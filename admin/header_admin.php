<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image" href="../static/image/bsu_logo.png" />
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="../scss/style.scss"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script src="../script/alert.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display+swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/472320e0e2.js" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

    <style>
        @media only screen and (max-width: 1024px) {
            .header {
                padding: 5px 20px;
                .container {
                .header-wrapper {
                    .univ-head {
                    margin-right: 230px;
                    }
                }
                }
            }
            /* .navbar{
                .container{
                    .nav-wrapper{
                        align-items: unset;
                        height: 35px;
                    }
                } 
            }*/
        }
        @media only screen and (max-width: 768px) {
            .header {
                padding: 5px 20px;
                .container {
                    .header-wrapper {
                        .univ-head {
                        margin-right: 100px;
                        }
                    }
                }
            }
            /* .navbar{
                .container{
                    .nav-wrapper{
                        align-items: unset;
                        height: 75px;
                    }
                }
            } */
        }


    </style>
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
                        <button type="submit" class="hidden"><i class="fa-solid fa-magnifying-glass"></i></button>
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
                                <!-- <li><a href="">Users Data Logging</a></li> -->
                            </ul>
                        </li>
                        <li><a href="./facility_categ.php">Manage Facilities</a></li>
                        <li></li>
                        <li><a href="./device_categ.php">Manage Devices</a></li>
                        <li><a href="./depart_categ.php">Manage Department</a></li>
                        <li></li>
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