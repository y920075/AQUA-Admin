<table id="myTable" class="sortable table table_add">
<thead class="thead-dark table_header_Color_chin">
    <tr>
    <th>選擇</th>
    <th>賣家Id</th>
    <!-- <th>IdIncre</th> -->
    <th>姓名</th>
    <th>密碼</th>
    <th>地址</th>
    <th>電話</th>
    <th>手機</th>
    <th>狀態</th>
    <th>電郵</th>
    <th>加入時間</th>
    </tr>
</thead>
<tbody class="append_position">

<?php
    if($stmt->rowCount() > 0) {
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++){
    ?>
    
    <tr>                   
            <td> 
                <input type="checkbox" name="chk[]" value="<?php echo $arr[$i]["seller_id"]; ?>"/>
            </td>
            <td class="seller_id"><?php echo $arr[$i]["seller_id"]; ?></td>
            <td class="seller_name"><?php echo $arr[$i]["seller_name"]; ?></td>
            <td class="seller_password"><?php echo $arr[$i]["seller_password"]; ?></td>
            <td class="seller_address"><?php echo $arr[$i]["seller_address"]; ?></td>
            <td class="seller_phone"><?php echo $arr[$i]["seller_phone"]; ?></td>
            <td class="seller_mobile"><?php echo $arr[$i]["seller_mobile"]; ?></td>
            <td class="seller_status"><?php echo $arr[$i]["seller_status"]; ?></td>
            <td class="seller_email"><?php echo $arr[$i]["seller_email"]; ?></td>
            <td class="join_time"><?php echo $arr[$i]["join_time"]; ?></td>
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