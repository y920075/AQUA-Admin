<?php
require_once('../template/db.inc.php'); //引入資料庫連線
require_once('./html_title.php'); //引入hmtl head資訊
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
                <li class="active">課程類別管理</li>
			</ol>
		</div>
		
	<ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link  text-primary active" href="./class_admin.php">課程管理首頁</a>
        </li>
        <li class="nav-item">
            <a class="nav-link  text-primary active" href="./class-category.php">課程類別一覽</a>
        </li>
        <li class="nav-item">
            <a class="nav-link  text-primary active" href="./class_level.php">課程等級一覽</a>
        </li>
    </ul>

		
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">課程類別一覽</div>
                <div class="panel-body">
                    <div class="col-md-12">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                <th>課程類別編號</th>
                                <th>課程類別名稱</th>
                                <th>建立時間</th>
                                <th>更新時間</th>
                                <th>功能</th>
                                </tr>
                            </thead>
                            <tbody>
                            
                                <?php
                                    //查詢sql語法
                                    $sql = "SELECT `classTypeId`,`classTypeName`,`created_at`,`updated_at` 
                                            FROM `class_Type`";
                                    //執行sql語法
                                    $stmt = $pdo->prepare($sql);
                                    $stmt->execute();
                                    //如果影響行數大於0 就印出資料
                                    if($stmt->rowCount() > 0){
                                        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        for($i = 0 ; $i < count($arr) ; $i++){
                                ?>
                                <tr>
                                <td><?php echo $arr[$i]['classTypeId']; ?></td>
                                <td><?php echo $arr[$i]['classTypeName']; ?></td>
                                <td><?php echo $arr[$i]['created_at']; ?></td>
                                <td><?php echo $arr[$i]['updated_at']; ?></td>
                                <td>
                                    <a class="btn btn-primary" href="./edit_Category.php?editTypeId=<?php echo $arr[$i]['classTypeId']; ?>">編輯</a>
                                    <a class="btn btn-secondary" href="./delete_Category.php?deleteTypeId=<?php echo $arr[$i]['classTypeId']; ?>">刪除</a>
                                </td>
                                </tr>
                            </tbody>
                                <?php
                                        };
                                    };
                                ?>
                        </table>	  
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- 新增類別按鈕 -->
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">新增類別</button>

    <!-- 新增類別彈出式視窗內容 -->
    <div class="panel panel-default">
        <div class="modal" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">新增類別</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                    </button>
                </div>
                    <form name="myForm" method="POST" action="./insert_category.php"  role="form">
                        <div class="modal-body">
                            <div class="form-group">
                                <label>類別編號</label>
                                <input type="text"" class="form-control" maxlength="11" name="classTypeId" placeholder="格式為classType+2碼流水號">
                            </div>
                            <div class="form-group">
                                <label>類別名稱</label>
                                <input type="text"" class="form-control" maxlength="30" name="classTypeName" placeholder="最多30字元">
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">返回</button>
                            <button type="submit" class="btn btn-primary">新增</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


            
<?php
require_once('../template/footer.php'); //引入尾部
require_once('./JS_script.php'); //引入js
?>
</body>
</html>
