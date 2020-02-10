<?php
    require_once('../template/db.inc.php');

    $sql = "DELETE FROM `event_member` WHERE `eventId` = ? AND `eventJOINmember` = ? ";
    $arrParam = [
        $_GET['eventid'],
        $_GET['memberid'] 
    ];

    //重新計算該筆揪團編號的參加會員總數
    $sqlCount = "   SELECT sum(`eventAttendee`) AS `memberCount` 
                    FROM `event_member` 
                    WHERE `eventId` = ? ";
    //繫結活動編號
    $arrEventId = [
        $_GET['eventid']
    ];

    //更新該筆揪團編號的現在人數
    $sqlEventUpdate = " UPDATE `event_data` 
                        SET `eventNowPeople` = ? 
                        WHERE `eventId` = ? ";

    //啟動 刪除會員參加資訊的SQL語法
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    //啟動 重新計算該筆揪團編號會員總數的SQL語法
    $stmtCount = $pdo->prepare($sqlCount);
    $stmtCount->execute($arrEventId);

    if( $stmt->rowCount() > 0 ){
        header("Refresh: 0.1; url=./edit_event.php?editeventId={$_GET['eventid']}");
        $arrCount = $stmtCount->fetchAll(PDO::FETCH_ASSOC)[0];
        //繫結更新總數及id
        $arrJoinCount = [
            $arrCount['memberCount'],
            $_GET['eventid']
        ];
        //啟動 更新參加會員總數的SQL語法
        $stmtEventUpdate = $pdo->prepare($sqlEventUpdate);
        $stmtEventUpdate->execute($arrJoinCount);
        echo '<script type="text/javascript">alert("取消成功!");</script>';
    } else {
        header("Refresh: 0.1; url=./edit_event.php?editeventId={$_GET['eventid']}");
        echo '<script type="text/javascript">alert("取消失敗!");</script>';

    }

