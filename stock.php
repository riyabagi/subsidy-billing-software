<?php
session_start();
$uid = $_SESSION['uid'];

if (!$uid) {
    header("Location: index.php");
    exit();
}
include 'link.php';
include 'connect.php';
include 'sidebar.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve values from the form
    $particulars = $_POST["particulars"];
    $units = $_POST["units"];
    $stocks = $_POST["stock"];
    $ndp = $_POST["ndp"];
    $mrp = $_POST["mrp"];

    $sql= "INSERT INTO stocks( particulars, units, mrp,stocks,ndp) VALUES ('$particulars','$units','$mrp','$stocks','$ndp')";
    $res=$con->query($sql);
   if($res){
    echo "<script> alert('data is saved');
    window.location.href = 'accoutn.php';
    </script>";
   } 
}
?>
<style>
    /* Apply a basic reset to remove default styles */
.stocks{
    margin-top:100px;
    padding-top:50px;
    width: 60%;    
    height: 70%;
}
form {
    max-width:80%;
    margin: 0 auto;
    background-color: #fff;
    padding: 20px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

label {
    display: inline-block;
    margin-bottom: 8px;
    width: 15%;
    color: black;
}

input {
    width: 30%;
    padding: 10px;
    margin-bottom: 40px;
    box-sizing: border-box;
    border: 2px solid #ccc;
    border-radius: 4px;
    border-color: #318ec8;
}

input[type="submit"] {
    background-color: #4caf50;
    color: #fff;
    cursor: pointer;
    margin-left: 300px;
    
  
}

input[type="submit"]:hover {
    background-color: #45a049;
    
}

/* Optional: Add some additional styling for better visual appeal */
h1 {
    /* display:flex;0 */

    text-align: center;
    margin-bottom: 20px;
    color: #333;
}

/* Optional: Style for form validation messages */
.form-message {
    color: #d9534f;
    margin-top: 5px;
}

</style>

<form method="post" action="stock.php" class="stocks">
<h1> ADD Stocks</h1>
<label for="particulars">Particulars:</label>
    <input type="text" name="particulars" required>
    <label for="units"  style="padding-left: 40px;">Units:</label>
    <input type="text" name="units" required><br>

    <label for="mrp">MRP:</label>
    <input type="text" name="mrp" required>

    <label for="stock"  style="padding-left: 40px;">Stock:</label>
    <input type="text" name="stock" required><br>

    <label for="ndp">NDP:</label>
    <input type="text" name="ndp" required>

    <!-- <label for="mrp"  style="padding-left: 40px;">MRP:</label>
    <input type="text" name="mrp" required><br> -->


    <input type="submit" value="Submit">
</form>

</body>
</html>