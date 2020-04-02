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
            ?>  <li class="paidwith-li">
                    <input type="radio" onclick="paidwith_selected();" id="title_<?php echo utf8_encode($row['id_paid_with']); ?>" name="paid_with" value="<?php echo utf8_encode($row['id_paid_with']); ?>" required class="input-paidwith">
                    <label for="title_<?php echo utf8_encode($row['id_paid_with']); ?>" onclick="paidwith_selected();" value="<?php echo utf8_encode($row['id_paid_with']); ?>"><?php echo utf8_encode($row['name']); ?></label>
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
    <div class="nav-bloc-icon desktop">
        <a href="add.php" class="nav-add-icon">
            <img src="media/addnew.svg" alt="" class="add-icon">
        </a>
    </div>
    <?php
}

function get_chart_data_category($conn) {
    $sql = "SELECT  SUM(bankoperation.amount) as value_sum,
                    bankoperation.id_bank_operation,
                    bankoperation.description,
                    bankoperation.amount,
                    bankoperation.type_id as typeid,
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
        GROUP BY    catname
        HAVING      typeid = 1";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $category[] = utf8_encode($row['catname']);
            $data[] = round($row['value_sum'],2);?>
            <?php
        }}
        ?>
        <script>
            var $category = <?php echo json_encode($category); ?>;
            var $data = <?php echo json_encode($data); ?>;
        </script><?php
}

function get_form($conn) {
    if (isset( $_GET['id'] ) && !empty( $_GET['id']) && is_numeric($_GET['id'])) {
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
                        <input type="number" class="entry-form" name="amount" step="0.01" min="0" required value="<?php echo utf8_encode(get_amount_positif($amount));?>">
                    </div>
                </div>
                <div class="form-div">
                    <label for="date" class="mandatory">
                        <h2 class="form-title">Date</h2>
                        <p class="mandatory-markup">*</p>
                    </label>
                    <div class="">
                        <input type="date" name="date" min="2018-01-01" class="entry-form" required value="<?php echo utf8_encode($date_bank_operation);?>" id="datefield">
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
                    <a href="index.php" class="btn-invalidate">
                        <img src="media/invalidate.svg" alt="" >
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
                echo "
                <script>paidwith_selected();</script>";
                
            } else {}
}

function get_bankoperation($conn,$filtre) {
    if (isset($filtre) && !empty($filtre)) {
        if ($filtre == 'on_category') {
            $filtre = 'category';
        } elseif ($filtre == 'on_date') {
            $filtre = 'date_bank_operation';
        }
    } else {
        $filtre = 'date_bank_operation';
    }

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
                ORDER BY $filtre DESC";
    $result = mysqli_query($conn, $sql_cat);
    $resultCheck = mysqli_num_rows($result);

    $category = "";
    $date = "";
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            if ($filtre == 'category') {
                if($row['catname'] !== $category) {
                    $category = $row['catname'];
                    ?> <p class="date"><?php  echo utf8_encode($category); ?> </p> <?php
                }

            } elseif ($filtre == 'date_bank_operation'){
                if($row['date_bank_operation'] !== $date) {
                    $date = $row['date_bank_operation'];
                    setlocale(LC_TIME, "fr_FR", "French");
                    $date_fr = strftime('%d %B %Y', strtotime($date));
                    ?> <p class="date"><?php  echo utf8_encode($date_fr); ?> </p> <?php
                }
            }

            if ($filtre == 'category') {
                $date = $row['date_bank_operation'];
                setlocale(LC_TIME, "fr_FR", "French");
                $date_fr = strftime('%d %B %Y', strtotime($date));
            } elseif ($filtre == 'date_bank_operation'){
                $category = $row['catname'];
            }

            $description = $row['description'];
            $amount = $row['amount'];
            $paidwith = $row['paid_with'];
            $type_id = $row['type_id'];
            $id_bank_operation = $row['id_bank_operation'];
            $paidwith = $row['paidwithname'];

            ?>
            <a href="modify.php?id=<?php echo $id_bank_operation ?>">
            <div class="transaction">
                <img src="media/<?php echo $type_id ?>.svg" alt="" class="xs">
                <div class="trans-txt">
                    <p class="trans-description"><?php echo $description ?></p>
                    <p class="trans-category">
                    <?php
                        if ($filtre == 'category') {
                            echo utf8_encode($date_fr);
                        } elseif ($filtre == 'date_bank_operation'){
                            echo utf8_encode($category);
                        }
                    ?>
                      - <?php echo utf8_encode($paidwith) ?></p>
                    <p class="id-bank-operation"><?php echo $id_bank_operation ?></p>
                </div>
                <p class="trans-amount" name="amount"><?php echo $amount ?> €</p>
            </div> </a> <?php
        }
    } else {
        echo "<p class='no-trans'>Vous n'avez pas encore entré de transaction.</p>";
    }
    
}

