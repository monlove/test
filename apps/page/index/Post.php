<?php
namespace app\page\index;

use think\Loader;
use app\index\controller\Base;
use app\page\model\PostsSort;
use app\page\model\Posts;

class Post extends Base
{
    public function index()
    {
        	        
	    $param = input('param.');
		$post_data = Posts::get(['id'=>$param['id']]);
		 
		if($post_data){
			$sort_data = PostsSort::get(['id'=>$post_data['sort_id']]);
			$page_data['title'] = $post_data['title'] .' - '.$sort_data['name'];
			
            $this->assign('post_data',$post_data);			
			$this->assign('sort_data',$sort_data);
			$this->assign('page_data',$page_data);
			
            return $this->fetch();
		}
		$this->Error('页面不存在');           


    }
	
	public function lists()
	{
		
		return $this->fetch();
	}

}
