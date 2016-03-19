<?php

namespace App\Http\Dc;

class Util
{
    static function sanitize( $string )
    {
    	return addslashes(strip_tags(trim($string)));
    }
    
    static function buildUrlByRouteName($_route_name, $_params = array())
    {
    	$params = array();
    	if(!empty($_params)){
    		foreach($_params as $k => $v){
    			$params[] = $k  . '/' . $v;
    		}
    	}
    	return route($_route_name) . '/' . join('/', $params);
    }
    
    static function buildUrl($_url_params = array(), $_divider = '/')
    {
    	$root = request()->root();
    	return $root . $_divider . join($_divider, $_url_params);
    }
    
    static function getQueryStringFromArray($_params = array(), $_remove_zero = 1)
    {
    	$ret = array();
    	foreach ($_params as $k => $v){
    		if(!$_remove_zero){
    			$ret[] = $k . '=' . $v;
    		} elseif ($v > 0) {
    			$ret[] = $k . '=' . $v;
    		}
    	}
    	if(!empty($ret)){
    		return join('&', $ret);
    	} else {
    		return '';
    	}
    }
    
    static function getRemoteAddress()
    {
        $ret = '';
    
        if(isset($_SERVER['HTTP_CF_CONNECTING_IP']) && !empty($_SERVER['HTTP_CF_CONNECTING_IP'])){
            return $_SERVER['HTTP_CF_CONNECTING_IP'];
        }
    
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && !empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    
        if(isset($_SERVER['REMOTE_ADDR']) && !empty($_SERVER['REMOTE_ADDR'])){
            return $_SERVER['REMOTE_ADDR'];
        }
    
        return $ret;
    }
}
