<?php
namespace Home\Controller;
class UserController extends CommonController {
    public function index(){
    	$where = array();
    	$username = I('post.username');
    	$mobile = I('post.mobile');
    	$email = I('post.email');
    	if($username) {
    		$where['username'] = array('like',"%{$username}%");
    	}
    	if($mobile) {
    		$where['mobile']	=  array('like',"%{$mobile}%");
    	}
    	if($email) {
    		$where['email']	=  array('like',"%{$email}%");
    	}
    	//记录总数
		$count 	= M('User')->where($where)->count();
		//初始化分页类
		$Page = new  \Think\Page($count, 10);  // 实例化分页类 传入总记录数
		$user_list 	= M('User')->where($where)
					->limit($Page->firstRow . ',' . $Page->listRows)
					->order('id desc')
					->select();
		$pageLink 	= $Page->show(); // 分页显示输出
		$this->assign('_USER_',$this->user_info);
		$this->assign('param',array('username'=>$username,'mobile'=>$mobile,'email'=>$email));
        $this->assign('user_list', $user_list);
        $this->assign('pageLink', $pageLink); // 赋值分页输出
		$this->display();
	}
	//新建用户
	public function createSsoUser(){
		//获取参数
		$id = I('post.id');
		$username = I('post.username');
		$passwd = I('post.passwd');
		$mobile = I('post.mobile');
		$email= I('post.email');
		$u_grp = I('post.u_grp');
		$status = I('post.status');
		$now_time = NOW_TIME;
		//定义变量
		$ret = array('status' => 0, 'info' => '');

		//校验参数
		if (!$username) {
			$ret['info'] = '用户名不能为空。';
			$this->ajaxReturn($ret);
		}
		if(!$passwd) {
			$ret['info'] = '用户密码不能为空。';
			$this->ajaxReturn($ret);
		}
		if (!$mobile) {
			$ret['info'] = '电话号码不能为空。';
			$this->ajaxReturn($ret);
		}
		$user_info = M('User')->where(array('username'=>$username))->find();
		if(!empty($user_info) && !$id) {
			$ret['info'] = '用户名已被占用。';
			$this->ajaxReturn($ret);
		}
		$passwd = md5($passwd);
		$user = $this->user_info;
		$data = array(
					'username'=>$username,
					'passwd'=>$passwd,
					'mobile'=>$mobile,
					'email'=>$email,
					'u_grp'=>$u_grp,
					'status'=>$status,
					'create_time'=>$now_time,
					'update_time'=>$now_time
		);
		$user_u_info = M('User')->where(array('id'=>$id))->find();
		if(!empty($user_u_info)) {
			unset($data['create_time']);
			$bool = M('User')->where(array('id'=>$id))->save($data);
			$id = $bool ? 1 : '';
		}else{
			$id = M('User')->add($data);
		}
		if(is_numeric($id)) {
			$ret['status'] = 1;
			$ret['url'] = U('User/index');
			$this->ajaxReturn($ret);
		}else{
			$ret['info'] = '插入异常！。';
			$this->ajaxReturn($ret);
		}
	}
	//获取一条记录信息
	public function getOne(){
		$id = I('post.id');
		$ret = array('status' => 0, 'info' => '');
		if(!$id || !is_numeric($id)) return false;
		$user_info = M('User')->where(array('id'=>$id))->find();

		if(!empty($user_info)) {
			$ret['status'] = 1;
			$ret['user_info'] = $user_info;
			$this->ajaxReturn($ret);
		}
	}
}