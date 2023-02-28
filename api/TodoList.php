<?php

require_once('database.php');


class TodoList extends Database {


    private $user;

    public function __construct($user) {
        $this->dbConnexion();

        $this->user = $user;

        // set the default timezone to "Europe/Paris"
        date_default_timezone_set("Europe/Paris");
    }


    public function createTodoList(string $title) {
        $result = null;

        // if the title is not empty...
        if (empty(trim($title)) === FALSE) {
            $title = htmlspecialchars($title);

            // get the current time as $created_at
            $created_at = $this->getCurrentDate();
            // get the user id
            $userId = $this->user->id;
    
            //var_dump($created_at);
            
            $pdo_stmt = $this->pdo->prepare("INSERT INTO `todo_lists` (title, created_at, user_id) values(?, ?, ?)");
            $pdo_res = $pdo_stmt->execute(array($title, $created_at, $userId));
    
            if ($pdo_res) {
                // get the id of this to-do list
                $id = $this->getTodoListIdByDate($created_at);

                $result = array(
                    "id" => $id,
                    "title" => $title,
                    "created_at" => $created_at,
                    "userId" => $userId
                );
            }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }

    public function addTask(int $todo_list_id, string $description) {
        $result = null;

        // if the todolist id is greater than zero and description is not empty...
        if ($todo_list_id > 0 && empty(trim($description)) === FALSE) {
            
            $description = htmlspecialchars($description);
            // get the user id
            $userId = $this->user->id;
            
            $completed = 0;
    
            //var_dump($created_at);
    
            $pdo_stmt = $this->pdo->prepare("INSERT INTO `tasks` (todo_list_id, description, completed, user_id) values(?, ?, ?, ?)");
            $pdo_res = $pdo_stmt->execute(array($todo_list_id, $description, $completed, $userId));
    
            if ($pdo_res) {
                // get the latest todo id
                $taskId = $this->getLatestTaskId($todo_list_id);

                $result = array(
                    "id" => $taskId,
                    "description" => $description
                );
            }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }

    private function getLatestTaskId(int $todo_list_id) {

        $pdo_stmt = $this->pdo->prepare("SELECT id FROM `tasks` WHERE todo_list_id = ? ORDER BY id DESC LIMIT 1"); // order by id des - from last to first/ limit 1 - pick one
        $pdo_stmt->execute(array($todo_list_id));

        $taskId = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        return $taskId['id'];
    }

    public function deleteTodoList(int $id) : bool {
        $result = false;

        // if the id is more than zero...
        if ($id > 0) {
            //var_dump($created_at);

            try {
                $delete_todo_lists_sql = "DELETE FROM `todo_lists` WHERE id = '$id'";
                $delete_tasks_sql = "DELETE FROM `tasks` WHERE todo_list_id = '$id'";

                $this->pdo->exec($delete_todo_lists_sql);
                $this->pdo->exec($delete_tasks_sql);

                $result = true;
            }catch (PDOException $e) {
                echo $delete_todo_lists_sql . " ++ ". $delete_todo_lists_sql . "<br>" . $e->getMessage();

            }
    
            // $delete_todo_lists_stmt = $this->pdo->query("DELETE FROM `todo_lists` WHERE id = '$id'");
            // // $delete_todos_result = $this->pdo->query("DELETE FROM `todo_lists` WHERE todo_list_id = '$id'");

            // // if ($delete_todolist_result === TRUE && $delete_todos_result === TRUE) {
            // //     $result = true;
            // // }

            // echo $delete_todo_lists_stmt->ro

            // if ($delete_todo_lists_stmt->rowCount() > 0) {
            //     $result = true;
            // }

        }

        //$result = $pdo_stmt->fetch

        return $result;
        
    }


    public function deleteTaskById(int $taskId) : bool {
        $result = false;

        // if the id is more than zero...
        if ($taskId > 0) {
            //var_dump($created_at);
    
            $delete_result = $this->pdo->query("DELETE FROM `tasks` WHERE id = '$taskId'");

            // var_dump($delete_result->rowCount());

            if ($delete_result->rowCount() > 0) {
                $result = true;
            }

        }

        return $result;
        
    }

    
    public function completeTaskById(int $taskId) : bool {
        $result = false;

        // if the id is more than zero...
        if ($taskId > 0) {

            $completed = true;
            $completed_at = $this->getCurrentDate();

            $complete_task_sql = "UPDATE `tasks` SET completed = :completed, completed_at = :completed_at WHERE id = :taskId";

            $pdo_stmt = $this->pdo->prepare($complete_task_sql);

            $pdo_stmt->bindParam(':completed', $completed);
            $pdo_stmt->bindParam(':completed_at', $completed_at);
            $pdo_stmt->bindParam(':taskId', $taskId);

            $pdo_stmt->execute();

            if ($pdo_stmt->rowCount() > 0) {
                $result = true;
            }

        }

        return $result;
        
    }


    
    public function undoTaskById(int $taskId) : bool {
        $result = false;

        // if the id is more than zero...
        if ($taskId > 0) {
            
            // $completed = false;
            
            $complete_task_sql = "UPDATE `tasks` SET completed = '0' WHERE id = '$taskId'";

            $pdo_stmt = $this->pdo->query($complete_task_sql);

            // $pdo_stmt->execute(array($completed, $taskId));

            // $pdo_stmt->bindParam(':completed', $completed);
            // $pdo_stmt->bindParam(':completed_at', $completed_at);
            // $pdo_stmt->bindParam(':taskId', $taskId);

            // $pdo_stmt->execute();

            if ($pdo_stmt->rowCount() > 0) {
                $result = true;
            }

        }

        return $result;
        
    }
    public function getAllTodoLists() : array {
        $result = array();

        $userId = $this->user->id;
        $pdo_stmt = $this->pdo->query("SELECT * FROM `todo_lists` WHERE user_id = '$userId' ORDER BY created_at DESC");
        $result = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }


    public function getAllTasks() : array {
        $result = array();

        $userId = $this->user->id;
        $pdo_stmt = $this->pdo->query("SELECT * FROM `tasks` WHERE user_id = '$userId'");
        $result = $pdo_stmt->fetchAll(PDO::FETCH_ASSOC);

        return $result;
    }

    /**
     * Method used to get the id of a to-do list with the given date
     * 
     * @param $date - The DATETIME value of the todo list
     */
    private function getTodoListIdByDate($date){
        $pdo_stmt = $this->pdo->query("SELECT id FROM `todo_lists` WHERE created_at = '$date'");
        $pdo_res = $pdo_stmt->fetch(PDO::FETCH_ASSOC);

        return $pdo_res['id'];
    }


    private function getCurrentDate() {
        return date('Y-m-d H:i:s');
    }

}