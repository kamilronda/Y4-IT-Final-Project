<?php

// Include Google Client Library for PHP autoload file
require_once '../vendor/autoload.php';
// Requires config
require('../config/config.php');
// Creates and checks connection
require('../config/db.php');

// Starts session
session_start();

// If user is logged in
if (isset($_SESSION['student_email']) && isset($_COOKIE['student_email'])) {
	// Redirect to the student dashboard
	header('Location: ./dashboard.php');
	exit();
}

// Message variables
$msg = '';
$msgClass = '';

// Checks for posted data
if (isset($_POST['login'])) {
	// Starts session
	session_start();

	// Gets form data
	$studentEmail = mysqli_real_escape_string($conn, $_POST['studentemail']);
	$studentPassword = mysqli_real_escape_string($conn, $_POST['studentpassword']);

	// Puts variable into session variable
	$_SESSION['student_email'] = $studentEmail;

	// SELECT Query
	$query = "SELECT * FROM students WHERE student_email = '$studentEmail' && BINARY student_password = '$studentPassword'";
	$hash = "SELECT student_password FROM students WHERE student_email = '$studentEmail'";

	// Gets result
	$result = mysqli_query($conn, $query);
	$passwordHashed = mysqli_query($conn, $hash);

	// Returns all hashed passwords in an array
	$lists = mysqli_fetch_array($passwordHashed, MYSQLI_NUM);

	// Gets number of rows
	$numOfRows = mysqli_num_rows($result);

	if (mysqli_query($conn, $query) && isset($studentEmail) && isset($studentPassword) && $numOfRows == 1 || password_verify($studentPassword, $lists[0])) {
		// Sets Cookie for 30 Days and then it will expire
		setcookie('student_email', $studentEmail, time() + 2592000);
		//* Passed
		$msg = '<strong>Success!</strong> You have logged in';
		$msgClass = 'alert-success alert-dismissible fade show';
		// Redirects to the student dashboard after 1 second
		header('refresh:1;url=./dashboard.php');
	}
	else {
		//! Failed
		// Returns error
		$msg = '<strong>Error!</strong> You entered the wrong email or password';
		$msgClass = 'alert-danger alert-dismissible fade show my-4';
	}

}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<!-- Basic Page Needs -->
	<title>Log in | CloseApart</title>
	<meta charset="utf-8">
	<meta http-equiv="x-ua-compatible" content="ie=edge">
	<meta name="description"
		content="Student’s online second home – participate in quizzes, communicate with teachers, complete your work online! Get comfortable with us">
	<meta name="viewport" content="width=device-width, initial-scale=1">

	<!-- Favicons -->
	<link rel="shortcut icon" href="../assets/images/favicon.ico" type="image/x-icon">
	<link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

	<!-- Fonts -->
	<link href="https://fonts.googleapis.com/css?family=Poppins:200,300,400,600,700,800" rel="stylesheet">

	<!-- PWA -->
  <link rel='manifest' href='../manifest.json'>
  <script>
    // Registering our Service worker
    if ('serviceWorker' in navigator) {
      navigator.serviceWorker.register('../sw.js', {
        scope: './'
      })
    }
  </script>

	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=G-5271QT8X93"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'G-5271QT8X93');
	</script>

	<!-- Icons -->
	<link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

	<!-- Stylesheets -->
	<link rel="stylesheet" href="../assets/css/argon-design-system.min.css">
	<link rel="stylesheet" href="../assets/css/argon-design-system-extras.min.css">
</head>

<body>
	<!-- Navigation -->
	<?php include('../includes/navs/nav_transparent.php'); ?>
	<!-- Log in -->
	<section class="section section-shaped bg-primary section-md">
		<div class="container pt-6">
			<div class="row">
				<div class="col">
					<img class="d-none d-sm-none d-md-block login-image"
							src="../assets/images/illustrations/closeapart-room.png" alt="student bedroom">
				</div>
				<div class="col-md-5 col-lg-5">
					<?php if($msg != ""): ?>
					<div class="alert <?php echo $msgClass; ?> alert-dismissible fade show" role="alert"><?php echo $msg; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php endif; ?>
					<?php if(isset($_GET['success'])): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert"><?php echo $_GET['success']; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php endif; ?>
					<?php if(isset($_GET['err'])): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert"><?php echo $_GET['err']; ?>
						<button type="button" class="close" data-dismiss="alert" aria-label="Close">
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<?php endif; ?>
					<div class="card bg-secondary shadow border-0">
						<div class="card-body bg-secondary px-lg-5 py-lg-5">
							<div class="text-center text-muted mb-4">
								<small>Log in with credentials</small>
							</div>
							<form method="POST" action="<?php $_SERVER['PHP_SELF']; ?>" id="studentLoginForm">
								<div class="form-group mb-3">
									<div class="input-group input-group-alternative mb-2">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class='bx bxs-envelope'></i></span>
										</div>
										<input type="email" class="form-control" id="studentemail" name="studentemail" placeholder="Email"
											required>
									</div>
								</div>
								<div class="form-group">
									<div class="input-group input-group-alternative mb-2">
										<div class="input-group-prepend">
											<span class="input-group-text"><i class='bx bxs-lock-open-alt'></i></span>
										</div>
										<input id="password-field" type="password" class="form-control" id="studentpassword" name="studentpassword"
											placeholder="Password" required>
									</div>
									<span toggle="#password-field" class="bx bx-hide field-icon toggle-password"></span>
								</div>
								<div class="text-center">
									<button type="submit" name="login" class="btn btn-primary my-4 btn-block text-capitalize">Log in</button>
								</div>
							</form>
						</div>
					</div>
					<div class="row mt-3">
						<div class="col text-center">
							<a href="./signup.php" class="text-white"><small>Create new account</small></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>
	<!-- Footer -->
	<?php include('../includes/footers/footer_user.php'); ?>
	<!-- Scripts -->
	<script src="https://code.jquery.com/jquery-3.2.1.min.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
	<script src="../assets/js/argon-design-system.min.js"></script>
	<script src="../assets/js/main.js"></script>
	<script>
		$.validator.setDefaults({
			errorElement: 'span',
			errorPlacement: function (error, element) {
				error.addClass('invalid-feedback');
				element.closest('.form-group').append(error);
			},
			highlight: function (element, errorClass, validClass) {
				$(element).addClass('is-invalid');
			},
			unhighlight: function (element, errorClass, validClass) {
				$(element).removeClass('is-invalid');
			}
		});

		$("#studentLoginForm").validate({
			rules: {
				studentemail: {
					required: true,
					email: true
				},
				studentpassword: {
					required: true
				}
			},
			messages: {
				studentemail: {
					required: "Please enter your email",
					email: "Your email must be in the format of name@domain.com"
				},
				studentpassword: {
					required: "Please enter your password",
				}
			}
		});
	</script>
</body>

</html>