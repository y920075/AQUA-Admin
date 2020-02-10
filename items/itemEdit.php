<?php
    require_once('../template/db.inc.php');
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
    <style>
    .py{
        padding: 15px 70px;
        margin-bottom: 20px;
    }

    .slt{
        height:46px;
    }
    .w300px{
        max-width: 300px;
    }
    label{
        display: block;
        text-indent: -5em;
        padding-bottom: -200px;
        /* margin-bottom: -20px; */
    }
    </style>
    <link href="../css/styles.css" rel="stylesheet">
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
				<li class="active">商品資料管理</li>
				<li class="active">編輯商品</li>
			</ol>
        </div>
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">編輯商品</h1>
			</div>
		</div>
        <form name="myForm" method="POST" action="./itemUpdate.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-10">
                            <?php
                                $sql = "SELECT `itemImg`, `itemName`, `itemDescription`,   `itemCategoryId`, `itemTypeId`, `itemMaterial`, `itemBrandId`, `itemPrice`, `itemQty`, `itemSize`
                                FROM `items`
                                WHERE `itemId` = ? ";

                                $arrParam = [$_GET['editId']];

                                $stmt = $pdo->prepare($sql);
                                $stmt->execute($arrParam);

                                if($stmt->rowCount() > 0) {
                                    $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

                            ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">基本資訊</div>
                        <div class="panel-body">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                            
                                
                                <div class="form-group">
                                    <label>商品名稱</label>
                                    <input class="form-control" type="text" name="itemName" id="itemName" value="<?php echo $arr['itemName']; ?>" maxlength="100">
                                </div>
                                <div class="form-group">
									<label>商品描述</label>
									<textarea class="form-control" rows="5" name="itemDescription"><?php echo nl2br($arr['itemDescription']); ?></textarea>
                                </div>
                                <div class="form-group">
                                    <label>商品類別</label>
                                    <select class="form-control slt" name="itemCategoryId" id="itemCategoryId">
                                        <option value="<?php echo $arr['itemCategoryId']; ?>" selected><?php echo $arr['itemCategoryId']; ?></option>
                                        <option value="蛙鞋">蛙鞋</option>
                                        <option value="面鏡">面鏡</option>
                                        <option value="防寒衣">防寒衣</option>
                                    </select>
                                </div>
                                <div class="form-group">
                                    <label>商品類型</label>
                                    <select class="form-control slt" name="itemTypeId" id="itemTypeId">
                                        <option value="<?php echo $arr['itemTypeId']; ?>" selected><?php echo $arr['itemTypeId']; ?></option>
                                        <option value="蛙鞋">蛙鞋</option>
                                        <option value="面鏡">面鏡</option>
                                        <option value="防寒衣">防寒衣</option>
                                    </select>
                                </div>
                                <div class="form-group">
									<label>商品材質</label>
									<input class="form-control" type="text" name="itemMaterial" id="itemMaterial" value="<?php echo $arr['itemMaterial']; ?>" maxlength="10">
                                </div>
                                <div class="form-group">
									<label>商品品牌</label>
									<input class="form-control" type="text" name="itemBrandId" id="itemBrandId" value="<?php echo $arr['itemBrandId']; ?>" maxlength="30">
                                </div>
                            
                                
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">
                            
                                <div class="form-group">
                                    <label>商品圖片</label>
                                    <figure>
                                    <?php if($arr['itemImg'] !== NULL) { ?>
                                    <img class="w300px" src="../image/items/<?php echo $arr['itemImg']; ?>" />
                                    <?php } ?>
                                    </figure>
									<input type="file" name="itemImg">
									<p class="help-block">圖片請小於500kb</p>
								</div>
                                
                            
                                
                            </div>

                        </div>   
                    </div>
                    <div class="panel panel-default">
                        <div class="panel-heading">銷售資訊</div>
                        <div class="panel-body">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">

                                <div class="form-group">
                                    <label>商品價格</label>
                                    <input class="form-control" type="number"" name="itemPrice" id="itemPrice" value="<?php echo $arr['itemPrice']; ?>" maxlength="5" min="1">
                                </div>
                                
                                <div class="form-group">
                                    <label>商品尺寸</label>
                                    <input class="form-control" type="text"" name="itemSize" id="itemSize" value="<?php echo $arr['itemSize']; ?>" maxlength="10">
                                </div>
                                
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">

                                
                                <div class="form-group">
                                    <label>商品數量</label>
                                    <input class="form-control" type="number"" name="itemQty" id="itemQty" value="<?php echo $arr['itemQty']; ?>" maxlength="2" min="1" max="30">
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                            <?php
                                    }
                            ?>
                </div>
                <div class="col-lg-2">
                    <input type="hidden" name="editId" value="<?php echo $_GET['editId']; ?>">
                    <input class="btn btn-primary btn-lg py" name="smb" type="submit"  value="修改">
                    
                    <!-- <a href="./items.php"> -->
                        <button onclick="window.history.go(-1);" type="button" class="btn btn-default btn-lg py">取消</button>
                    <!-- </a> -->
                </form>
			
            </div>
            <?php require_once('../template/footer.php'); ?>
        </div>

    </div>

</body>
</html>