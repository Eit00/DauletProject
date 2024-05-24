

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Учители</title>
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
</head>
<body>
    <header>
        <ul>
            <li><img src="images/logo.png"></li>
            <li><a href="main.php"><h1>Axioma Study</h1></a></li>
            <li><a href="groups.php">Группы</a></li>
            <li><a href="students.php">Ученики</a></li>
            <li><a class="li-active" href="teachers.php">Учители</a></li>
        </ul>
    </header>
<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Fetch data from the table
$query = "SELECT * FROM teachers";
$result = mysqli_query($conn, $query);

// Check for errors
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Start HTML output
echo "<h2>Учители</h2>
          <table>
              <tr>
                  <th class='id'>ID</th>
                  <th>Фамилия</th>
                  <th>Имя</th>
                  <th>Предмет</th>
                  <th>Ставка</th>
                  <th>Дни занятий</th>
                  <th>Уроков в месяц</th>
              </tr>";

// Loop through the results and display each row in the table
while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
              <td>{$row['teacher_id']}</td>
              <td>{$row['surname']}</td>
              <td>{$row['name']}</td>
              <td>{$row['subject']}</td>
              <td>{$row['stavka']}</td>
              <td>{$row['weekdays']}</td>
              <td>{$row['total_lessons_per_month']}</td>
          </tr>";
}

// Close the HTML table
echo "</table>";



// Close the database connection
mysqli_close($conn);
?>
    <button onclick="openModal()">Добавить</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Добавить</h2>
            <form id="addRecordForm" method="post" action="insert_teacher.php">
                <label for="surname">Surname:</label><br>
                <input class="input" type="text" name="surname" required><br>

                <label for="name">Name:</label><br>
                <input class="input" type="text" name="name" required><br>
                
                <label for="subject">Subject:</label><br>
                <input class="input" type="text" name="subject" required><br>
                
                <label for="login">Login:</label><br>
                <input class="input" type="text" name="login" required><br>
                
                <label for="password">Password:</label><br>
                <input class="input" type="text" name="password" required><br>

                <input type="submit" value="Add Record">
            </form>
        </div>
    </div>

<script src="js/script.js"></script>
</body>
</html>