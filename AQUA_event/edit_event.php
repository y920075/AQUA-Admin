<?php
require_once('../template/db.inc.php'); //引入資料庫連線
require_once('./html_title.php'); //引入html head資訊
?>
<body>
<?php
require_once('../template/header.php'); //引入頭部導航列
require_once('../template/sidebar.php'); //引入側攔
?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="../index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active text-primary"><a class="" href="./event-admin.php">揪團管理首頁</a></li>
                <li class="active">編輯揪團</li>
			</ol>
		</div>
<?php
    // 取得預設在資料庫內的資料
    // 透過DATE_FORMAT將從資料庫取得的資料格式化為HTML5 datetime-local格式
    $sql = "SELECT `eventId`,`eventName`,`eventTypeId`,`eventLocal`,`eventSponsor`,
            DATE_FORMAT(`eventStartDate`, '%Y-%m-%dT%H:%i') AS StartDate,
            DATE_FORMAT(`eventEndDate`, '%Y-%m-%dT%H:%i') AS EndDate,
            `eventDesc`,`eventNeedPeople`,`eventNowPeople`,`eventImg` 
            FROM `event_data`
            WHERE `eventId` = ? ";

    //取得揪團類型的資料
    $sql_Type = "SELECT `event_type`.`eventTypeName` 
                 FROM `event_data` 
                 INNER JOIN `event_type` 
                 ON `event_data`.`eventTypeId` = `event_type`.`eventTypeId`
                 WHERE `event_data`.`eventId` = ? ";
    //取得地點資料
    $sql_Local = "SELECT `location`.`LocationID`,`location`.`LocationName`
                  FROM `location` 
                  INNER JOIN `event_data`
                  ON `location`.`LocationID` = `event_data`.`eventLocal`
                  WHERE `event_data`.`eventId` = ? ";

    //取得參加者資料
    $sql_member = "SELECT `event_data`.`eventId`,`event_member`.`eventJOINmember`,`event_member`.`eventAttendee`
                   FROM `event_member`
                   INNER JOIN `event_data`
                   ON `event_data`.`eventId` = `event_member`.`eventId`
                   WHERE `event_data`.`eventId` = ? ";

    //共用繫結資料
    $arrParam = [
        $_GET['editeventId']
    ];

    //執行參加會員的sql語法
    $stmt_member = $pdo->prepare($sql_member);
    $stmt_member->execute($arrParam);

    //執行地點的sql語法
    $stmt_Local = $pdo->prepare($sql_Local);
    $stmt_Local->execute($arrParam);

    //執行揪團類型的sql語法
    $stmt_Type = $pdo->prepare($sql_Type);
    $stmt_Type->execute($arrParam);

    //執行查詢sql語法
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    //如果有查詢到資料，影響行數大於0，就印出資料
    if($stmt->rowCount() > 0 ) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

