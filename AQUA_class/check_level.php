<?php 
    header('Content-Type: application/json; charset=utf-8'); //設定資料類型
    require_once('../template/db.inc.php'); //引入資料庫連線
    
    //取得AJAX傳送過來的值
    $select_Type = $_POST['select_Type'];

    //建立查詢語法
    $sqlGetlevel = "SELECT `classLevelId`,`classLevel`
                    FROM `class_level`";

    //依據傳送的過來值，給予相對應的WHERE條件
    switch ( $select_Type ) {
        case 'classTypeSSI' :
            $sqlGetlevel.=  "WHERE `classLevelId` LIKE 'classlvSSI%'";
            break;
        case 'classTypeAIDA' :
            $sqlGetlevel.=  "WHERE `classLevelId` LIKE 'classlvAIDA%'";
            break;
        case 'calssTypePADI' :
            $sqlGetlevel.=  "WHERE `classLevelId` LIKE 'classlvPADI%'";
            break;
        default :
            $sqlGetlevel.=  "WHERE `classLevelId` REGEXP 'classlv[0-9]{2}'";
            break;
    }

    $stmtGetlevel = $pdo->prepare($sqlGetlevel);
    $stmtGetlevel->execute();

    $arrlevel = $stmtGetlevel->fetchAll(PDO::FETCH_ASSOC);

    //返回JSON字串
    echo json_encode($arrlevel);

    

?>