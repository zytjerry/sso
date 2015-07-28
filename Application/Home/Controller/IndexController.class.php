<?php
namespace Home\Controller;
class IndexController extends CommonController {
    public function index(){
    	$where = array();
    	$username = I('post.username');
    	$callback_url = I('post.web_site');
    	if($username) {
    		$where['sso_user.username'] = array('like',"%{$username}%");
    	}
    	if($callback_url) {
    		$where['sso_web_site.callback_url']	=  array('like',"%{$callback_url}%");
    	}
    	//记录总数
		$count 	= M('WebSite')->join("LEFT JOIN sso_user on sso_web_site.user_id = sso_user.id")
					->where($where)
					->count();
		//初始化分页类
		$Page = new  \Think\Page($count, 10);  // 实例化分页类 传入总记录数
		$app_list 	= M('WebSite')->join("LEFT JOIN sso_user on sso_web_site.user_id = sso_user.id")
					->field('sso_user.username,sso_web_site.*')
					->where($where)
					->limit($Page->firstRow . ',' . $Page->listRows)
					->order('id desc')
					->select();
		$pageLink 	= $Page->show(); // 分页显示输出
		$this->assign('_USER_',$this->user_info);
		$this->assign('param',array('username'=>$username,'callback_url'=>$callback_url));
        $this->assign('apply_list', $app_list);
        $this->assign('pageLink', $pageLink); // 赋值分页输出
		$this->display();
	}
	//新建站点
	public function createWebSite(){
		//获取参数
		$id = I('post.id');
		$appid = I('post.appid');
		$callback_url = I('post.callback_url');
		$desc = I('post.desc');
		$status = I('post.status');
		$now_time = NOW_TIME;
		//定义变量
		$ret = array('status' => 0, 'info' => '');

		//校验参数
		if (!$appid) {
			$ret['info'] = 'Appid不能为空。';
			$this->ajaxReturn($ret);
		}
		if (!$callback_url) {
			$ret['info'] = '回调地址不能为空。';
			$this->ajaxReturn($ret);
		}
		$web_info = M('WebSite')->where(array('appid'=>$appid))->find();
		if(!empty($web_info) && !$id) {
			$ret['info'] = 'Appid已被占用。';
			$this->ajaxReturn($ret);
		}
		$appkey = md5((C('APPKEY_TOKEN_PREFIX').$appid));
		$user = $this->user_info;
		$data = array(
					'user_id'=>$user['id'],
					'appid'=>$appid,
					'appkey'=>$appkey,
					'callback_url'=>$callback_url,
					'status'=>$status,
					'desc'=>$desc,
					'create_time'=>$now_time,
					'update_time'=>$now_time
		);
		$web_u_info = M('WebSite')->where(array('id'=>$id))->find();
		if(!empty($web_u_info)) {
			unset($data['create_time']);
			$bool = M('WebSite')->where(array('id'=>$id))->save($data);
			$id = $bool ? 1 : '';
		}else{
			$id = M('WebSite')->add($data);
		}
		if(is_numeric($id)) {
			$ret['status'] = 1;
			$ret['url'] = U('Index/index');
			$this->ajaxReturn($ret);
		}else{
			$ret['info'] = '插入异常！。';
			$this->ajaxReturn($ret);
		}
	}
	//删除一条记录
	public function delWeb(){
		$id = I('post.id');
		$ret = array('status' => 0, 'info' => '');
		if(!$id || !is_numeric($id)) {
			$ret['info'] = '确保ID是否正确！';
			$this->ajaxReturn($ret);
		}
		$web_info = M('WebSite')->where(array('id'=>$id))->find();
		if(empty($web_info)) {
			$ret['info'] = '确保数据项是否存在！';
			$this->ajaxReturn($ret);
		}
		$bool = M('WebSite')->where( array('id'=>$id) )->delete();
		if(!$bool) {
			$ret['info'] = '删除异常';
			$this->ajaxReturn($ret);
		}
		$ret['status'] = 1;
		$this->ajaxReturn($ret);
	}
	//获取一条记录信息
	public function getOne(){
		$id = I('post.id');
		$ret = array('status' => 0, 'info' => '');
		if(!$id || !is_numeric($id)) return false;
		$webser_info = M('WebSite')->where(array('id'=>$id))->find();

		if(!empty($webser_info)) {
			$ret['status'] = 1;
			$ret['webser_info'] = $webser_info;
			$this->ajaxReturn($ret);
		}
	}
}