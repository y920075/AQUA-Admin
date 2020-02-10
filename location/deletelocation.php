<?php
    require_once('../template/db.inc.php');
    $sql = "DELETE FROM `location`
            WHERE `LocationID` = ? ";
    $arrparam = [
        $_GET['deleteId']
    ];
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrparam);

    if($stmt->rowCount() > 0) {
        header("Refresh: 0; url=./location.php");
    } else {
        header("Refresh: 100; url=./location.php");
    }