<?php
    header("Content-Type:text/html; charset=utf-8");
    require_once('./db.inc.php');

    $class = $_POST['class'];
    $keyword = $_POST['search'];
    
    $sql = "SELECT * 
            FROM  `$class`";
    // 根據搜尋類別不同改變搜尋的欄位
    switch ($class) { 
        case "items":
            $sql.= "WHERE `itemName` LIKE '%$keyword%'";
            break;
        case "my_member":
            $sql.= "WHERE `loginId` LIKE '%$keyword%'";
            break;
        case "basic_information":
            $sql.= "WHERE `seller_name` LIKE '%$keyword%'";
        break;
        case "orders":
            $sql.= "INNER JOIN `items`
                    ON `orders`.`orderItemId` = `items`.`itemId`
                    WHERE `orderId` LIKE '%$keyword%'";
        break;
        case "event_data":
            $sql.= "WHERE `eventName` LIKE '%$keyword%'";
        break;
        case "class_data":
            $sql.= "WHERE `className` LIKE '%$keyword%'";
        break;
        case "blog":
            $sql.= "WHERE `blogTitle` LIKE '%$keyword%'";
        break;
        case "location":
            $sql.= "WHERE `LocationName` LIKE '%$keyword%'";
        break;
    }
    $sqlTotal = "SELECT count(1) FROM `$class`";
    $total = $pdo->query($sqlTotal)->fetch(PDO::FETCH_NUM)[0];
    $numPerPage = 15;
    $totalPages = ceil($total/$numPerPage); 
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $page = $page < 1 ? 1 : $page;
    $arrParam = [($page - 1) * $numPerPage, $numPerPage];
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    ?>
<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>AQUA - 搜尋結果</title>
        <link href="../css/bootstrap.min.css" rel="stylesheet">
        <link href="../css/font-awesome.min.css" rel="stylesheet">
        <link href="../css/datepicker3.css" rel="stylesheet">
        <link href="../css/styles.css" rel="stylesheet">
        <!--Custom Font-->
        <link href="https://fonts.googleapis.com/css?family=Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">
        <link rel="shortcut icon" href="../image/aquafavicon.png" type="image/x-icon">
        <!--[if lt IE 9]>
        <script src="js/html5shiv.js"></script>
        <script src="js/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <?php
            require_once('./header.php');
            require_once('./sidebar.php');
        ?>
        <div class="col-sm-9 col-sm-offset-3 col-lg-10 col-lg-offset-2 main">
            <div class="row">
                <ol class="breadcrumb">
                    <li><a href="#">
                        <em class="fa fa-home"></em>
                    </a></li>
                    <li class="active">搜尋結果</li>
                </ol>
            </div><!--/.row-->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">搜尋結果</div>
                        <div class="panel-body">
                            <div class="col-md-12">
                                <?php
                                    switch ($class){
                                        case "items":
                                            require_once('./searchitem.php');
                                        break;
                                        case "my_member":
                                            require_once('./searchmember.php');
                                        break;
                                        case "basic_information":
                                            require_once('./searchbasic_information.php');
                                        break;
                                        case "orders":
                                            require_once('./searchorders.php');
                                        break;
                                        case "event_data":
                                            require_once('./searchevent_date.php');
                                        break;
                                        case "class_data":
                                            require_once('./searchclassname.php');
                                        break;
                                        case "blog":
                                            require_once('./searchblog.php');
                                        break;
                                        case "location":
                                            require_once('./searchlocation.php');
                                        break;
                                    }    
                                ?>
                            </div>
                        </div>
                    </div><!-- /.panel-->
                </div><!-- /.col-->
                
            </div><!-- /.row -->
	    </div><!--/.main-->    
    </body>
</html>