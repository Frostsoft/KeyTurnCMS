<?php
    include_once('init.php');
    
    if(empty($_GET['p'])){
        header("Location: index.php?err=2");
        exit();
    }
    $pagename = $_GET['p'];
    if($pagename == "landingmenu" || $pagename == "menu" || $pagename == "footer"){
        $stmt = $connection->prepare("SELECT content FROM globals WHERE name = '" . $pagename . "'");
        $stmt->execute();
        if($stmt->rowCount() < 0){
            header("Location: index.php?err=2");
            exit();
        }
        $row = $stmt->fetch();

        $body = htmlspecialchars_decode($row['content']);

        $stmt = $connection->prepare("SELECT content FROM globals WHERE type = 'css'");
        $stmt->execute();
        while($row = $stmt->fetch()){
            $meta .= htmlspecialchars_decode($row['content']);
        }

        $stmt = $connection->prepare("SELECT content FROM globals WHERE type = 'script'");
        $stmt->execute();
        while($row = $stmt->fetch()){
            $scripts .= htmlspecialchars_decode($row['content']);
        }
    }else{
        $stmt = $connection->prepare("SELECT head, sub, content FROM pages WHERE pagename = '" . $_GET['p'] . "'");
        $stmt->execute();
        if($stmt->rowCount() < 0){
            header("Location: index.php?err=2");
            exit();
        }
        $row = $stmt->fetch();

        $meta = htmlspecialchars_decode($row['head']);
        $body = htmlspecialchars_decode($row['content']);
        $scripts = htmlspecialchars_decode($row['sub']);

        $stmt = $connection->prepare("SELECT content FROM globals WHERE type = 'css'");
        $stmt->execute();
        while($row = $stmt->fetch()){
            $meta .= htmlspecialchars_decode($row['content']);
        }

        $stmt = $connection->prepare("SELECT content FROM globals WHERE type = 'script'");
        $stmt->execute();
        while($row = $stmt->fetch()){
            $scripts .= htmlspecialchars_decode($row['content']);
        }
    }
    function endsWith($haystack, $needle)
    {
        $length = strlen($needle);
    
        return $length === 0 || 
        (substr($haystack, -$length) === $needle);
    }

    $stmt = $connection->prepare("SELECT value FROM settings WHERE name = 'website'");
    $stmt->execute();
    $website = $stmt->fetchColumn();
    
    $url = $website;
    if(!endsWith($url, "/"))
        $url = $url . "/";
    
	$isnav = false;
	if($_GET['p']=="menu" || $_GET['p'] =="landingmenu"){
		//brings the keybuilder nav to the bottom of screen to avoid nav conflict
		$isnav=true;
	}
?>
<html>
<head>
<link rel="stylesheet" type="text/css" href="asset/css/plugins/font-awesome.min.css"/>
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
<?php
   // echo '<base href="' . $url . '" />
   // <base target="_blank" />';

    echo str_replace("{%ROOT_URL%}", $url, $meta);
    ?>
<title>KeyBuilder - Beta</title>
<style>

<?php 
if($_GET['p'] == "menu" || $_GET['p'] == "footer" || $_GET['p'] == "landingmenu"){
    echo 'body{background-color:#a6a6a6;}';
}
?>

.editable_text{
	padding: 5px 2px 2px 5px;
	border: dashed 1px !important;
	z-index:999;
	margin:-1px;
}

.editable_text:hover{
	cursor:pointer;
}

.editable_img{
	border: dashed 1px !important;
	z-index:999;
	margin:-1px;
}

.editable_img:hover{
	cursor:pointer;
}

.modal input{
	width: 100%;
}

.addDynamic{
	width:70px;
	height:40px;
	background-color: green;
	color: #fff;
	padding: 10px 20px 10px 20px;
	position:absolute;
	bottom:0;
	right:0;
	z-index:9999;
}

.addDynamic:hover{
	background-color:#ccc;
	color:green;
	cursor: pointer;
}

.delDynamic{
    position: absolute;
    top:0;
    right:16px;
    padding: 5px 10px 5px 10px;
    font-size:20px;
    color: #666;
}

.delDynamic:hover{
    background-color: rgba(160, 0, 0, 0.4);
    color:#FFF;
    cursor:pointer;
}

.dynamicParent{
	border: dashed 1px;
	position:relative;
	margin:-1px;
}


.row.match-my-cols {
    overflow: hidden; 
}

