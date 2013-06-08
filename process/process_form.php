<?php
session_start();
if ($_POST) {

	// validate session
	if ($_SESSION['key'] != $_POST['key']) {
		header("Location: index.php");
		exit;
	}

	$api = 'https://api.github.com/gists';
	$filename = "weldan_paste.".$_POST['extension'];
	$filecontent = $_POST['input'];

	$input_array = array(
		'desc' => 'Created by paste.mweldan.com',
		'public' => true,
		'files' => array(
			$filename => array(
				'content' => $filecontent
			)
		)
	);
	
	$payload = json_encode($input_array);
	
	$headers = array(
		"Content-Type: application/x-www-form-urlencoded"
	);

	$process = curl_init($api);
	$curl_version = curl_version();
	
	curl_setopt($process, CURLOPT_CUSTOMREQUEST, "POST");
	curl_setopt($process, CURLOPT_POSTFIELDS, $payload);
	curl_setopt($process, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($process, CURLOPT_USERAGENT, "curl/".$curl_version['version']);
	curl_setopt($process, CURLOPT_RETURNTRANSFER, true);	
	curl_setopt($process, CURLOPT_HTTPHEADER, $headers);

	$response = curl_exec($process);
	if ($response) {
		$result = json_decode($response);
		
		//write into db
		require_once '../config.php';
		$db = new PDO(
			'mysql:host='.$db['host'].';dbname='.$db['name'].';charset=utf8', 
			$db['user'], 
			$db['pass']
		);
		
		$stmt = $db->prepare("insert into items(gist_id,gist_url,gist_rawurl) 
		values(:gist_id,:gist_url,:gist_rawurl)");
		$vars = array(
			':gist_id' => $result->id,
			':gist_url' => $result->html_url,
			':gist_rawurl' => $result->files->{$filename}->raw_url
		);
		$stmt->execute($vars);
		
		header("Location: ../archive.php");
		exit;
	}	

}
?>
