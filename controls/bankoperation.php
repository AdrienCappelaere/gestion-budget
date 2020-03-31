<?php
    include_once '../controls/functions.php';

    $type_id = get_type_id();  
    $amount = get_amount();
    $date = $_POST['date'];
    $category = $_POST['category'];
    $paid_with = $_POST['paid_with'];
    $description = $_POST['description'];

    $sql = "INSERT INTO bankoperation (type_id, amount, date_bank_operation, category, paid_with, description)
            VALUES ($type_id, $amount, '$date', $category, $paid_with, '$description');";
    
    if (mysqli_query($conn, $sql) === true) {
        header("Location: ..");
    } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>