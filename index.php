<?php

$link=mysqli_connect("localhost", "todo-app-user", "yjdsqgfhjkm", "todo-app");
if (!(isset($_COOKIE['id']) and isset($_COOKIE['hash']))):?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO-APP</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <form method="POST" action="auth/login.php" class="user-form">
         <h3>Login</h3>
        <input name="login" type="text" placeholder="Username"><br>
        <input name="password" type="password" placeholder="Password"><br>
        <input name="submit" type="submit" value="Log in">
        <a href="auth/register.php">Registration</a>
    </form>
</body>
<?php else : ?>
<?php
    $query = mysqli_query($link, "SELECT *,INET_NTOA(user_ip) AS user_ip FROM users WHERE user_id = '".intval($_COOKIE['id'])."' LIMIT 1");
    $userdata = mysqli_fetch_assoc($query);

    if(($userdata['user_hash'] !== $_COOKIE['hash']) or ($userdata['user_id'] !== $_COOKIE['id'])
 or (($userdata['user_ip'] !== $_SERVER['REMOTE_ADDR'])  and ($userdata['user_ip'] !== "0")) or ($_GET['logout'] == 'true') ) : ?>
<?php 
        setcookie("id", "", time() - 3600*24*30*12, "/");
        setcookie("hash", "", time() - 3600*24*30*12, "/");
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO-APP</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
</head>
<body>
    <form method="POST" action="auth/login.php" class="user-form">
       <h3>Login</h3>
        <input name="login" type="text" placeholder="Username"><br>
        <input name="password" type="password" placeholder="Password"><br>
        <input name="submit" type="submit" value="Log in">
        <a href="auth/register.php">Registration</a>
    </form>
</body>
     <?php else : ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TODO-APP</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">

    <!-- Script -->
    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="js/jquery.min.js"></script>
   <script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
    <script src="js/angular.min.js"></script>
    <script src="js/sortable.js"></script>
    <script src="js/angular-custom.js"></script>
</head>

<body data-ng-app="todoModule">
    <div class="container" ng-controller="ToDoController">
       <a href="?logout=true" class="logout">Log out</a>
       <a href="queries.php" class="queries">QUERIES</a>
        <div class="headline">
            <h1>Simple TODO lists</h1>
            <p>from Ruby Garage</p>
        </div>
        <form class="wrap-project" ng-repeat="project in projects">
            <div class="wrap-project-name">
                <span class="icon-calendar"></span>
                <h3 ng-hide="project.editing">{{project.name}}</h3>
                <input ng-show="project.editing" type="text" ng-value="project.name" id="{{'proj' + project.id}}" class="editingInput" />
                <ul class="tools">
                    <li ng-show="project.editing">
                        <a href="#" class="change-name icon-floppy"></a>
                    </li>
                    <li ng-hide="project.editing">
                        <a class="icon-pen" href="#" ng-click="editName(project)"></a>
                    </li>
                    <li>
                        <a href="#" class="icon-trash-stroke" ng-click="deleteProject(project)"></a>
                    </li>
                </ul>
            </div>
            <div class="new-task icon-plus">
                <input type="text" ng-model="project.newTask.name" placeholder="Start typing here to create a task..." required />
                <a href="#" ng-click="saveTask(project.newTask.name, project)">Add Task</a>
            </div>
            <ul class="wrap-tasks" ui-sortable="sortableOptions" ng-model="project.tasks">
                <li class="task" ng-repeat="task in project.tasks">
                    <input type="checkbox" ng-model="task.status" ng-true-value="'1'" ng-false-value="'0'" ng-change="changeTaskStatus(task)" />
                    <p ng-hide="task.editing">{{task.name}}</p>
                    <input type="text" ng-show="task.editing" ng-value="task.name" id="{{'task' + task.id}}" class="editingInput" />
                    <ul class="tools">
                        <li>
                            <a href="#" class="icon-select-arrows myHandle" ng-click="sortTasks(project.tasks)"></a>
                        </li>
                        <li ng-show="task.editing">
                            <a href="#" class="change-name icon-floppy"></a>
                        </li>
                        <li ng-hide="task.editing">
                            <a href="#" class="icon-pen" ng-click="editName(task)"></a>
                        </li>
                        <li>
                            <a href="#" class="icon-trash-stroke" ng-click="deleteTask(task, project)"></a>
                        </li>
                    </ul>
                </li>
            </ul>
        </form>

        <button class="add-project icon-plus" ng-click="addList()" ng-hide="toggleForm">Add TODO List</button>
        <form class="new-project icon-plus" ng-show="toggleForm" novalidate>
            <input type="text" placeholder="Create list..." ng-model="newProject.name" id="newName" required />
            <input type="submit" value="Add Project" class="add-project" />
        </form>
    </div>
</body>

</html>

<?php endif; ?>
<?php endif; ?>





