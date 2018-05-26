<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件


/**
 * 检测用户是否登录
 * @return integer 0-未登录，大于0-当前登录用户ID
 * @author Rain <80692285@qq.com>
 */
function is_login(){
	if(cookie('user_auth')){
		session('user_auth',cookie('user_auth'));
	}
    $user = session('user_auth');
	
    if (empty($user)) {
        return FALSE;
    } else {
        return session('user_auth.user_id');
    }
}
/**
 * 检测当前用户是否为管理员
 * @return boolean true-管理员，false-非管理员
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function is_admin($uid = null){
	
    $uid = is_null($uid) ? is_login() : $uid;
    return $uid && (intval($uid) === config('sys_config.user_admin'));
}
/**
 * 写日志
 * @param array ['type'=>$type,'user_id'=>$user_id,'other'=>$other,'comment'=>$comment];
 * 
 */
 function in_log($data){
 	$request = \Request::instance();
	$rest_arr = getAgentInfo();
	$data['url'] = $request->module().'/'.$request->controller().'/'.$request->action();
	$data['client_ip'] = $request->ip();
    $data['client_browser'] = $rest_arr['bro'];
	$data['client_sys'] = $rest_arr['sys'];
 	$inlog = new \app\common\model\Logs($data);	
    $rest = $inlog->save();
	return $rest;
 }
/**
 * 数据签名认证
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author Rain <80692285@qq.com>
 */
function data_auth_sign($data) {
    //数据类型检测
    if(!is_array($data)){
        $data = (array)$data;
    }
    ksort($data); //排序
    $code = http_build_query($data); //url编码并生成query字符串
    $sign = sha1($code); //生成签名
    return $sign;
}
/**
 * API数据返回数组
 * @param  array  $data 被认证的数据
 * @return string       签名
 * @author Rain <80692285@qq.com>
 */
function restApi($code = 444, $content='未定义信息',$data=''){
	if($code > 1){
		return ['code'=>$code,'msg'=>$content];
	}
	return ['code'=>1,'msg'=>$content,'data' => $data];
}
function jsonApi($code = 44444, $content='未定义信息',$data=''){
	if($code > 1){
		return json_encode(['code'=>$code,'msg'=>$content]);
	}
	return json_encode(['code'=>1,'msg'=>$content,'data' => $data]);
}	
function appApi($code = 0, $content='未定义信息',$data=[]){
	if($code == 0){
		return json_encode(['code'=>$code,'msg'=>'error','content'=>$content]);
	}
	return json_encode(['code'=>1,'msg'=>'success','content'=>$content,'data' => $data]);
}
function jsonCode($code=0,$msg='error',$data=''){
	if($code == 0){
		return json(['code'=>$code,'msg'=>$msg]);
	}
	return json(['code'=>$code,'msg'=>'success','data'=>$data]);
}
function jsonpCode($code=0,$msg='error',$data=''){
	if($code == 0){
		return jsonp(['code'=>$code,'msg'=>$msg])
        ->options([
            'var_jsonp_handler'     => 'callback',
            'default_jsonp_handler' => 'jsonpReturn',
            'json_encode_param'     => JSON_PRETTY_PRINT,
        ]);
		
	}
	return jsonp(['code'=>$code,'msg'=>'success','data'=>$data])
	->options([
        'var_jsonp_handler'     => 'callback',
        'default_jsonp_handler' => 'jsonpReturn',
        'json_encode_param'     => JSON_PRETTY_PRINT,
    ]);
}
function xmlCode($code=0,$msg='error',$data=''){
	if($code == 0){
		return xml(['code'=>$code,'msg'=>$msg]);
	}
	return xml(['code'=>$code,'msg'=>'success','data'=>$data]);
}
//IP取城市地址
function ipGetAddress($ip='127.0.0.1'){
	$IpLocation = new \org\IpLocation(); // 实例化类 参数表示IP地址库文件
    $area = $IpLocation->getlocation($ip); // 获取某个IP地址所在的位置
    $str=$area['country'].$area['area']; //合并位置    
    $str=iconv("GB2312", "UTF-8",$str); //因为最新版为GBK 转为UTF8
    return $str;  //输出地址
}
/**
* 对查询结果集进行排序
* @access public
* @param array $list 查询结果
* @param string $field 排序的字段名
* @param array $sortby 排序类型
* asc正向排序 desc逆向排序 nat自然排序
* @return array
*/
function list_sort_by($list,$field, $sortby='asc') {
   if(is_array($list)){
       $refer = $resultSet = array();
       foreach ($list as $i => $data)
           $refer[$i] = &$data[$field];
       switch ($sortby) {
           case 'asc': // 正向排序
                asort($refer);
                break;
           case 'desc':// 逆向排序
                arsort($refer);
                break;
           case 'nat': // 自然排序
                natcasesort($refer);
                break;
       }
       foreach ( $refer as $key=> $val)
           $resultSet[] = &$list[$key];
       return $resultSet;
   }
   return false;
}

