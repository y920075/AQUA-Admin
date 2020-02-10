<?php

 require_once("../template/db.inc.php");

//  echo "<pre>";

//  echo $_POST["selected"];


//   echo "</pre>";

 if(isset($_POST["selected"])){

        // echo json_encode($_POST["selected"]);

     $id = join("','",$_POST["selected"]);

     $query = "SELECT * FROM `secondlevel`
     WHERE `first_level_category_id` IN ('".$id."')";

     $stm = $pdo->prepare($query);
     $stm->execute();
     $result = $stm->fetchAll();
     $output = '';
     foreach($result as $row){
         $output .= '<option value="'.$row["second_level_category_id"].'">'.$row["second_level_category_name"].'</option>';
     }
     echo $output;
    }
 
 
 ?>
