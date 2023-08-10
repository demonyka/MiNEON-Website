<?php 
session_start();
$ndata = floor((abs(strtotime(date("Y-m-d")) - strtotime($_SESSION['user']['regdate']))/(60*60*24)));
if( $ndata == '1'){ 
    $ndata = "$ndata день";
} elseif( $ndata == '2'){ 
    $ndata = "$ndata дня"; 		
} elseif( $ndata == '3'){
    $ndata = "$ndata дня"; 
} elseif( $ndata == '4'){
    $ndata = "$ndata дня";  
} elseif( substr($ndata, -2) == '11'){ 
    $ndata = "$ndata дней";
} elseif( substr($ndata, -2) == '12'){ 
    $ndata = "$ndata дней"; 
} elseif( substr($ndata, -2) == '13'){ 
    $ndata = "$ndata дней";
} elseif( substr($ndata, -2) == '14'){ 
    $ndata = "$ndata дней"; 
} elseif( substr($ndata, -2) == '01'){ 
    $ndata = "$ndata день";	
} elseif( substr($ndata, -1) == '2'){ 
    $ndata = "$ndata дня";
} elseif( substr($ndata, -1) == '3'){ 
    $ndata = "$ndata дня";	
} elseif( substr($ndata, -1) == '4'){ 
    $ndata = "$ndata дня";				    
} else { 
    $ndata = "$ndata дней"; 
}
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>MiNEON</title>
	<link rel="stylesheet" type="text/css" href="assets/css/styles.css">
	<link rel="stylesheet" href="assets/css/fontello.css">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body background="assets/img/bg.png" class="scroll">

<div class="header">
	<div class="main">
		<div class="title">
			<!--<h1>MINE<span style="color: red;">ON</span></h1>-->
			<img src="assets/img/logo.png" style="width: 40%; height: 40%; margin-bottom: 15px; pointer-events: none;">
			<p>Лучший приватный сервер с модами!</p>
			<?php if (!$_SESSION['user']): ?>
				<button class="button collectonme" style="vertical-align:middle" data-bs-toggle="modal" data-bs-target="#startModal"><span>Начать игру </span></button>
			<?php else : ?>
				<button class="button collectonme" style="vertical-align:middle" data-bs-toggle="modal" data-bs-target="#profileModal"><span>Профиль </span></button>				
			<?php endif; ?>
			<div class="link" style="margin-top: 15px;">
				<a href="" target="_self" title="Скачать лаунчер">
					<span style="font-size: 36px;" class="icon-download"></span>
				</a>
			</div>
		</div>
	</div>
</div>
<div class="collectonme" id="footerdown2 bg-light" style="border-top: 2px solid rgba(255,255,255, .05);width: 100%;height: 100%;background: rgba(255,255,255, .01)">
	<footer style=" margin:0;" id="footerdown" class="container d-flex flex-wrap justify-content-between align-items-center">
    	<div style="position: absolute; right: 0; padding-right: 15px;">
            <span style="font-size: 1rem; margin-right: 10px;" class="text-light">
        		<a style="" class="a-minenet" href="https://discord.gg/BQbYRM6EsJ" target="_blank" title="Наш Discord">
					<span style="font-size: 24px;" class="icon-discord"></span>
				</a>
			</span>
			<span style="font-size: 1rem;" class="text-light">
        		<a class="a-minenet" href="" target="_self" title="Наш YouTube">
					<span style="font-size: 24px;" class="icon-youtube"></span>
				</a>
            </span>
        </div>
        <div style="padding: 10px 0 0 0;" class="d-flex align-items-center">
            <span style="font-size: 1rem;" class="mb-4 mb-md-0 text-light">
        		© 2022 MINEON | All rights reserved Development by <a class="a-dev" style="" href="https://t.me/demonyka" target="_blank">demonyga</a>				
				<p style="font-size: 0.7rem; margin-top: 5px">Размещенная на настоящем сайте информация носит исключительно информационный характер и ни при каких условиях не является публичной офертой
				<br>Мы предоставляем тестовый бесплатный вариант онлайн-игры Minecraft. Оригинальные права принадлежат Mojang AB и Microsoft</p>
            </span>

        </div>
    </footer>
</div>
<!-- Профиль -->
<?php if ($_SESSION['user']): ?>	
<div class="modal fade" id="profileModal" tabindex="-1" aria-labelledby="profileModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header" style="justify-content: center; flex-direction: column; padding: 10px 0 10px 0">
				<h4>
					<?php if ($_SESSION['user']['admin']): ?><span style="color: red;"><?php endif; ?><?= $_SESSION['user']['login'] ?>
				</h4>
				<img src="uploads/skin.php?user=<?= $_SESSION['user']['login'] ?>" width="128" height="128" style="align-self: center; border-radius: 12px; pointer-events: none; margin-bottom: 0;">
				<p style="margin: 5px 0 0 0; font-size: 0.9rem">Вы с нами <?= $ndata ?></p>
			</div>
			<div style="text-align: center;" class="modal-body">
				<button style="width: 50%; margin-bottom: 10px;" type="button" data-bs-toggle="modal" data-bs-target="#loadskinModal" class="btn btn-outline-light">Загрузить скин</button>
				<button style="width: 50%;" type="button" data-bs-toggle="modal" data-bs-target="#changepasswordModal" class="btn btn-outline-light">Изменить пароль</button>
				<p class="msg logmsg none">error</p>
			</div>
			<div class="modal-footer" style="justify-content: center;">
				<button style="width: 50%;" type="button" onclick="location.href='vendor/logout.php'" class="btn btn-outline-danger">Выйти из аккаунта</button>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<?php if ($_SESSION['user']): ?>
