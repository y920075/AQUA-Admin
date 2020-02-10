<?php
    require_once('../template/db.inc.php');

    $sql = "DELETE FROM `class_level` WHERE `classLevelId` = ? ";
    $arrParam = [
        $_GET['deletelevelId']  
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./class_level.php");
        echo '<script type="text/javascript">alert("刪除成功!");</script>';
    } else {
        header("Refresh: 0.1; url=./class_level.php");
        echo '<script type="text/javascript">alert("刪除失敗!");</script>';

    }

