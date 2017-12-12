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
    echo '<base href="' . $url . '" />
    <base target="_blank" />';
    echo $meta;
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

.editor-input{
	width:100%;
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
	margin-top:14px; 
	margin-right: 12px;
	text-decoration:none;
}
</style>
</head>
<body>

<div id="top_bar" style="background-color:#262626; color:#eee; position:fixed; <?php if($isnav){ echo 'bottom:0;'; } else { echo 'top:0;'; } ?> left:0; height:64px; z-index:10">
	<a class="btn btn-success key-navbtn" id="btnSavePage" href="javascript:void()" style="margin-left: 40px;">Save Page</a><?php if($isDeveloper=="1"){ echo'<a class="btn btn-primary key-navbtn" id="openHTML" href="javascript:void()"><i class="fa fa-code"></i> Raw HTML</a>';} ?><a class="btn btn-warning key-navbtn" id="openBugPrompt" href="javascript:void()"><i class="fa fa-bug"></i> Report Bug</a>
</div>

<button id="toggleMenuBar" style="position: fixed; background-color:#ccc; left: 0px; top: 0px; width: 36px; height:64px; z-index:15; color:#000;"><i class="fa fa-bars"></i></button>

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
		echo $body;
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

<?php
	echo $scripts;
?>
<!--<script src="asset/js/editor.js"></script>-->
<script src="https://code.jquery.com/jquery-3.2.1.min.js" integrity="sha256-hwg4gsxgFZhOsEEamdOYGBf13FyQuiTwlAQgxVSNgt4=" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
<script src="keyturn/js/base64.js"></script>
<script src="keyturn/js/editor.js"></script>




</body>

</html>