/**
 * 把返回的数据集转换成树
 * @param array $list 要转换的数据集
 * @param string $pid parent标记字段
 * @param string $level level标记字段
 * @return array
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function list_to_tree($list, $pk='id', $pid = 'pid', $child = '_child', $root = 0) {
    // 创建Tree
    $tree = array();
    if(is_array($list)) {
        // 创建基于主键的数组引用
        $refer = array();
        foreach ($list as $key => $data) {
            $refer[$data[$pk]] =& $list[$key];
        }
        foreach ($list as $key => $data) {
            // 判断是否存在parent
            $parentId =  $data[$pid];
            if ($root == $parentId) {
                $tree[] =& $list[$key];
            }else{
                if (isset($refer[$parentId])) {
                    $parent =& $refer[$parentId];
                    $parent[$child][] =& $list[$key];
                }
            }
        }
    }
    return $tree;
}


/**
 * 将list_to_tree的树还原成列表
 * @param  array $tree  原来的树
 * @param  string $child 孩子节点的键
 * @param  string $order 排序显示的键，一般是主键 升序排列
 * @param  array  $list  过渡用的中间数组，
 * @return array        返回排过序的列表数组
 * @author yangweijie <yangweijiester@gmail.com>
 */
function tree_to_list($tree, $child = '_child', $order='id', &$list = array()){
    if(is_array($tree)) {
        $refer = array();
        foreach ($tree as $key => $value) {
            $reffer = $value;
            if(isset($reffer[$child])){
                unset($reffer[$child]);
                tree_to_list($value[$child], $child, $order, $list);
            }
            $list[] = $reffer;
        }
        $list = list_sort_by($list, $order, $sortby='asc');
    }
    return $list;
}

/**
 * 格式化字节大小
 * @param  number $size      字节数
 * @param  string $delimiter 数字和单位分隔符
 * @return string            格式化后的带单位的大小
 * @author 麦当苗儿 <zuojiazi@vip.qq.com>
 */
function format_bytes($size, $delimiter = '') {
    $units = array('B', 'KB', 'MB', 'GB', 'TB', 'PB');
    for ($i = 0; $size >= 1024 && $i < 5; $i++) $size /= 1024;
    return round($size, 2) . $delimiter . $units[$i];
}
 	
//菜单排序
function menuSort($menus){
	$sort = ['direction' => 'SORT_ASC','field' => 'order',];
	$arrSort = [];  
	foreach($menus AS $uniqid => $row){
        foreach($row AS $key=>$value){
            $arrSort[$key][$uniqid] = $value;
        }
    }
	if($sort['direction']){
        array_multisort($arrSort[$sort['field']], constant($sort['direction']), $menus);
    }
	//	排序结束
    return $menus;
}

