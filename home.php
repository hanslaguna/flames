<!DOCTYPE html>
<html>
<head>
  <title>Home | FLAMES and Zodiac Compatibility Calculator</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
  <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
  <style>
	body {
		background: rgb(93,42,66);
		background: radial-gradient(circle, rgba(93,42,66,1) 0%, rgba(36,21,28,1) 100%);
		color: #ffffff;
	}

.container {
  background-color: rgba(20, 20, 20, 0.5);
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.25);
  margin-top: 50px;
  margin-bottom: 50px;
  width: 700px;
}
.container_welcome{
  background-color: rgba(20, 20, 20, 0.5);
  padding: 40px;
  border-radius: 10px;
  box-shadow: 0px 0px 10px 0px rgba(0,0,0,0.25);
  margin: auto;
  margin-top: 50px;
  margin-bottom: 50px;
  width: 1000px;
}


.register-text {
	display: inline-block;
	margin: 0;
	padding: 0;
}

.navbar {
	background-color: rgba(20, 20, 20, 0.5);
	border: none;
	color: #fff;
}

.welcome {
	text-align: center;
	font-size: 5rem;
	font-weight: bold;
	margin-bottom: 1rem;
}

.subtitle {
	text-align: center;
	font-size: 3rem;
	margin-bottom: 2rem;
}

.img-fluid {
	max-width: 100%;
	height: auto;
	width: 1000px;
}

.container1 {
	margin-top: 10%;
}

.text-center {
	display: flex;
	align-items: center;
	justify-content: center;
}
.spin {
  animation: spin 60s linear infinite;
  opacity: 0.5;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }
  100% {
    transform: rotate(360deg);
  }
}

.btn-primary {
  background-color: #FCB1A6;
  color: white;
}
.btn-primary:hover {
  background-color: #5D2A42;
  color: white;
}
.custom-btn {
    border: none;
}

  </style>
</head>
<body>


<?php
// Start the session to check if the user is logged in
session_start();

// Database connection details
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "flames_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the user is already logged in
if (isset($_SESSION['email'])) {
    // Retrieve the user's information from the database
    $email = $_SESSION['email'];
    $stmt = $conn->prepare("SELECT first_name FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $first_name = $row['first_name'];

    // If logged in, show the navigation menu
    $nav = '<nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="#">FLAMES and Zodiac Compatibility Calculator</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a class="nav-link" href="prospects.php">Prospects</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="calculator.php">Calculator</a>
                </li>
            </ul>
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="logout.php">Logout</a>
                </li>
            </ul>
        </div>
    </nav>
    
	<div class="container_welcome">
	<div class="row">
	  <div class="col-md-6" style="margin: auto;">
	  <div class="home_text">
		<h3 class="welcome" style="font-size: 2.5rem;">Welcome, '. $first_name .'</h3>
		<p class="subtitle" style="font-size: 1.5rem;">Discover your love potential with our Flames and Zodiac compatibility calculator!</p>
	  </div>
	  </div>
	  <div class="col-md-6 text-center">
		<img src="https://cdn.discordapp.com/attachments/856045907409764393/1088655211561766984/zodiac.png" alt="Placeholder image" class="img-fluid spin">
	  </div>
	</div>
  </div>
  ';
} else {
    // If not logged in, show the login form and register button
    $nav = '';

	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		// Handle the login form submission
		$email = $_POST['email'];
		$password = $_POST['password'];

		// Hash the password using the default algorithm
		$hashed_password = password_hash($password, PASSWORD_DEFAULT);

		// Prepare the SQL statement to select the user
		$stmt = $conn->prepare("SELECT email, password FROM users WHERE email=?");
		$stmt->bind_param("s", $email);
		$stmt->execute();
		$result = $stmt->get_result();
		

		// Check if the user exists and the password is correct
		if ($result->num_rows == 1) {
			$row = $result->fetch_assoc();
			if (password_verify($password, $row['password'])) {
				// If login successful, set the session variable
				$_SESSION['email'] = $email;
				// Show success message
				echo '<div class="alert alert-success">You have successfully logged in.</div>';
				// Refresh the page to show the navigation menu
				header('Location: home.php');
				exit();
			}
		}

		// If login failed, show an error message
		$error = "Invalid email or password.";
		// Show error message
		echo '<div class="alert alert-danger">' . $error . '</div>';
	}

	// Show the login form
	$nav .= 
	'<div class="container">
		<h4 class="text-center">FLAMES and Zodiac Compatibility Calculator</h4>
		<p class="text-center">Login to get insights into Your Love Compatibility with FLAMES and Zodiac</p>
	</div>

	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-6">';
		try {
			if(isset($_POST['submit'])){
				$email = $_POST['email'];
				$password = $_POST['password'];
				throw new Exception('Invalid email or password.');
			}
		} catch (Exception $e) {
			$nav .= '<p class="text-center text-danger">' . $e->getMessage() . '</p>';
		}
		$nav .= '
			<form method="post">
				<div class="form-group">
					<label for="email">Email:</label>
					<input type="email" class="form-control" id="email" name="email" required>
				</div>
				<div class="form-group">
					<label for="password">Password:</label>
					<input type="password" class="form-control" id="password" name="password" required>
				</div>
				<div class="form-group text-center">
					<input type="submit" value="Login" name="submit" class="btn btn-primary custom-btn">
				</div>
				<p class="text-center">Don\'t have an account? &nbsp <a href="register.php" class="text-primary"> Register</a></p>
			</form>
		</div>
	</div>';


	}

// Close the database connection
$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
	<title>FLAMES and Zodiac Compatibility Calculator</title>
	<link rel="stylesheet" type="text/css" href="style.css">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>

<?php echo $nav; ?>

</body>
</html>