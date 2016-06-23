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
    
    static function getVideoReady( $_video_link )
    {
        //youtube video template
        $youtube_video_template = '<iframe class="embed-responsive-item" src="http://www.youtube.com/embed/%s" frameborder="0" allowfullscreen></iframe>';
    
        //vimeo video template
        $vimeo_video_template = '<iframe src="http://player.vimeo.com/video/%s?title=0&amp;byline=0&amp;portrait=0" class="embed-responsive-item" frameborder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>';
    
        //container
        $video = '';
    
        //is youtube video
        if(preg_match('/https:\/\/(www.)?youtube.com\/watch\?v=([a-zA-Z0-9_-]+[^&])/', $_video_link, $matches)){
            $video = sprintf($youtube_video_template, $matches[2]);
        }
    
        return $video;
    }
    
    static function formatPrice( $_price )
    {
        return number_format($_price, 2, '.', ' ');    
    }
    
    static function getOldOrModelValue($_name, $_model = '', $_model_name = '')
    {
    	if(empty($_model_name)){
    		$_model_name = $_name;
    	}
        $old = session()->get('_old_input');
        if(isset($old[$_name])){
            return $old[$_name];
        }
        
        if(!empty($_model) && isset($_model->$_model_name) && !empty($_model->$_model_name)){
            return $_model->$_model_name;
        }
    }
    
    static function br2nl($_text)
    {
        return str_replace('<br />', "\n", $_text);
    }
    
    static function nl2br($_text)
    {
        return str_replace("\r\n","<br />", $_text);
    }
}