.row.match-my-cols [class*="col-"]{
    margin-bottom: -99999px;
    padding-bottom: 99999px;
}

.key-modal-lg{
	width:50%;
	margin: auto;
}

.key-navbtn{ 
	text-decoration:none;
    width:100%;
    padding-top:4vh;
    padding-bottom:4vh;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.key-navbtn i{
    font-size:40px;
}

.developerAlert{
    position:absolute;
    bottom:0;
    left:0;
    width:100%;
    padding-top:2vh;
    padding-bottom:1vh;
    font-size:20px;
    color:#fff;
}

#toggleMenuBar{
    position: fixed; 
    background-color:rgba(0,0,0,0.3); 
    right: 0px; 
    top: 0px;
    padding-top:12px;
    width: 100px; 
    height:74px; 
    z-index:15; 
    font-size: 25px; 
    color:#fff;
    border:none;
}

.editor_left_modal{
    position: fixed;
    top:0;
    left:-81vw;
    height: 100vh;
    width: 80vw;
    background-color:#eae8e7;
    z-index:9999;

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.toggle_html_toggled{
    position:absolute;
    height:100vh;
    padding-top:45vh;
    top:0;
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}


.leftmodal-toggled{
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    left: 0;
}

.editor_sidebar{
    position: fixed;
    top:0;
    right:-21vw;
    height: 100vh;
    width: 20vw;
    background-color:#eae8e7;
    z-index:9999;

    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
}

.sidebar-toggled{
    -webkit-transition: all 0.5s ease;
    -moz-transition: all 0.5s ease;
    -o-transition: all 0.5s ease;
    transition: all 0.5s ease;
    right: 0;
}

.sidebar-close{
    position:relative; top:0;left:0; height:5vh; width:100%; background-color:#dbd8d6; border:none; color:#222; font-size:18px;
}

.sidebar-textarea{
    border:none; padding: 8px; width:18vw; margin-left: 1vw; margin-bottom: 20px; height:65vh; resize: none;
}

.sidebar-update{
    position:absolute; bottom:0;left:0; height:10vh; width:100%; background-color:#39aa56; border:none; color:#fff; font-size: 30px;
}

.sidebar-textbox{
    border:none; padding: 8px; width:18vw; margin-left: 1vw;
}

.sidebar-textbox-2{
    margin-top: 20px;
}

.sidebar-dropdown{
    border:none; padding: 8px; width: 18vw; margin-bottom: 20px;
}

.sidebar-text{
    margin-left:1vw;
}

.bug-report-input{
    margin-left: 1%; 
    width: 97%; 
    padding: 15px;
}

@media (max-width: 512px){
    .sidebar-toggled{
        width: 100vw;
    }
    .sidebar-textarea{
        width:98vw;
    }

    .sidebar-textbox{
        width:98vw;
    }

    .sidebar-dropdown{
        width: 98vw;
    }
}

@media (max-width: 1280px){
    .sidebar-toggled{
        width: 30vw;
    }
    .sidebar-textarea{
        width:28vw;
    }

    .sidebar-textbox{
        width:28vw;
    }

    .sidebar-dropdown{
        width: 28vw;
    }
    .editor_left_modal{
        width:70vw;
    }
}


body::-webkit-scrollbar {
    width: 10px;
}
 
body::-webkit-scrollbar-track {
    -webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
}
 
body::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}
</style>
</head>
<body>

<!--
<div id="top_bar" style="background-color:#262626; color:#eee; position:fixed; <?php if($isnav){ echo 'bottom:0;'; } else { echo 'top:0;'; } ?> left:0; height:64px; z-index:10">
	<a class="btn btn-success key-navbtn" id="btnSavePage" href="javascript:void()" style="margin-left: 40px;">Save Page</a><?php if($isDeveloper=="1"){ echo'<a class="btn btn-primary key-navbtn" id="openHTML" href="javascript:void()"><i class="fa fa-code"></i> Raw HTML</a>';} ?><a class="btn btn-warning key-navbtn" id="openBugPrompt" href="javascript:void()"><i class="fa fa-bug"></i> Report Bug</a>
</div>-->

<button id="toggleMenuBar"><i class="fa fa-bars"></i> Menu</button>

