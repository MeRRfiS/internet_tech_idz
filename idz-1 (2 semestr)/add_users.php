<?php
require_once 'db_connection.php';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $username = $_POST['username'];
    $password = $_POST['password'];

	$queryCheck = "SELECT * FROM users WHERE username = :username";
    $queryGetId = "SELECT * FROM users ORDER BY id DESC LIMIT 1";
    $queryAddUser = "INSERT INTO users (username, password) VALUES(:username, :password)";
    $queryAddUserData = "INSERT INTO user_data (user_id, login) VALUES(:id, :username)";

	$statement = $pdo->prepare($queryCheck);
    $statement->bindValue(':username', $username);
    $statement->execute();
	$user = $statement->fetch();

    if($user){
        echo "Login already exist";
        exit();
    }

    $statement = $pdo->prepare($queryAddUser);
    $statement->bindValue(':username', $username);
    $statement->bindValue(':password', password_hash($password, PASSWORD_DEFAULT));
    $statement->execute();

    $statement = $pdo->prepare($queryGetId);
    $statement->execute();
    $user = $statement->fetch();

    $statement = $pdo->prepare($queryAddUserData);
    $statement->bindValue(':id', $user['id']);
    $statement->bindValue(':username', $username);
    $statement->execute();

	echo "New user was added";
}
?>