<!DOCTYPE html>
<html>
<head>
	<title>Register</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- Bootstrap CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
	<!-- Bootstrap JS -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

  <style>
	/* CSS For the HTML's frontend style */
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
	input[type="submit"] {
		background-color: #6F686D;
		color: #fff;
		padding: 12px 24px;
		border: none;
		border-radius: 4px;
		font-size: 16px;
		transition: background-color 0.3s ease-in-out;
	}
	/* Adds animation to the submit button when hovered*/
	input[type="submit"]:hover {
		background-color: #344966;
		color: #6F686D;
	}
	.register-text {
		display: inline-block;
		margin: auto;
		padding: 0;
    text-align: center;
	}

	</style>


</head>
<body>

<div class="container">
  <h4>Register</h4> <br>
  <div class="row">

      <form method="post" class="mx-auto">
        <div class="row form-group">
          <div class="col">
            <label for="first_name">First Name:</label>
            <input type="text" class="form-control" id="first_name" name="first_name" required>
          </div>
          <div class="col">
            <label for="last_name">Last Name:</label>
            <input type="text" class="form-control" id="last_name" name="last_name" required>
          </div>
        </div>
        <div class="row form-group">
          <div class="col">
            <label for="address_line_1">Address Line 1:</label>
            <input type="text" class="form-control" id="address_line_1" name="address_line_1" required>
          </div>
        </div>
        <div class="row form-group">
          <div class="col">
            <label for="address_line_2">Address Line 2:</label>
            <input type="text" class="form-control" id="address_line_2" name="address_line_2">
          </div>
        </div>
        <div class="row form-group">
          <div class="col">
            <label for="city">City:</label>
            <input type="text" class="form-control" id="city" name="city" required>
          </div>
          <div class="col">
            <label for="state">State/Province:</label>
            <input type="text" class="form-control" id="state" name="state" required>
          </div>
        </div>
        <div class="row form-group">
          <div class="col">
            <label for="email">Email:</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
        </div>
        <div class="row form-group">
          <div class="col">
            <label for="password">Password:</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
        </div>
        <div class="row">
          <div class="col">
            <input type="submit" class="btn btn-primary" value="Submit">
          </div>
        </div>
      </form>
      <br>    
      <p class="register-text">Already have an account? <a href="home.php" class="register">Login</a></p>
  </div>
</div>



  <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      // Get the form data
      $first_name = $_POST["first_name"];
      $last_name = $_POST["last_name"];
      $address_line_1 = $_POST["address_line_1"];
      $address_line_2 = $_POST["address_line_2"];
      $city = $_POST["city"];
      $state = $_POST["state"];
      $email = $_POST["email"];
      $password = $_POST["password"];

      // Hash the password using bcrypt
      $password_hash = password_hash($password, PASSWORD_BCRYPT);

      // Connect to the database
      $host = "localhost";
      $username = "root";
      $password = "";
      $dbname = "flames_db";

      $conn = mysqli_connect($host, $username, $password, $dbname);

      // Check connection
      if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
      }

      // Prepare and execute SQL statement to insert new user
      $sql = "INSERT INTO users (first_name, last_name, address_line_1, address_line_2, city, state, email, password) VALUES ('$first_name', '$last_name', '$address_line_1', '$address_line_2', '$city', '$state', '$email', '$password_hash')";

      if (mysqli_query($conn, $sql)) {
        echo "User registered successfully.";
      } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
      }

      // Close database connection
      mysqli_close($conn);
      echo '<script>alert("Account created successfully!");</script>';

      // Redirect to home.php
      echo '<script>window.location.href="home.php";</script>';
    }

    
  ?>
</body>
</html>
