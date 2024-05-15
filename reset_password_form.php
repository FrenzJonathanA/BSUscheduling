


<?php 

    $pageTitle = "Reset Password";
    
    include('header.php'); 

?>


<link rel="stylesheet" href="scss/style.css"> 

<div class="newpass">
    <div class="container">
        <div class="newpass-wrapper">
            <div class="reset-form">
                <h2>Enter New Password</h2>
                <?php
                    if (isset($error_message)) {
                        echo '<p class="error-message">'. $error_message. '</p>';
                    }
                ?>
                <form action="" method="post">
                    <input type="hidden" name="email" value="<?php echo $_GET['email'];?>">
                    <div class="form-group">
                        <label for="password">New Password:</label>
                        <input type="password" name="password" required placeholder="Enter Your New Password">
                    </div>
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password:</label>
                        <input type="password" name="confirm_password" required placeholder="Confirm Your New Password">
                    </div>
                    <button type="submit">Update Password</button>
                </form>
                <div class="newPass-container">
                    <?php
                        require 'database/con_db.php';


                        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $confirmPass = $_POST['confirm_password'];

                            if ($password === $confirmPass) {
                                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                                $stmt = $conn->prepare("UPDATE user SET password =?, confirm_pass =?, reset_code = NULL WHERE email =?");
                                $stmt->bind_param("sss", $hashedPassword, $hashedPassword, $email);
                                $stmt->execute();

                                echo "Password updated successfully. You can now <a href='login_form.php'>login</a> with your new password.";
                            } else {
                                echo "Passwords do not match.";
                            }
                        }

                        /*if ($_SERVER["REQUEST_METHOD"] == "POST") {
                            $email = $_POST['email'];
                            $password = $_POST['password'];
                            $confirmPass = $_POST['confirm_password'];

                            if ($password === $confirmPass) {
                                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                                $stmt = $conn->prepare("UPDATE user SET password =?, confirm_pass =?, reset_code = NULL WHERE email =?");
                                $stmt->bind_param("sss", $hashedPassword, $hashedPassword, $email);
                                $stmt->execute();

                                if ($stmt->affected_rows > 0) {
                                    echo "<script>Swal.fire({
                                            icon: 'success',
                                            title: 'Password updated successfully',
                                            text: 'Password updated successfully. You can now <a href='login_form.php'>login</a> with your new password.'
                                        })</script>";
                                } else {
                                    echo "<script>Swal.fire({
                                            icon: 'error',
                                            title: 'Error updating password',
                                            text: 'Please try again later.'
                                        })</script>";
                                }
                            } else {
                                echo "<script>Swal.fire({
                                        icon: 'error',
                                        title: 'Passwords do not match',
                                        text: 'Please try again.'
                                    })</script>";
                            }
                        }*/
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>    



<?php 

include('footer.php'); 

?>
</body>
</html>