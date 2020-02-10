<table class="table table-hover sortable">
    <thead>
        <tr>
        <th>課程編號</th>
        <th>課程名稱</th>
        <th>課程類型</th>
        <th>課程等級</th>
        <th>賣家編號</th>
        <th>開課日期</th>
        <th>課程費用</th>
        <th>建立時間</th>
        <th>更新時間</th>
        </tr>
    </thead>
    <tbody>
    <?php
        //取得揪團資料
        // $sql = "SELECT `classId`,`className`,`classTypeId`,`classLevelID`,`sellerID`,`classStartDate`,`classPrice`,`created_at`,`updated_at`
        // 		FROM `class_data` 
        // 		LIMIT ?,? ";
        // 顯示筆數 第一個值是從"第幾筆開始" 第二個值是總共要幾筆
        // LIMIT 0,5 = 第0筆開始 抓5筆 = 索引值為 0,1,2,3,4 資料會被抓出來

        //取得課程類型資料
        $sql_Type = "SELECT `class_data`.`classId`,`class_type`.`classTypeName` 
                    FROM `class_data` 
                    INNER JOIN `class_type` 
                    ON `class_data`.`classTypeId` = `class_type`.`classTypeId`";

        //取得等級資料
        $sql_level = "SELECT `class_data`.`classId`,`class_level`.`classLevelId`,									`class_level`.`classLevel`
                    FROM `class_level` 
                    INNER JOIN `class_data`
                    ON `class_level`.`classLevelId` = `class_data`.`classLevelID`";

        //繫結資料 第一個值對應到 lIMIT第一個值 表示從第幾筆開始 
        //計算方式 目前頁數減1 乘 一頁要幾筆 假設目前為第一頁 則 1-1 =0 , 0*5 = 0
        //第一個值就等於0 第二個值為 5 就等同於 LIMIT 0,5 將會抓取 0,1,2,3,4 五筆資料
        // $arrParam = [
        //     ($page - 1) * $numPerPage,
        //     $numPerPage
        // ];

        //執行地點SQL語法
        $stmt_level = $pdo->prepare($sql_level);
        $stmt_level->execute();

        //執行揪團類型SQL語法
        $stmt_Type = $pdo->prepare($sql_Type);
        $stmt_Type->execute();
        
        //執行查詢SQL語法
        $stmt = $pdo->prepare($sql);
        $stmt->execute();

        //如果影響行數大於0 就印出資料
        if($stmt->rowCount() > 0){
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $arr_type = $stmt_Type->fetchAll(PDO::FETCH_ASSOC);
            $arr_level = $stmt_level->fetchAll(PDO::FETCH_ASSOC);
            
            //用for迴圈逐一取得資料 count()是加總陣列長度
            for($i = 0 ; $i < count($arr) ; $i++){
                //用for迴圈逐一比對課程編號，如果一致就把課程類型名稱賦值給$type並離開迴圈印出資料
                //如果比對不成功則賦值null
                for( $j = 0 ; $j < count($arr_type) ; $j++){
                    if ($arr[$i]['classId'] == $arr_type[$j]['classId']) {
                        $type = $arr_type[$j]['classTypeName'];
                        break;
                    } else {
                        $type = 'null';
                    };
                };
                //用for迴圈逐一比對課程編號，如果一致就把等級賦值給$level並離開迴圈印出資料
                //如果比對不成功則依照資料庫內的值給值
                for( $k = 0 ; $k < count($arr_level) ; $k++){
                    if ($arr[$i]['classId'] == $arr_level[$k]['classId']) {
                        $level = $arr_level[$k]['classLevel'];
                        break;
                    } else {
                        $level = 'null';
                    };
                };
    ?>
    <tr>
        <td><?php echo $arr[$i]['classId']; ?></td>
        <td><?php echo $arr[$i]['className']; ?></td>
        <td><?php echo $type ?></td>
        <td><?php echo $level; ?></td>
        <td><?php echo $arr[$i]['sellerID']; ?></td>
        <td><?php echo $arr[$i]['classStartDate']; ?></td>
        <td><?php echo $arr[$i]['classPrice']; ?></td>
        <td><?php echo $arr[$i]['created_at']; ?></td>
        <td><?php echo $arr[$i]['updated_at']; ?></td>
    </tr> 
    <?php
            };
        };
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td colspan="12">
            <?php
            for($i = 1; $i <= $totalPages; $i++){
            ?>
            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
            <?php
            }
            ?>
            </td>
        </tr>
    </tfoot>
</table>