<?php
    include_once 'functions.php';
    include_once 'modify_function.php';
    
    $id_bank_operation = $modify_date_bank_operation;

    $sql = "DELETE FROM bankoperation
            WHERE id_bank_operation = $id_bank_operation";
    
    if (mysqli_query($conn, $sql) === true) {
        header("Location: ..");
    } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>