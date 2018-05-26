<?php
namespace app\common\controller;

//------------------------
// 取后台节点类文件
//-------------------------
class AuthNode
{
   
    /**
     * @node getNode
	 * @param $m 模块名
	 * @param $c 控制器名
     */
    public function getNode($m,$c_dir){
        $modules = array($m);  //模块名称        
        //var_dump($modules);		
        $i = 0;
        foreach ($modules as $module) {
            $all_controller = $this->getController($module,$c_dir);
            foreach ($all_controller as $controller) {
                $controller_name = $controller;
                $all_action = $this->getAction($module , $controller_name ,$c_dir);
                foreach ($all_action as $action) {
                    $data[$i] = array(
                        'name' =>$module.'/'. $controller . '/' . $action,
                        'status' => 1,
                        'title'=>$this->get_cc_desc($module,$controller,$action,$c_dir)
                    );
                    $i++;
                }
            }
        }
        return $data;
    }
    /**
     * @cc 获取所有控制器名称
     *
     * @param $module
     *
     * @return array|null
     */
    protected function getController($module,$c_dir){
        if(empty($module)) return null;
        $module_path = APP_PATH . '/' . $module . '/' . $c_dir . '/';  //控制器路径
        if(!is_dir($module_path)) return null;
        $module_path .= '/*.php';
        $ary_files = glob($module_path);
        foreach ($ary_files as $file) {        	
            if (is_dir($file)) {
                continue;
            }else {
            	$c_name =  basename($file, '.php');
				if($c_name != 'Error'){
					$files[] = $c_name;
				}           	
     	               
            }
        }
		//dump($files);
        return $files;
    }
    /**
     * @node 获取所有方法名称
     *
     * @param $module
     * @param $controller
     *
     * @return array|null
     */
    protected function getAction($module, $controller,$c_dir){
        if(empty($controller)) return null;
        $content = file_get_contents(APP_PATH . '/'.$module.'/'.$c_dir.'/'.$controller.'.php');
        preg_match_all("/.*?public.*?function(.*?)\(.*?\)/i", $content, $matches);
        $functions = $matches[1];
        //排除部分方法
        $inherents_functions = array('_before_index','_after_index','_initialize','__construct','getActionName','isAjax','display','show','fetch','buildHtml','assign','__set','get','__get','__isset','__call','error','success','ajaxReturn','redirect','__destruct','_empty');
        $customer_functions=array();
        foreach ($functions as $func){
            $func = trim($func);
            if(!in_array($func, $inherents_functions)){
              if (strlen($func)>0)   $customer_functions[] = $func;
            }
        }
        return $customer_functions;
    }
    /**
     * @cc 获取函数的注释
     *
     * @param $module Home
     * @param $controller Auth
     * @param $action index
     *
     * @return string 注释
     *
     */
    protected function get_cc_desc($module,$controller,$action,$c_dir){
        $desc='\app\\'.$module.'\\'.$c_dir.'\\'.$controller;
        $func  = new \ReflectionMethod(new $desc(),$action);        
        $tmp   = $func->getDocComment();				
        $flag  = preg_match_all('/@node(.*?)\n/',$tmp,$tmp_node);
		//preg_match_all('/@module(.*?)\n/',$tmp,$tmp_module);				
		if(!empty($tmp_node[1][0])){
		    $tmp_node = trim($tmp_node[1][0]);
		}else{
		    $tmp_node = 'NOT';
		}
		//dump($tmp_module);
        return $tmp_node;
    }


}