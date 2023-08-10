<?php 
	session_start();
	require_once 'connect.php';
	
	$login = $_POST['reglogin'];	
	$email = $_POST['regemail'];
	$password = $_POST['regpassword'];		
	$password_confirm = $_POST['regpassword_confirm'];	
	$promocode = $_POST['regpromocode'];	
	$client  = @$_SERVER['HTTP_CLIENT_IP'];
	$forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
	$remote  = @$_SERVER['REMOTE_ADDR'];
	  
	if(filter_var($client, FILTER_VALIDATE_IP)) $ip_address = $client;
	elseif(filter_var($forward, FILTER_VALIDATE_IP)) $ip_address = $forward;
	else $ip_address = $remote;
	$error_fields = [];

	if($login === '') {
		$error_fields[] = 'reglogin';
	}
	if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
	    $error_fields[] = 'regemail';
	}
	if($password === '') {
		$error_fields[] = 'regpassword';
	}
	if($password_confirm === '') {
		$error_fields[] = 'regpassword_confirm';
	}
	if($promocode === '') {
		$error_fields[] = 'regpromocode';
	}
	if(!empty($error_fields)) {
		$response = [
			"status" => false,
			"message" => "Проверьте правильность полей",
			"fields" => $error_fields
		];
		echo json_encode($response);
		die();
	}
	$check_login = mysqli_query($connect, "SELECT * FROM `users` WHERE `login` = '$login'");
	if (mysqli_num_rows($check_login) > 0) {
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пользователь с таким логином уже зарегистрирован",
	        "fields" => ['reglogin']
	    ];

	    echo json_encode($response);
	    die();
	}
	$check_email = mysqli_query($connect, "SELECT * FROM `users` WHERE `email` = '$email'");
	if (mysqli_num_rows($check_email) > 0) {
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пользователь с таким Email уже зарегистрирован",
	        "fields" => ['regemail']
	    ];
	    echo json_encode($response);
	    die();
	}
	if(!preg_match("/^[a-zA-Z0-9]*$/", $login)) {
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Логин должен состоять из букв латинской раскладки и/или цифр",
	        "fields" => ['reglogin']
	    ];
	    echo json_encode($response);
	    die();	
	}
	if(strlen($login) < 4 || strlen($login) > 16) {
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Логин не должен быть короче 4-х или длиннее 16-и символов",
	        "fields" => ['reglogin']
	    ];
	    echo json_encode($response);
	    die();		
	}
	if(strlen($password) < 8 || strlen($password) > 64) {
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пароль не должен быть короче 8-и или длинее 64-и символов",
	        "fields" => ['regpassword']
	    ];

	    echo json_encode($response);
	    die();		
	}
	if($password === $login) {
		$error_fields[] = 'reglogin';
		$error_fields[] = 'regpassword';
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пароль не должен повторять Ваш логин",
	        "fields" => $error_fields
	    ];

	    echo json_encode($response);
	    die();		
	}
	if($password === $email) {
		$error_fields[] = 'regemail';
		$error_fields[] = 'regpassword';
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пароль не должен повторять Ваш EMail",
	        "fields" => $error_fields
	    ];

	    echo json_encode($response);
	    die();		
	}
	$check_promo = mysqli_query($connect, "SELECT * FROM `promocodes` WHERE `promocode` = '$promocode' LIMIT 1");
	if (!mysqli_num_rows($check_promo)) {
    	$error_fields[] = 'regpromocode';
	    $response = [
	        "status" => false,
	        "message" => "Промокод недействителен",
	        "fields" => $error_fields
	    ];
	    echo json_encode($response);
	    die();
	}
	if($password === $password_confirm) {
		$password = md5(md5($password));
		$regdate = date("Y-m-d"); 
		mysqli_query($connect, "INSERT INTO `users`(`login`, `email`, `password`, `regdate`, `regip`) VALUES ('$login','$email','$password','$regdate', '$ip_address')");
		mysqli_query($connect, "DELETE FROM `promocodes` WHERE `promocode` = '$promocode' LIMIT 1");
	    $response = [
	        "status" => true,
	        "message" => "Регистрация прошла успешно!",
	    ];
	    echo json_encode($response);
	} else {
		$error_fields[] = 'regpassword';
		$error_fields[] = 'regpassword_confirm';
		$response = [
			"status" => false,
			"message" => "Пароли не совпадают",
			"fields" => $error_fields
		];
		echo json_encode($response);
	}
 ?>