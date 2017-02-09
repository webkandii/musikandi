<?php  
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();
    ob_start();
    require('inc/config.php');
    require('inc/functions.php');

    if(logged_in() == false) {
        header('Location: ' . $website_path);
        exit();
    }

    $id = $_GET['r'];
    $table = $_GET['table'];
    $return_url = $_GET['return'] . '#' . $_GET['hash'];

    $get_record = $conn->prepare('SELECT * FROM `' . $table . '` WHERE `id` = :id');
    $get_record->execute(array(':id' => $id));
    while ($data = $get_record->fetch()) {
        $owned_by = $data['owned_by'];
    }

    if($_SESSION['permissions'] != 'admin' && $_SESSION['id'] != $owned_by) {
        header('Location: ' . $website_path);
        exit();
    }

    try {
        $delete = $conn->prepare('DELETE FROM `' . $table . '` WHERE `id` = :id');
        $exec = $delete->execute(array(':id' => $id));

        if($exec) {        
            // Remove from address book
            // Check all user accounts with address books greater than 0 contacts
            try {
                $check = $conn->prepare('SELECT * FROM `users` WHERE `ab_count` > 0');
                $check->execute();

                while ($check_data = $check->fetch() ) {
                    $ab_table = 'ab_' . $table;
                    $ab_table_data = $check_data[$ab_table];
                    $ab_count = $check_data['ab_count'] - 1;
                    $uid = $check_data['id'];

                    // If ID exists in this users address book
                    if(in_address_book($id, $ab_table_data) == true) {
                        $arr = explode(', ', $ab_table_data);
                        $key = array_search($id, $arr);
                        unset($arr[$key]);
                        $updated_ab_table = implode(', ', $arr);

                        // Update address book
                        try {
                            $update = $conn->prepare('UPDATE `users` SET `' . $ab_table . '` = :updated_ab_table, `ab_count` = :ab_count WHERE `id` = :uid');
                            $update->execute(array(
                                ':updated_ab_table' => $updated_ab_table,
                                ':ab_count' => $ab_count,
                                ':uid' => $uid
                            ));

                            // If this user being looped through is the logged in user then update session variables
                            if($uid == $_SESSION['id']) {
                                $_SESSION['ab_count'] = $ab_count;
                                $_SESSION[$ab_table] = $updated_ab_table;
                            }
                        } catch (PDOException $e) {
                            echo 'Could not update address books. Reason: ' . $e->getMessage();
                        }
                    }
                }
            } catch (PDOException $e) {
                echo 'Could not check address books for record. Reason: ' . $e->getMessage();
            }

            echo '<<meta http-equiv="refresh" content="2; URL=' . $return_url . '"> The record with the ID ' . $id . ' has been successfully deleted from ' . $table  . '. Redirecting... <a href="' . $return_url . '" class="mkandi_csv">Go back</a>.';
        } else {
            echo 'The server encountered an error whilst trying to delete the record with the ID ' . $id . '. Please try again.';
        }   
    } catch (PDOException $e) {
        echo 'The server encountered an error whilst trying to delete the record with the ID ' . $id . '. Reason: ' . $e->getMessage();
    }
?>
