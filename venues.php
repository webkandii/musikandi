<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Venues • Musikandi';
    $page = 'venues';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Venues';    
    require('inc/header.php');
?>
<head>
<meta name="description" content="Free info on venues in the UK - England, Wales, Scotland and Ireland, and worldwide.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Venues</h1>
             <p>UK, London, festivals and worldwide.</p>
        <?php require('inc/venues-top-content.php'); ?>

            <div id="industry-tabs" class="data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul class="clearfix">
                        <li><a href="#venues" class="active">Venues</a></li>
                        <li><a href="#london">London</a></li>
                        <li><a href="#festivals">Festivals</a></li>
                        <li><a href="#national">National</a></li>
                        <li><a href="#outside-uk">Outside UK</a></li>
                    </ul>
                </div>
                <div id="venues" class="data-tab-content active table-pagination">
                    <h2>Venues</h2>
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
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'venues');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="london" class="data-tab-content table-pagination">
                    <h2>London</h2>
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
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'london');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="festivals" class="data-tab-content table-pagination">
                    <h2>Festivals</h2>
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
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'festivals');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="national" class="data-tab-content table-pagination">
                    <h2>National</h2>
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
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'venues');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="outside-uk" class="data-tab-content table-pagination">
                    <h2>Festivals outside of the UK</h2>
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
                                <?php if(logged_in() == true) { ?>
                                <th>Actions</th>
                                <?php } ?>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $records = display_records('default', $conn, 'nonukfests');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>
