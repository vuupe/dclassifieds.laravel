<?php

namespace App\Http\Middleware;

use Closure;

class SegmentFixMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
    	//get route static prefix
    	$r = $request->route()->getCompiled();
    	$sp = ltrim($r->getStaticPrefix(), '/');
    	$sp_array = explode('/', $sp);
    	
    	//get controller/action
    	$action_name_raw = $request->route()->getActionName();
    	
    	$action_name = '';
    	$action_name_array = array();
    	
    	if(!empty($action_name_raw)){
    		$action_name_array = explode('@', $action_name_raw);
    	}
    	
    	if(isset($action_name_array[1]) && !empty($action_name_array)){
    		$action_name = $action_name_array[1];
    	}
    	
    	//get url segments and inject them in $_GET params
    	$url_segments = $request->segments();
    	
    	if(!empty($url_segments) && is_array($url_segments)){
    		
    		//remove route static prefix from segments
			foreach ($sp_array as $k => $v){
				$action_name_index = array_search($v, $url_segments);
				if($action_name_index !== FALSE){
					unset($url_segments[$action_name_index]);
				}	
			}
			
    		//count segments
    		$segment_count = count($url_segments);
    		if($segment_count > 1){
    			$url_segments = array_values($url_segments);
	    		for($i = 0; $i < $segment_count; $i+=2){
	    			if(!$request->has($url_segments[$i])){
	    				$request->query->set($url_segments[$i], $url_segments[$i+1]);
	    			}
	    		}
    		}
    	}
    	
    	return $next($request);
    }
}
