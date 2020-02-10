<?php
//引入判斷是否登入機制
require_once("../template/checkSession.php");
require_once("./header_seller.php");

//引用資料庫連線
require_once("../template/db.inc.php");
?>
<body>
    <?php require_once("../template/header.php");?>
    <?php require_once("../template/sidebar.php");?>
   
    <div  class="container-fluid">
    <!-- col-sm-offset-3 -->
    <div class="col-sm-5 col-lg-offset-2 col-lg-10 main">
    <div class="row ">
			<ol class="breadcrumb">
				<li><a href="./seller.php">
					<em class="fa fa-home text_size_chin_4"></em>
				</a></li>
				<li class="active text_size_chin_4">賣家資料</li>
			</ol>
            </div><!--/.row-->
        <div class="mt_chin"></div>
        <div class="row">
        <div class="col-sm-5 ml4_chin pd_4_chin border_radius_chin text_size_chin_4 edit_bg_color_chin">
        <form enctype="multipart/form-data" name="myForm" method="POST" action="uploadEdit.php">
        <?php
            $sql = "SELECT `seller_id`,`seller_img`,`seller_name`,`seller_password`,`seller_address`, `seller_phone`,`seller_mobile`,`seller_status`,`seller_email`, `join_time`,`seller_decrip`
            FROM `basic_information`
            WHERE `seller_id` = ?";
         
            // $sqlpayment  = "SELECT `payment_type`.`paymentTypeid`, `payment_type`.`paymentTypeName`, `payment_type`.`paymentTypeImg`,
            //                 `basic_information`
            //                 FROM `payment_type`
            //                 INNER JOIN ``
            //                 WHERE `seller_id` = ?";

            $arrParam = [$_GET['editId']];
            
            // echo"<pre>";

            // print_r( $arrParam);    

            // echo"</pre>";
            $stmt = $pdo->prepare($sql);
            if(!$stmt){
                echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
                exit();
            }
            $stmt->execute($arrParam);
            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];
            // echo"<pre>";

            // print_r( $arr);    

            // echo"</pre>";

          

            if( count($arr) > 0){
              
            ?>
        
        <div class="form-group">
             <label for="Id">Id</label>
             <input type="text" class="form-control" name="seller_id" value="<?php echo $arr["seller_id"];?>" maxlength="8">
            </div>
        <div class="form-group">
            <label for="Image">賣場圖片</label>
            <?php if($arr["seller_img"] !== NULL){ ?>
                <img id="blah" style="width:150px" src="../image/sellers/<?php echo $arr["seller_img"]; ?>"/>
            <?php } ?>
            <div class="custom-file">
                <input type="file"  name="seller_img" accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])" class="custom-file-input" id="seller_img">
            </div>
        </div>
        <div class="form-group">
             <label for="Name">姓名</label>
             <input type="text" class="form-control"name="seller_name"  value="<?php echo $arr["seller_name"];?>" maxlength="8">
            </div>
        <div class="form-group">
             <label for="Name">密碼</label>
             <input type="password" class="form-control"name="seller_password"  value="<?php echo $arr["seller_password"];?>" maxlength="30"/>
            </div>   
        <div class="form-group">
             <label for="Name">地址</label>
             <input  type="text" class="form-control"name="seller_address"  value="<?php echo $arr["seller_address"];?>" maxlength="30"/>
            </div>   
        <div class="form-group">
             <label for="Name">電話</label>
             <input  type="text" class="form-control" name="seller_phone"  value="<?php echo $arr["seller_phone"];?>" maxlength="30"/>
            </div>
        </div>
        <!-- 另一部分的表單 -->
        <div class="col-sm-6 ml4_chin pd_4_chin border_radius_chin text_size_chin_4 edit_bg_color_chin">
        <div class="form-group">
             <label for="Name">手機</label>
             <input  type="text" class="form-control" name="seller_mobile"  value="<?php echo $arr["seller_mobile"];?>" maxlength="10"/>
            </div>       
        <div class="form-group">
             <label for="Name">狀態</label>
             <select name="seller_status" class="seller_status_chin" id="seller_status">
                    <option value="<?php echo $arr["seller_status"];?>" selected><?php echo $arr["seller_status"];?></option>
                    <option value="inactive">unactive</option>
                    <option value="suspended">suspended</option>
                </select>
            </div>      
        <div class="form-group">
             <label for="Name">電郵</label>
             <input id="seller_email"   type="email" class="form-control"  name="seller_email"  value="<?php echo $arr["seller_email"];?>" maxlength="30"/>
            </div>   
        <div class="form-group">
             <label for="Name">賣場描述</label>
             <textarea class="form-control"  style="font-size:30px" name="seller_decrip" id="seller_decrip" cols="30" rows="5"><?php echo $arr["seller_decrip"];?></textarea>
            </div>
       
      <div class="form-group">
             <label for="Name">加入時間</label>
             <input  id="join_time"  type="date" class="form-control"   name="join_time"  value="<?php echo $arr["join_time"];?>" maxlength="30"/>
            </div>         
        <div class="form-group">
        <a class="btn btn-danger" href="./delete.php?deleteId=<?php echo $arr["seller_id"];?>">刪除</a>
        <button class="btn btn-success"  type="submit" name="sub" >更新</button>

            </div> 
     </div>     
            
            <?php
             } else {
            ?>
        <div class="form-group">
        <div>沒有資料</div>
        </div>     
            <?php
             }
             ?>
        <div class="form-group">
        <input class="form-control" type="hidden" name="editId" value="<?php echo $_GET["editId"]; ?>">
        </div>           
        </form> 
        </div>
  
        </div>
          
		</div>
    </div>
		
      
        
 
        
</body>
</html>