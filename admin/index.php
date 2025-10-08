<?php
session_start();
error_reporting(0);
include('includes/dbconnection.php');

if (isset($_POST['login'])) {
	$adminuser = $_POST['username'];
	$password = $_POST['password'];
	$query = mysqli_query($con, "select ID from tbladmin where  UserName='$adminuser' && Password='$password' ");
	$ret = mysqli_fetch_array($query);
	if ($ret > 0) {
		$_SESSION['bpmsaid'] = $ret['ID'];
		header('location:dashboard.php');
	} else {
		$msg = "Invalid Details.";
	}
}
?>
<!DOCTYPE HTML>
<html>

<head>
	<title>BPMS | Login Page </title>

	<script type="application/x-javascript">
		addEventListener("load", function() {
			setTimeout(hideURLbar, 0);
		}, false);

		function hideURLbar() {
			window.scrollTo(0, 1);
		}
	</script>
	<!-- Bootstrap Core CSS -->
	<link href="css/bootstrap.css" rel='stylesheet' type='text/css' />
	<!-- Custom CSS -->
	<link href="css/style.css" rel='stylesheet' type='text/css' />
	<!-- font CSS -->
	<!-- font-awesome icons -->
	<link href="css/font-awesome.css" rel="stylesheet">
	<!-- //font-awesome icons -->
	<!-- js-->
	<script src="js/jquery-1.11.1.min.js"></script>
	<script src="js/modernizr.custom.js"></script>
	<!--webfonts-->
	<link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,300,300italic,400italic,700,700italic'
		rel='stylesheet' type='text/css'>
	<!--//webfonts-->
	<!--animate-->
	<link href="css/animate.css" rel="stylesheet" type="text/css" media="all">
	<script src="js/wow.min.js"></script>
	<script>
		new WOW().init();
	</script>
	<!--//end-animate-->
	<!-- Metis Menu -->
	<script src="js/metisMenu.min.js"></script>
	<script src="js/custom.js"></script>
	<link href="css/custom.css" rel="stylesheet">
	<!--//Metis Menu -->
</head>

<body class="cbp-spmenu-push">
	<div class="main-content">

		<!-- main content start-->
		<div style="background-color: #F1F1F1; height:800px;">
			<div class="main-page login-page ">
				<h3 class="title1">SignIn Page</h3>
				<div class="widget-shadow">
					<div class="login-top">
						<h4>Welcome back to BPMS AdminPanel ! </h4>
					</div>
					<div class="login-body">
						<form role="form" method="post" action="">
							<p style="font-size:16px; color:red" align="center"> <?php if ($msg) {
																						echo $msg;
																					}  ?> </p>
							<input type="text" class="user" name="username" placeholder="Username" required="true">
							<input type="password" name="password" class="lock" placeholder="Password" required="true">
							<input type="submit" name="login" value="Sign In">
							<div class="forgot-grid">

								<div class="forgot">
									<a href="../index.php">Back to Home</a>
								</div>
								<div class="clearfix"> </div>
							</div>
							<div class="forgot-grid">

								<div class="forgot">
									<a href="forgot-password.php">forgot password?</a>
								</div>
								<div class="clearfix"> </div>
							</div>
						</form>
					</div>
				</div>


			</div>
		</div>

	</div>
	<!-- Classie -->
	<script src="js/classie.js"></script>
	<script>
		var menuLeft = document.getElementById('cbp-spmenu-s1'),
			showLeftPush = document.getElementById('showLeftPush'),
			body = document.body;

		showLeftPush.onclick = function() {
			classie.toggle(this, 'active');
			classie.toggle(body, 'cbp-spmenu-push-toright');
			classie.toggle(menuLeft, 'cbp-spmenu-open');
			disableOther('showLeftPush');
		};

		function disableOther(button) {
			if (button !== 'showLeftPush') {
				classie.toggle(showLeftPush, 'disabled');
			}
		}
	</script>
	<style>
		/* Nền tổng thể */
		body {
			background: linear-gradient(135deg, #ff7eb3, #ff758c, #ff4d6d);
			background-size: 300% 300%;
			animation: gradientBG 6s ease infinite;
			font-family: 'Roboto', sans-serif;
			margin: 0;
			padding: 0;
		}

		/* Animation nền */
		@keyframes gradientBG {
			0% {
				background-position: 0% 50%;
			}

			50% {
				background-position: 100% 50%;
			}

			100% {
				background-position: 0% 50%;
			}
		}

		/* Tiêu đề */
		.title1 {
			text-align: center;
			font-size: 28px;
			font-weight: bold;
			color: white;
			margin-bottom: 15px;
			text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.3);
		}

		/* Khung form */
		.widget-shadow {
			max-width: 400px;
			margin: 0 auto;
			background: rgba(255, 255, 255, 0.95);
			padding: 30px 25px;
			border-radius: 15px;
			box-shadow: 0px 8px 25px rgba(0, 0, 0, 0.2);
			backdrop-filter: blur(8px);
		}

		/* Tiêu đề phụ */
		.login-top h4 {
			text-align: center;
			margin-bottom: 25px;
			font-size: 18px;
			color: #444;
		}

		/* Input */
		.login-body input.user,
		.login-body input.lock {
			width: 100%;
			padding: 12px 15px;
			margin-bottom: 15px;
			border-radius: 8px;
			border: 1px solid #ddd;
			font-size: 15px;
			transition: all 0.3s ease;
			background-color: #fafafa;
		}

		/* Hiệu ứng focus */
		.login-body input:focus {
			border-color: #ff4d6d;
			box-shadow: 0 0 8px rgba(255, 77, 109, 0.4);
			outline: none;
		}

		/* Nút Sign In */
		.login-body input[type="submit"] {
			background: linear-gradient(45deg, #ff4d6d, #ff758c);
			border: none;
			color: white;
			font-size: 16px;
			font-weight: bold;
			padding: 12px;
			border-radius: 8px;
			cursor: pointer;
			transition: all 0.3s ease;
		}

		.login-body input[type="submit"]:hover {
			background: linear-gradient(45deg, #ff758c, #ff4d6d);
			transform: translateY(-2px);
			box-shadow: 0 4px 12px rgba(255, 77, 109, 0.3);
		}

		/* Link phụ */
		.forgot a {
			color: #ff4d6d;
			font-size: 14px;
			text-decoration: none;
			transition: color 0.3s;
		}

		.forgot a:hover {
			color: #ff1a4c;
			text-decoration: underline;
		}

		/* Lỗi */
		p[style*="color:red"] {
			background: rgba(255, 77, 77, 0.1);
			padding: 8px;
			border-radius: 5px;
		}
	</style>
	<!--scrolling js-->
	<script src="js/jquery.nicescroll.js"></script>
	<script src="js/scripts.js"></script>
	<!--//scrolling js-->
	<!-- Bootstrap Core JavaScript -->
	<script src="js/bootstrap.js"> </script>
</body>

</html>