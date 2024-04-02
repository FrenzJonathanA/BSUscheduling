<?php 

require '../database/con_db.php';

$today = date('Y-m-d');
$year = date('Y');
if(isset($_GET['year'])){
    $year = $_GET['year'];
}

?>


<?php 

    $pageTitle = "Admin Dashboard";

    include('header_admin.php'); 

?>
<div class="admin-badge">
    <div class="container">
        <div class="abadge-wrapper">
            <div class="row1">
                <!-- Pending Registration Requests -->
                <div class="small-box-1">
                    <div class="badge">
                        <div class="icon">
                            <i class="fa-solid fa-users-gear"></i>
                        </div>
                        <div class="inner">
                                <?php
                                    // Query to fetch count of pending registration requests
                                    $query = "SELECT COUNT(*) AS numrows FROM user WHERE user_status = 'pending'";
                                    $result = mysqli_query($conn, $query);

                                    if ($result) {
                                        $row = mysqli_fetch_assoc($result);
                                        echo "<h3>".$row['numrows']."</h3>";
                                    } else {
                                        echo "Error executing query: " . mysqli_error($conn);
                                    }  
                                ?>
                                <p>Pending <br>Registration Requests</p>
                        </div>
                    </div>
                    <a href="./user_categ.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>

                <!-- Pending Schedule Requests -->
                <div class="small-box-1">
                    <div class="badge">
                        <div class="icon">
                            <i class="fa-solid fa-chalkboard-user"></i>
                        </div>
                        <div class="inner"> 
                            <?php
                                // Query to fetch count of pending schedule requests
                                $query = "SELECT COUNT(*) AS numrows FROM event_booking WHERE event_status = 'pending'";
                                $result = mysqli_query($conn, $query);

                                if ($result) {
                                    $row = mysqli_fetch_assoc($result);
                                    echo "<h3>".$row['numrows']."</h3>";
                                } else {
                                    echo "Error executing query: " . mysqli_error($conn);
                                }
                            ?>
                            <p>Pending <br>Schedule Requests</p>
                        </div>
                    </div>
                    <a href="./event_categ.php" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 

    ?>
</body> 

</html>
