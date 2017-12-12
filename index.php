<?php include_once("init.php"); 

//depri - $settings = simplexml_load_file("data/settings.xml");

$stmt = $connection->prepare("SELECT value FROM settings WHERE name = 'website'");
$stmt->execute();
$website = $stmt->fetchColumn();

$stmt = $connection->prepare("SELECT SUM(value) AS value_sum FROM trackers");
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);
$totalhits = $row['value_sum'];

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
    <!-- Dashboard 1 Page CSS -->
    <link href="css/pages/dashboard1.css" rel="stylesheet">
    <!-- You can change the theme colors from here -->
    <link href="css/colors/blue.css" id="theme" rel="stylesheet">
    <style>
        .change{
  padding: 10px 15px; 
  color:white;
  margin-top:5px;
}

.change i{
  margin-right:10px;
}

.bug{
  background-color:#f0ad4e;
}

.add{
  background-color:#5cb85c;
}

.modify{
  background-color:#5bc0de;
}

.removed{
  background-color:#d9534f;
}
    </style>
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
                <!-- ============================================================== -->
                <!-- Sales overview chart -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div>
                                        <h3 class="card-title m-b-5"><span class="lstick"></span>Page Views</h3>
                                        <h6 class="card-subtitle">Overview</h6></div>
                                    
                                </div>
								<canvas id="pageviews-chart" class="p-relative" style="height:400px;"></canvas>
								<!--
                                <div id="sales-overview" class="p-relative" style="height:400px;"></div>-->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- ============================================================== -->
                <!-- Stats box -->
                <!-- ============================================================== -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center text-info" style="font-size:52px;"><span class="lstick m-r-20"></span><i class="mdi mdi-eye"></i> </div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Total Views</h6>
                                        <h2 class="m-t-0">
										<?php
                                            // DISPLAY TOTAL HITS QUERY RESULTS
                                            echo $totalhits;
                                        ?>
										</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="card">
                            <div class="card-body">
                                <div class="d-flex no-block">
                                    <div class="m-r-20 align-self-center text-info" style="font-size:52px;"><span class="lstick m-r-20"></span><i class="mdi mdi-home"></i> </div>
                                    <div class="align-self-center">
                                        <h6 class="text-muted m-t-10 m-b-0">Home Page Views</h6>
                                        <h2 class="m-t-0">
										<?php
                                            $statement = $connection->prepare("SELECT value FROM trackers WHERE page = 'index'");
                                            $statement->execute();
                                            $result = $statement->fetch();
                                            echo $result['value'];
                                        ?>
										</h2></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- ============================================================== -->
                <!-- Right panel -->
                <!-- ============================================================== -->
                <aside class="right-side-panel">
                    <div class="row">
                       
                        <!-- Live Website Widget -->
                        <div class="col-md-12 m-t-10">
							<a href="<?php echo $website;?>" class="btn waves-effect waves-light btn-rounded btn-success" style="width:100%;">Live Website</a>
						</div>
                        <!-- End Live Website Widget -->
						
						<?php 
						
						$my_version = file_get_contents("version.dat");

						$web_version = file_get_contents("http://keyturnmedia.com/dev/repo/version_api.php");

						if($my_version == $web_version){
						
						echo '
						<div class="col-md-12 m-t-10">
                            <div class="card bg-success text-white">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="stats">
                                            <h1 class="text-white">v' . $my_version . '</h1>
											<h6 class="text-white">Up to date</h6>
										</div>
                                        <div class="stats-icon text-right ml-auto"><i class="mdi mdi-check display-5 op-3 text-dark"></i></div>
									</div>
								</div>
							</div>
						</div>';
						
						}else{
						
						echo '
						<div class="col-md-12 m-t-10">
                            <div class="card bg-danger text-white">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="stats">
                                            <h1 class="text-white">v' . $my_version . '</h1>
											<h6 class="text-white">Out of date (v' . $web_version . ' available)</h6>
                                            <a href="updater.php" class="btn btn-rounded btn-outline btn-light m-t-10 font-14">Update Now</a>
										</div>
                                        <div class="stats-icon text-right ml-auto"><i class="mdi mdi-alert-outline display-5 op-3 text-dark"></i></div>
									</div>
								</div>
							</div>
						</div>';
						
						}

						?>
                    </div>
                </aside>
                <!-- ============================================================== -->
                <!-- End Right panel -->
                <!-- ============================================================== -->
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

    <?php
        if($options['patch_noshow'] == false){
            if(file_exists("patchnotes.xml")){
                $patchnote = simplexml_load_file("patchnotes.xml");
                $title = $patchnote->title;
                $breif = $patchnote->breif;
                echo '<div id="patchNotesModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="patchNotesLabel" aria-hidden="true" style="display: none;">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="patchNotesLabel">' . $title . '</h4>
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                        </div>
                        <div class="modal-body">
                        ' . $breif;

                        foreach($patchnote->patch as $patch){
                            if($patch->type == "bug"){
                                echo '<div class="change bug"><i class="fa fa-bug"></i>' . $patch->desc . '</div>';
                            }else if($patch->type == "add"){
                                echo '<div class="change add"><i class="fa fa-plus"></i>' . $patch->desc . '</div>';
                            }else if($patch->type == "modify"){
                                echo '<div class="change modify"><i class="fa fa-refresh"></i>' . $patch->desc . '</div>';
                            }else if($patch->type == "removed"){
                                echo '<div class="change removed"><i class="fa fa-trash"></i>' . $patch->desc . '</div>';
                            }

                        }

                        echo '</div>
                        <div class="modal-footer">
                            <form id="patch_form" type="post">
                            <button type="button" id="patch_dismiss" class="btn btn-danger waves-effect" data-dismiss="modal">Dont Show Again</button>
                            <button type="button" class="btn btn-info waves-effect" data-dismiss="modal">Close</button>
                            </form>
                        </div>
                    </div>
                    <!-- /.modal-content -->
                </div>
                <!-- /.modal-dialog -->
            </div>';
            }
        }
    ?>

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
    <script src="js/dashboard1.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js"></script>
    <!-- ============================================================== -->
    <!-- Style switcher -->
    <!-- ============================================================== -->
    <script src="assets/plugins/styleswitcher/jQuery.style.switcher.js"></script>

