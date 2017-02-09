<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Industry • Musikandi';
    $page = 'industry';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Industry';
    require('inc/header.php');
?>
<head>
<meta name="description" content="Information about booking agents, promoters and classical musicians.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Industry</h1>
            <p>Key industry contacts booking agents, promoters and a mix of contacts from all over the world.</p>
          
           <?php require('inc/snind2.php');?>
            <div id="industry-tabs" class="data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul class="clearfix">
                        <li><a href="#booking-agents" class="active">Booking Agents</a></li>
                        <li><a href="#worldwide">Worldwide</a></li>
                        <li><a href="#promoters">Promoters</a></li>
                        <li><a href="#classical">Classical / Jazz</a></li>
                    </ul>
                </div>
                <div id="booking-agents" class="data-tab-content active table-pagination">
                    <h2>Booking Agents</h2>
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
                                $records = display_records('default', $conn, 'agents');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="worldwide" class="data-tab-content table-pagination">
                    <h2>Worldwide</h2>
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
                                $records = display_records('default', $conn, 'worldwide');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="promoters" class="data-tab-content table-pagination">
                    <h2>Promoters</h2>
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
                                $records = display_records('default', $conn, 'promoters');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="classical" class="data-tab-content table-pagination">
                    <h2>Classical</h2>
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
                                $records = display_records('default', $conn, 'classical');
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