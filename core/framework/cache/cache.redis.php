<?php
/**
 * redis 操作
 */

defined('InShopNC') or exit('Access Invalid!');

class CacheRedis extends Cache {
	private $config;
	private $connected;
	private $type;
	private $prefix;
    public function __construct() {
    	$this->config = C('redis');
    	if (empty($this->config['slave'])) $this->config['slave'] = $this->config['master'];
    	$this->prefix = $this->config['prefix'] ? $this->config['prefix'] : substr(md5($_SERVER['HTTP_HOST']), 0, 6).'_';
        if ( !extension_loaded('redis') ) {
            throw_exception('redis failed to load');
        }
    }

    private function init_master(){
    	static $_cache;
    	if (isset($_cache)){
    		$this->handler = $_cache;
    	}else{
	        $func = $this->config['pconnect'] ? 'pconnect' : 'connect';
	        $this->handler  = new Redis;
	        $this->enable = $this->handler->$func($this->config['master']['host'], $this->config['master']['port']);
	        $_cache = $this->handler;
            //$_cache->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
    	}
    }

    private function init_slave(){
    	static $_cache;
    	if (isset($_cache)){
    		$this->handler = $_cache;
    	}else{
	        $func = $this->config['pconnect'] ? 'pconnect' : 'connect';
	        $this->handler = new Redis;
	        $this->enable = $this->handler->$func($this->config['slave']['host'], $this->config['slave']['port']);
	        $_cache = $this->handler;
            //$_cache->setOption(Redis::OPT_SERIALIZER, Redis::SERIALIZER_PHP);
    	}
    }

    private function isConnected() {
    	$this->init_master();
        return $this->enable;
    }

	public function get($key, $type = ''){
		$this->init_slave();
		if (!$this->enable) return false;
		$this->type = $type;
		$value = $this->handler->get($this->_key($key));

        return unserialize($value);
	}

    public function set($key, $value, $prefix = '', $expire = null) {
    	$this->init_master();
    	if (!$this->enable) return false;
    	$this->type = $prefix;

        $value = serialize($value);

        if(is_int($expire)) {
            $result = $this->handler->setex($this->_key($key), $expire, $value);
        }else{
            $result = $this->handler->set($this->_key($key), $value);
        }
        return $result;
    }

    public function hset($name, $prefix, $data) {
        $this->init_master();
        if (!$this->enable || !is_array($data) || empty($data)) return false;
        $this->type = $prefix;
        foreach ($data as $key => $value) {
            if ($value[0] == 'exp') {
                $value[1] = str_replace(' ', '', $value[1]);
                preg_match('/^[A-Za-z_]+([+-]\d+(\.\d+)?)$/',$value[1],$matches);
                if (is_numeric($matches[1])) {
                    $this->hIncrBy($name, $prefix, $key, $matches[1]);
                }
                unset($data[$key]);
            }
        }
        if (count($data) == 1) {
            $this->handler->hset($this->_key($name), key($data),current($data));
        } elseif (count($data) > 1) {
            $this->handler->hMset($this->_key($name), $data);
        }
    }

    public function hget($name, $prefix, $key = null) {
        $this->init_slave();
        if (!$this->enable) return false;
        $this->type = $prefix;
        if ($key == '*' || is_null($key)) {
            return $this->handler->hGetAll($this->_key($name));
        } elseif (strpos($key,',') != false) {
            return $this->handler->hmGet($this->_key($name), explode(',',$key));
        } else {
            return $this->handler->hget($this->_key($name), $key);
        }
    }

    public function hdel($name, $prefix, $key = null) {
        $this->init_master();
        if (!$this->enable) return false;
        $this->type = $prefix;
        if (is_null($key)) {
            if (is_array($name)) {
                return $this->handler->delete(array_walk($array,array(self,'_key')));
            } else {
                return $this->handler->delete($this->_key($name));
            }
        } else {
            if (is_array($name)) {
                foreach ($name as $key => $value) {
                    $this->handler->hdel($this->_key($name), $key);
                }
                return true;
            } else {
                return $this->handler->hdel($this->_key($name), $key);
            }
        }
    }

    public function hIncrBy($name, $prefix, $key, $num = 1) {
        if ($this->hget($name, $prefix,$key) !== false) {
            $this->handler->hIncrByFloat($this->_key($name), $key, floatval($num));
        }
    }

    public function rm($key, $type = '') {
    	$this->init_master();
    	if (!$this->enable) return false;
    	$this->type = $type;
        return $this->handler->delete($this->_key($key));
    }

    public function clear() {
    	$this->init_master();
    	if (!$this->enable) return false;
        return $this->handler->flushDB();
    }

	private function _key($str) {
		return $this->prefix.$this->type.$str;
	}
}