<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'suppliers';
$_SESSION['redirect_to'] = 'addBrand.php';
$user = $_SESSION['user'];


?>
<!DOCTYPE html>
<html>

<head>

    <title>Add Brand of C&C</title>
    <?php include('ps/appHeadersc.php'); ?>
</head>

<body>
    <div id="dMaincont">
        <?php include('ps/sbApp.php') ?>
        <div class="dcontentcont" id="dcontentcont">
            <?php include('ps/tnavApp.php') ?>

            <div class="dcontent">
                <div class="dcontentmain">
                    <div class="row">
                        <div class="col col-12">
                            <h1 class="sh"><ion-icon name="add-outline"></ion-icon>Create Brand</h1>
                            <div id="userAFC">
                                <form action="database/au.php" method="POST" class="aform"
                                    enctype="multipart/form-data">
                                    <div class="aforminputcont">
                                        <label for="supplier_name">Brand Name</label>
                                        <input type="text" class="aforminput" id="supplier_name"
                                            placeholder="Enter brand name..." name="supplier_name" required />
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="supplier_location">Shop</label>
                                        <input type="text"class="aforminput" name="supplier_location" id="supplier_location" placeholder="Enter brand shop..." required/>
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="email">Price</label>
                                        <input type="text" class="aforminput" id="email"
                                            placeholder="Enter brand price..." name="email" required />
                                    </div>
                                    <button type="submit" class="aubtn"><ion-icon name="add-sharp"></ion-icon>Add
                                        Brand</button>    
                                </form>
                                <?php
                                if (isset($_SESSION['response'])) {
                                    $response_message = $_SESSION['response']['message'];
                                    $is_success = $_SESSION['response']['success'];
                                    ?>
                                    <div class="responseMessage">
                                        <p
                                            class="responseMessage <?= $is_success ? 'reponseMessage_success' : 'responseMessage__error' ?>">
                                            <?= $response_message ?>
                                        </p>
                                    </div>
                                    <?php unset($_SESSION['response']);
                                } ?>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('ps/appScripts.php'); ?>
</body>
</html>