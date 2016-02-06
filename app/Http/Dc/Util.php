<?php

namespace App\Http\Dc;

class Util
{
    static function sanitize( $string )
    {
    	return addslashes(strip_tags(trim($string)));
    }
    
    static function buildUrl($_route_name, $_params = array())
    {
    	$params = array();
    	if(!empty($_params)){
    		foreach($_params as $k => $v){
    			$params[] = $k  . '/' . $v;
    		}
    	}
    	return route($_route_name) . '/' . join('/', $params);
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
}
