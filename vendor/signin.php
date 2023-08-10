<?php 
	session_start();
	require_once 'connect.php';

	$login = $_POST['login'];	
	$password = $_POST['password'];

	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = @$_SERVER['REMOTE_ADDR'];
	  
	if(filter_var($client, FILTER_VALIDATE_IP)) $ip_address = $client;
	elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip_address = $forward;
	else $ip_address = $remote;

	$error_fields = [];

	if($login === '') {
		$error_fields[] = 'login';
	}

	if($password === '') {
		$error_fields[] = 'password';
	}

	if(!empty($error_fields)) {
		$response = [
			"status" => false,
			"type" => 1,
			"message" => "Проверьте правильность полей",
			"fields" => $error_fields
		];
		echo json_encode($response);
		die();
	}

	$password = md5(md5($password));
	$check_user = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login' AND `password` = '$password' LIMIT 1");
	if(mysqli_num_rows($check_user)) {
		$user =  mysqli_fetch_assoc($check_user);
		$_SESSION['user'] = [
			"id" => $user['id'],
			"login" => $user['login'],
			"regdate" => $user['regdate'],
			"email" => $user['email'],
			"admin" => $user['admin'],
		];
		$lastdate = date("Y-m-d H:i:s"); 
		mysqli_query($connect, "UPDATE `users` SET `lastdate`='$lastdate',`lastip`='$ip_address' WHERE `login`='$login' LIMIT 1");
		$response = [
			"status" => true
		];
		echo json_encode($response);
	} else {
		$error_fields[] = 'password';
		$response = [
			"status" => false,
			"message" => "Неверный логин или пароль",
			"fields" => $error_fields
		];
		echo json_encode($response);
	}
?>