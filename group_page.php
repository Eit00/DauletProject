<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <?php
    // Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);
    // Assuming you've connected to your database already
    include "db_connection.php";

    // Check if the 'id' parameter is set in the URL
    if (isset($_GET['id'])) {
        $groupId = $_GET['id'];

        // Perform a query to retrieve group details based on the group_id
        $query = $conn->prepare("SELECT students.student_id, students.surname, students.name, students.class, students.lessons_number, groups.subject, groups.group_id, groups.teacher_id FROM students INNER JOIN `groups` ON students.group_id=`groups`.group_id WHERE students.group_id = ?");
        $query->bind_param("s", $groupId);
        $query->execute();
        $result = $query->get_result();

        if ($result && mysqli_num_rows($result) > 0) {
            // Fetch the first row for the group details
            $groupDetails = mysqli_fetch_assoc($result);

            // Display group details
            echo "<title>Группа {$groupId}</title>";
            echo "<link href='css/styles.css' rel='stylesheet'>
        <link href='css/style.css' rel='stylesheet'>
        <link href='css/tables.css' rel='stylesheet'>";
            echo "</head><body>    
            <header>
                <ul>
                    <li><img src='images/logo.png'></li>
                    <li><a href='main.php'><h1>Axioma Study</h1></a></li>
                    <li><a href='groups.php'>Группы</a></li>
                    <li><a href='students.php'>Ученики</a></li>
                    <li><a href='teachers.php'>Учители</a></li>
                </ul>
            </header>";  // Close the head and open the body
            echo "<h1>{$groupDetails['subject']} (ID группы: {$groupDetails['group_id']})</h1>";
            echo "<p>ID учителя: {$groupDetails['teacher_id']}</p>";
            
            echo "<table border='1'>
                      <tr>
                          <th>ID</th>
                          <th>Фамилия</th>
                          <th>Имя</th>
                          <th>Класс</th>
                          <th>Кол-во уроков</th>
                      </tr>";

            // Reset the pointer and loop through the results to display each student
            mysqli_data_seek($result, 0);
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                          <td>{$row['student_id']}</td>
                          <td>{$row['surname']}</td>
                          <td>{$row['name']}</td>
                          <td>{$row['class']}</td>
                          <td>{$row['lessons_number']}</td>
                      </tr>";
            }
            echo "</table>";
        } else {
            // Handle case when no matching group is found
            echo "<title>Group Not Found</title>";
            echo "</head><body>";  // Close the head and open the body
            echo "<p>Group not found</p>";
        }
    } else {
        // Handle case when 'id' parameter is not set
        echo "<title>Invalid Request</title>";
        echo "</head><body>";  // Close the head and open the body
        echo "<p>Invalid request</p>";
    }
    ?>
</body>
</html>