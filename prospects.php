<?php

// Start a new session
session_start();

// Check if the email session variable is not set
if (!isset($_SESSION['email'])) {
  // Redirect the user to the home page
  header("location:home.php");
}

// Define constants for the database connection
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'flames_db');

try {
  // Create a new MySQLi database connection using the defined constants
  $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
} catch (Exception $e) {
  // If an exception occurs, print the error message and stop executing the script
  die("ERROR: " . $e->getMessage());
}

// If the database connection failed, print an error message and stop executing the script
if ($conn === false) {
  die("ERROR: Could not connect. " . $conn->connect_error);
}
class Person
{
    // Public properties for the person's first name, last name, birthday, and zodiac sign
    public $first_name;
    public $last_name;
    public $birthday;
    public $zodiac;

    // Constructor method that sets the person's first name, last name, birthday, and calculates their zodiac sign
    function __construct($first_name, $last_name, $birthday){
        $this->first_name = $first_name;
        $this->last_name = $last_name;
        $this->birthday = $birthday;
        // Create a new instance of the Zodiac class, passing the person's birthday as an argument
        $this->zodiac = new Zodiac($birthday);
    }

    // Method that returns the person's full name in the format "last_name, first_name"
    function GetFullName(){
        return "$this->last_name," . " $this->first_name";
    }
}


class Zodiac {
    public $sign; // the name of the zodiac sign
    public $symbol; // the symbol associated with the zodiac sign
    public $startDate; // the start date of the zodiac sign
    public $endDate; // the end date of the zodiac sign

    function __construct($date)
    {
        // Create a new mysqli object to connect to a database
        try {
            $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
        } catch (Exception $e) {
            // If an exception is thrown, display an error message and exit
            die("ERROR: " . $e->getMessage());
        }
    
        // If the connection failed, display an error message and exit
        if ($conn === false) {
            die("ERROR: Could not connect. " . $conn->connect_error);
        }
    
        // Extract the month and day from the input date
        $month = date("m", $date);
        $day = date("d", $date);
    
        // Determine the zodiac sign ID based on the month and day
        switch(true) {
            case (($month == 12 && $day >= 22) || ($month == 1 && $day <= 19)):
                $zodiacId = 10;
                break;
            case (($month == 1 && $day >= 20) || ($month == 2 && $day <= 18)):
                $zodiacId = 11;
                break;
            case (($month == 2 && $day >= 19) || ($month == 3 && $day <= 20)):
                $zodiacId = 12;
                break;
            case (($month == 3 && $day >= 21) || ($month == 4 && $day <= 19)):
                $zodiacId = 1;
                break;
            case (($month == 4 && $day >= 20) || ($month == 5 && $day <= 20)):
                $zodiacId = 2;
                break;
            case (($month == 5 && $day >= 21) || ($month == 6 && $day <= 21)):
                $zodiacId = 3;
                break;
            case (($month == 6 && $day >= 22) || ($month == 7 && $day <= 22)):
                $zodiacId = 4;
                break;
            case (($month == 7 && $day >= 23) || ($month == 8 && $day <= 22)):
                $zodiacId = 5;
                break;
            case (($month == 8 && $day >= 23) || ($month == 9 && $day <= 22)):
                $zodiacId = 6;
                break;
            case (($month == 9 && $day >= 23) || ($month == 10 && $day <= 23)):
                $zodiacId = 7;
                break;
            case (($month == 10 && $day >= 24) || ($month == 11 && $day <= 21)):
                $zodiacId = 8;
                break;
            case (($month == 11 && $day >= 22) || ($month == 12 && $day <= 21)):
                $zodiacId = 9;
                break;
            default:
            // If the date does not correspond to any zodiac sign, display an error message and exit
                echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                return;
        }
        // Query the database to get the zodiac sign information for the determined ID
        $sql = "SELECT * FROM zodiac WHERE id = '$zodiacId'";
        $result = $conn->query($sql);
    
        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_array();
            $this->sign = $row['zodiac_sign'];
            $this->symbol = $row['zodiac_symbol'];
            $this->startDate = $row['start_date'];
            $this->endDate = $row['end_date'];
            $result->free();
        } else {
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    }
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get input values from POST request
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $birthday = $_POST['birthday'];
    // Create new Person object using input values
    $person_object = new Person($first_name, $last_name, strtotime($birthday));

