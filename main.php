<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    exit();
}


// You can add more content or functionality for the logged-in users here
?>

<!DOCTYPE html><!--Подключение Пятой версии HTML-->
<html><!--Основные тэги-->
<head><!--Ссылки и подключения-->
    <meta charset="utf-8">
    <title>Основная страница</title><!--Название веб страницы-->
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/tables.css">
    <link rel="stylesheet" href="css/styles.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Black+Han+Sans&display=swap">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap">
    <style>
    #popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      padding: 20px;
      background-color: #fff;
      border: 1px solid #ccc;
      box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
      z-index: 1;
    }

    #overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background-color: rgba(0, 0, 0, 0.7);
      z-index: 0;
    }

    #close-btn {
      position: absolute;
      top: 10px;
      right: 10px;
      cursor: pointer;
    }
    </style>
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
include "db_connection.php";

// Определение текущей страницы
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$records_per_page = 10;
$start_from = ($page - 1) * $records_per_page;

// Формирование запроса для подсчета общего количества записей с учетом фильтра
$count_query = "SELECT COUNT(*) AS total FROM students WHERE lessons_number<=2";
$count_result = mysqli_query($conn, $count_query);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];

// Рассчет общего количества страниц
$total_pages = ceil($total_records / $records_per_page);

// Fetch data from the table
$query = "SELECT * FROM students WHERE lessons_number<=2 LIMIT $start_from, $records_per_page";
$result = mysqli_query($conn, $query);
  // Assume $result is your database query result

  echo "<h2>Красные</h2>
  <table class='red_students'>
              <tr>
                  <th class='id'>ID</th>
                  <th>Фамилия</th>
                  <th>Имя</th>
                  <th>Класс</th>
                  <th>Группа</th>
                  <th>Кол-во уроков</th>
              </tr>";

  // Loop through the results and display each row in the table
  while ($row = mysqli_fetch_assoc($result)) {
      echo "<tr>
                <td>{$row['student_id']}</td>
                <td>{$row['surname']}</td>
                <td>{$row['name']}</td>
                <td>{$row['class']}</td>
                <td>{$row['group_id']}</td>
                <td>{$row['lessons_number']}</td>
            </tr>";
  }

  // Close the HTML table and PHP block
  echo "</table>
        </div>";
            
// Пагинация
echo "<div class='pagination'>";
for ($i = 1; $i <= $total_pages; $i++) {
    echo "<a class='pagination-link' href='main.php?page=" . $i . "'>" . $i . "</a> ";
}
echo "</div>";
  mysqli_close($conn);
?>

<script src="js/script.js"></script>
<script>
    // Функция для загрузки содержимого страницы асинхронно
    function loadPage(page) {
        // Используем AJAX запрос для загрузки содержимого страницы
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "main.php?page=" + page, true);
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                // Вставляем полученное содержимое внутрь всплывающего окна
                var popupContents = document.getElementsByClassName("modal-content");
                for (var i = 0; i < popupContents.length; i++) {
                    popupContents[i].innerHTML = xhr.responseText;
                }
            }
        };
        xhr.send();
    }

    // Обработчик клика на ссылке пагинации
    document.addEventListener("click", function(event) {
        if (event.target.matches(".pagination-link")) {
            // Предотвращаем переход по ссылке по умолчанию
            event.preventDefault();
            // Получаем номер страницы из атрибута href ссылки
            var page = event.target.getAttribute("href").split("=")[1];
            // Загружаем содержимое страницы
            loadPage(page);
        }
    });
</script>
</body>
</html>