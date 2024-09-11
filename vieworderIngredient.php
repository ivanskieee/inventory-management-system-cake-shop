<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$show_table = 'suppliers';
$suppliers = include('database/show.php');



?>
<!DOCTYPE html>
<html>

<head>
    <title>View Orders of C&C</title>
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
                            <h1 class="sh"><ion-icon name="list-outline"></ion-icon>List of Orders</h1>
                            <div class="sc">
                                <div class="ioListCont">
                                    <?php
                                        $stmt = $conn->prepare("SELECT products.product_name, order_product.quantity_ordered, users.first_name, users.last_name, order_product.batch, suppliers.supplier_name, order_product.status, order_product.created_at 
                                        FROM order_product, suppliers, products, users 
                                        WHERE order_product.supplier = suppliers.id 
                                        AND 
                                              order_product.product = products.id 
                                        AND   
                                              order_product.created_by = users.id 
                                        ORDER BY
                                              order_product.created_at DESC
                                              ");
                                        $stmt->execute();
                                        $purchase_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                        $data = [];
                                        foreach($purchase_orders as $purchase_order){
                                            $data[$purchase_order['batch']][] = $purchase_order;

                                        }
                                    ?>
                                        <?php
                                            foreach($data as $batch_id => $batch_pos){

                                            
                                        ?>
                                    <div class="ioList">
                                        <p>Batch #: <?= $batch_id ?> </p>
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Ingredient</th>
                                                <th>Qty Ordered</th>
                                                <th>Supplier</th>
                                                <th>Status</th>
                                                <th>Ordered By</th>
                                                <th>Created Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                foreach($batch_pos as $index => $batch_po) {

                                                
                                            ?>
                                        <tr>
                                                <td><?= $index + 1 ?></td>
                                                <td><?= $batch_po['product_name'] ?></td>
                                                <td><?= $batch_po['quantity_ordered'] ?></td>
                                                <td><?= $batch_po['supplier_name'] ?></td>
                                                <td><span class="orderStyle <?=$batch_po['status'] ?>"><?= $batch_po['status'] ?></span></td>
                                                <td><?= $batch_po['first_name'] .'  '. $batch_po['last_name'] ?></td>
                                                <td><?= $batch_po['created_at'] ?></td>
                                        </tr>
                                        <?php } ?>        
                                        
                                        </tbody>        
                                        </table>
                                        <!-- <div class="ioOrderUpdtbtncont alignR">
                                            <button class="appbtn updateiobtn">Delete</button>
                                        </div> -->
                                        </div>

                                        <?php } ?>
                                    
                                    </div>
                                       
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <?php 
    
    include('ps/appScripts.php'); 
    
    $show_table = 'products';
    $products = include('database/show.php');

    $products_arr = [];

    foreach ($products as $product) {
        $products_arr[$product['id']] = $product['product_name'];
    }

    $products_arr = json_encode($products_arr);

    ?>

    <script>
        var productsList = <?= $products_arr ?>;


        function script() {

                var vm = this;
           
                this.registerEvents = function () {
                    document.addEventListener('click', function (e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

                        if (classList.contains('deleteSupplier')) {
                            e.preventDefault();
                            sId = targetElement.dataset.sid;
                            supplierName = targetElement.dataset.name;
                            

                            BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Delete Brand',
                                message: 'Are you sure to delete <strong>' + supplierName + '</strong>?',
                                callback: function (isDelete) {
                                    if(isDelete){

                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                               id: sId,
                                               table: 'suppliers'
    
                                            },
                                            url: 'database/delProd.php',
                                            dataType: 'json',
                                            success: function (data) {
                                                message = data.success ?
                                                supplierName + ' successfully deleted!' : 'Error processing your request!';
                                        
                                                    BootstrapDialog.alert({
                                                        type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                        message: message,
                                                        callback: function () {
                                                            if (data.success) location.reload();
                                                        }
                                                    });
                                            }
                                        });
                                    }
                                }
                            })

                        }

                        if(classList.contains('updateSupplier')){
                            e.preventDefault();

                            sId = targetElement.dataset.sid;

                            vm.showEditDialog(sId);




                            
                           

                        }

                    });
                    
                   document.addEventListener('submit', function(e){
                        e.preventDefault();
                        targetElement = e.target;

                        if(targetElement.id === 'editSupplierForm'){
                           vm.saveUpdateData(targetElement);
                        }
                   })

                },
                this.saveUpdateData = function(form){


                   
                                                    $.ajax({
                                                    method: 'POST',
                                                    data: {
                                                        supplier_name: document.getElementById('supplier_name').value,
                                                        supplier_location: document.getElementById('supplier_location').value,
                                                        email: document.getElementById('email').value,
                                                        products: $('#products').val(),
                                                        sid: document.getElementById('sid').value
                                                    },
                                                    url: 'database/updateSupp.php',
                                                    dataType: 'Json',
                                                    success: function (data) {
                                                        BootstrapDialog.alert({
                                                            type: data.success ? BootstrapDialog.TYPE_SUCCESS : BootstrapDialog.TYPE_DANGER,
                                                            message: data.message,
                                                            callback:function (){
                                                                if(data.success)location.reload();
                                                            }
                                                        });
                                                       
                                                    }
                                                });
                    },

                this.showEditDialog = function(id){
                    $.get('database/get-supplier.php', {id: id}, function(supplierDetails){

                        let curProducts = supplierDetails['products'];
                        let productOptions = '';

                        for(const [pId, pName] of Object.entries(productsList)) {
                            selected = curProducts.indexOf(pId) > -1 ? 'selected' : '';
                            productOptions += "<option "+ selected +" value='"+ pId +"'>"+ pName +"</option>";
                            
                        }


                        BootstrapDialog.confirm({
                                title: 'Update: <strong>' + supplierDetails.supplier_name + '</strong>',
                                message: '<form action="database/au.php" method="POST" enctype="multipart/form-data" id="editSupplierForm">\ <div class="aforminputcont">\
                                        <label for="supplier_name">Brand Name</label>\
                                        <input type="text" class="aforminput" id="supplier_name"\
                                            value="'+ supplierDetails.supplier_name +'" placeholder="Enter supplier name..." name="supplier_name" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="supplier_location">Brand Shop</label>\
                                        <input type="text" class="aforminput" id="supplier_location"\
                                            value="'+ supplierDetails.supplier_location +'" placeholder="Enter supplier location..." name="supplier_location" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="email">Brand Price</label>\
                                        <textarea class="aforminput prodtext" id="email"\
                                            placeholder="Enter suppliers email..." name="email"\
                                            required> '+ supplierDetails.email +'</textarea>\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="products">Ingredients</label>\
                                        <select name="products[]"  id="products" multiple="">\
                                            <option value="">Select Products</option>\
                                            '+ productOptions +'\
                                        </select>\
                                    </div>\
                                    <input type="hidden" name="sid" id="sid" value="'+ supplierDetails.id +'" />\
                                    <input type="submit"value="submit" id="editSupplierSubmitBtn" class="hidden" />\
                                    </form>\
                                ',   
                                   
                                
                                callback: function (isUpdate) {
                                    if (isUpdate) {

                                        document.getElementById('editSupplierSubmitBtn').click();
                                        
                                      

                                    }
                                }

                            });

                    }, 'json');

                   
                }



                this.initialize = function(){
                    this.registerEvents();
                }
        }
    

        var script = new script;
        script.initialize();
    </script>
</body>

</html>