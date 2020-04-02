<?php include_once 'controls/functions.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <?php include_once 'controls/header.php';?>
    <title>WiteMoney | Gestion de votre budget</title>
</head>
<body>
    <header class="main-header">
        <h1 class="main-title">WiteMoney</h1>
        <p class="solde"><?php get_balance($conn);?> €</p>
        <p class="solde-txt">Solde actuel</p>
    </header>
    <div class="m-flex">
        <main class="main-index">
            <?php get_bankoperation_type($conn) ?>
        </main>
        <aside>
            <?php get_chart_total($conn) ?>
            <?php get_chart_category($conn) ?>
        </aside>
    </div>
    <?php get_nav(); ?>

    <script>
        hide_revenu_category();
        add_green();
        get_tri();
        get_chart($category,$data);
        get_chart_total($date,$data_solde,$revenu,$depense);
    </script>
</body>
</html>