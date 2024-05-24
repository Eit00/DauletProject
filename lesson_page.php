<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="css/lesson_form.css">
    <link rel="stylesheet" href="css/style.css">
  <title>Форма урока</title>
</head>
<body>
    <header>
        <ul>
            <li><img src="images/logo.png"></li>
            <li><a href="main.php"><h1>Axioma Study</h1></a></li>
            <li><a href="groups.php">Группы</a></li>
            <li><a href="students.php">Ученики</a></li>
            <li><a href="teachers.php">Учители</a></li>
        </ul>
    </header>
<?php
// Assuming you've connected to your database already
include "db_connection.php";

// Check if the 'id' parameter is set in the URL
if (isset($_GET['id'])) {
    $groupId = $_GET['id'];

    // Perform a query to retrieve group details based on the group_id
    $query = "SELECT * FROM students INNER JOIN groups ON students.group_id=groups.group_id WHERE students.group_id = '$groupId'";
    $result = mysqli_query($conn, $query);
    $query_teach="SELECT groups.subject,groups.group_id,teachers.teacher_id,teachers.surname,teachers.name FROM teachers INNER JOIN groups ON teachers.teacher_id=groups.teacher_id WHERE groups.group_id='$groupId'";
    $result_teach=mysqli_query($conn, $query_teach);

    if ($result_teach && $row = mysqli_fetch_assoc($result_teach)) {

    }
}
?>
  <form action="insert_lesson.php" method="post">
    
    <input type="number" name="teacher_id" value="<?php echo $row['teacher_id']; ?>" hidden>
    <label>Группа:</label><label><?php echo $row['group_id']; ?></label><br><br>
    <input type="text" name="group_id" value="<?php echo $row['group_id']; ?>" hidden>
    <label for="lessonDate">Дата урока:</label><label><?php echo date('Y-m-d'); ?></label>
    <input type="date" id="lessonDate" name="lessonDate" value="<?php echo date('Y-m-d'); ?>" hidden><br><br>
    <h2>Список учеников:</h2>
    <table>
        <tr>
            <th>№</th>
            <th>ФИО ребенка</th>
            <th>Присутствовал</th>
            <th>Д/з</th>
            <th>Активность</th>
            <th>Комментарии</th>
        </tr>
    <?php
      $id =1;
      if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
          echo '<tr><label><td>';
          echo $id;
          echo '</td><td>';
          echo $row['surname'];
          echo $row['name'];
          echo '</label></td>';
          echo '<input type="number" name="student_id" value="' . $row['student_id'] . '" hidden>';
          echo '<td><input type="checkbox" name="status"></td><br>';
          $id++;
        }
      } else {
        echo "Нет учеников в указанной группе";
      }

      // Закрытие соединения
      $conn->close();
    ?>
    </table>
    <input type="submit" value="Отправить">
  </form>
</body>
</html>