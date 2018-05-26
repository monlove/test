<?php
namespace app\cpapi\controller;

class Index {

	public function index() {
		return 'api';

	}

	public function cqsscCle() {
		$api = 'http://www.cailele.com/static/ssc/newlyopenlist.xml';
		$resource = file_get_contents($api);
		$data = json_decode($resource, 1);
		$expect = $data['c_t'];
		$opencode = $data['c_d'];
		$opentime = $data['l_r'];
		header('Content-Type: text/xml;charset=utf8');
		$limit = strlen($ct) - 3;
		$ct = substr($ct, 0, $limit) . '-' . substr($ct, $limit, $limit + 3);
		echo '<xml><row expect="' . $ct . '" opencode="' . $cr . '" opentime="' . str_replace('/', '-', $cd) . '"/></xml>';
	}
	public function cqssc_360() {
        date_default_timezone_set('PRC');
        ob_start();
        $url='http://chart.cp.360.cn/zst/qkj/?lotId=255401';
        $content=file_get_contents($url);
        $start='Issue":"';
        $end='","WinNumber';
        $expect=$this->cut($start,$end,$content);
        $expect = '20'.$expect;
        $expect = substr($expect,0,8).'-'.substr($expect,8);
        $start='WinNumber":"';
        $end='","EndTime';
        $codes=$this->cut($start,$end,$content);
        $start='EndTime":"';
        $end='"},"preIssue';
        $opentime=$this->cut($start,$end,$content);

        $opencode='';
        $i = 0;
        while ($i<=4){
            if($i<>4) $str=',';else $str='';
            $opencode.=substr($codes,$i,1).$str;
            $i+=1;
        }
		//return xml(['expect'=>$expect,'opencode'=>$opencode]);
        //header("Content-type: application/xml");
        $rest_arr=['expect'=>$expect,'opencode'=>$opencode,'opentime'=>$opentime];
		return json_encode($rest_arr);
        //return xml('<xml><row expect="'."$expect".'" opencode="'."$opencode".'" opentime="'."$opentime".'" /></xml>');
        //ob_end_flush();
        	
	}
	function cut($start,$end,$file){
        $content=explode($start,$file);
        $content=explode($end,$content[1]);
        return  $content[0];
    }
	function getcode($str){
        $str=trim(eregi_replace("[^0-9]","",$str));
        return $str;
    }

}
