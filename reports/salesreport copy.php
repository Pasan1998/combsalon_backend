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
    <div class="page-title">
      <div class="title_left">
        <!-- <h3>Plain Page</h3> -->
      </div>
    </div>
  </div>
  <!-- <div class="clearfix"></div> -->

  <div class="row">
    <div class="col-md-12 col-sm-12  ">
      <div class="x_panel">
        <div class="x_title">
          <h2>Stylist's List</h2>
          <ul class="nav navbar-right panel_toolbox">
            <div class="btn-toolbar mb-2 mb-md-0">
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>employers/addservice.php" class="btn btn-sm btn-outline-secondary"> Cost</a>
              </div>
              <div class="btn-group ml-1">
                <a href="<?= SYSTEM_PATH ?>employers/addservice.php" class="btn btn-sm btn-outline-secondary">
                  Profit</a>
              </div>
              <div class="btn-group ml-1 ">
                <a href="<?= SYSTEM_PATH ?>employers/addservice.php" class="btn btn-sm btn-outline-secondary"> P & L</a>
              </div>
          </ul>
          <div class="clearfix">
            
          </div>
        </div>
        <div class="x_content">



          <div class="row">
            <div class="col-md-12 col-sm-12 ">
              <div class="dashboard_graph x_panel">
                <div class="x_title">
                  <div class="col-md-6">
                    <h3>This Week Sales <small>Graph title sub-title</small></h3>
                  </div>
                  <div class="col-md-6">
                    <div id="reportrange" class="pull-right"
                      style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                      <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                      <span>December 30, 2014 - January 28, 2023</span> <b class="caret"></b>
                    </div>
                  </div>
                </div>
                <div class="x_content">
                  <div class="demo-container" style="height:250px">
                    <div class="demo-placeholder">
                      <canvas id="myChart2" style="width:100%;height: 100%"></canvas>
                    </div>

                    <div id="chart_plot_03"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>


        </div>
      </div>
    </div>
  </div>
</div>

<!-- /page content -->
<script>
  const ctx = document.getElementById('myChart2');

  //   new Chart(ctx, {
  //     type: 'bar',
  //   data: {
  //     labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
  //   datasets: [{
  //     label: '# of Votes',
  //   data: [12, 19, 3, 5, 2, 3],
  //   borderWidth: 1
  //     }]
  //   },
  //   options: {
  //     scales: {
  //     y: {
  //     beginAtZero: true
  //       }
  //     }
  //   }
  // });

  new Chart(ctx, {
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