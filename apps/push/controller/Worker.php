<?php

namespace app\push\controller;

use think\worker\Server;
use app\user\model\Users;
use app\app\model\Apps;
use app\admin\model\Configs;
use app\push\model\AppsUserWs as UserWs;

class Worker extends Server
{
    	
    protected $socket = 'websocket://0.0.0.0:5530';
	protected $processes = 1;

    /**
     * 收到信息
     * @param $connection
     * @param $data
     */
    public function onMessage($connection, $data)
    {
        	
        // 客户端传递的是json数据
        $message_data = json_decode($data,TRUE);
		//dump($message_data);
		
        if(!$message_data)
        {
            	
            return ;
        }
		//$message_data['data_type']是否存在
		if(!array_key_exists('data_type',$message_data)){
			
			return ;
		}
		//echo 'data_type ok';
        // 根据类型执行不同的业务
        switch($message_data['data_type'])
        {
            // 客户端回应服务端的心跳
            case 'heart':
                $connection->last_time = time();
				$connection->send(json_encode(['msg_type'=>'heart']));
                break;       
            
            // 客户端登录 message格式: {type:login, name:xx, room_id:1} ，添加到客户端，广播给所有客户端xx进入聊天室
            case 'login':
                // 判断当前客户端是否已经验证,即是否设置了uid
                if(!isset($connection->uid)){
                	//dump($connection->uid);
			       // 没验证的话把第一个包当做uid（这里为了方便演示，没做真正的验证）			        					       
			        $connection->uid = $message_data['user_id'].':'.$message_data['app_id'];
					$where = ['user_id'=>$message_data['user_id'],'app_id'=>$message_data['app_id']];
					$ws_db = db('apps_user_ws')->where($where)->find();
					if($ws_db){
						db('apps_user_ws')->where($where)->setInc('sum');
					}else{
						$where['sum'] = 1;
						db('apps_user_ws')->insert($where);
					}									   			        
			        /* 保存uid到connection的映射，这样可以方便的通过uid查找connection，
			        * 实现针对特定uid推送数据
			        */			        		    	
				    $this->worker->uid[$connection->uid] = $connection;					
					$this->worker->uid[$connection->uid]->send(json_encode(['msg_type'=>'login'.$connection->uid]));
				    
					
//			    	foreach($this->worker->uid as $conn)
//				    {				        
//				       dump($conn->uid);
//				    }
                 //dump($message_data);return;	
					//dump('one['.$connection->uid.']');
			    }else{			    				    					
					$this->worker->uid[$connection->uid] = $connection;

			    }
                break;
			case 'to_clost':			    
				if(!empty($message_data['websocket_key'])){
					if(config("site.magager_websorket_key") == $message_data['websocket_key']){																											
					    $this->worker->uid[$message_data['uid']]->send(json_encode(['msg_type'=>'exit']));
						$this->worker->uid[$message_data['uid']]->close();
					    
                    }
				}
				break;	
			default:
				break;	
               
        }
        return;	
            		
    }

    /**
     * 当连接建立时触发的回调函数
     * @param $connection
     */
    public function onConnect($connection)
    {
    	//$msg = json_encode(['code'=>1,'msg'=>'success']);	
    	//$connection->send("success");
        
        
    }

    /**
     * 当连接断开时触发的回调函数
     * @param $connection
     */
    public function onClose($connection)
    {
    	
    	if(isset($connection->uid)){
            // 连接断开时删除映射
            $ws_info = explode(':',$connection->uid);
			$where = ['user_id'=>$ws_info[0],'app_id'=>$ws_info[1]];
			$ws_db = db('apps_user_ws')->where($where)->find();
			if($ws_db['sum']>1){
				db('apps_user_ws')->where($where)->setDec('sum');
				
			}else{
				db('apps_user_ws')->where($where)->update(['sum'=>0]);
				unset($this->worker->uid[$connection->uid]);
			}
            
						
        }        

        //dump("down[".$connection->id."]");
    }

    /**
     * 当客户端的连接上发生错误时触发
     * @param $connection
     * @param $code
     * @param $msg
     */
    public function onError($connection, $code, $msg)
    {
        echo "error $code\n";
    }

    /**
     * 每个进程启动
     * @param $worker
     */
    public function onWorkerStart($worker)
    {
        db('apps_user_ws')->where('sum','>',0)->update(['sum'=>0]);
    	//UserWs::where('sum','>',0)->update(['sum'=>0]);
//      Timer::add(3,function(){
//      	echo "a\n";
//      });

    }
	public function onWorkerStop(){
		db('apps_user_ws')->where('sum','>',0)->update(['sum'=>0]);
	}

}
