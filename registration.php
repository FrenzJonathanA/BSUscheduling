
<?php 

    $pageTitle = "Registration";
    
    include('header.php');

?>
        <link rel="stylesheet" href="scss/style.css"> 
        <style>
            /* Modal styles */
            .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
            overflow-y: hidden;
            
            }

            .modal-content {
            background-color: #fefefe;
            display: block;
            margin: 10% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 30%; /* Could be more or less, depending on screen size */
            button{
                display: flex;
                margin: 0 auto;
                margin-top: 30px;
                padding: 8px 12px;
                font-size: 14px;
                font-weight: bold;
                background-color: #555; /* Change button color */
                color: #fff; /* Change text color */
                border: none;
                border-radius: 5px;
                cursor: pointer;
                

            }

            
            }
            button:hover{
                    background-color: #007BFF;
                }

                input[type="text"] {
                    padding: 8px;
                    border: 1px solid #ccc;
                    border-radius: 5px;
                    margin-right: 10px;
                }
            .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            }

            .close:hover,
            .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
            }

            #preview-section{
                margin: auto 50px;
                p{
                    strong{
                        margin-right: 20px;
                    }
                }
            }

        </style>



        <div class="registration">
                <div class="container">
                    <div class="reg-wrapper">
                        <h2>User Registration Form</h2>
                        <?php
                            // Check if error message is set in session
                            if (isset($_SESSION['error_message'])) {
                                echo '<div class="error-message">' . $_SESSION['error_message'] . '</div>';
                                // Unset the error message to prevent displaying it again on subsequent page loads
                                unset($_SESSION['error_message']);
                            }
                        ?>
                        <form id="registrationForm" method="POST" action="register.php">

                            <style>
                                #my_camera{
                                width: 320px;
                                height: 240px;
                                border: 1px solid black;
                                text-align: center;
                                margin-bottom: 10px
                                }
                                .profiler{
                                    display: flex;
                                    flex-direction: column;
                                    align-items: center;
                                    justify-content: center;
                                    margin-top: 30px;
                                    margin-bottom: 30px;
                                    border-bottom: 1px solid black
                                }
                                input[type="button"] {
                                    margin-bottom: 20px;
                                }
                            </style>
                            
                            <div class="profiler">
                                <div id="my_camera"></div>
                                <div id="results" ></div>
                                <input type=button value="Take Snapshot" onClick="take_snapshot()">  
                            </div>

                            <script language="JavaScript">

                                Webcam.set({
                                width: 320,
                                height: 240,
                                image_format: 'jpeg',
                                jpeg_quality: 90
                                });
                                Webcam.attach( '#my_camera' );

                                // preload shutter audio clip
                                var shutter = new Audio();
                                shutter.autoplay = true;
                                shutter.src = navigator.userAgent.match(/Firefox/) ? 'shutter.ogg' : 'shutter.mp3';

                                function take_snapshot() {

                                    // Hide the webcam container
                                    document.getElementById('my_camera').style.display = 'none';
                                    
                                    // Display the results container
                                    document.getElementById('results').style.display = 'block';
                                    
                                    // play sound effect
                                    shutter.play();
                                    
                                    // take snapshot and get image data
                                    Webcam.snap( function(data_uri) {
                                    
                                        Webcam.upload( data_uri, 'saveimage.php', function(code, text,Name) {
                                            document.getElementById('results').innerHTML = 
                                            '' + '<img src="'+data_uri+'"/>';
                                        } );
                                    
                                    
                                    } );
                                }

                            </script>


                            <label for="first_name">First Name:</label><br>
                            <input type="text" id="first_name" name="first_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your First Name"><br>
                            <span id="first_name_error"></span><br>

                            <label for="last_name">Last Name:</label><br>
                            <input type="text" id="last_name" name="last_name" pattern="[A-Za-z\s]+" required placeholder="Enter Your Last Name"><br>
                            <span id="last_name_error"></span><br>

                            <label for="email">Email:</label><br>
                            <!-- <input type="email" id="email" name="email" required placeholder="Enter Your Email"><br> -->
                            <input type="email" id="email" name="email" required placeholder="Enter Your Email">
                            <span id="email_error"></span><br>

                            <script>
                                // Function to check if email already exists
                                function checkEmail() {
                                    var email = $('#email').val();

                                    $.ajax({
                                        url: 'check_email.php',
                                        type: 'POST',
                                        data: { email: email },
                                        success: function(response) {
                                            if (response === 'exists') {
                                                $('#email_error').text('Email address is already in use.');
                                                scrollToError($('#email')); 
                                                $('#finalSubmitButton').prop('disabled', true); // Disable registration button
                                            } else {
                                                $('#email_error').text('');
                                                $('#finalSubmitButton').prop('disabled', false); // Enable registration button
                                            }
                                        },
                                        error: function() {
                                            $('#email_error').text('Error checking email.');
                                        }
                                    });
                                }

                                $(document).ready(function() {
                                    // Add event listener to email input focus
                                    $('#email').focus(function() {
                                        checkEmail();
                                        $('#email_error').show();
                                    });
                                    // Add event listener to email input change
                                    $('#email').change(function() {
                                        checkEmail();
                                    });
                                });
                            </script>

                                
                            <label for="password">Password:</label><br>
                            <input type="password" id="password" name="password" pattern="^(?=.*[A-Za-z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,}$" required placeholder="Password (at least 1 letter, 1 number, 1 special character)"><br>
                            <input type="checkbox" id="showPassword"> Show Password<br>
                            <span id="password_error"></span><br>

                            <label for="confirm_pass">Confirm Password:</label><br>
                            <input type="password" id="confirm_pass" name="confirm_pass" required placeholder="Confirm Password"><br>
                            <input type="checkbox" id="showConPassword"> Show Password<br>
                            <span id="confirm_pass_error"></span><br>

                            <script>
                                // JavaScript to toggle password visibility
                                document.getElementById("showPassword").addEventListener("change", function() {
                                    var passwordInput = document.getElementById("password");
                                    if (this.checked) {
                                        passwordInput.type = "text";
                                    } else {
                                        passwordInput.type = "password";
                                    }
                                });
                                document.getElementById("showConPassword").addEventListener("change", function() {
                                    var confirmPassInput = document.getElementById("confirm_pass");
                                    if (this.checked) {
                                        confirmPassInput.type = "text";
                                    } else {
                                        confirmPassInput.type = "password";
                                    }
                                });
                            </script>

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
                            <span id="department_error"></span><br>

                            <label for="role">Role:</label><br>
                            <select id="role" name="role">
                                <option value="USER">User</option>
                                <?php

                                include './database/con_db.php';        
                                
                                // Check the count of active admin and staff accounts
                                $sql = "SELECT COUNT(*) AS count FROM user WHERE role = 'ADMIN' AND user_status = 'Active'";
                                $result = $conn->query($sql);
                                $admin_count = ($result) ? $result->fetch_assoc()['count'] : 0;

                                $sql = "SELECT COUNT(*) AS count FROM user WHERE role = 'STAFF' AND user_status = 'Active'";
                                $result = $conn->query($sql);
                                $staff_count = ($result) ? $result->fetch_assoc()['count'] : 0;

                                // If the maximum count has not been reached, show the options
                                if ($admin_count < 1) {
                                    echo '<option value="ADMIN">Admin</option>';
                                }
                                if ($staff_count < 2) {
                                    echo '<option value="STAFF">Staff</option>';
                                }
                                ?>
                            </select><br>
                            <span id="role_error"></span><br>

                            <label for="contact_number">Contact Number:</label><br>
                            <input type="text" id="contact_number" name="contact_number" pattern="[0-9]{10}" required placeholder="Enter Your valid 10-digit Contact number"><br>
                            <span id="contact_number_error"></span><br>

                            <label for="employee_ID">Employee ID:</label><br>
                            <input type="text" id="employee_ID" name="employee_ID"><br>
                            <span id="employee_ID_error"></span><br>

                            <!-- <h3>Preview:</h3>
                            <div id="preview-section"> -->
                                <!-- Preview details will be displayed here -->
                            <!-- </div> -->


                            <input type="submit" id="finalSubmitButton" value="Register">
                            
                        </form>
                        
                        <!-- Modal popup for preview details -->
                        <div id="previewModal" class="modal">
                            <div class="modal-content">
                                <span class="close">&times;</span>
                                <h2>Review Your Details</h2>
                                <div id="preview-section">
                                <!-- Preview details will be displayed here -->
                                </div>
                                <button id="confirmSubmitButton">Confirm Submission</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="container">

            </div>
            <?php 

            include('footer.php'); 

            ?>
            


        <script>
            // Function to update preview section
            function updatePreview() {
                // Get form input values
                var firstName = document.getElementById('first_name').value;
                var lastName = document.getElementById('last_name').value;
                var email = document.getElementById('email').value;
                var password = document.getElementById('password').value;
                var confirmPass = document.getElementById('confirm_pass').value;
                var department = document.getElementById('department_ID').value;
                var role = document.getElementById('role').value;
                var contactNumber = document.getElementById('contact_number').value;
                var employeeID = document.getElementById('employee_ID').value;

                // Update preview section with input values
                var previewSection = document.getElementById('preview-section');
                previewSection.innerHTML = `
                    <p><strong>First Name:</strong> ${firstName}</p>
                    <p><strong>Last Name:</strong> ${lastName}</p>
                    <p><strong>Email:</strong> ${email}</p>
                    <p><strong>Password:</strong> ${password}</p>
                    <p><strong>Confirm Password:</strong> ${confirmPass}</p>
                    <p><strong>Department:</strong> ${department}</p>
                    <p><strong>Role:</strong> ${role}</p>
                    <p><strong>Contact Number:</strong> ${contactNumber}</p>
                    <p><strong>Employee ID:</strong> ${employeeID}</p>
                `;
            }

            // Set custom validity message for first name input
            var firstNameError = document.getElementById('first_name_error');
            document.getElementById('first_name').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('First name is required.');
                    firstNameError.textContent = 'First name is required.';
                } else {
                    this.setCustomValidity('');
                    firstNameError.textContent = '';
                }
            });

            // Set custom validity message for last name input
            var lastNameError = document.getElementById('last_name_error');
            document.getElementById('last_name').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('Last name is required.');
                    lastNameError.textContent = 'Last name is required.';
                } else {
                    this.setCustomValidity('');
                    lastNameError.textContent = '';
                }
            });

            // Set custom validity message for email input
            // var emailInput = document.getElementById('email');
            // var emailError = document.getElementById('email_error'); // Use the same span id as for other email error messages

            // emailInput.addEventListener('input', function() {
            //     if (emailInput.validity.valueMissing) {
            //         emailError.textContent = 'Email is required.';
            //     } else if (emailInput.validity.patternMismatch) {
            //         emailError.textContent = 'Email must be a valid email address.';
            //     } else {
            //         // Check if email is already in use
            //         var xhr = new XMLHttpRequest();
            //         xhr.open('POST', 'register.php', true);
            //         xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            //         xhr.onload = function() {
            //             if (xhr.status === 200) {
            //                 if (xhr.responseText === 'Email address is already in use.') {
            //                     emailInput.setCustomValidity('Email address is already in use.'); // Set custom validity message
            //                     emailError.textContent = 'Email address is already in use.'; // Display error message in the span
            //                     document.getElementById('finalSubmitButton').disabled = true; // Disable submit button
            //                 } else {
            //                     emailInput.setCustomValidity(''); // Clear custom validity message
            //                     emailError.textContent = ''; // Clear error message in the span
            //                     document.getElementById('finalSubmitButton').disabled = false; // Enable submit button
            //                 }
            //             } else {
            //                 emailError.textContent = 'Error checking email.';
            //             }
            //         };
            //         xhr.send('email=' + emailInput.value);
            //     }
            // });



            // Set custom validity message for email input
            var emailError = document.getElementById('email_error');
            document.getElementById('email').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('Email is required.');
                    emailError.textContent = 'Email is required.';
                } else {
                    this.setCustomValidity('');
                    emailError.textContent = '';
                }
            });

            // Set custom validity message for password input
            var passwordError = document.getElementById('password_error');
            document.getElementById('password').addEventListener('input', function() {
                if (this.value.length < 8) {
                    this.setCustomValidity('Password must be at least 8 characters long.');
                    passwordError.textContent = 'Password must be at least 8 characters long.';
                } else {
                    this.setCustomValidity('');
                    passwordError.textContent = '';
                }
            });

            // Set custom validity message for confirm password input
            var confirmPassError = document.getElementById('confirm_pass_error');
            document.getElementById('confirm_pass').addEventListener('input', function() {
                var password = document.getElementById('password').value;
                if (this.value !== password) {
                    this.setCustomValidity('Passwords do not match.');
                    confirmPassError.textContent = 'Passwords do not match.';
                } else {
                    this.setCustomValidity('');
                    confirmPassError.textContent = '';
                }
            });

            // Set custom validity message for role input
            var roleError = document.getElementById('role_error');
            document.getElementById('role').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('Role is required.');
                    roleError.textContent = 'Role is required.';
                } else {
                    this.setCustomValidity('');
                    roleError.textContent = '';
                }
            });

            // Set custom validity message for contact number input
            var contactNumberError = document.getElementById('contact_number_error');
            document.getElementById('contact_number').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('Contact number is required.');
                    contactNumberError.textContent = 'Contact number is required.';
                } else {
                    this.setCustomValidity('');
                    contactNumberError.textContent = '';
                }
            });

            // Set custom validity message for employee ID input
            var employeeIDError = document.getElementById('employee_ID_error');
            document.getElementById('employee_ID').addEventListener('input', function() {
                if (this.value === '') {
                    this.setCustomValidity('Employee ID is required.');
                    employeeIDError.textContent = 'Employee ID is required.';
                } else {
                    this.setCustomValidity('');
                    employeeIDError.textContent = '';
                }
            });

            // Update preview on input change
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', function() {
                    if (input.type === 'file') {
                        // Show uploaded image preview
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                document.getElementById('preview_image').src = e.target.result;
                            }
                            reader.readAsDataURL(input.files[0]);
                        } else {
                            document.getElementById('preview_image').src = '';
                        }
                    } else {
                        // Update text preview
                        document.getElementById('preview_text').innerHTML = createPreviewText(
                            document.getElementById('first_name').value,
                            document.getElementById('last_name').value,
                            document.getElementById('email').value,
                            document.getElementById('role').value,
                            document.getElementById('contact_number').value,
                            document.getElementById('employee_ID').value
                        );
                    }
                });
            });

            // Form submission
            document.getElementById('register_form').addEventListener('submit', function(event) {
                if (!this.checkValidity()) {
                    event.preventDefault();
                    this.reportValidity();
                } else {
                    // Clear previous preview
                    document.getElementById('preview_text').innerHTML = '';
                    document.getElementById('preview_image').src = '';

                    // Display success message
                    document.getElementById('success_message').textContent = 'Registration successful!';
                    document.getElementById('success_message').style.display = 'block';

                    // Hide form
                    document.getElementById('register_form').style.display = 'none';
                }
            });

            // Reset form and display form again
            document.getElementById('reset_button').addEventListener('click', function() {
                // Reset form
                document.getElementById('register_form').reset();

                // Reset validation
                document.getElementById('register_form').checkValidity();

                // Clear previous preview
                document.getElementById('preview_text').innerHTML = '';
                document.getElementById('preview_image').src = '';

                // Hide success message
                document.getElementById('success_message').style.display = 'none';

                // Display form
                document.getElementById('register_form').style.display = 'block';
            });

            // Function to disable register button if form is invalid
            function disableButton() {
                var form = document.getElementById('registrationForm');
                var registerButton = document.getElementById('finalSubmitButton');
                if (form.checkValidity()) {
                    registerButton.removeAttribute('disabled');
                } else {
                    registerButton.setAttribute('disabled', 'disabled');
                }
            }

            // Add event listeners to form inputs
            document.querySelectorAll('input, select').forEach(input => {
                input.addEventListener('input', updatePreview);
                input.addEventListener('input', disableButton);
            });

            // Add event listener to form submit button
            document.getElementById('registrationForm').addEventListener('submit', function(event) {
                event.preventDefault();
                if (this.checkValidity()) {
                    // Form is valid, submit the form
                    this.submit();
                } else {
                    // Form is invalid, show error messages
                    event.stopPropagation();
                    this.reportValidity();
                }
            });






            // Function to scroll to the first input field with an error
            function scrollToError() {
                var errorInputs = document.querySelectorAll('input:invalid, select:invalid');
                if (errorInputs.length > 0) {
                    var firstErrorInput = errorInputs[0];
                    firstErrorInput.scrollIntoView({ behavior: 'smooth', block: 'center' });
                    firstErrorInput.focus();
                }
            }

            $(document).ready(function() {
                // Add event listener to registration button click
                $('#finalSubmitButton').click(function(event) {
                    // Check if any input field is invalid
                    var invalidInputs = document.querySelectorAll('input:invalid, select:invalid');
                    if (invalidInputs.length > 0) {
                        // Prevent default action (form submission)
                        event.preventDefault();
                        // Scroll to the first input field with an error
                        scrollToError();
                    }
                });
            });

        

        
        </script>

        </body>
        </html>
