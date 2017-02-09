<?php  
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $count = $_SESSION['ab_count'];

    $agents = explode(', ', $_SESSION['ab_agents']);
    $agents_count = count_arr($agents);

    $worldwide = explode(', ', $_SESSION['ab_worldwide']);
    $worldwide_count = count_arr($worldwide);

    $promoters = explode(', ', $_SESSION['ab_promoters']);
    $promoters_count = count_arr($promoters);

    $digital = explode(', ', $_SESSION['ab_digital']);
    $digital_count = count_arr($digital);

    $print = explode(', ', $_SESSION['ab_print']);
    $print_count = count_arr($print);

    $broadcast = explode(', ', $_SESSION['ab_broadcast']);
    $broadcast_count = count_arr($broadcast);

    $venues = explode(', ', $_SESSION['ab_venues']);
    $venues_count = count_arr($venues);

    $london = explode(', ', $_SESSION['ab_london']);
    $london_count = count_arr($london);

    $festivals = explode(', ', $_SESSION['ab_festivals']);
    $festivals_count = count_arr($festivals);

    $nonukfests = explode(', ', $_SESSION['ab_nonukfests']);
    $nonukfests_count = count_arr($nonukfests);

    $tech = explode(', ', $_SESSION['ab_tech']);
    $tech_count = count_arr($tech);

    $bline = explode(', ', $_SESSION['ab_bline']);
    $bline_count = count_arr($bline);

    $staff = explode(', ', $_SESSION['ab_staff']);
    $staff_count = count_arr($staff);

    $classical = explode(', ', $_SESSION['ab_classical']);
    $classical_count = count_arr($classical);

    $page_title = 'Address Book • Musikandi';
    $page = 'addressbook';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Address Book';    
    require('inc/header.php');
?>
<head>
<meta name="description" content="This is your digital address book accessible only by you.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Address Book</h1>
            
            <?php if($count == '0' || empty($count)) { ?>
            <p><?php echo $_SESSION['first_name']; ?>, you currently have no contacts in your address book!</p>
            <?php } else { ?>
            <p><?php echo $_SESSION['first_name']; ?>, you currently have <span class="address-book-count"><?php echo $count; ?></span> contacts in your address book!</p>

            <p><a href="add-contacts.php" class="green-btn">Add contact</a> <a href="import-contacts.php" class="green-btn">Import contacts (csv)</a></p>

            <div class="new-records data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul>
                        <li><a href="#booking-agents">Booking agents (<?php echo $agents_count; ?>)</a></li>
                        <li><a href="#broadcast">Broadcast (<?php echo $broadcast_count; ?>)</a></li>
                        <li><a href="#classical">Classical (<?php echo $classical_count; ?>)</a></li>
                        <li><a href="#digital">Digital (<?php echo $digital_count; ?>)</a></li>
                        <li><a href="#promoters">Promoters (<?php echo $promoters_count; ?>)</a></li>
                        <li><a href="#festivals">Festivals (<?php echo $festivals_count; ?>)</a></li>
                        <li><a href="#festivals-out-of-uk">Festivals outside of UK (<?php echo $nonukfests_count; ?>)</a></li>
                        <li><a href="#london-venues">London Venues(<?php echo $london_count; ?>)</a></li>
                        <li><a href="#venues-out-of-london">Venues(<?php echo $venues_count; ?>)</a></li>
                        <li><a href="#media">Media (<?php echo $print_count; ?>)</a></li>
                        <li><a href="#worldwide">Worldwide(<?php echo $worldwide_count; ?>)</a></li>
                        <li><a href="#tech">PA/Backline(<?php echo $tech_count; ?>)</a></li>
                        <li><a href="#bline">Instruments(<?php echo $bline_count; ?>)</a></li>
                        <li><a href="#staff">Sound Engineers (<?php echo $staff_count; ?>)</a></li>
                    </ul>
                </div>

                <div id="booking-agents" class="data-tab-content">
                    <?php if($agents_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'agents');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="broadcast" class="data-tab-content">
                    <?php if($broadcast_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'broadcast');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="classical" class="data-tab-content">
                    <?php if($classical_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'classical');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="digital" class="data-tab-content">
                    <?php if($digital_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'digital');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="promoters" class="data-tab-content">
                    <?php if($promoters_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'promoters');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="festivals" class="data-tab-content">
                    <?php if($festivals_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'festivals');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="festivals-out-of-uk" class="data-tab-content">
                    <?php if($nonukfests_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'nonukfests');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="london-venues" class="data-tab-content">
                    <?php if($london_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'london');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="venues-out-of-london" class="data-tab-content">
                    <?php if($venues_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'venues');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="media" class="data-tab-content">
                    <?php if($print_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'print');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="worldwide" class="data-tab-content">
                    <?php if($worldwide_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'worldwide');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="tech" class="data-tab-content">
                    <?php if($tech_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'tech');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="bline" class="data-tab-content">
                    <?php if($bline_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'bline');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
                <div id="staff" class="data-tab-content">
                    <?php if($staff_count == '0') { ?>
                    <p>You have no records for this category in your address book!</p>
                    <?php } else { ?>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Company</th>
                                <th>City</th>
                                <th>Postcode</th>
                                <th>Tel</th>
                                <th>Email</th>
                                <th>Web</th>
                                <th>Notes</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_address_book('default', $conn, 'staff');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                    <?php } ?>
                </div>
            <?php } ?>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>