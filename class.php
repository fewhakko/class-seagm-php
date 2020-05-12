<?php

class SeagmIOS {

	public $user_token = null;
	public $email = null;
	public $password = null;
	public $app_token = null;
	
	public function __construct ($email = null, $password = null,$user_token = null) {
		if (empty($user_token)) {
			$this->email = $email;
			$this->password = $password;
		} else {
			$this->user_token = $user_token;
			$this->email = $email;
			$this->password = $password;
		}
	}
	
	public function request ($api_za, $data = null) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => $api_za,
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => $data,
		CURLOPT_HTTPHEADER => array(
			"Host: api.seagm.com",
			"User-Agent: Mozilla/5.0 (iPhone; CPU iPhone OS 13_3_1 like Mac OS X) AppleWebKit/605.1.15 (KHTML, like Gecko) Mobile/15E148",
			"Cache-Control: no-cache",
			"deviceuuid: 426525D1-07A9-4007-99B1-EE6A08F7866E",
			"channelid: seagm",
			"devtype: ios",
			"packagename: com.seagm.store",
			"syscountry: TH",
			"version: 1.6.7",
			"sysversion: 13.3.1",
			"syslocale: th-TH",
			"versioncode: 167",
			"resolution: 1125x2436",
			"Connection: keep-alive",
			"Accept-Language: th-th",
			"api-version: 2",
			"devname: iPhone",
			"apptoken: qj9qd19a84fpmakm59aaj0dijr",
			"Accept: /",
			"Content-Type: application/x-www-form-urlencoded",
			"Accept-Encoding: gzip, deflate, br",
			"Content-Type: text/plain"
		),
		));
		$response = curl_exec($curl);
		curl_close($curl);
		return $response;
	}

	public function GetUserToken() {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/dev_login",$parameter);
		return json_decode($web,true);
	}

	public function Login($user_token) {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'password' => $this->password,
			'email' => $this->email,
			'push_cid' => "FCM-IOS-eQTk1SHsKeU:APA91bHclzyzaYZ15wH1NMMCEelAqpPoLTgvruB9-4HmcM-0h_DOTKU2i6vhgBKLdvgs0Ix49eFxBQLuAHI1LJOXTgaSN-glPVNE4F8lO95AIoUucq8L-fTKV05PJS5yPkYT4cKj-TvP",
			'user_token' => $user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/login",$parameter);
		$few = json_decode($web,true);

		$file = fopen("session.key","w");
		fwrite($file,$few["content"]["_app_session_id"]);
		fclose($file);

		return $few;
	}

	public function userInfo() {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/user_info",$parameter);
		return json_decode($web,true);
	}

	public function gamedetails($idcard) {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'card_category_id' => $idcard,
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/game_direct_topup/detail",$parameter);
		return json_decode($web,true);
	}

	public function getListGame() {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'category_type' => "all",
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/game_direct_topup/list",$parameter);
		return json_decode($web,true);
	}

	public function getBalance() {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/topup/get_balance",$parameter);
		return json_decode($web,true);
	}

	public function BuyOrderFreeFire($card_type_id,$userid) {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'card_type_id' => $card_type_id,
			'amount' => "1",
			'action_type' => "buyNow",
			'card_tip_time' => "0",
			'userid' => $userid,
			'nickname' => "เทสๆFewZa",
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/game_direct_topup/buy",$parameter);
		return json_decode($web,true);
	}

	public function ConfirmOrder($id) {
		$curl = curl_init();
		curl_setopt_array($curl, array(
		CURLOPT_URL => "https://pay.seagm.com/th/balance/pay-seagm?trade_id=".$id."&app_token=".fgets(fopen("session.key", "r")),
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_USERAGENT => $_SERVER['HTTP_USER_AGENT'],
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => array('password' => $this->password),
		));

		$response = curl_exec($curl);
		curl_close($curl);
		return json_decode($response,true);
	}

	public function SendMessageOrder($id,$player_id) {
		$fiel = [
			'region' => "th",
			'lang' => "th",
			'currency' => "THB",
			'order_id' => $id,
			'content' => "PlayerId : ".$player_id."\n Name : เทสๆFewZa",
			'user_token' => $this->user_token
		];
		$parameter = http_build_query($fiel);
		
		$web = $this->request("https://api.seagm.com/message_post",$parameter);
		return json_decode($web,true);
	}
}
?>
