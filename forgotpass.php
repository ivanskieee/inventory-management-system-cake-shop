<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Forgot Password</title>
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
    <h2>Forgot Password</h2>


    <form method="post" action="sendpass.php">

    <div class="inputbox">
    <ion-icon name="mail-outline"></ion-icon>
        <input type="text" name="email" required>
        <label for="">email</label>
    </div>

    
        <button class="">Send</button>
        
        <div class="sendbtn"></div>
        <button onclick="location.href='login.php'" class="hb">Back</button>

    </form>

</div>
</div>
    </section>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
</body>
</html>