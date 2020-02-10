<?php
require_once('../template/db.inc.php'); //引入資料庫連線
require_once('./html_title.php'); //引入html head資訊
?>
<body>
<?php
require_once('../template/header.php'); //引入頭部導航列
require_once('../template/sidebar.php'); //引入側欄
?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="../index.php">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active text-primary"><a class="" href="./event-admin.php">揪團管理首頁</a></li>
                <li class="active">新增揪團</li>
			</ol>
	    </div>
            <div class="panel panel-default">
                <div class="panel-heading">新增揪團</div>
                <div class="panel-body">
                    <h4>揪團圖片</h4>
                    <figure class="eventImg">
                        <img id="blah" alt="">
                    </figure>
                    <form name="myForm" method="POST" action="./insert_event.php"  role="form" enctype="multipart/form-data">
                        <div class="col-md-5">
                            <div class="form-group">
                            <?php
                                //查出現在的年月(4碼+2碼) 用來 做WHERE條件比對
                                $checktime = date("Y-m");

                                //查出當月份 idd欄位的最大值
                                $sqlMAX = "   SELECT MAX(`maxId`) AS `MAX`
                                                FROM `event_data` 
                                                WHERE DATE_FORMAT(`created_at`,'%Y-%m') = '$checktime'";

                                $MAX = $pdo->query($sqlMAX)->fetch(PDO::FETCH_NUM)[0];
                                $maxId = $pdo->query($sqlMAX)->fetch(PDO::FETCH_NUM);
                                // 抓出現在年(2碼),月份
                                $time = date("ym");
                                // total轉成數值後+1 再用str_pad函式 設定4位數 位數空位補 0  
                                $MAX_num = str_pad((int)$MAX+1,4,'0',STR_PAD_LEFT);
                            ?>
                                <label>揪團編號</label>
                                <input class="form-control" type="text" name="eventId" value="<?php echo 'E'.$time.$MAX_num ?>" readonly="value">
                                <!-- 取出最大值並傳送到後端PHP程式做 +1後存進資料庫 -->
                                <input class="form-control" type="hidden" name="maxId" value="<?php echo $maxId[0] ?>" readonly="value">
                            </div>
                            <div class="form-group">
                                <label>活動日期</label>
                                <input type="datetime-local" id="eventStartDate" class="form-control"  name="eventStartDate" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00">
                            </div>
                            <div class="form-group">
                                <label>徵求人數</label>
                                <input type="text" id="eventNeedPeople" class="form-control" maxlength="2" name="eventNeedPeople" >
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">揪團類型</label>
                                <select name="eventTypeId" class="form-control">

                                <!-- 抓出event_type這張資料表中的所有類型 -->
                                <?php
                                    $sqlGetType =  "SELECT `eventTypeName`,`eventTypeId`
                                                    FROM `event_type`";
                                    // 執行sql語法
                                    $stmtGetType = $pdo->prepare($sqlGetType);
                                    $stmtGetType->execute();

                                    // 如果影響行數大於0，則表示有資料，就印出資料
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
                                <label>主揪者</label>
                                <input type="text"" class="form-control" maxlength="30" name="eventSponsor" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>揪團主題</label>
                                <input type="text" class="form-control" maxlength="50" name="eventName" placeholder="最多50字元">
                            </div>
                            <div class="form-group">
                                <label id="endDateTitle">報名截止日期</label>
                                <input type="datetime-local" id="eventEndDate" class="form-control"  name="eventEndDate" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00">
                            </div>
                            <div class="form-group">
                                <label id="nowPeopleTitle">目前人數</label>
                                <input type="text" id="eventNowPeople" class="form-control" maxlength="2" name="eventNowPeople" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">揪團地點</label>
                                <select name="eventLocal" class="form-control" id="localid">
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
                                <textarea type="text" class="textarea form-control" maxlength="1000" name="eventDesc" placeholder="最多1000字元"></textarea>
                            </div>
                            <button id="btn-addcategory" type="submit" class="btn btn-primary">新增</button>
                        </div>
                    </form>
                </div>
            </div>

<?php
require_once('../template/footer.php'); //引入尾部
require_once('./JS_script.php'); //引入js
?>
<script>
    //判斷目前人數是否大於徵求人數
    $('#eventNowPeople').change(function(){
        let Now = parseInt($('input#eventNowPeople').val());
        let Need = parseInt($('input#eventNeedPeople').val());
        if ( Now > Need ){
            $('p').remove('.warning');
            $('label#nowPeopleTitle').append('<p class="warning">目前人數不可大於徵求人數!</p>');
        } else {
            $('p').remove('.warning');
        };
    });
    
</script>
</body>
</html>
