<?php
    require_once('../template/db.inc.php');

    $sql = "DELETE FROM `class_type` WHERE `classTypeId` = ? ";
    $arrParam = [
        $_GET['deleteTypeId']  
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./class-category.php");
        echo '<script type="text/javascript">alert("刪除成功!");</script>';
    } else {
        header("Refresh: 0.1; url=./class-category.php");
        echo '<script type="text/javascript">alert("刪除失敗!");</script>';

    }

