<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get user input from the form
    $surname = $_POST["surname"];
    $name = $_POST["name"];
    $parent_name = $_POST["parent_name"];
    $class = $_POST["class"];
    $group = $_POST["group"];
    $lessons_number=$_POST["lessons_number"];
    $lessons_days=$_POST["lessons_days"];

    // Prepare and execute the SQL query to insert a new record
    $query = "INSERT INTO students (surname, name, class,parent_name, group_id,lessons_number,lessons_days) VALUES ('$surname', '$name','$parent_name', '$class', '$group',$lessons_number,$lessons_days)";
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