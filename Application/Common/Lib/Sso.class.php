<?php
namespace Common\Lib;
class Sso{
    private $secrect ; //验证密钥
    private $ssoid; //在ssoserver 中的站点id
	private $ssoUrl ; //  验证地址
    public function __construct(){
        $this->secrect  = '271354e9c145bf43de3c4fc88363f514';
        $this->ssoid	= 1;
        $this->ssoUrl	= 'http://www.sso.com/Login/sso';
     }

    /**
     *验证cookie是否合法有效
     * @param $isJump 当没有权限时，是否跳转
     * @return type
     */
    public function checkCookie($isJump = true){
        $tokenName = 'ssoToken';
        $ssoToken = '';
        $isCookie = true;
        if( isset($_COOKIE[$tokenName])){
            $ssoToken = $_COOKIE[$tokenName];
        }else{
            $ssoToken = $_GET[$tokenName] ? $_GET[$tokenName] : $_POST[$tokenName];
            $isCookie = false;
        }
        //访问令牌不存在
        if(!$ssoToken) return $this->error($isJump);

        $ssoauth =  unserialize( base64_decode($ssoToken));
        //访问令牌不存在
        if( ! $ssoauth){
            if($isJump){
                $this->ssoLogin();
            }
            exit;
        }
        //没有cookie
        if($isCookie === false){
            $this->setCookie( $tokenName, $ssoToken, 86400, '/');
        }
        return $ssoauth;
    }

    private function error($isJump = true){
    	if($isJump){
    		$this->ssoLogin();
    	}else{
    		return array('ok' => 0,'ssoUrl' => $this->ssoUrl('login', SSO_BACK));
    	}
    }

    /**
     *退出系统
     */
    public function logout(){
        $tokenName = 'ssoToken_' . $this->ssoid;
        $this->setcookie( $tokenName, '', 1, '/');
        unset($_COOKIE);
        return $this->ssoUrl('logout');
    }
    /**
     *获取当前完整URL
     * @param String $param 参数为y则获取的URL带参数
     * @return string
     */
    public function curPageURL($param='y'){
        $pageURL = 'http';
        if ($_SERVER["HTTPS"] == "on") {
            $pageURL .= "s";
        }
        $pageURL .= "://";
        $pageURL  .= $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        return $pageURL;
    }
    /**
     *跳转到ssourl去验证
     */
    public function ssoLogin($action='login'){
        $url = $this->ssoUrl($action);
        echo "<script>location.href = '$url';</script>";
        exit;
    }
    /**
     * 跳转给中心站点的url
     * @param type $action  默认为登陆 登出为logout
     */
    public function ssoUrl($action='login', $pageUrl = ''){
    	if($action == 'login'){
        	$pageUrl = urlencode($pageUrl ? $pageUrl : $this->curPageURL());
    	}else{
    		$pageUrl = urlencode($this->indexPage);
    	}
        $sig = md5($this->secrect . $this->ssoid . $pageUrl) ;
        $aParam = array(
                    'ssoid'    => $this->ssoid,
                    'sig'       => $sig,
                    'redirect'  => $pageUrl
        );
        $param = http_build_query($aParam);
        $url = $this->ssoUrl . '?' . $param;
        if($action == 'logout'){
            $url .= '&act=logout';
        }
        return $url;
    }

    public function request_uri(){
        if (isset($_SERVER['REQUEST_URI'])){
            $uri = $_SERVER['REQUEST_URI'];
        }
        else{
            if (isset($_SERVER['argv'])){
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['argv'][0];
            }
            else{
                $uri = $_SERVER['PHP_SELF'] .'?'. $_SERVER['QUERY_STRING'];
            }
        }
        return $uri;
    }
    /**
     *返回加密的sig
     *  @param String $str
     */
    public function sig($str){
        return md5($this->secrect .$str );
    }
    /**
	 * 设置COOKIE
	 * @param  $name
	 * @param  $value
	 * @param  $time 过期时间,0则关闭浏览器失效
	 */
	public static function setCookie($name, $value, $time=0, $path='/'){
		$expires = $time ? time()+(int)$time : 0;
		setcookie($name, $value, $expires, $path, '', false, true);
	}
}
?>
