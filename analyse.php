<?php
    include_once 'controls/functions.php'; ?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="style/style.css">
    <title>WiteMoney | Analyse de votre budget</title>
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
            <form action="controls/bankoperation.php" method="POST" class="add-home_form">

                <div>
                    <label for="type_id" class="mandatory">
                        <h2 class="form-title">Type de saisie</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="input-type">
                    <p class="input-type-txt red">Sortie d'argent</p>
                        <label class="switch">
                            <input  type="checkbox" name="type_id" onclick="get_type();" id="switch">
                            <span class="slider round">
                            </span>
                        </label>
                    <p class="input-type-txt green">Entrée d'argent</p>
                    </div>
                </div>
                <div>
                    <label for="description" class="mandatory">
                        <h2 class="form-title">Description</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="text" class="entry-form" name="description" required maxlength="30">
                    </div>
                </div>
                <div>
                    <label for="amount" class="mandatory">
                        <h2 class="form-title">Montant</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="number" class="entry-form" name="amount" step="0.01" required>
                    </div>
                </div>
                <div>
                    <label for="date" class="mandatory">
                        <h2 class="form-title">Date</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="date" id="datefield" name="date" class="entry-form" required>
                    </div>
                </div>
                <div>
                    <label for="category" class="mandatory">
                        <h2 class="form-title">Catégorie</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <select name="category" class="entry-form" required>
                            <?php get_category($conn); ?>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="paid_with" class="mandatory">
                        <h2 class="form-title">Moyen de paiement</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <ul class="paidwith-ul">
                            <?php get_paid_with($conn) ?>
                        </ul>
                    </div>
                </div>
                <div class="trans-btn">
                    <a href="..">
                        <img src="media/invalidate.svg" alt="" class="btn-invalidate">
                    </a>
                    <button type="submit" name="submit" class="submit-btn">
                            <img src="media/validate.svg" alt="" class="btn-validate">
                    </button>
                </div>
            </form>
        </aside>
    </div>

    <?php get_nav(); ?>

    <script src="js/index.js"></script>
    <script src="js/add.js"></script>
</body>
</html>