<?php 
require_once("../template/db.inc.php");

// $sqlTotal = "SELECT count(1) FROM `my_member`";
// //取得總筆數
// $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
// //每頁幾筆
// $numPerPage = 10;
// // 總頁數
// $totalPages = ceil($total/$numPerPage); 
// //目前第幾頁
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// //若 page 小於 1，則回傳 1
// $page = $page < 1 ? 1 : $page;
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>會員資料管理</title>
	<link rel="shortcut icon" href="..\image\aquafavicon.png">
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<!-- <script src="./js/sorttable.js"></script> -->
	<link rel="stylesheet" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
	<style>
		.functionsize{
			width:20px;
		}
		/* .changecolor{
			background-color: rgb(52,165,251);
		} */
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
				<li class="active">會員名單</a></li>
				<!-- <li class="active"><a href="./ranking.php">級別狀態</a></li> -->
				<li class="active"><a href="./new.php">新增會員</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">會員名單</h1>
			</div>
		</div><!--/.row-->
		<!-- <form name="myForm" method="POST" action=""> --> 
			<table class="table sortable" id="myTable">
				<thead class="thead-dark changecolor">
				  <tr>
					<th>會員編號</th>
					<th>會員帳號</th>
					<!-- <th>會員密碼</th> -->
					<!-- <th class="sorttable_nosort">會員頭像</th> -->
					<th>會員姓名</th>
					<th>會員性別</th>
					<th>會員生日</th>
					<th>電子郵件</th>
					<th>手機號碼</th>
					<!-- <th>會員地址</th> -->
					<!-- <th>加入日期</th> -->
					<th>狀態</th>
					<!-- <th>創造日期</th>
					<th>更新日期</th> -->
					<!-- <th class="sorttable_nosort">功能</th> -->
					<th>功能</th>
				  </tr>
				</thead>
				<tbody>
				<?php 
					$sql = "SELECT `memberId`, `loginId`, `loginPwd`, `avatar`, `fullName`, `gender`, `birthDate`, `email`, `mobileNumber`, `address`, `joinDate`, `currentStatus`,`created_at`, `updated_at`
							FROM `my_member`
							ORDER BY `memberId` ASC";
							// LIMIT ?, ? ";

					// $arrParam = [($page-1) * $numPerPage, $numPerPage];

					$stmt = $pdo->prepare($sql);
					// $stmt->execute($arrParam);
					$stmt->execute();

					if($stmt->rowCount() > 0){
						$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
						for($i = 0; $i < count($arr); $i++){
				?>
				<tr>
					<td><?php echo $arr[$i]['memberId'] ?></td>
					<td><?php echo $arr[$i]['loginId'] ?></td>
					<!-- <td><?php echo $arr[$i]['loginPwd'] ?></td> -->
					<!-- <td><?php if ($arr[$i]['avatar'] !== NULL){ ?>
						<img src="./Img/<?php echo $arr[$i]['avatar'] ?>">
					</td>					
					<?php } ?> -->
					<td><?php echo $arr[$i]['fullName'] ?></td>
					<td><?php echo $arr[$i]['gender'] ?></td>
					<td><?php echo $arr[$i]['birthDate'] ?></td>
					<td><?php echo $arr[$i]['email'] ?></td>
					<td><?php echo $arr[$i]['mobileNumber'] ?></td>
					<!-- <td><?php echo $arr[$i]['address'] ?></td>
					<td><?php echo $arr[$i]['joinDate'] ?></td> -->
					<td><?php echo $arr[$i]['currentStatus'] ?></td>
					<!-- <td><?php echo $arr[$i]['created_at'] ?></td>
					<td><?php echo $arr[$i]['updated_at'] ?></td> -->
					<td>
                    	<a href="./edit.php?editId=<?php echo $arr[$i]['memberId'] ?>"><img name="search" class="functionsize" src="../image/search.png" alt=""></a>
                    	<a href="./delete.php?deletememberId=<?php echo $arr[$i]['memberId']; ?>"><img name="recycle"class="functionsize" src="../image/recycle.png" alt=""></a>
					</td>
				</tr>
				<?php
						}
					}
				?>
				</tbody>
				<!-- <tfoot>
					<tr>
						<td class="border" colspan="9">
							<?php for($i = 1; $i <= $totalPages; $i++){ ?>
							<a href="?page=<?= $i ?>"><?= $i ?></a>
							<?php } ?>
						</td>
					</tr>
				</tfoot> -->
			  </table>
		<!-- </form> -->
<?php
require_once("../template/footer.php");
?>

<script src="../js/jquery-1.11.1.min.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<!-- <script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script> -->
	<!-- <script src="js/easypiechart.js"></script> -->
	<!-- <script src="js/easypiechart-data.js"></script> -->
	<script src="../js/bootstrap-datepicker.js"></script>
	<script src="../js/custom.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready( function () {
		$('#myTable').DataTable();
		} );
	</script>
	
</body>
</html>
