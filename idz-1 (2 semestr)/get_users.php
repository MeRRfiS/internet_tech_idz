<?php
require_once 'db_connection.php';

session_start();

if($_SERVER["REQUEST_METHOD"] == "GET"){
	$query = "SELECT * FROM user_data";

	$statement = $pdo->prepare($query);

	$statement->execute();

	$users = $statement->fetchAll(PDO::FETCH_ASSOC);

	if (count($users) > 0) {
        echo "<table border='1'>";
        echo "<tr><th>User Id</th><th>Login</th><th>Email</th><th>Notes</th></tr>";
        foreach ($users as $user) {
            echo "<tr>";
            echo "<td>" . $user['user_id'] . "</td>";
            echo "<td>" . $user['login'] . "</td>";
            echo "<td>" . $user['email'] . "</td>";
            echo "<td>" . $user['notes'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";
    } else {
        echo "Users not exist";
    }
}
?>