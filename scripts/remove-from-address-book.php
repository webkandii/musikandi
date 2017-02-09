<?php
	session_start();
    require('../inc/config.php');
    require('../inc/functions.php');

    if(logged_in() == false) {
        header('Location: ' . $website_path);
    }

    $table = 'ab_' . $_POST['table'];
    $rid = $_POST['rid'];
    $ab_count = $_SESSION['ab_count'] - 1;

    if(in_address_book($rid, $_SESSION[$table]) == false) {
    	echo 'This record does not exist in your address book.';
    	exit();
    }

    // Convert session variable into an array
    $ab_table_arr = explode(', ', $_SESSION[$table]);

    // Gets key of value to be deleted
    if(($key = array_search($rid, $ab_table_arr)) !== false) {
	    unset($ab_table_arr[$key]);
	}

	// Update session variable for table
    $_SESSION[$table] = implode(', ', $ab_table_arr);
    
    try {
	    $remove = $conn->prepare('UPDATE `users` SET `' . $table . '` = :rid, `ab_count` = :count WHERE `id` = :uid');
	    $exec = $remove->execute(array(
	    	':rid' => $_SESSION[$table],
	    	':count' => $ab_count,
	    	':uid' => $_SESSION['id']
	    ));    	

	    if($exec) {
	    	$_SESSION['ab_count'] = $ab_count;
	    	echo 'Record has been successfully removed from your address book.';
	    	exit();
	    }
    } catch (PDOException $e) {
    	echo 'Could not remove record from address book. Reason: ' . $e->getMessage();
    	exit();
    } 
?>