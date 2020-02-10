<table id="myTable" class="table sortable">
    <thead class="thead-light">
        <tr>
            <th class="text-center" scope="col ">
            </th>
            <th scope="col">商品ID</th>
            <th scope="col">圖片</th>
            <th scope="col">商品名稱</th>
            <th scope="col">類別</th>
            <th scope="col">賣家ID</th>
            <th scope="col">價格</th>
            <th scope="col">數量</th>
            <th scope="col">已售出</th>
            <th scope="col">狀態</th>
        </tr>
    </thead>
    <tbody>
    <?php
    if($stmt->rowCount() > 0){
        $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
        for($i = 0; $i < count($arr); $i++){
    ?>
        <tr>
            <td><?php echo $arr[$i]['itemId']?></td>
            <td>
                <img style="max-width: 100px " src="../image/items/<?php echo $arr[$i]['itemImg'] ?>">
            </td>
            <td><?php echo $arr[$i]['itemName']?></td>
            <td><?php echo $arr[$i]['itemCategoryId']?></td>
            <td><?php echo $arr[$i]['itemSellerId']?></td>
            <td><?php echo "\$".$arr[$i]['itemPrice']?></td>
            <td><?php echo $arr[$i]['itemQty']?></td>
            <td>-</td>
            <td><?php echo $arr[$i]['itemStatus']?></td>
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