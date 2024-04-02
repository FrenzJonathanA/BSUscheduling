<body>

    <?php 

        $pageTitle = "Registration";
        
        include('header.php'); 
    
    ?>


    <div class="registration">
        <div class="container">
            <div class="reg-wrapper">
                <h2>User Registration Form</h2>
                <form method="POST" action="register.php">
                    <label for="first_name">First Name:</label><br>
                    <input type="text" id="first_name" name="first_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your First Name"><br>

                    <label for="last_name">Last Name:</label><br>
                    <input type="text" id="last_name" name="last_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your Last Name"><br>

                    <label for="email">Email:</label><br>
                    <input type="email" id="email" name="email" required placeholder="Enter Your Email"><br>

                    <label for="password">Password:</label><br>
                    <input type="password" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" required placeholder="Password (at least 1 letter, 1 number, 1 special character)"><br>

                    <label for="confirm_pass">Confirm Password:</label><br>
                    <input type="password" id="confirm_pass" name="confirm_pass" required placeholder="Confirm Password"><br>

                    <label for="department">Department:</label><br>
                    <select id="department_ID" name="department_ID" required>
                        <option value="" selected>- Select -</option>
                        <?php
                        // Include database connection file
                        include './database/con_db.php';

                        // Check connection
                        if ($conn->connect_error) {
                            die("Connection failed: " . $conn->connect_error);
                        }

                        // Prepare and execute the query
                        $query = "SELECT department_ID, department_name FROM department";
                        $result = $conn->query($query);

                        // Check if query executed successfully
                        if ($result) {
                            // Fetch data and generate options
                            while ($row = $result->fetch_assoc()) {
                                echo '<option value="' . $row['department_ID'] . '">' . $row['department_name'] . '</option>';
                            }
                            // Free result set
                            $result->free();
                        } else {
                            // Display error message
                            echo "Error: " . $query . "<br>" . $conn->error;
                        }

                        // Close connection
                        // $conn->close();
                        ?>
                    </select><br>


                    
                    <label for="role">Role:</label><br>
                    <select id="role" name="role">
                        <option value="USER">User</option>
                        <option value="STAFF">Staff</option>
                        <option value="ADMIN">Admin</option>
                    </select><br>

                    <label for="contact_number">Contact Number:</label><br>
                    <input type="text" id="contact_number" name="contact_number" pattern="[0-9]{10}" required placeholder="Enter Your valid 10-digit Contact number"><br>

                    <label for="employee_ID">Employee ID:</label><br>
                    <input type="text" id="employee_ID" name="employee_ID"><br>

                    <input type="submit" value="Register">
                </form>
            </div>
        </div>
    </div>
    <div class="container">

    </div>
    <?php 

    include('footer.php'); 

    ?>
    
</body>
</html>
