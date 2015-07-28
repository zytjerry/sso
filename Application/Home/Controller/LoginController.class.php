<?php
namespace Home\Controller;
use Think\Controller;
class LoginController extends Controller {
	//本站登录
	public function index() {
		$this->display();
	}
	//本站登录
	public function doLogin(){
		//获取参数
		$username = I('post.username');
		$passwd = md5(I('post.passwd'));

		//定义变量
		$nowTime = time();
		$ret = array('status' => 0, 'info' => '');
		if(!$username) {
			$ret['info'] = '用户名不能为空。';
			$this->ajaxReturn($ret);
		}
		if(!$passwd) {
			$ret['info'] = '密码不能为空。';
			$this->ajaxReturn($ret);
		}
		//校验参数，及登录  u_grp=1 方可以登录本系统
		$where = array('username'=>$username, 'passwd'=>$passwd, 'status'=>1,'u_grp'=>1);
		$user_info = M('User')->where($where)->find();
		unset($user_info['passwd']);
		if(!empty($user_info)){
			$_user =  base64_encode(serialize($user_info));
			session('__USER__',$_user);
			$ret['status'] = 1;
			$ret['info'] = '登录成功';
			$this->ajaxReturn($ret);
		} else {
			$ret['info'] = '验证失败，请您确认用户为正常用户。';
			$this->ajaxReturn($ret);
		}
	}
	//退出
	public function logout() {
		session('__USER__',null);
		$this->redirect('/Login/index');
	}
	//修改密码
	public function changePwd(){
		//获取参数
		$passwd = I('post.passwd');
		$surePasswd = I('post.surePasswd');

		//定义变量
		$ret = array('status' => 0, 'info' => '');

		//校验参数
		if (!$passwd) {
			$ret['info'] = '新密码不能为空。';
			$this->ajaxReturn($ret);
		}
		if (!$surePasswd || $passwd != $surePasswd) {
			$ret['info'] = '请确认两次输入的密码一致。';
			$this->ajaxReturn($ret);
		}

		//更改密码，并重新登录
		$s_user = session('__USER__');
		$user_info = unserialize( base64_decode($s_user, true));
		$where = array('id' => $user_info['id']);
		$u_info = M('User')->where($where)->find();
		if (!$u_info) {
			$ret['info'] = '用户信息不存在，修改未生效。';
			$this->ajaxReturn($ret);
		}
		$data = array('passwd'=>md5($passwd),'update_time'=>time());
		M('user')->where($where)->save($data); // 根据条件更新记录
		session('__USER__',null);
		$ret['status'] = 1;
		$ret['info'] = '密码修改成功。';
		$this->ajaxReturn($ret);
	}
	//sso登录
	public function sso() {
		$sso = I('get.');
		$this->assign('sso',$sso);
		$this->display();
	}
	//sso登录
	public function ssoLogin() {
		$user_name = I('post.user_name');
		$passwd = I('post.passwd');
		$appid = I('post.appid');
		$appkey = I('post.appkey');
		$ret = array('status' => 0, 'info' => '');
		$where = array('username'=>$user_name, 'passwd'=>md5($passwd), 'status'=>1);
		$user_info = M('User')->where($where)->find();
		if(empty($user_info)) {
			$ret['info'] = '用户验证失败！';
			$this->ajaxReturn($ret);
		}
		$where = array('appid'=>$appid,'appkey'=>$appkey);
		$webser_info = M('WebSite')->where($where)->find();
		if(empty($webser_info)) {
			$ret['info'] = '校检失败！！';
			$this->ajaxReturn($ret);
		}
		$ssoauth['sig'] = md5($appid.$appkey);
		$ssoauth['username'] = $user_info['username'];
		$ssoauth['email'] = $user_info['email'];
		$ssoauth['mobile'] = $user_info['mobile'];
		cookie('ssoToken',base64_encode(serialize($ssoauth)));
		$ret['status'] = 1;
		$ret['ssoUrl'] = $webser_info['callback_url'];
		$ret['info'] = 'sso登录成功。';
		$this->ajaxReturn($ret);
	}
}