<?php
    include_once 'controls/functions.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'controls/header.php';?>
    <title>WiteMoney | Gestion de votre budget</title>
</head>
<body>
    <header class="main-header">
        <h1 class="main-title">WiteMoney</h1>
        <p class="solde"><?php get_balance($conn); ?> €</p>
        <p class="solde-txt">Solde actuel</p>
    </header>
    <div class="m-flex">
        <main>
            <h2 class="trans-title">Transactions par
                <select name="tri" onchange="location = this.value;" class="tri-select">
                    <option name="option-tri" value="?filtre=on_date" onclick="get_tri();">date</option>
                    <option name="option-tri" value="?filtre=on_category" onclick="get_tri();">catégorie</option>
                </select>
            </h2>
            <?php get_bankoperation_type($conn) ?>
        </main>

        <aside class="analysis-aside">
            <?php get_chart_data($conn) ?>
            <div class="canvas">
                <canvas id="myChart"></canvas>
            </div>
        </aside>
    </div>
    <?php get_nav(); ?>

    <script>
        hide_revenu_category();
        add_green();
        get_tri();
        get_chart();
    </script>

</body>
</html>