<?php
	
	return [	
	    'tpl_replace_string'       => [
	        '__ROOT__'   =>  request::instance()->root(),
            '__PUBLIC__' =>  request::instance()->root() . '/public',           
            '__STATIC__' =>  request::instance()->root() . '/public/static',
            '__PLUGS__'   =>  request::instance()->root() . '/public/static/plugs',
            '__ONEUI__'  =>  request::instance()->root() . '/public/static/oneui',
            '__CSS__' =>  request::instance()->root() . '/public/static/admin/css',
        ],               
	];
