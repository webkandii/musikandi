<?php  
    session_start();
    ob_start();
    require('inc/config.php');

    $page_title = 'Add Records • Musikandi';
    $page = 'info';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> <a href="' . $website_path . '"address-book.php>Address Book</a>  <span>&#8250;&#8250;</span> Add Contacts';
    require('inc/functions.php');
    require('inc/header.php');

    if(logged_in() == false) {
        header('Location: ' . $website_path);
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['insert_record'])) {
        $columns = array();
        $data = array();
        $table = protect($_POST['table']);
        $visible = $_POST['visibility'];

        // Remove unnecessary data from _POST 
        unset($_POST['table']); 
        unset($_POST['insert_record']);
        unset($_POST['visibility']);

        // Add names of fields to columns array and add values from fields into data array
        foreach ($_POST as $column_name => $value) {
            $columns[] = $column_name;
            $data[] = $value;
        }

        // Array for use in VALUES function in SQL statement, essentially adding a ':' before each value
        $columns_values = array();
        foreach ($columns as $key => $value) {
            $columns_values[] = ':' . $value;
        }

        try {
            $insert = $conn->prepare('INSERT INTO `' . $table . '` (`name`, `company`, `city`, `postcode`, `tel`, `email`, `web`, `notes`, `owned_by`, `visible`) VALUES(' . implode(',', $columns_values) . ', :owned_by, :visible)');
            foreach ($_POST as $key => &$value) {
                $insert->bindParam(':' . $key, $value, PDO::PARAM_STR);
            }
            $insert->bindParam(':owned_by', $_SESSION['id'], PDO::PARAM_STR);
            $insert->bindParam(':visible', $visible, PDO::PARAM_STR);
            $exec = $insert->execute(); 

            if($exec) {
                $note = "Your new record has been successfully entered into '" . $table . "'";
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
                $note = 'The server encountered an error whilst attempting to insert a record into ' . $table . '.';
            }
        } catch (PDOException $e) {
            $note = 'Could not add record to database. Reason: ' . $e->getMessage();
        }
    }
?>
<head>
<meta name="description" content="Add contacts to your online music directory here.">
</head> 
    <section id="content">
        <div class="container">
            <h1>Add contacts to Musikandi.</h1>

            <p>Select from one of the items below to start adding to a category.</p>

            <div class="new-records data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul>
                        <li><a href="#booking-agents">Booking agents</a></li>
                        <li><a href="#broadcast">Broadcast</a></li>
                        <li><a href="#classical">Classical</a></li>
                        <li><a href="#digital">Digital</a></li>
                        <li><a href="#promoters">Promoters</a></li>
                        <li><a href="#festivals">Festivals</a></li>
                        <li><a href="#festivals-out-of-uk">Festivals outside of UK</a></li>
                        <li><a href="#london-venues">London venues</a></li>
                        <li><a href="#venues-out-of-london">Venues</a></li>
                        <li><a href="#media">Media</a></li>
                        <li><a href="#print">Print</a></li>
                        <li><a href="#worldwide">Worldwide</a></li>
                        <li><a href="#tech">PA/Backline</a></li>
                        <li><a href="#bline">Instruments</a></li>
                        <li><a href="#staff">Sound Engineers</a></li>
                    </ul>
                </div>

                <?php if(isset($note)) { echo '<p><strong>' . $note . '</strong></p>'; } ?>
                <div id="booking-agents" class="data-tab-content">
                    <form method="post" name="form1" class="form">
                        <input type="hidden" name="table" value="agents">
                        <h2>Booking agents</h2>
                        <table> 
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td><a href="#top" class="back-to-top">Top</a></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="broadcast" class="data-tab-content">
                    <form method="post" name="form2" class="form">
                        <input type="hidden" name="table" value="broadcast">
                        <h2>Broadcast</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="classical" class="data-tab-content">
                    <form method="post" name="form2" class="form">
                        <input type="hidden" name="table" value="classical">
                        <h2>Classical</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="digital" class="data-tab-content">
                    <form method="post" name="form3" class="form">
                        <input type="hidden" name="table" value="digital">
                        <h2  id="digital">Digital</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="promoters" class="data-tab-content">
                    <form method="post" name="form8" class="form">
                        <input type="hidden" name="table" value="promoters">
                        <h2  id="promoters">Promoters</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="festivals" class="data-tab-content">
                    <form method="post" name="form4" class="form">
                        <input type="hidden" name="table" value="festivals">
                        <h2 id="festivals">Festivals</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="festivals-out-of-uk" class="data-tab-content">
                    <form method="post" name="form7" class="form">
                        <input type="hidden" name="table" value="nonukfests">
                        <h2>Festivals outside of UK</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="Festival" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="london-venues" class="data-tab-content">
                    <form method="post" name="form5" class="form">
                        <input type="hidden" name="table" value="london">
                        <h2  id="venues">London venues</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="venue" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="London" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">capacity, PA, key staff etc</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="venues-out-of-london" class="data-tab-content">
                    <form method="post" name="form6" class="form">
                        <input type="hidden" name="table" value="venues">
                        <h2>Venues outside London</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="venue" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">capacity, PA, key staff etc</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="media" class="data-tab-content">
                    <form method="post" name="form9" class="form">
                        <input type="hidden" name="table" value="press">
                        <h2 id="media">Media</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="print" class="data-tab-content">
                    <form method="post" name="form10" class="form">
                        <input type="hidden" name="table" value="print">
                        <h2>Print</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="worldwide" class="data-tab-content">
                    <form method="post" name="form10" class="form">
                        <input type="hidden" name="table" value="worldwide">
                        <h2>Worldwide</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="tech" class="data-tab-content">
                    <form method="post" name="form10" class="form">
                        <input type="hidden" name="table" value="tech">
                        <h2>PA Hire</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="bline" class="data-tab-content">
                    <form method="post" name="form10" class="form">
                        <input type="hidden" name="table" value="bline">
                        <h2>Backline / Instruments</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <div id="staff" class="data-tab-content">
                    <form method="post" name="form10" class="form">
                        <input type="hidden" name="table" value="staff">
                        <h2>Sound Engineers</h2>
                        <table>
                            <tr valign="baseline">
                                <td nowrap align="right">Name:</td>
                                <td><input type="text" name="name" value="name" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Company:</td>
                                <td><input type="text" name="company" value="company" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">City:</td>
                                <td><input type="text" name="city" value="city" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Postcode:</td>
                                <td><input type="text" name="postcode" value="postcode/zip" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Tel:</td>
                                <td><input type="text" name="tel" value="telephone" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Email:</td>
                                <td><input type="text" name="email" value="email" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">Web:</td>
                                <td><input type="text" name="web" value="website" size="32"></td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right" valign="top">Notes:</td>
                                <td><textarea name="notes" cols="50" rows="5">notes</textarea></td>
                            </tr>
                            <tr valign="baseline">
                                <td align="right"><label for="visibility">Would you like your contact to be visible to other users on Musikandi?</label></td>
                                <td>
                                    <select name="visibility" id="visibility">
                                        <option value="1">Yes</option>
                                        <option value="0">No</option>
                                    </select>
                                </td>
                            </tr>
                            <tr valign="baseline">
                                <td nowrap align="right">&nbsp;</td>
                                <td><input type="submit" value="Insert record" name="insert_record" class="click"></td>
                            </tr>
                        </table>
                    </form>
                </div>
            </div>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>