<?php
    require_once('../template/db.inc.php');

    $sql = "DELETE FROM `event_type` WHERE `eventTypeId` = ? ";
    $arrParam = [
        $_GET['deleteTypeId']  
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./event-category.php");
        echo '<script type="text/javascript">alert("刪除成功!");</script>';
    } else {
        header("Refresh: 0.1; url=./event-category.php");
        echo '<script type="text/javascript">alert("刪除失敗!");</script>';

    }

