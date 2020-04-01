<?php
    include_once 'functions.php';;
    
    $id_bank_operation = $_GET['id'];

    $sql = "DELETE FROM bankoperation
            WHERE id_bank_operation = $id_bank_operation";
    
    if (mysqli_query($conn, $sql) === true) {
        header("Location: ..");
    } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
    }
?>