function get_bankoperation_type($conn) {
    ?>
    <h2 class="trans-title">Transactions par
        <select name="tri" onchange="location = this.value;" class="tri-select">
            <option name="option-tri" value="?filtre=on_date" onclick="get_tri();">date</option>
            <option name="option-tri" value="?filtre=on_category" onclick="get_tri();">catégorie</option>
        </select>
    </h2>
    <div class="scroll">
    <?php
    if (isset( $_GET['filtre'] ) && !empty( $_GET['filtre'] )) {
        $filtre = $_GET['filtre'];
        call_user_func('get_bankoperation',$conn,$filtre);
    } else {
        $filtre= "";
        get_bankoperation($conn,$filtre);
    }
    ?></div><?php
}

function get_chart_total($conn) {
    get_chart_data_total($conn) ?>
    <h2 class="">Tendances par mois</h2>
    <div class="canvas canvas-total">
        <canvas id="myChart-total"></canvas>
        <div id="myChartLegend-total"></div>
    </div>
    <?php

}

function get_chart_category($conn) {
    get_chart_data_category($conn) ?>
    <h2 class="">Dépenses par catégorie</h2>
    <div class="canvas canvas-category">
        <canvas id="myChart-category"></canvas>
        <div id="myChartLegend-category"></div>
    </div>
    <?php
}

function get_chart_data_total($conn) {
    $sql = "SELECT  SUM(bankoperation.amount) as value_sum,
                    MONTHNAME(bankoperation.date_bank_operation) as is_month,
                    bankoperation.id_bank_operation,
                    bankoperation.type_id as typeid,
                    bankoperation.date_bank_operation
        FROM        bankoperation
        GROUP BY    MONTH(date_bank_operation)
        ";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
 
    if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $month[] = utf8_encode($row['is_month']);
            $data[] = round($row['value_sum'],2);
            
        }}
    
    $sql_revenu = "SELECT   SUM(case when bankoperation.amount >= 0 then bankoperation.amount else 0 end) as positive,
                            SUM(case when bankoperation.amount < 0 then bankoperation.amount else 0 end) as negative,
                            MONTHNAME(bankoperation.date_bank_operation) as is_month,
                            bankoperation.type_id as typeid,
                            bankoperation.date_bank_operation
                        FROM        bankoperation
                        GROUP BY    MONTH(date_bank_operation)
                        ";
        $result = mysqli_query($conn, $sql_revenu);
        $resultCheck = mysqli_num_rows($result);

        if ($resultCheck > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            $revenu[] = round($row['positive'],2);
            $depense[] = round($row['negative'],2);
            
        }}

    
        ?>
        <script>
            var $date = <?php echo json_encode($month); ?>;
            var $data_solde = <?php echo json_encode($data); ?>;
            var $revenu = <?php echo json_encode($revenu); ?>;
            var $depense = <?php echo json_encode($depense); ?>;
        </script><?php
}

?>
