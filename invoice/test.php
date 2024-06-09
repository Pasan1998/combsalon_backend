

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Combined Data</title>
</head>

<body>

    <?php
    // Your database connection code here
    include '../function.php';
    $db = dbConn();
    
    // Perform the first query
    $query1 = "SELECT DATE(Addeddate) AS Cashout_day, SUM(Amountcashout) AS total_cashouts FROM tbl_cashout GROUP BY DATE(Addeddate) ORDER BY DATE(Addeddate) DESC";
    $result1 =  $db->query($query1);

    // Perform the second query
    $query2 = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleCost) AS total_cost FROM tbl_sales GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
    $result2 =  $db->query($query2);

    // Fetch results and combine based on date
    $combinedData = array();

    while ($row1 = mysqli_fetch_assoc($result1)) {
        $combinedData[$row1['Cashout_day']] = array('total_cashouts' => $row1['total_cashouts']);
    }

    while ($row2 = mysqli_fetch_assoc($result2)) {
        $date = $row2['sale_day'];
        if (isset($combinedData[$date])) {
            $combinedData[$date]['total_cost'] = $row2['total_cost'];
            $combinedData[$date]['net_total'] = $row2['total_cost'] + $combinedData[$date]['total_cashouts'];
        } else {
            $combinedData[$date] = array(
                'total_cost' => $row2['total_cost'],
                'total_cashouts' => 0,
                'net_total' => $row2['total_cost']
            );
        }
    }
    ?>

    <table border="1">
        <thead>
            <tr>
                <th>Date</th>
                <th>Total Cost</th>
                <th>Total Cashouts</th>
                <th>Net Total</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($combinedData as $date => $data) : ?>
                <tr>
                    <td><?= $date ?></td>
                    <td><?= $data['total_cost'] ?></td>
                    <td><?= $data['total_cashouts'] ?></td>
                    <td><?= $data['net_total'] ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

</body>

</html>
