<?php
    // echo "<pre>";
    // print_r($_POST);
    // echo "</pre>";
    // exit();
    require_once('../template/db.inc.php');


    if ($_POST["itemStatus"]=='刪除') {
        $sql = "DELETE FROM `items` WHERE `itemId` = ? ";

        $countDel = 0;
        $sqlGetImg = "SELECT `itemImg` FROM `items` WHERE `itemId` = ? ";
        $stmtGetImg = $pdo->prepare($sqlGetImg);

        for ($i=0; $i < count($_POST['itemId']); $i++) { 
            $arrGetImgParam = [
                $_POST['itemId'][$i]
            ];
            $stmtGetImg->execute($arrGetImgParam);

            //若有找到 studentImg 的資料
            if($stmtGetImg->rowCount() > 0) {
                //取得指定 id 的學生資料 (1筆)
                $arrImg = $stmtGetImg->fetchAll(PDO::FETCH_ASSOC);

                //若是 studentImg 裡面不為空值，代表過去有上傳過
                if($arrImg[0]['itemImg'] !== NULL){
                    //刪除實體檔案
                    @unlink("../image/items/".$arrImg[0]['itemImg']);
                } 
            } 
            
            $arrParam = [
                $_POST['itemId'][$i]
            ];
        
            $stmt = $pdo->prepare($sql);
            $stmt->execute($arrParam);
            $countDel += $stmt->rowCount();

        }
        if( $countDel > 0 ){
            header("Refresh: 0.1; url=./items.php");
            echo "<script>alert('刪除成功')</script>";
        } else {
            print_r($pdo->errorInfo());
            header("Refresh: 0.1; url=./items.php");
            echo "<script>alert('刪除失敗')</script>";
        }
    } else{

    $sql = "UPDATE `items` 
            SET `itemStatus` = ?
            WHERE `itemId` = ? ";
    
    $count = 0;

    for ($i=0; $i < count($_POST['itemId']) ; $i++) { 
        
        $arrParam = [
            $_POST['itemStatus'],
            $_POST['itemId'][$i]
        ];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);

        $count += $stmt->rowCount();
    }

    if( $count > 0 ){
        header("Refresh: 0.1; url=./items.php");
        echo "<script>alert('修改成功')</script>";
    } else {
        print_r($pdo->errorInfo());
        header("Refresh: 0.1; url=./items.php");
        echo "<script>alert('修改失敗')</script>";
    }
    


    }