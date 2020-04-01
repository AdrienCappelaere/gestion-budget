<?php
    include_once '../controls/functions.php';
    include_once '../controls/modify_function.php';

    $type_id = get_type_id();  
    $amount = get_amount();
    $date = $_POST['date'];
    $category = $_POST['category'];
    $paid_with = $_POST['paid_with'];
    $description = htmlspecialchars($_POST['description'], ENT_QUOTES);
    $id_bank_operation = $modify_date_bank_operation;

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