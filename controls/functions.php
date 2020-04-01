<?php

include_once 'dbdata.php';

$conn = new mysqli($dbServername, $dbUsername, $dbPassword ,$dbName);
if ($conn->connect_errno) {
    echo "Echec lors de la connexion à MySQL : (" . $conn->connect_errno . ") " . $conn->connect_error;
}

function get_category($conn) {
    $sql = "SELECT category.id_category, category.name, category.type_id FROM category";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?> <option value="<?php echo utf8_encode($row['id_category']); ?>" name="select" class="<?php echo utf8_encode($row['type_id']); ?>" id=""><?php echo utf8_encode($row['name']); ?></option> <?php
}}}

function get_paid_with($conn) {
    $sql = "SELECT paidwith.name, paidwith.id_paid_with FROM paidwith";
    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            ?>  <li class="li-paidwith">
                    <input type="radio" id="title_<?php echo utf8_encode($row['id_paid_with']); ?>" name="paid_with" value="<?php echo utf8_encode($row['id_paid_with']); ?>" required class="input-paidwith">
                    <label for="title_<?php echo utf8_encode($row['id_paid_with']); ?>" value="<?php echo utf8_encode($row['id_paid_with']); ?>"><?php echo utf8_encode($row['name']); ?></label>
                </li> <?php
}}}

function get_type_id() {
    if (isset($_POST['type_id'])) {
        return 2;
    } else {
        return 1;
    }
}

function get_amount() {
    if (isset($_POST['type_id'])) {
        return $_POST['amount'];
    } else {
        return $_POST['amount']*-1;
    }
}

function get_balance($conn) {
    $sql = 'SELECT SUM(bankoperation.amount) AS value_sum FROM bankoperation';
    $result = mysqli_query($conn, $sql); 
    $row = mysqli_fetch_assoc($result); 
    $sum = $row['value_sum'];
    echo round($sum,2);
}

function get_bankoperation($conn) {

    $sql_cat = "SELECT  bankoperation.id_bank_operation,
                        bankoperation.description,
                        bankoperation.amount,
                        bankoperation.type_id,
                        bankoperation.date_bank_operation,
                        bankoperation.category,
                        bankoperation.paid_with,
                        category.id_category,
                        paidwith.id_paid_with,
                        category.name as catname,
                        paidwith.name as paidwithname
                FROM    bankoperation
                INNER JOIN category ON bankoperation.category = category.id_category
                INNER JOIN paidwith ON bankoperation.paid_with = paidwith.id_paid_with
                ORDER BY date_bank_operation DESC";
    $result = mysqli_query($conn, $sql_cat);
    $resultCheck = mysqli_num_rows($result);

    $date = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if($row['date_bank_operation'] !== $date) {
                $date = $row['date_bank_operation'];
                setlocale(LC_TIME, "fr_FR", "French");
                $date_fr = strftime('%d %B %Y', strtotime($date));
                ?> <p class="date"><?php  echo utf8_encode($date_fr); ?> </p> <?php
            }

            $description = $row['description'];
            $amount = $row['amount'];
            $paidwith = $row['paid_with'];
            $type_id = $row['type_id'];
            $id_bank_operation = $row['id_bank_operation'];
            $category = $row['catname'];
            $paidwith = $row['paidwithname'];

            ?>
            <a href="modify.php?id=<?php echo $id_bank_operation ?>">
            <div class="transaction">
                <img src="media/<?php echo $type_id ?>.svg" alt="" class="xs">
                <div class="trans-txt">
                    <p class="trans-description"><?php echo $description ?></p>
                    <p class="trans-category"><?php echo utf8_encode($category) ?> - <?php echo utf8_encode($paidwith) ?></p>
                    <p class="id-bank-operation"><?php echo $id_bank_operation ?></p>
                </div>
                <p class="trans-amount" name="amount"><?php echo $amount ?> €</p>
            </div> </a> <?php
        }
    } else {
        echo "<p class='no-trans'>Vous n'avez pas encore entré de transaction.</p>";
    }
}
    
function get_nav() {
    ?>
    <nav class="main-nav">
        <div class="nav-bloc">
            <a href="index.php" class="nav-bloc">
                <img src="media/account.svg" alt="" class="nav-icon">
                <p class="nav-txt">Comptes</p>
            </a>
        </div>
        <div class="nav-bloc">
            <a href="analyse.php" class="nav-bloc">
                <img src="media/analyse.svg" alt="" class="nav-icon">
                <p class="nav-txt">Analyses</p>
            </a>
        </div>
        <div class="nav-bloc">
            <img src="media/menu.svg" alt="" class="nav-icon">
            <p class="nav-txt">Menu</p>
        </div>
        <!-- <div class="nav-bloc">
           <img src="media/alertes.svg" alt="" class="nav-icon">
            <p class="nav-txt">Alertes</p>
        </div>-->
        <div class="nav-bloc-icon">
            <a href="add.php">
                <img src="media/addnew.svg" alt="" class="add-icon">
            </a>
        </div>
    </nav>
    <?php
}