?>
            <div class="panel panel-default">
                <div class="panel-heading">編輯揪團</div>
                <div class="panel-body">

                    <!-- 如果資料庫中'eventImg'這個值存在就印出圖片-->
                    <?php if( $arr['eventImg'] !== NULL){ ?>
                    <h4>揪團圖片</h4>
                    <figure class="eventImg">
                        <img id="blah" src="../image/eventImg/<?php echo $arr['eventImg'];?>" alt="">
                    </figure>
                    <?php } ?>

                    <form name="myForm" method="POST" action="./update_event.php"  role="form" enctype="multipart/form-data">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>揪團編號</label>
                                <input type="text" class="form-control" maxlength="11" name="eventId"  value="<?php echo $arr['eventId']; ?>" readonly="value">
                            </div>
                            <div class="form-group">
                                <label>活動日期</label>
                                <input type="datetime-local" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00" class="form-control"  name="eventStartDate"  value = "<?php echo $arr['StartDate']; ?>">
                            </div>
                            <div class="form-group">
                                <label>徵求人數</label>
                                <input type="text" class="form-control" maxlength="2" name="eventNeedPeople" value = "<?php echo $arr['eventNeedPeople']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">揪團類型</label>
                                <select name="eventTypeId" class="form-control">

                                    <!-- 先抓出原本資料庫中的值 -->
                                    <?php
                                    if($stmt_Type->rowCount() > 0){
                                        $arrType = $stmt_Type->fetchAll(PDO::FETCH_ASSOC)[0];
                                    ?>
                                        <option value="<?php echo $arr['eventTypeId'] ;?>">*原始值* <?php echo $arrType['eventTypeName']; ?></option>
                                    <?php
                                    } else {
                                        unset($stmt_Type);
                                    ?>
                                        <option value="<?php echo $arr['eventTypeId'] ;?>">*無系統預設值*</option>
                                    <?php
                                    }
                                    ?>

                                <!-- 再抓出event_type這張資料表中的所有類型 -->
                                <?php
                                    $sqlGetType =  "SELECT `eventTypeName`,`eventTypeId`
                                                    FROM `event_type`";
                                    $stmtGetType = $pdo->prepare($sqlGetType);
                                    $stmtGetType->execute();
                                    if($stmtGetType->rowCount() > 0){
                                        $arrGetType = $stmtGetType->fetchAll(PDO::FETCH_ASSOC);
                                        for($i = 0 ; $i < count($arrGetType) ; $i++){
                                        ?>
                                            <option value="<?php echo $arrGetType[$i]['eventTypeId']; ?>"><?php echo $arrGetType[$i]['eventTypeName']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>
                                    
                                </select>
                            </div>
                            <div class="form-group">
                                <label>主揪者</label><span><a href="../member/edit.php?editId=<?php echo $arr['eventSponsor']; ?>">查看</a></span><input type="button" value="修改" id="btn-changeID">
                                <input type="text" class="form-control" maxlength="30" name="eventSponsor" id="changeID" value = "<?php echo $arr['eventSponsor']; ?>"  readonly="value">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>揪團主題</label>
                                <input type="text" class="form-control" maxlength="50" name="eventName" placeholder="最多50字元" value = "<?php echo $arr['eventName']; ?>">
                            </div>
                            <div class="form-group">
                                <label>報名截止日期</label>
                                <input type="datetime-local" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00" class="form-control"  name="eventEndDate"  value = "<?php echo $arr['EndDate']; ?>">
                            </div>
                            <div class="form-group">
                                <label>目前人數</label>
                                <input type="text" class="form-control" maxlength="2" name="eventNowPeople"  value = "<?php echo $arr['eventNowPeople']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">揪團地點</label>
                                <select name="eventLocal" class="form-control" id="localid">

                                <!-- 先抓出原本資料庫中的地點 -->
                                <?php
                                    
                                    if($stmt_Local->rowCount() > 0 ){
                                        $arrLocal = $stmt_Local->fetchAll(PDO::FETCH_ASSOC)[0];
                                    ?>
                                        <option value="<?php echo $arr['eventLocal'] ;?>">*原始值* <?php echo $arrLocal['LocationName']; ?></option>
                                    <?php
                                    } else {
                                        unset($stmt_Local);
                                    ?>
                                        <option value="<?php echo $arr['eventLocal'] ;?>">*原始值* <?php echo $arr['eventLocal'] ;?></option>
                                    <?php
                                    } 
                                    ?>

                                <?php
                                    //抓出地點類型
                                    $sqlGetLocal = "SELECT `LocationID`,`LocationName`
                                                    FROM `location`";
                                    $stmtGetLocal = $pdo->prepare($sqlGetLocal);
                                    $stmtGetLocal->execute();
                                    if ($stmtGetLocal->rowCount() > 0) {
                                        $arrGetLocal = $stmtGetLocal->fetchAll(PDO::FETCH_ASSOC);
                                        for ( $j = 0 ; $j < count($arrGetLocal) ; $j++) {
                                            ?>
                                            <option value="<?php echo $arrGetLocal[$j]['LocationID']; ?>"><?php echo $arrGetLocal[$j]['LocationName']; ?></option>
                                        <?php
                                        }
                                    }
                                ?>
                                    <option value="other">其他</option>
                                </select> 

                                <!-- 隱藏輸入框，選項為"其他"時會顯示 -->
                                <label style="display:none;" id="localinput" for="formGroupExampleInput">請輸入地點
                                    <input type="text" class="form-control" maxlength="15" name="customLocal" placeholder="最多15字元">
                                </label>

                            </div>
                            <div class="form-group">
                                <label>上傳圖片</label>
                                <input type="file" class="form-control"  name="eventImg" accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>揪團說明</label>
                                <textarea type="text" class="textarea form-control" maxlength="1000" name="eventDesc" placeholder="最多1000字元" ><?php echo$arr['eventDesc']; ?></textarea>
                            </div>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>參加會員</th>
                                        <th>同行人數</th>
                                        <th>取消</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                    if ($stmt_member->rowCount() > 0) {
                                        $arrMember = $stmt_member->fetchAll(PDO::FETCH_ASSOC);
                                        for ( $k = 0 ; $k <count($arrMember) ; $k++){
                                            ?>
                                            <tr>
                                            <td><?php echo $arrMember[$k]['eventJOINmember']; ?></td>
                                            <td><?php echo $arrMember[$k]['eventAttendee']; ?></td>
                                            <td>
                                                <a href="./delete_eventJoin.php?eventid=<?php echo $arrMember[$k]['eventId'];?>&memberid=<?php echo $arrMember[$k]['eventJOINmember'] ;?>">取消</a>
                                            </td>
                                            </tr>
                                <?php
                                        }
                                    }
                                ?>
                                </tbody>
                            </table>

                    <?php
                        } else {
                            echo '查詢不到相關資料';
                        }
                    ?>
                            <button id="btn-addcategory" type="submit" class="btn btn-primary">修改</button>
                            <!-- 隱藏的input元素，用來將editId POST出去，以便後續程式接收資料 -->
                            <input type="hidden" name="editId" value="<?php echo $_GET['editeventId']; ?>">
                        </div>
                    </form>
                </div>
            </div>
        </div>
<?php
require_once('../template/footer.php'); //引入尾部
require_once('./JS_script.php'); //引入JS
?>
<script>
document.getElementById('btn-changeID').onclick = function() {
    document.getElementById('changeID').removeAttribute('readonly');
};

</script>
</body>
</html>
