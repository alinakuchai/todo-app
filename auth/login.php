<?
// Страница авторизации

# Функция для генерации случайной строки
function generateCode($length=6) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHI JKLMNOPRQSTUVWXYZ0123456789";
    $code = "";
    $clen = strlen($chars) - 1;
    while (strlen($code) < $length) {
            $code .= $chars[mt_rand(0,$clen)];
    }
    return $code;
}

# Соединямся с БД
$link=mysqli_connect("localhost", "todo-app-user", "yjdsqgfhjkm", "todo-app");

if(isset($_POST['submit']))
{
    # Вытаскиваем из БД запись, у которой логин равняеться введенному
    $query = mysqli_query($link,"SELECT user_id, user_password FROM users WHERE user_login='".mysqli_real_escape_string($link,$_POST['login'])."' LIMIT 1");
    $data = mysqli_fetch_assoc($query);

    # Сравниваем пароли
    if($data['user_password'] === md5(md5($_POST['password'])))
    {
        # Генерируем случайное число и шифруем его
        $hash = md5(generateCode(10));

        if(!@$_POST['not_attach_ip'])
        {
            # Если пользователя выбрал привязку к IP
            # Переводим IP в строку
            $insip = ", user_ip=INET_ATON('".$_SERVER['REMOTE_ADDR']."')";
        }

        # Записываем в БД новый хеш авторизации и IP
        mysqli_query($link, "UPDATE users SET user_hash='".$hash."' ".$insip." WHERE user_id='".$data['user_id']."'");

        # Ставим куки
        setcookie("id", $data['user_id'], time()+60*60*24*30 , "/");
        setcookie("hash", $hash, time()+60*60*24*30, "/");

        # Переадресовываем браузер на страницу проверки нашего скрипта
        header("Location: /"); exit();
    }
    else
    {
        print "<div class='error'>The username or password is incorrect.</div>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO-APP</title>
    <!-- Bootstrap -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">
    <link href="../css/style.css" rel="stylesheet">
</head>
<body>
<form method="POST" class="user-form">
<h3>Login</h3>
<input name="login" type="text" placeholder="Username"><br>
<input name="password" type="password" placeholder="Password"><br>
<input name="submit" type="submit" value="Log in">
<a href="register.php">Registration</a>
</form>
</body>