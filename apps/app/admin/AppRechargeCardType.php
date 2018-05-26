<?php
namespace app\app\admin;

use app\admin\controller\Base;
use app\app\model\Apps;
use app\app\model\AppsUser;
use app\app\model\AppsRechargeCard as Card;
use app\app\model\AppsRechargeCardType as CardType;
use Request;
use Config;
use think\Db;

class AppRechargeCardType extends Base
{
    /**
     * @node 卡类管理
	 * 
     *
     */		
	public function index(){
		
		return $this->fetch();
		
		
	}
    /**
     * @node 添加
	 * 
     *
     */		
	public function inAdd(){
		if(Request::instance()->isPost()){
			$inputs=input('post.');
			if($inputs['unit']==='unlimited'){
				$inputs['value'] = 0;
			}
			$result = $this->validate(
                $inputs,
                [
                'name'         => 'require',
                'unit'        => 'require',
                'value'        =>  'require|number',
                ],
                [
                'name'         => '名称 不能为空',
                'unit'         => '请选择时间单位',
                'value'   => '时间值 必须为正整数',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			
			$cardtype=new CardType();			
			$resapp = $cardtype
			    ->where('name',$inputs['name'])
			    ->find();

			if($resapp){
				$this->error('失败 存在相同类型名称');
			}
			if($inputs['unit']==='unlimited'){
				$inputs['value'] = 0;
			}			
			$app=new CardType();
			if($app->count()>=5 && config('site_check')['author_type'] == 'free'){
			    $this->error('error');
            }
			$app->data($inputs);
            $app->save();					
			$this->success('添加成功');
		}				
			
		
		$this->success('添加成功');
		
	}
    /**
     * @node 编辑
	 * 
     *
     */	
    public function edit(){
		$input   = input('param.');
		$typedb = CardType::get($input['type_id']);
		//echo '<pre>';
		//var_dump($typedb);
		$this->assign('typedb',$typedb->getData());
				
		return $this->fetch();
				
	}
	
    /**
     * @node 保存
	 * 
     *
     */		
	public function inEdit(){
		if(Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'name'         => 'require',
                'unit'        => 'require',
                'value'        =>  'require|number',
                ],
                [
                'name'         => '名称 不能为空',
                'unit'        => '请选择时间单位',
                'value'        => '时间值 必须为正整数',
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }			
			$types = new CardType();						
			$restypesname = $types
			    ->where('id','neq',$inputs['type_id'])
			    ->where('name',$inputs['name'])
			    ->find();
			if($restypesname){
				$this->error('失败 存在相同卡类型名称');
			}									
			$typesdb = new CardType();
            $typesdb -> allowField(true)->save($inputs,['id'=>$inputs['type_id']]);	
			$this->success('编辑成功');
		}				
			
		$this->error('数据有误');
		
	}
    /**
     * @node 删除
	 * 
     *
     */	    
	public function del(){
        if(Request::instance()->isPost()){
            $card = new Card();
            $card->where('card_type_id', input('param.action_id'))
                ->update(['status' => 0]);      	
     	    CardType::destroy(input('param.action_id'));
			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}
    /**
     * @node 停用
	 * 
     *
     */		
	public function stop(){
		if(Request::instance()->isPost()){
     	    $cardtype=CardType::get(input('param.action_id'));
			$cardtype->status = 0;
			$cardtype->save();
			$this->success('禁用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 卡类启用
	 * 
     *
     */		
	public function start(){
		if(Request::instance()->isPost()){
     	    $cardtype=CardType::get(input('param.action_id'));
			$cardtype->status = 1;
			$cardtype->save();
			$this->success('启用成功');
        }
		$this->error('数据有误');
	}
    /**
     * @node 卡类列表
	 * 
     *
     */		
	public function Lists(){
		$draw=input('param.draw');			
		$start=input('param.start');	
		$length=input('param.length');
		$search=input('param.search/a');
		$order=input('param.order/a');
		$columns=input('param.columns/a');
				
		if($order[0]['column'] && $order[0]['dir']){
			$order_name=$columns[$order[0]['column']]['data'];			
		}else{
			$order_name = 'id';
		    $order[0]['dir'] = 'asc';
		}
			
		$cardtype  = new CardType();
		$count = $cardtype->where('name','like', ['%'.$search['value'].'%']) ->count();			
		$type  = $cardtype->where('name','like', ['%'.$search['value'].'%']) ->order($order_name.' '.$order[0]['dir'])->limit($start,$length)->select();
		
		$typelist = $type->toArray();
		//var_dump($typelist);
		$unit_config = Config::load(APP_PATH.'app/config/unit.php','unit');
		foreach($typelist as $key=>$val){
			//$typelist[$key]['value']='<code>'.$typelist[$key]['value'].'</code>&nbsp;'.$typelist[$key]['unit'];
			$typelist[$key]['value'] = '<code>'.$typelist[$key]['value'].'</code>'.$unit_config['unit'][$typelist[$key]['unit']]['title'];
			if($typelist[$key]['unit'] === 'unlimited'){
				$typelist[$key]['value'] ='<code>永久使用</code>';
			}
			
		}
		//echo '<pre>';
        //var_dump($typelist);	
		return ['recordsTotal'=>$count,'recordsFiltered'=>$count,'draw'=>$draw,'data'=>$typelist];
				
	}
    /**
     * @node 批量启用
	 * 
     *
     */		
	public function startList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$cardtype = new CardType();
			foreach($tables as $data){
			    $cardtype->where('id',$data)->update(['status' => 1]);
			}
        	$this->success('启用成功');
		}
		$this->error('失败,未选中数据');
	}
	/**
     * @node 批量禁用
	 * 
     *
     */	
	public function stopList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	$cardtype = new CardType();
			foreach($tables as $data){
			    $cardtype->where('id',$data)->update(['status' => 0]);
			}
        	$this->success('停用成功');
		}
		$this->error('失败,未选中数据');
	}
    /**
     * @node 批量删除
	 * 
     *
     */					
	public function delList()
    {
    	$tables = input('param.data/a');
		//dump($tables);
        if ($this->request->isPost() && !empty($tables) && is_array($tables)) {
        	CardType::destroy($tables);
        	$this->success('删除成功');
		}
		$this->error('失败,未选中数据');
	}	
}
