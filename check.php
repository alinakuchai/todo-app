<?
// Скрипт проверки

# Соединямся с БД
$link=mysqli_connect("localhost", "todo-app-user", "yjdsqgfhjkm", "todo-app");

if (isset($_COOKIE['id']) and isset($_COOKIE['hash']))
{
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")))
    {
       die ('{"error":"You need to be logged in"}');
    }
}
else
{
   die ('{"error":"You need to be logged in"}');
}
?>