<?php    
/*
 * PHP QR Code encoder
 *
 * Exemplatory usage
 *
 * PHP QR Code is distributed under LGPL 3
 * Copyright (C) 2010 Dominik Dzienia <deltalab at poczta dot fm>
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA 02110-1301 USA
 */

class PhpQRCode{
    
	//processing form input
	//remember to sanitize user input in real-life solution !!!
	private $errorCorrectionLevel = 'H';		// L M Q H
	
	
	
	private $matrixPointSize = 3;				// 1 2 3 4 5 6 7 8 9 10
	
	
	private $date = 'shopnc';
	
	
	private $pngTempDir		= '';
	
	private $pngTempName    = '';
    
	/**
	 * 设置
	 */
	public function set($key,$value){
		$this->$key = $value;
	}
	
	public function __construct() {
	    include "qrlib.php";
	}
	
    public function init(){
	    //ofcourse we need rights to create temp dir
	    if (!file_exists($this->pngTempDir))
	        mkdir($this->pngTempDir);
	
	    if ($this->date != 'shopnc') { 
	            
	        // user data
	        if ($this->pngTempName != '') {
	            $filename = $this->pngTempDir.$this->pngTempName;
	        } else {
	           $filename = $this->pngTempDir.'test'.md5($this->date.'|'.$this->errorCorrectionLevel.'|'.$this->matrixPointSize).'.png';
	        }
	        QRcode::png($this->date, $filename, $this->errorCorrectionLevel, $this->matrixPointSize, 2);    
	        
	    } else {    
	    
	        //default data
	        QRcode::png('http://www.baidu.com', $filename, $this->errorCorrectionLevel, $this->matrixPointSize, 2);    
	        
	    }    
	        
	    //display generated file
	    return basename($filename);
	    
	    QRtools::timeBenchmark();    
	}
}