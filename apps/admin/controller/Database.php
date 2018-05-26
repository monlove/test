<?php
namespace app\admin\controller;

use think\Db;
use util\Database as DatabaseModel;

class Database extends Base
{
    /**
     * @node 数据库备份
	 * 
     *
     */	    	
    public function index()
    {

        return $this->fetch();
    }
    /**
     * @node 备份
	 * @module 系统
     *
     */	
	public function back($data = null, $start = 0)
    {
        $tables = $data;
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
            // 初始化
            $path = config('data_set.data_backup_path');
			
            if(!is_dir($path)){
                mkdir($path, 0755, true);
            }
         
            // 读取备份配置
            $config = array(
                'path'     => realpath($path) . DIRECTORY_SEPARATOR,
                'part'     => config('data_set.data_backup_part_size'),
                'compress' => config('data_set.data_backup_compress'),
                'level'    => config('data_set.data_backup_compress_level'),
            );

            // 检查是否有正在执行的任务
            $lock = "{$config['path']}backup.lock";
            if(is_file($lock)){
                return restApi(90060,'检测到有一个备份任务正在执行，请稍后再试！');
            } else {
                // 创建锁文件
                file_put_contents($lock, $this->request->time());
            }

            // 检查备份目录是否可写
            is_writeable($config['path']) || $this->error('备份目录不存在或不可写,请检查后重试！');

            // 生成备份文件信息
            $file = array(
                'name' => date('Ymd-His', $this->request->time()),
                'part' => 1,
            );

            // 创建备份文件
            $Database = new DatabaseModel($file, $config);
            if(false !== $Database->create()){
                // 备份指定表
                foreach ($tables as $table) {
                    $start = $Database->backup($table, $start);
                    while (0 !== $start) {
                        if (false === $start) { // 出错
                            return restApi(90060,'备份出错');
                        }
                        $start = $Database->backup($table, $start[0]);
                    }
                }

                // 备份完成，删除锁定文件
                unlink($lock);
                // 记录行为
                //action_log('database_export', 'database', 0, UID, implode(',', $tables));
                return restApi(1,'备份完成！');
            } else {
                return restApi(90063,'初始化失败，备份文件创建失败!');
            }
        } else {
            return restApi(90064,'参数错误!');
        }    	       	

    }
    /**
     * @node 还原
	 * @module 系统
     *
     */	
    public function recovery($ids = 0){
        if ($ids === 0) $this->error('参数错误！');

        // 初始化
        $name  = date('Ymd-His', $ids) . '-*.sql*';
        $path  = realpath(config('data_set.data_backup_path')) . DIRECTORY_SEPARATOR . $name;
        $files = glob($path);
        $list  = array();
        foreach($files as $name){
            $basename = basename($name);
            $match    = sscanf($basename, '%4s%2s%2s-%2s%2s%2s-%d');
            $gz       = preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql.gz$/', $basename);
            $list[$match[6]] = array($match[6], $name, $gz);
        }
        ksort($list);

        // 检测文件正确性
        $last = end($list);
        if(count($list) === $last[0]){
            foreach ($list as $item) {
                $config = [
                    'path'     => realpath(config('data_set.data_backup_path')) . DIRECTORY_SEPARATOR,
                    'compress' => $item[2]
                ];
                $Database = new DatabaseModel($item, $config);
                $start = $Database->import(0);

                // 循环导入数据
                while (0 !== $start) {
                    if (false === $start) { // 出错
						return restApi(13000,'还原数据出错！');
                    }
                    $start = $Database->import($start[0]);
                }
            }
            // 记录行为
            //action_log('database_import', 'database', 0, UID, date('Ymd-His', $ids));
            return restApi(1,'还原成功');
        } else {
        	return restApi(13000,'备份文件已经损坏或格式不正确！');
        }		
		
	}
    /**
     * @node 优化表
	 * 
     *
     */
    public function optimize($ids = null)
    {    	
        $tables = $ids;
		if(empty($ids)){
			$tables=input('post.data/a');
		}
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list   = Db::query("OPTIMIZE TABLE `{$tables}`");

                if($list){
                    // 记录行为
                    //action_log('database_optimize', 'database', 0, UID, "`{$tables}`");
                    return restApi(1,'数据表优化完成');
                    //$this->success("数据表优化完成！");
                } else {
                	return restApi(13006,'数据表优化出错请重试');
                    //$this->error("数据表优化出错请重试！");
                }
            } else {
                $list = Db::query("OPTIMIZE TABLE `{$tables}`");
                if($list){
                    // 记录行为
                   
                   // action_log('database_optimize', 'database', 0, UID, $tables);
                   return restApi(1,'数据表'.$tables.'优化完成！');
                    //$this->success("数据表'{$tables}'优化完成！");
                } else {
                	return restApi(13006,'数据表'.$tables.'优化出错请重试！');
                    //$this->error("数据表'{$tables}'优化出错请重试！");
                }
            }
        } else {
        	return restApi(13006,"请选择要优化的表");
            //$this->error("请选择要优化的表！");
        }
    }
	
    /**
     * @node 修复表
	 * 
     *
     */
    public function repair($ids = null)
    {
		$tables = $ids;
		if(empty($ids)){
			$tables=input('post.data/a');
		}
        if($tables) {
            if(is_array($tables)){
                $tables = implode('`,`', $tables);
                $list = Db::query("REPAIR TABLE `{$tables}`");

                if($list){
                    // 记录行为
                    //action_log('database_repair', 'database', 0, UID, "`{$tables}`");
                    return restApi(1,"数据表修复完成");
                    //$this->success("数据表修复完成！");
                } else {
                	return restApi(13006,"数据表修复出错请重试");
                   // $this->error("数据表修复出错请重试！");
                }
            } else {
                $list = Db::query("REPAIR TABLE `{$tables}`");
                if($list){
                    // 记录行为
                   // action_log('database_repair', 'database', 0, UID, $tables);
                    return restApi(1,"数据表'{$tables}'修复完成！");
                   // $this->success("数据表'{$tables}'修复完成！");
                } else {
                	return restApi(13006,"数据表'{$tables}'修复出错请重试！");
                   // $this->error("数据表'{$tables}'修复出错请重试！");
                }
            }
        } else {
        	return restApi(13006,"请指定要修复的表");
            //$this->error("请指定要修复的表！");
        }
    }
	
    /**
     * @node 删除备份
	 * 
     *
     */
    public function delete($ids = 0)
    {
        if ($ids == 0) {
        	restApi(13000,'参数错误！');
		}	

        $name  = date('Ymd-His', $ids) . '-*.sql*';
        $path  = realpath(config('data_set.data_backup_path')) . DIRECTORY_SEPARATOR . $name;
        array_map("unlink", glob($path));
        if(count(glob($path))){
        	return restApi(13000,'备份文件删除失败,请检查目录权限！');
        } else {
            // 记录行为
            //action_log('database_backup_delete', 'database', 0, UID, date('Ymd-His', $ids));
			return restApi(1,'备份文件删除成功！');
        }
    }
    /**
     * @node 数据列表
	 * 
     *
     */				
    public function datalist()
    {
        $data_list = Db::query("SHOW TABLE STATUS");
        $data_list = array_map('array_change_key_case', $data_list);
		$res=['data'=>$data_list];
        return $res;
    }
    /**
     * @node 备分列表
	 * 
     *
     */
	public function databaklist()
	{
		$path = \Env::get('root_path').config('data_set.data_backup_path');
        if(!is_dir($path)){
            mkdir($path, 0755, true);
        }
        $path = realpath($path);
        $flag = \FilesystemIterator::KEY_AS_FILENAME;
        $glob = new \FilesystemIterator($path,  $flag);
        $data_list = [];
        foreach ($glob as $name => $file) {
            if(preg_match('/^\d{8,8}-\d{6,6}-\d+\.sql(?:\.gz)?$/', $name)){
                $name = sscanf($name, '%4s%2s%2s-%2s%2s%2s-%d');

                $date = "{$name[0]}-{$name[1]}-{$name[2]}";
                $time = "{$name[3]}:{$name[4]}:{$name[5]}";
                $part = $name[6];

                if(isset($data_list["{$date} {$time}"])){
                    $info = $data_list["{$date} {$time}"];
                    $info['part'] = max($info['part'], $part);
                    $info['size'] = $info['size'] + $file->getSize();
                } else {
                    $info['part'] = $part;
                    $info['size'] = $file->getSize();
                }
                $extension        = strtoupper(pathinfo($file->getFilename(), PATHINFO_EXTENSION));
                $info['compress'] = ($extension === 'SQL') ? '-' : $extension;
                $info['time']     = strtotime("{$date} {$time}");
                $info['name']     = $info['time'];

                $data_list["{$date} {$time}"] = $info;
            }
        }

         $data_list = !empty($data_list) ? array_values($data_list) : $data_list;
		 foreach($data_list as $key => $val){
		 	$data_list[$key]['date'] = timeTodate($data_list[$key]['time']);
			$data_list[$key]['name'] = '<i class="fa fa-fw fa-database" style="color:#999;"></i>'.timeTodate($data_list[$key]['name'],'name');
		 }
		 return ['data'=>$data_list];
	}
}
