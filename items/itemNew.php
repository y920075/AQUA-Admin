<?php
    require_once('../template/db.inc.php');

    $sqlTotal = "SELECT count(`itemId`) AS `count` FROM `items`";
    $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
    // $total_num = (int)$total+1;
    $time = date("ym");

    // echo "<pre>";
    // echo "time:".$time;
    // echo "total:".$total_num.'<br>';
    $total_num = str_pad((int)$total+1,4,'0',STR_PAD_LEFT);
    // echo "</pre>";
    // exit();
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
    .fg{
        margin-bottom: 16px;

    }

    .slt{
        height:46px;
    }
    
    label{
        display: block;
        text-indent: -5em;
        padding-bottom: -200px;
        /* margin-bottom: -20px; */
    }
    /* option{
        padding: 20px;
    } */
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
				<li class="active">新增商品</li>
			</ol>
        </div>
        <div class="row">
			<div class="col-lg-12">
				<h1 class="page-header">新增商品</h1>
			</div>
		</div>
        <form name="myForm" method="POST" action="./itemInsert.php" enctype="multipart/form-data">
            <div class="row">
                <div class="col-lg-10">
                    <div class="panel panel-default">
                        <div class="panel-heading">基本資訊</div>
                        <div class="panel-body">
                            <div class="col-md-1"></div>
                            <div class="col-md-5">

                                <input type="hidden" name="itemId" value="<?php echo 'I'.$time.$total_num ?>">
                            
                               
                                <div class="form-group">
                                    <label>商品名稱</label>
                                    <input class="form-control" type="text" name="itemName" id="itemName" value="" maxlength="100">
                                </div>
                                <div class="form-group">
									<label>商品描述</label>
									<textarea class="form-control" rows="5" name="itemDescription"></textarea>
                                </div>
                                <div class="form-group">
                                    <label>商品類別</label>
                                    <select class="form-control slt" name="itemCategoryId" id="itemCategoryId">
                                        <option value="蛙鞋" selected>蛙鞋</option>
                                        <option value="面鏡">面鏡</option>
                                        <option value="防寒衣">防寒衣</option>
                                    </select>
                                </div>
                                
                                <div class="form-group">
									<label>商品品牌</label>
									<input class="form-control" type="text" name="itemBrandId" id="itemBrandId" value="" maxlength="30">
                                </div>



                            </div>


                            <div class="col-md-1"></div>
                            <div class="col-md-5">

                                <input type="hidden" name="itemId" value="<?php echo 'I'.$time.$total_num ?>">
                            
                                <div class="form-group">
                                    <label>商品圖片</label>
                                    <figure class="fg">
                                    <img id="blah" width="135" height="135" >
                                    </figure>
									<input type="file" accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" name="itemImg">
									<p class="help-block">圖片請小於500kb</p>
                                    
								</div>
                                
                                
                                <div class="form-group">
                                    <label>商品類型</label>
                                    <select class="form-control slt" name="itemTypeId" id="itemTypeId">
                                        <option value="蛙鞋" selected>蛙鞋</option>
                                        <option value="面鏡">面鏡</option>
                                        <option value="防寒衣">防寒衣</option>
                                    </select>
                                </div>
                                <div class="form-group">
									<label>商品材質</label>
									<input class="form-control" type="text" name="itemMaterial" id="itemMaterial" value="" maxlength="10">
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
                                    <input class="form-control" type="number"" name="itemPrice" id="itemPrice" value="" maxlength="5" min="1">
                                </div>
                                
                                <div class="form-group">
                                    <label>商品尺寸</label>
                                    <input class="form-control" type="text"" name="itemSize" id="itemSize" value="" maxlength="10">
                                </div>
                                
                            </div>
                            <div class="col-md-1"></div>
                            <div class="col-md-5">

                                
                                <div class="form-group">
                                    <label>商品數量</label>
                                    <input class="form-control" type="number"" name="itemQty" id="itemQty" value="" maxlength="2" min="1" max="30">
                                </div>
                                
                                
                            </div>
                        </div>
                    </div>
                    
                </div>
                <div class="col-lg-2">
                    <input class="btn btn-primary btn-lg py" name="smb" type="submit"  value="新增">
                    
                    <a href="./items.php"><button type="button" class="btn btn-default btn-lg py">取消</button></a>
                </form>
			
            </div>
            <?php require_once('../template/footer.php'); ?>
        </div>

    </div>

</body>
</html>