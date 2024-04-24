
<?php 

    $pageTitle = "Verify Email";
    
    include('header.php'); 

?>

<div class="verifyReg">
    <div class="container">
        <div class="verifyReg-wrapper">
            <h2>Enter Verification Code</h2>
            <div class="verifyReg-form">
                <label for="verification_code">Verification Code:</label>
                <form action="verify_regCode.php" method="post">
                    <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                    <input type="text" name="verification_code" id="verification_code" required>
                    <button type="submit">Verify</button>
                </form>
            </div>    
        </div>
    </div>
</div>


<?php 

include('footer.php'); 

?>

</body>
</html>