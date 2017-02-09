<?php  
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();
    ob_start();
    require('inc/config.php');
    $page_title = 'Edit • Musikandi';
    $page = 'info';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Edit record';

    require('inc/functions.php');
    require('inc/header.php');    

    if(logged_in() == false) {
        header('Location: ' . $website_path);
    }

    $id = $_GET['r'];
    $table = $_GET['table'];
    $return_url = $_GET['return'] . '#' . $_GET['hash'];

    $get_record = $conn->prepare('SELECT * FROM `' . $table . '` WHERE `id` = :id');
    $get_record->execute(array(':id' => $id));
    while ($data = $get_record->fetch()) {
        $name = $data['name'];
        $title = $data['title'];
        $company = $data['company'];
        $address = $data['address'];
        $city = $data['city'];
        $postcode = $data['postcode'];
        $tel = $data['tel'];
        $email = $data['email'];
        $web = $data['web'];
        $notes = $data['notes'];
        $visible = $data['visible'];
        $owned_by = $data['owned_by'];
    }

    if($_SESSION['permissions'] != 'admin' && $_SESSION['id'] != $owned_by) {
        header('Location: ' . $website_path);
    }

    if(isset($_POST['update_record'])) {
        $name = $_POST['name'];
        $title = $_POST['title'];
        $company = $_POST['company'];
        $address = $_POST['address'];
        $city = $_POST['city'];
        $postcode = $_POST['postcode'];
        $tel = $_POST['tel'];
        $email = $_POST['email'];
        $web = $_POST['web'];
        $notes = $_POST['notes'];
        $visible = $_POST['visibility'];

        try {
            $update = $conn->prepare('UPDATE `' . $table . '` SET `name` = :name, `title` = :title, `company` = :company, `address` = :address, `city` = :city, `postcode` = :postcode, `tel` = :tel, `email` = :email, `web` = :web, `notes` = :notes, `visible` = :visible WHERE `id` = :id');
            $exec = $update->execute(array(
                ':name' => $name,
                ':title' => $title,
                ':company' => $company,
                ':address' => $address,
                ':city' => $city,
                ':postcode' => $postcode,
                ':tel' => $tel,
                ':email' => $email,
                ':web' => $web,
                ':notes' => $notes,
                ':visible' => $visible,
                ':id' => $id,
            ));   

            if($exec) {
                $note = 'Successfully updated record. <a href="' . $return_url . '" class="mkandi_csv">Go back</a>';
            } else {
                $note = 'The server encountered an error whilst attempting to update the record. Please try again.';
            }   
        } catch (PDOException $e) {
            echo 'The server encountered an error, reason: ' . $e->getMessage();
        }
    }
?>
<head>
<meta name="description" content="Edit information on your music contacts.">
</head>  
    <section id="content">
        <div class="container">
            <h1>Edit record</h1>

            <p>You are editing the record with the ID of <strong><?php echo $id ?></strong> from <strong><?php echo $table; ?></strong>. <a href="<?php echo $return_url; ?>" class="mkandi_csv">Go back</a>.</p>

            <?php if(isset($note)) { echo '<p><strong>' . $note . '</strong></p>'; } ?>
            <form method="post" class="form">
                <table> 
                    <tr valign="baseline">
                        <td nowrap align="right">Name:</td>
                        <td><input type="text" name="name" size="32" value="<?php if(isset($name)) { echo $name; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Title:</td>
                        <td><input type="text" name="title"size="32" value="<?php if(isset($title)) { echo $title; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Company:</td>
                        <td><input type="text" name="company" size="32" value="<?php if(isset($company)) { echo $company; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Address:</td>
                        <td><input type="text" name="address" size="32" value="<?php if(isset($address)) { echo $address; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">City:</td>
                        <td><input type="text" name="city" size="32" value="<?php if(isset($city)) { echo $city; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Postcode:</td>
                        <td><input type="text" name="postcode" size="32" value="<?php if(isset($postcode)) { echo $postcode; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Tel:</td>
                        <td><input type="text" name="tel" size="32" value="<?php if(isset($tel)) { echo $tel; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Email:</td>
                        <td><input type="text" name="email" size="32" value="<?php if(isset($email)) { echo $email; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">Web:</td>
                        <td><input type="text" name="web" size="32" value="<?php if(isset($web)) { echo $web; } ?>"></td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right" valign="top">Notes:</td>
                        <td><textarea name="notes" cols="50" rows="5"><?php if(isset($notes)) { echo $notes; } ?></textarea></td>
                    </tr>
                    <tr>
                        <td><label for="visibility">Would you like your contacts to be visible to other users on Musikandi?</label></td>
                        <td>
                            <select name="visibility" id="visibility">
                                <option value="1" <?php if($visible == '1') { echo 'selected'; } ?>>Yes</option>
                                <option value="0" <?php if($visible == '0') { echo 'selected'; } ?>>No</option>
                            </select>
                        </td>
                    </tr>
                    <tr valign="baseline">
                        <td nowrap align="right">&nbsp;</td>
                        <td><input type="submit" value="Update record" name="update_record" class="click"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><a href="#top" class="back-to-top">Top</a></td>
                    </tr>
                </table>
            </form>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>
