<?php
	
	return [	
	    'tpl_replace_string'       => [
	        '__ROOT__'   =>  Request::instance()->root(),
            '__PUBLIC__' =>  Request::instance()->root() . '/public',           
            '__STATIC__' =>  Request::instance()->root() . '/public/static',
            '__PLUGS__'   =>  Request::instance()->root() . '/public/static/plugs',
            '__ONEUI__'  =>  Request::instance()->root() . '/public/static/oneui',
            '__CSS__' =>  Request::instance()->root() . '/public/static/admin/css',
            '__JS__' =>  Request::instance()->root() . '/public/static/admin/js',
        ],               
	];
