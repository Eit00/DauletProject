<?php
// Include your database connection code here (e.g., db_connection.php)
include "db_connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $teacher_id = $_POST['teacher_id'];
    $group_id = $_POST['group_id'];
    $lesson_date = $_POST['lessonDate'];

    $student_ids = is_array($_POST['student_id']) ? $_POST['student_id'] : array($_POST['student_id']);

    // Initialize $stmt outside the loop
    $insert_query = "INSERT INTO lessons (teacher_id, student_id, status, group_id, lesson_date) 
                                VALUES (?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $insert_query);

    // Check for errors
    if (!$stmt) {
        die("Error in preparing statement: " . mysqli_error($conn));
    }
    
    // Loop through the submitted data
    foreach ($student_ids as $student_id) {
        // Assume 'status' and 'comment' are the names of your checkboxes and text areas
        $status = isset($_POST['status'][$student_id]) ? 1 : 0;

        mysqli_stmt_bind_param($stmt, 'iiiss', $teacher_id, $student_id,$status, $group_id, $lesson_date);
        // Execute the statement
        mysqli_stmt_execute($stmt);

        // Check for errors
        if (mysqli_errno($conn) !== 0) {
            die("Error in executing statement: " . mysqli_error($conn));
        }
        mysqli_stmt_reset($stmt);
    }

    // Close the prepared statement outside the loop
    mysqli_stmt_close($stmt);

    // Redirect to the page after inserting data
    header("Location: groups.php");
    exit();
}
?>