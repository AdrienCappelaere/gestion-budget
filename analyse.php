<?php
    include_once 'controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'controls/header.php';?>
    <title>WiteMoney | Analyse de votre budget</title>

</head>
<body>
    <header class="main-header">
        <h1 class="main-title">WiteMoney</h1>
        <p class="solde"><?php get_balance($conn); ?> €</p>
        <p class="solde-txt">Solde actuel</p>
    </header>
    <div class="m-flex">
        <main>
            <h2 class="trans-title">Transactions par catégorie</h2>
            <?php get_bankoperation_type($conn) ?>
        </main>

        <aside class="analysis-aside">
            <?php get_chart_data($conn) ?>
            <div class="canvas">
                <canvas id="myChart"></canvas>
                <script>get_chart();</script>
            </div>
        </aside>
    </div>
    <?php get_nav(); ?>

    <script src="js/index.js"></script>
    <script src="js/add.js"></script>
    

</body>
</html>