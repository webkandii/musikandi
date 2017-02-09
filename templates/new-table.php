<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Test • Musikandi';
    $page = 'test';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Test';
    require('inc/header.php');
?>
    
    <section id="content">
        <div class="container">
            <h1>Test</h1>

            <div class="data-tabs">
                <div class="data-tab-nav clearfix">
                    <ul class="clearfix">
                        <li><a href="#table1" class="active">Table 1</a></li>
                        <li><a href="#table2">Table 2</a></li>
                    </ul>
                </div>
                <!-- Add 'table-paginaton' class to enable paged tables. !-->
                <div id="table1" class="data-tab-content active table-pagination">
                    <h2>Table 1</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Address</th>
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
                                $records = display_records('default', $conn, 'table1');
                                foreach ($records as $key => $row) {
                                    echo $row;
                                }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div id="table2" class="data-tab-content table-pagination">
                    <h2>Table 2</h2>
                    <table>
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Title</th>
                                <th>Company</th>
                                <th>Address</th>
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
                                $records = display_records('default', $conn, 'table2');
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
