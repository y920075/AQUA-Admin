<?php
	require_once('../template/db.inc.php');
	?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>潛點資料管理</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<!-- <script src="../js/sorttable.js"></script> -->
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.20/css/jquery.dataTables.css">
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">

 

	<!--[if lt IE 9]>
	<script src="js/html5shiv.js"></script>
	<script src="js/respond.min.js"></script>
	<![endif]-->
</head>
<body>
	<?php
		require_once('../template/header.php');
		require_once('../template/sidebar.php');
	?>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">潛點資料管理</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<div class="panel-heading">潛點資料</div>
						<div class="panel-body">
							<div class="col-md-12">
								<table id="myTable" class="table">
									<thead>
										<tr>
											<th scope="col">地點編號</th>
											<th scope="col">地點名稱</th>
											<th scope="col">地點區域</th>
											<th scope="col">地點難度</th>
											<th scope="col">滿意度</th>
											<th scope="col" class="sorttable_nosort">地點描述</th>
											<th scope="col" class="sorttable_nosort">交通資訊</th>
											<th scope="col" class="sorttable_nosort">修改/刪除</th>
										</tr>
									</thead>
									<tbody>
										<?php
											$sql = "SELECT `LocationID`,`LocationName`, `LocationArea`,`Locationlevel`,`Satisfaction`,`Locationdescribe`,  	
														`Transportation`
													FROM `location`
													ORDER BY `LocationID` ASC";
											$stmt = $pdo->prepare($sql);
											$stmt->execute();
											if($stmt->rowCount() > 0) {
												$arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
												for($i = 0 ; $i < count($arr) ; $i++){
													?>
												<tr>
													<td><?php echo $arr[$i]['LocationID']; ?></td>
													<td><?php echo $arr[$i]['LocationName']; ?></td>
													<td><?php echo $arr[$i]['LocationArea']; ?></td>
													<td><?php echo $arr[$i]['Locationlevel']; ?></td>
													<td><?php echo $arr[$i]['Satisfaction']; ?></td>
													<td><?php echo $arr[$i]['Locationdescribe']; ?></td>
													<td><?php echo $arr[$i]['Transportation']; ?></td>
													<td><a href="./editlocation.php?editId=<?php echo $arr[$i]['LocationID']; ?>">編輯</a>
														<a href="./deletelocation.php?deleteId=<?php echo $arr[$i]['LocationID'];?>" onclick="return confirm('確定刪除?')">刪除</a>
													</td>
												</tr>
										<?php	}
											} ?>
									</tbody>
								</table>
							<a href="./addlocation.php"><button type="button" class="btn btn-md btn-primary">新增</button></a>
						</div>
					</div>
				</div><!-- /.panel-->
			</div><!-- /.col-->
			<div class="col-sm-12">
				<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
			</div>
		</div><!-- /.row -->
	</div><!--/.main-->
<script src="../js/jquery-3.4.1.min.js"></script>
<script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.js"></script>
	<script src="../js/bootstrap.min.js"></script>
	<script>
	$(document).ready( function () {
    $('#myTable').DataTable();
} );
	</script>
	<!-- <script src="../js/chart.min.js"></script>
	<script src="../js/chart-data.js"></script>
	<script src="../js/easypiechart.js"></script>
	<script src="../js/easypiechart-data.js"></script>
	<script src="../js/bootstrap-datepicker.js"></script>
	<script src="../js/custom.js"></script> -->
</body>
</html>
