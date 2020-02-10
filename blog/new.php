<?php
require_once("../template/header.php");
require_once('../template/db.inc.php');
require_once("../template/sidebar.php");
?>	
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>blog資料管理</title>
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
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li><a href="./blog.php" style="text-decoration: none">Blog</a></li>
				<li><a href="./new.php" style="text-decoration: none">Add</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1><b>Add</b></h1>
			</div>
		</div><!--/.row-->
		<form name="myForm" method="POST" action="./insert.php" enctype="multipart/form-data">
				<?php
					$checktime = date("Y-m");
					$sqlTotal = "SELECT MAX(`idd`) AS `MAX`
								FROM `blog`
								WHERE DATE_FORMAT(`created_at`,'%Y-%m') = '$checktime'";
					$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
					$idd = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM);
					$time = date("ym");
					$total_num = str_pad((int)$total+1,4,'0',STR_PAD_LEFT);
				?>
				<div class="panel panel-default">
					<div class="panel-heading">發表新文章</div>
					<div class="panel-body">
						<div class="form-group">
							<div class="form-group col-md-2">
							<label style="font-size: 20px">編號</label>
							<input type="text" class="form-control" name="blogId"  value="<?php echo 'B'.$time.$total_num ?>" maxlength="10" readonly />     
							<input type="hidden" name="idd" value="<?php echo $idd[0] ?>">
							</div>
							<div class="form-group col-md-1">
								<label  style="font-size: 20px">類型</label>
								<select class="form-control"  style="height: 46px; width: 76px;" name="blogCategory" id="blogCategory">
									<option value="情報">情報</option>
									<option value="心得">心得</option>
									<option value="問題">問題</option>
								</select>
							</div>
						</div>
						<div class="form-group col-md-12">
							<label style="font-size: 20px">標題</label>
							<input type="text" class="form-control" name="blogTitle" id="blogTitle" maxlength="20">
						</div>
						<div class="form-group col-md-6 ">
							<textarea name="blogContent" id="editor1" ></textarea>
						</div>
						<img style="width:200px" id='blah' class="col-md-2" src="../image/blog/"/>
						<input type="file" name="blogImages" class="col-md-4" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"/>
						<div class="form-group col-md-12">
							<input type="submit" class="btn btn-primary col-md-12" style="font-size: 20px" value="發佈文章"></input>
						</div>						
					</div>	
				</div></.panel
		</form>	
		<div class="col-sm-12">
			<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
		</div>
	</div>  
	
<!-- <script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script> -->
	<script src="//cdn.ckeditor.com/4.13.1/standard/ckeditor.js"></script>	
	<script>CKEDITOR.replace("editor1");</script>
	
</body>
</html>
