<?php

session_start();
require_once 'connect.php';
    $path = 'uploads/skins/' . $_SESSION['user']['login'].'.png';
    list($width, $height, $type, $attr) = getimagesize($_FILES['avatar']['tmp_name']);
    if($type != 3) {
        $response = [
            "status" => false,
            "message" => "Скин должен быть в формате PNG",
        ];
        echo json_encode($response);
        die();
    }
    if(($width != 64 && $height != 32) || ($width != 64 && $height != 64)) {
        $response = [
            "status" => false,
            "message" => "Разрешение скина должно быть 64х32 или 64х64",
        ];
        echo json_encode($response);
        die();
    }
    if (!move_uploaded_file($_FILES['avatar']['tmp_name'], '../' . $path)) {
        $response = [
            "status" => false,
            "message" => "Ошибка при загрузке аватарки",
        ];
        echo json_encode($response);
    } else {
        $response = [
            "status" => true,
        ];
        echo json_encode($response);        
    }

?>
