<?php

// Start session to keep user logged in
session_start();

// If the user is not logged in, redirect back to home page
if (!isset($_SESSION['email'])) {
    header("location:home.php");
}

// Define database credentials if not defined already
if (!(defined('DB_SERVER') && defined('DB_USERNAME') && defined('DB_PASSWORD') && defined('DB_NAME'))) {
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', '');
    define('DB_NAME', 'flames_db');
}

// Fetches prospect data from the database based on a SQL query.
function fetchProspectData($conn, $sql) {
    $result = $conn->query($sql);
    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return [
            "first_name" => $row['first_name'],
            "last_name" => $row['last_name'],
            "birthday" => $row['birthday'],
            "zodiac_sign" => $row['zodiac_sign']
        ];
    }
    return null;
}

// Function to count common letters between two full names
function countCommonLetters($full_name_prospect_1, $full_name_prospect_2){
    
    // Attempt database connection
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }
    
    // Prepare names for comparison by removing commas and spaces and making them lowercase
    $prepared_full_name_1 = strtolower(str_replace(array(",", " "), "", $full_name_prospect_1));
    $prepared_full_name_2 = strtolower(str_replace(array(",", " "), "", $full_name_prospect_2));

    // Count frequency of each character in both names
    $name_char_freq_1 = array_count_values(str_split($prepared_full_name_1));
    $name_char_freq_2 = array_count_values(str_split($prepared_full_name_2));

    // Count the number of similar characters in both names and build a string of the similar characters
    $similar_char_count = 0;
    $similar_chars_string = "";
    foreach ($name_char_freq_1 as $name_1_char => $name_1_char_freq) {
        foreach ($name_char_freq_2 as $name_2_char => $name_2_char_freq) {
            if ($name_1_char == $name_2_char) {
                $similar_char_count += $name_1_char_freq + $name_2_char_freq;
                $similar_chars_string .= " " . strtoupper($name_1_char);
            }
        }
    }
    $similar_char_count_mod = $similar_char_count % 6;

    // Get FLAMES result from database
    $sql = "SELECT * FROM flames WHERE modulo=$similar_char_count_mod";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_array();
        $result_1 = $full_name_prospect_1 . " and " . $full_name_prospect_2 . " are " . "<b>" . $row['result'] . "</b>";
        $result_2 = empty($similar_chars_string) ? "" : "Their common letters are: " . $similar_chars_string . "<br>";
        $result_3 = $full_name_prospect_1 . " has " . array_sum($name_char_freq_1) . " common letters. ". "<br>" . 
                    $full_name_prospect_2 . " has " . array_sum($name_char_freq_2) . " common letters. ";
        $result_4 = "Their total is $similar_char_count (modulo 6) is $similar_char_count_mod which means they are " . "<b>" . $row['result']. "</b>";
        return $result_1 . "<br>" . $result_2 . "<br>" . $result_3 . "<br>" . $result_4;
    } else {
        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
    
    // Close database connection
    $result->free();
    $conn->close();
}    

// This function computes and returns the zodiac compatibility of two given zodiac signs
function ComputeZodiacCompatibility($sign_1, $sign_2) {
    // Create a new mysqli connection to the database
    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    // Check for connection errors and terminate the script if there is one
    if ($conn->connect_error) {
        die("ERROR: Could not connect. " . $conn->connect_error);
    }

    // Prepare the SQL statement to select the compatibility of the two given signs from the database
    $sql = "SELECT compatibility FROM compatibility WHERE prospect_one_zodiac = ? AND prospect_two_zodiac = ?";
    $stmt = $conn->prepare($sql);

    // Bind the parameter values to the statement and execute it
    $stmt->bind_param("ss", $sign_1, $sign_2);
    $stmt->execute();

    // Bind the result of the executed statement to a variable
    $stmt->bind_result($compatibility);
    $stmt->fetch();

    // Check if a compatibility value was returned from the database and return it
    if ($compatibility) {
        return "The Zodiac compatibility of $sign_1 and $sign_2 is \"$compatibility\"";
    } 
    // If no compatibility value was found, return an error message
    else {
        return '<div class="alert alert-danger"><em>No records were found.</em></div>';
    }
}