//递归分类排列
function sortOut($cate, $parent_id = 0, $level = 0, $html = '&nbsp;&nbsp;&nbsp;&nbsp;') {
	$tree = array();
    foreach($cate as $v){
    	if($v['parent_id']){
    		$v['name']=  '├&nbsp;'.$v['name'] ;
    	}
    	            	
        if($v['parent_id'] == $parent_id){
            $v['level'] = $level + 1;
            $v['name'] = str_repeat($html, $level).$v['name'];
            $tree[] = $v;
            $tree = array_merge($tree, sortOut($cate,$v['id'],$level+1,$html));
        }
    }
    return $tree;	   
}
//递归分类排列
function sortOutx($cate, $parent_id = 0, $level = 0, $html = '&nbsp;&nbsp;&nbsp;&nbsp;') {
	$tree = array();
    foreach($cate as $v){
    	if($v['parent_id']){
    		$v['name']=  '——&nbsp;'.$v['name'] ;
    	}
    	            	
        if($v['parent_id'] == $parent_id){
            $v['level'] = $level + 1;
            $v['name'] = str_repeat($html, $level).$v['name'];
            $tree[] = $v;
            $tree = array_merge($tree, sortOut($cate,$v['id'],$level+1,$html));
        }
    }
    return $tree;	   
}
//递归分类排列
function sortNode($cate, $parent_id = 0, $level = 0, $html = '&nbsp&nbsp&nbsp&nbsp') {
	$tree = array();
    foreach($cate as $v){               	
        if($v['parent_id'] == $parent_id){
            $v['level'] = $level + 1;			
			if($v['parent_id']){
				$v['title'] = str_repeat($html, $level).'├&nbsp&nbsp'.$v['title'];
			}else{
				$v['title'] = str_repeat($html, $level).$v['title'];
			}
            
            $tree[] = $v;
            $tree = array_merge($tree, sortNode($cate,$v['id'],$level+1,$html));
        }
    }
    return $tree;
	   
}
//递归分类排列
function sortDir($cate, $parent_id = 0, $level = 0, $html = '— ') {//递归分类排列
	$tree = array();
    foreach($cate as $v){               	
        if($v['parent_id'] == $parent_id){
            $v['level'] = $level + 1;
            $v['name'] = str_repeat($html, $level).$v['name'];
            $tree[] = $v;
            $tree = array_merge($tree, sortDir($cate,$v['id'],$level+1,$html));
        }
    }
    return $tree;
	   
}
/**
 * 取得根域名
 * @param type $domain 域名
 * @return string 返回根域名
 */
function get_domain($domain) {
    $re_domain = '';
	$domain = str_replace('http://','',$domain);
    $domain_postfix_cn_array = array("com", "net", "org", "gov", "edu", "com.cn", "cn","net.cn","la","top","cc","vip");
    $array_domain = explode(".", $domain);
    $array_num = count($array_domain) - 1;
    if ($array_domain[$array_num] == 'cn') {
        if (in_array($array_domain[$array_num - 1], $domain_postfix_cn_array)) {
            $re_domain = $array_domain[$array_num - 2] . "." . $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
        } else {
            $re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
        }
    } else {
        $re_domain = $array_domain[$array_num - 1] . "." . $array_domain[$array_num];
    }
	
    return $re_domain;
}

/**
 * 简单对称加密算法之加密
 * @param String $string 需要加密的字串
 * @param String $skey 加密EKY
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
function encode($string = '', $skey = 'rain') {
    $strArr = str_split(base64_encode($string));
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key < $strCount && $strArr[$key].=$value;
    return str_replace(array('=', '+', '/'), array('O0O0O', 'o000o', 'oo00o'), join('', $strArr));
}
/**
 * 简单对称加密算法之解密
 * @param String $string 需要解密的字串
 * @param String $skey 解密KEY
 * @author Anyon Zou <zoujingli@qq.com>
 * @date 2013-08-13 19:30
 * @update 2014-10-10 10:10
 * @return String
 */
function decode($string = '', $skey = 'rain') {
    $strArr = str_split(str_replace(array('O0O0O', 'o000o', 'oo00o'), array('=', '+', '/'), $string), 2);
    $strCount = count($strArr);
    foreach (str_split($skey) as $key => $value)
        $key <= $strCount  && isset($strArr[$key]) && $strArr[$key][1] === $value && $strArr[$key] = $strArr[$key][0];
    return base64_decode(join('', $strArr));
}
//加密函数
function rain_encrypt($txt, $key) {
	srand((double)microtime() * 1000000);
	$encrypt_key = md5(rand(0, 32000));
	$ctr = 0;
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
	   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
	   $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
	}
	return base64_encode(passport_key($tmp, $key));
}
//解密函数
function rain_decrypt($txt, $key) {
	$txt = passport_key(base64_decode($txt), $key);
	$tmp = '';
	for($i = 0;$i < strlen($txt); $i++) {
	   $md5 = $txt[$i];
	   $tmp .= $txt[++$i] ^ $md5;
	}
	return $tmp;
}

