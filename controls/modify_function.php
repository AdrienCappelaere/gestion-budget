<?php
    include_once 'controls/functions.php';

if (isset( $_GET['id'] ) && !empty( $_GET['id'] )) {
    $modify_date_bank_operation = $_GET['id'];
} else {
    $modify_date_bank_operation = "";
}

function get_form($conn, $modify_date_bank_operation) {
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
            <form action="controls/<?php if ($modify_date_bank_operation != 0) {echo "sendmodify.php?id=$modify_date_bank_operation\" method=\"POST\">";} else {echo "bankoperation.php\" method=\"POST\">";}?>
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
                        <input type="date" id="" name="date" class="entry-form" required value="<?php echo utf8_encode($date_bank_operation);?>">
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
