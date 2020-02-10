<?php require_once("./header_seller.php");?>
<?php require_once("../template/db.inc.php");?>


<body>
    <?php require_once("../template/header.php");?>
    <?php require_once("../template/sidebar.php");?>

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
    <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home text_size_chin_4"></em>
				</a></li>
				<li class=""><a href="./seller.php" class="text_size_chin_4">賣家資料</a></li>
				<li class="active"><a href="" class="text_size_chin_4">新增賣家</a></li>
			</ol>
           
		</div><!--/.row-->
        <div class="mt_chin"></div>
        <div class="row">
           <div class="col-sm-5 pd_4_chin ml4_chin border_radius_chin newAdd_bg_color_chin text_size_chin_4">
           <form name="myForm" method="POST" action="./insert.php" enctype="multipart/form-data">
            <div class="form-group">
                    <label>Id</label>
                    <input type="text" name="seller_id" id="seller_id" value="<?php echo 'S'. $time . $total_num;?>" maxlength="10" class="form-control" placeholder="Placeholder">
                    <input  class="form-control" type="hidden" name="idd" value="<?php echo $idd[0];?>">
            </div>
            <div class="form-group">
                    <label>賣場名</label>
                    <input type="text" name="seller_name" id="seller_name" value="" maxlength="8" class="form-control" placeholder="可愛的魚">
            </div>
            <div class="form-group">
                    <label>賣場圖</label>
                    <img style="width:150px" id="blah" alt="">
                    <input type="file" class="form-control"  name="seller_img" accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])">

            </div>
			<div class="form-group">
					<label>密碼</label>
					<input name="seller_password" id="seller_password" value="" maxlength="10"  type="password" class="form-control">
            </div>
            <div class="form-group">
					<label>地址</label>
					<input type="text" name="seller_address" id="seller_address" value="" maxlength="30" class="form-control">
            </div>
            <div class="form-group">
					<label>電話</label>
					<input type="text" name="seller_phone" id="seller_phone" value="" maxlength="10"  class="form-control">
            </div>
           
            </div>
            <!-- 以上是第一部分form -->
            <div class=""></div>

            <div class="col-sm-5 pd_4_chin ml4_chin border_radius_chin newAdd_bg_color_chin text_size_chin_4">

            <div class="form-group">
					<label>手機</label>
					<input type="text" name="seller_mobile" id="seller_mobile" value="" maxlength="10"  class="form-control">
            </div>
            <div class="form-group">
					<label>Email</label>
					<input type="email" name="seller_email" id="seller_email" value="" maxlength="30"/>
            </div>
            <div class="form-group">
					<label>賣家狀態</label>
                    <select name="seller_status" id="seller_status">
                    <option value="active">active</option>
                    <option value="unactive">unactive</option>
                    <option value="suspened">suspened</option>

                    </select>
            </div>
            <div class="form-group">
             <label for="Name">賣場描述</label>
             <textarea class="form-control" cols="30" rows="10" style="font-size:15px" name="seller_decrip" id="seller_decrip"></textarea>
            </div>   
            <div class="form-group">
					<label>Date</label>
					<input type="text" readonly name="join_time" id="join_time" value="<?php echo date("Y-m-d");?>" />
            </div>
            <div class="form-group">
            <div class="border" colspan="7">
                    <input class="form-control" style="font-size:20px;border-radius:5%;background:pink" type="submit" name="smb" value="新增">
                </div>         
            </div>
        
       
        </form>
        </div>
      
      
        </div>
     

    </div>
    </div>
  
    <?php require_once("./JSScripts.php"); ?>
		
</body>
</html>