function passport_key($txt, $encrypt_key) {
	$encrypt_key = md5($encrypt_key);
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen($txt); $i++) {
	   $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
	   $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
	}
	return $tmp;
}

/**
 * $string 明文或密文
 * $operation 加密ENCODE或解密DECODE
 * $key 密钥
 * $expiry 密钥有效期
 */ 
function authcode($string, $operation = 'DECODE', $key = '', $expiry = 0) {
    // 动态密匙长度，相同的明文会生成不同密文就是依靠动态密匙
    // 加入随机密钥，可以令密文无任何规律，即便是原文和密钥完全相同，加密结果也会每次不同，增大破解难度。
    // 取值越大，密文变动规律越大，密文变化 = 16 的 $ckey_length 次方
    // 当此值为 0 时，则不产生随机密钥
    $ckey_length = 4;
    // 密匙
    // $GLOBALS['discuz_auth_key'] 这里可以根据自己的需要修改
    $key = md5($key ? $key : $GLOBALS['rain_auth_key']); 
 
    // 密匙a会参与加解密
    $keya = md5(substr($key, 0, 16));
    // 密匙b会用来做数据完整性验证
    $keyb = md5(substr($key, 16, 16));
    // 密匙c用于变化生成的密文
    $keyc = $ckey_length ? ($operation == 'DECODE' ? substr($string, 0, $ckey_length): substr(md5(microtime()), -$ckey_length)) : '';
    // 参与运算的密匙
    $cryptkey = $keya.md5($keya.$keyc);
    $key_length = strlen($cryptkey);
    // 明文，前10位用来保存时间戳，解密时验证数据有效性，10到26位用来保存$keyb(密匙b)，解密时会通过这个密匙验证数据完整性
    // 如果是解码的话，会从第$ckey_length位开始，因为密文前$ckey_length位保存 动态密匙，以保证解密正确
    $string = $operation == 'DECODE' ? base64_decode(substr($string, $ckey_length)) : sprintf('%010d', $expiry ? $expiry + time() : 0).substr(md5($string.$keyb), 0, 16).$string;
    $string_length = strlen($string);
    $result = '';
    $box = range(0, 255);
    $rndkey = array();
    // 产生密匙簿
    for($i = 0; $i <= 255; $i++) {
        $rndkey[$i] = ord($cryptkey[$i % $key_length]);
    }
    // 用固定的算法，打乱密匙簿，增加随机性，好像很复杂，实际上并不会增加密文的强度
    for($j = $i = 0; $i < 256; $i++) {
        $j = ($j + $box[$i] + $rndkey[$i]) % 256;
        $tmp = $box[$i];
        $box[$i] = $box[$j];
        $box[$j] = $tmp;
    }
    // 核心加解密部分
    for($a = $j = $i = 0; $i < $string_length; $i++) {
        $a = ($a + 1) % 256;
        $j = ($j + $box[$a]) % 256;
        $tmp = $box[$a];
        $box[$a] = $box[$j];
        $box[$j] = $tmp;
        // 从密匙簿得出密匙进行异或，再转成字符
        $result .= chr(ord($string[$i]) ^ ($box[($box[$a] + $box[$j]) % 256]));
    }
    if($operation == 'DECODE') {
        // substr($result, 0, 10) == 0 验证数据有效性
        // substr($result, 0, 10) - time() > 0 验证数据有效性
        // substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16) 验证数据完整性
        // 验证数据有效性，请看未加密明文的格式
        if((substr($result, 0, 10) == 0 || substr($result, 0, 10) - time() > 0) && substr($result, 10, 16) == substr(md5(substr($result, 26).$keyb), 0, 16)) {
            return substr($result, 26);
        } else {
            return '';
        }
    } else {
        // 把动态密匙保存在密文里，这也是为什么同样的明文，生产不同密文后能解密的原因
        // 因为加密后的密文可能是一些特殊字符，复制过程可能会丢失，所以用base64编码
        return $keyc.str_replace('=', '', base64_encode($result));
    }
}

function baseAuth($string, $operation = 'DECODE', $key = '', $expiry = 0){
	if($operation === 'DECODE'){
		$string = base64_decode($string);
		$rest   = authcode($string, $operation = 'DECODE', $key);
		return $rest;
	}else{
		$rest = authcode($string, $operation = 'ENCODE', $key, $expiry);
		return base64_encode($rest);
		
	}
	
}