function get_form($conn) {
    if (isset( $_GET['id'] ) && !empty( $_GET['id'] )) {
        $modify_date_bank_operation = $_GET['id'];
    } else {
        $modify_date_bank_operation = "";
    }

    function get_amount_positif($amount) {
        if ($amount > 0) {
            echo ($amount);
        } else {
            echo ($amount*-1);
        }
    }

    if ($modify_date_bank_operation != 0) {
        $sql_cat = "SELECT  bankoperation.id_bank_operation,
                            bankoperation.description,
                            bankoperation.amount,
                            bankoperation.type_id,
                            bankoperation.date_bank_operation,
                            bankoperation.category,
                            bankoperation.paid_with,
                            category.id_category,
                            paidwith.id_paid_with,
                            category.name as catname,
                            paidwith.name as paidwithname
                FROM        bankoperation
                INNER JOIN  category ON bankoperation.category = category.id_category
                INNER JOIN  paidwith ON bankoperation.paid_with = paidwith.id_paid_with
                WHERE       bankoperation.id_bank_operation = $modify_date_bank_operation";
        $result = mysqli_query($conn, $sql_cat);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                $description = $row['description'];
                $amount = $row['amount'];
                $paidwith_id = $row['paid_with'];
                $type_id = $row['type_id'];
                $id_bank_operation = $row['id_bank_operation'];
                $category = $row['catname'];
                $category_id = $row['category'];
                $paidwith = $row['paidwithname'];
                $date_bank_operation = $row['date_bank_operation'];
            }
        }
    } else {
            $description = "";
            $amount = "";
            $paidwith_id = "";
            $type_id = "";
            $id_bank_operation = "";
            $category = "";
            $category_id = "";
            $paidwith = "";
            $date_bank_operation = "";
    }
    ?>
            <form action="controls/<?php if ($modify_date_bank_operation != 0) {echo "modify_operation.php?id=$modify_date_bank_operation\" method=\"POST\">";} else {echo "create_operation.php\" method=\"POST\">";}?>
                <div class="form-div">
                    <label for="type_id" class="mandatory">
                        <h2 class="form-title">Type de saisie</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="input-type">
                    <p class="input-type-txt red">Sortie d'argent</p>
                        <label class="switch">
                            <input  type="checkbox" name="type_id" onclick="get_type();" id="switch" >
                            <span class="slider round">
                            </span>
                        </label>
                    <p class="input-type-txt green">Entrée d'argent</p>
                    </div>
                </div>
                <div class="form-div">
                    <label for="description" class="mandatory">
                        <h2 class="form-title">Description</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="text" class="entry-form" name="description" required maxlength="30" value="<?php echo $description;?>">
                    </div>
                </div>
                <div class="form-div">
                    <label for="amount" class="mandatory">
                        <h2 class="form-title">Montant</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="number" class="entry-form" name="amount" step="0.01" required value="<?php echo utf8_encode(get_amount_positif($amount));?>">
                    </div>
                </div>
                <div class="form-div">
                    <label for="date" class="mandatory">
                        <h2 class="form-title">Date</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="date" name="date" class="entry-form" required value="<?php echo utf8_encode($date_bank_operation);?>" id="datefield">
                    </div>
                </div>
                <div class="form-div">
                    <label for="category" class="mandatory">
                        <h2 class="form-title">Catégorie</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <select name="category" class="entry-form" required value="<?php echo utf8_encode($category);?>">
                            <?php get_category($conn); ?>
                        </select>
                    </div>
                </div>
                <div class="form-div">
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
                    <a href="index.php">
                        <img src="media/invalidate.svg" alt="" class="btn-invalidate">
                    </a>
                    <?php if ($modify_date_bank_operation != 0) {
                        echo "  <a id=\"delete\">
                                    <img src=\"media/supr.svg\" alt=\"\" class=\"btn-supr\">
                                </a>";
                    } else {}
                    ?>
                    <button type="submit" name="submit" class="submit-btn">
                            <img src="media/validate.svg" alt="" class="btn-validate">
                    </button>
                </div>
            </form>
            <?php
            if ($modify_date_bank_operation != 0) {
                echo "
                <script>
                    var select = document.getElementsByName(\"select\");
                    let category = \"";
                    echo "$category_id\"";
                    echo ";
                    
                    for (var i=0; i < select.length; i++) {
                        if (select[i].value == category) {
                            select[i].setAttribute('selected', true);
                    } 
                    }
                </script>";
                echo "
                <script>
                    var select = document.getElementsByName(\"paid_with\");
                    let paidwith = \"";
                    echo "$paidwith_id\"";
                    echo ";
                    
                    for (var i=0; i < select.length; i++) {
                        if (select[i].value == paidwith) {
                            select[i].setAttribute('checked', true);
                    } 
                    }
                </script>";
                echo "
                <script>
                    var select = document.getElementsByName(\"type_id\");
                    let typeid = \"";
                    echo "$type_id\"";
                    echo ";
                    
                    for (var i=0; i < select.length; i++) {
                        if (typeid == 2) {
                            select[i].setAttribute('checked', true);
                    } 
                    }
                </script>";
            } else {}
}

?>
