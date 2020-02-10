

<?php
require_once("../template/db.inc.php");


$sql = "SELECT SUM(checkSubTotal)
        FROM `orders`
        WHERE ordermemberId = 'M0101' ";

$stmt = $pdo->prepare($sql);
$stmt->execute();

if ($stmt->rowCount() > 0){
    $arr = $stmt->fetchAll(PDO::FETCH_NUM)[0];
    // echo "<pre>";
    // print_r($arr);
    // echo "</pre>";

if (($arr[0] >= 0) && ($arr[0] <= 5000)) {
    echo "小丑魚";
} else if (($arr[0] >= 5001) && ($arr[0] <= 20000)) {
    echo "海龜";
} else if (($arr[0] >= 20001) && ($arr[0] <= 50000)) {
    echo "海豚";
} else {
    echo "鯨魚";
}
}
?>

