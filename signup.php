<?php
include('connection.php');

if (isset($_POST['submit'])) {
    $username = mysqli_real_escape_string($conn, $_POST['user']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['pass']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpass']);

    $sql = "Select * from details where username='$username'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }

    $count_user = mysqli_num_rows($result);

    $sql = "Select * from details where email='$email'";
    $result = mysqli_query($conn, $sql);

    if ($result === false) {
        die("Query failed: " . mysqli_error($conn));
    }

    $count_email = mysqli_num_rows($result);

    if ($count_user == 0 && $count_email == 0) {

        if ($password == $cpassword) {

            $hash = password_hash($password, PASSWORD_DEFAULT);

            // Password Hashing is used here.
            $sql = "INSERT INTO details(username, email, password) VALUES('$username', '$email','$hash')";

            $result = mysqli_query($conn, $sql);

            if ($result) {
                header("Location: welcome.php");
            } else {
                die("Query failed: " . mysqli_error($conn));
            }
        } else {
            echo  '<script>
                    alert("Passwords do not match")
                    window.location.href = "index1.php";
                </script>';
        }
    } else {
        if ($count_user > 0) {
            echo  '<script>
                    window.location.href = "index1.php";
                    alert("Username already exists!!")
                </script>';
        }
        if ($count_email > 0) {
            echo  '<script>
                    window.location.href = "index1.php";
                    alert("Email already exists!!")
                </script>';
        }
    }
}
?>
