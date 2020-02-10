<?php
    header("Content-Type: text/html; chartset=utf-8");
    require('../template/db.inc.php');
    if($_POST['noted'] === '') $_POST['noted'] = null;
    $sql = "INSERT INTO `location`
            (`LocationID`,`LocationName`,`LocationArea`,`Locationlevel`,`Satisfaction`,`Locationdescribe`,`Transportation`,`noted`)
            VALUES (?,?,?,?,?,?,?,?)";
    $arr = [
        $_POST['LocationID'],
        $_POST['LocationName'],
        $_POST['LocationArea'],
        $_POST['Locationlevel'],
        $_POST['Satisfaction'],
        $_POST['Locationdescribe'],
        $_POST['Transportation'],
        $_POST['noted']
    ];
    $pdo_stmt = $pdo->prepare($sql);
    $pdo_stmt->execute($arr);
    if($pdo_stmt->rowCount() === 1) {
        header("Refresh: 0; url=./location.php");
    } else {
        header("Refresh: 0; url=./location.php");
    }