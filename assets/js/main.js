// Регистрация
$('.register-btn').click(function (e) {
    e.preventDefault();

    $(`input`).removeClass('error');

    let reglogin = $('input[name="reglogin"]').val(),
        regemail = $('input[name="regemail"]').val(),
        regpassword = $('input[name="regpassword"]').val(),
        regpassword_confirm = $('input[name="regpassword_confirm"]').val(),
        regpromocode = $('input[name="regpromocode"]').val();

    let formData = new FormData();
    formData.append('reglogin', reglogin);
    formData.append('regemail', regemail);
    formData.append('regpassword', regpassword);
    formData.append('regpassword_confirm', regpassword_confirm);
    formData.append('regpromocode', regpromocode);


    $.ajax({
        url: 'vendor/signup.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {
            if (data.status) {
                document.location.href = '/index.php';
            } else {
                data.fields.forEach(function (field) {
                    $(`input[name="${field}"]`).addClass('error');
                });
                $('.regmsg').addClass('error').removeClass('none').text(data.message);

            }

        }
    });

});
// Авторизация
$('.login-btn').click(function(e) {
    e.preventDefault();

    $(`input`).removeClass('error');

    let login = $('input[name="login"]').val(),
        password = $('input[name="password"]').val();
    $.ajax({
        url: 'vendor/signin.php',
        type: 'POST',
        dataType: 'json',
        data: {
            login: login,
            password: password
        },
        success(data) {
            if(data.status) {
                document.location.href = '/index.php';
            } else {
                data.fields.forEach(function (field) {
                    $(`input[name="${field}"]`).addClass('error');
                });
                $('.logmsg').addClass('error').removeClass('none').text(data.message); 
            }       
        }
    });
});
// Загрузка скина
let avatar = false;

$('input[name="skin"]').change(function (e) {
    avatar = e.target.files[0];
});

$('.loadskin-btn').click(function (e) {
    e.preventDefault();

    let formData = new FormData();
    formData.append('avatar', avatar);


    $.ajax({
        url: 'vendor/upload.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {

            if (data.status) {
                location.reload();  
            } else {
                $('.skin').addClass('error').removeClass('none').text(data.message);
            }

        }
    });

});
$('.input-file input[type=file]').on('change', function(){
    let file = this.files[0];
    $(this).next().html(file.name);
});
// Изм. пароль
$('.changepassword-btn').click(function (e) {
    e.preventDefault();

    $(`input`).removeClass('error');

    let oldpassword = $('input[name="oldpassword"]').val(),
        newpassword = $('input[name="newpassword"]').val(),
        newpassword_confirm = $('input[name="newpassword_confirm"]').val()

    let formData = new FormData();
    formData.append('oldpassword', oldpassword);
    formData.append('newpassword', newpassword);
    formData.append('newpassword_confirm', newpassword_confirm);


    $.ajax({
        url: 'vendor/changepassword.php',
        type: 'POST',
        dataType: 'json',
        processData: false,
        contentType: false,
        cache: false,
        data: formData,
        success (data) {

            if (data.status) {
                $('.changepass').addClass('success').removeClass('none').text(data.message);
                setTimeout(() => document.location.href = '/', 3000)
            } else {
                data.fields.forEach(function (field) {
                    $(`input[name="${field}"]`).addClass('error');
                });
                $('.changepass').addClass('error').removeClass('success').removeClass('none').text(data.message);

            }

        }
    });

});


