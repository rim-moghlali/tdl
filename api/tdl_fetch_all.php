<?php

session_start();

require_once("user-pdo.php");
require_once("TodoList.php");

$user = new Userpdo();
$tdl = new TodoList($user);

// create a response array
$response = array(
    "success" => 'no',
    "message" => ""
);


// if the user is connected
if ($user->isConnected()) {
    
    // get all to-do lists of this connected user
    $todo_lists = $tdl->getAllTodoLists();

    // get all tasks of this connected user
    $allTasks = $tdl->getAllTasks();

    $data = array();

    foreach ($todo_lists as $todo_list) {
        // get the todo list id
        $todo_list_id = $todo_list['id'];
        
        // get the tasks of this todo_list id (todo_list_id)
        $tasks = array_filter($allTasks, function($task) use ($todo_list_id) {
            return $task['todo_list_id'] == $todo_list_id;
        });

        // get only the 
        $todo_list['tasks'] = array_values($tasks); // <- BUG: reset the array indexes to 0

        $todo_list['created_at'] = date('D d/m/Y @ H:i', strtotime($todo_list['created_at']));

        $data[] = $todo_list;
        

    }

    // ...update the response by setting 'success' to 'yes'
    $response['success'] = 'yes';
    $response['message'] = "";
    // add the $data to the response
    $response['data'] = $data;

    //print_r($data);



}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);