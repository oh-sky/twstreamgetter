<?php
class StreamShell extends AppShell {

	public function main(){

		// Twitterアカウント情報を取り出す
		Configure::load('twitter_account');
		$twitter_account = Configure::read('twitter_account');
		$twitter_password = Configure::read('twitter_password');

		//CURL 設定
		$curl_ch = curl_init();
		curl_setopt($curl_ch, CURLOPT_URL, "https://stream.twitter.com/1.1/statuses/filter.json");
		curl_setopt($curl_ch, CURLOPT_POST, 1);
		curl_setopt($curl_ch, CURLOPT_POSTFIELDS, "track=#".implode(',#',$this->args));
		curl_setopt($curl_ch, CURLOPT_HEADER, 0);
		curl_setopt($curl_ch, CURLOPT_USERPWD, "{$twitter_account}:{$twitter_password}");

		while(true){
			//Streaming APIから受信したものをタレナガシ
			curl_exec($curl_ch);
			//接続が切れたら、少々時間をおいて再接続する
			sleep(30);
		}

		curl_close($curl_ch);
	}
}
