<?php
require_once 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $old_username = $_POST['old_username'];
    $new_username = $_POST['new_username'];
    $password = $_POST['password'];
    $email = $_POST['email'];
    $notes = $_POST['notes'];

	$queryCheck = "SELECT * FROM users WHERE username = :old_username";
    $queryUpdate = "UPDATE users SET username = :new_username, password = :password WHERE id = :id";
    $queryUpdateData = "UPDATE user_data SET login = :new_username, email = :email, notes = :notes WHERE user_id = :id";

	$statement = $pdo->prepare($queryCheck);
    $statement->bindValue(':old_username', $old_username);
    $statement->execute();
	$old_user = $statement->fetch();

    if($old_user){
        $statement = $pdo->prepare($queryUpdate);
        $statement->bindValue(':new_username', $new_username ? $new_username : $old_username);
        $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
        $statement->bindValue(':id', $old_user['id']);
        $statement->execute();

        $statement = $pdo->prepare($queryUpdateData);
        $statement->bindValue(':new_username', $new_username ? $new_username : $old_username);
        $statement->bindValue(':email', $email);
        $statement->bindValue(':notes', $notes);
        $statement->bindValue(':id', $old_user['id']);
        $statement->execute();

	    echo "User's data was update";
    }
    else{
        echo "User not exist";
    }
}
?>