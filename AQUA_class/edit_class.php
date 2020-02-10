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
				<li class="active text-primary"><a class="" href="./class_admin.php">課程管理首頁</a></li>
                <li class="active">編輯課程</li>
			</ol>
		</div>
<?php
    // 取得預設在資料庫內的資料
    // 透過DATE_FORMAT將從資料庫取得的資料格式化為HTML5 datetime-local格式
    $sql = "SELECT `classId`,`className`,`classTypeId`,`classLevelID`,`classPrice`,
            DATE_FORMAT(`classStartDate`, '%Y-%m-%dT%H:%i') AS StartDate,
            `classDesc`,`classMAXpeople`,`classNOWpeople`,`classImg`,`sellerID` 
            FROM `class_data`
            WHERE `classId` = ? ";

    //取得課程類型的資料
    $sql_Type = "SELECT `class_type`.`classTypeName` 
                 FROM `class_data` 
                 INNER JOIN `class_type` 
                 ON `class_data`.`classTypeId` = `class_type`.`classTypeId`
                 WHERE `class_data`.`classId` = ? ";
    //取得課程等級資料
    $sql_level = "SELECT `class_level`.`classLevelId`,`class_level`.`classLevel`
                  FROM `class_level` 
                  INNER JOIN `class_data`
                  ON `class_level`.`classLevelId` = `class_data`.`classLevelID`
                  WHERE `class_data`.`classId` = ? ";

    //取得參加者資料
    $sql_member = "SELECT `class_data`.`classId`,`class_member`.`classJoinMember`,`class_member`.`memberMemo`
                   FROM `class_member`
                   INNER JOIN `class_data`
                   ON `class_data`.`classId` = `class_member`.`classId`
                   WHERE `class_data`.`classId` = ? ";

    //共用繫結資料
    $arrParam = [
        $_GET['editclassId']
    ];

    //執行參加會員的sql語法
    $stmt_member = $pdo->prepare($sql_member);
    $stmt_member->execute($arrParam);

    //執行地點的sql語法
    $stmt_level = $pdo->prepare($sql_level);
    $stmt_level->execute($arrParam);

    //執行類型的sql語法
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
                <div class="panel-heading">編輯課程</div>
                <div class="panel-body">

                    <!-- 如果資料庫中'eventImg'這個值存在就印出圖片-->
                    <?php if( $arr['classImg'] !== NULL){ ?>
                    <h4>課程圖片</h4>
                    <figure class="eventImg">
                        <img id="blah" src="../image/classImg/<?php echo $arr['classImg'];?>" alt="">
                    </figure>
                    <?php } ?>

                    <form name="myForm" method="POST" action="./update_class.php"  role="form" enctype="multipart/form-data">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>課程編號</label>
                                <input type="text" class="form-control" maxlength="11" name="classId"  value="<?php echo $arr['classId']; ?>" readonly="value">
                            </div>
                            <div class="form-group">
                                <label>開課日期</label>
                                <input type="datetime-local" min="0000-01-00T00:00:00" max="9999-12-31T00:00:00" class="form-control"  name="classStartDate"  value = "<?php echo $arr['StartDate']; ?>">
                            </div>
                            <div class="form-group">
                                <label>最大人數</label>
                                <input type="text" id="classMAXpeople" class="form-control" maxlength="3" name="classMAXpeople" value = "<?php echo $arr['classMAXpeople']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">課程類型</label>
                                <select name="classTypeId" class="form-control" id="select_Type">

                                    <!-- 先抓出原本資料庫中的值 -->
                                    <?php
                                    if($stmt_Type->rowCount() > 0){
                                        $arrType = $stmt_Type->fetchAll(PDO::FETCH_ASSOC)[0];
                                    ?>
                                        <option value="<?php echo $arr['classTypeId'] ;?>">*原始值* <?php echo $arrType['classTypeName']; ?></option>
                                    <?php
                                    } else {
                                        unset($stmt_Type);
                                    ?>
                                        <option value="<?php echo $arr['classTypeId'] ;?>">*無系統預設值*</option>
                                    <?php
                                    }
                                    ?>

                                <!-- 再抓出class_type這張資料表中的所有類型 -->
                                <?php
                                    $sqlGetType =  "SELECT `classTypeName`,`classTypeId`
                                                    FROM `class_type`";
                                    $stmtGetType = $pdo->prepare($sqlGetType);
                                    $stmtGetType->execute();
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
                                <label>賣家</label><span><a href="../aqua_seller/edit.php?editId=<?php echo $arr['sellerID']; ?>">查看</a></span><input type="button" value="修改" id="btn-changeID">
                                <input type="text" class="form-control" maxlength="30" name="sellerID" id="changeID" value = "<?php echo $arr['sellerID']; ?>"  readonly="value" >
                            </div>
                        </div>
                        <div class="col-md-5">
                            <div class="form-group">
                                <label>課程名稱</label>
                                <input type="text" class="form-control" maxlength="50" name="className" placeholder="最多50字元" value = "<?php echo $arr['className']; ?>">
                            </div>
                            <div class="form-group">
                                <label>課程售價</label>
                                <input type="text" class="form-control" maxlength="6" name="classPrice"  value = "<?php echo $arr['classPrice']; ?>">
                            </div>
                            <div class="form-group">
                                <label id="nowPeopleTitle">目前人數</label>
                                <input type="text" id="classNOWpeople" class="form-control" maxlength="3" name="classNOWpeople" placeholder="" value = "<?php echo $arr['classNOWpeople']; ?>">
                            </div>
                            <div class="form-group">
                                <label for="formGroupExampleInput">課程等級</label>
                                <select name="classLevelId" class="form-control" id="select_level">

                                <!-- 先抓出原本資料庫中的等級 -->
                                <?php
                                    
                                    if($stmt_level->rowCount() > 0 ){
                                        $arrlevel = $stmt_level->fetchAll(PDO::FETCH_ASSOC)[0];
                                    ?>
                                        <option value="<?php echo $arrlevel['classLevelId'] ;?>">*原始值* <?php echo $arrlevel['classLevel']; ?></option>
                                    <?php
                                    } else {
                                        unset($stmt_level);
                                    ?>
                                        <option value="<?php echo $arr['classLevelId'] ;?>">*無系統預設值*</option>
                                    <?php
                                    } 
                                    ?>
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
                                <textarea type="text" class="textarea form-control" maxlength="3000" name="classDesc" placeholder="最多3000字元" ><?php echo $arr['classDesc']; ?></textarea>
                            </div>
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>報名會員</th>
                                        <th>會員備註</th>
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
                                            <td><?php echo $arrMember[$k]['classJoinMember']; ?></td>
                                            <td><?php echo $arrMember[$k]['memberMemo']; ?></td>
                                            <td>
                                                <a href="./delete_classJoin.php?classid=<?php echo $arrMember[$k]['classId'];?>&memberid=<?php echo $arrMember[$k]['classJoinMember'] ;?>">取消</a>
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
                            <input type="hidden" name="editId" value="<?php echo $_GET['editclassId']; ?>">
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

$("select#select_Type").change(function(){
    //每次執行這個函式時，就會刪除原本的已存在選項，否則會一直疊加選項 .empty函式會刪除所有子元素
    $('select#select_level').empty()
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

document.getElementById('btn-changeID').onclick = function() {
    document.getElementById('changeID').removeAttribute('readonly');
};
    


</script>
</body>
</html>
