<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.css">
    <title>Dashboard of C&C</title>
</head>

<body>
    <div id="dMaincont">
        <?php include('ps/sbApp.php') ?>
        <div class="dcontentcont" id="dcontentcont">
            <?php include('ps/tnavApp.php') ?>

            <div id="reportsCont">
                <div class="rtcont">
                    <div class="rt">
                        <p>Ingredients Report</p>
                        <div class="alignR">
                            <a href="database/rep-excl.php?report=ingredient" class="reportsBtn">Excel</a>
                            <a href="database/rep-pdf.php?report=ingredient" class="reportsBtn">PDF</a>
                        </div>
                    </div>
                    <div class="rt">
                        <p>Products Report</p>
                        <div class="alignR">
                            <a href="database/rep-excl.php?report=product" class="reportsBtn">Excel</a>
                            <a href="database/rep-pdf.php?report=product" class="reportsBtn">PDF</a>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
    <script src="JS/sc.js"></script>
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>
   
</body>

</html>