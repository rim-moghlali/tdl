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
    
    // If 'id' exists...
    if (isset($_GET['id'])) {
        // ...get the id from PHP's GET 
        $id = (int) $_GET['id'];
        // undo the task with the $id
        $isUndone = $tdl->undoTaskById($id);
        
        // If the $isUndone is TRUE
        if ($isUndone == TRUE) {
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'yes';
            $response['message'] = "task has been undone successfully";
        } else { 
            // ...update the response by setting 'success' to 'yes'
            $response['success'] = 'no';
            $response['message'] = "failed to undo task";
        }

    }

}else { // <- user is not connected
    // update the response by setting 'success' to 'no'
    $response['success'] = 'no';
    $response['message'] = "user is not connected";

}


echo json_encode($response);