//生成授权码
function makeauthcode($len=16, $num=1,$appid,$bind) {
	$sNumArr=range(0,9);
    $sArr=array_merge($sNumArr,range('a','z'));
    $cards=array();
    for($x=0;$x< $num;$x++){       
        $tempStr=array();
        for($i=0;$i< $len;$i++){
            $tempStr[]=$sArr[array_rand($sArr)];
        }
        $cards[$x]['acard_number']=implode('',$tempStr);
		$cards[$x]['appid']=$appid;
		$cards[$x]['bind']=$bind;
		$cards[$x]['create_time']=time();
    }
//array_unique($cards);
    return $cards;
}


function corder() {//生成订单号
	return date('Ymd').substr(implode(NULL,array_map('ord',str_split( substr(uniqid(), 7, 13) , 1))), 0, 8) ;
	}

//模块是否存在
function checkmodul($name){
	if (file_exists(APP_PATH .$name)) {
		return TRUE;
	}else{
		return FALSE;
	}
}



function createkey($len=32, $num=1) {
	$sNumArr=range(0,9);
    $sArr=array_merge($sNumArr,range('a','z'));
    $cards=array();
    $tempStr=array();
    for($i=0;$i< $len;$i++){
        $tempStr[]=$sArr[array_rand($sArr)];
    }
        $cards=strtoupper(implode('',$tempStr));
		
   
//array_unique($cards);
    return $cards;
} 
/**
 * 发送HTTP请求方法
 * @param  string $url    请求URL
 * @param  array  $params 请求参数
 * @param  string $method 请求方法GET/POST
 * @return array  $data   响应数据
 */
function chttp($url, $params, $method = 'GET', $header = array(), $multi = false){
    $opts = array(
            CURLOPT_TIMEOUT        => 30,
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_SSL_VERIFYPEER => false,
            CURLOPT_SSL_VERIFYHOST => false,
            CURLOPT_HTTPHEADER     => $header
    );

    /* 根据请求类型设置特定参数 */
    switch(strtoupper($method)){
        case 'GET':
            $opts[CURLOPT_URL] = $url . '?' . http_build_query($params);
            break;
        case 'POST':
            //判断是否传输文件
            $params = $multi ? $params : http_build_query($params);
            $opts[CURLOPT_URL] = $url;
            $opts[CURLOPT_POST] = 1;
            $opts[CURLOPT_POSTFIELDS] = $params;
            break;
        default:
            'method_error';
    }

    /* 初始化并执行curl请求 */
    $ch = curl_init();
    curl_setopt_array($ch, $opts);
    $data  = curl_exec($ch);
    $error = curl_error($ch);
    curl_close($ch);
    if($error) $error;
    return  $data;
} 


/**
 * 数组 转 对象
 *
 * @param array $arr 数组
 * @return object
 */
function array_to_object($arr) {
    if (gettype($arr) != 'array') {
        return;
    }
    foreach ($arr as $k => $v) {
        if (gettype($v) == 'array' || getType($v) == 'object') {
            $arr[$k] = (object)array_to_object($v);
        }
    }
 
    return (object)$arr;
}
 
/**
 * 对象 转 数组
 *
 * @param object $obj 对象
 * @return array
 */
function object_to_array($obj) {
    $obj = (array)$obj;
    foreach ($obj as $k => $v) {
        if (gettype($v) == 'resource') {
            return;
        }
        if (gettype($v) == 'object' || gettype($v) == 'array') {
            $obj[$k] = (array)object_to_array($v);
        }
    }
 
    return $obj;
}


function timeTodate($time,$options = 'on'){
	if($time < 1){
		return '0000-00-00 00:00:00';
	}
	if($options === 'on'){
		return date('Y-m-d H:i:s', $time);
	}
	if($options === 'day'){
		return date('Y-m-d', $time);
	}
	if($options === 'month'){
		return date('Y-m', $time);
	}	
	return date('Ymd-His', $time);	
}

function dateTimeAn($value,$option ='date'){
	if($option=='date'){
		return date("H:i:s",$value);
	}
	return strtotime($value);
}

