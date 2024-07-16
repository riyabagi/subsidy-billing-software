<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>

</head>
<style>
    @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@500&display=swap');

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Poppins', sans-serif;
    }

    body {
        display: flex;
        align-items: center;
        justify-content: center;
        min-height: 100vh;
        background-image: linear-gradient(rgba(54, 115, 71, 0.908), rgba(54, 102, 62, 0.174)), url(https://user-images.githubusercontent.com/13468728/233847739-219cb494-c265-4554-820a-bd3424c59065.jpg);
        background-repeat: no-repeat;
        background-position: center;
        background-size: cover;
    }

    .sections section {
        position: relative;
        max-width: 400px;
        background-color: transparent;
        border: 2px solid rgba(255, 255, 255, 0.5);
        border-radius: 20px;
        backdrop-filter: blur(55px);
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 2rem 3rem;
    }

    h1 {
        font-size: 2rem;
        color: black;
        text-align: center;
    }

    .inputbox {
        position: relative;
        margin: 30px 0;
        max-width: 310px;
        border-bottom: 2px solid black;
    }

    .inputbox label {
        position: absolute;
        top: 50%;
        left: 5px;
        transform: translateY(-50%);
        color: black;
        font-size: 1rem;
        pointer-events: none;
        transition: all 0.5s ease-in-out;
    }

    input:focus~label,
    input:valid~label {
        top: -5px;
    }

    .inputbox input {
        width: 100%;
        height: 60px;
        background: transparent;
        border: none;
        outline: none;
        font-size: 1rem;
        padding: 0 35px 0 5px;
        color: black;
    }

    .inputbox ion-icon {
        position: absolute;
        right: 8px;
        color: #fff;
        font-size: 1.2rem;
        top: 20px;
    }

    .button-container button {
        width: 100%;
        height: 40px;
        border-radius: 40px;
        background-color: rgb(255, 255, 255, 1);
        border: none;
        outline: none;
        cursor: pointer;
        font-size: 1rem;
        font-weight: 600;
        transition: all 0.4s ease;
    }

    .button-container button:hover {
        background-color: rgb(255, 255, 255, 0.5);
    }

    /* Responsive Styles */

    @media only screen and (max-width: 600px) {
        section {
            width: 80%;
            padding: 2rem;
        }

        .inputbox {
            max-width: 100%;
        }
    }
</style>

<body>
    <div class="sections">
        <section>
            <form>
                <h1>Login</h1>
                
                <div class="inputbox">
                    <ion-icon name="person-outline"></ion-icon>
                    <input type="email" id="email"  required>
                    <label for="email">User name</label>
                </div>
                <div class="inputbox">
                    <ion-icon name="lock-closed-outline"></ion-icon>
                    <input type="password"  id="pass" required>
                    <label for="password" >Password</label>
                </div>

                <div class="button-container">
                    <button id="login">Log in</button>
                </div>

            </form>
        </section>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <script>
        $(document).ready(function () {
            $("#login").click(function () {
                let lemail = $("#email").val();
                let lpss = $("#pass").val();

                if (lemail == '') {
                    $("#error").html("Please enter the email")
                }
                else if (lpss == '') {
                    $("#error").html("Please enter the password")
                }

                else {
                    $.ajax({
                        url: './ajax/loginajax.php',
                        method: "POST",
                        data: {
                            lemail: lemail,
                            lpss: lpss,
                        },
                        success: function (res) {
                            alert(res)
                            // $_SESSION['uid']=res;
                            if (res === 'success')
                                window.location.href = 'dashboard.php';
                        },
                        error: function (err) {

                        }
                    })
                }
            })
        })
    </script>

</body>

</html>