<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();
    $query = $_GET['q'];
    require('inc/config.php');

    $search = $conn->prepare('(SELECT *, "Agents" as `origin`, "agents" as `table` FROM `agents` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q)) 
        UNION
        (SELECT *, "Broadcast" as `origin`, "broadcast" as `table` FROM `broadcast` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
(SELECT *, "Classical" as `origin`, "classical" as `table` FROM `classical` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Digital" as `origin`, "digital" as `table` FROM `digital` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Festivals" as `origin`, "festivals" as `table` FROM `festivals` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Worldwide" as `origin`, "worldwide" as `table` FROM `worldwide` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "London" as `origin`, "london" as `table` FROM `london` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Festivals outside of UK" as `origin`, "nonukfests" as `table` FROM `nonukfests` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Print" as `origin`, "print" as `table` FROM `print` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Promoters" as `origin`, "promoters" as `table` FROM `promoters` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
 UNION
        (SELECT *, "Tech" as `origin`, "tech" as `table` FROM `tech` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
(SELECT *, "Bline" as `origin`, "bline" as `table` FROM `bline` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
(SELECT *, "Staff" as `origin`, "staff" as `table` FROM `staff` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))
        UNION
        (SELECT *, "Venues" as `origin`, "venues" as `table` FROM `venues` WHERE `visible` = 1 AND (`name` LIKE :q OR `company` LIKE :q OR `city` LIKE :q OR `postcode` LIKE :q OR `tel` LIKE :q OR `email` LIKE :q OR `web` LIKE :q))'
        );
    $search_query = '%' . $query . '%';
    $search->bindParam(':q', $search_query);
    $search->execute();
    $count = $conn->query('SELECT FOUND_ROWS()')->fetchColumn();

    $page_title = "Results for '" . $query . "' • Musikandi";
    $page = 'search';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> Search results';
    require('inc/functions.php');
    require('inc/header.php');
?>
<head>
<meta name="description" content="Search for music contacts at this free online database.">
</head>   
    <section id="content">
        <div class="container">
            <h1>Search results</h1>
            <p>We have found <?php echo $count; ?> records that match '<?php echo $query; ?>'!</p>
            
            <?php if($count > 0) { ?>

            <div class="table-pagination">
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
                            <th>Origin</th>
                            <?php if(logged_in() == true) { ?>
                            <th>Actions</th>
                            <?php } ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            while ($results = $search->fetch()) {
                                $id = $results['id'];
                                $name = $results['name'];
                                $company = $results['company'];
                                $city = $results['city'];
                                $postcode = $results['postcode'];
                                $tel = $results['tel'];
                                $email = $results['email'];
                                $web = $results['web'];
                                $owned_by = $results['owned_by'];
                                $origin = $results['origin'] . ' <a href="' . get_category_url($categories, $results['table']) . '">View all</a>'; 
                                $table = $results['table'];
                                $ab_table = 'ab_' . $table;
                                $return_url = 'http://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . '&hash=' . $table;
                                $class = '';
                                $actions = '';
                
                                if(logged_in() == true) {
                                    $onclick = "return confirm('Are you sure you want to delete this record (ID " . $id . ") from " . $table . "?')";
                                    if(in_address_book($id, $_SESSION[$ab_table]) == true) {
                                        $actions = '<a href="#" class="remove-from-address-book show-tooltip" data-id="' . $id . '" data-table="' . $table . '" data-del="false" original-title="Remove ' . $name . ' from address book"></a>';
                                        $class = ' class="in-address-book"';
                                    } else {
                                        $actions = '<a href="#" class="add-to-address-book show-tooltip" data-id="' . $id . '" data-table="' . $table . '" original-title="Add ' . $name . ' to address book"></a>';
                                    }
                
                                    if($_SESSION['permissions'] == 'admin' || $owned_by == $_SESSION['id']) {
                                       $actions .= '<a href="edit.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" class="edit-record"></a> <a href="delete.php?r=' . $id . '&table=' . $table . '&return=' . $return_url . '" onclick="' . $onclick . '" class="delete-record"></a>';
                                    }
                                }
                
                                $row = <<<row
                            <tr$class>
                                <td>$name</td>
                                <td>$company</td>
                                <td>$city</td>
                                <td>$postcode</td>
                                <td>$tel</td>
                                <td><a href="mailto:$email">$email</a></td>
                                <td><a href="$web">$web</a></td>
                                <td>$origin</td>
                                <td class="actions-td"><div>$actions</div></td>
                            </tr>
row;
                                echo $row;
                            }
                        ?>
                    </tbody>
                </table>
                <?php } ?>
            </div>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>