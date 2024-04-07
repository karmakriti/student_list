<?php
if($_SERVER["REQUEST_METHOD"] == "POST") {
    //after filling all fields
    //Validate username
    if (!preg_match("/^[a-zA-Z]*$/", $_POST["username"])) {
        echo "Username must contain only alphabetical letters!";
        exit();
    } else {
        //Username is valid, save it in username variable
        $username = $_POST["username"];
    }

    if (!preg_match("/^[a-zA-Z0-9]{3,10}$/", $_POST["password"])) {
        echo "Password should contain numbers and letters only and be between 3 and 10 characters";
        exit();
    } else {
        $password = $_POST["password"];
    }

    if (!preg_match("/^[0-9]*$/", $_POST["age"])) {
        echo "The age should contain only numbers";
        exit();
    } else {
        $age = $_POST["age"];
    }

    //now we will make sure that my additionalInfo will be between 3 and 25 characters
    //strlen: return the length of the input
    if(strlen($_POST["additionalinfo"]) < 3 || strlen($_POST["additionalinfo"]) > 10) {
        echo "Your additionalInfo should be between 3 and 10";
        exit();
    } else {
        $additionalInfo = $_POST["additionalinfo"];
    }

    //Now after PHP has done all the validations, we will send the saved values to my database
    //We will then build a connection between PHP and my database

    $conn = new mysqli("localhost", "root", "", "ilac_college");

    // we will check that connection is successfully executed
    if ($conn->connect_error) {
        die ("Connection Failed" . $conn->connect_error);
    }

    //now connection is built so we create a query
    $sql = "INSERT INTO phpstudents(name, password, age, additionalinfo)
    VALUES('$username','$password','$age','$additionalInfo')";

    //we use a method called query()
    $results = $conn->query($sql);

    //now we check if my query was run successfully
    if ($results === true) {
        echo "Data stored in database";
    } else {
        echo "You got an error: " . $sql . $conn->error;
    }

    $conn->close();
}

// Fetch data from database
$conn = new mysqli("localhost", "root", "", "ilac_college");

if ($conn->connect_error) {
    die ("Connection Failed" . $conn->connect_error);
}

$query = "SELECT * FROM phpstudents";

$results = $conn->query($query);

if ($results->num_rows > 0) {
    // Output data in a table
    echo "<table border='1'>";
    echo "<tr><th>Name</th><th>Password</th><th>Age</th><th>AdditionalInfo</th></tr>";

    while($row = $results->fetch_assoc()) {
        echo "<tr>";
        echo "<td>".$row["name"]."</td>";
        echo "<td>".$row["password"]."</td>";
        echo "<td>".$row["age"]."</td>";
        echo "<td>".$row["additionalinfo"]."</td>";
        echo "</tr>";
    }

    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();


?>
