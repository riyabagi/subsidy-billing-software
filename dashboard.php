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

<nav>
    <input type="checkbox" id="check">
    <!-- <label for="check">
        <i class="fas fa-bars"></i>
    </label> -->
    <div class="container">

        <div class="content">
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <h3>Accounts</h3>

                    </div>
                </div>

                <div class="cards">
                    <div class="box">
                        <h3>Bills-subsidy</h3>

                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h3>Credit</h3>

                    </div>
                </div>
            </div>

            <div class="cards">
                <div class="cards">
                    <div class="box">
                        <h3>Bills-inward</h3>

                    </div>
                </div>
                <div class="card">
                    <div class="box">
                        <h3>Bills-outward</h3>
                    </div>
                </div>
                <div class="cards">
                    <div class="box">
                        <h3>Profit</h3>

                    </div>
                </div>
            </div>
        </div>

        <style>
            .chechbtn {
                font-size: 30px;
                color: white;
                float: right;
                line-height: 80px;
                margin-right: 40px;
                cursor: pointer;
                display: none;

            }

            #check {
                display: none;
            }

            @media (max-width: 952px) {
                label.logo {
                    font-size: 30px;
                    padding-left: 50px;
                }

            }

            .container {
                position: absolute;
                right: 0;
                width: 80vw;
                height: 100vh;
                /* background:none; */
            }

            .container .header {
                position: fixed;
                top: 0;
                right: 0;
                width: 80vw;
                height: 10vh;
                background: rgb(231, 220, 220);
                display: flex;
                align-items: center;
                justify-content: center;
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            }

            .container .header .nav {
                width: 90%;
                display: flex;
                align-items: center;

            }

            .container .content {
                position: relative;
                margin-top: 10vh;
                min-height: 90vh;
            }

            .container .content .cards {
                padding: 20px 15px;
                display: flex;
                align-items: center;
                justify-content: space-between;
                flex-wrap: wrap;
            }

            .container .content .cards .card {
                width: 370px;
                height: 120px;
                border-radius: 10px;
                background: 	#f17d80;
                margin: 20px 10px;
                display: flex;
                align-items: center;
                justify-content: space-around;
                /* box-shadow: 0 4px 8px 0 rgba(245, 243, 243, 0.941), 0 6px 20px 0 rgba(248, 245, 245, 0.91); */
            }

            .container .content .cards .cards {
                width: 370px;
                height: 120px;
                border-radius: 10px;
                background: #3b9ad7;
                margin: 20px 10px;
                display: flex;
                align-items: center;
                justify-content: space-around;
                box-shadow: 0 4px 8px 0 rgba(241, 239, 239, 0.2), 0 6px 20px 0 rgba(245, 243, 243, 0.19);
            }
            h3{
                color:white;
            }



        </style>
    </div>

     <!-- --> 