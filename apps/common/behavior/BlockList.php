<?php
namespace app\common\behavior;

use think\facade\Request;
use app\common\model\BlockLists;
use think\Controller;

class BlockList extends Controller
{
	/*
	 * @name 动态配置
	 *
	 */
	public function run(Request $request, $params) {
        		
	    $request = request();
	    $client_ip = $request->ip();
		//dump(session('user_auth'));exit;
		$where[] = ['value','=',$client_ip];
		if(session('user_auth.user_name')){			
			$where[] = ['value','=',session('user_auth.user_name')];
		}
		if($request->param('device')){
			$where[] = ['value','=',$request->param('device')];
		}
        $prefix = config('database.prefix');	    
        if($this->isTable($prefix.'block_lists')){
        	$block_list = BlockLists::whereOR($where)->select();
		    if(count($block_list)){
			    config('app.default_return_type','json');
			    $this->error('你已被禁止访问');
		    }
        }

	}
    protected function isTable($table_name){
    	if(is_file(\Env::get('root_path').'/config/database.php')){
    		$sql = 'SHOW TABLES LIKE "'.$table_name.'"';
		    return \Db::query($sql);
    	}
    	return FALSE;
		
    }	

}
