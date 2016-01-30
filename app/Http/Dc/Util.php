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
}
