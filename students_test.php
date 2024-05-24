<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Студенты</title>
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
            <li><a href="teachers.php">Учители</a></li>
        </ul>
    </header>

<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Определение текущей страницы
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$start_from = ($page - 1) * $records_per_page;

// Получение данных из формы фильтрации
$filter = isset($_POST['filter']) ? strtolower($_POST['filter']) : '';
$group_filter = isset($_POST['group_filter']) ? strtolower($_POST['group_filter']) : '';

// Формирование запроса для подсчета общего количества записей с учетом фильтра
$count_query = "SELECT COUNT(*) AS total FROM students WHERE LOWER(name) LIKE '%$filter%' AND LOWER(group_id) LIKE '%$group_filter%'";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];

// Рассчет общего количества страниц
$total_pages = ceil($total_records / $records_per_page);

// Запрос для получения данных с учетом фильтра и пагинации
$query = "SELECT * FROM students WHERE LOWER(name) LIKE '%$filter%' AND LOWER(group_id) LIKE '%$group_filter%' LIMIT $start_from, $records_per_page";
$result = mysqli_query($conn, $query);

// Проверка на ошибки
if (!$result) {
    die("Error: " . mysqli_error($conn));
}

// Вывод данных в таблицу
echo "<h2>Ученики</h2>
      <table>
          <tr>
              <th class='id'>ID</th>
              <th>Фамилия</th>
              <th>Имя</th>
              <th>Родитель</th>
              <th>Класс</th>
              <th>Группа</th>
              <th>Кол-во уроков</th>
          </tr>";

while ($row = mysqli_fetch_assoc($result)) {
    echo "<tr>
              <td>{$row['student_id']}</td>
              <td>{$row['surname']}</td>
              <td>{$row['name']}</td>
              <td>{$row['parent_name']}</td>
              <td>{$row['class']}</td>
              <td>{$row['group_id']}</td>
              <td>{$row['lessons_number']}</td><td>"
echo "<form method='post' action='update.php'>";
        echo "<input type='hidden' name='id' value='" . $row["student_id"] . "'>";
        echo "<input type='checkbox' name='value' value='1' " . ($row["freeze"] == 1 ? "checked" : "") . " onchange='this.form.submit();'>";
        echo "</form>";
        echo "</td>";  
    echo "</tr>";
}

echo "</table>";
    
$id = $_POST['student_id'];
$value = $_POST['freeze'];
    
$sql = "UPDATE students SET value='$value' WHERE id='$id'";
// Пагинация
echo "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a href='students.php?page=" . $i . "&filter=" . urlencode($filter) . "&group_filter=" . urlencode($group_filter) . "'>" . $i . "</a> ";
}
echo "</div>";

// Закрытие соединения с базой данных
mysqli_close($conn);
?>
    <button onclick="openModal()">Добавить ученика</button>

    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Добавить</h2>
            <form method="post" action="insert_student.php">

                <label for="name">Фамилия:</label><br>
                <input class="input" type="text" name="surname"><br>
                
                <label for="name">Имя:</label><br>
                <input class="input" type="text" name="name"><br>
                
                <label for="name">Имя родителя:</label><br>
                <input class="input" type="text" name="parent_name"><br>
                
                <label for="class">Класс:</label><br>
                <input class="input" type="text" name="class"><br>
                
                <label for="group">Группа:</label><br>
                <input class="input" type="text" name="group"><br>
                
                <label for="group">Кол-во уроков:</label><br>
                <input class="input" type="text" name="lessons_number"><br>
                
                <label for="group">Дни уроков:</label><br>
                <input class="input" type="text" name="lessons_days"><br>

                <input type="submit" value="Добавить">
            </form>
        </div>
    </div>
    <button onclick="openModal1()">Изменить кол-во уроков</button>

    <div id="myModal1" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal1()">&times;</span>
            <h2>Изменить</h2>
            <form method="post" action="update_lessonsnumber.php">

                <label for="name">ID ученика:</label><br>
                <input class="input" type="text" name="student_id"><br>
                
                <label for="name">Кол-во уроков:</label><br>
                <input class="input" type="text" name="lessons_number"><br>

                <input type="submit" value="Изменить">
            </form>
        </div>
    </div>
    
    <button onclick="openModal2()">Фильтры</button>
    
    <div id="myModal2" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal2()">&times;</span>
            <form method="post" action="">
                <label for="filter">Фильтр по имени:</label>
                <input type="text" id="filter" name="filter"><br>
                <label for="group_filter">Фильтр по группе:</label>
                <input type="text" id="group_filter" name="group_filter"><br>
                <input type="submit" value="Применить фильтр">
            </form>
        </div>
    </div>
    <button onclick="openModal3()">Изменить группу</button>
    
    <div id="myModal3" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal3()">&times;</span>
            <form method="post" action="update_groupid.php">
                <label for="name">ID ученика:</label><br>
                <input class="input" type="text" name="student_id"><br>
                
                <label for="name">Кол-во уроков:</label><br>
                <input class="input" type="text" name="group_id"><br>
                <input type="submit" value="Применить фильтр">
            </form>
        </div>
    </div>
<script src="js/script.js"></script>
    
</body>
</html>