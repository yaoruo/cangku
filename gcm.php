<?php

	require  'Response.php';	
	$host = "https://zid.market.alicloudapi.com";
    $path = "/idcheck/Post";
    $method = "POST";
    $appcode = "59af011b27424b7eb7d38baa4560de47";
	
    $headers = array();
    array_push($headers, "Authorization:APPCODE " . $appcode);
    //根据API的要求，定义相对应的Content-Type
    array_push($headers, "Content-Type".":"."application/x-www-form-urlencoded; charset=utf-8;");
	

	
    $querys = "";
	$Name = "";
	$card = "";
	$Name=$_POST["p_name"];
	$card=$_POST["p_num"];
	$username = $_POST["myid"];
    $bodys = "cardNo=".$card."&realName=".$Name;
	
	$link=mysqli_connect('localhost','root','root','mud');	
	$sqli="select * from muduser where smyz='$card'" ;	
	$result=mysqli_query($link,$sqli); 	
    if($row=mysqli_fetch_array($result)){  
		Response::msg(1, '该证件已被实名认证。');
    }	
	
	
    $url = $host . $path;

    $curl = curl_init();
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($curl, CURLOPT_FAILONERROR, false);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    if (1 == strpos("$".$host, "https://"))
    {
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
    }
    curl_setopt($curl, CURLOPT_POSTFIELDS, $bodys);
	
	$arr = curl_exec($curl);
	
	$json = substr($arr,strripos($arr,'{"error_code'));
	$json2Array = (array)json_decode( $json , true);
	
	//echo($json2Array["result"]["isok"]);
	if(!$json2Array["error_code"]){
		if(!$json2Array["result"]["isok"])
			Response::msg(1, '账号'.$username.'防成迷验证失败，姓名和身份证不匹配');
		else{
			$birthday = $json2Array["result"]["IdCardInfor"]["birthday"];
			if(!isAdult($birthday))
				Response::msg(1, '账号'.$username.'防成迷验证失败，系统检测到你为成年人，无法进入游戏。');
			else{
				
				
				$link=mysqli_connect('localhost','root','root','mud');	
				$sql="update muduser set smyz='$card' where username='$username'";
				$result1=mysqli_query($link,$sql);												
				Response::msg(0, '账号'.$username.'防成迷验证成功。');
				
			}
				
				
		}
		exit;	
	}
	
	
	
	/**
 * 是否成年人
 * @param string $birthday [出生年月]
 * @return boolean [description]
 */
function isAdult($birthday)
{
    if(empty($birthday))
    {
        return false;
    }
    list($year,$month,$day)=explode('-', $birthday);
    if(empty($year)||empty($month)||empty($day))
    {
        return false;
    }
    $cyear=date('Y');
    $cmonth=date('m');
    $cday=date('d');
    if(intval($cday)<intval($day))
    {
        $cmonth-=1;
    }
    if(intval($cmonth)<intval($month))
    {
        $cyear-=1;
    }
    if(intval($cyear)-intval($year) < 18)
    {
        return false;
    }
    return true;
}
	
	
?>