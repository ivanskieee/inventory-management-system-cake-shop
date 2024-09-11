<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$show_table = 'suppliers';
$suppliers = include('database/show.php');
$total_price = include('database/totaldata.php');


?>
<!DOCTYPE html>
<html>

<head>
    <title>View Brands of C&C</title>
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
                            <h1 class="sh"><ion-icon name="list-outline"></ion-icon>List of Brands</h1>
                            <div class="sc">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Brand Name</th>
                                                <th>Brand Shop</th>
                                                <th>Brand Price</th>
                                                <th>Ingredients</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($suppliers as $index => $supplier) { ?>
                                                <tr>
                                                    <td>
                                                        <?= $index + 1 ?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['supplier_name']?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['supplier_location']?>
                                                    </td>
                                                    <td>
                                                        <?= $supplier['email']?>
                                                    </td>
                                                    <td>
                                                        <?php
                                                            $product_list = '-';
                                                            $sid = $supplier['id'];
                                                            $stmt = $conn->prepare("SELECT product_name FROM products, productssuppliers WHERE productssuppliers.supplier=$sid AND productssuppliers.product = products.id");
                                                            $stmt->execute();
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if($row){
                                                                $product_arr = array_column($row, 'product_name');
                                                                $product_list = '<li>' . implode("</li><li>", $product_arr);
                                                            }


                                                            echo $product_list;

                                                           
                                                        ?>
                                                    </td>  
                                                     <td>
                                                        <?php
                                                            $uid = $supplier['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $created_by_name = $row['first_name'] .' '. $row['last_name'];
                                                            echo  $created_by_name;
                                                        ?>

                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($supplier['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($supplier['updated_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <a href="" class="updateSupplier" data-sid="<?= $supplier['id'] ?>">
                                                            <ion-icon name="pencil-outline"></ion-icon>Edit</a> |

                                                        <a href="" class="deleteSupplier" data-name="<?= $supplier['supplier_name'] ?>" data-sid="<?= $supplier['id'] ?>"><ion-icon
                                                                name="trash-outline"></ion-icon>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>

                                    </table>
                                    <p class="uc">
                                        <?= count($suppliers) ?> brands of Cream&Cakes System 
                                    </p>
                                    

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