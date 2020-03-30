<?php
    include_once '../controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../style/style.css">
    <title>BankMoney - Gestion de votre budget</title>
    <script src="../js/functions.js"></script>
    <link rel="icon" type="image/png" href="../media/favicon.png"  />
</head>
<body>
    <header class="main-header">
        <h1 class="main-title">Bank Money</h1>
        <p class="solde"><?php get_balance($conn); ?> €</p>
        <p class="solde-txt">Solde</p>
    </header>
    <main>
        <?php get_bankoperation($conn) ?>
    </main>
    <a href="/budget-lpdwca/views/add.php">
        <button class="add-trans">
            <img src="../media/add.svg" alt="">
            <p>Ajouter une entrée</p>
        </button>
    </a>
    <nav class="main-nav">
        <div class="nav-bloc">
            <img src="../media/account.svg" alt="" class="nav-icon is-active">
            <p class="nav-txt is-active">Comptes</p>
        </div>
        <div class="nav-bloc">
            <img src="../media/analyse.svg" alt="" class="nav-icon">
            <p class="nav-txt">Analyses</p>
        </div>
        <div class="nav-bloc">
            <img src="../media/virement.svg" alt="" class="nav-icon">
            <p class="nav-txt">Virement</p>
        </div>
        <div class="nav-bloc">
            <img src="../media/alertes.svg" alt="" class="nav-icon">
            <p class="nav-txt">Alertes</p>
        </div>
        <div class="nav-bloc">
            <img src="../media/menu.svg" alt="" class="nav-icon">
            <p class="nav-txt">Menu</p>
        </div>
    </nav>


    
    <script src="../js/index.js"></script>
</body>
</html>