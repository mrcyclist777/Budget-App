<?php
session_start();

if ((!isset($_POST['login'])) || (!isset($_POST['password']))) {
    header('Location: index.php');
    exit();
}

require_once "config.php";
mysqli_report(MYSQLI_REPORT_STRICT);

try {
    $connection = new mysqli($host, $db_user, $db_password, $db_name);

    if ($connection->connect_errno != 0) {
        throw new Exception(mysqli_connect_errno());
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];

        $login = htmlentities($login, ENT_QUOTES, "UTF-8");

        if (
            $result = $connection->query(
                sprintf(
                    "SELECT * FROM users WHERE login='%s'",
                    mysqli_real_escape_string($connection, $login)
                )
            )
        ) {
            $how_many_users = $result->num_rows;
            if ($how_many_users > 0) {
                $row = $result->fetch_assoc();

                if (password_verify($password, $row['password'])) {
                    $_SESSION['user_logged'] = true;
                    $_SESSION['id'] = $row['id'];

                    //wrong login session
                    unset($_SESSION['error_login']);

                    //clean query's result
                    $result->free_result();
                    header('Location: home.php');

                } else {
                    $_SESSION['error_login'] = "Wrong login or password. Try again!";
                    header('Location: index.php');
                }
            } else {
                $_SESSION['error_login'] = "Wrong login or password. Try again!";
                header('Location: index.php');
            }
        } else {
            throw new Exception($connection->error);
        }
        $connection->close();
    }
} catch (Exception $e) {
    echo 'Problem with server. Please register in other time!';
}
?>