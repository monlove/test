<?php
namespace app\page\index;

use think\Loader;
use app\index\controller\Base;
use app\page\model\PostsSort;
use app\page\model\Posts;

class PostSort extends Base
{
    public function index()
    {
        $param = input('param.');
		$page_data = PostsSort::get(['id'=>$param['id']]);					
        if($page_data){
        	$page_data['title'] = $page_data['name'];
        	$page_data['alias'] = $page_data['byname'];
        }
		$post_list = Posts::where(['status'=>1,'sort_id'=>$param['id']])->paginate(10);
		
		foreach($post_list as $key=>$val){

			$post_list[$key]['content'] = preg_replace('!<[^>]*?>!', ' ', $post_list[$key]['content']);
			$post_list[$key]['url'] = url('index/Post/index',['id'=>$post_list[$key]['id']]);
			if(empty($post_list[$key]['featured_image'])){
				$s = ('photo' . rand(1, 39) . '.jpg');
				$post_list[$key]['featured_image'] = '__ONEUI__/img/photos/'.$s;
			}
		}
		
		$this->assign('post_list',$post_list);      
		$this->assign('page_data',$page_data);	        
		
        return $this->fetch();

    }
	
	public function lists()
	{
		
		return $this->fetch();
	}

}
