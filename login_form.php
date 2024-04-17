<!-- <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="scss/style.scss"> 

</head>
<body>
    <div class="background-image"></div>
    <div class="header">
        <div class="container">
            <div class="header-wrapper">
                <div class="univ-head">
                    <div class="logo">
                        <img src="static/image/bsu_logo.png" alt="Logo">
                    </div>
    
                    <div class="site-name">
                        <h1>BATANGAS STATE UNIVERSITY</h1>
                        <h4>The National Engineering University</h4>
                    </div>
                </div>
                <div class="search-bar">
                    <input type="text" placeholder="Search...">
                    <button type="submit">Search</button>
                </div>
            </div>
        </div>
    </div> -->

    <?php 

        $pageTitle = "LogIN";
        
        include('header.php'); 
    
    ?> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div class="log-form">
        <div class="container">
            <div class="log-wrapper">
                <h2>Login</h2>
                <form action="login.php" method="POST">
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password:</label>
                        <input type="password" id="password" name="password" required>
                    </div>
                    <button type="submit">Login</button>
                    <div class="text-center">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
                </form>
                <div class="text-center">
                    <a href="registration.php">Don't have an account? Sign Up</a>
                </div>
                <div class="text-center">
                    <a href="cal-sample.php">View Calendar</a>
                </div>
            </div>     
        </div>
    </div>
    <div class="container2">
        
        
    </div>

    <?php 

    include('footer.php'); 

    ?>


</body>

</html>
