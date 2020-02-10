<?php require_once("./header_seller.php");?>
<?php require_once("../template/db.inc.php");?>
<?php
        $check = date("Y-m");

        $sqlTotal = "SELECT MAX(`idd`) AS `MAX`
                    FROM `basic_information`
                    WHERE DATE_FORMAT(`create_time`,'%Y-%m') = '$check'";
        $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
        $idd = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM);

        //抓出現在年月兩碼

        $time = date("ym");

        $total_num = str_pad((int)$total+1,4,'0',STR_PAD_LEFT);
    
    ?>
<body>
    <?php require_once("../template/header.php");?>
    <?php require_once("../template/sidebar.php");?>
    <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active"><a href="seller.php">賣家資料</a></li>
				<li class="active"><a href="new.php">新增賣家</a></li>
                <li class="active"><a href="seller_cond.php">賣家狀態</a></li>

			</ol>
           
		</div><!--/.row-->
        <div class="mt_chin"></div>
        <div class="row">
			<div class="col-lg-12">
				<h2>賣家詳細資訊</h2>
			</div>
				<?php

				$sql_gd = "SELECT seller_id, COUNT(seller_id) 
							FROM comment_gd GROUP BY seller_id 
							HAVING seller_id = '".$_GET['editId']."'";
				// $sql_gd = "SELECT seller_id, COUNT(seller_id) FROM comment_gd GROUP BY seller_id";
				$sql_bd = "SELECT seller_id, COUNT(seller_id) 
							FROM comment_gd GROUP BY seller_id 
							HAVING seller_id = '".$_GET['editId']."'";
				
				$sql_item = "SELECT itemSellerId, COUNT(itemSellerId) 
							FROM items GROUP BY itemSellerId 
							HAVING itemSellerId = '".$_GET['editId']."'";
				$sql_item_category = "SELECT itemCategoryId,itemImg
										FROM items GROUP BY itemSellerId 
										HAVING itemSellerId = '".$_GET['editId']."'";

				$stmt_gd = $pdo->prepare($sql_gd);
				$stmt_gd->execute();
				
				$stmt_bd = $pdo->prepare($sql_bd);
                $stmt_bd->execute();

				$stmt_item = $pdo->prepare($sql_item);
				$stmt_item->execute();
				
				$stmt_item_category = $pdo->prepare($sql_item_category);
                $stmt_item_category->execute();
				?>


			
			<div class="col-sm-6">
				<div class="panel panel-success">
					<div class="panel-heading">商品數目</div>
					<div class="panel-body">
					<h4>累積商品數:</h4>

						<?php		
								if($stmt_item->rowCount() > 0) {
								$arr_item = $stmt_item->fetchAll(PDO::FETCH_ASSOC);

								for($i = 0 ; $i < count($arr_item) ; $i++){?>
									<p style="font-size:50px">
									<img style="width:50px" src="../image/sellers/bag.svg" alt="">
									<?php echo $arr_item[$i]["COUNT(itemSellerId)"]; ?>
									</p>
							<?php };
								}else{?>
									<p style="font-size:50px">
									<img style="width:50px" src="../image/sellers/annulled-emoticon-square-face.svg" alt="">
									</p>
								<?php } ?>
					</div>
				</div>
            </div>
            <div class="col-sm-5">
				<div class="panel panel-danger">
					<div class="panel-heading">負面評論</div>
					<div class="panel-body">
					<h4>累積評論:</h4>

					<?php		
							if($stmt_bd->rowCount() > 0) {
                            $arr_bd = $stmt_bd->fetchAll(PDO::FETCH_ASSOC);

                            for($i = 0 ; $i < count($arr_bd) ; $i++){?>
								<p style="font-size:50px">
								<img style="width:50px" src="../image/sellers/down.svg" alt="">
								<?php echo $arr_bd[$i]["COUNT(seller_id)"]; ?>
								</p>
						<?php };
							}else{?>
								<p style="font-size:50px">
									<img style="width:50px" src="../image/sellers/annulled-emoticon-square-face.svg" alt="">
									</p>
							<?php } ?>
					</div>
				</div>
            </div>
            <div class="col-sm-6">
				<div class="panel panel-success">
					<div class="panel-heading">主要商品種類</div>
					<div class="panel-body">`
					<h4>商品類別列表:</h4>

					<?php		
							if($stmt_item_category->rowCount() > 0) {
							$arr_item_cate =$stmt_item_category->fetchAll(PDO::FETCH_ASSOC);

							for($i = 0 ; $i < count($arr_item_cate) ; $i++){?>
								<p style="font-size:50px">
								<img style="width:150px" src="../image/items/<?php echo $arr_item_cate[$i]["itemImg"]; ?>" alt="">
								<?php echo $arr_item_cate[$i]["itemCategoryId"]; ?>
								</p>
						<?php };
							}else{?>
								<p style="font-size:50px">
									<img style="width:50px" src="../image/sellers/annulled-emoticon-square-face.svg" alt="">
									</p>
							<?php } ?>

					</div>
				</div>
            </div>
			
            <div class="col-sm-5">
				<div class="panel panel-primary">
					<div class="panel-heading">正面評論</div>
					<div class="panel-body">`
					<h4>累積評論:</h4>
					<?php		
				
				if($stmt_gd->rowCount() > 0) {
                            $arr_gd = $stmt_gd->fetchAll(PDO::FETCH_ASSOC);

                            for($i = 0 ; $i < count($arr_gd) ; $i++){?>
								<p style="font-size:50px">
								<img style="width:50px" src="../image/sellers/rise.svg" alt="">
								<?php echo $arr_gd[$i]["COUNT(seller_id)"]; ?>
								</p>
								<?php };
							}else{?>
								<p style="font-size:50px">
									<img style="width:50px" src="../image/sellers/annulled-emoticon-square-face.svg" alt="">
									</p>
							<?php } ?>
					</div>
				</div>
			</div>
        </div><!-- /.row -->     
        
</div>
</div>     