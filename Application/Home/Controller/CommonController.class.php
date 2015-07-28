<?php
namespace Home\Controller;
use Think\Controller;

class CommonController extends Controller{
    public $user_info = array();
    public function __construct(){
        parent::__construct();
        $s_user = session('__USER__');
        $__USER__ = unserialize( base64_decode($s_user, true));
        if (!empty($__USER__)) {
			$this->user_info = $__USER__;
        } else {    //初次（或重新）进系统
            if (in_array($_SERVER['PATH_INFO'], array('Index/index', 'Login/index', ''))) {
                $this->redirect('/Login/index');
            } else { //请求跳转
            	$ret = array('status' => 99, 'info' => '亲！用户Session过期！！请重新登录！');
                $this->ajaxReturn($ret);
            }
            return false;
        }
	}

	public function _initialize(){
        if(!method_exists($this,ACTION_NAME)){
            $refurl = refurl();
            $this->assign('jumpUrl', $refurl);
            $this->display("Public:404");
            exit;
        }
    }
}