<table id="myTable" class="table sortable">
    <thead class="thead-light">
            <th scope="col">買家</th>
            <th scope="col">商品名稱 </th>
            <th scope="col">數量 </th>
            <th scope="col">訂單金額 </th>
            <th scope="col">更新時間 </th>
    </thead>
    <?php
    if($stmt->rowCount() > 0){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++){
    ?>
    <thead class="thead-light" style="margin-top: 10px">      
            <th scope="col"><?php echo $arr[$i]['orderMemberId'] ?></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col"></th>
            <th scope="col">訂單編號:<?php echo $arr[$i]['orderId'] ?> </th>
    </thead>
    <tbody>
        <tr>
            <td>
                <img style="max-width: 100px " src="../image/items/<?php echo $arr[$i]['itemImg'] ?>">
            </td>
            <td><?php echo $arr[$i]['itemName']?></td>
            <td><?php echo 'x'.$arr[$i]['checkQty']?></td>
            <td><?php echo "\$".$arr[$i]['checkSubtotal']?></td>
            <td><?php echo $arr[$i]['updated_at']?></td>
            <td>
            <button type="button" onclick="check(this.form)" class="btn btn-default" data-toggle="modal" data-target="#exampleModal"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>查看詳情</button>
                
            </td>
        </tr>
    <?php
        }
    }
    ?>
    </tbody>
    <tfoot>
        <tr>
            <td class="border" colspan="11">
            <!-- <?php for($i = 1; $i <= $totalPages; $i++){ ?>
            <a href="?page=<?php echo $i ?>"><?php echo $i ?></a>
            <?php } ?> -->
            </td>
        </tr>
    </tfoot>
</table>