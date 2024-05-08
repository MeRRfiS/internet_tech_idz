<?php
require_once 'db_connection.php';

session_start();

if($_SERVER["REQUEST_METHOD"] == "POST"){
	$username = $_POST['username'];
    $password = $_POST['password'];

	$query = "SELECT * FROM users WHERE username = :username";

	$statement = $pdo->prepare($query);

	$statement->bindValue(':username', $username);

	$statement->execute();

	$user = $statement->fetch();

	if($user && password_verify($password, $user['password'])){
		$_SESSION['user_id'] = $user['id'];
        header("Location: user_data.php");
        exit();
	} else {
        echo "Not correct password or login";
    }
}

?>