<?php 
header('Content-Type:text/html;charset=utf-8'); 
header('Access-Control-Allow-Origin:*'); 
error_reporting(0);
require  'medoo.php';
require  'Response.php';
error_reporting(E_ALL || ~E_NOTICE);
$key = 'byname666s';  // 不能随意修改必须和app一致

$database = new medoo([
    'database_type' => 'mysql',
    'database_name' => 'mud',
    'server' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'charset' => 'utf8',
]);

$cs = $_GET['cs'];
$token = $_GET['token'];

if (empty($cs)) {
	Response::msg(1, '参数错误');
	exit;
} 

switch ($cs) {

	case 'login':
	    login();
		break;

	case 'reg':
	    reg();
	    break;
	case 'smyz':
	    smyz();
	    break;

	default:
		Response::msg(1, '参数错误');
		break;
}

function  login() {
	$name = $_GET['name'];
	$pass = $_GET['pass'];
	$name_a = '';
	$pass_a = '';
	global $token;



	if (empty($name)) {
		Response::msg(1, '账号不能为空！');
		exit;
	} 
	if (strlen($name) > 12 || strlen($name) < 4) {
		Response::msg(1, '账号长度为4-12个字节！');
		exit;
	}
	
	
	$name_a = substr( $name, 0, 1 );
	if(!preg_match("/^[a-z\s]+$/",$name_a)){	
		Response::msg(1, '账号必须以小写字母开头！');
		exit;
	}
	
	if (empty($pass)) {
		Response::msg(1, '密码不能为空！');
		exit;
	} 
	
	if (strlen($pass) > 12 || strlen($pass) < 4) {
		Response::msg(1, '密码长度为4-12个字节！');
		exit;
	}
	
	$pass_a = substr( $pass, 0, 1 );

	global $database;
    
	$res = $database->get("muduser", [
		"username",
		"passwd",
		"smyz",
	], [
		"username" => $name,
	
	]);

	if ($res["username"] != $name) {
		Response::msg(1, '账号错误');
		exit;
	}

	if ($res["passwd"] != $pass) {
		Response::msg(1, '密码错误');
		exit;
	}

	if ($res["username"] == $name  and $res["passwd"] == $pass) {
		
		if (!$res["smyz"]) {
			Response::msg(2, '需要防沉迷验证。');
			exit;
		}
		
		Response::msg(0, '登录成功',serverList());
	}
}

function  reg() {

	$name = $_GET['name'];
	$pass = $_GET['pass'];
	$phone = $_GET['phone'];
	$mail = $_GET['mail'];
	$name_a = '';
	$pass_a = '';
	global $token;
    
	$md5Token = md5Token($name.$pass.$phone.$mail);


	if (empty($name)) {
		Response::msg(1, '账号不能为空！');
		exit;
	} 
	if (strlen($name) > 12 || strlen($name) < 4) {
		Response::msg(1, '账号长度为4-12个字节！');
		exit;
	}
	$regex = '/^[ a-z0-9]+$/i';	
	if(!preg_match($regex, $name)){
		Response::msg(1, '用户名只能包含数字和字母！');
		exit;
	}
	
	$name_a = substr( $name, 0, 1 );
	if(!preg_match("/^[a-z\s]+$/",$name_a)){	
		Response::msg(1, '账号必须以小写字母开头！');
		exit;
	}
	
	if (empty($pass)) {
		Response::msg(1, '密码不能为空！');
		exit;
	} 
	
	if($name == $pass ){
		Response::msg(1, '账号和密码不能一样！');
		exit;
	}
	
	if (strlen($pass) > 12 || strlen($pass) < 4) {
		Response::msg(1, '密码长度为4-12个字节！');
		exit;
	}
	/*
	if(check_str($pass)){
		Response::msg(1, '请使用字母和数字组成的密码，不要使用特殊符号！');
		exit;
		
	}*/

	global $database;
 
	$resName = $database->get("muduser", [
		"username",
	], [
		"username" => $name
	]);

	if (!$resName){

		$res = $database->insert('muduser',[
		    'username' => $name,
		    'passwd' => $pass,
		]);

		if ($res) {
			Response::msg(0, '注册成功');
		} else {
			Response::msg(1, '注册失败 请重试');
		}
			
	} else {
		Response::msg(1, '账号已经被注册');
		exit;
	}
}


function check_str($str){
    $res = preg_match('/^[\x{4e00}-\x{9fa5}A-Za-z0-9 _:：,，.。…\/、~`＠＃￥％＆×＋｜｛｝＝－＊＾＄～｀!@#$%^&*()\+-—=（）！￥{}【】\[\]\|"\'’‘“”；;《》<>\?\？\·]+$/u', $str);
    return $res ? TRUE : FALSE;
}

function serverList() {
	return ['serverList' => [
				0 => ['name' => '笔墨江湖','path' =>'43.138.132.154','port' => 8888,'verify' => 'zjmDMaIpOvxdb'],  //端口是2019驱动的webscoket端口
                ]
           ];
}


function md5Token($text){
	global $key;
	$token = null;
	if ($text != null) {
		$token = md5(date('Y-m-d', time()).$key.$text);
	}
	return $token;
}
