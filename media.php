<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Media • Musikandi';
    $page = 'media';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Media';
    require('inc/header.php');
?>
<head>
<meta name="description" content="Media contacts including online and digital, print, radio and TV.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Media</h1>
            <p>Scroll down for print, broadcast and digital.</p>
           <?php require('inc/snmedia.php');?>
            <div id="industry-tabs" class="data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul class="clearfix">
                        <li><a href="#digital" class="active">Digital</a></li>
                        <li><a href="#print">Print</a></li>
                        <li><a href="#broadcast">Broadcast</a></li>
                    </ul>
                </div>
                <div id="digital" class="data-tab-content active table-pagination">
                    <h2>Digital</h2>
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
                                $records = display_records('default', $conn, 'digital');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="print" class="data-tab-content table-pagination">
                    <h2>Print</h2>
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
                                $records = display_records('default', $conn, 'print');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="broadcast" class="data-tab-content table-pagination">
                    <h2>Broadcast</h2>
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
                                $records = display_records('default', $conn, 'broadcast');
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
