<?php
namespace app\page\admin;

use app\admin\controller\Base;
use app\page\model\Pages;
use app\page\model\PagesNav;
use app\page\model\PostsSort;
use think\Db;
use think\Cache;
use think\Config;

class PageNav extends Base
{
    /**
     * @node 导航菜单管理
	 * 
     *
     */		
    public function index()
    {								
		$page_nav = PagesNav::all();		
		$page_nav = $page_nav->toArray();
		foreach($page_nav as $key=>$val){
			if($page_nav[$key]['type'] != 'url'){
				$page_nav[$key]['url'] = url('index/Page/'.$page_nav[$key]['type'],'id='.$page_nav[$key]['type_id']);
				
			}
			if($page_nav[$key]['icon'] == null){
				$page_nav[$key]['icon'] = 'si si-home';
			}
		}
		$nav_list = [];
		if($page_nav){
			$nav_list = menuSort($page_nav);
		}
		
		$this->assign('nav_list',$nav_list);
        return $this->fetch();
    }
    /**
     * @node 保存菜单排序
     * @author Rain <80692285@qq.com>
     * @return mixed
     */
    public function save()
    {
        if ($this->request->isPost()) {
            $data = $this->request->post();
            if (!empty($data)) {
                $menus = $this->parseMenu($data['menus']);
                foreach ($menus as $menu) {

                    PagesNav::update($menu);					
                }
                Cache::clear();
				//dump($menus);
                return restApi(1,'保存成功');
            } else {
                return restApi(111000,'保存失败');
            }
        }
        return restApi(111001,'数据非法');
    }	
    /**
     * @node 递归解析菜单
     * @param array $menus 节点数据
     * @param int $pid 上级节点id
     * @author Rain <80692285@qq.com>
     * @return array 解析成可以写入数据库的格式
     */
    private function parseMenu($menus = [], $pid = 0)
    {
        $sort   = 1;
        $result = [];
        foreach ($menus as $menu) {
            $result[] = [
                'id'   => (int)$menu['id'],
                'parent_id'  => (int)$pid,
                'order' => $sort,
            ];
            if (isset($menu['children'])) {
                $result = array_merge($result, $this->parseMenu($menu['children'], $menu['id']));
            }
            $sort ++;
        }
        $this->error($result);
    }	
	

    /**
     * @node 添加
	 * 
     *
     */		
    public function add()
    {
    	$page_nav = PagesNav::all();		
		$page_nav = $page_nav->toArray();
		$nav_list=[];
		if($page_nav){
			$nav_list = menuSort($page_nav);
		    $nav_list = sortOut($nav_list);
		}
		
		\Config::load(APP_PATH.'page/config/menu_type.php','menu_type');
		//dump(config('menu_type.'));exit;				
		$this->assign('nav_list',$nav_list);

		 
        return $this->fetch();
    }
    /**
     * @node 取菜单联动
	 * 
     *
     */	
	public function getHtml(){		
		if(\Request::instance()->isPost()){
			$inputs = input('post.');
			if($inputs['type'] == 'page'){
				$where = input('post.page/a');
				$list = Pages::all($where);
				$restdb = $list->toArray();
				foreach($restdb as $key=>$val){
					$restdb[$key]['name'] = $restdb[$key]['title'];
					$restdb[$key]['node'] = url('index/Page/index');
					$restdb[$key]['module'] = 'page';
				}								
				return restApi(1,'读取成功',$restdb);
			}
			if($inputs['type'] == 'sort'){
				$where = input('post.sort/a');
				$list = PostsSort::all($where);
				$restdb = $list->toArray();
				foreach($restdb as $key=>$val){
					$restdb[$key]['node'] = url('index/Post/index');
					$restdb[$key]['module'] = 'page';
				}												
				return restApi(1,'读取成功',$restdb);
			}
			if($inputs['type'] == 'url'){
				$restdb = '';
				return restApi(1,'读取成功',$restdb);
			}			
			return restApi(99999,'数据不完整');
		}
		
		return restApi(1,'添加完成','data');				
	}	
    /**
     * @node 确认添加
	 * 
     *
     */	
	public function inAdd(){		
		if(\Request::instance()->isPost()){
			$inputs = input('post.');
			$result = $this->validate(
                $inputs,
                [
                    'type' => 'require',                
                ],
                [
                    'type' => '类型不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
			if($inputs['type'] === 'url'){
		        $result = $this->validate(
        	        $inputs,
         	        [
            	        'url' => 'activeUrl',
            	        'name' => 'require',                
                	],
                	[
                    	'url' => '不是有效的URL地址',
                    	'name' => '链接名不能为空',
                
                	]
				);
            	if(true !== $result){
                	 // 验证失败 输出错误信息
                	$this->error($result);
            	}								
			}else{
		        $result = $this->validate(
        	        $inputs,
         	        [
            	        'type_id' => 'number',                
                	],
                	[
                    	'type_id' => '请正确选择类型',
                
                	]
				);
            	if(true !== $result){
                	 // 验证失败 输出错误信息
                	$this->error($result);
            	}
								
			}
			//dump($inputs);exit;
			if($inputs['type'] === 'page'){
				$restdb = Pages::get(['id'=>$inputs['type_id']]);
				$inputs['name'] = $restdb['title'];
			}
			if($inputs['type'] === 'sort'){
				$restdb = PostsSort::get(['id'=>$inputs['type_id']]);
				$inputs['name'] = $restdb['name'];
			}			
            $pave_nav = PagesNav::create($inputs);
			if($pave_nav->id){
				$restdb=['name'=>$inputs['name']];
				return restApi(1,'添加完成',$restdb);
			}
			return restApi(12000,'数据不完整');
		}
		return restApi(100000,'非法数据');
						
	}
    /**
     * @node 编辑
	 * 
     *
     */		
	public function edit()
    {
        $input   = input('param.');
		$nav_menu = PagesNav::get($input['id']);		
    	$page_nav = PagesNav::all();		
		$page_nav = $page_nav->toArray();
		$nav_list=[];
		if($page_nav){
			$nav_list = menuSort($page_nav);
		    $nav_list = sortOut($nav_list);
		}
		$page_list = Pages::all(['status'=>1]);
		$post_sort_list = PostsSort::all(['status'=>1]);
		
		
		\Config::load(APP_PATH.'page/config/menu_type.php','menu_type');				
		$this->assign('nav_list',$nav_list);		
		$this->assign('nav_menu',$nav_menu);
		$this->assign('page_list',$page_list);
		$this->assign('post_sort_list',$post_sort_list);
		//dump($nav_menu);exit;		 
        return $this->fetch();
    }
    /**
     * @node 确认编辑
	 * 
     *
     */		
	public function inEdit()
    {
        if(\Request::instance()->isPost()){
			$inputs=input('post.');
			$result = $this->validate(
                $inputs,
                [
                'type'         => 'require',
                
                ],
                [
                'type'         => '类型不能为空',
                
                ]
			);
            if(true !== $result){
                 // 验证失败 输出错误信息
                $this->error($result);
            }
            $classdb = new PagesNav();
            $classdb->allowField(true)->save($inputs,['id'=>$inputs['menu_id']]);					
			$this->success('编辑成功');
		}				
    }
    /**
     * @node 删除
	 * 
     *
     */	
    public function delete(){
        if(\Request::instance()->isGet()){
        	if(input('param.id') == 1 || input('param.id') == 2){
        		return ['code'=>10000,'msg'=>'系统菜单不可操作'];
        	}
     	    PagesNav::destroy(input('param.id'));
			$this->success('删除成功');
        }
		$this->error('数据有误');
			
	}

  
}
