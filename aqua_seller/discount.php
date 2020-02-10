
<?php require_once("./header_seller.php");?>
<?php require_once("../template/db.inc.php");?>


<?php

$sqlTotal = "SELECT count(1) FROM `basic_information`";


$total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

echo $total;

$numPerPage = 5;//每頁五筆

//總頁數

$totalPages = ceil($total/$numPerPage);

//目前第幾頁

$page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

//如果page頁小於1回傳1

$page = $page < 1 ? 1 : $page;
?>



<body>
    <?php require_once("../template/nav.php");?>
    <?php require_once("../template/sidebar.php");?>
    <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home"></em>
				</a></li>
				<li class="active">優惠資料</li>
				<li class=""><a href="newDiscount.php">新增優惠</a></li>
			</ol>
           
		</div><!--/.row-->
     <!-- 優惠的代號是D -->
        <div class="row">
            <div class="form_1">
            <form name="myForm" method="POST" action="deleteIds.php">
                    <table class="sortable table table_add">
                    <thead class="thead-dark table_header_Color_chin">
                        <tr>
                        <th>選擇</th>
                        <th>Id</th>
                        <th>優惠圖</th>
                        <th>優惠名</th>
                        <th>生效條件A</th>
                        <th>生效條件B</th>
                        <th>優惠起始</th>
                        <th>優惠結束</th>
                        <th>適用商品類</th>
                        <th>適用對象</th>
                        <th>使用次數</th>
                        <th>創造時間</th>
                        <th>更新時間</th>
                        <th>功能</th>
                        </tr>
                    </thead>
                    <tbody class="append_position">

                    <?php
                    $sql = "SELECT `couponId`,`couponImg`,
                            `couponName`,`second_level_category_id`,
                            `third_level_category_id`,`LastConditionId`,
                            `itemCategoryId`,
                            DATE_FORMAT(`timeStart`, '%Y-%m-%dT%H:%i') AS StartDate,
                            DATE_FORMAT(`timeOver`, '%Y-%m-%dT%H:%i') AS OverDate,
                            `create_time`,`update_time`,`Times`
                            FROM `couponall`
                            ORDER BY `couponId` ASC ";
                    //取得生效類型進行合併
                    $sqlEffect = "SELECT `secondlevel`.`second_level_category_name`,`couponall`.`second_level_category_id`
                                FROM `secondlevel`
                                INNER JOIN `couponall`
                                ON `secondlevel`.`second_level_category_id` = `couponall`.`second_level_category_id`";

                     $sqlEffectAno = "SELECT `thirdlevel`.`third_level_category_name`,`couponall`.`third_level_category_id`
                                    FROM `thirdlevel`
                                    INNER JOIN `couponall`
                                    ON `thirdlevel`.`third_level_category_id` = `couponall`.`third_level_category_id`";

                    // 取得適用對象範圍
                    $sqlEffectUse = "SELECT `cuponuse`.`cuponuseName`,`couponall`.`couponId`
                                    FROM `cuponuse`
                                    INNER JOIN `couponall`
                                    ON `cuponuse`.`couponId` = `couponall`.`couponId`";
                        //設定繫節質                           
                        // $sqlCount ="SELECT COUNT(seller_id) FROM `basic_information`";
                        // $stmt1 = $pdo->prepare($sqlCount);
                        // $stmt1->execute();
                        // $arrParam = [
                        //     ($page - 1) * $numPerPage, 
                        //     $numPerPage
                        // ];
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute();

                      

                        $stmtEffect = $pdo->prepare($sqlEffect);
                        $stmtEffect->execute();
                       

                        
                        $sqlEffectAno = $pdo->prepare($sqlEffectAno);
                        $sqlEffectAno->execute();

                        $sqlEffectUse = $pdo->prepare($sqlEffectUse);
                        $sqlEffectUse->execute();

                        //資料量> 0則列出所有資料
    
                        if($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $arrEffect = $stmtEffect->fetchAll(PDO::FETCH_ASSOC);
                            $arrEffectAno = $sqlEffectAno->fetchAll(PDO::FETCH_ASSOC);
                            $arrEffectUse = $sqlEffectUse->fetchAll(PDO::FETCH_ASSOC);


                            //用for迴圈逐一取得資料 count()是加總陣列長度
										for($i = 0 ; $i < count($arr) ; $i++){
											//用for迴圈逐一比對狀況編號，如果一致就把狀況類型名稱賦值給$type並離開迴圈印出資料
											//如果比對不成功則賦值null
                                            if ($stmtEffect->rowCount() > 0) {
                                                for( $j = 0 ; $j < count( $arrEffect ) ; $j++){
                                                    if ($arr[$i]['second_level_category_id'] == $arrEffect[$j]['second_level_category_id']) {
														$CondNameA =  $arrEffect[$j]['second_level_category_name'];
														break;
													} else {
														$CondNameA = 'null';
													};
												};
											} else {
                                                $CondNameA = 'null';
                                            }
                                          
                                            if ( $sqlEffectAno->rowCount() > 0) {
                                                    for( $k = 0 ; $k < count($arrEffectAno) ; $k++){
                                                        if ($arr[$i]['third_level_category_id'] == $arrEffectAno[$k]['third_level_category_id']) {
                                                            $CondNameB = $arrEffectAno[$k]['third_level_category_name'];
                                                            break;
                                                        } else {
                                                            $CondNameB = 'null';
                                                        };
                                                    };
                                                } else {
                                                    $CondNameB = 'null';
                                                }
                                            if ( $sqlEffectUse->rowCount() > 0) {
                                                    for( $h = 0 ; $h < count($arrEffectUse) ; $h++){
                                                        if ($arr[$i]['couponId'] == $arrEffectUse[$h]['couponId']) {
                                                            $EffectUse = $arrEffectUse[$h]['cuponuseName'];
                                                            break;
                                                        } else {
                                                            $EffectUse = 'null';
                                                        };
                                                    };
                                                } else {
                                                    $EffectUse = 'null';
                                                }
                        ?>
                        
                        <tr>                   
                                <td> 
                                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]["couponId"]?>"/>
                                </td>
                                <td class="couponId"><?php echo $arr[$i]["couponId"]; ?></td>
    
                                
                                </td> 
                                <td class="couponImg">
                                    <?php if($arr[$i]["couponImg"] !== NULL) { ?>
                                    <img class="w50" src="../image/sellers/<?php echo $arr[$i]["couponImg"];?>" >
                                    <?php } ?>
                                </td>
                                <td class="couponName"><?php echo $arr[$i]["couponName"]; ?></td>
                                <td class="CondNameA"><?php echo $CondNameA; ?></td>
                                <td class="CondNameB"><?php echo $CondNameB; ?></td>
                                <td class="timeStart"><?php echo $arr[$i]["StartDate"]; ?></td>
                                <td class="timeOver"><?php echo $arr[$i]["OverDate"]; ?></td>
                                <td class="itemCategoryId"><?php echo $arr[$i]["itemCategoryId"]; ?></td>
                                <td class="EffectUse"><?php echo $EffectUse; ?></td>
                                <td class="times"><?php echo $arr[$i]["Times"]; ?></td>
                                <td class="create_time"><?php echo $arr[$i]["create_time"]; ?></td>
                                <td class="update_time"><?php echo $arr[$i]["update_time"]; ?></td>

                                <td class="edit">
                                    <a href="./edit.php?editId=<?php echo $arr[$i]["couponId"]; ?>">
                                    查看
                                    </a>
                                    <a href="./delete.php?deleteId=<?php echo $arr[$i]["couponId"]; ?>">
                                    刪除
                                    </a>
                                </td>
                        </tr>
                        <?php
                        };
                        }; 
                    
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="9">
                            <?php for($i = 1;$i <=$totalPages;$i++){?>
                                <a href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php } ?>
                            </td>
                        </tr>
                    </tfoot>
                    </table>
                    <a name="submit" type="submit" id="" class="btn btn-danger" href="#" role="button">
                    刪除多筆
                    </a>
                 
                </form>
            </div>
            <div class="py-3 form_2">
            <form name="myForm" method="POST" action="insertDynamic.php"  enctype="multipart/form-data">
            <a name="new_data" type="submit" id="" class="btn add_row btn-warning" href="#" role="button">
                   新增多筆
                    </a>
            <button name="new_data" type="submit" id="" class="btn btn-warning" href="#" role="button">
                   提交多筆
                    </button>
         

                <table class="table table_add">
                <thead class="thead-dark">
                        <tr>
                        <th>Choose</th>
                        <th>Id</th>
                        <th>Image</th>
                        <th>Name</th>
                        <th>password</th>
                        <th>address</th>
                        <th>phone</th>
                        <th>mobile</th>
                        <th>Status</th>
                        <th>Email</th>
                        <th>Join_time</th>
                        </tr>
                    </thead>
                    <tbody class="append_position_c">
                     </tbody>
                </table>
            </form>
            </div>
        </div>
    </div>
    </div>
    
    <script src="../js/jq1.7.2.js"></script>
                          
    <script>

        let chooseTbody = $(".append_position_c");
        let i = $(".append_position_c tr").size() + 1;
        let s = `
                    <tr>
                        <td>
                        <input type="submit" class="btn btn-primary remove_row"  value="remove">
                        </td>
                        <td class="">
                            <input type="text" name="seller_id[]" id="seller_id" value="" maxlength="8" />
                        </td>
                        <td class="">
                            <input type="file" name="seller_img[]" />
                        </td>
                        <td class="">
                            <input type="text" name="seller_name[]" id="seller_name" value="" maxlength="8" />
                        </td>
                        <td class="">
                            <input type="text" name="seller_password[]" id="seller_password" value="" maxlength="10" />   
                        </td>
                        <td class="">
                            <input type="text" name="seller_address[]" id="seller_address" value="" maxlength="30" />
                        </td>
                        <td class="">
                            <input type="text" name="seller_phone[]" id="seller_phone" value="" maxlength="10" />
                        </td>
                        <td class="">
                        <input type="text" name="seller_mobile[]" id="seller_mobile" value="" maxlength="10" />
                        </td>
                        <td class="">
                        <select name="seller_status[]" id="seller_status">
                            <option value="active" selected>active</option>
                            <option value="inactive">inactive</option>
                            <option value="suspended">suspended</option>
                        </select>
                        </td>
                        <td class="">
                        <input type="email" name="seller_email[]" id="seller_email" value="" maxlength="30" />
                        </td>
                        <td>
                        <input type="date" name="join_time[]" id="join_time" value="" />
                        </td>
                        
                    </tr>
                
        `;


        $("body").on("click",".add_row",function(){
        chooseTbody.append(s);
                    i++;
                    return false;
        });
        //移除邏輯
        $(document).on('click', '.remove_row', function() {
             if (i >= 1) {
                $(this).closest('tr').remove();
                    i--;
               }
                    return false;
                });
    </script>
