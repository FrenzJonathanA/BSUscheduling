<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Content Security Policy -->
    <!-- <meta http-equiv="Content-Security-Policy" content="default-src 'self' data: gap: https://ssl.gstatic.com 'unsafe-eval'; style-src 'self' 'unsafe-inline'; media-src *">  -->
    <!-- Other meta tags, title, and external resources -->
    <link rel="icon" type="image" href="static/image/bsu_logo.png" />
    <title><?php echo $pageTitle; ?></title>
    <script src="https://kit.fontawesome.com/472320e0e2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="scss/style.scss"> 
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.10/dist/sweetalert2.all.min.js"></script>
    <script type="text/javascript" src="script/webcam.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="alert.js"></script>
    <script src="script/script.js" defer></script>
    
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
                    <form action="search.php" method="GET"> <!-- Change action to the PHP script handling search -->
                        <input type="text" name="event_code" placeholder="Search by Event Code...">
                        <button type="submit">Search</button>
                        <button type="submit" class="hidden"><i class="fa-solid fa-magnifying-glass"></i></button>
                    </form>
                 </div>
                 <div class="login-logout">
                    <?php include('session_handler.php'); ?>
                </div>
            </div>
        </div>
    </div>
