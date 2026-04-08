<?php

if(! function_exists('prefixActive')){
	function prefixActive($prefixName)
	{
        return request()->routeIs($prefixName) ? 'active' : '';
	}
}
if (!function_exists('prefixBlock')) {
    function prefixBlock($routeName)
    {
        return    request()->routeIs($routeName) ? 'block' : 'none';
    }
}

if(! function_exists('routeActive')){
	function routeActive($routeName)
	{
		return	request()->routeIs($routeName) ? 'active' : '';
	}
}


