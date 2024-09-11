<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$show_table = 'products';
$products = include('database/show.php');
$products = json_encode($products);

?>
<!DOCTYPE html>
<html>

<head>

    <title>Order Ingredient of C&C</title>
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
                            <h1 class="sh"><ion-icon name="add-outline"></ion-icon>Order Ingredient</h1>
                            <div>
                                <form action="database/orderSave.php" method="POST">
                                    <div class="alignR">
                                        <button type="button" class="orderProductbtn orderProductbtn" id="orderProductbtn">Add Another Ingredient</button>
                                    </div>
                                    <div id= "orderprodlist">
                                        <p id="noData" style="color: #9f9f9f;">No ingredient selected.</p>
                        
                                    </div>
                                    <div class="alignR margTop">
                                        <button type="submit" class="orderProductbtn submitOrderProductbtn">Submit Order</button>
                                    </div>
                                </form>
                               
                               
                            </div>
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
    <?php include('ps/appScripts.php'); ?>

    <script>
        var products = <?= $products ?>;
        var counter = 0;

        function script(){
            var vm = this;

            let productOptions = '\
            <div>\
            <label for="product_name">INGREDIENT NAME</label>\
            <select name="products[]" id="productNameSelect" class="productNameSelect">\
            <option value="">Select Ingredient</option>\
            INSERTPRODUCTHERE\
            </select>\
            <button class="appbtn removeOrderBtn">Remove</button>\
        </div>';

                               

            this.initialize = function(){
                this.registerEvents();
                this.renderProductOptions();
            },

            this.renderProductOptions = function(){
                let optionHtml = '';
                products.forEach((product) => {
                    optionHtml += '<option value="'+ product.id+ '">'+ product.product_name +'</option>';

                })

                productOptions = productOptions.replace('INSERTPRODUCTHERE', optionHtml);
            },

            this.registerEvents = function(){

                    document.addEventListener('click', function(e){
                        targetElement = e.target;
                        classList = targetElement.classList;



                        if(targetElement.id === 'orderProductbtn'){
                        document.getElementById('noData').style.display = 'none';
                        let orderprodlistContainer = document.getElementById('orderprodlist');
                        

                        orderprodlist.innerHTML += '\
                        <div class="orderProductRow">\
                        '+ productOptions +'\
                         <div class="suppRows" id="suppRows_'+ counter +'" data-counter="'+ counter +'"></div>\
                        </div>';


                        counter++;

                        }

                        if(targetElement.classList.contains('removeOrderBtn')){
                            let orderRow = targetElement.closest('div.orderProductRow');
                            orderRow.remove();
                        }
                    });

                    document.addEventListener('change', function(e){
                        targetElement = e.target;
                        classList = targetElement.classList;


                        if(classList.contains('productNameSelect')){
                            let pid = targetElement.value;

                            let counterId = targetElement.closest('div.orderProductRow').querySelector('.suppRows').dataset.counter;


                            

                                $.get('database/get-prod-supp.php', {id: pid}, function(suppliers){
                                    vm.renderSuppRows(suppliers, counterId);
                                }, 'json')
                            
                        
                    }
                       
                    });

                    
            },
            this.renderSuppRows = function(suppliers, counterId){

                    let supplierRows = '';

                    suppliers.forEach((supplier) => {
                    supplierRows += '\
                    <div class="row">\
                    <div style="width: 50%;">\
                    <p class="supplierName">'+ supplier.supplier_name +'</p>\
                    </div>\  <div style="width: 50%;">\
                    <label for="quantity">Quantity: </label>\
                    <input type="number" class="aforminput orderProdqty" id="quantity"\
                    placeholder="Enter quantity..." name="quantity['+ counterId +']['+ supplier.id +']" required />\
                    </div>\
                    </div>';

                    });

                    let suppRowCont = document.getElementById('suppRows_' + counterId);
                    suppRowCont.innerHTML = supplierRows;
                  
            }
        }

        (new script()).initialize();
    </script>
</body>
</html>