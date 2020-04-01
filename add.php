<?php
    include_once 'controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <script src="js/functions.js"></script>
    <title>WiteMoney | Créer une nouvelle transaction</title>
    <link rel="icon" type="image/png" href="media/favicon.png"  />
</head>

<body class="add">
    <h1>Nouvelle entrée</h1>
    <?php get_form($conn) ?>
    
    
    <script src="js/add.js"></script>

</body>
</html>