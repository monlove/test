<?php
// +----------------------------------------------------------------------
// | Rain OS X [ RainOS ]
// +----------------------------------------------------------------------
// | 版权所有 2016~2017 RainSoft [ http://www.rain68.com ]
// +----------------------------------------------------------------------
// | 官方网站: http://rain68.com
// +----------------------------------------------------------------------
// | 开源协议 ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------

// 此函数文件来自OneThink

/**
 * 系统环境检测
 * @return array 系统环境数据
 */
function check_env(){
    $items = array(
        'os'      => array('操作系统', '不限制', '类Unix', PHP_OS, 'check'),
        'php'     => array('PHP版本', '5.6', '5.6+', PHP_VERSION, 'check'),
        'upload'  => array('附件上传', '不限制', '2M+', '未知', 'check'),
        'gd'      => array('GD库', '2.0', '2.0+', '未知', 'check'),
        'disk'    => array('磁盘空间', '100M', '不限制', '未知', 'check'),
    );

    // PHP环境检测
    if($items['php'][3] < $items['php'][1]){
        $items['php'][4] = 'times text-warning';
        session('error', true);
    }

    // 附件上传检测
    if(@ini_get('file_uploads'))
        $items['upload'][3] = ini_get('upload_max_filesize');

    // GD库检测
    $tmp = function_exists('gd_info') ? gd_info() : array();
    if(empty($tmp['GD Version'])){
        $items['gd'][3] = '未安装';
        $items['gd'][4] = 'times text-warning';
        session('error', true);
    } else {
        $items['gd'][3] = $tmp['GD Version'];
    }
    unset($tmp);

    // 磁盘空间检测
    if(function_exists('disk_free_space')) {
        $disk_size = floor(disk_free_space(INSTALL_APP_PATH) / (1024*1024));
        $items['disk'][3] = $disk_size.'M';
        if ($disk_size < 100) {
            $items['disk'][4] = 'times text-warning';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 目录，文件读写检测
 * @return array 检测数据
 */
function check_dirfile(){
    $items = [
        ['dir',  '可写', 'check', './apps'],       
        ['dir',  '可写', 'check', './public/data'],
        ['dir',  '可写', 'check', './public/static'],
        ['dir',  '可写', 'check', './public/uploads'],
        ['dir',  '可写', 'check', './runtime'],
    ];

    foreach ($items as &$val) {
        $item =	INSTALL_APP_PATH . $val[3];
        if('dir' == $val[0]){
            if(!is_writable($item)) {
                if(is_dir($item)) {
                    $val[1] = '可读';
                    $val[2] = 'times text-warning';
                    session('error', true);
                } else {
                    $val[1] = '不存在';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            }
        } else {
            if(file_exists($item)) {
                if(!is_writable($item)) {
                    $val[1] = '不可写';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            } else {
                if(!is_writable(dirname($item))) {
                    $val[1] = '不存在';
                    $val[2] = 'times text-warning';
                    session('error', true);
                }
            }
        }
    }

    return $items;
}

/**
 * 函数检测
 * @return array 检测数据
 */
function check_func(){
    $items = [
        ['pdo','支持','check','类'],
        ['pdo_mysql','支持','check','模块'],
        //['fileinfo','支持','check','模块'],
        ['curl','支持','check','模块'],
        ['file_get_contents', '支持', 'check','函数'],
        ['mb_strlen', '支持', 'check','函数'],
    ];

    foreach ($items as &$val) {
        if(('类'==$val[3] && !class_exists($val[0]))
            || ('模块'==$val[3] && !extension_loaded($val[0]))
            || ('函数'==$val[3] && !function_exists($val[0]))
        ){
            $val[1] = '不支持';
            $val[2] = 'times text-warning';
            session('error', true);
        }
    }

    return $items;
}

/**
 * 写入配置文件
 * @param $config
 * @return array 配置信息
 */
function write_config($config){
    if(is_array($config)){
        //读取配置内容
        $conf = file_get_contents(APP_PATH . 'install/data/database.tpl');
        // 替换配置项
        foreach ($config as $name => $value) {
            $conf = str_replace("[{$name}]", $value, $conf);
        }

        //写入应用配置文件
        if(file_put_contents(\Env::get('root_path') . 'config/database.php', $conf)){
            show_msg('配置文件写入成功');
        } else {
            show_msg('配置文件写入失败！', 'error');
            session('error', true);
        }
        return '';
    }
}

/**
 * 创建数据表
 * @param $db 数据库连接资源
 * @param string $prefix 表前缀
 */
function create_tables($db, $prefix = ''){
    // 读取SQL文件
    $sql = file_get_contents(APP_PATH . 'install/data/rainos.sql');

    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    // 替换表前缀
    $orginal = config('install.original_table_prefix');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    // 开始安装
    show_progress('0%');
    $all_table = config('install.install_table_total');
    $i = 1;
    foreach ($sql as $value) {
        $value = trim($value);
        if(empty($value)) continue;
        $msg  = (int)($i/$all_table*100) . '%';
        if(false !== $db->execute($value)){
            show_progress($msg);
        } else {
            show_progress($msg, 'error');
            session('error', true);
        }
        $i++;
    }
}

/**
 * 更新数据表
 * @param $db 数据库连接资源
 * @param string $prefix 表前缀
 */
function update_tables($db, $prefix = ''){
    //读取SQL文件
    $sql = file_get_contents(APP_PATH . 'install/data/update.sql');
    $sql = str_replace("\r", "\n", $sql);
    $sql = explode(";\n", $sql);

    // 替换表前缀
    $orginal = config('install.original_table_prefix');
    $sql = str_replace(" `{$orginal}", " `{$prefix}", $sql);

    //开始安装
    show_progress('0%');
    $all_table = config('install.update_data_total');
    $i = 1;
    $msg = '';
    foreach ($sql as $k=>$value) {
    	echo $value;
        $value = trim($value);
        if(empty($value)) continue;
        if(substr($value, 0, 12) == 'CREATE TABLE') {
            $msg  = (int)($i/$all_table*100) . '%';
            if($db->execute($value) === false){
                session('error', true);
            }
        } else {
            if(substr($value, 0, 8) == 'UPDATE `') {
                $msg  = (int)($i/$all_table*100) . '%';
            } else if(substr($value, 0, 11) == 'ALTER TABLE'){
                $msg  = (int)($i/$all_table*100) . '%';
            } else if(substr($value, 0, 11) == 'INSERT INTO'){
                $msg  = (int)($i/$all_table*100) . '%';
            }
            if(($db->execute($value)) === false){
                session('error', true);
            }
        }

        if ($msg != '') {
            show_progress($msg);
            $i++;
        }
    }
}

/**
 * 及时显示提示信息
 * @param  string $msg 提示信息
 */
function show_msg($msg, $class = ''){
    echo "<script type=\"text/javascript\">showmsg(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}

/**
 * 显示进度
 * @param $msg
 * @param string $class
 * @author Rain <80692285@qq.com>
 */
function show_progress($msg, $class = ''){
    echo "<script type=\"text/javascript\">show_progress(\"{$msg}\", \"{$class}\")</script>";
    flush();
    ob_flush();
}