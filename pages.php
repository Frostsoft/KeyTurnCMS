<?php include_once("init.php"); 

if(empty($_GET['p'])){
    header("Location: index.php?err=2");
    exit();
}

$stmt = $connection->prepare("SELECT title, description, keywords, lastedit FROM pages WHERE pagename = '" . $_GET['p'] . "'");
$stmt->execute();
if($stmt->rowCount() < 0){
    header("Location: index.php?err=2");
    exit();
}
$row = $stmt->fetch();
$page_title = $row['title'];
$page_desc = $row['description'];
$page_keywords = $row['keywords'];
$page_lastedit = $row['lastedit'];

$stmt = $connection->prepare("SELECT enabled FROM trackers WHERE page = '" . $_GET['p'] . "'");
$stmt->execute();
$tracker_enabled = $stmt->fetchColumn();

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
    <!-- chartist CSS -->
    <link href="assets/plugins/chartist-js/dist/chartist.min.css" rel="stylesheet">
    <link href="assets/plugins/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css" rel="stylesheet">
    <!--c3 CSS -->
    <link href="assets/plugins/c3-master/c3.min.css" rel="stylesheet">
    <!--Toaster Popup message CSS -->
    <link href="assets/plugins/toast-master/css/jquery.toast.css" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="css/style.css" rel="stylesheet">
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
                    <div class="col-md-8">
                        <div class="card ">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Page Overview</h4>
                            </div>
                            <div class="card-body">
                                <form action="actions.php?page=<?php echo $_GET['p']; ?>" class="form-horizontal" method="post">
                                    <div class="form-body">
                                        <h3 class="box-title">Settings</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Page Title</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="page_title"  value="<?php echo $page_title; ?>" placeholder="Website Title">
                                                        <small class="form-control-feedback"> This will set the page title that you see in your browser tab. </small> </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Page Description</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="page_description" value="<?php echo $page_desc; ?>" placeholder="A cool description...">
                                                        <small class="form-control-feedback"> This sets the page description that search engines will find </small> </div>
                                                </div>
                                            </div>
                                            <!--/span-->
                                            <div class="col-md-12">
                                                <div class="form-group row">
                                                    <label class="control-label text-right col-md-3">Page Keywords</label>
                                                    <div class="col-md-9">
                                                        <input type="text" class="form-control" name="page_keywords" value="<?php echo $page_keywords; ?>" placeholder="Technology,Computers,Entertainment">
                                                        <small class="form-control-feedback"> The keywords that represent your website content (Seperate keywords with commas)</small> </div>
                                                </div>
                                            </div>
                                            <div class="col-md-12">
                                            <div class="form-group row">
                                                <label class="control-label col-md-3"></label>
                                                <div class="col-md-9">
                                                    <div class="checkbox checkbox-success">
                                                        <input class="form-control" name="page_tracker" id="enable_tracker" type="checkbox"  <?php if($tracker_enabled == 1){echo "checked";}?>>
                                                        <label for="enable_tracker"> Enable View Tracker </label>
                                                    </div>
                                                </div>
                                            </div>
                                            </div>
                                            <!--/span-->
                                        </div>
                                    </div>
                                    <div class="form-actions">
                                        <div class="row">
                                            <div class="col-md-12">
                                                        <button type="submit" name="page_settings_save" class="btn btn-success pull-right">Save</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="card ">
                            <div class="card-header bg-info">
                                <h4 class="m-b-0 text-white">Page Editing</h4>
                            </div>
                            <div class="card-body">
                                <div class="form-body">
                                        <h3 class="box-title">Tools</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <div class="col-md-12">
                                                 <p>Last Modified: <?php echo $page_lastedit; ?></p> 
                                            </div>
                                            <!--/span-->
                                                <div class="col-md-6">
                                                        <a href="editor.php?p=<?php echo $_GET['p'];?>" class="btn btn-block btn-lg btn-primary">Edit</a>
                                                </div>
                                                <div class="col-md-6">
                                                        <a href="publish.php?p=<?php echo $_GET['p'];?>" class="btn btn-block btn-lg btn-success">Publish</a>
                                                </div>
                                        </div>

                                        <?php
                                        if($isDeveloper){
                                            echo'
                                        <br><br>
                                        <h3 class="box-title">Developer</h3>
                                        <hr class="m-t-0 m-b-40">
                                        <div class="row">
                                            <!--/span-->
                                                <div class="col-md-6">
                                                        <a href="codeeditor.php?p=' . $_GET['p'] . '&type=js&code=head" class="btn btn-block btn-lg btn-primary">Head</a>
                                                </div>
                                                <div class="col-md-6">
                                                        <a href="codeeditor.php?p=' . $_GET['p'] . '&type=js&code=sub" class="btn btn-block btn-lg btn-success">Sub</a>
                                                </div>
                                        </div>';
                                        }
                                        ?>


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
                                <li><b>Chat option</b></li>
                                <!--<li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/1.jpg" alt="user-img" class="img-circle"> <span>Varun Dhavan <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/2.jpg" alt="user-img" class="img-circle"> <span>Genelia Deshmukh <small class="text-warning">Away</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/3.jpg" alt="user-img" class="img-circle"> <span>Ritesh Deshmukh <small class="text-danger">Busy</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/4.jpg" alt="user-img" class="img-circle"> <span>Arijit Sinh <small class="text-muted">Offline</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/5.jpg" alt="user-img" class="img-circle"> <span>Govinda Star <small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/6.jpg" alt="user-img" class="img-circle"> <span>John Abraham<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/7.jpg" alt="user-img" class="img-circle"> <span>Hritik Roshan<small class="text-success">online</small></span></a>
                                </li>
                                <li>
                                    <a href="javascript:void(0)"><img src="assets/images/users/8.jpg" alt="user-img" class="img-circle"> <span>Pwandeep rajan <small class="text-success">online</small></span></a>
                                </li>-->
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
    <!--c3 JavaScript -->
    <script src="assets/plugins/d3/d3.min.js"></script>
    <script src="assets/plugins/c3-master/c3.min.js"></script>
    <!-- Popup message jquery -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <!-- Chart JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

        <?php
            if(isset($_GET['pub'])){
                echo "<script>";
                if($_GET['pub'] ==1){
                    echo "
                    $.toast({
                    heading: 'Page Published',
                    text: 'Your page has been successfully published.',
                    position: 'top-right',
                    loaderBg: '#4BB543',
                    icon: 'success',
                    hideAfter: 6000,
                    stack: 6
                    })";
                }
                echo "</script>";
            }else if(isset($_GET['saved'])){
                echo "<script>";
                if($_GET['saved'] ==1){
                    echo "
                    $.toast({
                    heading: 'Draft Saved',
                    text: 'Your page draft has been successfully saved, publish it to see it on the live website.',
                    position: 'top-right',
                    loaderBg: '#f33c49',
                    icon: 'info',
                    hideAfter: 6000,
                    stack: 6
                    })";
                }else if($_GET['saved'] ==2){
                    echo "
                    $.toast({
                    heading: 'Settings Saved',
                    text: 'Your page settings have been saved successfully.',
                    position: 'top-right',
                    loaderBg: '#4BB543',
                    icon: 'success',
                    hideAfter: 6000,
                    stack: 6
                    })";
                }
                echo "</script>";
            }
        ?>
</body>

</html>