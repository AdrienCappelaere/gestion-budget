<?php
    include_once '../controls/functions.php'; 
    include_once '../controls/modify_function.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <script src="../js/functions.js"></script>

    <title>BankMoney | Modifier une transaction</title>
    <link rel="icon" type="image/png" href="../media/favicon.png"  />
</head>

<body class="add">
    <h1>Modifier la transaction</h1>
    <?php modify_bankoperation($conn,$modify_date_bank_operation); ?>

    <script src="../js/index.js"></script>
    <script src="../js/modify.js"></script>

</body>
</html>