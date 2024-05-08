<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>IDZ</title>
    <script>
    function get_users(event) {
        event.preventDefault();
        const xhr = new XMLHttpRequest();
        xhr.open("GET", "get_users.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("users").innerHTML = xhr.responseText;
            }
        };
        xhr.send();
    }

    function add_user(event) {
        event.preventDefault();
        const username = document.getElementById("username").value;
        const password = document.getElementById("password").value;
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "add_users.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("result_reg").innerHTML = xhr.responseText;
            }
        };
        xhr.send(`username=${username}&password=${password}`);
    }

    function update_user(event) {
        event.preventDefault();
        const old_username = document.getElementById("old_username").value;
        const new_username = document.getElementById("new_username").value;
        const password = document.getElementById("new_password").value;
        const email = document.getElementById("new_email").value;
        const notes = document.getElementById("new_nodes").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "update_users.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("result_upd").innerHTML = xhr.responseText;
            }
        };
        xhr.send(`old_username=${old_username}&new_username=${new_username}&password=${password}&email=${email}&notes=${notes}`);
    }

    function remove_user(event) {
        event.preventDefault();
        const delete_username = document.getElementById("delete_username").value;

        const xhr = new XMLHttpRequest();
        xhr.open("POST", "remove_users.php");
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function() {
            if (xhr.readyState === 4 && xhr.status === 200) {
                document.getElementById("result_rem").innerHTML = xhr.responseText;
            }
        };
        xhr.send(`remove_username=${delete_username}`);
    }
    </script>
</head>
<body>

    <h2>User's list</h2>
    <br>
    <div id="users"></div>
    <br>
    <form id="form1" onsubmit="get_users(event)">
        <button type="submit">Get user's list</button>
    </form>

    <h2>Add new user</h2>
    <form id="form2" onsubmit="add_user(event)">
        <label for="username">Login:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <button type="submit">Add user</button>
    </form>
    <br>
    <div id="result_reg"></div>
    <br>

    <h2>Update user</h2>
    <form id="form3" onsubmit="update_user(event)">
        <label for="old_username">Old Login:</label>
        <input type="text" id="old_username" name="old_username" required><br>
        <label for="new_username">New Login:</label>
        <input type="text" id="new_username" name="new_username"><br>
        <label for="new_password">Password:</label>
        <input type="password" id="new_password" name="new_password"><br>
        <label for="new_email">Email:</label>
        <input type="text" id="new_email" name="new_email"><br>
        <label for="new_nodes">Nodes:</label>
        <input type="text" id="new_nodes" name="new_nodes"><br>
        <button type="submit">Update user</button>
    </form>
    <br>
    <div id="result_upd"></div>
    <br>

    <h2>Remove user</h2>
    <form id="form4" onsubmit="remove_user(event)">
        <label for="delete_username">Login:</label>
        <input type="text" id="delete_username" name="delete_username" required><br>
        <button type="submit">Remove</button>
    </form>
    <br>
    <div id="result_rem"></div>
    <br>
</body>
</html>