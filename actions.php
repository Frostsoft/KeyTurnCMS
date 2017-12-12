<?php

include_once('init.php');

	if(isset($_GET['page']) && isset($_POST['page_settings_save'])){

		if(isset($_POST['page_tracker'])){
			$tracker_val = "1";
		}else{
            $tracker_val = "0";
		}
			$title_val = $_POST['page_title'];
			$desc_val = $_POST['page_description'];
			$keywords_val = $_POST['page_keywords'];
        
        $stmt = $connection->prepare("UPDATE pages
        SET `title` = :title,
            `description` = :description,
            `keywords` = :keywords
        WHERE pagename = :pagename");

        $stmt->bindValue(":title", $title_val);
        $stmt->bindValue(":description", $desc_val);
        $stmt->bindValue(":keywords", $keywords_val);
        $stmt->bindValue(":pagename", $_GET['page']);
        $stmt->execute();

        $stmt = $connection->prepare("UPDATE `trackers`   
        SET `enabled` = :enabled
        WHERE `page` = :pagename");

        $stmt->bindValue(":enabled", $tracker_val);
        $stmt->bindValue(":pagename", $_GET['page']);
        $stmt->execute();

		header("Location: pages.php?p=" . $_GET['page'] . "&saved=2");
		exit();
	}else if(isset($_POST['patch_dismiss'])){
        $options['patch_noshow'] = true;
        $options = json_encode($options);
        $stmt = $connection->prepare("UPDATE `users`   
        SET `options` = :options
        WHERE `username` = :name");
        $stmt->bindValue(":options", $options);
        $stmt->bindValue(":name", $_SESSION['user']);
        $stmt->execute();
        exit();
    }else if(isset($_POST['add_global_code'])){
        $new_global = array(
            "name" => $_POST['name'],
            "type" => $_POST['type'],
            "enabled" => 1,
            "content" => $_POST['content']
        );
        $SQL_globalinfo = sprintf(
            "INSERT INTO %s (%s) values (%s)",
            "globals",
            implode(", ", array_keys($new_global)),
            ":" . implode(", :", array_keys($new_global))
        );
        $stmt = $connection->prepare($SQL_globalinfo);
        $stmt->execute($new_global);
        header("Location: globalcode.php?s=1");
        exit();
    }
    
    header("Location: index.php");
	
?>