<?php
// require_once('./checkSession.php');
require_once('../template/db.inc.php');

$sqlTotal = "SELECT count(`orderId`) AS `count` FROM `orders`";
$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
// $numPerPage = 10;
// $totalPages = ceil($total/$numPerPage);
// $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
// $page = $page < 1  ? 1 : $page;


?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>AQUA ADMIN</title>
	<link href="../css/bootstrap.min.css" rel="stylesheet">
	<link href="../css/font-awesome.min.css" rel="stylesheet">
	<link href="../css/datepicker3.css" rel="stylesheet">
	
	<!--Custom Font-->
	<link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
	
	
	<link href="../css/styles.css" rel="stylesheet">
	<link href="../css/bootstrap4-table.css" rel="stylesheet">
	<script src="../js/jquery-3.4.1.min.js"></script>
	
	<link href="//cdn.datatables.net/1.10.20/css/jquery.dataTables.min.css" rel="stylesheet">
	<script src="//cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">
	<script>
		// $(document).ready( function () {
		// 	$('#myTable').DataTable();
		// 	} );
		
		

		
		
	</script>
    <style>
        .thead-light{
            margin-top: 10px;
        }
    </style>

</head>
<body>
	<?php
    require_once('../template/header.php');
	require_once('../template/sidebar.php');
	?>

    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
        <!-- main -->
        <div class="row"> <!-- breadcrumb -->
			<ol class="breadcrumb">
				<li>
					<a href="#">
						<em class="fa fa-home"></em>
					</a>
				</li>
				<li class="active">訂單資料管理</li>
			</ol>
        </div>
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">訂單列表</h1>
			</div>
		</div>
        <div class="row">
			<div class="col-lg-12">
				<div class="panel panel-default">
					<form name="myForm" method="POST" action="./itemBanned.php">
					<div class="panel-heading">全部</div>
					<div class="panel-body">
						<div class="col-md-12">


							<!-- <div class="form-group">
								
								<select class="form-control slt" name="itemTypeId" id="itemTypeId">
									<option value="蛙鞋" selected>蛙鞋</option>
									<option value="面鏡">面鏡</option>
									<option value="防寒衣">防寒衣</option>
								</select>
								<input type="text" name="" id="">

							</div> -->


							<span class="large col-lg-3"><?php echo $total; ?> Orders</span>
							<div class="col-lg-offset-8">

							

							
							
							</div>

							<table id="myTable" class="table sortable">
                                <thead class="thead-light">
                                    
                                        
                                        <th scope="col">買家</th>
                                        <th scope="col">商品名稱 </th>
                                        <th scope="col">數量 </th>
                                        <th scope="col">訂單金額 </th>
                                        <th scope="col">更新時間 </th>
                                        <th scope="col">操作 </th>
                                        
                                    
                                </thead>

								<?php
                                $sql = "SELECT `orders`.`orderMemberId`, `orders`.`orderId`, `items`.`itemImg`, `items`.`itemSellerId`, `items`.`itemName`, `orders`.`checkQty`, `orders`.`checkSubtotal`,`orders`.`updated_at`, `items`.`itemSize`, `items`.`itemPrice`
                                        FROM `orders`
                                        INNER JOIN `items`
                                        ON `orders`.`orderItemId` = `items`.`itemId`";
                                // $arrParam = [
                                //     ($page - 1) * $numPerPage,
                                //     $numPerPage];

                                $stmt = $pdo->prepare($sql);
                                $stmt->execute(); // $arrParam
                                if($stmt->rowCount() > 0){
                                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                    for($i = 0; $i < count($arr); $i++){
                                ?>
								<thead class="thead-light" style="margin-top: 10px">
									
										
										<th scope="col"><?php echo $arr[$i]['orderMemberId'] ?></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
                                        <th scope="col"></th>
										<th scope="col">訂單編號:<?php echo $arr[$i]['orderId'] ?> </th>
										
									
                                </thead>
								<tbody>
									<tr>
										
										<td>
                                            <img style="max-width: 100px " src="../image/items/<?php echo $arr[$i]['itemImg'] ?>">
										</td>
										<td><?php echo $arr[$i]['itemName']?></td>
										<td><?php echo 'x'.$arr[$i]['checkQty']?></td>
										<td><?php echo "\$".$arr[$i]['checkSubtotal']?></td>
										<td><?php echo $arr[$i]['updated_at']?></td>
										<td>
										<button type="button" onclick="check(this.form)" class="btn btn-default" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>查看詳情</button>
                                            
                                        </td>
                                    </tr>

									<div class="modal bd-example-modal-sm" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
										<div class="modal-dialog modal-sm" role="document">
											<form name="myForm" method="POST" action="./itemBatch.php" enctype="multipart/form-data">
											<div class="modal-content">
												<div class="modal-header">
													<span class="modal-title" id="exampleModalLabel">訂單明細</span>
													<button type="button" class="close" data-dismiss="modal" aria-label="Close">
													<span aria-hidden="true">&times;</span>
													</button>
												</div>
												<div class="modal-body">
												<div class="col-md-12">
													
														<label>商品名稱</label>
														<input class="form-control" type="text" name="itemName" id="itemName" value="" maxlength="100">
													


												</div>
												

												</div>
												<div class="modal-footer">
													<button type="submit" class="btn btn-primary">確定</button>
													<button type="button" class="btn btn-secondary" data-dismiss="modal">取消</button>
												</div>
											</div>
											</form>
										</div>
									</div>



                                <?php
                                    }
                                }
                                ?>
								</tbody>
								<tfoot>
									<tr>
										<td class="border" colspan="11">
										<!-- <?php for($i = 1; $i <= $totalPages; $i++){ ?>
										<a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
										<?php } ?> -->
										</td>
									</tr>
								</tfoot>
                            </table>
                        </div>
                    </div>
				</form>	
				</div>
			</div>
			<?php require_once('../template/footer.php'); ?>
		</div>
		 
		
		
			
			

	</div>    
	<script>
	
	function check(formObj) {
			var obj = formObj.chk;
			var sele = [];
			for (var i = 0; i < obj.length; i++) {
				if (obj[i].checked) {
					sele.push(obj[i].value);

				}
				
			}
			console.log(sele);
			sele.forEach(myFunc);
			function myFunc(itemId) {
				var newinput = document.createElement("input");
				newinput.setAttribute('name', 'itemId[]');
				newinput.setAttribute('type', 'hidden');
				newinput.setAttribute('value', itemId);
				var status = document.getElementById("itemStatus");
				status.insertBefore(newinput, status.childNodes[0]);
				// document.getElementById("demo").innerHTML += index + ":" + item + "<br>"; 
			}
			// console.log(sele);
			// return sele;
			
		}
	
	</script>
	<script src="../js/bootstrap.min.js"></script>
	

</body>
</html>