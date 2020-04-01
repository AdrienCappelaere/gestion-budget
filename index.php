<?php
    include_once 'controls/functions.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>WiteMoney | Gestion de votre budget</title>
    <script src="js/functions.js"></script>
    <link rel="icon" type="image/png" href="media/favicon.png"  />
</head>
<body>
    <header class="main-header">
        <h1 class="main-title">WiteMoney</h1>
        <p class="solde"><?php get_balance($conn); ?> €</p>
        <p class="solde-txt">Solde actuel</p>
    </header>
    <div class="m-flex">
        <main>
            <h2 class="trans-title">Transactions enregistrées</h2>
            <?php get_bankoperation($conn) ?>
        </main>

        <aside>
            <h2 class="add-home_title">Nouvelle entrée</h1>
            <?php get_form($conn); ?>
        </aside>
    </div>
    <?php get_nav(); ?>

    <script>
        set_date();
        hide_revenu_category();
        add_green();
    </script>

</body>
</html>