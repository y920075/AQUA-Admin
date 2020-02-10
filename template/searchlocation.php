<table class="table sortable">
	<thead>
        <tr>
            <th scope="col">地點編號</th>
            <th scope="col">地點名稱</th>
            <th scope="col">地點區域</th>
            <th scope="col">地點難度</th>
            <th scope="col">滿意度</th>
            <th scope="col" class="sorttable_nosort">地點描述</th>
            <th scope="col" class="sorttable_nosort">交通資訊</th>
        </tr>
    </thead>
    <tbody>
        <?php
            if($stmt->rowCount() > 0) {
                $arr = $stmt->fetchAll(PDO::FETCH_ASSOC);
                for($i = 0 ; $i < count($arr) ; $i++){
                    ?>
                <tr>
                    <td><?php echo $arr[$i]['LocationID']; ?></td>
                    <td><?php echo $arr[$i]['LocationName']; ?></td>
                    <td><?php echo $arr[$i]['LocationArea']; ?></td>
                    <td><?php echo $arr[$i]['Locationlevel']; ?></td>
                    <td><?php echo $arr[$i]['Satisfaction']; ?></td>
                    <td><?php echo $arr[$i]['Locationdescribe']; ?></td>
                    <td><?php echo $arr[$i]['Transportation']; ?></td>
                </tr>
        <?php	}
            } ?>
    </tbody>
        <tfoot>
            <tr>
                <td class="border text-center" colspan="9">
                <?php for($i = 1; $i <= $totalPages; $i++){ ?>
                    <a href="?page=<?= $i ?>"><?= $i ?></a>
                <?php } ?>
                </td>
            </tr>
        </tfoot>
</table>