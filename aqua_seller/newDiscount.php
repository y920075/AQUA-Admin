<?php require_once("./header_seller.php");?>
<?php require_once("../template/db.inc.php");?>


<body>
    <?php require_once("../template/nav.php");?>
    <?php require_once("../template/sidebar.php");?>
    <?php
    $sql = "SELECT * FROM `firstlevel`
            ORDER BY first_level_category_id ASC";
    $stm = $pdo->prepare($sql);

    $stm->execute();

    $result = $stm->fetchAll();

    // echo "<pre>";

    // print_r($result);

    // echo "</pre>";
    
  
// Array
// (
//     [0] => Array
//         (
//             [id] => 2
//             [0] => 2
//             [noConditionId] => NOCN2
//             [1] => NOCN2
//             [ConditionInit] => 有條件
//             [2] => 有條件
//             [created_at] => 2020-01-17 13:49:36
//             [3] => 2020-01-17 13:49:36
//             [updated_at] => 2020-01-17 13:49:36
//             [4] => 2020-01-17 13:49:36
//         )

//     [1] => Array
//         (
//             [id] => 1
//             [0] => 1
//             [noConditionId] => NOCN1
//             [1] => NOCN1
//             [ConditionInit] => 沒有條件
//             [2] => 沒有條件
//             [created_at] => 2020-01-17 13:49:36
//             [3] => 2020-01-17 13:49:36
//             [updated_at] => 2020-01-17 13:49:36
//             [4] => 2020-01-17 13:49:36
//         )
// )
    ?>
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
<div class="constainer-fluid">
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
            <ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home text_size_chin_1"></em>
				</a></li>
				<li class=""><a href="./seller.php" class="text_size_chin_1">優惠資料</a></li>
				<li class="active"><a href="" class="text_size_chin_1">新增優惠</a></li>
			</ol>
           
            </div>
            <div class="mt_chin"></div>
            <div class="row">
            <div class="col-sm-5 pd_4_chin ml4_chin border_radius_chin newAdd_bg_color_chin text_size_chin_4">
                <form name="myForm" method="POST" action="./insertDiscount.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label>Id</label>
                    <input type="text" name="couponId" id="couponId" value="<?php echo 'D'. $time . $total_num;?>" maxlength="8" class="form-control" placeholder="Placeholder">
                    <input  class="form-control" type="hidden" name="idd" value="<?php echo $idd[0];?>">
                </div>
                <div class="form-group">
                        <label>優惠圖</label>
                        <figure class="">
                        <img id="blah" alt="">
                        </figure>
                        <input name="couponImg"  type="file" class="form-control"  accept="image/*" onchange="document.getElementById('blah').src = window.URL.createObjectURL(this.files[0])"/>
                </div>
                <div class="form-group">
                        <label>優惠名</label>
                        <input type="text" name="couponName" id="couponName" value="" maxlength="8" class="form-control" placeholder="全店滿千八折">
                </div>
                <div class="form-group">
                        <label>生效條件類型1:</label>
                        <select name="first_level[]" id="first_level" class="form-control" multiple >
                            <?php
                                foreach($result as $row){
                                    echo '<option value="'.$row["first_level_category_id"].'">'.$row["first_level_category_name"].'</option>';
                                }
                            ?>
                        </select>
                </div>
                <div class="form-group" >
                        <label>生效條件類型2:</label>
                        <select name="second_level[]" id="second_level" class="form-control" multiple >

                        </select>
                </div>
                <div class="form-group">
                        <label>生效條件類型3:</label>
                        <select name="third_level[]" id="third_level" class="form-control" multiple >

                        </select>
                </div>
                <div class="form-group">
                        <label>生效條件類型4:</label>
                        <select name="forth_level[]" id="forth_level" class="form-control" multiple >

                        </select>
                </div>
                <div class="form-group">
                        <label>地址</label>
                        <input type="text" name="seller_address" id="seller_address" value="" maxlength="30" class="form-control">
                </div>
                <div class="form-group">
                        <label>電話</label>
                        <input type="text" name="seller_phone" id="seller_phone" value="" maxlength="10"  class="form-control">
                </div>
                <div class="form-group">
                        <label>手機</label>
                        <input type="text" name="seller_mobile" id="seller_mobile" value="" maxlength="10"  class="form-control">
                </div>
            </div>
            <div class="col-sm-5 pd_4_chin ml4_chin border_radius_chin newAdd_bg_color_chin text_size_chin_4">
             
                </form>
            </div>
            </div>
        </div>
</div>
<?php require_once("./JSScripts.php"); ?>
<script>
        $(function(){
            $("#first_level").multiselect({
                nonSelectedText:"請選擇生效條件A",
                buttonWidth:"200px",
                onChange:function(option, checked){
                 
                    
                    
                    var selected_1 = this.$select.val();
                    // let selected_let = this.$select.val();
                   console.log(selected_1);
                    if(selected_1.length > 0)
                    {
                        $.ajax({
                            url:"fetch_CondB.php",
                            method:"POST",
                            data:{selected:selected_1},
                            success:function(data){
                           
                                $("#second_level").html(data);
                                $("#second_level").multiselect("rebuild");
                            }
                        });
                    }
                }

            });

            $("#second_level").multiselect({
                nonSelectedText:"請選擇生效條件B",
                buttonWidth:"200px",
                onChange:function(option, checked){

                
                   var selected_2 = this.$select.val();

                    if(selected_2.length > 0)
                    {
                        $.ajax({
                            url:"fetch_CondC.php",
                            method:"POST",
                            data:{selected:selected_2},
                            success:function(data){
                                // console.log(data);
                                // console.log("錯誤");
                                $("#third_level").html(data);
                                $("#third_level").multiselect("rebuild");
                            },
                            error: function(jqxhr, status, exception) {
                                alert('Exception:', exception);
                            }
                        });
                    }
                }
            });
            $('#third_level').multiselect({
                nonSelectedText: "請選擇生效條件C",
                buttonWidth:'200px',
                onChange:function(option, checked){

                
                var selected_3 = this.$select.val();

                console.log(selected_3);


                if(selected_3.length > 0)
                {
                    $.ajax({
                        url:"fetch_CondD.php",
                        method:"POST",
                        data:{selected:selected_3},
                        success:function(data){
                            console.log(data);
                            // console.log("錯誤");
                            $("#forth_level").html(data);
                            $("#forth_level").multiselect("rebuild");
                        },
                        error: function(jqxhr, status, exception) {
                            alert('Exception:', exception);
                        }
                    });
                }
                }
                });
            $("#forth_level").multiselect({
                nonSelectedText:"請選擇生效條件D",
                buttonWidth:"200px"
                
            });
        });
</script>
</body>
</html>