//取目录下所有目录名
function dirnames($dir_name){
	//抑制错误信息显示  便于自定义错误显示
	$dir_handle=opendir($dir_name);
	$dirarr=[];
	if (!$dir_handle) {
		die("目录打开错误！");
	}
	//文件名为'0'时，readdir返回FALSE，判断返回值是否不全等
	while (($file = readdir($dir_handle)) !== false) {
		if ($file!='.' && $file!='..' && $file!='.svn') {
            //echo "filename: $file : filetype: " . filetype($dir_name . $file) . "\n";
            if(filetype($dir_name . $file)=='dir'){
            	$dirarr[]=$file;
            }
            
		}	
    } 
		closedir($dir_handle);//关闭目录句柄
	return $dirarr;
}

function apiArray($code = 1,$message='success',$content='',$data=''){
	if($date == null){
		return ['code'=>$code,'message'=>$message,'msg'=>$content];
	}
	return ['code'=>$code,'message'=>$message,'data'=>$data,'msg'=>$content];
}

function is_json($str){  
    return is_null(json_decode($str));
}

/**
 * 系统邮件发送函数
 * @param string $tomail 接收邮件者邮箱
 * @param string $name 接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body 邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 * @author static7 <static7@qq.com>
 */
function send_mail($tomail, $name, $subject = '', $body = '', $attachment = null) {
    $mail = new \PHPMailer();           //实例化PHPMailer对象
    $mail->CharSet = 'UTF-8';           //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
    $mail->IsSMTP();                    // 设定使用SMTP服务
    $mail->SMTPDebug = 1;               // SMTP调试功能 0=关闭 1 = 错误和消息 2 = 消息
    $mail->SMTPAuth = true;             // 启用 SMTP 验证功能
    $mail->SMTPSecure = 'ssl';          // 使用安全协议
    $mail->Host = config('email.host'); // SMTP 服务器
    $mail->Port = config('email.port');             // SMTP服务器的端口号
    $mail->Username = config('email.username');    // SMTP服务器用户名
    $mail->Password = config('email.password');     // SMTP服务器密码
    $mail->SetFrom(config('email.replyemali'), config('email.replyuser'));
    $replyEmail = config('email.replyemali');                   //留空则为发件人EMAIL
    $replyName = config('email.replyuser');                    //回复名称（留空则为发件人名称）
    $mail->AddReplyTo($replyEmail, $replyName);
    $mail->Subject = $subject;
    $mail->MsgHTML($body);
    $mail->AddAddress($tomail, $name);
    if (is_array($attachment)) { // 添加附件
        foreach ($attachment as $file) {
            is_file($file) && $mail->AddAttachment($file);
        }
    }
    return $mail->Send() ? true : $mail->ErrorInfo;
}
//转换为时分秒00：00：00
function timeTotype($seconds){
    if ($seconds > 3600){
        $hours = intval($seconds/3600);
        $minutes = $seconds % 3600;
        $time = $hours.":".gmstrftime('%M:%S', $minutes);
    }else{
        $time = gmstrftime('%H:%M:%S', $seconds);
    }
    return $time;
}

function curl_get_contents($url,$data = array(), $https = false)  
{  
    $results['error']   = '';  
    $results['status']  = 0;  
    $results['data']    = array();  
    $user_agent         =  $_SERVER['HTTP_USER_AGENT'];  
    $curl               = curl_init();                              // 启动一个CURL会话  
      
  
    if( !empty($data) && is_array($data) )  
    {  
        curl_setopt($curl, CURLOPT_POST, 1);                        // 发送一个常规的Post请求  
        curl_setopt($curl, CURLOPT_POSTFIELDS, $data);              // Post提交的数据包  
    }  
    if( $https )  
    {  
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);              // 对认证证书来源的检查  
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 1);              // 从证书中检查SSL加密算法是否存在  
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);              // 使用自动跳转  
    }  
        curl_setopt($curl, CURLOPT_URL, $url);                      // 要访问的地址  
        curl_setopt($curl, CURLOPT_TIMEOUT, 30);                    // 设置超时限制防止死循环  
        curl_setopt($curl, CURLOPT_HEADER, 0);                      // 显示返回的Header区域内容  
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);              // 获取的信息以文件流的形式返回  
        curl_setopt($curl, CURLOPT_USERAGENT,$user_agent);          // 模拟用户使用的浏览器  
        curl_setopt($curl, CURLOPT_AUTOREFERER, 1);                 // 自动设置Referer  
          
    $results['data']        = curl_exec($curl);                     // 执行操作  
    if (curl_errno($curl))   
    {  
       $results['error']    = curl_error($curl);                    //捕抓异常  
    }  
    curl_close($curl);                                              // 关闭CURL会话  
    return $results;                                                // 返回数据  
  
}  
// CURL https post 方式提交数据  
function curl_https_post($url, $data)  
{  
    return curl_get_contents($url,$data,true);  
}  
  
  
// CURL https get 方式获取网页  
function curl_https_get($url)  
{  
    return curl_get_contents($url,array(),true);  
}  
  
  
// CURL https post 方式提交数据  
function curl_http_post($url, $data = array())  
{  
  
    return curl_get_contents($url,$data,false);  
}  
// CURL https get 方式获取网页  
function curl_http_get($url)  
{  
    return curl_get_contents($url,array(),true);  
}

 /**
	 * 监听钩子

	 */
