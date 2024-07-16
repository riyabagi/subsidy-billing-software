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

?>
<style>
    /* Apply a basic reset to remove default styles */
    .stocks {
        margin-top: 100px;
        padding-top: 50px;
        width: 60%;
        height: 70%;
    }

    form {
        max-width: 80%;
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

    h1 {
        text-align: center;
        margin-bottom: 20px;
        color: #333;
    }

    .form-message {
        color: #d9534f;
        margin-top: 5px;
    }
</style>

<form method="post" action="stock.php" class="stocks">
    <h1> ADD Stocks</h1>

    <?php
    include('connect.php');
    $id = isset($_GET['id']) ? $_GET['id'] : null;

    $sqlProduct = "SELECT * FROM stocks WHERE sno = $id";
    $resultProduct = mysqli_query($con, $sqlProduct);

    if (!$resultProduct) {
        die("Error in SQL query: " . mysqli_error($con));
    }
    ?>

    <?php
    while ($row = mysqli_fetch_assoc($resultProduct)) {

        $particulars = $row['particulars'] ?? '';
        $units = $row['units'] ?? '';
        $ndp = $row['ndp'] ?? '';
        $mrp = $row['mrp'] ?? '';
        $stocks = $row['stocks'] ?? '';

        ?>

        <label for="particulars">Particulars:</label>
        <input type="text" name="particulars" id="particulars" value="<?php echo htmlspecialchars($particulars); ?>"
            required>

        <label for="units" style="padding-left: 40px;">Units:</label>
        <input type="text" name="units" id="units" value="<?php echo htmlspecialchars($units); ?>" required><br>

        <label for="mrp">MRP:</label>
        <input type="text" name="mrp" id="mrp" value="<?php echo htmlspecialchars($mrp); ?>" required>

        <label for="stock" style="padding-left: 40px;">Stock:</label>
        <input type="text" name="stock" id="stocks" value="<?php echo htmlspecialchars($stocks); ?>" required><br>

        <label for="ndp">NDP:</label>
        <input type="text" name="ndp" id="ndp" value="<?php echo htmlspecialchars($ndp); ?>" required>

        <input type="submit" value="Submit" id="updatestocksave">

<script>
    $(document).ready(function () {
        $("#updatestocksave").click(function (event) {
            event.preventDefault(); 
            let particulars = $("#particulars").val();
            let units = $("#units").val();
            let mrp = $("#mrp").val();
            let stocks = $("#stocks").val();
            let ndp = $("#ndp").val();

            let id = <?= json_encode($id) ?>;

            $.ajax({
                url: './ajax/updatestockajax.php',
                method: "POST",
                data: {
                    particulars: particulars,
                    units: units,
                    mrp: mrp,
                    stocks: stocks,
                    ndp: ndp,
                    id: id,
                },
                success: function (res) {
                    alert(res)
                    window.location.href = 'showstocks.php';
                },
                error: function (err) {
                    console.error(err);
                }
            });
        });
    });
</script>


    <?php }
    ; ?>

</form>

</body>

</html>