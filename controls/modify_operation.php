<?php
    include_once '../controls/functions.php';

    $type_id = mysqli_real_escape_string($conn, get_type_id());  
    $amount = mysqli_real_escape_string($conn, get_amount());
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $paid_with = mysqli_real_escape_string($conn, $_POST['paid_with']);
    $description = mysqli_real_escape_string($conn, htmlspecialchars($_POST['description'], ENT_QUOTES));
    $id_bank_operation = mysqli_real_escape_string($conn, $_GET['id']);

    $sql = "UPDATE bankoperation
            SET type_id = $type_id,
                amount = $amount,
                date_bank_operation = '$date',
                category = $category,
                paid_with = $paid_with,
                description = '$description'
            WHERE id_bank_operation = '$id_bank_operation'";
    
    if (mysqli_query($conn, $sql) === true) {
        header("Location: ..");
    } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>