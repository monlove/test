<?php
return [
    'title' => "Rain OS APi接口文档",  //文档title
    'version'=>'1.0.0', //文档版本
    'copyright'=>'Powered By Rain', //版权信息
    'controller' => [
        //需要生成文档的类
        'app\\app\\controller\\AppApi',
        'app\\app\\controller\\UserApi'
    ],
    'filter_method' => [
        //过滤 不解析的方法名称
        '_empty'
    ],
    'return_format' => [
        //数据格式
        'code' => "0 (失败) / 1 (成功)",
        'msg' => "提示信息",
        'content' => "中文提示内容",
    ],
    'public_header' => [
        //全局公共头部参数
        //['name'=>'version', 'require'=>1, 'default'=>'', 'desc'=>'版本号(全局)']
    ],
    'public_param' => [
        //全局公共请求参数，设置了所以的接口会自动增加次参数
        //如：['name'=>'token', 'type'=>'string', 'require'=>1, 'default'=>'', 'other'=>'' ,'desc'=>'验证（全局）')']
    ],
];
