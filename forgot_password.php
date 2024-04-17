<?php 

    $pageTitle = "Forgot Password";
    
    include('header.php'); 

?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<div class="forgetPass-form">
    <div class="container">
        <div class="forgetPass-wrapper">
            <h2>Forgot Password</h2>
            <form method="post" action="send_reset_code.php">
                <label for="email">Enter Email Address:</label>    
                <div class="form-group">
                    <input type="email" name="email" required>
                    <button type="submit">Send Code</button>
                </div>
            </form>
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