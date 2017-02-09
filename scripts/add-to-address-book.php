<?php
	session_start();
    require('../inc/config.php');
    require('../inc/functions.php');

    if(logged_in() == false) {
        header('Location: ' . $website_path);
    }

    $table = 'ab_' . $_POST['table'];
    $rid = $_POST['rid'];
    $ab_count = $_SESSION['ab_count'] + 1;

    //echo 'Current session: ' . $_SESSION[$table] . '<br>';

    if(in_address_book($rid, $_SESSION[$table]) == true) {
    	echo 'Record has already been added to your address book.';
    	exit();
    }

    try {
	    $add = $conn->prepare('UPDATE `users` SET `' . $table . '` = :rid, `ab_count` = :count WHERE `id` = :uid');
	    if(empty($_SESSION[$table])) {
		    $exec = $add->execute(array(
		    	':rid' => $rid,
		    	':count' => $ab_count,
		    	':uid' => $_SESSION['id']
		    ));    	
	    } else {
		    $exec = $add->execute(array(
		    	':rid' => $_SESSION[$table] . ', ' . $rid,
		    	':count' => $ab_count,
		    	':uid' => $_SESSION['id']
		    ));    	
		}

	    if($exec) {
	    	if(empty($_SESSION[$table])) {
	    		$_SESSION[$table] = $rid;
	    	} else {
	    		$_SESSION[$table] = $_SESSION[$table] . ', ' . $rid;
	    	}

	    	$_SESSION['ab_count'] = $ab_count;
	    	echo 'Record has been successfully added to your address book.';
	    	exit();
	    }
    } catch (PDOException $e) {
    	echo 'Could not add record to address book. Reason: ' . $e->getMessage();
    	exit();
    }
?>