<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $student_id = $_POST["student_id"];
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $parent_name = $_POST["parent_name"];
    $class = $_POST["class"];
    $group_id = $_POST["group_id"];
    $lessons_number = $_POST["lessons_number"];
    $lessons_days = $_POST["lessons_days"];

    // Prepare and execute the SQL query to insert a new record
    $query = "UPDATE students SET surname='$surname',name='$name',parent_name='$parent_name',class='$class',group_id='$groupd_id',lessons_number='$lessons_number',lessons_days='$lessons_days' WHERE student_id='$student_id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        header("Location: students.php");
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
// Close the database connection
mysqli_close($conn);
?>