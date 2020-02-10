<?php


echo "<pre>";
print_r($_POST);
echo "</pre>";
exit();

require_once('../template/db.inc.php');



$sql = "UPDATE `items` 
        SET `itemStatus` = '禁賣'
        WHERE `itemId` = ? ";

$count = 0;

for( $i = 0; $i < count($_POST['chk']); $i++ ){
    $arrParam = [
        $_POST['chk'][$i]
    ];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    $count += $stmt->rowCount();

}

if( $count > 0 ){
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('修改成功')</script>";
} else {
    print_r($pdo->errorInfo());
    header("Refresh: 0.1; url=./items.php");
    echo "<script>alert('修改失敗')</script>";
}
