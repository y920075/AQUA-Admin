<?php require_once("./header_seller.php");?>
<?php require_once("../template/db.inc.php");?>


<?php
//   header('Content-Type: application/javascript');

// $sqlTotal = "SELECT count(1) FROM `basic_information`";


// $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];

// echo $total;

// $numPerPage = 5;//每頁五筆

// //總頁數

// $totalPages = ceil($total/$numPerPage);

// //目前第幾頁

// $page = isset($_GET["page"]) ? (int)$_GET["page"] : 1;

// //如果page頁小於1回傳1

// $page = $page < 1 ? 1 : $page;
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
<body>
    <?php require_once("../template/header.php");?>
    <?php require_once("../template/sidebar.php");?>
    <div class="container-fluid">
    <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
		<div class="row">
			<ol class="breadcrumb">
				<li><a href="#">
					<em class="fa fa-home text_size_chin_4"></em>
				</a></li>
				<li class="active"><a class="text_size_chin_4" href="seller.php">賣家資料</a></li>
				<li class="active"><a class="text_size_chin_4" href="new.php">新增賣家</a></li>
                <li class="active text_size_chin_4">賣家狀態</li>

			</ol>
           
		</div><!--/.row-->
     
        <div class="row">
            <div class="form_1">
            <form name="myForm" method="POST" action="deleteIds.php">
                    <table id="myTable" class="sortable table table_add">
                    <thead class="thead-dark table_header_Color_chin">
                        <tr>
                        <th>賣場Id</th>
                        <!-- <th>IdIncre</th> -->
                        <th>賣場圖片</th>
                        <th>賣場名</th>

                        <th>賣家商品類</th>
                        <th>賣家總分</th>
                        <th>賣家等級</th>
                        <th>狀態</th>
                        <th>加入時間</th>
                        <th>功能</th>
                        </tr>
                    </thead>
                    <tbody class="append_position">
                    <?php
                    $sql = "SELECT `seller_id`,`seller_level`,
                            `seller_score`,`itemId`
                            FROM `sellercondition`
                            ORDER BY `seller_id` ASC";
                            // LIMIT ?,? ";
                        //設定繫節質
                        // $sqlCount ="SELECT COUNT(seller_id) FROM `basic_information`";
                        // $stmt1 = $pdo->prepare($sqlCount);
                        // $stmt1->execute();
                        // $arrParam = [
                        //     ($page - 1) * $numPerPage, 
                        //     $numPerPage
                        // ];
                        //查詢分頁的學生資料

                        $sql_seller_cond = "SELECT `sellercondition`.`seller_id`,`basic_information`.`seller_img`,
                                            `basic_information`.`seller_name`,
                                            `basic_information`.`seller_status`,`basic_information`.`join_time`
                                            FROM `sellercondition`
                                            INNER JOIN `basic_information`
                                            ON `basic_information`.`seller_id` = `sellercondition`.`seller_id`";

                        $sql_item_cond = "SELECT `sellercondition`.`itemId`,`items`.`itemCategoryId`
                                            FROM `sellercondition`
                                            INNER JOIN `items`
                                            ON `items`.`itemId` = `sellercondition`.`itemId`";


                        $stmt = $pdo->prepare($sql);
                        // $stmt->execute($arrParam);
                        $stmt->execute();


                        
                        $stmt_seller_cond = $pdo->prepare($sql_seller_cond);
                        $stmt_seller_cond->execute();


                        $stmt_item_cond = $pdo->prepare($sql_item_cond);
                        $stmt_item_cond->execute();
                           //資料量> 0則列出所有資料
    
                           if($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            $arr_seller_cond = $stmt_seller_cond->fetchAll(PDO::FETCH_ASSOC);

                            $arr_item_cond = $stmt_item_cond->fetchAll(PDO::FETCH_ASSOC);

                            for($i = 0 ; $i < count($arr) ; $i++){

                            if ($stmt_seller_cond->rowCount() > 0) {
                                for( $j = 0 ; $j < count( $arr_seller_cond ) ; $j++){
                                    if ($arr[$i]['seller_id'] == $arr_seller_cond [$j]['seller_id']) {
                                        $seller_cond_status =  $arr_seller_cond[$j]['seller_status'];
                                        $seller_cond_img =  $arr_seller_cond[$j]['seller_img'];
                                        $seller_cond_name =  $arr_seller_cond[$j]['seller_name'];
                                        $seller_join_time =  $arr_seller_cond[$j]['join_time'];
                                        break;
                                    } else {
                                        $seller_cond_status = 'null';
                                        $seller_cond_img =  'null';
                                        $seller_cond_name =  'null';
                                        $seller_join_time  =  'null';
                                    };
                                };
                            } else {
                                $seller_cond_status = 'null';
                                $seller_cond_img =  'null';
                                $seller_cond_name =  'null';
                                $seller_join_time  =  'null';

                            }

                            if ( $stmt_item_cond->rowCount() > 0) {
                                for( $k = 0 ; $k < count($arr_item_cond) ; $k++){
                                    if ($arr[$i]['itemId'] == $arr_item_cond[$k]['itemId']) {
                                        $item_cond = $arr_item_cond[$k]['itemCategoryId'];
                                        break;
                                    } else {
                                        $item_cond = 'null';
                                    };
                                };
                            } else {
                                $item_cond = 'null';
                            }
                            ?>
                              <tr data-scores="<?php echo $arr[$i]['seller_score'];?>" class="filter-items">                   
                               
                                <td class="seller_id"><?php echo $arr[$i]["seller_id"]; ?></td>
    
                                
                                </td> 
                                <td class="seller_img">
                                    <?php if($seller_cond_img !== NULL) { ?>
                                    <img class="w50" src="../image/sellers/<?php echo $seller_cond_img;?>" >
                                    <?php } ?>
                                </td>
                                <td class="seller_name"><?php echo $seller_cond_name; ?></td>
                                <td class="itemCategoryId"><?php echo $item_cond; ?></td>
                                <td class="seller_level"><?php echo $arr[$i]["seller_score"]; ?></td>
                                <td class="seller_score"><?php echo $arr[$i]["seller_level"]; ?></td>
                                <td class="seller_cond_status"><?php echo $seller_cond_status; ?></td>
                                <td class="seller_join_time"><?php echo  $seller_join_time ; ?></td>

                                <td class="edit">
                                    <a href="./seller_cond_edit.php?editId=<?php echo $arr[$i]["seller_id"]; ?>">
                                    詳細資訊
                                    </a>
                                   
                                </td>
                        </tr>
                        <?php
                            };
                        };
                              
                        ?>
                    </tbody>
                    <!-- <tfoot>
                        <tr>
                            <td colspan="9">
                            <?php for($i = 1;$i <=$totalPages;$i++){?>
                                <a href="?page=<?= $i ?>"><?= $i ?></a>
                            <?php } ?>
                            </td>
                        </tr> -->
                    </tfoot>
                    </table>
                 
                </form>
            </div>
            <?php require_once("../template/footer.php");?>
            <?php require_once("./JSScripts.php");?>
            <?php require_once("../template/tpl-filter.php");?>
            <script>
     $(document).ready( function () {
    $('#myTable').DataTable();
        } );
     </script>                     
    
