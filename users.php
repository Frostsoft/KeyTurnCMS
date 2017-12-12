<?php include_once("init.php"); 

if($user_level!=2){
    header("Location:index.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="KeyTurn CMS - Empower your website">
    <meta name="author" content="">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="assets/images/favicon.png">
    <title>KeyTurn CMS - Empower your website</title>
    <!-- Bootstrap Core CSS -->
    <link href="assets/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet">
    <!-- This page CSS -->
    <!--Toaster Popup message CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
    <link href="assets/plugins/sweetalert/sweetalert.css" rel="stylesheet" type="text/css">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
</head>

<body class="fix-header fix-sidebar card-no-border">
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    <div class="preloader">
        <div class="loader">
            <div class="loader__figure"></div>
            <p class="loader__label">KeyTurn CMS</p>
        </div>
    </div>
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->
    <div id="main-wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <?php include_once("inc/topbar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Topbar header -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <?php include_once("inc/leftbar.php"); ?>
        <!-- ============================================================== -->
        <!-- End Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Page wrapper  -->
        <!-- ============================================================== -->
        <div class="page-wrapper">
            <!-- ============================================================== -->
            <!-- Container fluid  -->
            <!-- ============================================================== -->
            <div class="container-fluid r-aside">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                
                
                <div class="row">
                    <div class="col-md-12">
                    <div class="card">
                    <div class="contact-page-aside">
                    <div class="right-aside ">
                                    <div class="right-page-header">
                                        <div class="d-flex">
                                            <div class="align-self-center">
                                                <h4 class="card-title m-t-10" style="padding-left:25px; padding-top:10px;">Users </h4></div>
                                            <div class="ml-auto"></div>
                                        </div>
                                    </div>
                                    <div class="table-responsive">
                                        <table id="demo-foo-addrow" class="table m-t-30 table-hover no-wrap contact-list" data-page-size="10">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Name</th>
                                                    <th>Role</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    $count = 0;

                                                    $stmt = $connection->prepare("SELECT username, userlevel FROM users");
                                                    $stmt->execute();
                                                    
                                                    while($row = $stmt->fetch(PDO::FETCH_ASSOC)){
                                                        echo "<tr>";
                                                        $count++;
                                                        if($row['userlevel']==0){
                                                            $level= '<td><span class="label label-success">Editor</span> </td>';
                                                        }elseif($row['userlevel']==1){
                                                            $level= '<td><span class="label label-info">Manager</span> </td>';
                                                        }elseif($row['userlevel']==2){
                                                            $level= '<td><span class="label label-danger">Administrator</span> </td>';
                                                        }
                                                        echo '<tr><td>' . $count . '</td>
                                                        <td>
                                                            <a href="app-contact-detail.html"><img src="assets/images/users/default-profile.png" alt="user" id="usersname" class="img-circle" style="width:40px; height:40px;" />' . $row['username'] . '</a>
                                                        </td>' . $level;
                                                        
                                                        if($row['username'] != $_SESSION['user']){
                                                        echo '<td>
                                                            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn edit_user_btn" data-toggle="modal" data-target="#edit-user"><i class="ti-pencil" aria-hidden="true"></i></button>
                                                            <button type="button" class="btn btn-sm btn-icon btn-pure btn-outline delete-row-btn" data-toggle="tooltip" data-original-title="Delete" name="sa-warning"><i class="ti-close" aria-hidden="true"></i></button>
                                                        </td>';
                                                        }else{
                                                            echo "<td></td>";
                                                        }

                                                        echo "</tr>";
                                                    }
                                                ?>
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td colspan="2">
                                                        <button type="button" class="btn btn-info btn-rounded" data-toggle="modal" data-target="#add-contact">Add New User</button>
                                                    </td>
                                                    <div id="add-contact" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Add New User</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="userhandler.php" method="post" class="form-horizontal form-material">
                                                                        <div class="form-group">
                                                                            <div class="col-md-12 m-b-20">
                                                                                <input type="text" class="form-control" name="new_name" placeholder="Username"> </div>
                                                                            <div class="col-md-12 m-b-20">
                                                                                <input type="text" class="form-control" name="new_pass" placeholder="Password"> </div>
                                                                                <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">User Role</label>
                                                                                <div class="col-md-9">
                                                                                    <select class="form-control custom-select" name="new_level">
                                                                                        <option value="Editor">Editor</option>
                                                                                        <option value="Manager">Manager</option>
                                                                                        <option value="Administrator">Administrator</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-12 m-b-20">
                                                                                <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                                    <input type="file" class="upload"> </div>
                                                                            </div>-->
                                                                        </div>
                                                                        
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-info waves-effect" name="create_user">Add</button>
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                    </div>
                                                        <div id="edit-user" class="modal fade in" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h4 class="modal-title" id="myModalLabel">Edit User</h4>
                                                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="userhandler.php" method="post" class="form-horizontal form-material">
                                                                        <div class="form-group">
                                                                            <input type="hidden" class="form-control" id="change_name" name="change_name" value="">
                                                                            <div class="col-md-12 m-b-20">
                                                                                <input type="text" class="form-control" name="change_pass" placeholder="Password"> </div>
                                                                                <div class="form-group row">
                                                                                <label class="control-label text-right col-md-3">User Role</label>
                                                                                <div class="col-md-9">
                                                                                    <select class="form-control custom-select" name="change_level">
                                                                                        <option value="Editor">Editor</option>
                                                                                        <option value="Manager">Manager</option>
                                                                                        <option value="Administrator">Administrator</option>
                                                                                    </select>
                                                                                </div>
                                                                            </div>
                                                                            <!--<div class="col-md-12 m-b-20">
                                                                                <div class="fileupload btn btn-danger btn-rounded waves-effect waves-light"><span><i class="ion-upload m-r-5"></i>Upload Contact Image</span>
                                                                                    <input type="file" class="upload"> </div>
                                                                            </div>-->
                                                                        </div>
                                                                        
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-info waves-effect" name="change_user">Change</button>
                                                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Cancel</button>
                                                                </div>
                                                                </form>
                                                                </div>
                                                            </div>
                                                            <!-- /.modal-content -->
                                                        </div>
                                                        <!-- /.modal-dialog -->
                                                        </div>
                                                    </div>
                                                    <td colspan="7">
                                                        <div class="text-right">
                                                            <ul class="pagination"> </ul>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>
                                    </div>
                            </div>
                    </div>
                    </div>
                    </div>
                    </div>


                <!-- ============================================================== -->
                <!-- End Page Content -->
                <!-- ============================================================== -->
                <!-- ============================================================== -->
                <!-- Right sidebar -->
                <!-- ============================================================== -->
                <!-- .right-sidebar -->
                <div class="right-sidebar">
                    <div class="slimscrollright">
                        <div class="rpanel-title"> Service Panel <span><i class="ti-close right-side-toggle"></i></span> </div>
                        <div class="r-panel-body">
                            <ul id="themecolors" class="m-t-20">
                                <li><b>With Light sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default" class="default-theme working">1</a></li>
                                <li><a href="javascript:void(0)" data-theme="green" class="green-theme">2</a></li>
                                <li><a href="javascript:void(0)" data-theme="red" class="red-theme">3</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue" class="blue-theme">4</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple" class="purple-theme">5</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna" class="megna-theme">6</a></li>
                                <li class="d-block m-t-30"><b>With Dark sidebar</b></li>
                                <li><a href="javascript:void(0)" data-theme="default-dark" class="default-dark-theme">7</a></li>
                                <li><a href="javascript:void(0)" data-theme="green-dark" class="green-dark-theme">8</a></li>
                                <li><a href="javascript:void(0)" data-theme="red-dark" class="red-dark-theme">9</a></li>
                                <li><a href="javascript:void(0)" data-theme="blue-dark" class="blue-dark-theme">10</a></li>
                                <li><a href="javascript:void(0)" data-theme="purple-dark" class="purple-dark-theme">11</a></li>
                                <li><a href="javascript:void(0)" data-theme="megna-dark" class="megna-dark-theme ">12</a></li>
                            </ul>
                            <ul class="m-t-20 chatonline">
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- End Right sidebar -->
                <!-- ============================================================== -->
            </div>
            <!-- ============================================================== -->
            <!-- End Container fluid  -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <footer class="footer"> © 2017 KeyTurn Media</footer>
            <!-- ============================================================== -->
            <!-- End footer -->
            <!-- ============================================================== -->
        </div>
        <!-- ============================================================== -->
        <!-- End Page wrapper  -->
        <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="assets/plugins/jquery/jquery.min.js"></script>
    <!-- Bootstrap popper Core JavaScript -->
    <script src="assets/plugins/bootstrap/js/popper.min.js"></script>
    <script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
    <!-- slimscrollbar scrollbar JavaScript -->
    <script src="js/perfect-scrollbar.jquery.min.js"></script>
    <!--Wave Effects -->
    <script src="js/waves.js"></script>
    <!--Menu sidebar -->
    <script src="js/sidebarmenu.js"></script>
    <!--Custom JavaScript -->
    <script src="js/custom.min.js"></script>
    <!-- ============================================================== -->
    <!-- This page plugins -->
    <!-- ============================================================== -->
    <!--sparkline JavaScript -->
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!--morris JavaScript -->
    <script src="assets/plugins/chartist-js/dist/chartist.min.js"></script>
    <!-- Popup message jquery -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
    <script src="assets/plugins/sweetalert/sweetalert.min.js"></script>
    <script src="assets/plugins/sweetalert/jquery.sweet-alert.custom.js?v=7"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script>
        $(".edit_user_btn").on('click', function(){

            $("#change_name").attr("value", $(this).parent().parent().find("a").text());

        });
    </script>
</body>

</html>