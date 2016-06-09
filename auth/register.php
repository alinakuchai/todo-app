<?
// Страница регистрации нового пользователя

# Соединямся с БД
$link=mysqli_connect("localhost", "todo-app-user", "yjdsqgfhjkm", "todo-app");

if(isset($_POST['submit']))
{
    $err = array();

    # проверям логин
    if(!preg_match("/^[a-zA-Z0-9]+$/",$_POST['login']))
    {
        $err[] = "Please, use only latin characters and numbers for username!";
    }

    if(strlen($_POST['login']) < 3 or strlen($_POST['login']) > 30)
    {
        $err[] = "The username should be 3-30 symbols!";
    }

    # проверяем, не сущестует ли пользователя с таким именем
    $query = mysqli_query($link, "SELECT user_id FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."' LIMIT 1");
   // var_dump("SELECT COUNT(user_id) FROM users WHERE user_login='".mysqli_real_escape_string($link, $_POST['login'])."'" );
    if(mysqli_num_rows($query) > 0)
    {
        $err[] = "We already have a user with this username. Please, choose another username.";
    }

    # Если нет ошибок, то добавляем в БД нового пользователя
    if(count($err) == 0)
    {

        $login = $_POST['login'];

        # Убераем лишние пробелы и делаем двойное шифрование
        $password = md5(md5(trim($_POST['password'])));

        mysqli_query($link,"INSERT INTO users SET user_login='".$login."', user_password='".$password."'");
        header("Location: login.php"); exit();
    }
    else
    {
        foreach($err AS $error)
        {
            print "<div class='error'>".$error."<div>";
        }
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
<h3>Registration</h3>
<input name="login" type="text" placeholder="Username"><br>
<input name="password" type="password" placeholder="Password"><br>
<input name="submit" type="submit" value="Sign up">
<a href="login.php">Log in</a>
</form>
</body>