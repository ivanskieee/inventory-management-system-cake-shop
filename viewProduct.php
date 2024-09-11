<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');

$show_table = 'productscake';
$productscake = include('database/show.php');
$total_price = include('database/prodcaketotal.php');
$paging = include('database/pagination2.php');

?>
<!DOCTYPE html>
<html>

<head>
    <title>View Product of C&C</title>
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
                            <h1 class="sh"><ion-icon name="list-outline"></ion-icon>List of Products</h1>
                            <div class="sc">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>ID</th>
                                                <th>Image</th>
                                                <th>Product Name</th>
                                                <th>Price</th>
                                                <th width="15%">Description</th>
                                                <th>Created By</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach($productscake as $index => $productcake) 
                                            while($productcake=mysqli_fetch_assoc($result)) { ?>
                                                    <tr>
                                                    <td>
                                                        <?= $productcake ['id'] ?>
                                                    </td>
                                                    <td class="img">
                                                        <img class="pi" src="uploads/products/<?= $productcake['img'] ?>" alt="" />
                                                    </td>
                                                    <td class="pName">
                                                        <?= $productcake['product_name'] ?>
                                                    </td>
                                                    <td class="prc">
                                                        <?= $productcake['price'] ?>
                                                    </td>
                                                    <td class="descp">
                                                        <?= $productcake['description'] ?>
                                                    </td>
                                                    
                                                    <td>

                                                        <?php
                                                            $uid = $productcake['created_by'];
                                                            $stmt = $conn->prepare("SELECT * FROM users WHERE id=$uid");
                                                            $stmt->execute();
                                                            $row = $stmt->fetch(PDO::FETCH_ASSOC);

                                                            $created_by_name = $row['first_name'] .' '. $row['last_name'];
                                                            echo  $created_by_name;
                                                        ?>


                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($productcake['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($productcake['updated_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <a href="" class="updateProduct" data-pid="<?= $productcake['id'] ?>">
                                                            <ion-icon name="pencil-outline"></ion-icon>Edit</a> |

                                                        <a href="" class="deleteProduct" data-name="<?= $productcake['product_name'] ?>" data-pid="<?= $productcake['id'] ?>"><ion-icon
                                                                name="trash-outline"></ion-icon>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>

                                    </table>
                                    <p class="uc">
                                        <?= "{$total_price} total price / " . count($productscake) . " Products of Cream&Cakes System"  ?>
                                    </p>
                                    
                                    <?php
                                    $pr_query = "select * from productscake ";
                                    $pr_result = mysqli_query($con,$pr_query);
                                    $total_record = mysqli_num_rows($pr_result );
                                    
                                    $total_page = ceil($total_record/$num_per_page);

                                    if($page>1)
                                    {
                                        echo "<a href='viewProduct.php?page=".($page-1)."' class='btn btn-danger'>Previous</a>";
                                    }
                                    
                                    for($i=1;$i<$total_page;$i++)
                                    {
                                        echo "<a href='viewProduct.php?page=".$i."' class='btn btn-primary'>$i</a>";
                                    }
                                    if($i>$page)
                                    {
                                        echo "<a href='viewProduct.php?page=".($page+1)."' class='btn btn-danger'>Next</a>";
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
                                title: 'Delete Product',
                                message: 'Are you sure to delete <strong>' + pName + '</strong>?',
                                callback: function (isDelete) {
                                    if(isDelete){

                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                               id: pId,
                                               table: 'productscake'
    
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
                                                    url: 'database/updateProdCake.php',
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
                    $.get('database/get-prodcake.php', {id: id}, function(productDetails){

                        let curSuppliers = productDetails['suppliers'];
                        let supplierOption = '';

                        for(const [supId, supName] of Object.entries(suppliersList)) {
                            selected = curSuppliers.indexOf(supId) > -1 ? 'selected' : '';
                            supplierOption += "<option "+ selected +" value='"+ supId +"'>"+ supName +"</option>";
                            
                        }


                        BootstrapDialog.confirm({
                                title: 'Update: <strong>' + productDetails.product_name + '</strong>',
                                message: '<form action="database/au.php" method="POST" enctype="multipart/form-data" id="editProductForm">\ <div class="aforminputcont">\
                                        <label for="product_name">Product Name</label>\
                                        <input type="text" class="aforminput" id="product_name"\
                                            value="'+ productDetails.product_name +'" placeholder="Enter product name..." name="product_name" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="img">Product Image</label>\
                                        <input type="file" name="img" />\
                                    </div>\
                                    <input type="hidden" name="pid" value="'+ productDetails.id +'" />\
                                    <div class="aforminputcont">\
                                        <label for="price">Price</label>\
                                        <input type="text" class="aforminput" id="price"\
                                            value="'+ productDetails.price +'" placeholder="Enter product price..." name="price" required />\
                                    </div>\
                                    <div class="aforminputcont">\
                                        <label for="description">Description</label>\
                                        <textarea class="aforminput prodtext" id="description"\
                                            placeholder="Enter product description..." name="description"\
                                            required> '+ productDetails.description +'</textarea>\
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