<!-- Загрузка скина -->
		<div class="modal fade" id="loadskinModal" tabindex="-1" aria-labelledby="loadskinModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="loadskinModalLabel">Загрузка скина</h5>
					</div>
					<div class="modal-body" style="text-align: center;">
						<form>
							<label class="input-file">
								<input type="file" name="skin">		
								<span>Выберите файл</span>
							</label>
						</form>
						<p style="margin: 15px 0 0 0;" class="msg skin none">error</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#profileModal">Назад</button>
						<button type="submit" class="btn btn-outline-light loadskin-btn">Загрузить</button>
					</div>
				</div>
			</div>
		</div>
<?php endif; ?>
<!-- Изм. пароль -->
<?php if ($_SESSION['user']): ?>
		<div class="modal fade" id="changepasswordModal" tabindex="-1" aria-labelledby="changepasswordModalLabel" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title" id="changepasswordModalLabel">Изменение пароля</h5>
					</div>
					<div class="modal-body" style="text-align: center;">
						<input style="margin: 0 0 0 0" class="auth-input" type="password" name="oldpassword" placeholder="Старый пароль">
						<br><input style="margin: 10px 0 0 0" class="auth-input" type="password" name="newpassword" placeholder="Новый пароль">
						<br><input style="margin: 10px 0 0 0" class="auth-input" type="password" name="newpassword_confirm" placeholder="Подтверждение пароля">
						<br><p class="msg changepass none">error</p>
					</div>
					<div class="modal-footer">
						<button type="button" class="btn btn-outline-light" data-bs-toggle="modal" data-bs-target="#profileModal">Назад</button>
						<button type="submit" class="btn btn-outline-light changepassword-btn">Подтвердить</button>
					</div>
				</div>
			</div>
		</div>
<?php endif; ?>
<!-- Авторизация -->
<?php if (!$_SESSION['user']): ?>
<div class="modal fade" id="startModal" tabindex="-1" aria-labelledby="startModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header" style="justify-content: center;">
				<h5 class="modal-title" id="startModalLabel">Авторизация</h5>
			</div>
			<div style="text-align: center;" class="modal-body">
				<input style="margin-bottom: 10px" class="auth-input" type="text" name="login" placeholder="Логин">
				<br><input class="auth-input" type="password" name="password" placeholder="Пароль">
				<p style="text-align: center; margin: 10px 0 0 0; padding: 0; color: white;">У Вас нет аккаунта? - <a class="a-reg" data-bs-toggle="modal" data-bs-target="#regModal">зарегистрируйтесь</a></p>
				<p class="msg logmsg none">error</p>
			</div>
			<div class="modal-footer" style="justify-content: center;">
				<button style="width: 50%;" type="submit" class="btn btn-outline-light login-btn">Войти</button>
			</div>
		</div>
	</div>
</div>
<?php endif; ?>
<!-- Регистрация -->
<?php if (!$_SESSION['user']): ?>
<div class="modal fade" id="regModal" tabindex="-1" aria-labelledby="regModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered ">
		<div class="modal-content">
			<div class="modal-header" style="justify-content: center;">
				<h5 class="modal-title" id="regModalLabel">Регистрация</h5>
			</div>
			<form action="vendor/signup.php" method="post">
				<div style="text-align: center;" class="modal-body">
					<input name="reglogin" style="margin-bottom: 10px" class="auth-input" type="text" placeholder="Логин">
					<br><input name="regemail" style="margin-bottom: 10px" class="auth-input" type="text" placeholder="Email">
					<br><input name="regpassword" style="margin-bottom: 10px" class="auth-input" type="password" placeholder="Пароль">
					<br><input name="regpassword_confirm" style="margin-bottom: 10px" class="auth-input" type="password" placeholder="Подтверждение пароля">
					<br><input name="regpromocode" class="auth-input" type="text" placeholder="Промокод">
					<p style="text-align: center; margin: 10px 0 0 0; color: white;">Регистрируясь, вы соглашаетесь с правилами проекта.</p>
					<p style="text-align: center; margin: 10px 0 0 0; padding: 0; color: white;">У Вас уже есть аккаунт? - <a class="a-reg" data-bs-toggle="modal" data-bs-target="#startModal">авторизируйтесь</a></p>
					<p class="msg regmsg none">error</p>
				</div>
				<div class="modal-footer" style="justify-content: center;">
					<button style="width: 50%;" type="submit" class="btn btn-outline-light register-btn">Создать аккаунт</button>
				</div>
			</form>
		</div>
	</div>
</div>
<?php endif; ?>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
<script src="assets/js/jquery-3.4.1.min.js"></script>
<script src="assets/js/main.js"></script>
<script src="assets/js/snowfall.js"></script>
<script type="text/javascript">
    $(document).snowfall({
        flakeCount: 300,
        minSize: 1, 
        maxSize:6,
        round: true,
        shadow: false,
        minSpeed: 1,
        maxSpeed: 3,
        collection : '.collectonme', flakeCount : 100
    });
</script>
</body>
</html>