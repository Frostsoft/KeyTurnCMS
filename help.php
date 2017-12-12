<?php include_once("init.php"); ?>

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
                <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-themecolor">Help Articles</h3>
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">KeyTurnCMS</a></li>
                        <li class="breadcrumb-item">Help</li>
                    </ol>
                </div>
                <div>
                    <button class="right-side-toggle waves-effect waves-light btn-inverse btn btn-circle btn-sm pull-right m-l-10"><i class="ti-settings text-white"></i></button>
                </div>
            </div>
                <!-- ============================================================== -->
                <!-- End Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                
                <div class="row">
                    <div class="col-lg-3 col-xlg-2 col-md-4">
                        <div class="stickyside">
                            <div class="list-group" id="top-menu">
                                <a href="#1" class="list-group-item active">The Dashboard</a>
                                <a href="#22" class="list-group-item">Pages</a>
                                <a href="#3" class="list-group-item">Images</a>
                                <a href="#4" class="list-group-item">Menu / Footer</a>
                                <a href="#5" class="list-group-item">Users</a>
                                <a href="#6" class="list-group-item">Settings</a>
                                <a href="#7" class="list-group-item">Page Editing</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-9 col-xlg-10 col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title" id="1">The Dashboard</h4>
                                <p>The dashboard will be the first screen you see on any login. Currently the dashboard only shows page statistics and view analytics. The Dashboard also has a sidebar on the right that displays useful data and update information. The dashboard is under a lot of development currently and will display more data and relevant information in the future.</p>
                                <br><br><br>
                                <h4 class="card-title m-t-40" id="22">Pages</h4>
                                <p>All pages are managed under the “pages” tab on the left menu bar. You have the option to modify the page title, page description, and page keywords. The page description should be a short explanation of what your website or company offers. This text will not be displayed on the website, it’s hidden in a meta tag that search engines can read. Likewise, the keywords will not be visible to a user visiting your website. However, they are crucial to your pages search engine rankings, and should only include relevant words associated with your website or company's purpose. The “Enable Tracker” checkbox at the bottom will enable or disable view tracking for that specific page. Remember to click the save button after making any changes to the page’s settings.</p>
                                <p>You will also have the option to edit page content via a button on the right labeled: “Edit”. More information on the editor can be found in the “Page Editor” section. The button to the right of it labeled “Publish” will publish the page edits to the live website.</p>
                                <h4 class="card-title m-t-40" id="3">Images</h4>
                                <p>The images page is where you can manage all images on your website. To upload an image either click on the “Drop files here to upload” box, or drag and drop your image file into the dotted line box. After selecting or dropping an image you’ll see its upload status inside the dotted line box. Do note, that it is highly recommended to optimize images before uploading them. To do this, either bring down the resolution of giant photos or run them through an image optimizer; many of these can be found online.</p>
                                <p>All uploaded images will be found under the “Your Images” section. From here you can see which images are already available to add to your website via the editor, you can also delete images by clicking the garbage can in the top right corner. (Editors cannot delete images)</p>
                                <h4 class="card-title m-t-40" id="4">Menu / Footer</h4>
                                <p>The menu / footer page will allow you to edit the menu (The bar at the top of your website, used for navigation) and the footer (The bar at the bottom of your website that may contain company contact or copyright information). The CMS allows for the homepage to have an independant menu bar, remember any changes you do to the sub page menu will not be applied to the homepage menu. This system is used since some websites require separate navigation styles for their landing pages. If you do not have this enabled, you’ll see only one menu editing option.</p>
                                <p>Clicking edit on the respective element will bring you to the editor software. From here it’s like editing any other page (See more about the editor in the “Page Editor” section). Like pages, clicking “publish” will publish the respective element to the live website.</p>
                                <h4 class="card-title m-t-40" id="5">Users</h4>
                                <p>The KeyTurn CMS software offers companies to have multiple users to be created, allowing multiple people to edit pages. All users log in the same way through the login screen. There are three levels of users, with different privileges (Each level inherits the privileges below it):</p>
                                <ol>
                                    <li>Administrator
                                        <ul>
                                            <li>Add, Delete, Modify Users</li>
                                            <li>Update CMS Software</li>
                                        </ul>
                                    </li>
                                    <li>Manager
                                        <ul>
                                            <li>Publish Pages and Menu/Footer</li>
                                            <li>Change CMS Settings</li>
                                            <li>Delete Images</li>
                                        </ul>
                                    </li>
                                    <li>Editor
                                        <ul>
                                            <li>Upload Images</li>
                                            <li>Edit Pages and Menu/Footer</li>
                                            <li>Change Page Settings</li>
                                        </ul>
                                    </li>
                                </ol>
                                <p>To add a user click the “Add User” button at the bottom of the user table. To delete a user, click the “X” button under the actions column on the respective user. You’ll be prompted to confirm this action, since it cannot be reverted.</p>
                                <h4 class="card-title m-t-40" id="6">Settings</h4>
                                <p>Currently under the settings tab, you can change only two options. Website URL and Developer options. The Website URL has to be accurate to your live website. The CMS will use this URL when parsing pages for the editor and for the “Live website” button on the dashboard. The Developer options checkbox will enable or disable the ability to edit for technical fields on the CMS. Here is a list of items developer options enables:</p>
                                <ol>
                                    <li>Ability to edit the body tags in page settings</li>
                                    <li>Ability to edit raw html from the editor</li>
                                    <li>Ability to modify classes on page elements within the editor</li>
                                </ol>
                                <p>This option was created for end user protection, for the reason that it may confuse them and cause them to edit something they don’t understand.</p>
                                <h4 class="card-title m-t-40" id="7">Page Editing</h4>
                                <p>The KeyBuilder is our own custom page editing software. It allows you to modify images and text in a live website view. You can also add specific elements to the page if they are intended to work that way. To modify an element all you have to do is click on it. Editable elements will have a dotted line surrounding them. Clicking them will prompt you with a dialog presenting you with fields you may change. If you have developer options enabled you’ll be able to change the class of elements as well. To apply your change you must click the update button on the bottom right. To change an image select from the dropdown list that is prompted to you upon clicking the image you want to change. Only the images you upload via the Images tab will be available for selection. </p>
                                <p>If developer options are enabled you’ll also be able to edit the raw html of the website. <strong>DO NOT</strong> modify this if you are unaware of what your changes will bring.</p>
                                <p>In order to save your changes click the green “Save Page” button in the top left tool bar. This will save the page as a draft and will not be shown on the live server until published. This system is used so you can make changes, leave, then come back to them later without the world being able to see your half completed work.</p>
                                <p style="color:red;">Important Note: If multiple users are on the editor of a page at the same time, their changes will overwrite each others! Meaning the last person to save will be the copy that is kept, all changes of the other user will be lost.</p>
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
    <script src="assets/plugins/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="assets/plugins/sparkline/jquery.sparkline.min.js"></script>
    <!-- Popup message jquery -->
    <script src="assets/plugins/toast-master/js/jquery.toast.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>
    <script>
    // This is for the sticky sidebar    
    $(".stickyside").stick_in_parent({
        offset_top: 90
    });
    $('.stickyside a').click(function() {
        $('html, body').animate({
            scrollTop: $($(this).attr('href')).offset().top - 90
        }, 500);
        return false;
    });
    // This is auto select left sidebar
    // Cache selectors
    // Cache selectors
    var lastId,
        topMenu = $(".stickyside"),
        topMenuHeight = topMenu.outerHeight(),
        // All list items
        menuItems = topMenu.find("a"),
        // Anchors corresponding to menu items
        scrollItems = menuItems.map(function() {
            var item = $($(this).attr("href"));
            if (item.length) {
                return item;
            }
        });

    // Bind click handler to menu items


    // Bind to scroll
    $(window).scroll(function() {
        // Get container scroll position
        var fromTop = $(this).scrollTop() + topMenuHeight - 250;

        // Get id of current scroll item
        var cur = scrollItems.map(function() {
            if ($(this).offset().top < fromTop)
                return this;
        });
        // Get the id of the current element
        cur = cur[cur.length - 1];
        var id = cur && cur.length ? cur[0].id : "";

        if (lastId !== id) {
            lastId = id;
            // Set/remove active class
            menuItems
                .removeClass("active")
                .filter("[href='#" + id + "']").addClass("active");
        }
    });
    </script>
</body>

</html>