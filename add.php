<?php
    include_once 'controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'controls/header.php';?>
    <title>WiteMoney | Créer une nouvelle transaction</title>
</head>

<body class="add">
    <h1>Nouvelle entrée</h1>
    <?php get_form($conn) ?>
    
    <script>
        set_date();
        hide_revenu_category();
    </script>
</body>
</html>