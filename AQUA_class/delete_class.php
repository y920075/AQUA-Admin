<?php
    require_once('../template/db.inc.php');


    $sql_ImgDelete = "SELECT `classImg` FROM `class_data` WHERE `classId` = '{$_GET['deleteclassId']}' ";

    $stmt_ImgDelete = $pdo->prepare($sql_ImgDelete);
    $stmt_ImgDelete->execute();

    if ( $stmt_ImgDelete->rowCount() > 0 ) {
        $arrImgDelete = $stmt_ImgDelete->fetchAll(PDO::FETCH_ASSOC)[0];
        @unlink("../image/classImg/".$arrImgDelete['classImg']);
    }

    $sql = "DELETE FROM `class_data` WHERE `classId` = '{$_GET['deleteclassId']}' ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./class_admin.php");
        echo '<script type="text/javascript">alert("刪除成功!");</script>';

    } else {
        header("Refresh: 0.1; url=./class_admin.php");
        echo '<script type="text/javascript">alert("刪除失敗!");</script>';

    }