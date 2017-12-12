<aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <li class="user-profile"> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><img src="assets/images/users/default-profile.png" alt="user" /><span class="hide-menu"><?php if(!empty($_SESSION['user'])){ echo $_SESSION['user']; } ?></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="javascript:void()">Account Setting</a></li>
                                <li><a href="logout.php">Logout</a></li>
                            </ul>
                        </li>
                        <li class="nav-devider"></li>
                        <li class="nav-small-cap">WEBSITE MANAGEMENT</li>
                        <li> <a class="waves-effect waves-dark" href="index.php"><i class="mdi mdi-gauge"></i>Dashboard </a> </li>
						<?php
								$pagecount = 0;
                                $list_html = "";
                                $stmt = $connection->prepare("SELECT pagename FROM pages");
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    $list_html = $list_html . "<li><a href='pages.php?p=" . $row['pagename'] . "'>" . $row['pagename'] . "</a></li>";
									$pagecount++;
                                }
						?>
						<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-file-document"></i><span class="hide-menu">Pages <span class="label label-rouded label-themecolor pull-right"><?php echo $pagecount; ?></span></span></a>
                            <ul aria-expanded="false" class="collapse">
                                <?php
                                    echo $list_html;
								?>
                            </ul>
                        </li>
						<li> <a class="waves-effect waves-dark" href="images.php"><i class="mdi mdi-image"></i>Images </a> </li>
						
						<?php
                        
                        if(!empty($user_level)){ if($user_level > 0){
							echo '<li> <a class="waves-effect waves-dark" href="globalelements.php"><i class="mdi mdi-menu"></i>Menu/Footer </a> </li>';
                        }}
                        if(!empty($user_level)){ if($user_level == 2){
                            echo '<li> <a class="waves-effect waves-dark" href="users.php"><i class="mdi mdi-account"></i>Users </a> </li>';
                            if($isDeveloper){
							    echo '<li> <a class="waves-effect waves-dark" href="globalcode.php"><i class="mdi mdi-cloud"></i>Global Code </a> </li>';
                            }
						}}?>
                        <!--<li> <a class="has-arrow waves-effect waves-dark" href="#" aria-expanded="false"><i class="mdi mdi-share"></i><span class="hide-menu">Social Media </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="feed.php?media=facebook">Facebook</a></li>
                            </ul>
                        </li>-->
						<li> <a class="waves-effect waves-dark" href="help.php"><i class="mdi mdi-help"></i>Help </a> </li>
						<li> <a class="waves-effect waves-dark" href="settings.php"><i class="mdi mdi-settings"></i>Settings </a> </li>
					</ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </aside>