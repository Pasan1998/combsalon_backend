<?php
session_start();
include '../sidebar.php';
if (isset($_SESSION['EmpUserrole']) && $_SESSION['EmpUserrole'] == "management") {
  // The user has the "management" role
  // echo "User has the management role.";
} else {
  // Redirect to the login page or show an unauthorized message
  header("Location:http://localhost/salon/production/page_403.html");

  
}

  ?>
<!-- page content -->
<div class="right_col" role="main">
  <div class="">


    <div class="clearfix"></div>

    <div class="row">
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sales Report</h2>
            <ul class="nav navbar-right panel_toolbox">
              <form method="post" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>">
                <div class="row g-3">

                  <!-- <div class="col-sm">
                      <?php
                      //                $db = dbConn();
//                $sql = "SELECT DISTINCT Model FROM vehicle";
//                $result = $db->query($sql);
                      ?>
                      <select name="payementmethod" class="form-control">
                        <option value="">--Cash Out Type--</option>
                        <option value="stylist">Stylist</option>
                        <option value="management">Management</option>

                      </select>
                    </div> -->
                  <div class="col-sm">

                    <input type="date" class="form-control" name="from" placeholder="Enter From Date"
                      max="<?php echo date('Y-m-d'); ?>"  required="true" >
                  </div>
                  <div class="col-sm">
                    <input type="date" class="form-control" name="to" placeholder="Enter to Date"
                      max="<?php echo date('Y-m-d'); ?>" required="true">


                  </div>
                  <div class="col-sm">
                    <input type="hidden" name="CustomerId " value=">">
                    <button type="submit" class="btn btn-warning">Search</button>
                  </div>
                </div>
              </form>
              <!-- <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>reports/sales_report_details.php.php" class="btn btn-sm btn-outline-secondary">More Filter</a>
              </div> -->

            </ul>
            <div class="clearfix"></div>
          </div>
          <div class="x_content">
            <div class="demo-container" style="height:250px">
              <div class="demo-placeholder">
                <canvas id="myChart1" style="width:95%;height: 90%"></canvas>
              </div>

              <div id="chart_plot_03"></div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <?php
    $where = null;
    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {


      if (!empty($from) && empty($to)) {
        $where .= " Addeddate  = '$from' AND";
      }
      if (empty($from) && !empty($to)) {
        $where .= " Addeddate  = '$to' AND";
      }
      if (!empty($from) && !empty($to)) {
        $where .= " Addeddate  BETWEEN '$from' AND '$to' AND";
      }
      if (empty($from) && empty($to)) {
        $where .= " DATE(Addeddate) = CURDATE() AND";
      }


      //        if (!empty($where)) {
//            $where = substr($where, 0, -3);
//            $where = " WHERE $where";
//        }
    

      if (!empty($where)) {
        $where = substr($where, 0, -3);
        $where = "  $where";
      }


      $where = 10;
      //        extract($_POST);
//        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
      extract($_POST);
      //    $CustomerId = $_GET['CustomerId'];
    
      $sql_spcific_date = "SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleAmount), 0) AS total_sale
            FROM (
                SELECT CURDATE() - INTERVAL n DAY AS date
                FROM (
                    SELECT @row := @row - 1 AS n
                    FROM information_schema.columns, (SELECT @row := 7) r
                    LIMIT 7
                ) dates
            ) date_range
            LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate)
            WHERE date_range.date BETWEEN '$from' AND '$to'  -- Specify your date range here
            GROUP BY date_range.date
            ORDER BY date_range.date DESC;
            ";
      $db = dbConn();
      $results_specific_date = $db->query($sql_spcific_date);
      $i = 1;
      $totalamount = 0;

      $data_labeldiscount = array();
      $data_valuediscount = array();

      while ($row_specific_date = $results_specific_date->fetch_assoc()) {
        $data_labeldiscount[] = $row_specific_date['total_sale'];
        $data_valuediscount[] = $row_specific_date['sale_day'];
      }
      "<br>";
      "'" . implode("','", $data_valuediscount) . "'";
      implode(",", $data_labeldiscount);


      //  table rows generating starts
      // $sql_table_sevendays = "SELECT * FROM `tbl_sales` WHERE SaleDate BETWEEN '$from' and '$to'";
      $sql_table_sevendays = "SELECT *, DATE(SaleDate) AS sale_day, COALESCE(SUM(SaleAmount), 0) AS total_sale
       FROM tbl_sales
       WHERE SaleDate BETWEEN '$from' AND '$to'
       GROUP BY DATE(SaleDate)
       ORDER BY DATE(SaleDate) DESC;
       ";
      $db = dbConn();
      $results_table = $db->query($sql_table_sevendays);
      // table rows generating ends
    }
    ?>

    <!-- filtering code ends -->

    <div class="row">




      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
          <h2>Sales Table Cash Payments <small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
            </ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

           

            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">

                    <!-- <th class="column-title">Invoice Number </th> -->
                    <th class="column-title">Invoice Date </th>
                    <!-- <th class="column-title">Customer Name </th>
                            <th class="column-title">Customer Number </th> -->
                    <th class="column-title">Sale </th>



                  </tr>
                </thead>
                <?php
                if ($where == null) {
                  $sql_table_sevendays = "SELECT *,DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale
  FROM tbl_sales
  WHERE PaymentType = 1 and SaleDate >= CURDATE() - INTERVAL 6 DAY
  GROUP BY DATE(SaleDate)
  ORDER BY DATE(SaleDate) DESC;
  ";
                  $db = dbConn();
                  $results_table = $db->query($sql_table_sevendays);
                }


                ?>
                <tbody>
                  <?php
                  if ($results_table->num_rows > 0) {
                    $i = 1;
                    $totalamount = 0;
                    while ($row_table_sales = $results_table->fetch_assoc()) {
                      ?>
                      <tr class="even pointer">

                        <!-- <td class=" "><?= $row_table_sales['SaleInvoiceNumber'] ?></td> -->
                        <td class=" ">
                          <?= $row_table_sales['SaleDate'] ?>
                        </td>
                        <!-- <td class=" "><?= ucwords($row_table_sales['CustomerName']) ?> </td>
                            <td class=" "><?= $row_table_sales['CustomerName'] ?></td> -->
                        <td class=" ">
                          <?= $row_table_sales['total_sale'] ?>
                        </td>
                        <?php $totalamount += $row_table_sales['total_sale'] ?>
                      </tr>

                    <?php }
                  } ?>

                </tbody>
                <tfoot>
                    <tr>
                      <td colspan=""><strong> Total Amount</strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamount, 2) ?></strong>
                      </td>
                    </tr>
                  </tfoot>
              </table>
            </div>


          </div>
        </div>
      </div>
      <div class="col-md-12 col-sm-12  ">
        <div class="x_panel">
          <div class="x_title">
            <h2>Sales Table Card Payemnts <small></small></h2>
            <ul class="nav navbar-right panel_toolbox">
              <!-- <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <a class="dropdown-item" href="#">Settings 1</a>
                            <a class="dropdown-item" href="#">Settings 2</a>
                          </div>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li> -->
            </ul>
            <div class="clearfix"></div>
          </div>

          <div class="x_content">

            <p>Sales in Table view <code></code></p>

            <div class="table-responsive">
              <table class="table table-striped jambo_table bulk_action">
                <thead>
                  <tr class="headings">

                    <!-- <th class="column-title">Invoice Number </th> -->
                    <th class="column-title">Invoice Date </th>
                    <!-- <th class="column-title">Customer Name </th>
                            <th class="column-title">Customer Number </th> -->
                    <th class="column-title">Sale </th>



                  </tr>
                </thead>
                <?php
                if ($where == null) {
                  $sql_table_sevendays = "SELECT *,DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale
  FROM tbl_sales
  WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY
  GROUP BY DATE(SaleDate)
  ORDER BY DATE(SaleDate) DESC;
  ";
                  $db = dbConn();
                  $results_table = $db->query($sql_table_sevendays);
                }


                ?>
                <tbody>
                  <?php
                  if ($results_table->num_rows > 0) {
                    $i = 1;
                    $totalamount = 0;
                    while ($row_table_sales = $results_table->fetch_assoc()) {
                      ?>
                      <tr class="even pointer">

                        <!-- <td class=" "><?= $row_table_sales['SaleInvoiceNumber'] ?></td> -->
                        <td class=" ">
                          <?= $row_table_sales['SaleDate'] ?>
                        </td>
                        <!-- <td class=" "><?= ucwords($row_table_sales['CustomerName']) ?> </td>
                            <td class=" "><?= $row_table_sales['CustomerName'] ?></td> -->
                        <td class=" ">
                          <?= $row_table_sales['total_sale'] ?>
                        </td>
                        <?php $totalamount += $row_table_sales['total_sale'] ?>
                      </tr>

                    <?php }
                  } ?>

                </tbody>
                <tfoot>
                    <tr>
                      <td colspan=""><strong> Total Amount</strong>
                      </td>
                      <td>
                        <strong><?= number_format(@$totalamount, 2) ?></strong>
                      </td>
                    </tr>
                  </tfoot>
              </table>
            </div>


          </div>
        </div>
      </div>
      <div class="clearfix"></div>




    </div>

    <!-- sales report php sql code start -->
    <?php
    //        SELECT op.productid, imi.productid, tp.ProductID , tp.ProductCategory , imi.price FROM `orderproducts` op INNER JOIN tbl_imie imi on op.productid= imi.productid INNER JOIN tbl_products tp on op.productid=tp.ProductID;
    //$sqldiscount = "SELECT DATE(SaleDate) AS sale_day, SUM(SaleAmount) AS total_sale FROM tbl_sales WHERE SaleDate >= CURDATE() - INTERVAL 6 DAY GROUP BY DATE(SaleDate) ORDER BY DATE(SaleDate) DESC";
    
    if (@$where == null) {
      $sql_sevenday_sales = "SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleAmount), 0) AS total_sale
       FROM (
           SELECT CURDATE() - INTERVAL n DAY AS date
           FROM (
               SELECT @row := @row - 1 AS n
               FROM information_schema.columns, (SELECT @row := 7) r
               LIMIT 7
           ) dates
       ) date_range
       LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate)
       GROUP BY date_range.date
       ORDER BY date_range.date DESC;";
      $db = dbConn();
      $result_sevenday_sales = $db->query($sql_sevenday_sales);

      $data_labeldiscount = array();
      $data_valuediscount = array();

      while ($row_sevenday_sales = $result_sevenday_sales->fetch_assoc()) {
        $data_labeldiscount[] = $row_sevenday_sales['total_sale'];
        $data_valuediscount[] = $row_sevenday_sales['sale_day'];
      }
      echo "<br>";
      "'" . implode("','", $data_valuediscount) . "'";
      implode(",", $data_labeldiscount);

    }

    ?>
    <!-- sales report php sql code end -->

    <?php

    extract($_POST);
    if ($_SERVER['REQUEST_METHOD'] == "POST") {

      $where = 10;
      //        extract($_POST);
//        if ($_SERVER['REQUEST_METHOD'] == "POST" ) {
      extract($_POST);
      //    $CustomerId = $_GET['CustomerId'];
    
       $sql_spcific_date = "SELECT date_range.date AS sale_day, COALESCE(SUM(s.SaleAmount), 0) AS total_sale
            FROM (
                SELECT CURDATE() - INTERVAL n DAY AS date
                FROM (
                    SELECT @row := @row - 1 AS n
                    FROM information_schema.columns, (SELECT @row := 364) r
                    LIMIT 365
                ) dates
            ) date_range
            LEFT JOIN tbl_sales s ON date_range.date = DATE(s.SaleDate)
            WHERE date_range.date BETWEEN '$from' AND '$to'  -- Specify your date range here
            GROUP BY date_range.date
            ORDER BY date_range.date DESC;
            ";
      $db = dbConn();
      $results_specific_date = $db->query($sql_spcific_date);
      $i = 1;
      $totalamount = 0;

      $data_labeldiscount = array();
      $data_valuediscount = array();

      while ($row_specific_date = $results_specific_date->fetch_assoc()) {
        $data_labeldiscount[] = $row_specific_date['total_sale'];
        $data_valuediscount[] = $row_specific_date['sale_day'];
      }
      "<br>";
       "'" . implode("','", $data_valuediscount) . "'";
       implode(",", $data_labeldiscount);



    }
    ?>

    <!-- /page content -->
    <script>
      const ctx = document.getElementById('myChart1');
      new Chart(ctx, {
        type: 'line',
        data: {
          labels: [<?= "'" . implode("','", $data_valuediscount) . "'" ?>],
          datasets: [{
            label: 'Sales',
            data: [<?= implode(",", $data_labeldiscount) ?>],
            borderWidth: 3,
            borderColor: 'rgb(75, 192, 192)',
            fill: false,
            tension: 0.1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });


    </script>

    <script>
      const ctx1 = document.getElementById('myChart3');
      new Chart(ctx1, {
        type: 'line',
        data: {
          labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
          datasets: [{
            label: '# of Votes',
            data: [65, 59, 80, 81, 56, 55, 40],
            borderWidth: 1,
            borderColor: 'rgb(75, 192, 192)',
            fill: false,
            tension: 0.1
          }]
        },
        options: {
          scales: {
            y: {
              beginAtZero: true
            }
          }
        }
      });


    </script>



    <?php include '../footer.php' ?>