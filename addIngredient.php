<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'products';
$_SESSION['redirect_to'] = 'addIngredient.php';
$user = $_SESSION['user'];


?>
<!DOCTYPE html>
<html>

<head>

    <title>Add Ingredient of C&C</title>
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
                            <h1 class="sh"><ion-icon name="add-outline"></ion-icon>Create Ingredient</h1>
                            <div id="userAFC">
                                <form action="database/au.php" method="POST" class="aform"
                                    enctype="multipart/form-data">
                                    <div class="aforminputcont">
                                        <label for="product_name">Ingredient Name</label>
                                        <input type="text" class="aforminput" id="product_name"
                                            placeholder="Enter ingredient name..." name="product_name" required />
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="img">Ingredient Image</label>
                                        <input type="file" name="img" />
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="price">Price</label>
                                        <input type="text" class="aforminput" id="price"
                                            placeholder="Enter ingredient price..." name="price" required />
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="description">Description</label>
                                        <textarea class="aforminput prodtext" id="description"
                                            placeholder="Enter ingredient description..." name="description"
                                            required></textarea>
                                    </div>
                                    <div class="aforminputcont">
                                        <label for="description">Brands</label>
                                        <select name="suppliers[]"  id="suppliersSel" multiple="">
                                            <option value="">Select Brands</option>
                                            <?php 
                                                $show_table = 'suppliers';
                                                $suppliers = include('database/show.php');

                                                foreach ($suppliers as $supplier) {
                                                    echo "<option value='". $supplier['id'] ."'>". $supplier['supplier_name']."</option>";
                                                }
                                            ?>
                                            
                                        </select>
                                    </div>  
                                    <button type="submit" class="aubtn"><ion-icon name="add-sharp"></ion-icon>Add
                                        Ingredient</button>
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