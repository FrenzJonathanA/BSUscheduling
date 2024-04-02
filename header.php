<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="scss/style.scss"> 
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
                    </form>
                 </div>
            </div>
        </div>
    </div>
