<?php 
    require_once('../template/db.inc.php');
// echo '<pre>';
// print_r($_POST);
// echo '</pre>';
// exit();

//設定更新sql語法
$sql = "UPDATE `class_data` 
    SET 
    `classId` = ?, 
    `className` = ?,
    `classTypeId` = ?,
    `classLevelID` = ?,
    `classPrice` = ?,
    `classStartDate` = ?,
    `classDesc` = ?, 
    `classMAXpeople` = ?, 
    `classNOWpeople` = ?, 
    `sellerID` = ? ";

//設定繫結陣列
$arrParam = [
    $_POST['classId'],
    $_POST['className'],
    $_POST['classTypeId'],
    $_POST['classLevelId'],
    $_POST['classPrice'],
    $_POST['classStartDate'],
    $_POST['classDesc'],
    $_POST['classMAXpeople'],
    $_POST['classNOWpeople'],
    $_POST['sellerID']
];

//如果檔案成功上傳
if( $_FILES['classImg']['error'] === 0 ){
    //取得E+時間字串
    $classImg = 'C'.date('YmdHis');
    //取得副檔名
    $extension = pathinfo( $_FILES['classImg']['name'],PATHINFO_EXTENSION);
    //建立新檔案名稱 用取得的時間字串+副檔名命名
    $classtimgFileName = $classImg.".".$extension;

    //如果檔案移動成功，則表示舊檔案需要被刪除
    if (move_uploaded_file($_FILES['classImg']['tmp_name'],"../image/classImg/".$classtimgFileName)){
        //查詢SQL語法
        $sqlGetImg = "SELECT `classImg` FROM `class_data` WHERE `classId` = ?";
        $stmtImg = $pdo->prepare($sqlGetImg);

        //繫結陣列，這裡使用的editId是從隱藏的input元素傳送的
        $arrGetImgParam = [
            $_POST['editId']
        ];

        //執行sql語法
        $stmtImg->execute($arrGetImgParam);
        //如果影響行數大於0 就執行刪除檔案
        if($stmtImg->rowCount() > 0){
            $arrImg = $stmtImg->fetchAll(PDO::FETCH_ASSOC);
            
            //如果資料庫中的classImg的值不為NULL，則表示有檔案存在
            if( $arrImg[0]['classImg'] !== NULL ){
                //將檔案強制刪除，並無視錯誤訊息
                @unlink("../image/classImg/".$arrImg[0]['classImg']);
            }
            //如果刪除完畢，將classImg加入原先的SQL語法查詢
            $sql.=",";
            $sql.="`classImg` = ? ";

            //新增繫結陣列的值
            $arrParam[] = $classtimgFileName;
        }
    }
}

//加入SQL WHERE篩選條件
$sql.= "WHERE `classId` = ? ";
//這裡editId值來自於隱藏的input元素傳送的
$arrParam[] = $_POST['editId'];

$stmt = $pdo->prepare($sql);
$stmt->execute($arrParam);

if( $stmt->rowCount() > 0 ){
    header("Refresh: 0.1; url=./class_admin.php");
    echo '<script type="text/javascript">alert("資料修改成功!");</script>';
} else {
    header("Refresh: 0.1; url=./class_admin.php");
    echo '<script type="text/javascript">alert("沒有資料被修改!");</script>';
}

?>
