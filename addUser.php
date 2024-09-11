<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';
$_SESSION['redirect_to'] = 'addUser.php';

$show_table = 'users';
$users = include('database/show.php');


?>
<!DOCTYPE html>
<html>

<head>
   
    <title>Add Users of C&C</title>
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
                            <h1 class="sh"><ion-icon name="add-outline"></ion-icon>Create User</h1>
                            <div id="userAFC">
                                <form action="database/au.php" method="POST" class="aform">
                                    <div class="aforminputcont">
                                        <label for="first_name">First Name</label>
                                        <input type="text" class="aforminput" id="first_name" name="first_name" required/>
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="last_name">Last Name</label>
                                        <input type="text" class="aforminput" id="last_name" name="last_name" required/>
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="email">Email</label>
                                        <input type="email" class="aforminput" id="email" name="email" required/>
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="password">Password</label>
                                        <input type="password" class="aforminput" id="password" name="password" required/>
                                    </div>


                                    <button type="submit" class="aubtn"><ion-icon name="add-sharp"></ion-icon>Add
                                        User</button>
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