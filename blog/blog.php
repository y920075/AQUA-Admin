<!-- http://localhost/php7-mysql-examples/lumino/blog.php -->
<?php
require_once('../template/db.inc.php');
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
	<script src="../js/jquery-3.4.1.min.js"></script>
	<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
	<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script>
	$(document).ready( function () {
    $('#myTable').DataTable();
	} );
	</script>

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
		require_once("../template/header.php");
		require_once("../template/sidebar.php");
	?>	
	<div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
					</a>
				</li>
				<li><a href="./blog.php" style="text-decoration: none">Blog</a></li>
			</ol>
		</div><!--/.row-->
		
		<div class="row">
			<div class="col-lg-12">
				<h1><b>Blog</b></h1>
			</div>
		</div><!--/.row-->
		<br>
		<form name="myForm" method="POST" action="deleteIds.php" id="deleteIds">
		<a href="./new.php" ><img src="../image/blog/icon/add.png" width="30" height="30" alt="deleteId" style="margin-bottom: 10px"></a>
		
			<table  class="table table-hover"style="margin-bottom: 0px;" id="myTable" >
				<thead>
					<tr>
						<th style="width:10PX">選取</th>
						<th style="width:35px">編號</th>
						<th style="width:50px">類型</th>
						<th >標題</th>
						<th>圖片</th>
						<th >內容</th>
						<th style="width:120px">新增時間</th>
						<th style="width:120px">修改時間</th>
						<th style="width:80px">功能</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$sql = "SELECT `menberId`,`blogId`,`blogCategory`,`blogTitle`,`blogContent`,`blogImages`,`created_at`,`updated_at`
							FROM `blog`";

					$stmt = $pdo->prepare($sql);
					$stmt->execute();

					if( $stmt->rowCount() > 0 ){
						$arr= $stmt->fetchAll(PDO::FETCH_ASSOC);
						for($i = 0; $i < count($arr); $i++){
					?>

					<tr>
						<td>
							<input type="checkbox" style="width:20px ;height:20px" name="chk[]" value="<?php echo $arr[$i]['blogId']; ?>" />
						</td>				
						<td><?php echo $arr[$i]["blogId"]?></td>
						<td><?php echo $arr[$i]["blogCategory"]?></td>
						<td><?php echo $arr[$i]["blogTitle"]?></td>
						<td><?php if($arr[$i]['blogImages'] !== NULL) { ?><img style="width:100px; height: 100px" src="../image/blog/<?php echo $arr[$i]['blogImages']; ?>">
						<?php } ?>
						</td>
						<td  
						style=" max-width:350px;
						">
						<?php  
						$textorgin =  $arr[$i]["blogContent"];
						if(mb_strlen($textorgin,'utf-8') > 50){
							echo mb_substr($textorgin,0,65,"utf-8").'...'; 
						}else{
							echo $textorgin;
						}
					
						?>
						</td>
						<td><?php echo $arr[$i]["created_at"]?></td>
						<td><?php echo $arr[$i]["updated_at"]?></td>
						<td><a href="./edit.php?editId=<?php echo $arr[$i]["blogId"]?>"><img src="../image/blog/icon/edit.png" width="20" height="20" alt="edit"></a>
						<a href="./delete.php?deleteId=<?php echo $arr[$i]['blogId']; ?>"><img src="../image/blog/icon/delete.png" width="20" height="20" alt="delete"></a>
						</td>
					</tr>
					<?php	
						}
					}
					?>
				</tbody>
				<tfoot>
					<tr>
						<td style="border:none;padding:0px">
							<button type="submit" class="btn btn-danger " onclick="return myFunction()" ><b>Delete</b></button>
							
							<script>
								function myFunction() {
									deleteIDS = "";
									$('input[name*="chk"]:checked')
									.each(function(){
									// 	alert($(this).val());
										deleteIDS = $(this).val() + ',' +deleteIDS ;
									})
									if(confirm(deleteIDS+"確定要刪除嗎?")){
										return true;
									}else{
										return false;
									}
								}
							</script>
						</td>
					</tr>
				</tfoot>
			</table>
		</form>			
		
		<div class="col-sm-12">
			<p class="back-link">Lumino Theme by <a href="https://www.medialoot.com">Medialoot</a></p>
		</div>
	</div><!--/.main-->
	
<!-- <script src="js/jquery-1.11.1.min.js"></script> -->
	<!-- <script src="js/bootstrap.min.js"></script>
	<script src="js/chart.min.js"></script>
	<script src="js/chart-data.js"></script>
	<script src="js/easypiechart.js"></script>
	<script src="js/easypiechart-data.js"></script>
	<script src="js/bootstrap-datepicker.js"></script>
	<script src="js/custom.js"></script> -->
	
</body>
</html>
