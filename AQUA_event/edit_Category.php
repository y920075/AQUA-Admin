<?php
require_once('../template/db.inc.php'); //引入資料庫連線
// echo '<pre>';
// print_r($_GET);
// echo '</pre>';
// exit();
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
				<li>
                    <a href="../index.php">
					    <em class="fa fa-home"></em>
				    </a>
                </li>
				<li class="active text-primary">
                    <a class="" href="./event-admin.php">揪團管理首頁</a>
                </li>
                <li class="active">
                    <a class="" href="./event-category.php">揪團類別一覽</a>
                </li>
                <li class="active">編輯類別</li>
			</ol>
	    </div>
		

<?php
    //查詢sql語法
    $sql = "SELECT `eventTypeId`,`eventTypeName`
            FROM `event_Type`
            WHERE `eventTypeId` = ? ";

    //繫結陣列
    $arrParam = [
        $_GET['editTypeId']
    ];
    //執行sql語法
    $stmt = $pdo->prepare($sql);
    $stmt->execute($arrParam);

    //如果影響行數大於0 就印出資料
    if($stmt->rowCount() > 0){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
?>
        <div class="panel panel-default">
            <div class="panel-heading">編輯類別</div>
                <div class="panel-body">
                    <div class="col-md-3">
                        <form name="myForm" method="POST" action="./update_Category.php"  role="form">
                            <div class="form-group">
                                <label>類別名稱</label>
                                <input type="text"" class="form-control" maxlength="10" name="eventTypeName"  value="<?php echo $arr['eventTypeName']; ?>" placeholder="最多10字元">
                            </div>
                            <button type="submit" class="btn btn-primary" >更新</button>
                            <input type="hidden" name="editId" value="<?php echo $_GET['editTypeId']; ?>">
                        </form>
                    </div>
                </div>
            </div>
        </div>
<?php
  } else {
      echo '查詢不到相關資料';
  }
require_once('../template/footer.php'); //引入尾部
require_once('./JS_script.php'); //引入JS
?>
</body>
</html>