    // Get zodiac sign from Person object
    $person_object_zodiac_sign = $person_object->zodiac->sign;

    // Get current user's email from session
    $user_email_current = $_SESSION['email'];

    // Check if the request is to create or update a prospect in the database
    if ($_POST['db_action'] == 'create') {
        
        // Create SQL query to insert a new prospect
        $sql = "INSERT INTO prospects (first_name, last_name, birthday, zodiac_sign, user_email) VALUES ('$first_name', '$last_name', '$birthday', '$person_object_zodiac_sign', '$user_email_current')";
        
        // Execute query and display success message or error message if query fails
        if ($conn->query($sql)) {
            echo '<script>alert("Prospect added to database!"); window.location.assign("prospects.php");</script>';
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
        
    } else {
        
        // Get prospect ID from POST request
        $prospect_id = $_POST['prospect_id'];
        
        // Create SQL query to update an existing prospect
        $sql = "UPDATE prospects SET first_name='$first_name', last_name='$last_name', birthday='$birthday', zodiac_sign='$person_object_zodiac_sign' WHERE id='$prospect_id'";
        
        // Execute query and display success message or error message if query fails
        if ($conn->query($sql)) {
            echo '<script>alert("Prospect information updated!"); window.location.assign("prospects.php");</script>';
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }
    }

        // Unset the Person object to free up memory
        unset($person_object);
    }


// Check if both 'id' and 'operation' are set in the URL query string
if (isset($_GET['id'], $_GET['operation'])) {
    // Get the prospect id from the URL query string
    $prospect_id = $_GET['id'];

    // If the operation is 'update'
    if ($_GET['operation'] === 'update') {
        // Create SQL query to retrieve the prospect record with the given id
        $sql = "SELECT * FROM prospects WHERE id = '$prospect_id'";
        $result = $conn->query($sql);

        // If there is at least one result, retrieve the record and store its data in variables
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $update_first_name = $row['first_name'];
            $update_last_name = $row['last_name'];
            $update_birthday = $row['birthday'];
        } else {
            // If no results are found, display an error message
            echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
        }
    } 
    // If the operation is 'delete'
    elseif ($_GET['operation'] === 'delete') {
        // Create SQL query to delete the prospect record with the given id
        $sql = "DELETE FROM prospects WHERE id ='$prospect_id'";
        $success = $conn->query($sql);

        // If the query was successful, display a success message and redirect to prospects.php
        if ($success) {
            echo '<script>alert("Prospect information deleted!");</script>';
            echo '<script>window.location.assign("prospects.php");</script>';
        } else {
            // If the query was not successful, display an error message
            echo "Oops! Something went wrong. Please try again later.";
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Prospects | FLAMES and Zodiac Compatibility Calculator</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
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
        .navbar {
            background-color: rgba(20, 20, 20, 0.5);
            border: none;
            color: #fff;
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
        .container-fluid{
        margin: auto;
        }
        .wrapper {
            width: 600px;
            margin: 0 auto;
        }
  
        table {
        border: none;
        }   
        table tr td:last-child {
            border: none;
        }

        th {
            white-space: nowrap;
            color: white;
        }
        tr {
            color: white;
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

    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>

<body>

    <nav class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand" href="home.php">FLAMES and Zodiac Compatibility Calculator</a>
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

<div class="container">
  <div class="wrapper">
    <div class="container-fluid ">
      <div class="row">
        <div class="col-md-12">
          <h2>Prospects</h2><br>
          <div class="form-group">
            <input type="button" data-bs-toggle="modal" data-bs-target="#addStaticBackdrop" value="Add Prospect" name="submit" class="btn btn-primary custom-btn">
          </div>
          <?php
            
            $current_user = $_SESSION['email'];
        
            $sql = "SELECT * FROM prospects WHERE user_email = '$current_user'";
        
            if ($result = $conn->query($sql)) {
           
              if ($result->num_rows > 0) {
                echo '<table class="table">';
                echo "<thead>";
                echo "<tr>";
                echo "<th>First Name</th>";
                echo "<th>Last Name</th>";
                echo "<th>Birthday (yyyy-mm-dd) </th>";
                echo "<th>Zodiac Sign </th>";
                echo "<th>Action</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody>";
        
                while ($row = $result->fetch_array()) {
                  echo "<tr>";
                  echo "<td>" . $row['first_name'] . "</td>";
                  echo "<td>" . $row['last_name'] . "</td>";
                  echo "<td>" . $row['birthday'] . "</td>";
                  echo "<td>" . $row['zodiac_sign'] . "</td>";
                  echo "<td style='white-space:nowrap;'>";
                  echo '<a href="prospects.php?id=' . $row['id'] . '&operation=update" class="m-1" title="Update Record" data-toggle="tooltip"><span class="fa fa-pencil"></a>';
                  echo '<a href="prospects.php?id=' . $row['id'] . '&operation=delete" class="m-2" title="Delete Record" data-toggle="tooltip" onclick="alert(\'Are you sure you want to delete this prospect?\')"><span class="fa fa-trash"></span></a>';
                  echo "</td>";
                  echo "</tr>";
                }
                echo "</tbody>";
                echo "</table>";
           
                $result->free();
              } else {
              
                echo '<div class="alert alert-danger"><em>No prospects found yet, add a prospect now!</em></div>';
              }
            } else {
         
              echo "Oops! Something went wrong. Please try again later.";
            }
          ?>
        </div>
      </div>
    </div>
  </div>
</div>



<div class="modal fade" id="addStaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="addStaticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content bg-dark">
      <form action="prospects.php" method="POST">
        <div class="modal-header">
          <h1 class="modal-title text-light fs-5" id="addStaticBackdropLabel">Add a Prospect</h1>
          <button type="button" class="btn-close text-light" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label for="first_name" class="form-label text-light">First Name:</label><br>
            <input type="text" class="form-control" id="first_name" name="first_name" maxlength="50" required>
          </div>

          <div class="mb-3">
            <label for="last_name" class="form-label text-light">Last Name:</label><br>
            <input type="text" class="form-control" id="last_name" name="last_name" maxlength="50" required>
          </div>

          <div class="mb-3">
            <label for="birthday" class="form-label text-light">Birthday:</label><br>
            <input type="date" class="form-control" id="birthday" name="birthday" required>
          </div>
        </div>
        <div class="modal-footer">
          <button type="reset" class="btn btn-secondary">Reset</button>
          <button type="submit" name="db_action" class="btn btn-primary" value="create">Add</button>
        </div>
      </form>
    </div>
  </div>
</div>


<div class="modal fade" id="editStaticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="editStaticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content bg-dark">
            <form action="prospects.php" method="POST">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="editStaticBackdropLabel">Edit Prospect</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="first_name">First Name:</label><br>
                        <input type="text" class="form-control" id="first_name" name="first_name" value=<?php echo $update_first_name; ?> maxlength="50" required>
                    </div>

                    <div class="mb-3">
                        <label for="last_name">Last Name:</label><br>
                        <input type="text" class="form-control" id="last_name" name="last_name" value=<?php echo $update_last_name; ?> maxlength="50" required>
                    </div>

                    <div class="mb-3">
                        <label for="birthday">Birthday:</label><br>
                        <input type="date" class="form-control" id="birthday" class="form-control" name="birthday"
                            value=<?php echo $update_birthday; ?> required>
                    </div>

                    <input type="hidden" name="prospect_id" value=<?php echo $prospect_id ?> />
                </div>
                <div class="modal-footer">
                    <button type="submit" name="db_action" class="btn btn-primary" value="update">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
if (isset($_GET['id']) && isset($_GET['operation'])) {
    if ($_GET['operation'] == 'update') {
        echo "<script>
$(document).ready(function () {
    $('#editStaticBackdrop').modal('show');
}); </script>";
    }
}
?>
</body>

</html>