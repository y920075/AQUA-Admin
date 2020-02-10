<?php 
// require_once("./template/header.php");
require_once("../template/db.inc.php")
?>		
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>會員資料管理</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<script src="../js/sorttable.js"></script>
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<style>
		#show{
			position:absolute;
			vertical-align: middle;
			left:300px;
			top: 1px;
		}
	</style>
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
				<li class="active"><a href="./member.php">會員名單</a></li>
				<!-- <li class="active"><a href="./ranking.php">級別狀態</a></li> -->
				<li class="active">新增會員</></li>
			</ol>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">新增會員</h1>
			</div>
		</div><!--/.row-->
		<!-- <hr> -->
		<form name="myForm" method="POST" action="./insert.php" enctype="multipart/form-data">
				<div class="panel panel-default">
					<div class="panel-heading">會員資料</div>
					<div class="panel-body">
		<?php 
		$checktime = date("Y-m");

		$sqlTotal = "SELECT MAX(`idd`) AS `MAX` 
					 FROM `my_member` 
					 WHERE DATE_FORMAT(`created_at`,'%Y-%m') = '$checktime'"; 

		$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
		$idd = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM);
		$time = date("ym");
		$total_num = str_pad((int)$total+1,4,'0',STR_PAD_LEFT);
		?>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput">會員編號</label>
					<input type="text" name="memberId" class="form-control" id="formGroupExampleInput" maxlength="9" placeholder="Ex: M20200101" value="<?php echo 'M'.$time.$total_num ?>" readonly>
					<input type="hidden" name="idd" class="form-control" value="<?php echo $idd[0]?>" readonly>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員姓名</label>
					<input type="text" name="fullName" class="form-control" id="formGroupExampleInput2" maxlength="20" placeholder="FirstNameLastName" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員帳號</label>
					<input type="text" name="loginId" class="form-control" id="formGroupExampleInput2" maxlength="30" placeholder="MaxLength: 30" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員密碼</label>
					<input type="text" name="loginPwd" class="form-control" id="formGroupExampleInput2" maxlength="10" placeholder="MaxLength: 10" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">性別</label>
						<select name="gender" class="form-control" id="exampleFormControlSelect1" required>
							<option value="男">男</option>
							<option value="女">女</option>
						</select>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員生日</label>
					<input type="date" name="birthDate" class="form-control" id="formGroupExampleInput2" placeholder="" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">電子郵件</label>
					<input type="text" name="email" class="form-control" id="formGroupExampleInput2" placeholder="Ex: random888@gmail.com" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">手機號碼</label>
					<input type="text" name="mobileNumber" class="form-control" id="formGroupExampleInput2" maxlength="12" placeholder="Ex: 0999-999-999" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員地址</label>
					<input type="text" name="address" class="form-control" id="formGroupExampleInput2" placeholder="Enter Address Here" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">貝殼幣</label>
					<input type="text" name="rankCoin"" class="form-control" id="formGroupExampleInput2" maxlength="10" placeholder="MaxLength: 10" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">級別名稱</label>
						<select name="rankId" class="form-control" id="exampleFormControlSelect1" required>
							<option value="銅牌小丑魚">銅牌小丑魚</option>
							<option value="銀牌海龜">銀牌海龜</option>
							<option value="金牌海豚">金牌海豚</option>
							<option value="鑽石鯨魚">鑽石鯨魚</option>
						</select>
				</div>
				<div class="form-group col-lg-3">
					<label for="formGroupExampleInput2">會員頭像</label>
					<input type="file" name="avatar" onchange="document.getElementById('show').src = window.URL.createObjectURL(this. files[0])" class="form-control" id="formGroupExampleInput2" placeholder="" required> 
					<img id="show" width="100px" height="100px" src="" alt="">
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">加入日期</label>
					<input type="text" name="joinDate" class="form-control" id="formGroupExampleInput2" placeholder="" required readonly value="<?php echo date("Y-m-d");?>">
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">會員狀態</label>
						<select name="currentStatus" class="form-control" id="exampleFormControlSelect1" required>
							<option value="ACTIVE">ACTIVE</option>
							<option value="DEACTIVE">INACTIVE</option>
							<option value="SUSPENDED">SUSPENDED</option>
						</select>
				</div>
				<button type="submit" name="smb" class="btn btn-primary form-group col-lg-12">新增</button>
			</form>
					</div>
				</div><!-- /.panel-->
			</div><!-- /.col-->
		</div><!-- /.row -->
	</div><!--/.main-->
<?php
require_once("../template/footer.php");
?>
	
	<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script src="../js/chart.min.js"></script>
	<script src="../js/chart-data.js"></script>
	<script src="../js/easypiechart.js"></script>
	<script src="../js/easypiechart-data.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
	<script src="../js/custom.js"></script>	
</body>
</html>
