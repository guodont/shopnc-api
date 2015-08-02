<?php
/**
 * 缓存文件 
 *
 * @package    
 */
defined('InShopNC') or exit('Access Invalid!');

class NcFtp{
	const FTP_ERR_SERVER_DISABLED = -100;
	const FTP_ERR_CONFIG_OFF = -101;
	const FTP_ERR_CONNECT_TO_SERVER = -102;
	const FTP_ERR_USER_NO_LOGGIN = -103;
	const FTP_ERR_CHDIR = -104;
	const FTP_ERR_MKDIR = -105;
	const FTP_ERR_SOURCE_READ = -106;
	const FTP_ERR_TARGET_WRITE = -107;

	public $enabled = false;
	public $config = array();

	public $func;
	public $connectid;
	public $_error;

	public static function &instance($config = array()) {
		static $object;
		if(empty($object)) {
			$object = new NcFtp($config);
		}
		return $object;
	}

	public function __construct($config = array()) {
		$this->set_error(0);
		if (!($this->config = $config)){
			$this->config['on'] = C('ftp_open');
			$this->config['host'] = C('ftp_server');
			$this->config['ssl'] = C('ftp_ssl_state');
			$this->config['port'] = C('ftp_port');
			$this->config['username'] = C('ftp_username');
			$this->config['password'] = C('ftp_password');
			$this->config['pasv'] = C('ftp_pasv');
			$this->config['attachdir'] = C('ftp_attach_dir');
			$this->config['attachurl'] = C('ftp_access_url');
			$this->config['timeout'] = C('ftp_timeout');			
		}
		$this->enabled = false;
		if(empty($this->config['on']) || empty($this->config['host'])) {
			$this->set_error(self::FTP_ERR_CONFIG_OFF);
		} else {
			$this->func = $this->config['ssl'] && function_exists('ftp_ssl_connect') ? 'ftp_ssl_connect' : 'ftp_connect';
			if($this->func == 'ftp_connect' && !function_exists('ftp_connect')) {
				$this->set_error(self::FTP_ERR_SERVER_DISABLED);
			} else {
				$this->config['host'] = NcFtp::clear($this->config['host']);
				$this->config['port'] = intval($this->config['port']);
				$this->config['ssl'] = intval($this->config['ssl']);
				$this->config['host'] = NcFtp::clear($this->config['host']);
				$this->config['password'] = $this->config['password'];
				$this->config['timeout'] = intval($this->config['timeout']);
				$this->enabled = true;
			}
		}
	}

	public function upload($source, $target) {
		if($this->error()) {
			return 0;
		}

		$old_dir = $this->ftp_pwd();
		$dirname = dirname($target);
		$filename = basename($target);
		if(!$this->ftp_chdir($dirname)) {
			if($this->ftp_mkdir($dirname)) {
				$this->ftp_chmod($dirname);
				if(!$this->ftp_chdir($dirname)) {
					$this->set_error(self::FTP_ERR_CHDIR);
				}
				$this->ftp_put('index.html', BASE_PATH.'/upload/index.html', FTP_BINARY);
			} else {
				$this->set_error(self::FTP_ERR_MKDIR);
			}
		}

		$res = 0;
		if(!$this->error()) {
			if($fp = @fopen($source, 'rb')) {
				$res = $this->ftp_fput($filename, $fp, FTP_BINARY);
				@fclose($fp);
				!$res && $this->set_error(self::FTP_ERR_TARGET_WRITE);
			} else {
				$this->set_error(self::FTP_ERR_SOURCE_READ);
			}
		}

		$this->ftp_chdir($old_dir);

		return $res ? 1 : 0;
	}

	public function connect() {
		if(!$this->enabled || empty($this->config)) {
			return 0;
		} else {
			return $this->ftp_connect(
				$this->config['host'],
				$this->config['username'],
				$this->config['password'],
				$this->config['attachdir'],
				$this->config['port'],
				$this->config['timeout'],
				$this->config['ssl'],
				$this->config['pasv']
				);
		}

	}

