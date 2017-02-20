<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Bands • Musikandi';
    $page = 'bands';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Bands';
    require('inc/header.php');
?>
<head>
<meta name="description" content="Information for bands. Hire companies, PA rental, sound engineers and lights.">
</head>    
    <section id="content">
        <div class="container">
            <h1>Bands</h1>
             <p>Information for bands. Most of the things you'd need to put on a gig including backline hire companies, PA rental, sound engineers, staging, instrument hire, lights. Scroll down for the lists.</p>
             <?php require('inc/bands-top-content.php');?>
               <div id="industry-tabs" class="data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul class="clearfix">
                        <li><a href="#tech" class="active">PA/Backline</a></li>
                        <li><a href="#bline">Instruments</a></li>
                        <li><a href="#staff">Sound Engineers</a></li>
                    </ul>
                </div>
                <div id="tech" class="data-tab-content active table-pagination">
                    <h2>PA/Backline</h2>
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
                                $records = display_records('default', $conn, 'tech');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="bline" class="data-tab-content table-pagination">
                    <h2>Instruments</h2>
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
                                $records = display_records('default', $conn, 'bline');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="staff" class="data-tab-content table-pagination">
                    <h2>Sound Engineers</h2>
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
                                $records = display_records('default', $conn, 'staff');
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
