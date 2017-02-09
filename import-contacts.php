<?php  
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();
    require('inc/config.php');
    require('inc/functions.php');
    require('inc/csv.php');

    if(isset($_POST['upload_csv'])) {
        $csv_file = $_FILES['csv']['tmp_name'];
        $csv_file_ext = pathinfo($_FILES['csv']['name']);
        $visibility = $_POST['visibility'];
        $table = $_POST['table'];
        $table_name = get_category_name($categories, $table);

        if(!is_uploaded_file($csv_file)) {
            $note = 'You must upload a file.';
        } else {
            if($csv_file_ext['extension'] != 'csv') {
                $note = 'You must upload the file in .csv format.';
            } else {
                $row = 0;
                if(($handle = fopen($csv_file, "r")) !== FALSE) {
                    while(($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
                        $num = count($data);
                        if($num > '8' || $num < '8') {
                            $row_num = $row + 1; 
                            $note = 'Your CSV file contains ' . $num . ' columns at row ' . $row_num . '. This and any other row must contain no more or less than 8 columns.';

                            if($row > 0) {
                                $note .= ' All rows before this have been uploaded successfully.';
                            }
                        } else {
                            #echo "<p> $num fields in line $row: <br /></p>\n";
                            $row++;
                            $row_data = '';
                            foreach ($data as $key => $value) {
                                if(!empty($value)) {
                                    $data_filtered = filter_var($value, FILTER_SANITIZE_STRING);
                                    $data = protect($data_filtered);
                                } else {
                                    $data = ' ';
                                }
                                $row_data .= "'" . $data . "', ";
                            }

                            $row_data .= $_SESSION['id'] . ', ' . $visibility;

                            try {
                                $insert = $conn->prepare('INSERT INTO `' . $table . '` (`name`, `company`, `city`, `postcode`, `tel`, `email`, `web`, `notes`, `owned_by`, `visible`) VALUES (' . $row_data . ')');
                                $exec = $insert->execute();

                                if($exec) {
                                    $note = $row . ' contacts have been successfully uploaded into <strong>' . $table_name . '</strong>';
                                    $ab_table = 'ab_' . $table;
                                    $rid = $conn->lastInsertId();
                                    $ab_count = $_SESSION['ab_count'] + 1;

                                    try {
                                        $add = $conn->prepare('UPDATE `users` SET `' . $ab_table . '` = :rid, `ab_count` = :count WHERE `id` = :uid');
                                        if(empty($_SESSION[$ab_table])) {
                                            $exec = $add->execute(array(
                                                ':rid' => $rid,
                                                ':count' => $ab_count,
                                                ':uid' => $_SESSION['id']
                                            ));     
                                        } else {
                                            $exec = $add->execute(array(
                                                ':rid' => $_SESSION[$ab_table] . ', ' . $rid,
                                                ':count' => $ab_count,
                                                ':uid' => $_SESSION['id']
                                            ));     
                                        }

                                        if($exec) {
                                            $note .= ' and added to your address book.';
                                            if(empty($_SESSION[$ab_table])) {
                                                $_SESSION[$ab_table] = $rid;
                                            } else {
                                                $_SESSION[$ab_table] = $_SESSION[$ab_table] . ', ' . $rid;
                                            }

                                            $_SESSION['ab_count'] = $ab_count;
                                        } else {
                                            $note .= '. However, the server encountered an error whilst trying to add the contacts to your address book, you will need to add these contacts manually.';
                                        }
                                    } catch (PDOException $e) {
                                        echo 'Could not add record to address book. Reason: ' . $e->getMessage();
                                        exit();
                                    }
                                } else {
                                    $note = 'The server encountered an error whilst try to upload your records into ' . $table_name . '. Please try again.';
                                }
                            } catch (PDOException $e) {
                                echo 'Could not upload data to database. Reason: ' . $e->getMessage();
                            }
                        }
                    }
                    fclose($handle);
                }
            }
        }
    }

    $page_title = 'Import Contacts • Musikandi';
    $page = 'importcontacts';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> <a href="' . $website_path . '"address-book.php>Address Book</a>  <span>&#8250;&#8250;</span> Import Contacts';    
    require('inc/header.php');
?>
<head>
<meta name="description" content="Import contacts to your online music industry address book.">
</head>    
    <section id="content">
        <div class="container">
            <h1>Import Contacts</h1>
            
            <p>Import contacts into your address book using the .csv (comma-separated values) format.</p> 

            <p><strong>IMPORTANT:</strong> any file that you upload MUST be in .csv format and have no more or less than 10 columns, the csv should also be formatted like the following to ensure each contact is uploaded correctly: name, title, company, address, city, postcode, tel, email, web, notes. <a href="http://www.musikandi.com/templates/mkandi_upload_template.csv" title=".csv template" class="mkandi_csv">Download .csv template</a>.</p>

            <?php if(isset($note)) { echo '<p><strong>' . $note . '</strong></p>'; } ?>

            <form method="POST" class="form" enctype="multipart/form-data">
                <table>
                    <tr>
                        <td><label for="csv">Upload CSV file</label></td>
                        <td><input type="file" name="csv" id="csv"></td>
                    </tr>
                    <tr>
                        <td><label for="visibility">Would you like your contacts to be visible to other users on Musikandi?</label></td>
                        <td>
                            <select name="visibility" id="visibility">
                                <option value="1">Yes</option>
                                <option value="0">No</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="table">Where would you like to upload your contacts?</label></td>
                        <td>
                            <select name="table" id="table">
                                <?php
                                    foreach ($categories as $key => $value) {
                                        echo '<option value="' . $value['category'] . '">' . $value['name'] . '</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><input type="submit" name="upload_csv" value="Import contacts"></td>
                    </tr>
                </table>
            </form>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>
