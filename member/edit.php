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
	<!-- <script src="./js/sorttable.js"></script> -->
	
	
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
					<em class="fa fa-home"></em></a></li>
				<li class="active"><a href="./member.php">會員名單</a></li>
				<!-- <li class="active"><a href="./ranking.php">級別狀態</a></li> -->
				<li class="active"><a href="./new.php">新增會員</a></li>
			</ol>
		</div><!--/.row-->
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">查看</h1>
			</div>
		</div><!--/.row-->
		<!-- <hr> -->

		<form name="myForm" method="POST" action="./updateEdit.php" enctype="multipart/form-data">
        <?php
        $sql = "SELECT `rankCoin`, `rankId`, `memberId`, `loginId`, `loginPwd`, `fullName`, `gender`, `birthDate`, `email`, `mobileNumber`, `address`, `avatar`, `joinDate`, `currentStatus`, `created_at`, `updated_at`
                FROM `my_member`
                WHERE `memberId` = ?";

        $arrParam = [$_GET['editId']];

        $stmt = $pdo->prepare($sql);
        $stmt->execute($arrParam);
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(count($arr) > 0){
        }
        ?>
				<div class="panel panel-default">
					<div class="panel-heading">會員資料</div>
					<div class="panel-body">
				
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput">會員編號</label>
					<input type="text" name="memberId" value="<?php echo $arr[0]['memberId']; ?>" maxlength="9" class="form-control" id="formGroupExampleInput" placeholder="M20200101" readonly>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員姓名</label>
					<input type="text" name="fullName" value="<?php echo $arr[0]['fullName']; ?>" maxlength="20" class="form-control" id="formGroupExampleInput2" placeholder="FirstNameLastName" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員帳號</label>
					<input type="text" name="loginId" value="<?php echo $arr[0]['loginId']; ?>" maxlength="30" class="form-control" id="formGroupExampleInput2" placeholder="MaxLength: 30" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員密碼</label>
					<input type="text" name="loginPwd" value="<?php echo $arr[0]['loginPwd']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" placeholder="MaxLength: 10" required> 
					<!-- loginpwd varchar 40  -->
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">性別</label>
						<select name="gender" class="form-control" id="exampleFormControlSelect1" required>
                            <option value="<?php echo $arr[0]['gender']; ?>" selected><?php echo $arr[0]['gender']; ?></option>
							<option value="男">男</option>
							<option value="女">女</option>
						</select>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員生日</label>
					<input type="text" name="birthDate" value="<?php echo $arr[0]['birthDate']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" placeholder="EX: 2020-01-01" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">電子郵件</label>
					<input type="text" name="email" value="<?php echo $arr[0]['email']; ?>" maxlength="30" class="form-control" id="formGroupExampleInput2" placeholder="EX: random@gmail.com" required> 
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">手機號碼</label>
					<input type="text" name="mobileNumber" value="<?php echo $arr[0]['mobileNumber']; ?>" maxlength="12" class="form-control" id="formGroupExampleInput2" placeholder="EX: 0999-999-999" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">會員地址</label>
					<input type="text" name="address" value="<?php echo $arr[0]['address']; ?>" maxlength="30" class="form-control" id="formGroupExampleInput2" required>
				</div>
                <div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">加入日期</label>
					<input type="text" name="joinDate" value="<?php echo $arr[0]['joinDate']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" readonly>
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">會員狀態</label>
						<select name="currentStatus" maxlength="8" class="form-control" id="exampleFormControlSelect1" required>
                            <option value="<?php echo $arr[0]['currentStatus']; ?>" selected><?php echo $arr[0]['currentStatus']; ?></option>
							<option>ACTIVE</option>
							<option>INACTIVE</option>
							<option>SUSPENDED</option>
						</select>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">貝殼幣</label>
					<input type="text" name="rankCoin" value="<?php echo $arr[0]['rankCoin']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" required>
				</div>
				<div class="form-group col-lg-6">
					<label for="exampleFormControlSelect1">會員等級</label>
						<select name="rankId"" maxlength="8" class="form-control" id="exampleFormControlSelect1" required>
                            <option value="<?php echo $arr[0]['rankId']; ?>" selected><?php echo $arr[0]['rankId']; ?></option>
							<option>銅牌小丑魚</option>
							<option>銀牌海龜</option>
							<option>金牌海豚</option>
							<option>鑽石鯨魚</option>
						</select>
				</div>
				<div class="form-group col-lg-3">
					<label for="formGroupExampleInput2">會員頭像</label>
					<input type="file" name="avatar" onchange="document.getElementById('show').src = window.URL.createObjectURL(this. files[0])" class="form-control" id="formGroupExampleInput2">
                    <?php if($arr[0]['avatar'] !== NULL) { ?>
                        <img id="show" width="100px" height="100px" src="../image/avatar/<?php echo $arr[0]['avatar']; ?>" />
                    <?php } ?>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">創建日期</label>
					<input type="text" name="created_at" value="<?php echo $arr[0]['created_at']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" readonly>
				</div>
				<div class="form-group col-lg-6">
					<label for="formGroupExampleInput2">更新日期</label>
					<input type="text" name="updated_at" value="<?php echo $arr[0]['updated_at']; ?>" maxlength="10" class="form-control" id="formGroupExampleInput2" readonly>
				</div>
				<input type="hidden" name="editId" value="<?php echo $_GET['editId']; ?>">
				<button type="submit" name="smb" class="btn btn-primary form-group col-lg-12">修改</button>
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
