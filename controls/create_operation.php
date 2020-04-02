<?php
    include_once 'functions.php';

    $type_id = mysqli_real_escape_string($conn, get_type_id());   
    $amount =  mysqli_real_escape_string($conn, get_amount());
    $date =  mysqli_real_escape_string($conn, $_POST['date']); 
    $category =  mysqli_real_escape_string($conn, $_POST['category']); 
    $paid_with =  mysqli_real_escape_string($conn, $_POST['paid_with']); 
    $description =  mysqli_real_escape_string($conn, htmlspecialchars($_POST['description'], ENT_QUOTES)); 

    $sql = "INSERT INTO bankoperation (type_id, amount, date_bank_operation, category, paid_with, description)
            VALUES ($type_id, $amount, '$date', $category, $paid_with, '$description');";
    
    if (mysqli_query($conn, $sql) === true) {
        header("Location: ..");
    } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>