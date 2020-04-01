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
            ?>  <li>
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
            <a href="views/modify.php?id=<?php echo $id_bank_operation ?>">
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
    
?>
