<?php
session_start();
include "db_connect.php";

if (isset($_POST['username']) && isset($_POST['password'])) {
    function validate($data)
    {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data);
        return $data;
    }

    $username = validate($_POST['username']);
    $password = validate($_POST['password']);

    if (empty($password) || empty($username)) {
        $_SESSION['error'] = "Username and Password are required!";
        header("Location: index.php");
        exit();
    } else {
        // Use prepared statement to prevent SQL injection
        $query = "SELECT * FROM akun WHERE username = ? AND password = ?";
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ss", $username, $password);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);

        if ($result && mysqli_num_rows($result) === 1) {
            $row = mysqli_fetch_assoc($result);
            $_SESSION['username'] = $row['username'];
            $_SESSION['name'] = $row['name'];
            $_SESSION['id'] = $row['id'];

            // Set a cookie for the username
            setcookie('username', $row['username'], time() + (86400 * 30), "/"); // 86400 = 1 day

            header("Location: tokobarokah.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect Username and/or Password!";
            header("Location: index.php");
            exit();
        }
    }
} else {
    header("Location: index.php");
    exit();
}
