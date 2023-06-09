<?php

include('../config/connection.php');
include('inchargemenu.php');

$station = $rows['station'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Digital OB</title>
   <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
   <form action="">
      <div class="details dashboard">
         <div class="recentOrders dashboard">
            <div class="cardHeader">
               <h2>Dashboard</h2>
               <h4><?php echo date('Y-m-d H:i:s'); ?></h4>
            </div>
            <div class="main-cards">
               <div class="card">
                  <div class="card-inner">
                     <h3>Total Staff in <?php echo $rows['station']; ?></h3>
                  </div>
                  <?php
                  $dash_staff_query = "SELECT * FROM users WHERE station='$station'";
                  $dash_staff_result = mysqli_query($conn, $dash_staff_query);

                  if($dash_staff_total = mysqli_num_rows($dash_staff_result)){
                     echo '<h1> '.$dash_staff_total.' </h1>';
                  }
                  else{
                     echo '<h2>No Data</h2>';
                  }
                  ?>
                  <a href="viewstaff.php" style="text-decoration: none; color: black; background: pink;">
                  <h4>View Details</h4>
                  </a>
               </div>

               <div class="card">
                  <div class="card-inner">
                     <h3>Total Complaints reported</h3>
                  </div>
                  <?php
                  $dash_comp_query = "SELECT * FROM cases WHERE station='$station'";
                  $dash_comp_result = mysqli_query($conn, $dash_comp_query);
                  
                  if($dash_comp_total = mysqli_num_rows($dash_comp_result)){
                     echo '<h1> '.$dash_comp_total.' </h1>';
                  }
                  else{
                     echo '<h2>No Data</h2>';
                  }
                  ?>
                  <a href="viewcase.php" style="text-decoration: none; color: black; background: pink;">
                  <h4>View Details</h4>
                  </a>
               </div>

               <div class="card">
                  <div class="card-inner">
                     <h3>Cases Ongoing</h3>
                  </div>
                  <?php
                  $dash_ongoing_query = "SELECT * FROM cases WHERE station='$station' && status='Ongoing'";
                  $dash_ongoing_result = mysqli_query($conn, $dash_ongoing_query);
                  
                  if($dash_ongoing_total = mysqli_num_rows($dash_ongoing_result)){
                     echo '<h1> '.$dash_ongoing_total.' </h1>';
                  }
                  else{
                     echo '<h2>No Data</h2>';
                  }
                  ?>
               </div>

               <div class="card">
                  <div class="card-inner">
                     <h3>Cases Closed</h3>
                  </div>
                  <?php
                  $dash_complete_query = "SELECT * FROM cases WHERE station='$station' && status='Closed'";
                  $dash_complete_result = mysqli_query($conn, $dash_complete_query);
                  
                  if($dash_complete_total = mysqli_num_rows($dash_complete_result)){
                     echo '<h1> '.$dash_complete_total.' </h1>';
                  }
                  else{
                     echo '<h2>No Data</h2>';
                  }
                  ?>
               </div>
            </div>
            <div class="charts">
               <div class="charts-card">
                  <h2 class="charts-title">Crime Analytics Reports</h2>
                  <div id="piechart_3d" style="width: 430px;height: 350px;"></div>
               </div>
               <script type="text/javascript">
                  google.charts.load('current', {'packages':['corechart']});
                  google.charts.setOnLoadCallback(pieChart);

                  function pieChart(){

                     var data = google.visualization.arrayToDataTable([
                        ['crime_type', 'count'],
                        <?php
                           $chart_sql = "SELECT crime_type, COUNT(*) as count FROM cases WHERE station='$station' GROUP BY crime_type"; 
                           $chart_result = mysqli_query($conn, $chart_sql);
                           
                           while($chart_row = mysqli_fetch_assoc($chart_result)){
                           echo"['".$chart_row['crime_type']."',".$chart_row['count']."],";
                           }
                        ?>
                     ]);

                     var options = {
                        title: 'Crime Reports Percentage',
                        is3D: true,
                     };

                     var chart = new google.visualization.PieChart(document.getElementById('piechart_3d'));
                     chart.draw(data, options);
                  }
               </script>

               <div class="charts-card">
                  <h2 class="charts-title">Case Analytics Reports</h2>
                  <div id="columnchart" style="width: 430px;height: 350px;"></div>
               </div>
               <script type="text/javascript">
                  google.charts.load('current', {'packages':['corechart']});
                  google.charts.setOnLoadCallback(barChart);

                  function barChart(){

                     var data = google.visualization.arrayToDataTable([
                        ['crime_type', 'count'],
                        <?php
                           $chart_sql = "SELECT crime_type, COUNT(*) as count FROM cases WHERE station='$station' GROUP BY crime_type"; 
                           $chart_result = mysqli_query($conn, $chart_sql);
                           
                           while($chart_row = mysqli_fetch_assoc($chart_result)){
                           echo"['".$chart_row['crime_type']."',".$chart_row['count']."],";
                           }
                        ?>
                     ]);

                     var options = {
                        title: 'Crime Reports Count'
                     };

                     var chart = new google.visualization.ColumnChart(document.getElementById('columnchart'));
                     chart.draw(data, options);
                  }
               </script>

            </div>
         </div>
      </div>
   </form>
</body>
</html>