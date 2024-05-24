<?php
// Assuming you've connected to your database already
include "db_connection.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $student_id = $_GET['id'];

    // Perform a query to retrieve group details based on the group_id
    $query = "SELECT * FROM students WHERE student_id = '$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result && $row = mysqli_fetch_assoc($result)) {

      echo "<!DOCTYPE html>
      <html lang='ru'>
      <head>
          <meta charset='UTF-8'>
          <meta name='viewport' content='width=device-width, initial-scale=1.0'>
          <title>Ученик {$student_id}</title>
      </head>
      <body>
          <h2>Форма изменений</h2>
          ";
        
        // You can also include HTML templates, additional styling, etc.
    } else {
        // Handle case when no matching group is found
        echo "<p>Group not found</p>";
    }
} else {
    // Handle case when 'id' parameter is not set
    echo "<p>Invalid request</p>";
}
?>

<!DOCTYPE html>
<html lang='ru'>
    <head>
        <link href="css/styles.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <link href="css/tables.css" rel="stylesheet">
    </head>
    <body>
    <form action="edit_student.php" method="post" style="text-align:center">
        <input type="hidden" name="student_id" value="<?php echo $row['student_id']; ?>">
        <label for="name">Фамилия:</label><br>
        <input type="text" id="surname" name="surname" value="<?php echo $row['surname']; ?>"><br>
        <label for="name">Имя:</label><br>
        <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>"><br>
        <label for="name">Имя родителя:</label><br>
        <input type="text" id="parent_name" name="parent_name" value="<?php echo $row['parent_name']; ?>"><br>
        <label for="name">Класс:</label><br>
        <input type="text" id="class" name="class" value="<?php echo $row['class']; ?>"><br>
        <label for="name">Группа:</label><br>
        <input type="text" id="group_id" name="group_id" value="<?php echo $row['group_id']; ?>"><br>
        <label for="name">Кол-во уроков:</label><br>
        <input type="text" id="lessons_number" name="lessons_number" value="<?php echo $row['lessons_number']; ?>"><br>
        <label for="name">Дни уроков:</label><br>
        <input type="text" id="lessons_days" name="lessons_days" value="<?php echo $row['lessons_days']; ?>"><br>
        <input type="submit" value="Изменить">
    </form>
    </body>
</html>