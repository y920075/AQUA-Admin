<?php
//引入判斷是否登入機制
require_once("../template/checkSession.php");
require_once("./header_seller.php");

//引用資料庫連線
require_once("../template/db.inc.php");
?>
<body>
    <?php require_once("../template/nav.php");?>
    <?php require_once("../template/sidebar.php");?>
   
    <div  class="container-fluid">
    <!-- col-sm-offset-3 -->
    <div class="col-sm-5 col-lg-offset-2 col-lg-10 main">
    <div class="row ">
			<ol class="breadcrumb">
				<li><a href="./discount.php">
					<em class="fa fa-home text_size_chin_1"></em>
				</a></li>
				<li class="active text_size_chin_1">優惠資料</li>
			</ol>
            </div><!--/.row-->
        <div class="mt_chin"></div>
        <div class="row">
        <div class="col-sm-5 ml4_chin pd_4_chin border_radius_chin text_size_chin_4 edit_bg_color_chin">
        <form enctype="multipart/form-data" name="myForm" method="POST" action="uploadEdit.php">
        <?php
            $sql = "SELECT `couponId`,`couponImg`,
                    `couponName`,`coupCondAId`,
                    `couponCondBId`,`LastConditionId`,
                    `itemCategoryId`,
                    DATE_FORMAT(`timeStart`, '%Y-%m-%dT%H:%i') AS StartDate,
                    DATE_FORMAT(`timeOver`, '%Y-%m-%dT%H:%i') AS OverDate,
                    `create_time`,`update_time`,`Times`
                    FROM `couponall`
                    WHERE `couponId` = ? ";

             $sqlCondA = "SELECT `couponconditiona`.`coupCondNameA`,`couponall`.`coupCondAId`
                            FROM `couponconditiona`
                            INNER JOIN `couponall`
                            ON `couponconditiona`.`coupCondAId` = `couponall`.`coupCondAId`
                            WHERE `couponall`.`coupCondAId` = ? ";


            $sqlCondB = "SELECT `cuponconditionb`.`couponCondNameB`,`couponall`.`couponCondBId`
                            FROM `cuponconditionb`
                            INNER JOIN `couponall`
                            ON `cuponconditionb`.`couponCondBId` = `couponall`.`couponCondBId`
                            WHERE `couponall`.`couponCondBId` = ? ";


            // 取得適用對象範圍
            $sqlEffectUse = "SELECT `cuponuse`.`cuponuseName`,`couponall`.`couponId`
                            FROM `cuponuse`
                            INNER JOIN `couponall`
                            ON `cuponuse`.`couponId` = `couponall`.`couponId`
                            WHERE `couponall`.`couponId` = ? ";


        
            $arrParam = [$_GET['editId']];
            
            //執行查詢語法
            $stmt = $pdo->prepare($sql);
            if(!$stmt){
                echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
                exit();
            }
            $stmt->execute($arrParam);

            $stmtCondA = $pdo->prepare($sqlCondA);

            if(!$stmtCondA){
                echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
                exit();
            }
            $stmtCondA->execute($arrParam);


            $stmtCondB = $pdo->prepare($sqlCondB);
            if(!$stmtCondB){
                echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
                exit();
            }
            $stmtCondB->execute($arrParam);


            $stmtEffectUse = $pdo->prepare($sqlEffectUse);
            if(!$stmtEffectUse){
                echo "Prepare failed: (". $pdo->errno.") ".$pdo->error."<br>";
                exit();
            }
            $stmtEffectUse->execute($arrParam);
           

            if( count($arr) > 0){
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC)[0];

            ?>
        <!-- `couponId`,`couponImg`,
                    `couponName`,`coupCondAId`,
                    `couponCondBId`,`LastConditionId`,
                    `itemCategoryId`,
                    DATE_FORMAT(`timeStart`, '%Y-%m-%dT%H:%i') AS StartDate,
                    DATE_FORMAT(`timeOver`, '%Y-%m-%dT%H:%i') AS OverDate,
                    `create_time`,`update_time`,`Times -->
        <div class="form-group">
             <label for="Id">Id</label>
             <input type="text" class="form-control" name="couponId" value="<?php echo $arr["couponId"];?>" maxlength="8">
            </div>
        <div class="form-group">
            <label for="Image">優惠圖</label>
            <?php if($arr["couponImg"] !== NULL){ ?>
                <img style="width:50px" src="../image/sellers/<?php echo $arr["couponImg"]; ?>"/>
            <?php } ?>
            <div class="custom-file">
                <input type="file" name="couponImg" class="custom-file-input" id="couponImg">
                <label class="custom-file-label" for="customFile">選擇檔案</label>
            </div>
        </div>
        <div class="form-group">
             <label for="Name">優惠名</label>
             <input type="text" class="form-control"name="couponName"  value="<?php echo $arr["couponName"];?>" maxlength="8">
            </div>
        <div class="form-group">
             <label for="Name">生效狀況A</label>
             <select name="CondNameA" class="CondNameA" id="select_CondA">
             <?php
                    // 生效狀況A先抓出原本資料庫中的值

                     if($stmtCondA->rowCount() > 0){
                        $arrCondA = $stmtCondA->fetchAll(PDO::FETCH_ASSOC)[0];
             ?>
                    <option value="<?php echo $arr["coupCondAId"];?>" selected>*初始值* <?php echo $arrCondA['coupCondNameA']; ?></option>
            <?php
                     }else{
                        unset($arrCondA);
            ?>
                
                    <option value="<?php echo $arr["coupCondAId"];?>">沒有條件</option>
             <?php   
                }    
                ?>  
                    <!-- 再抓出couponcondition這張資料表中的所有類型 -->
            <?php
                $sqlgetConA = "SELECT `coupCondAId`,`coupCondNameA`
                                FROM `couponconditiona`";
                     $stmtgetConA = $pdo->prepare($sqlgetConA);
                     $stmtgetConA->execute();
                if($stmtgetConA->rowCount() > 0){
                    $arrGetConA = $stmtgetConA->fetchAll(PDO::FETCH_ASSOC);
                    for($i = 0; $i < count($arrGetConA) ; $i++) {
                    ?>
                        <option value="<?php echo $arrGetConA[$i]['coupCondAId']?>"><?php echo $arrGetConA[$i]['coupCondNameA']?></option>
                    <?php
                    }
                }
                ?>
                </select>            
            </div>   
        <div class="form-group">
             <label for="Name">生效狀況B</label>
             <select name="CondNameB" class="form-control" id="CondNameB">
             <?php
                    // 生效狀況B先抓出原本資料庫中的值

                     if($stmtCondB->rowCount() > 0){
                        $arrCondB = $stmtCondB->fetchAll(PDO::FETCH_ASSOC)[0];
             ?>
                    <option value="<?php echo $arr["coupCondBId"];?>" selected>*初始值* <?php echo $arrCondA['coupCondNameB']; ?></option>
            <?php
                     }else{
                        unset($arrCondB);
            ?>
                
                    <option value="<?php echo $arr["coupCondBId"];?>">沒有條件</option>
             <?php   
                }    
                ?>  
             
                </select>      
            </div>   
      
        <!-- 另一部分的表單 -->
        <div class="col-sm-6 ml4_chin pd_4_chin border_radius_chin text_size_chin_4 edit_bg_color_chin">
        <div class="form-group">
             <label for="Name">優惠起始	</label>
             <input  type="text" class="form-control" name="StartDate"  value="<?php echo $arr["StartDate"];?>" maxlength="30"/>
            </div>
        </div>
        <div class="form-group">
             <label for="Name">優惠結束</label>
             <input  type="text" class="form-control" name="OverDate"  value="<?php echo $arr["OverDate"];?>" maxlength="10"/>
            </div>       
        <div class="form-group">
             <label for="Name">適用商品類型</label>
             <input type="search" name="searchItemType"><br>
                <input type="submit">
            </div>      
        <div class="form-group">
             <label for="Name">電郵</label>
             <input id="seller_email"   type="email" class="form-control"  name="seller_email"  value="<?php echo $arr["seller_email"];?>" maxlength="30"/>
            </div>   
        <div class="form-group">
             <label for="Name">賣場描述</label>
             <textarea class="form-control" name="seller_decrip" id="seller_decrip" cols="30" rows="10">
             <?php echo $arr["seller_decrip"];?>
             </textarea>
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
		
      
        
    <?php require_once("../template/footer.php");?>
    <script>

$("select#select_CondA").change(function(){
    //每次執行這個函式時，就會刪除原本的已存在選項，否則會一直疊加選項 .empty函式會刪除所有子元素
    $('select#select_CondB').empty()
    $.ajax({
        //選擇要接收AJAX資料的php檔案
        url: "check_Cond.php", 
        //要傳送的過去的資料 'select_Type' 等同於 $_POST['select_CondA'] 冒號後面則是它的值
        data: {select_Type : $('#select_CondA').val()}, 
        //傳送的方式 
        type:'POST', 
        //傳送的資料格式
        dataType:'json', 

        //如果執行成功就執行success函式 引數data就是PHP傳送回來的資料
        success: function(data){
            //取得JSON字串長度
            let jsonlength = data.length; 
            //宣告變數以便迴圈中使用
            let i,id,level;
            //執行迴圈依照JSON長度新增選項
            for (  i = 0 ; i < jsonlength ; i++) {
                //取得JSON字串裡面的等級編號
                id = data[i]['classLevelId'];
                //取得JSON字串裡面的等級名稱
                level = data[i]['classLevel'];
                //動態新增選項
                $('#select_level').append(`<option value="${id}">${level}</option>`);
            };
        }
    });
});
//判斷目前人數是否大於徵求人數
// $('#classNOWpeople').change(function(){
//     let Now = parseInt($('input#classNOWpeople').val());
//     let Need = parseInt($('input#classMAXpeople').val());
//     if ( Now > Need ){
//         $('p').remove('.warning');
//         $('label#nowPeopleTitle').append('<p class="warning">最大人數不可大於目前人數!</p>');
//     } else {
//         $('p').remove('.warning');
//     };
// });


    


</script>
        
</body>
</html>
