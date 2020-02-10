<table class="table table-hover sortable">
    <thead>
        <tr>
        <th>揪團編號</th>
        <th>揪團主題</th>
        <th>揪團類型</th>
		<th>揪團地點</th>
        <th>主揪者</th>
        <th>活動日期</th>
        <th>報名截止日期</th>
        <th>建立時間</th>
        <th>更新時間</th>
        </tr>
    </thead>
    <tbody>
    
    <?php
        // //取得揪團類型資料
        $sql_Type = "SELECT `event_data`.`eventId`,`event_type`.`eventTypeName` 
                    FROM `event_data` 
                    INNER JOIN `event_type` 
                    ON `event_data`.`eventTypeId` = `event_type`.`eventTypeId`";

        // //取得地點資料
        $sql_Local = "SELECT `event_data`.`eventId`,`location`.`LocationID`,`location`.`LocationName`
        FROM `location` 
        INNER JOIN `event_data`
        ON `location`.`LocationID` = `event_data`.`eventLocal`";

        //繫結資料 第一個值對應到 lIMIT第一個值 表示從第幾筆開始 
        //計算方式 目前頁數減1 乘 一頁要幾筆 假設目前為第一頁 則 1-1 =0 , 0*5 = 0
        //第一個值就等於0 第二個值為 5 就等同於 LIMIT 0,5 將會抓取 0,1,2,3,4 五筆資料
        //執行地點SQL語法
        $stmt_Local = $pdo->prepare($sql_Local);
        $stmt_Local->execute();

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
            $arr_Local = $stmt_Local->fetchAll(PDO::FETCH_ASSOC);
            
            //用for迴圈逐一取得資料 count()是加總陣列長度
            for($i = 0 ; $i < count($arr) ; $i++){
                //用for迴圈逐一比對揪團編號，如果一致就把揪團類型名稱賦值給$type並離開迴圈印出資料
                //如果比對不成功則賦值null
                for( $j = 0 ; $j < count($arr_type) ; $j++){
                    if ($arr[$i]['eventId'] == $arr_type[$j]['eventId']) {
                        $type = $arr_type[$j]['eventTypeName'];
                        break;
                    } else {
                        $type = 'null';
                    };
                };
                // //用for迴圈逐一比對揪團編號，如果一致就把地點賦值給$Local並離開迴圈印出資料
                // //如果比對不成功則依照資料庫內的值給值
                for( $k = 0 ; $k < count($arr_Local) ; $k++){
                    if ($arr[$i]['eventId'] == $arr_Local[$k]['eventId']) {
                        $Local = $arr_Local[$k]['LocationName'];
                        break;
                    } else {
                        $Local = $arr[$i]['eventLocal'];
                    };
                };
    ?>
    <tr>
        <td><?php echo $arr[$i]['eventId']; ?></td>
        <td><?php echo $arr[$i]['eventName']; ?></td>
        <td><?php echo $type ?></td>
		<td><?php echo $Local; ?></td>
        <td><?php echo $arr[$i]['eventSponsor']; ?></td>
        <td><?php echo $arr[$i]['eventStartDate']; ?></td>
        <td><?php echo $arr[$i]['eventEndDate']; ?></td>
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
             <td class="border text-center" colspan="9">
            <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
</table>