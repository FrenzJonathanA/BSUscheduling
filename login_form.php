    <?php 

        $pageTitle = "LogIN";
        
        include('header.php'); 
    
    ?> 

    <link rel="stylesheet" href="scss/style.css"> 
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
                        <input type="password" id="password" name="password" required><br>
                        <input type="checkbox" id="showPassword"> Show Password<br>
                    </div>

                    <button type="submit">Login</button>
                    
                </form>
                <!-- <p style="text-align: center;">---------------- or ---------------</p>
                <a href="cal-sample.php" style="text-decoration: none;"><button>Face Login</button></a> -->

                <?php
                    // Check if error message is set in session
                    if (isset($_SESSION['error_message'])) {
                        echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                        // Unset the error message to prevent displaying it again on subsequent page loads
                        unset($_SESSION['error_message']);
                    }
                ?>
                <div class="text-center">
                        <a href="forgot_password.php">Forgot Password?</a>
                    </div>
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

<script>
    document.getElementById("showPassword").addEventListener("change", function() {
        console.log("Checkbox clicked");
        var passwordInput = document.getElementById("password");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    });
</script>

</body>

</html>
