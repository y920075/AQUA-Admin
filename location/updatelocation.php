<?php
    require_once('../template/db.inc.php');

    $sql = "UPDATE  `location`
            SET     `LocationID` = ?,
                    `LocationName` = ?,
                    `LocationArea` = ?,
                    `Locationlevel` = ?,
                    `Satisfaction` = ?,
                    `Locationdescribe` = ?,
                    `Transportation` = ?,
                    `noted` = ? ";
    
    $arrparam = [
        $_POST['LocationID'],
        $_POST['LocationName'],
        $_POST['LocationArea'],
        $_POST['Locationlevel'],
        $_POST['Satisfaction'],
        $_POST['Locationdescribe'],
        $_POST['Transportation'],
        $_POST['noted'],
    ];

    $sql.= "WHERE `LocationID` = ? ";
    $arrparam[] = $_POST['editId'];

    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrparam);

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0; url=./location.php");
        // echo "更新成功";
    } else {
        header("Refresh: 2; url=./location.php");
        echo "沒有任何更新";
    }

                