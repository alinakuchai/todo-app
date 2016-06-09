<?php
require_once 'config.php';
require_once 'check.php';

if(isset($_POST['type'])){
	$type = $_POST['type'];
	
	switch ($type) {
		case "save_project":
			save_project($mysqli, $_POST['id']);
			break;
		case "save_task":
			save_task($mysqli, $_POST['project_id'], $_POST['id']);
			break;
		case "delete_project":
			delete_project($mysqli, $_POST['id']);
			break;
		case "delete_task":
			delete_task($mysqli, $_POST['id']);
			break;
		case "getProjects":
			getProjects($mysqli);
			break;
		case "sortTasks":
			sortTasks($mysqli);
			break;
        case "change_status_task":
            change_status_task($mysqli);
            break;
		default:
			invalidRequest();
	}
}else{
	invalidRequest();
}

	function getProjects ($mysqli){
	try{
	
		$query = "SELECT * FROM `projects` WHERE owner_id = ".$_COOKIE['id'];
		$result = $mysqli->query( $query );
		$data = array();
        
        while ($row = $result->fetch_assoc()) {
            
            $task_query = "SELECT id, name, status FROM `tasks` WHERE project_id = ". $row['id']." ORDER BY order_value DESC, id ASC";
            $task_result = $mysqli->query( $task_query );
            
            while ($task_row = $task_result->fetch_assoc()) {
            $row['tasks'][] = $task_row;
            }
            
			$row['id'] = (int) $row['id'];
			$data['data'][] = $row;
		}
		$data['success'] = true;
		echo json_encode($data);exit;
	
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}

function save_project ($mysqli, $id = ''){
	try{
		$data = array();
		$name = $mysqli->real_escape_string(isset( $_POST['project']) ? $_POST['project'] : '');
	
		if($name == ''){
			throw new Exception( "Required fields missing, Please enter and submit" );
		}
        
        if(empty($id)){
			$query = "INSERT INTO projects (`id`, `name`, `owner_id`) VALUES (NULL, '$name' , '".$_COOKIE['id']."' )";
		}else{
			$query = "UPDATE projects SET `name` = '$name' WHERE `projects`.`id` = $id";
		}
		
	
		if( $mysqli->query( $query ) ){
			$data['success'] = true;
			if(!empty($id))$data['message'] = 'Project updated successfully.';
			else $data['message'] = 'Project inserted successfully.';
			if(empty($id))$data['id'] = (int) $mysqli->insert_id;
			else $data['id'] = (int) $id;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
		$mysqli->close();
		echo json_encode($data);
		exit;
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}

function save_task ($mysqli, $project_id = '', $id = ''){
	try{
		$data = array();
		$name = $mysqli->real_escape_string(isset( $_POST['task']) ? $_POST['task'] : '');
	
		if($name == ''){
			throw new Exception( "Required fields missing, Please enter and submit" );
		}
        
        if(empty($id)){
			$query = "INSERT INTO tasks (`id`, `name`, `project_id`,`status`) VALUES (NULL, '$name', $project_id, '0')";
		}else{
			$query = "UPDATE tasks SET `name` = '$name' WHERE `tasks`.`id` = $id";
		}
		
	
		if( $mysqli->query( $query ) ){
			$data['success'] = true;
			if(!empty($id))$data['message'] = 'Task updated successfully.';
			else $data['message'] = 'Task inserted successfully.';
			if(empty($id))$data['id'] = (int) $mysqli->insert_id;
			else $data['id'] = (int) $id;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
		$mysqli->close();
		echo json_encode($data);
		exit;
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}
function change_status_task ($mysqli){
	try{
		$data = array();
		$id = $mysqli->real_escape_string(isset( $_POST['id']) ? $_POST['id'] : '');
		$status = $mysqli->real_escape_string(isset( $_POST['status']) ? $_POST['status'] : '');
	
		if($status == ''){
			throw new Exception( "Required fields missing, Please enter and submit" );
		}
        
			$query = "UPDATE tasks SET `status` = '$status' WHERE `tasks`.`id` = $id";
		
	
		if( $mysqli->query( $query ) ){
			$data['success'] = true;
			$data['message'] = 'Task updated successfully.';
			$data['id'] = (int) $id;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
		$mysqli->close();
		echo json_encode($data);
		exit;
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}
function sortTasks($mysqli) {
try{
		$data = array();
		$stringId = $mysqli->real_escape_string(isset( $_POST['stringId']) ? $_POST['stringId'] : '');
        $arrayId = explode(",", $stringId);
    
        foreach ($arrayId as $id) {
        $query = "UPDATE tasks SET `order_value` = '$i' WHERE `tasks`.`id` = $id";
        		
	
		if( $mysqli->query( $query ) ){
			$data['success'] = true;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
            $i++;
}

		$mysqli->close();
		echo json_encode($data);
		exit;
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}
/**
 * This function will handle project deletion
 * @param string $id
 * @throws Exception
 */
function delete_project($mysqli, $id = ''){
	try{
		if(empty($id)) throw new Exception( "Invalid Project." );
		$query = "DELETE FROM `projects` WHERE `id` = $id";
        $query_tasks = "DELETE FROM `tasks` WHERE `project_id` = $id";
        
		if($mysqli->query( $query )){
			$data['success'] = true;
			$data['message'] = 'Project deleted successfully.';
            $mysqli->query( $query_tasks );
			echo json_encode($data);
			exit;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
		
	
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}

function delete_task($mysqli, $id = ''){
	try{
		if(empty($id)) throw new Exception( "Invalid Task." );
		$query = "DELETE FROM `tasks` WHERE `id` = $id";
		if($mysqli->query( $query )){
			$data['success'] = true;
			$data['message'] = 'Task deleted successfully.';
			echo json_encode($data);
			exit;
		}else{
			throw new Exception( $mysqli->sqlstate.' - '. $mysqli->error );
		}
		
	
	}catch (Exception $e){
		$data = array();
		$data['success'] = false;
		$data['message'] = $e->getMessage();
		echo json_encode($data);
		exit;
	}
}
function invalidRequest()
{
	$data = array();
	$data['success'] = false;
	$data['message'] = "Invalid request.";
	echo json_encode($data);
	exit;
}
?>
