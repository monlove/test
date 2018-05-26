<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsPrice;
use Request;
use think\Db;
use Config;

class AppPrice extends Base
{
    /**
     * @node 价格设置
	 * 
     *
     */		
    public function index()
    {
        $restapp = Apps::where('use_way','<>','free')->select();
		$app_list = $restapp->toArray();
		foreach($app_list as $key=>$val){
			$app_list[$key]['price_list'] = [];
			if($app_list[$key]['use_way'] == 'points'){
			    $price_db = AppsPrice::where('app_id',$app_list[$key]['id'])
			        ->where('unit','points')
			        ->select();
				$app_list[$key]['price_list'] = $price_db->toArray();					
			}else if($app_list[$key]['use_way'] == 'time'){
			    $price_db = AppsPrice::where('app_id',$app_list[$key]['id'])
			        ->where('unit','<>','points')
			        ->select();	
				$app_list[$key]['price_list'] = $price_db->toArray();					
			}						
		}
		$this->assign('app_list',$app_list);	
        return $this->fetch();
    }
	
    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
        $app_id = input('param.id');
		$appdb = Apps::get(['id'=>$app_id]);
		$appdb['price_list'] = AppsPrice::all(['app_id'=>$appdb['id']]);
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
		$this->assign('appdb',$appdb);
        return $this->fetch();
    }
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inAdd(){		
		if(Request::instance()->isPost()){
			$update=input('post.');
			$result = $this->validate(
                $update,
                [
                'name'         => 'require',
                'unit'   => 'alpha',
                'unit_num'   => 'number',
                'price'   => 'float',
                ],
                [
                'name'         => '价格名不能为空',
                'unit'   => '计费单位不能为空',
                'unit_num'   => '计费单位值必需是整数型',
                'price'   => '价格必需是数字',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$resdb = AppsPrice::get(['name' => $update['name']]);
			if($resdb){
				$this->error('失败 存在相同名称');
			}
						
			$classdb=new AppsPrice();
			$classdb->data($update);
            $classdb->allowField(true)->save();					
			$this->success('添加成功');
		}				
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
    {
        $price_id = input('param.');
		$price_db = AppsPrice::get($price_id);
		$price_db['app_db']   = Apps::get($price_db['app_id']);	
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
	
		$this->assign('price_db',$price_db);				 
        return $this->fetch();
    }
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
    {
        if(Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'name'         => 'require',
                'unit'   => 'alpha',
                'unit_num'   => 'number',
                'price'   => 'float',
                ],
                [
                'name'       => '价格名不能为空',
                'unit'       => '计费单位选项不能为空',
                'unit_num'   => '计费单位值必需是整数型',
                'price'      => '价格必需是数字',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			$class=new AppsPrice();						
			$resdb = $class
			    ->where('id','<>',$inputs['price_id'])
			    ->where('name',$inputs['name'])
			    ->find();
			if($resdb){
				$this->error('失败 存在相同应用名称');
			}						
            $class->allowField(true)->save($inputs,['id'=>$inputs['price_id']]);					
			$this->success('编辑成功');
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function delete(){
        if(Request::instance()->isAjax()){
     	    AppsPrice::destroy(input('param.id'));
			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}  
}
