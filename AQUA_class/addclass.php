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
				<li class="active text-primary"><a class="" href="./class_admin.php">課程管理首頁</a></li>
                <li class="active">新增課程</li>
			</ol>
	    </div>
            <div class="panel panel-default">
                <div class="panel-heading">新增課程</div>
                <div class="panel-body">
                    <h4>課程圖片</h4>
                    <figure class="eventImg">
                        <img id="blah" alt="">
                    </figure>
                    <form name="myForm" method="POST" action="./insert_class.php"  role="form" enctype="multipart/form-data">
                        <div class="col-md-5">
                        <div class="form-group">
                            <?php
                                //查出現在的年月(4碼+2碼) 用來 做WHERE條件比對
                                $checktime = date("Y-m");

                                //查出當月份 idd欄位的最大值
                                $sqlMAX = "   SELECT MAX(`maxId`) AS `MAX`
                                                FROM `class_data` 
                                                WHERE DATE_FORMAT(`created_at`,'%Y-%m') = '$checktime'";

                                $MAX = $pdo->query($sqlMAX)->fetch(PDO::FETCH_NUM)[0];
                                $maxId = $pdo->query($sqlMAX)->fetch(PDO::FETCH_NUM);
                                // 抓出現在年(2碼),月份
                                $time = date("ym");
                                // total轉成數值後+1 再用str_pad函式 設定4位數 位數空位補 0  
                                $MAX_num = str_pad((int)$MAX+1,4,'0',STR_PAD_LEFT);
                            ?>
                                <label>課程編號</label>
                                <input class="form-control" type="text" name="classId" value="<?php echo 'C'.$time.$MAX_num ?>" readonly="value">
                                <!-- 取出最大值並傳送到後端PHP程式做 +1後存進資料庫 -->
                                <input class="form-control" type="hidden" name="maxId" value="<?php echo $maxId[0] ?>" readonly="value">
                            </div>
                            <div class="form-group">
                                <label>開課日期</label>
                                <input type="datetime-local" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00" class="form-control"  name="classStartDate" placeholder="">
                            </div>
                            <div class="form-group">
                                <label>最大人數</label>
                                <input type="text" id="classMAXpeople" class="form-control" maxlength="3" name="classMAXpeople" placeholder="">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">課程類型</label>
                                <select name="classTypeId" class="form-control" id="select_Type">
                                    <option value="請選擇">請選擇</option>
                                <!-- 抓出event_type這張資料表中的所有類型 -->
                                <?php
                                    $sqlGetType =  "SELECT `classTypeName`,`classTypeId`
                                                    FROM `class_type`";
                                    // 執行sql語法
                                    $stmtGetType = $pdo->prepare($sqlGetType);
                                    $stmtGetType->execute();

                                    // 如果影響行數大於0，則表示有資料，就印出資料
                                    if($stmtGetType->rowCount() > 0){
                                        $arrGetType = $stmtGetType->fetchAll(PDO::FETCH_ASSOC);
                                        for($i = 0 ; $i < count($arrGetType) ; $i++){
                                        ?>
                                            <option value="<?php echo $arrGetType[$i]['classTypeId']; ?>"><?php echo $arrGetType[$i]['classTypeName']; ?></option>
                                    <?php
                                        }
                                    }
                                    ?>

                                </select>
                            </div>
                            <div class="form-group">
                                <label>賣家</label>
                                <input type="text" class="form-control" maxlength="30" name="sellerID" >
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>課程名稱</label>
                                <input type="text" class="form-control" maxlength="50" name="className" placeholder="最多50字元">
                            </div>
                            <div class="form-group">
                                <label>課程售價</label>
                                <input type="text" class="form-control"  maxlength="6" name="classPrice"  >
                            </div>
                            <div class="form-group">
                                <label id="nowPeopleTitle">目前人數</label>
                                <input type="text" id="classNOWpeople" class="form-control" maxlength="3" name="classNOWpeople" >
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">課程等級</label>
                                <select name="classLevelID" class="form-control" id="select_level">

                                </select>

                            </div>
                            <div class="form-group">
                                <label>上傳圖片</label>
                                <input type="file" class="form-control"  name="classImg" accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">
                            </div>
                        </div>
                        <div class="col-md-10">
                            <div class="form-group">
                                <label>課程說明</label>
                                <textarea type="text"  class="textarea form-control" maxlength="3000" name="classDesc" placeholder="最多3000字元"></textarea>
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

$("select#select_Type").change(function(){
    //每次執行這個函式時，就會刪除原本的已存在選項，否則會一直疊加選項 .empty函式會刪除所有子元素
    $('select#select_level').empty()
    //如果取得的值不是預設的'請選擇'的話就從資料庫抓資料回來
    if ( $('#select_Type').val() !== '請選擇' ) {
        $.ajax({
            //選擇要接收AJAX資料的php檔案
            url: "check_level.php", 
            //要傳送的過去的資料 'select_Type' 等同於 $_POST['select_Type'] 冒號後面則是它的值
            data: {select_Type : $('#select_Type').val()}, 
            //傳送的方式 
            type:'POST', 
            //傳送的資料格式
            dataType:'json', 

            //如果執行成功就執行success函式 引數data就是PHP傳送回來的資料
            success: function(data){
                //取得JSON字串長度
                let jsonlength = data.length; 
                //宣告變數以便迴圈中使用
                let i,id,level;
                //執行迴圈依照JSON長度新增選項
                for (  i = 0 ; i < jsonlength ; i++) {
                    //取得JSON字串裡面的等級編號
                    id = data[i]['classLevelId'];
                    //取得JSON字串裡面的等級名稱
                    level = data[i]['classLevel'];
                    //動態新增選項
                    $('#select_level').append(`<option value="${id}">${level}</option>`);
                };
            }
        });
    }
});


//判斷目前人數是否大於徵求人數
$('#classNOWpeople').change(function(){
    let Now = parseInt($('input#classNOWpeople').val());
    let Need = parseInt($('input#classMAXpeople').val());
    if ( Now > Need ){
        $('p').remove('.warning');
        $('label#nowPeopleTitle').append('<p class="warning">最大人數不可大於目前人數!</p>');
    } else {
        $('p').remove('.warning');
    };
});
    


</script>
</body>
</html>
