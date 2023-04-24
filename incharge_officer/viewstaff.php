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
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <div class="details staff">
        <div class="recentOrders">
            <div class="cardHeader">
                <h2>Staff List</h2>
                <a href="addstaff.php" class="btn">Add Staff</a>
            </div>
            <?php include('../controller/message.php'); ?>
            <form action="../controller/action.php" method="post">
                <table class="staff_table">
                    <thead>
                        <tr><td>S/N</td>
                            <td>Staff ID</td>
                            <td>Full Name</td>
                            <td>Rank</td>
                            <td>Station</td>
                            <td>Status</td>
                            <td>Gender</td>
                            <td>Action</td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        // serial number variable
                        $sn=0;

                        $query = "SELECT * FROM users where station='$station'";
                        $result = mysqli_query($conn, $query);

                        while($rows = mysqli_fetch_assoc($result)){
                            $sn++;
                            ?>
                            <tr>
                                <td><?php echo $sn; ?></td>
                                <td><?php echo $rows['staff_id']; ?></td>
                                <td><?php echo $rows['name']; ?></td>
                                <td><?php echo $rows['rank']; ?></td>
                                <td><?php echo $rows['station']; ?></td>
                                <td><?php echo $rows['status']; ?></td>
                                <td><?php echo $rows['gender']; ?></td>
                                <td>
                                    <a class="edit_btn" title="Edit Staff" href="editstaff.php?staff_id=<?php echo $rows['staff_id']; ?>"><i class="bx bxs-edit"></i></a>
                                    <button type="submit" title="Delete Staff" name="delete_staff" class="del_btn" value="<?php echo $rows['staff_id']; ?>"><i class="bx bxs-trash-alt"></i></button>
                                </td>
                            </tr>
                            <?php
                        }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>