<?php
    require_once('../template/db.inc.php')
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>編輯潛點資料</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	<link href="../css/styles.css" rel="stylesheet">
	
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
                <li class="active">編輯潛點資料</li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">編輯潛點資料</h1>
			</div>
		</div><!--/.row-->
				<div class="panel panel-default">
					<div class="panel-body">
                        <form role="form" name="locationform" method="POST" action="./updatelocation.php" enctype="multipart/form-data">
                            <?php
                                $sql = "SELECT `LocationID`,`LocationName`,`LocationArea`,`Locationlevel`,`Satisfaction`,`Locationdescribe`,`Transportation`,`noted`
                                        From `location`
                                        WHERE `LocationID` = ? ";
                        
                                $arrparam = [$_GET['editId']];
                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($arrparam);
                                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
                                if(count($arr) > 0) {
                                    ?>
                            <div class="col-md-6">
								<div class="form-group">
									<label>潛點編號</label>
									<input class="form-control" name="LocationID" value="<?php echo $arr['LocationID'];?>"   maxlength=10 />
                                </div>
                                <div class="form-group">
									<label>地區</label>
									<select class="form-control" name="LocationArea">
                                        <option value="<?php echo $arr['LocationArea'];?>"><?php echo $arr['LocationArea'];?></option>
										<option>北海岸</option>
										<option>東北角</option>
										<option>花東海岸</option>
										<option>墾丁</option>
									</select>
                                </div>
								<div class="form-group">
									<label>地點滿意度</label>
									<div class="radio">
										<label>
											<input type="radio" name="Satisfaction" id="Satisfaction" value="★★★★★"<?php echo ($arr['Satisfaction'] == '★★★★★') ?  "checked" : "" ;  ?>>★★★★★
                                        </label>
                                        <label>
											<input type="radio" name="Satisfaction" id="Satisfaction" value="★★★★"<?php echo ($arr['Satisfaction'] == '★★★★') ?  "checked" : "" ;  ?>>★★★★
                                        </label>
                                        <label>
											<input type="radio" name="Satisfaction" id="Satisfaction" value="★★★"<?php echo ($arr['Satisfaction'] == '★★★') ?  "checked" : "" ;  ?>>★★★
                                        </label>
                                        <label>
											<input type="radio" name="Satisfaction" id="Satisfaction" value="★★"<?php echo ($arr['Satisfaction'] == '★★') ?  "checked" : "" ;  ?>>★★
                                        </label>
                                        <label>
											<input type="radio" name="Satisfaction" id="Satisfaction" value="★"<?php echo ($arr['Satisfaction'] == '★') ?  "checked" : "" ;  ?>>★
										</label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>地點描述</label>
                                    <textarea class="form-control" rows="3" name="Locationdescribe"><?php echo $arr['Locationdescribe']; ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                        <label>潛點名稱</label>
                                        <input class="form-control" name="LocationName" value="<?php echo $arr['LocationName']; ?>">
                                </div>
                                <div class="form-group">
                                    <label>潛點難度</label>
                                    <select class="form-control" name="Locationlevel">
                                        <option value="<?php echo $arr['Locationlevel'];?>"><?php echo $arr['Locationlevel'];?></option>
                                        <option>入門</option>
                                        <option>一般</option>
                                        <option>進階</option>
                                    </select>
                                </div>
                                <div class="form-group">
									<label>交通資訊</label>
									<textarea class="form-control" rows="1" name="Transportation"><?php echo $arr['Transportation']; ?></textarea>
								</div>
                                <div class="form-group">
									<label>備註</label>
                                    <textarea class="form-control" rows="3" name="noted" id="noted"><?php echo $arr['noted']; ?></textarea>
                                </div>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">送出</button>
                            </div>
                            <?php
        }
        ?>
                        <input type="hidden" name="editId" value="<?php echo $_GET['editId']; ?>">
						</form>
					</div>
				</div><!-- /.panel-->
			</div><!-- /.col-->
			<div class="col-sm-12">
				<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
			</div>
		</div><!-- /.row -->
	</div><!--/.main-->
	
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
