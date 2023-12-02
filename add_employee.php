<?php

include 'session.php';

include 'config.php';

$target_dir = "assets/img/";

$uploadOk = 1;

if (isset($_POST['submit'])) {

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $number = mysqli_real_escape_string($conn, $_POST['number']);
    $dob = mysqli_real_escape_string($conn, $_POST['dob']);
    $entry_day = mysqli_real_escape_string($conn, $_POST['entry_day']);
    $profession = mysqli_real_escape_string($conn, $_POST['profession']);
    
    $password = mysqli_real_escape_string($conn,  sha1($_POST['password']));

    // Check if the user already exists based on the email or username
    $select_users = mysqli_query($conn, "SELECT * FROM `users` WHERE email = '$email'") or die('query failed');

   
    if (mysqli_num_rows($select_users) > 0) {
        $message[] = 'User already exists!';
        
    } else {

            $target_file = $target_dir . basename($_FILES["photo"]["name"]);
            $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

            // Hash the password
            $hashed_password = sha1($password);

            $check = getimagesize($_FILES["photo"]["tmp_name"]);
            if($check !== false) {
              echo "File is an image - " . $check["mime"] . ".";
              $uploadOk = 1;
            } else {
              echo "File is not an image.";
              $uploadOk = 0;
            }
          }
          
          // Check if file already exists
          if (file_exists($target_file)) {
            echo "Sorry, file already exists.";
            $uploadOk = 0;
          }
          
          // Check file size
          if ($_FILES["photo"]["size"] > 500000) {
            echo "Sorry, your file is too large.";
            $uploadOk = 0;
          }
          
          // Allow certain file formats
          if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
          && $imageFileType != "gif" ) {
            echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
            $uploadOk = 0;
          }
          
          // Check if $uploadOk is set to 0 by an error
          if ($uploadOk == 0) {
            echo "Sorry, your file was not uploaded.";
          // if everything is ok, try to upload file
          } else {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
              echo "The file ". htmlspecialchars( basename( $_FILES["photo"]["name"])). " has been uploaded.";
            } else {
              echo "Sorry, there was an error uploading your file.";
            }


            // Insert the user's data into the database with the hashed password
            mysqli_query($conn, "INSERT INTO `users`(name, last_name, email, number, address, dob, entry_day, photo, profession, password) VALUES('$name', '$last_name', '$email', '$number', '$address', '$dob', '$entry_day', ' $target_file', '$profession', '$hashed_password')") or die('query failed');
            $message[] = 'User added successfully!';
          
        
    }
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Add Employee</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  
  <!-- JQuery -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

  
  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">

 
</head>

<body>


<?php
if (isset($message)) {
   foreach ($message as $msg) {
      echo '
      <div class="message">
         <span>' . $msg . '</span>
         <i class="fas fa-times" onclick="this.parentElement.remove();"></i>
      </div>
      ';
   }
}
?>



  <!-- ======= Header ======= -->
  <?php include 'header.php'; ?>
  <!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <?php include 'side_bar.php'; ?>
  <!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Add Employee</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="index.php">Home</a></li>
          <li class="breadcrumb-item">G R H</li>
          <li class="breadcrumb-item active">Add employee</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-6">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Infos</h5>

              <!-- General Form Elements -->
              <form class="row g-3" action="" name="add_employee" method="post" enctype="multipart/form-data" novalidate onsubmit="return validateForm()">
        <div class="col-md-6">
            <input type="text" class="form-control" placeholder="Name" name="name" required>
        </div>
        <div class="col-md-6">
            <input type="text" name="last_name" class="form-control" placeholder="Last Name" required>
        </div>

        <div class="col-md-6">
            <input type="email" name="email" class="form-control" placeholder="Email" value="" required>
        </div>
        <div class="col-md-6">
            <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>
        <div class="col-md-12">
            <input type="tel" pattern="[0-9]{3}-[0-9]{2}-[0-9]{3}" name="number" class="form-control" placeholder="Phone Number">
        </div>
        <div class="col-md-12">
            <input class="form-control" type="file" id="formFile" placeholder="Upload File" name="photo">
        </div>
        <div class="col-md-12">
            <input type="text" onfocus="(this.type='date')" class="form-control" placeholder="Birth Day" name="dob">
        </div>
        <div class="col-12">
            <input type="text" class="form-control" placeholder="Address" name="address">
        </div>
        <div class="col-md-12">
            <input type="text" onfocus="(this.type='date')" class="form-control" placeholder="Entry day" name="entry_day">
        </div>
        <div class="col-md-12">
            <label for="inputAddress" class="form-label">Pick a Color</label>
            <input type="color" class="form-control form-control-color" id="exampleColorInput" value="#4154f1" title="Choose your color" name="color">
        </div>

        <div class="col-md-12">
            <select class="form-select" aria-label="Default select example" name="profession" required>
                <option selected>Profession...</option>
                <option value="1">Administrateur</option>
                <option value="2">Employe</option>
                <option value="3">Client</option>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" name="submit" class="btn btn-primary">Submit</button>
            <button type="reset" name="reset" class="btn btn-secondary">Reset</button>
        </div>
    </form>

    <script>
        function validateForm() {
            // Add your validation functions here
            const name = document.forms["add_employee"]["name"].value;
            const lastName = document.forms["add_employee"]["last_name"].value;
            const email = document.forms["add_employee"]["email"].value;
            const password = document.forms["add_employee"]["password"].value;
            const number = document.forms["add_employee"]["number"].value;
            const dob = document.forms["add_employee"]["dob"].value;
            const address = document.forms["add_employee"]["address"].value;
            const entryDay = document.forms["add_employee"]["entry_day"].value;
            const profession = document.forms["add_employee"]["profession"].value;

            if (name.trim() === "") {
                alert("Name must be filled out");
                return false;
            }

            if (lastName.trim() === "") {
                alert("Last Name must be filled out");
                return false;
            }

            if (!isValidEmail(email)) {
                alert("Invalid email address");
                return false;
            }

            if (!isStrongPassword(password)) {
                alert("Password is not strong enough");
                return false;
            }

            // Add additional validations for number, dob, address, entryDay, and profession as needed

            return true; // If all validations pass, the form will be submitted
        }

        function isValidEmail(email) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            return emailRegex.test(email);
        }

        function isStrongPassword(password) {
            // Add your password strength criteria here
            const passwordRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return passwordRegex.test(password);
        }
    </script>

              <!-- End General Form Elements -->

            </div>
          </div>
      
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <?php include 'footer.php'; ?>
  <!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>