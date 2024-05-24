<?php
// Start the session
session_start();

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Include your database connection code here
    include "db_connection.php";

    // Get user input from the form
    $username = $_POST["login"];
    $password = $_POST["password"];

    // Validate input (you should add more validation and sanitization)
    if (empty($username) || empty($password)) {
        echo "Please enter both username and password.";
    } else {
        // Query the database to check if the user exists
        $query = "SELECT * FROM teachers WHERE login = '$username' AND password = '$password'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Check if a matching user is found
            if (mysqli_num_rows($result) == 1) {
                // Authentication successful, set session variables
                $_SESSION["username"] = $username;
                header("Location: main.php");
            } else {
                echo "<html><div id='error-message'>Неправильный логин или пароль.</div></html>";
            }
        } else {
            echo "Error: " . mysqli_error($conn);
        }

        // Close the database connection
        mysqli_close($conn);
    }
}
?>

<!DOCTYPE html><!--Подключение Пятой версии HTML-->
<html><!--Основные тэги-->
<head><!--Ссылки и подключения-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="viewport" content="width=1920, height=1080, initial-scale=1.0">
    <title>Авторизация</title><!--Название веб страницы-->
    <link rel="stylesheet" href="css/login.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
</head>
<body>
    <ul>
        <li><img src="images/logo.png" alt=""></li>
        <li><h1>AXIOMA STUDY</h1></li>
    </ul>
    <div class="login_form">
        <h2>Авторизация</h2>
        <hr color="black">
        <form action="" method="post">
            <label>Логин</label><br><br>
            <input type="text" name="login" required><br><br><br>

            <label>Пароль</label><br><br>
            <input type="password" name="password" required><br><br><br>

            <button type="submit">Авторизоваться</button>
        </form>
    </div>
    <div class="circle1"></div>
    <div class="circle2"></div>
    <div class="circle3"></div>
    <div class="circle4"></div>
    
</body>
</html>