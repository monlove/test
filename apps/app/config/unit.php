<?php
    return [
        'unit' => [
            'minute'    => ['name'=>'minute','title'=>'分钟','time'=>60],
            'hour'      => ['name'=>'hour','title'=>'小时','time'=>3600],
            'day'       =>  ['name'=>'day','title'=>'天','time'=>3600*24], 
            'week'      => ['name'=>'week','title'=>'周','time'=>3600*24*7],
            'month'     => ['name'=>'month','title'=>'月','time'=>3600*24*30],
            'year'      => ['name'=>'year','title'=>'年','time'=>3600*24*365],            
            'unlimited' => ['name'=>'unlimited','title'=>'永久','time'=>'n/a'],
            'points'    => ['name'=>'points','title'=>'点','time'=>'points'],        
        ],
        'use_way' => [
            'free'  => ['name'=>'free','title'=>'免费'],
            'time'  => ['name'=>'time','title'=>'计时'],
            'points'=> ['name'=>'points','title'=>'扣点'],         
        ]        
    ];    