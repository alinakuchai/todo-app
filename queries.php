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

<body class="container">
   <?php
    $link=mysqli_connect("localhost", "todo-app-user", "yjdsqgfhjkm", "todo-app");
    ?>
    <a href="/" class="back">Back to app</a>
    <table class="queries">
        <thead>
            <tr>
                <th>№</th>
                <th>Query</th>
                <th>Result</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>1</td>
                <td class="query">
                    <?php 
                    $query = "SELECT DISTINCT  `status` FROM  `tasks` ORDER BY  `status` ASC ";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
			         $data[] = $row;
		              }
		            
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>2</td>
                <td class="query">
                    <?php 
                    $query = "SELECT projects.name AS project, COUNT(tasks.project_id) AS  `count_tasks` FROM  `projects`  LEFT JOIN  `tasks` ON projects.id = tasks.project_id GROUP BY  `project` ORDER BY `count_tasks` DESC";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>3</td>
                <td class="query">
                    <?php 
                    $query = "SELECT projects.name AS project, COUNT(tasks.project_id) AS  `count_tasks` FROM  `projects`  LEFT JOIN  `tasks` ON projects.id = tasks.project_id GROUP BY  `project` ORDER BY `project` ASC";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>4</td>
                <td class="query">
                    <?php 
                   
                    $query = "SELECT projects.name AS  `project` , tasks.name AS  `task` FROM  `tasks` LEFT JOIN  `projects` ON projects.id = tasks.project_id WHERE projects.name LIKE  'N%' GROUP BY  `task` ORDER BY  `task` ASC ";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>5</td>
                <td class="query">
                    <?php 
                    $query = "SELECT projects.name AS project, COUNT( tasks.project_id ) AS  `count_tasks` FROM  `projects` LEFT JOIN  `tasks` ON projects.id = tasks.project_id WHERE projects.name LIKE  '%a%' GROUP BY  `project` ORDER BY  `project` ASC";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            //echo json_encode($data);
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            <tr>
                <td>6</td>
                <td class="query">
                    <?php 
                    $query = "SELECT name FROM tasks GROUP BY name HAVING COUNT( name ) >1 ORDER BY name ASC ";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            //echo json_encode($data);
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
                <td>7</td>
                <td class="query">
                    <?php 
                    $query = "SELECT tasks.name AS  `task` , COUNT( * ) AS  `duplicates` FROM  `tasks` LEFT JOIN  `projects` ON projects.id = tasks.project_id WHERE projects.name LIKE  'Garage' GROUP BY  `task` , tasks.status HAVING COUNT( * ) >1 ORDER BY `duplicates` ASC";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            //echo json_encode($data);
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
            </tr>
                <td>8</td>
                <td class="query">
                    <?php 
                    $query = "SELECT projects.id, projects.name, COUNT(tasks.status) AS `done` FROM projects LEFT JOIN tasks ON projects.id = tasks.project_id WHERE tasks.status LIKE '1' GROUP BY projects.name, projects.id HAVING COUNT( tasks.project_id ) >10 ORDER BY projects.id ASC ";
                   echo $query;
                    ?>
                </td>
                <td>
                    <?php
                    $result = $link->query($query);
                    $data = array();
        
                    while ($row = $result->fetch_assoc()) {
                    $data[] = $row;
		              }
		            //echo json_encode($data);
                    echo "<pre>";
                    var_dump ($data);
                    echo "</pre>";
                    ?>
                </td>
            </tr>
        </tbody>
    </table>
</body>