<?php

session_start();
if (!isset($_SESSION['user']))
    header('location: login.php');
$_SESSION['table'] = 'users';
$user = $_SESSION['user'];
$show_table = 'users';
$users = include('database/su.php');


?>
<!DOCTYPE html>
<html>

<head>
    <title>View Users of C&C</title>
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
                            <h1 class="sh"><ion-icon name="list-outline"></ion-icon>List of Users</h1>
                            <div class="sc">
                                <div class="users">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>First Name</th>
                                                <th>Last Name</th>
                                                <th>Email</th>
                                                <th>Created At</th>
                                                <th>Updated At</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            foreach ($users as $index => $user) { ?>
                                                <tr>
                                                    <td>
                                                        <?= $index + 1 ?>
                                                    </td>
                                                    <td class="fn">
                                                        <?= $user['first_name'] ?>
                                                    </td>
                                                    <td class="ln">
                                                        <?= $user['last_name'] ?>
                                                    </td>
                                                    <td class="em">
                                                        <?= $user['email'] ?>
                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($user['created_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <?= date('M d,Y/h:i:s A', strtotime($user['updated_at'])) ?>
                                                    </td>
                                                    <td>
                                                        <a href="" class="updateUser" data-userid="<?= $user['id'] ?>">
                                                            <ion-icon name="pencil-outline"></ion-icon>Edit</a>
                                                        <a href="" class="du" data-userid="<?= $user['id'] ?>"
                                                            data-fname="<?= $user['first_name'] ?>"
                                                            data-lname="<?= $user['last_name'] ?>"><ion-icon
                                                                name="trash-outline"></ion-icon>Delete</a>
                                                    </td>
                                                </tr>
                                            <?php } ?>

                                        </tbody>

                                    </table>
                                    <p class="uc">
                                        <?= count($users) ?> Users of Cream&Cakes System
                                    </p>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include('ps/appScripts.php'); ?>

    <script>
        function script() {

            this.initialize = function () {
                this.registerEvents();
            },

                this.registerEvents = function () {
                    document.addEventListener('click', function (e) {
                        targetElement = e.target;
                        classList = targetElement.classList;

                        if (classList.contains('du')) {
                            e.preventDefault();
                            userId = targetElement.dataset.userid;
                            fname = targetElement.dataset.fname;
                            lname = targetElement.dataset.lname;
                            fullName = fname + ' ' + lname;

                            BootstrapDialog.confirm({
                                type: BootstrapDialog.TYPE_DANGER,
                                message: 'Are you sure to delete ' + fullName + '?',
                                callback: function (isDelete) {
                                    if(isDelete){

                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                                user_id: userId,
                                                f_name: fname,
                                                l_name: lname
    
                                            },
                                            url: 'database/del.php',
                                            dataType: 'json',
                                            success: function (data) {
                                                console.log(data)
                                                if (data.success) {
                                                    BootstrapDialog.alert({
                                                        type: BootstrapDialog.TYPE_SUCCESS,
                                                        message: data.message,
                                                        callback: function () {
                                                            location.reload();
                                                        }
                                                    });
    
    
    
                                                } else
                                                    BootstrapDialog.alert({
                                                        type: BootstrapDialog.TYPE_DANGER,
                                                        message: data.message,
    
                                                    });
                                            }
                                        });
                                    }
                                }
                            })

                        }

                        if (classList.contains('updateUser')) {
                            e.preventDefault();

                            fn = targetElement.closest('tr').querySelector('td.fn').innerText;
                            ln = targetElement.closest('tr').querySelector('td.ln').innerText;
                            em = targetElement.closest('tr').querySelector('td.em').innerText;
                            userId = targetElement.dataset.userid;

                            BootstrapDialog.confirm({
                                title: 'Update: ' + fn + ' ' + ln,
                                message: '<form>\
                                <div class="form-group">\
                                <label for="fn">First Name:</label>\
                                <input type ="text" class="form-control" id="fn" value="'+ fn + '">\
                                </div>\
                                <div class="form-group">\
                                <label for="ln">Last Name:</label>\
                                <input type ="text" class="form-control" id="ln" value="'+ ln + '">\
                                </div>\
                                <div class="form-group">\
                                <label for="em">Email Address:</label>\
                                <input type = "em" class="form-control" id="em" value="'+ em + '">\
                                </div>\
                                </form>',
                                callback: function (isUpdate) {
                                    if (isUpdate) {
                                        $.ajax({
                                            method: 'POST',
                                            data: {
                                                userId: userId,
                                                f_name: document.getElementById('fn').value,
                                                l_name: document.getElementById('ln').value,
                                                email: document.getElementById('em').value,
                                            },
                                            url: 'database/update.php',
                                            dataType: 'json',
                                            success: function (data) {
                                                if (data.success) {
                                                    BootstrapDialog.alert({
                                                        type: BootstrapDialog.TYPE_SUCCESS,
                                                        message: data.message,
                                                        callback: function () {
                                                            location.reload();
                                                        }
                                                    });



                                                } else
                                                    BootstrapDialog.alert({
                                                        type: BootstrapDialog.TYPE_DANGER,
                                                        message: data.message,

                                                    });
                                            }
                                        });

                                    }
                                }

                            });

                        }


                    });
                }
        }
    

        var script = new script;
        script.initialize();
    </script>
</body>

</html>