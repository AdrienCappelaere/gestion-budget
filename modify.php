<?php
    include_once 'controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'controls/header.php';?>
    <title>WiteMoney | Modifier une transaction</title>

</head>

<body class="add">
    <h1>Modifier la transaction</h1>
    <?php get_form($conn); ?>

    <script>
        hide_revenu_category();
        delete_control();
    </script>

</body>
</html>