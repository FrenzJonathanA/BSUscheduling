<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../scss/style.scss"> 
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <script src="https://kit.fontawesome.com/472320e0e2.js" crossorigin="anonymous"></script>
    <!-- Include the jQuery library -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <!-- Include SweetAlert2 CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11">
    <!-- Include SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>
    <div class="background-image"></div>
    <div class="header">
        <div class="container">
            <div class="header-wrapper">
                <div class="univ-head">
                    <div class="logo">
                        <img src="../static/image/bsu_logo.png" alt="Logo">
                    </div>
    
                    <div class="site-name">
                        <h1>BATANGAS STATE UNIVERSITY</h1>
                        <h4>The National Engineering University</h4>
                    </div>
                </div>
                <div class="search-bar">
                    <form action="../search.php" method="GET"> <!-- Change action to the PHP script handling search -->
                        <input type="text" name="event_code" placeholder="Search by Event Code...">
                        <button type="submit">Search</button>
                    </form>
                 </div>
            </div>
        </div>
    </div>
    <div class="navbar">
        <div class="container">
            <div class="nav-wrapper">
                <nav>
                    <ul id="MenuItems">
                        <li><a href="./admin_dash.php">Dashboard</a></li>
                        <li><a href="./event_categ.php">Manage Schedules</a></li>
                        <li><a href="./user_categ.php">Manage Users</a>
                            <ul class="submenu">
                                <!-- <li><a href="">Users Accounts</a></li> -->
                                <li><a href="">Users Data Logging</a></li>
                            </ul>
                        </li>
                        <li><a href="./facility_categ.php">Manage Facilities</a></li>
                        <li><a href="./device_categ.php">Manage Devices</a></li>
                        <li><a href="./depart_categ.php">Manage Department</a></li>
                    </ul>
                </nav>
            </div>
        </div> 
    </div>



        <!-- js for toggle menu -->
    <script>
        var MenuItems = document.getElementById("MenuItems");
        
        MenuItems.style.maxHeight = "0px";

        function menutoggle() {
            if (MenuItems.style.maxHeight =="0px")
            {
                MenuItems.style.maxHeight = "300px";
            }
            else{
                MenuItems.style.maxHeight = "0px";
            }
        }
    </script>