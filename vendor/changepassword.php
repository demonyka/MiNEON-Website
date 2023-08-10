<?php 
	session_start();
	require_once 'connect.php';
	
	$oldpassword = $_POST['oldpassword'];	
	$newpassword = $_POST['newpassword'];
	$newpassword_confirm = $_POST['newpassword_confirm'];		
	$login = $_SESSION['user']['login'];

	$error_fields = [];

	if($oldpassword === '') {
		$error_fields[] = 'oldpassword';
	}
	if($newpassword === '') {
		$error_fields[] = 'newpassword';
	}
	if($newpassword_confirm === '') {
		$error_fields[] = 'newpassword_confirm';
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
	if(strlen($newpassword) < 8 || strlen($newpassword) > 64) {
		$error_fields[] = 'newpassword_confirm';
		$error_fields[] = 'newpassword';
	    $response = [
	        "status" => false,
	        "type" => 1,
	        "message" => "Пароль не должен быть короче 8-и или длинее 64-и символов",
	        "fields" => $error_fields
	    ];
	    echo json_encode($response);
	    die();		
	}
	if($newpassword !== $newpassword_confirm) {
		$error_fields[] = 'newpassword_confirm';
		$error_fields[] = 'newpassword';
	    $response = [
	        "status" => false,
	        "message" => "Пароли не совпадают",
	        "fields" => $error_fields
	    ];
	    echo json_encode($response);
	    die();	
	}

	$sql = mysqli_query($connect, "SELECT `password` FROM `users` WHERE `login`='$login' LIMIT 1");
	if(mysqli_num_rows($sql)) {
	    $row = mysqli_fetch_assoc($sql);
    	$password = $row['password'];	
    	if(md5(md5($newpassword)) === $password) {
		$error_fields[] = 'newpassword_confirm';
		$error_fields[] = 'newpassword';
		$error_fields[] = 'oldpassword';
	    $response = [
	        "status" => false,
	        "message" => "Новый пароль совпадает с нынешним",
	        "fields" => $error_fields
	    ];
	    echo json_encode($response);
	    die();	    		
    	}
    	if(md5(md5($oldpassword)) === $password) {
    		$newpassword = md5(md5($newpassword));
			mysqli_query($connect, "UPDATE `users` SET `password`='$newpassword' WHERE `login`='$login' LIMIT 1");
		    $response = [
		        "status" => true,
		        "message" => "Пароль изменен"
		    ];
		    echo json_encode($response);    		
    	} else {
		    $response = [
		        "status" => false,
		        "message" => "Неверный пароль",
		        "fields" => ['oldpassword']
		    ];
		    echo json_encode($response);
		    die();	    		
    	}
	}
 ?>