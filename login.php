<?php

session_start();
if (isset($_SESSION['user']))
    header('location: dashboard.php');

$error_message = '';

if ($_POST) {
    include('database/connection.php');

    $email = $_POST['email'];
    $password = $_POST['password'];


    $query = 'SELECT * FROM users WHERE users.email="' . $email . '" AND users.password="' . $password . '"';
    $stmt = $conn->prepare($query);
    $stmt->execute();



    if ($stmt->rowCount() > 0) {
        $stmt->setFetchMode(PDO::FETCH_ASSOC);
        $user = $stmt->fetchAll()[0];
        
        $_SESSION['user'] = $user;

        header('location: dashboard.php');

    } else
        $error_message = 'Please make sure that email and password are correct.';


}

?>





<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Cream&Cakes Login</title>
</head>

<body id="form-box">
    <?php if (!empty($error_message)) { ?>
        <div id="errorMessage">
            <strong>Error:</strong> </p>
            <?= $error_message ?>
            </p>
        </div>
    <?php } ?>
    <section>
        <div class="form-box">
            <div class="form-value">
                <form action="login.php" method="POST">
                    <h2>Cream&Cakes</h2>
                    <div class="inputbox">
                        <ion-icon name="mail-outline"></ion-icon>
                        <input type="text"  name="email" required>
                        <label for="">Email</label>
                    </div>
                    <div class="inputbox">
                        <ion-icon name="lock-closed-outline" id="lc"></ion-icon>
                        <input type="password"  name="password" id="password" required>
                        <label for="">Password</label>
                    </div>


                    <div class="forget">
                    <label for=""><a href="forgotpass.php">Forgot Password?</a></label>

                    </div>
                    <button>Log in</button>
                   
                    <div class="sendbtn"></div>
                    <button onclick="location.href='index.php'" class="hb">Back</button>
                </form>
            </div>
        </div>
    </section>

    <script>
        let lc = document.getElementById("lc");
        let password = document.getElementById("password");

        lc.onclick = function(){
            if(password.type == "password"){
                password.type = "text";
                

            }else{
                password.type = "password";
                
            }
        }
    </script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>

</html>