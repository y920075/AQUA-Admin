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
				<li class="active text_size_chin_4">賣家資料</li>
				<li class=""><a class="text_size_chin_4" href="new.php">新增賣家</a></li>
                <li class="active" ><a class="text_size_chin_4" href="seller_cond.php">賣家狀態</a></li>

			</ol>
           
		</div><!--/.row-->
     
        <div class="row">
            <div class="form_1">
            <form name="myForm" method="POST" action="deleteIds.php">
                    <table id="myTable" class="sortable table table_add">
                    <thead class="thead-dark table_header_Color_chin">
                        <tr>
                        <th>選擇</th>
                        <th>賣家Id</th>
                        <!-- <th>IdIncre</th> -->
                        <th>圖片</th>
                        <th>姓名</th>
                        <th>密碼</th>
                        <th>地址</th>
                        <th>電話</th>
                        <th>手機</th>
                        <th>狀態</th>
                        <th>電郵</th>
                        <th>加入時間</th>
                        <th>功能</th>
                        </tr>
                    </thead>
                    <tbody class="append_position">

                    <?php
                    $sql = "SELECT `seller_id`,`seller_name`,
                            `seller_password`,`seller_address`,
                            `seller_phone`,`seller_mobile`,
                            `seller_status`,`seller_email`,
                            `join_time`,`seller_img`
                            FROM `basic_information`
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

                        $stmt = $pdo->prepare($sql);
                        // $stmt->execute($arrParam);
                        $stmt->execute();
                        //資料量> 0則列出所有資料
    
                        if($stmt->rowCount() > 0) {
                            $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                            for($i = 0; $i < count($arr); $i++){
                        ?>
                        
                        <tr>                   
                                <td> 
                                    <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]["seller_id"]; ?>"/>
                                </td>
                                <td class="seller_id"><?php echo $arr[$i]["seller_id"]; ?></td>
                                <!-- <td class="seller_id">
                                
                                // if(strlen(count($arr)) == 1){
                                //     echo "A" . date("ymd") . sprintf("%'.07d\n",$i);
                                // }else if(strlen(count($arr)) == 2){
                                //     echo "A" . date("ymd") .  sprintf("%'.06d\n",$i);
                                // }else if(strlen(count($arr)) == 3){
                                //     echo "A" .  date("ymd") .  sprintf("%'.05d\n",$i);

                                // }else{
                                //     echo "A" .date("ymd") .  (string)$i;

                                // }
                                
                                </td> -->
                                <td class="seller_img">
                                    <?php if($arr[$i]["seller_img"] !== NULL) { ?>
                                    <img class="w50" src="../image/sellers/<?php echo $arr[$i]["seller_img"];?>" >
                                    <?php } ?>
                                </td>
                                <td class="seller_name"><?php echo $arr[$i]["seller_name"]; ?></td>
                                <td class="seller_password"><?php echo $arr[$i]["seller_password"]; ?></td>
                                <td class="seller_address"><?php echo $arr[$i]["seller_address"]; ?></td>
                                <td class="seller_phone"><?php echo $arr[$i]["seller_phone"]; ?></td>
                                <td class="seller_mobile"><?php echo $arr[$i]["seller_mobile"]; ?></td>
                                <td class="seller_status"><?php echo $arr[$i]["seller_status"]; ?></td>
                                <td class="seller_email"><?php echo $arr[$i]["seller_email"]; ?></td>
                                <td class="join_time"><?php echo $arr[$i]["join_time"]; ?></td>
                                <td class="edit">
                                    <a href="./edit.php?editId=<?php echo $arr[$i]["seller_id"]; ?>">
                                    查看
                                    </a>
                                    <a href="./delete.php?deleteId=<?php echo $arr[$i]["seller_id"]; ?>">
                                    刪除
                                    </a>
                                </td>
                        </tr>
                        <?php
                        }
                        } else {
                        ?>
                        <tr>
                            <td colspan="9">沒有資料</td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot>
                        <tr >
                            <td class="border_top_chin" colspan="9">
                            <!-- <?php for($i = 1;$i <=$totalPages;$i++){?> -->
                                <!-- <a href="?page=<?= $i ?>"><?= $i ?></a> -->
                            <!-- <?php } ?> -->
                            </td>
                        </tr>
                    </tfoot>
                    </table>
                    <button name="submit" type="submit" id="" class="btn btn-danger"  role="button">
                    刪除多筆
                    </button>
                 
                </form>
            </div>
           
    <?php require_once("../template/footer.php");?>
    <?php require_once("./JSScripts.php");?>

    <?php 
    
    $add = 'S'. $time . $total_num; ?>
    <?php 
    $idd_add = $idd[0];
    ?>
 
     <script>
     $(document).ready( function () {
        $('#myTable').DataTable();
        } );
     </script>                     
    
