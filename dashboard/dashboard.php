<?php
	require_once('../template/db.inc.php')
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AQUA</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	<link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">
	<script src="https://d3js.org/d3.v5.min.js"></script>
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	<style>
		.color-purple{
			color: mediumorchid;
		}
		.color-pink{
			color: hotpink;
		}
		.color-yellow{
			color: goldenrod;
		}
	</style>
	
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
				<li class="active">網站管理系統</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">AQUA-網站管理系統</h1>
			</div>
		</div><!--/.row-->
		<div class="panel panel-container">
			<div class="row">
				<?php
					$sql_item = "SELECT COUNT(*) FROM `items`";
					$stmtitem = $pdo->query($sql_item)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../items/items.php">
					<div class="col-xs-6 col-md-3 col-lg-3 no-padding">	
						<div class="panel panel-teal panel-widget border-right">
							<div class="row no-padding"><em class="fa fa-xl fa-shopping-bag color-purple"></em>
								<div class="large"><?php echo $stmtitem; ?></div>
								<div class="text-muted">Products</div>
							</div>
						</div>
					</div>
				</a>
				<?php
					$sql_class = "SELECT COUNT(*) FROM `class_data`";
					$stmtclass = $pdo->query($sql_class)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../AQUA_class/class_admin.php">
					<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
						<div class="panel panel-blue panel-widget border-right">
							<div class="row no-padding"><em class="fa fa-xl fa-university color-orange"></em>
								<div class="large"><?php echo $stmtclass; ?></div>
								<div class="text-muted">Classes</div>
							</div>
						</div>
					</div>
				</a>
				<?php
					$sql_event = "SELECT COUNT(*) FROM `event_data`";
					$stmtevent = $pdo->query($sql_event)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../AQUA_event/event-admin.php">
					<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
						<div class="panel panel-orange panel-widget border-right">
							<div class="row no-padding"><em class="fa fa-xl fa-futbol-o color-black"></em>
								<div class="large"><?php echo $stmtevent; ?></div>
								<div class="text-muted">Events</div>
							</div>
						</div>
					</div>
				</a>
				<?php
					$sql_Articles = "SELECT COUNT(*) FROM `blog`";
					$stmtArticles = $pdo->query($sql_Articles)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../blog/blog.php">
					<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
						<div class="panel panel-red panel-widget ">
							<div class="row no-padding"><em class="fa fa-xl fa-book color-yellow"></em>
								<div class="large"><?php echo $stmtArticles; ?></div>
								<div class="text-muted">Articles</div>
							</div>
						</div>
					</div>
				</a>
			</div>
		</div>


		<div class="panel panel-container">
			<div class="row">
				<?php
					$sql_user = "SELECT COUNT(*) FROM `my_member`";
					$stmtuser = $pdo->query($sql_user)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../member/member.php">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-teal panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-users color-blue"></em>
							<div class="large"><?php echo $stmtuser; ?></div>
							<div class="text-muted">Users</div>
						</div>
					</div>
				</div>
				</a>
				<?php
					$sql_seller = "SELECT COUNT(*) FROM `basic_information`";
					$stmtseller = $pdo->query($sql_seller)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../aqua_seller./seller.php">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-blue panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-user-o color-pink"></em>
							<div class="large"><?php echo $stmtseller; ?></div>
							<div class="text-muted">Sellers</div>
						</div>
					</div>
				</div>
				</a>
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-orange panel-widget border-right">
						<div class="row no-padding"><em class="fa fa-xl fa-shopping-cart color-teal"></em>
							<div class="large"><?php echo 45; ?></div>
							<div class="text-muted">Orders</div>
						</div>
					</div>
				</div>
				<?php
					$sql_location = "SELECT COUNT(*) FROM `location`";
					$stmtlocation = $pdo->query($sql_location)->fetch(PDO::FETCH_NUM)[0];
				?>
				<a href="../location/location.php">
				<div class="col-xs-6 col-md-3 col-lg-3 no-padding">
					<div class="panel panel-red panel-widget ">
						<div class="row no-padding"><em class="fa fa-xl fa-map-marker color-red"></em>
							<div class="large"><?php echo $stmtlocation; ?></div>
							<div class="text-muted">Locations</div>
						</div>
					</div>
				</div>
				</a>
			</div>
		</div>	
		<div class="row">
			<div class="col-md-6">
				<div class="panel panel-default">
					<div class="panel-heading">資料數據</div>
					<div class="panel-body">
						
					</div>
				</div>
			</div><!--/.col-->
			<div class="col-md-6">
				<div class="panel panel-default ">
					<div class="panel-heading">
						Team Works
						<ul class="pull-right panel-settings panel-button-tab-right">
							<li class="dropdown"><a class="pull-right dropdown-toggle" data-toggle="dropdown" href="#">
								<em class="fa fa-cogs"></em>
							</a>
								<ul class="dropdown-menu dropdown-menu-right">
									<li>
										<ul class="dropdown-settings">
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 1
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 2
											</a></li>
											<li class="divider"></li>
											<li><a href="#">
												<em class="fa fa-cog"></em> Settings 3
											</a></li>
										</ul>
									</li>
								</ul>
							</li>
						</ul>
						<span class="pull-right clickable panel-toggle panel-button-tab-left"><em class="fa fa-toggle-up"></em></span></div>
					<div class="panel-body timeline-container">
						<ul class="timeline">
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">戴靖</h4>
									</div>
									<div class="timeline-body">
										<p>廠商資料管理相關</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">張元昊</h4>
									</div>
									<div class="timeline-body">
										<p>地點資訊</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">江瑀</h4>
									</div>
									<div class="timeline-body">
										<p>活動/課程相關</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">饒家鴻</h4>
									</div>
									<div class="timeline-body">
										<p>部落格文章系統管理</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">蘇騰瑜</h4>
									</div>
									<div class="timeline-body">
										<p>會員資料管理</p>
									</div>
								</div>
							</li>
							<li>
								<div class="timeline-badge"><em class="glyphicon glyphicon-thumbs-up"></em></div>
								<div class="timeline-panel">
									<div class="timeline-heading">
										<h4 class="timeline-title">莊振維</h4>
									</div>
									<div class="timeline-body">
										<p>商品/訂單資料管理</p>
									</div>
								</div>
							</li>
						</ul>
					</div>
				</div>
			</div><!--/.col-->
			<div class="col-sm-12">
				<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
			</div>
		</div><!--/.row-->
	</div>	<!--/.main-->
	<script>
		
	</script>
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script>
	<script>
		window.onload = function () {
	var chart1 = document.getElementById("line-chart").getContext("2d");
	window.myLine = new Chart(chart1).Line(lineChartData, {
	responsive: true,
	scaleLineColor: "rgba(0,0,0,.2)",
	scaleGridLineColor: "rgba(0,0,0,.05)",
	scaleFontColor: "#c5c7cc"
	});
};
	</script>
		
</body>
</html>