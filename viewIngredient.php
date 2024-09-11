<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$show_table = 'products';
$products = include('database/show.php');
$total_price = include('database/totaldata.php');
$paging = include('database/pagination.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>View Ingredient of C&C</title>
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
                            <h1 class="sh"><ion-icon name="list-outline"></ion-icon>List of Ingredients</h1>
                            <div class="sc">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Ingredient Name</th>
                                                <th>Price</th>
                                                <th width="15%">Description</th>
                                                <th width = "10%">Brands</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($products as $index => $product) 
                                            while($product=mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                    <td>
                                                        <?= $product ['id'] ?>
                                                    </td>
                                                    <td class="img">
                                                        <img class="pi" src="uploads/products/<?= $product['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="pName">
                                                        <?= $product['product_name'] ?>
                                                    </td>
                                                    <td class="prc">
                                                        <?= $product['price'] ?>
                                                    </td>
                                                    <td class="descp">
                                                        <?= $product['description'] ?>
                                                    </td>
                                                    <td class="descp">
                                                        <?php
                                                            $supplier_list = '-';
                                                            $pid = $product['id'];
                                                            $stmt = $conn->prepare("SELECT supplier_name FROM suppliers, productssuppliers WHERE productssuppliers.product=$pid AND productssuppliers.supplier = suppliers.id");
                                                            $stmt->execute();
                                                            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);

                                                            if($row){
                                                                $supplier_arr = array_column($row, 'supplier_name');
                                                                $supplier_list = '<li>' . implode("</li><li>", $supplier_arr);
                                                            }


                                                            echo $supplier_list;

                                                           
                                                        ?>
                                                    </td>
                                                    <td>

                                                        <?php
                                                            $uid = $product['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $created_by_name = $row['first_name'] .' '. $row['last_name'];
                                                            echo  $created_by_name;
                                                        ?>


                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($product['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($product['updated_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <a href="" class="updateProduct" data-pid="<?= $product['id'] ?>">
                                                            <ion-icon name="pencil-outline"></ion-icon>Edit</a> |

                                                        <a href="" class="deleteProduct" data-name="<?= $product['product_name'] ?>" data-pid="<?= $product['id'] ?>"><ion-icon
                                                                name="trash-outline"></ion-icon>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>

                                    </table>
                                    <p class="uc">
                                        <?= "{$total_price} total price / " . count($products) . " Ingredients of Cream&Cakes System"  ?>
                                    </p>
                                    
                                    <?php
                                    $pr_query = "select * from products ";
                                    $pr_result = mysqli_query($con,$pr_query);
                                    $total_record = mysqli_num_rows($pr_result );
                                    
                                    $total_page = ceil($total_record/$num_per_page);

                                    if($page>1)
                                    {
                                        echo "<a href='viewIngredient.php?page=".($page-1)."' class='btn btn-danger'>Previous</a>";
                                    }
                                    
                                    for($i=1;$i<$total_page;$i++)
                                    {
                                        echo "<a href='viewIngredient.php?page=".$i."' class='btn btn-primary'>$i</a>";
                                    }
                                    if($i>$page)
                                    {
                                        echo "<a href='viewIngredient.php?page=".($page+1)."' class='btn btn-danger'>Next</a>";
                                    }
                                    
                                    ?>

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
    
    $show_table = 'suppliers';
    $suppliers = include('database/show.php');

    $suppliers_arr = [];

    foreach ($suppliers as $supplier) {
        $suppliers_arr[$supplier['id']] = $supplier['supplier_name'];
    }

    $suppliers_arr = json_encode($suppliers_arr);

    ?>

    <script>
        var suppliersList = <?= $suppliers_arr ?>;


        function script() {

                var vm = this;
           
                this.registerEvents = function () {
                    document.addEventListener('click', function (e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

                        if (classList.contains('deleteProduct')) {
                            e.preventDefault();
                            pId = targetElement.dataset.pid;
                            pName = targetElement.dataset.name;
                            

                            BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_DANGER,
                                title: 'Delete Ingredient',
                                message: 'Are you sure to delete <strong>' + pName + '</strong>?',
                                callback: function (isDelete) {
                                    if(isDelete){

                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                               id: pId,
                                               table: 'products'
    
                                            },
                                            url: 'database/delProd.php',
                                            dataType: 'json',
                                            success: function (data) {
                                                message = data.success ?
                                                 pName + ' successfully deleted!' : 'Error processing your request!';
                                        
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

                        if(classList.contains('updateProduct')){
                            e.preventDefault();

                            pId = targetElement.dataset.pid;

                            vm.showEditDialog(pId);




                            
                           

                        }

                    });
                    
                   document.addEventListener('submit', function(e){
                        e.preventDefault();
                        targetElement = e.target;

                        if(targetElement.id === 'editProductForm'){
                           vm.saveUpdateData(targetElement);
                        }
                   })

                },
                this.saveUpdateData = function(form){


                   
                                                    $.ajax({
                                                    method: 'POST',
                                                    data: new FormData(form),
                                                    url: 'database/updateProd.php',
                                                    processData: false,
                                                    contentType: false,
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
                    $.get('database/get-product.php', {id: id}, function(productDetails){

                        let curSuppliers = productDetails['suppliers'];
                        let supplierOption = '';

                        for(const [supId, supName] of Object.entries(suppliersList)) {
                            selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                            supplierOption += "<option "+ selected +" value='"+ supId +"'>"+ supName +"</option>";
                            
                        }


                        BootstrapDialog.confirm({
                                title: 'Update: <strong>' + productDetails.product_name + '</strong>',
                                message: '<form action="database/au.php" method="POST" enctype="multipart/form-data" id="editProductForm">\ <div class="aforminputcont">\
                                        <label for="product_name">Ingredient Name</label>\
                                        <input type="text" class="aforminput" id="product_name"\
                                            value="'+ productDetails.product_name +'" placeholder="Enter ingredient name..." name="product_name" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="img">Ingredient Image</label>\
                                        <input type="file" name="img" />\
                                    </div>\
                                    <input type="hidden" name="pid" value="'+ productDetails.id +'" />\
                                    <div class="aforminputcont">\
                                        <label for="price">Price</label>\
                                        <input type="text" class="aforminput" id="price"\
                                            value="'+ productDetails.price +'" placeholder="Enter ingredient price..." name="price" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="description">Description</label>\
                                        <textarea class="aforminput prodtext" id="description"\
                                            placeholder="Enter ingredient description..." name="description"\
                                            required> '+ productDetails.description +'</textarea>\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="description">Brands</label>\
                                        <select name="suppliers[]"  id="suppliersSel" multiple="">\
                                            <option value="">Select Supplier</option>\
                                            '+ supplierOption +'\
                                        </select>\
                                    </div>\
                                    <input type="submit"value="submit" id="editProductSubmitBtn" class="hidden" />\
                                    </form>\
                                ',   
                                   
                                
                                callback: function (isUpdate) {
                                    if (isUpdate) {

                                        document.getElementById('editProductSubmitBtn').click();
                                        
                                      

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