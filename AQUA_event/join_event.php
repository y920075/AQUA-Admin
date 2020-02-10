<?php
    session_start();
    require_once('../template/db.inc.php'); //引入資料庫連線
    $user = $_SESSION['username']; //取得現在登入的會員帳號

    //新增會員的參加資訊到資料庫
    $sqlJoinData = "    INSERT INTO `event_member` 
                        (`eventId`,`eventJOINmember`,`eventAttendee`)
                        VALUE ( ?, ?, ?)";
    //繫結參加資訊
    $arrJoinMember = [
        $_POST['eventId'],
        $user,
        $_POST['eventAttendee']
    ];

    //計算該筆揪團編號的參加會員總數
    $sqlCount = "   SELECT sum(`eventAttendee`) AS `memberCount` 
                    FROM `event_member` 
                    WHERE `eventId` = ? ";
    //繫結活動編號
    $arrEventId = [
        $_POST['eventId']
    ];

    //更新該筆揪團編號的現在人數
    $sqlEventUpdate = " UPDATE `event_data` 
                        SET `eventNowPeople` = ? 
                        WHERE `eventId` = ? ";
    
    //啟動 新增參加資訊的SQL語法
    $stmtJoin = $pdo->prepare($sqlJoinData);
    $stmtJoin->execute($arrJoinMember);
    
    //啟動 計算該筆揪團編號會員總數的SQL語法
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute($arrEventId);

    if ($stmtJoin->rowCount() > 0 && $stmtCount->rowCount() > 0) {

        $arrCount = $stmtCount->fetchAll(PDO::FETCH_ASSOC)[0];
        //繫結更新總數及id
        $arrJoinCount = [
            $arrCount['memberCount'],
            $_POST['eventId']
        ];
        //啟動 更新參加會員總數的SQL語法
        $stmtEventUpdate = $pdo->prepare($sqlEventUpdate);
        $stmtEventUpdate->execute($arrJoinCount);
        echo '參加成功!';
        exit();
    } else {

        echo '參加失敗!';
        exit();
    }
?>