if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Connect to the database
    $conn = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
    if (!$conn) {
        die("ERROR: Could not connect. " . mysqli_connect_error());
    }

    // Retrieve form data
    $prospect1_id = $_POST['p1_id'];
    $prospect2_id = $_POST['p2_id'];
    $current_user_email = $_SESSION['email'];

    // Query the database for the selected prospects
    $sql_p1 = "SELECT * FROM prospects WHERE id = $prospect1_id AND user_email = '$current_user_email'";
    $sql_p2 = "SELECT * FROM prospects WHERE id = $prospect2_id AND user_email = '$current_user_email'";
    $prospect1 = fetchProspectData($conn, $sql_p1);
    $prospect2 = fetchProspectData($conn, $sql_p2);

    // Perform calculations and generate output message
    if ($prospect1 && $prospect2) {
        // Calculate the FLAMES result
        $flames_result = countCommonLetters($prospect1['last_name'] . ', ' . $prospect1['first_name'], $prospect2['last_name'] . ', ' . $prospect2['first_name']);
        
        // Calculate the Zodiac compatibility result
        $zodiac_result = ComputeZodiacCompatibility($prospect1['zodiac_sign'], $prospect2['zodiac_sign']);
        
        // Generate the output message
        $output_msg = "<p><b>FLAMES RESULTS:</b><br><br>$flames_result</p><p><b>ZODIAC COMPATIBILITY RESULTS:</b><br><br>$zodiac_result</p>";
    } else {
        // Display error message if no prospects were selected
        $output_msg = '<div class="alert alert-danger"><em>Error: Please select a prospect from the menu.</em></div>';
    }

    // Close database connection
    mysqli_close($conn);

}


?>

<html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Calculator | FLAMES and Zodiac Compatibility Calculator</title>

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet" />
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap" rel="stylesheet" />
    <!-- MDB -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/6.2.0/mdb.min.css" rel="stylesheet" />
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-w76AqPfDkMBDXo30jS1Sgez6pr3x5MlQ1ZAGC+nuZB+EYdgRZgiwxhTBTkF7CXvN"
        crossorigin="anonymous"></script>
    <!-- bootstrap for nav bar -->
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

        table {
            overflow-y: auto;
            height: 210px;
            display: block;
        }

        th {
            white-space: nowrap;
        }
    </style>
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
    <h4>Calculator</h4>
    <!-- A form for selecting prospects and submitting form data to calculator.php -->
    <form action="calculator.php" method="POST">
        <!-- A container for selecting a prospect for Person 1 -->
        <div class="mb-3">
            <label for="p1_id">Person 1:</label>
            <!-- A dropdown list of prospects for Person 1 -->
            <select class="form-select" id="p1_id" name="p1_id">
                <!-- An option to choose a prospect -->
                <option value="-1">--Choose a Prospect--</option>
                <?php
                    // Attempt database connection
                    try {
                        $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                    } catch (Exception $e) {
                        die("ERROR: " . $e->getMessage());
                    }

                    // Check if the database connection was successful
                    if ($conn === false) {
                        die("ERROR: Could not connect. " . $conn->connect_error);
                    }

                    // Construct a query to select all prospects created by the current user
                    $current_user = $_SESSION['email'];
                    $sql = "SELECT * FROM prospects WHERE user_email = '$current_user'";

                    // Execute the query and process the results
                    if ($result = $conn->query($sql)) {
                        // If the result set is not empty, display the prospects as options in the dropdown list
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_array()) {
                                echo "<option value='" . $row['id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                            }
                            // Free the result set
                            $result->free();
                        } else {
                            // If no prospects were found, display an error message
                            echo '<option value="">No records were found.</option>';
                        }
                    } else {
                        // If the query failed, display an error message
                        echo '<option value="">Oops! Something went wrong. Please try again later.</option>';
                    }

                    // Close the database connection
                    $conn->close();     
                ?>  
            </select>
            <?php 
                // Check if p1_id is empty when the form is submitted, and display an error message if it is
                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    if (empty($_POST['p1_id'])) {
                        echo '<div class="alert alert-danger mt-2"><em>Please select a person for Person 1.</em></div>';
                    }
                }
            ?>
        </div>


        <div class="mb-3">
            <label for="p2_id">Person 2:</label>
            <select class="form-select" id="p2_id" name="p2_id">
                <option value="-1">--Choose a Prospect--</option>

            <?php
                // Reconnect to the database
                try {
                    $conn = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
                } catch (Exception $e) {
                    die("ERROR: " . $e->getMessage());
                }

                // Check connection
                if ($conn === false) {
                    die("ERROR: Could not connect. " . $conn->connect_error);
                }

                // Select all fancied prospects created by the user
                $current_user = $_SESSION['email'];
                $sql = "SELECT * FROM prospects WHERE user_email = '$current_user'";

                // Perform db query
                if ($result = $conn->query($sql)) {
                    // If result set is not empty
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_array()) {
                            echo "<option value='" . $row['id'] . "'>" . $row['first_name'] . " " . $row['last_name'] . "</option>";
                        }
                        // Free result set
                        $result->free();
                    } else {
                        // If result set is empty
                        echo '<div class="alert alert-danger"><em>No records were found.</em></div>';
                    }
                } else {
                    // If db query failed
                    echo "Oops! Something went wrong. Please try again later.";
                }

                // Close database connection
                $conn->close();
            ?>
        </select>

        </div>
        <div class="mt-4">
            <button type="submit" class="btn btn-primary">Calculate</button>
        </div>
        </form>
        </div>


        <?php

        if (isset($output_msg)) {
            echo '
        <div class="container">
            <h4 class="card-title">Results</h4>
            ' . $output_msg . '
        </div>';
        }

        ?>
    </div>
</body>

</html>