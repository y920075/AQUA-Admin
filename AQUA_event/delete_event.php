<?php
    require_once('../template/db.inc.php');


    $sql_ImgDelete = "SELECT `eventImg` FROM `event_data` WHERE `eventId` = '{$_GET['deleteeventId']}' ";

    $stmt_ImgDelete = $pdo->prepare($sql_ImgDelete);
    $stmt_ImgDelete->execute();

    if ( $stmt_ImgDelete->rowCount() > 0 ) {
        $arrImgDelete = $stmt_ImgDelete->fetchAll(PDO::FETCH_ASSOC)[0];
        @unlink("../image/eventImg/".$arrImgDelete['eventImg']);
    }

    $sql = "DELETE FROM `event_data` WHERE `eventId` = '{$_GET['deleteeventId']}' ";

    $stmt = $pdo->prepare($sql);
    $stmt->execute();

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./event-admin.php");
        echo '<script type="text/javascript">alert("刪除成功!");</script>';

    } else {
        header("Refresh: 0.1; url=./event-admin.php");
        echo '<script type="text/javascript">alert("刪除失敗!");</script>';

    }