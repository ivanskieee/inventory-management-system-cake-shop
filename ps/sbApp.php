<?php
   $user = $_SESSION['user'];
?>

<div class="side" id="side">
    <h3 class="logo" id="logo">Cream&Cakes</h3>
    <div class="sUser">
        <img src="pics/logoo.jpg" alt="User image." id="UserImg" />
        <span>
            <?= $user['first_name'] . ' ' . $user['last_name'] ?>
        </span>
    </div>
    <div class="sMenus">
        <ul class="mlist">
            <!--class="menua" -->
            <li class="LMM">
                <a href="./dashboard.php"><ion-icon name="speedometer-outline"></ion-icon><span
                        class="menuT">Dashboard</span></a>
            </li>
            <li class="LMM">
                <a href="./reports.php"><ion-icon name="folder-outline"></ion-icon><span
                        class="menuT">Reports</span></a>
            </li>
            <li class="LMM showhidesm" >
                <a href="javascript:void(0);" class="showhidesm"><ion-icon name="person-add-outline" class="showhidesm"></ion-icon><span
                        class="menuT showhidesm">User</span>
                       <i class="fa fa-angle-left arup showhidesm"></i>
                    </a>

                        <ul class="subMenus">
                            <a class="sbl" href="./viewUser.php"><ion-icon name="ellipse-outline"></ion-icon> View Users</a>
                            <a class="sbl" href="./addUser.php"><ion-icon name="ellipse-outline"></ion-icon> Add User</a>
                        </ul>   
                       
            </li>
            <li class="LMM">
                        <a href="javascript:void(0);" class="showhidesm"><i class="fa fa-globe showhidesm"></i><span
                        class="menuT showhidesm">Brand</span>
                        <i class="fa fa-angle-left arup showhidesm"></i>
                    </a>

                        <ul class="subMenus">
                            <a class="sbl" href="./viewBrand.php"><ion-icon name="ellipse-outline"></ion-icon> View Brand</a>
                            <a class="sbl" href="./addBrand.php"><ion-icon name="ellipse-outline"></ion-icon> Add Brand</a>
                        </ul> 
                       
            </li>
            <li class="LMM">
                        <a href="javascript:void(0);" class="showhidesm"><i class="fa fa-shopping-cart showhidesm"></i><span
                        class="menuT showhidesm">Orders</span>
                        <i class="fa fa-angle-left arup showhidesm"></i>
                    </a>

                        <ul class="subMenus">
                            <a class="sbl" href="./vieworderIngredient.php"><ion-icon name="ellipse-outline"></ion-icon> View Orders</a>
                            <a class="sbl" href="./orderIngredient.php"><ion-icon name="ellipse-outline"></ion-icon> Create Order</a>
                        </ul> 
                       
            </li>
            <li class="LMM">
            <a href="javascript:void(0);" class="showhidesm"><i class="fa fa-list showhidesm"></i><span
                        class="menuT showhidesm">Ingredient</span>
                        <i class="fa fa-angle-left arup showhidesm"></i>
                    </a>

                        <ul class="subMenus">
                            <a class="sbl" href="./viewIngredient.php"><ion-icon name="ellipse-outline"></ion-icon> View Ingredient</a>
                            <a class="sbl" href="./addIngredient.php"><ion-icon name="ellipse-outline"></ion-icon> Add Ingredient</a>
                            
                        </ul> 
                       
            </li>
            <li class="LMM">
            <a href="javascript:void(0);" class="showhidesm"><i class="fa fa-tag showhidesm"></i><span
                        class="menuT showhidesm">Product</span>
                        <i class="fa fa-angle-left arup showhidesm"></i>
                    </a>

                        <ul class="subMenus">
                            <a class="sbl" href="./viewProduct.php"><ion-icon name="ellipse-outline"></ion-icon> View Product</a>
                            <a class="sbl" href="./addProduct.php"><ion-icon name="ellipse-outline"></ion-icon> Add Product</a>
                        </ul> 
                       
            </li>

        </ul>
    </div>
</div>