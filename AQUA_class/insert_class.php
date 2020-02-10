<?php
require_once('../template/db.inc.php');

// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit();

if ( (int)$_POST['classNOWpeople'] > (int)$_POST['classMAXpeople'] ) {
    header("Refresh: 0.1 ; url=./class_admin.php");
    echo '<script type="text/javascript">alert("現在人數不可大於徵求人數!");</script>';
    exit();
}

$classid = $_POST['classId'];
$maxId = $_POST['maxId'] + 1;

//用來驗證編號有沒有重複
$sqlCheckId = "SELECT `classId`
               FROM `class_data`
               WHERE `classId`='$classid'";
$stmtCheckId = $pdo->prepare($sqlCheckId);
$stmtCheckId->execute();
if($stmtCheckId->rowCount() > 0){
    header("Refresh: 0.1 ; url=./addclass.php");
    echo '<script type="text/javascript">alert("課程編號重複!");</script>';
    exit();
}



$sql = "INSERT INTO `class_data` 
        (`classId`,`maxId`,`className`,`classTypeId`,`classLevelID`,`classStartDate`,`classPrice`,`classDesc`,`classMAXpeople`,`classNOWpeople`,`classImg`,`sellerID`) 
        VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

//如果檔案正常上傳
if($_FILES['classImg']['error'] === 0){
    //取得時間字串 格式為 E + 年月日時分秒
    $eventImg = 'C'.date('YmdHis');
    //取得副檔名
    $extension = pathinfo($_FILES['classImg']['name'],PATHINFO_EXTENSION);
    //建立新檔案名稱 用取得的時間字串+副檔名 命名 
    $classtimgFileName = $eventImg.".".$extension;

    //如果檔案沒有被移動，則提示上傳失敗並退出
    if(!move_uploaded_file($_FILES['classImg']['tmp_name'],"../image/classImg/".$classtimgFileName)){
        header("Refresh: 2 ; url=./class_admin.php");
        echo '圖片上傳失敗';
        exit();
    }
} else {
    $classtimgFileName = '';
}

$stmt = $pdo->prepare($sql);


//繫結陣列
$arrStmt = [
    $classid,
    $maxId,
    $_POST['className'],
    $_POST['classTypeId'],
    $_POST['classLevelID'],
    $_POST['classStartDate'],
    $_POST['classPrice'],
    $_POST['classDesc'],
    $_POST['classMAXpeople'],
    $_POST['classNOWpeople'],
    $classtimgFileName,
    $_POST['sellerID']

];
$stmt->execute($arrStmt);

//如果SQL語法影響行數大於0 就跳轉回去
if ( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1 ; url=./class_admin.php");
    echo '<script type="text/javascript">alert("新增成功!");</script>';
    exit();
} else {
    header("Refresh: 0.1 ; url=./addclass.php");
    echo '<script type="text/javascript">alert("新增失敗，請檢查是否有資料輸入錯誤!");</script>';
}