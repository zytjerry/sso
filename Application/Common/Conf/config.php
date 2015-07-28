<?php
return array(
   'LOAD_EXT_CONFIG' 		=> array('database'),

    'URL_CASE_INSENSITIVE' =>true,   //不区分大小写
	//其它
    'URL_HTML_SUFFIX'=>'.html',

	'APPKEY_TOKEN_PREFIX'=>'zlx!@#$jerr',

	//逗号（,）两边，不能有空格
	'DEFAULT_FILTER'        => 'trim,htmlspecialchars', // 默认参数过滤方法 用于I函数...
	'TMPL_CACHE_ON' 		=> false,      // 默认开启模板缓存
	'ACTION_CACHE_ON'  		=> false,
	'HTML_CACHE_ON'   		=> false,
	'DB_FIELD_CACHE' 		=> false,

	'URL_MODEL'             =>  2,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
	// 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式

	'SESSION_AUTO_START'	=> true, //是否开启session
    'SESSION_PREFIX'		=>'SSO',
    'SESSION_EXPIRE'		=>1800,

	//单点登录的Cookie
	'COOKIE_PREFIX'			=>'SSO',
	'COOKIE_EXPIRE'			=> 86400,
	'COOKIE_PATH'			=>'/',
	'COOKIE_SECURE'			=>false,
	'COOKIE_HTTPONLY'		=>true,

	'PAGESIZE' 				=> 13, //分页数

	'APP_SUB_DOMAIN_DEPLOY' => true, // 是否开启子域名部署
    'APP_SUB_DOMAIN_RULES' 	=> array(
        'www.sso.com' 	=> 'Home',
        'b.sso.com' 	=> 'Admin',

        'sso.oa.com' 	=> 'Home',
        'bsso.oa.com' 	=> 'Admin',
		'msso.oa.com' 	=> 'Mobile',
    ), // 子域名部署规则

	'MULTI_MODULE' 			=> true, 								// 是否允许多模块 如果为false 则必须设置 DEFAULT_MODULE
    'MODULE_DENY_LIST' 		=> array('Common', 'Runtime'), 		// 禁止访问的模块列表
    'MODULE_ALLOW_LIST' 	=> array('Home', 'Admin','Server'), 			// 允许访问的模块列表
	'DEFAULT_MODULE' 		=> 'Home', 							// 默认模块
    'DEFAULT_CONTROLLER' 	=> 'Index', 						// 默认控制器名称


);