<div class="modal fade" id="welcomeMessage" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Welcome to the BETA </h4>
            </div>
            <div class="modal-body">
				<h2>Welcome to the KeyBuilder Beta</h2>
				<p>The KeyBuilder Website Editor is still under development and in its beta stage. Not all features will work correctly, like-wise some wont work at all; or break. If you stumble upon a bug please report it to james@keyturnmedia.com or click the "Report Bug" button. <br> Thanks and happy editing! <br> James Vandersluis</p>
            </div>
            <div class="modal-footer">
                <button type="button" id="closeWelcomeMessage" class="btn btn-success" data-dismiss="modal">Start Editing!</button>
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="reportABug" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><i class="fa fa-bug"></i> Report a Bug</h4>
            </div>
            <div class="modal-body">
				<p>NOTE: Use this form only for bug reports! Anything else will be ignored and deleted by our filter. Please try to reproduce a bug before you submit it. Thank you!</p>
				<h5>Name</h5>
				<input type="text" id="nameBug" class="editor-input" placeholder="Name" value="<?php $_SESSION['user']; ?>">
				<h5>Description of bug</h5>
				<textarea id="descBug" class="editor-input" placeholder="Tell us what happened"></textarea>
				<h5>Reproduction procedure</h5>
				<textarea id="reproBug" class="editor-input" placeholder="If you were able to reproduce the bug, please explain. Otherwise give a outline of what you did before the bug occured."></textarea>
			</div>
            <div class="modal-footer">
                <button type="button" id="submitBugReport" class="btn btn-warning" data-dismiss="modal">Report Bug</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<form action="savedraft.php" id="savedraft" method="post">
	<input name="page" type="hidden" value="<?php echo $_GET['p'];?>">
	<input name="body" type="hidden" id="draftDoc" value="">
</form>

<noscript>
The KeyBuilder Website Editor requires javascript to be enabled in your browser. If you do not know how to do this please visit <a href="https://www.enable-javascript.com/">https://www.enable-javascript.com/</a>
</noscript>

<div id="docBody" style="margin-top:0px;">
	<?php
	/*
	foreach($plugins->plugin as $plugin){
		str_replace("%".$plugin->name."%", $plugin->placeholder, $body);
    }*/
    echo str_replace("{%ROOT_URL%}", $url, $body);
    ?>
</div>

<div class="modal fade" id="changeImage" role="dialog">
    <div class="modal-dialog key-modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Change Image </h4>
            </div>
            <div class="modal-body">
				<img src="" id="displaySelectedImage" class="img-responsive" alt="Display Image">
				<p>Select an Image from your uploads: </p>
				<div style="overflow:hidden;"><center>
                <?php
				echo '<select class="editor-input" id="imageList" name="ls">';
		   $images = glob("../images/*.{jpg,gif,png,jpeg}", GLOB_BRACE);
		   foreach($images as $image)
		   {
				echo '<option>' . basename($image) . '</option>';
		   }

        		echo  '</select>';
				?>
				</center></div>
				<p>Alternate Text: </p>
                <input id="imageAlt" class="editor-input" placeholder="Text that displays if image cant load">
				<p <?php if($isDeveloper==0){echo "style=\"display:none;\"";}?>>Classes: </p>
                <input id="imageClass" class="editor-input" placeholder="Classes to be applied" <?php if($isDeveloper==0){echo "style=\"display:none;\"";}?>>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmChange" class="btn btn-default" data-dismiss="modal">Change</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="updateText" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Update Text </h4>
            </div>
            <div class="modal-body">
				<p>Text: </p>
				<textarea id="newText" class="editor-input" placeholder="Enter text" rows="14"></textarea>
				<div id="hrefOptions" style="display:none;">
					<p>Link URL: </p>
					<input id="linkHref" class="editor-input" placeholder="Where the link points to">
				</div>
				<p <?php if($isDeveloper==0){echo "style=\"display:none;\"";}?>>Classes: </p>
                <input id="textClasses" class="editor-input" placeholder="Classes to be applied" <?php if($isDeveloper == 0){echo "style=\"display:none;\"";}?>>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmChange" class="btn btn-default" data-dismiss="modal">Update Text</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editHTML" role="dialog">
    <div class="modal-dialog key-modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Page HTML </h4>
            </div>
            <div class="modal-body">
                <textarea id="htmlbody" rows="30" style="width:100%;"></textarea>
            </div>
            <div class="modal-footer">
                <button type="button" id="confirmChange" class="btn btn-default" data-dismiss="modal">Update HTML</button>
            </div>
        </div>
    </div>
</div>