<?php if($options['patch_noshow']==false){ echo '<script>$(document).ready(function(){$("#patchNotesModal").modal("show");});</script>'; }?>

	<script>

$("#patch_dismiss").on('click', function(){
    $.ajax({ type: "POST",   
				url: "actions.php",   
				data : {"patch_dismiss" : "true"},
				async: true
			});
});

var ctx = document.getElementById("pageviews-chart").getContext('2d');

var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: [<?php 
                    $stmt = $connection->prepare("SELECT page, value FROM trackers");
                    $stmt->execute();
                    $tracker_count = $stmt->rowCount();
                    $barcount = 0;
                    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                        if($barcount == $tracker_count-1){
                            echo "\"" . $row['page'] . "\"";
                        }else{
                            echo "\"" . $row['page'] . "\", ";
                        }
                            $barcount++;
                    }
                ?>],
        datasets: [{
            label: '# of Views',
            data: [<?php 
            $barcount = 0;
            $stmt->execute();
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                if($barcount == $tracker_count-1)
                    echo $row['value'];
                else
                    echo $row['value'] . ", ";

                $barcount++;
            }
			?>],
            label: "Page Analytics",
			backgroundColor: 'rgba(116, 90, 242,0.2)',
			borderColor: '#745af2',
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
</script>

<?php
    if(isset($_GET['err'])){
        echo "<script>";
        if($_GET['err'] ==2){
            echo "
            $.toast({
            heading: 'Page Error',
            text: 'Trying to request a page that doesnt exist.',
            position: 'top-right',
            icon: 'error',
            hideAfter: 6000,
            stack: 6
            })";
        }
        echo "</script>";
    }
?>

</body>

</html>