	public function ftp_connect($ftphost, $username, $password, $ftppath, $ftpport = 21, $timeout = 30, $ftpssl = 0, $ftppasv = 0) {
		$res = 0;
		$fun = $this->func;
		if($this->connectid = $fun($ftphost, $ftpport, 20)) {

			$timeout && $this->set_option(FTP_TIMEOUT_SEC, $timeout);
			if($this->ftp_login($username, $password)) {
				$this->ftp_pasv($ftppasv);
				if($this->ftp_chdir($ftppath)) {
					$res =  $this->connectid;
				} else {
					$this->set_error(self::FTP_ERR_CHDIR);
				}
			} else {
				$this->set_error(self::FTP_ERR_USER_NO_LOGGIN);
			}

		} else {
			$this->set_error(self::FTP_ERR_CONNECT_TO_SERVER);
		}

		if($res > 0) {
			$this->set_error();
			$this->enabled = 1;
		} else {
			$this->enabled = 0;
			$this->ftp_close();
		}

		return $res;

	}

	public function set_error($code = 0) {
		$this->_error = $code;
	}

	public function error() {
		return $this->_error;
	}

	public function clear($str) {
		return str_replace(array( "\n", "\r", '..'), '', $str);
	}


	public function set_option($cmd, $value) {
		if(function_exists('ftp_set_option')) {
			return @ftp_set_option($this->connectid, $cmd, $value);
		}
	}

	public function ftp_mkdir($directory) {
		$directory = NcFtp::clear($directory);
		$epath = explode('/', $directory);
		$dir = '';$comma = '';
		foreach($epath as $path) {
			$dir .= $comma.$path;
			$comma = '/';
			$return = @ftp_mkdir($this->connectid, $dir);
			$this->ftp_chmod($dir);
		}
		return $return;
	}

	public function ftp_rmdir($directory) {
		$directory = NcFtp::clear($directory);
		return @ftp_rmdir($this->connectid, $directory);
	}

	public function ftp_put($remote_file, $local_file, $mode = FTP_BINARY) {
		$remote_file = NcFtp::clear($remote_file);
		$local_file = NcFtp::clear($local_file);
		$mode = intval($mode);
		return @ftp_put($this->connectid, $remote_file, $local_file, $mode);
	}

	public function ftp_fput($remote_file, $sourcefp, $mode = FTP_BINARY) {
		$remote_file = NcFtp::clear($remote_file);
		$mode = intval($mode);
		return @ftp_fput($this->connectid, $remote_file, $sourcefp, $mode);
	}

	public function ftp_size($remote_file) {
		$remote_file = NcFtp::clear($remote_file);
		return @ftp_size($this->connectid, $remote_file);
	}

	public function ftp_close() {
		return @ftp_close($this->connectid);
	}

	public function ftp_delete($path) {
		$path = NcFtp::clear($path);
		return @ftp_delete($this->connectid, $path);
	}

	public function ftp_get($local_file, $remote_file, $mode, $resumepos = 0) {
		$remote_file = NcFtp::clear($remote_file);
		$local_file = NcFtp::clear($local_file);
		$mode = intval($mode);
		$resumepos = intval($resumepos);
		return @ftp_get($this->connectid, $local_file, $remote_file, $mode, $resumepos);
	}

	public function ftp_login($username, $password) {
		$username = $this->clear($username);
		$password = str_replace(array("\n", "\r"), array('', ''), $password);
		return @ftp_login($this->connectid, $username, $password);
	}

	public function ftp_pasv($pasv) {
		return @ftp_pasv($this->connectid, $pasv ? true : false);
	}

	public function ftp_chdir($directory) {
		$directory = NcFtp::clear($directory);
		return @ftp_chdir($this->connectid, $directory);
	}

	public function ftp_site($cmd) {
		$cmd = NcFtp::clear($cmd);
		return @ftp_site($this->connectid, $cmd);
	}

	public function ftp_chmod($filename, $mod = 0777) {
		$filename = NcFtp::clear($filename);
		if(function_exists('ftp_chmod')) {
			return @ftp_chmod($this->connectid, $mod, $filename);
		} else {
			return @ftp_site($this->connectid, 'CHMOD '.$mod.' '.$filename);
		}
	}

	public function ftp_pwd() {
		return @ftp_pwd($this->connectid);
	}

}
?>