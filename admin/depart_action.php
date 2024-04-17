<?php
require __DIR__ . '/../database/con_db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the action from the form data
    $action = $_POST['action'];

    // Perform different actions based on the value of $action
    if ($action == 'add') {
        if (isset($_POST['department_name'], $_POST['department_code'])) {
            $department_name = $_POST['department_name'];
            $department_code = $_POST['department_code'];

            // Check if the department code already exists
            $check_query = "SELECT department_code FROM department WHERE department_code = ?";
            $check_stmt = $conn->prepare($check_query);
            $check_stmt->bind_param("s", $department_code);
            $check_stmt->execute();
            $check_stmt->store_result();

            if ($check_stmt->num_rows > 0) {
                // Department code already exists, redirect back with error message
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Department code already exists.'
                        }).then(() => {
                            window.location.href = './depart_categ.php';
                        });
                      </script>";
                exit();
            } else {
                // Department code is unique, proceed with insertion
                $sql = "INSERT INTO department (department_name, department_code) VALUES (?, ?)";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("ss", $department_name, $department_code);

                if ($stmt->execute()) {
                    // Insertion successful
                    echo "<script>
                            Swal.fire({
                                icon: 'success',
                                title: 'Success',
                                text: 'Department added successfully.'
                            }).then(() => {
                                window.location.href = './depart_categ.php';
                            });
                          </script>";
                    exit();
                } else {
                    // Error occurred during insertion
                    echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Error occurred during insertion: " . $stmt->error . "'
                            }).then(() => {
                                window.location.href = './depart_categ.php';
                            });
                          </script>";
                    exit();
                }

                $stmt->close();
            }

            $check_stmt->close();
        }
    } elseif ($action == 'update') {
        // Check if the form was submitted
        if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['department_ID'], $_POST['department_name'], $_POST['department_code'])) {
            // Retrieve form data
            $department_id = $_POST['department_ID'];
            $department_name = $_POST['department_name'];
            $department_code = $_POST['department_code'];

            // Prepare and execute the SQL UPDATE query
            $sql = "UPDATE department SET department_name = ?, department_code = ? WHERE department_id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $department_name, $department_code, $department_id);

            if ($stmt->execute()) {
                // Update successful
                echo "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Department updated successfully.'
                        }).then(() => {
                            window.location.href = './depart_categ.php';
                        });
                      </script>";
                exit();
            } else {
                // Update failed
                echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Update failed.'
                        }).then(() => {
                            window.location.href = './depart_categ.php';
                        });
                      </script>";
                exit();
            }

            // Close the statement and database connection
            $stmt->close();
            $conn->close();
        } else {
            // If the form was not submitted via POST method, return an error response
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Form submission error.'
                    }).then(() => {
                        window.location.href = './depart_categ.php';
                    });
                  </script>";
            exit();
        }
    } else {
        // Invalid action
        echo "<script>
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Invalid action.'
                }).then(() => {
                    window.location.href = './depart_categ.php';
                });
              </script>";
    }
} else {
    // If the form was not submitted via POST method, return an error response
    echo "<script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Form not submitted.'
            }).then(() => {
                window.location.href = './depart_categ.php';
            });
          </script>";
}
?>