<!--Large Left Sidebar-->
<div class="editor_left_modal" id="left_sidebar">
    <h2 class="text-center">Edit Raw HTML</h2>
    <textarea style="margin-left: 1%; width: 97%; height: 90%; resize:none; padding: 15px;" id="edit_html"></textarea>
</div>

<div class="editor_left_modal" id="left_bug_sidebar">
    <h2 class="text-center">Report A Bug</h2>

    <p style="margin-left: 1%;margin-right:1%;">NOTE: Use this form only for bug reports! Anything else will be ignored and deleted by our filter. Please try to reproduce a bug before you submit it. Thank you!</p>
    <input type="text" id="nameBug" style="" class="bug-report-input" placeholder="Name" value="<?php $_SESSION['user']; ?>">
    <textarea id="descBug" style="height: 25%; resize:none; padding: 15px; margin-top:8px;" class="bug-report-input" placeholder="Tell us what happened"></textarea>
    <textarea id="reproBug" style="height: 40%; resize:none; padding: 15px; margin-top:8px;" class="bug-report-input" placeholder="If you were able to reproduce the bug, please explain. Otherwise give an outline of what you did before the bug occured."></textarea>
    <button type="button" id="submitBugReport" style="width:97%;margin-left: 1%;margin-top:1%;" class="btn btn-warning" data-dismiss="modal">Report Bug</button>

</div>

<!-- TESTING SIDEBARS -->

<div class="editor_sidebar" id="text_sidebar">
    <button id="collapse_sidebar" class="sidebar-close">Close</button>
    <h2 class="text-center" style="color:#222;">Text Editor</h2>
    <textarea class="sidebar-textarea" placeholder="content text" id="content_textarea"></textarea><br/>
    <input type="text" placeholder="classes" class="sidebar-textbox"/>
    <input type="text" id="href_edit" placeholder="http://www.keyturnmedia.com/" style="display:none;" class="sidebar-textbox sidebar-textbox-2"/>
    <button id="update_content_sidebar" class="sidebar-update">Update Text</button>
</div>

<div class="editor_sidebar" id="image_sidebar">
    <button id="collapse_sidebar" class="sidebar-close">Close</button>
    <h2 class="text-center" style="color:#222;">Image Editor</h2>

        <p class="sidebar-text">Select an Image from your uploads: </p>
        <div style="overflow:hidden;"><center>
        <?php
        echo '<select class="sidebar-dropdown" id="image_select" name="ls">';
        $images = glob("../images/*.{jpg,gif,png,jpeg}", GLOB_BRACE);
        foreach($images as $image)
        {
            echo '<option>' . basename($image) . '</option>';
        }

        echo  '</select>';
        ?>
        </center></div>

    <input type="text" placeholder="Image alternate text" class="sidebar-textbox" id="image_alternate"/>
    <button id="update_content_sidebar" class="sidebar-update">Update Image</button>
</div>

<div class="editor_sidebar" id="main_sidebar">
    <button id="collapse_sidebar" class="sidebar-close">Close</button><br/>
    <a class="btn btn-success key-navbtn" id="btnSavePage" href="javascript:void(0)"><i class="fa fa-save"></i><br/>Save Page</a>
    
    <?php if($isDeveloper=="1"){ echo'<a class="btn btn-primary key-navbtn" id="toggle_html" href="javascript:void(0)"><i class="fa fa-code"></i><br/> Raw HTML</a>';} ?>
    
    <a class="btn btn-warning key-navbtn" id="toggle_bug_reporter" href="javascript:void(0)"><i class="fa fa-bug"></i><br/> Report Bug</a>

    <center><h1>KeyBuilder</h1><p>Made with <i class="fa fa-heart" style="color:red;"></i> By James Vandersluis</p></center>
    
    <?php
        if($isDeveloper=="1"){
            echo '<div class="developerAlert btn-success"><p class="text-center">Developer Mode: On</p></div>';
        }else{
            echo '<div class="developerAlert btn-danger"><p class="text-center">Developer Mode: Off</p></div>';
        }
        ?>
</div>

<?php
echo str_replace("{%ROOT_URL%}", $url, $scripts);
?>
<!--<script src="asset/js/editor.js"></script>-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="js/base64.js"></script>
<?php 
$debugger = true;
if($debugger)
    echo '<!--Debugger Mode Enabled! This date will always update the editor.js File--><script src="js/editor.js?v=' . date('Y/m/d H:i:s') . '"></script>';
else
   echo '<script src="js/editor.js?v=2_1"></script>';
?>


</body>

</html>