<?php 
session_start();

	include("connection.php");
	include("functions.php");

  //شوف واش مسجل ولا عندو كوكيز تاع تسجيل
  if( isset($_SESSION['userid']))
{
  header('Location: home.php');
  exit;
}else if( isset($_COOKIE['rememberme'] )){
  // pass the name to a var
  $e = $_COOKIE['rememberme'];
  // Decrypt cookie variable value
  $userid = encrypt_decrypt('decrypt',$e);
  // Fetch records
  $stmt = $conn->prepare("SELECT count(*) FROM wuser WHERE wid=:id");
  $stmt->bindValue(':id', (int)$userid, PDO::PARAM_INT);
  $stmt->execute(); 
  $count = $stmt->fetchColumn();
  if( $count > 0 ){
     $_SESSION['user_id'] = $userid; 
     header('Location: home.php');
     exit;
  }
}

	if(isset($_POST['signup']))
	{
		//something was posted
		$wname = $_POST['wname'];
		$wemail = $_POST['wemail'];
		$wpassword = $_POST['wpassword'];
        $password2 = $_POST['wpassword2'];

        if($wpassword !== $password2) {
            echo "Passwords do not match";
        } else {
            if(!empty($wname) && !empty($wpassword))
            {
                $query = "SELECT * FROM wuser WHERE wname = :name;";
                $stmt = $conn->prepare($query);
                $stmt->bindParam(':name', $wname);
                $stmt->execute();
                $result = $stmt->fetch();

                if(!$result) {
                    //save to database
                    $wpassword = password_hash($wpassword, PASSWORD_DEFAULT);
                    $query = "INSERT INTO wuser ( wname , wemail , wpassword , access_level)
			                        values (:name,:email,:pwd,'user')";
                    $stmt = $conn->prepare($query);
                    $stmt->bindParam(':name', $wname);
                    $stmt->bindParam(':email', $wemail);
                    $stmt->bindParam(':pwd', $wpassword);
                    $stmt->execute();
                    
                    $wid = $conn->lastInsertId();

                    $query2 = "INSERT INTO wprofile ( wid, fullName)
                                values (:wid, :name)";
                    $stmt2 = $conn->prepare($query2);
                    $stmt2->bindParam(':name', $wname);
                    $stmt2->bindParam(':wid', $wid);
                    if($stmt2->execute()){
                      header("Location: index.html");
                        exit();
                    } else {
                        header("Location: register.php?signup=error");
                        exit();
                    }                
                } else {
                    header("Location: register.php?signup=error");
                    exit();
                }
            } else {
                echo "Please enter some valid information!";
            }
        }
	}

    if(isset($_GET['signup']) && $_GET['signup'] == "error") {
        echo "Unable to create your account";
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Pages / Register - NiceAdmin Bootstrap Template</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

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

  <!-- =======================================================
  * Template Name: NiceAdmin - v2.2.2
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>

  <main>
    <div class="container">

      <section class="section register min-vh-100 d-flex flex-column align-items-center justify-content-center py-4">
        <div class="container">
          <div class="row justify-content-center">
            <div class="col-lg-4 col-md-6 d-flex flex-column align-items-center justify-content-center">

              <div class="d-flex justify-content-center py-4">
                <a href="index.html" class="logo d-flex align-items-center w-auto">
                  <img src="assets/img/logo.png" alt="">
                  <span class="d-none d-lg-block">Rush To Learn</span>
                </a>
              </div><!-- End Logo -->

              <div class="card mb-3">

                <div class="card-body">

                  <div class="pt-4 pb-2">
                    <h5 class="card-title text-center pb-0 fs-4">Create an Account</h5>
                    <p class="text-center small">Enter personal details to create account</p>
                  </div>

                  <form action="./register.php" method="POST" name="register" class="row g-3 needs-validation" novalidate>
                    <div class="col-12">
                      <label for="yourName" class="form-label">Your Name</label>
                      <input type="text" name="wname" class="form-control" id="yourName" required>
                      <div class="invalid-feedback">Please, enter your name!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourEmail" class="form-label">Your Email</label>
                      <input type="email" name="wemail" class="form-control" id="yourEmail" required>
                      <div class="invalid-feedback">Please enter a valid Email adddress!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="wpassword" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <label for="yourPassword" class="form-label">Password</label>
                      <input type="password" name="wpassword2" class="form-control" id="yourPassword" required>
                      <div class="invalid-feedback">Please enter your password!</div>
                    </div>

                    <div class="col-12">
                      <div class="form-check">
                        <input class="form-check-input" name="terms" type="checkbox" value="" id="acceptTerms" required>
                        <label class="form-check-label" for="acceptTerms">I agree and accept the <a href="#">terms and conditions</a></label>
                        <div class="invalid-feedback">You must agree before submitting.</div>
                      </div>
                    </div>
                    <div class="col-12">
                      <button class="btn btn-primary w-100" name="signup" type="signup">Create Account</button>
                    </div>
                    <div class="col-12">
                      <p class="small mb-0">Already have an account? <a href="index.html">Log in</a></p>
                    </div>
                  </form>

                </div>
              </div>

              <div class="credits">
                <!-- All the links in the footer should remain intact. -->
                <!-- You can delete the links only if you purchased the pro version. -->
                <!-- Licensing information: https://bootstrapmade.com/license/ -->
                <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
                Designed by <a href="https://bootstrapmade.com/">Mohammed Reda EL Jirari</a>
              </div>

            </div>
          </div>
        </div>

      </section>

    </div>
  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.min.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.min.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
