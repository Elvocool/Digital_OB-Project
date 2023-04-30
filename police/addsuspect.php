<?php
include('../config/connection.php');
include('policemenu.php');

$station = $rows['station'];

if(isset($_POST['submit'])){

    $ob_number = $_POST['ob_number'];
    $crime_suspected = $_POST['crime_suspected'];
    $name = $_POST["name"];
    $national_id = $_POST['national_id'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $phone_num = $_POST['phone_num'];
    $gender = $_POST['gender'];
 
    $insert = "INSERT INTO suspects(ob_number, crime_suspected, name, national_id, dob, address, phone_num, gender) VALUES(?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_stmt_init($conn);
    $prepareStmt = mysqli_stmt_prepare($stmt,$insert);
    if ($prepareStmt) {
       mysqli_stmt_bind_param($stmt,"sssissis", $ob_number, $crime_suspected, $name, $national_id, $dob, $address, $phone_num, $gender);
       mysqli_stmt_execute($stmt);
       echo "<script type='text/javascript'>alert('Suspect Added Successfully');
       document.location='viewsuspect.php'</script>";
       }else{
           die("Something went wrong");
       }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Digital OB</title>
   <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<form action="" method="post">
      <div class="details police">
         <div class="recentOrders new">
            <div class="cardHeader">
               <h2>Add Suspect</h2>
               <a href="viewsuspect.php" class="btn">View Suspects</a>
            </div>
            <div class="form-content">
               <div class="form-box">
                  <label for="ob_number">OB Number</label>
                  <select name="ob_number" required onchange="fetchCrimeType()">
                     <option select hidden value="">Select OB Number</option>
                     <?php
                     $case_query = "SELECT * FROM cases WHERE station='$station'";
                     $case_result = mysqli_query($conn, $case_query);

                     while($case_rows = mysqli_fetch_assoc($case_result)){
                        ?>
                        <option value="<?php echo $case_rows['ob_number'] ?>"> <?php echo $case_rows['ob_number'] ?> </option>
                        <?php
                        $ob_number = $case_rows['ob_number'];
                     }
                        ?>
                  </select>
               </div>
               <div class="form-box">
                  <label for="crime_suspected">Crime Suspected of</label>
                  <input type="text" name="crime_suspected" id="crime_suspected" readonly required>
               </div>
               <div class="form-box">
                  <label for="comp_name">Name of Suspect</label>
                  <input type="text" name="name" autocomplete="off" required>
               </div>
               <div class="form-box">
                  <label for="tel">National ID Number</label>
                  <input type="text" name="national_id" autocomplete="off" required>
               </div>
               <div class="form-box">
                  <label for="occupation">Date of Birth</label>
                  <input type="date" name="dob" autocomplete="off" required>
               </div>
               <div class="form-box">
                  <label for="address">Address</label>
                  <input type="text" name="address" autocomplete="off" required>
               </div>
               <div class="form-box">
                  <label for="region">Phone Number</label>
                  <input type="number" name="phone_num" autocomplete="off" required>
               </div>
               <div class="form-box">
                  <label for="gender">Gender</label>
                  <select name="gender" required>
                     <option selected hidden value="">Select Gender</option>
                     <option value="Male">Male</option>
                     <option value="Female">Female</option>
                  </select>
               </div>
            </div>
            <div class="form-btn">
               <button type="submit" name="submit">Save and Continue</button>
            </div>
         </div>
      </div>
   </form>

   <!-- Script to get the crime type in regard to the ob_number selected --> 

   <script>

      function fetchCrimeType() {
         var ob_number = document.getElementsByName("ob_number")[0].value;
         var xhttp = new XMLHttpRequest();
         xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                  document.getElementById("crime_suspected").value = this.responseText;
            }
         };
         xhttp.open("GET", "get_crimetype.php?ob_number=" + ob_number, true);
         xhttp.send();
      }

</script>

</body>
</html>