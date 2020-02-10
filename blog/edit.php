<?php
require_once('../template/db.inc.php');
?>	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>部落格資料管理</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
<?php
    require_once("../template/header.php");
    require_once("../template/sidebar.php");
?>
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li><a href="./blog.php" style="text-decoration: none">Blog</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1><b>Edit</b></h1>
			</div>
		</div><!--/.row-->
        <form name="myForm" method="POST" action="./updateEdit.php" enctype="multipart/form-data">
            <?php
                $sql = "SELECT `blogId`, `blogCategory`, `blogTitle`, `blogContent`, `blogImages`
                        FROM `blog`
                        WHERE `blogId` = ?";
                
                //設定繫結值
                $arrParam = [$_GET['editId']];

                //查詢
                $stmt = $pdo->prepare($sql);
                $stmt->execute($arrParam);
                if($stmt->rowCount() > 0) {
                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">文章內容</div>
                        <div class="panel-body">
                            <div class="form-group">
                                <div class="form-group col-md-2">
                                <label style="font-size: 20px">編號</label>
                                <input type="text" class="form-control" name="blogId"  value="<?php echo $arr[0]['blogId']; ?>" maxlength="10" readonly />
                                </div>
                                <div class="form-group col-md-1">
                                    <label  style="font-size: 20px">類型</label>
                                    <select class="form-control"  style="height: 46px; width: 76px;" name="blogCategory" id="blogCategory">
                                        <option value="<?php echo $arr[0]['blogCategory']; ?>" selected><?php echo $arr[0]['blogCategory']; ?></option>
                                        <option value="情報">情報</option>
                                        <option value="心得">心得</option>
                                        <option value="問題">問題</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group col-md-12">
                                <label style="font-size: 20px">標題</label>
                                <input type="text" class="form-control" name="blogTitle" id="blogTitle" maxlength="40" value="<?php echo $arr[0]['blogTitle']; ?>">
                            </div>
                            <div class="form-group col-md-6" >
                                <textarea name="blogContent" id="editor1" cols="30" rows="10" ><?php echo $arr[0]['blogContent']; ?></textarea>
                            </div>
                            <div class="form-group">
                            <?php if($arr[0]['blogImages'] !== NULL) { ?>
                                <img style="width:200px" id='blah' class="col-md-2" src="../image/blog/<?php echo $arr[0]['blogImages']; ?>" />
                                <?php } ?>
                            <input type="file" name="blogImages" class="col-md-3" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"/>
                            </div>
                            <div class="form-group col-md-12">
                                <input type="submit" class="btn btn-primary col-md-12" style="font-size: 20px" value="修改文章"></input>
                            </div>						
                        </div>	
                    </div></.panel
                <?php
                } else {
                ?>
                    <tr>
                        <td class="border" colspan="6">沒有資料</td>
                    </tr>
                <?php
                }
                ?>
            <input type="hidden" name="editId" value="<?php echo $_GET['editId']; ?>">
		</form>	

		<div class="col-sm-12">
			<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
		</div>
	</div><!--/.main-->
<!-- 	
<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script> -->
    <script src="https://cdn.ckeditor.com/4.7.3/standard/ckeditor.js"></script>
	<script>CKEDITOR.replace("editor1");</script>

	
</body>
</html>