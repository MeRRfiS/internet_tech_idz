<?php
session_start();
require_once 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $remove_username = $_POST['remove_username'];

	$queryCheck = "SELECT * FROM users WHERE username = :remove_username";
    $queryDeleteData = "DELETE FROM user_data WHERE user_id = :id";
    $queryDelete = "DELETE FROM users WHERE id = :id";

	$statement = $pdo->prepare($queryCheck);
    $statement->bindValue(':remove_username', $remove_username);
    $statement->execute();
	$user = $statement->fetch();

    if($user){
        if($user['id'] == $_SESSION['user_id']){
            echo "You can't remove auth user";
            exit();
        }

        $statement = $pdo->prepare($queryDeleteData);
        $statement->bindValue(':id', $user['id']);
        $statement->execute();

        $statement = $pdo->prepare($queryDelete);
        $statement->bindValue(':id', $user['id']);
        $statement->execute();

	    echo "User was delete";
    }
    else{
        echo "User not exist";
    }
}
?>