function themehook($type = 'Index', $name = 'index', $params=[]) {
	\app\common\behavior\ThemeHook::call($type, $name, $params);
}


function update_config($file, $ini, $value, $type = 'string') {
	if (!file_exists($file)) return FALSE;
		
	$str = file_get_contents($file);
	$str2 = "";
	if ($type != 'string') {
		$str2 = preg_replace("/'" . $ini . "'(.*)=>(.*),/", "'" . $ini . "'=>" . $value . ",", $str);
	} else {
		$str2 = preg_replace("/'" . $ini . "'(.*)=>(.*)',/", "'" . $ini . "'=>'" . $value . "',", $str);
	}

	file_put_contents($file, $str2);
}

/**
 * json文件操作
 * @param string $op 操作方法 get = 取 ，非get = 生成保存
 * @param string $name 文件路径
 * @return json/array
 * @author rain 80692285@qq.com
 */
function json_op($op='get',$file,$data){
	if($op == 'get'){
		// 从文件中读取数据到PHP变量
        $json_string = file_get_contents($file);
        // 把JSON字符串转成PHP数组
        $data = json_decode($json_string, true);
		return $data;
	}
	$json_string = json_encode($data ,JSON_UNESCAPED_UNICODE);
    // 写入文件
    file_put_contents($file, $json_string);
	return $json_string;
}
/**
 * 删除指定目录下的文件
 * */
function delFile($path) {
    $op = dir($path);
    while(false != ($item = $op->read())) {
        if($item == '.' || $item == '..') {
            continue;
        }
        if(is_dir($op->path.'/'.$item)) {
            deleteAll($op->path.'/'.$item);
            rmdir($op->path.'/'.$item);
        } else {
            unlink($op->path.'/'.$item);
        }
    
    }   
}
/**  
 * 获取客户端浏览器级系统信息 添加win10 edge浏览器判断  
 * @param  null  
 * @author  Jea杨  
 * @return string   
 */  

function getAgentInfo(){  
    $agent = $_SERVER['HTTP_USER_AGENT'];  
    $brower = array(  
        'MSIE' => 1,  
        'Firefox' => 2,  
        'QQBrowser' => 3,  
        'QQ/' => 3,  
        'UCBrowser' => 4,  
        'MicroMessenger' => 9,  
        'Edge' => 5,  
        'Chrome' => 6,  
        'Opera' => 7,  
        'OPR' => 7,  
        'Safari' => 8,  
        'Trident/' => 1  
    );  
    $system = array(  
        'Windows Phone' => 4,  
        'Windows' => 1,  
        'Android' => 2,  
        'iPhone' => 3,  
        'iPad' => 5  
    );  
    $browser_num = 0;//未知  
    $system_num = 0;//未知  
    foreach($brower as $bro => $val){
    	$browser_num = '未知';  
        if(stripos($agent, $bro) !== false){  
            $browser_num = $bro;  
            break;  
        }  
    }  
    foreach($system as $sys => $val){
    	$system_num = '未知';   
        if(stripos($agent, $sys) !== false){  
            $system_num = $sys;  
            break;  
        }  
    }  
    return array('sys' => $system_num, 'bro' => $browser_num);  
}

