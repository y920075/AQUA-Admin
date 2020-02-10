<?php

//fetch_third_level_category.php

include('../template/db.inc.php');

if(isset($_POST["selected"])){
    $id = join("','",$_POST["selected"]);
    

   
    //  $query = "SELECT * FROM `thirdlevel` 
//  WHERE `second_level_category_id` IN ('".$id."')"; 

$query = "SELECT * FROM `thirdlevel` WHERE `second_level_category_id` IN ('".$id."')";
 $statement = $pdo->prepare($query);
 $statement->execute();
 $result = $statement->fetchAll();

 $output = '';
 foreach($result as $row)
 {
  $output .= '<option value="'.$row["third_level_category_id"].'">'.$row["third_level_category_name"].'</option>';
 }
 echo $output;

// echo "我沒有錯";
}




?>