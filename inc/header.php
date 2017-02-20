<?php
    if(isset($_POST['login'])) {
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!$email || !$password) {
            $login_err = 'Please enter a valid email address and password.';
        } else {
            try {
                $check = $conn->prepare('SELECT * FROM `users` WHERE `email` = :email');
                $check->bindParam(':email', $email);
                $check->execute();
                while ($data = $check->fetch()) {
                    $db_id = $data['id'];
                    $db_password = $data['password'];
                    $db_salt = $data['salt'];
                    $db_first_name = $data['first_name'];
                    $db_last_name = $data['last_name'];
                    $db_permissions = $data['permissions'];
                    $db_ab_count = $data['ab_count'];
                    $db_ab_agents = $data['ab_agents'];
                    $db_ab_worldwide = $data['ab_worldwide'];
                    $db_ab_promoters = $data['ab_promoters'];
                    $db_ab_digital = $data['ab_digital'];
                    $db_ab_print = $data['ab_print'];
                    $db_ab_broadcast = $data['ab_broadcast'];
                    $db_ab_venues = $data['ab_venues'];
                    $db_ab_london = $data['ab_london'];
                    $db_ab_festivals = $data['ab_festivals'];
                    $db_ab_nonukfests = $data['ab_nonukfests'];
                    $db_ab_tech = $data['ab_tech'];
                    $db_ab_bline = $data['ab_bline'];
                    $db_ab_staff = $data['ab_staff'];
                    $db_ab_classical = $data['ab_classical'];
                    $count = count($data);
                }

                if($count >= 1) { // Check email address is valid
                    $hash = hash('sha256', $db_salt . hash('sha256', $password));

                    if($hash != $db_password) { // Check password
                        $login_err = 'Please enter a valid email address and password.';
                    } else {
                        validate_user($db_id, $db_first_name, $db_last_name, $email, $db_permissions, $db_ab_count, $db_ab_agents, $db_ab_worldwide, $db_ab_promoters, $db_ab_digital, $db_ab_print, $db_ab_broadcast, $db_ab_venues, $db_ab_london, $db_ab_festivals, $db_ab_nonukfests, $db_ab_tech, $db_ab_bline, $db_ab_staff, $db_ab_classical);
                        header('Location: ' . $website_path . 'address-book.php');
                    }
                } else {
                   $login_err = 'Please enter a valid email address and password.';
                }
            } catch (PDOException $e) {
                $login_err = 'Could not login, please contact us' . $e->getMessage();
            }
        }
    }
?>
<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js"> <!--<![endif]-->
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?php echo $page_title; ?></title>
        <meta name="description" content="A free online editable address book for bands, media and music professionals.">
        <!-- <meta name="viewport" content="width=device-width, initial-scale=1"> -->
        <meta name="viewport" content="width=500, initial-scale=1">
        <!-- 4 Aug 14 * commenting out the above means that mobile devices don't cut off half the background image, problem is you need to rescale it by hand *-->

        <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->

        <link rel="stylesheet" href="css/normalize.css">
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="css/datatables.css">

<!-- slider css and js -->
    <link href="themes/1/js-image-slider.css" rel="stylesheet" type="text/css" />
    <script src="themes/1/js-image-slider.js" type="text/javascript"></script>
<!-- slider css ends -->

        <script src="js/vendor/modernizr-2.6.2.min.js"></script>

<!-- Google Analytics -->
        <script>
            (function(b,o,i,l,e,r){b.GoogleAnalyticsObject=l;b[l]||(b[l]=
            function(){(b[l].q=b[l].q||[]).push(arguments)});b[l].l=+new Date;
            e=o.createElement(i);r=o.getElementsByTagName(i)[0];
            e.src='//www.google-analytics.com/analytics.js';
            r.parentNode.insertBefore(e,r)}(window,document,'script','ga'));
            ga('create','UA-48574451-1');ga('send','pageview');
        </script>

    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="http://browsehappy.com/">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->

        <header <?php if(isset($page) && $page == 'home') { echo 'class="home"'; } ?>>
            <div class="container">
                <?php if(logged_in() == true) { ?>
                <div class="address-book-button">
                    <a href="<?php echo $website_path; ?>address-book.php">Address Book (<span class="address-book-count"><?php echo $_SESSION['ab_count']; ?></span>)</a>
                </div>
                <?php } ?>
                <div class="top">
                    <div class="logo">
                        <a href="<?php echo $website_path; ?>"><img src="<?php echo $website_path; ?>img/logo.png" alt="Musikandi, Logo"></a>
                    </div>
                    <nav>
                        <ul>
                            <li class="dropdown"><a href="<?php echo $website_path; ?>industry.php" <?php if(isset($page) && $page == 'industry') { echo 'class="active"'; } ?>>Industry</a>
                              <div>
                                    <a href="<?php echo $website_path; ?>industry.php#booking-agents">Booking Agents</a>
                                    <a href="<?php echo $website_path; ?>industry.php#worldwide">Worldwide</a>
                                    <a href="<?php echo $website_path; ?>industry.php#promoters">Promoters</a>
                                    <a href="<?php echo $website_path; ?>industry.php#classical">Classical / Jazz</a>
                                </div>
                              </li>
                            <li class="dropdown"><a href="<?php echo $website_path; ?>media.php" <?php if(isset($page) && $page == 'media') { echo 'class="active"'; } ?>>Media</a>
                              <div>
                                    <a href="<?php echo $website_path; ?>media.php#digital">Digital</a>
                                    <a href="<?php echo $website_path; ?>media.php#print">Print</a>
                                    <a href="<?php echo $website_path; ?>media.php#broadcast">Broadcast</a>
                              </div>
                            </li>
                            <li><a href="<?php echo $website_path; ?>" <?php if(isset($page) && $page == 'home') { echo 'class="active"'; } ?>>Home</a></li>
                            <li class="dropdown"><a href="<?php echo $website_path; ?>bands.php" <?php if(isset($page) && $page == 'bands') { echo 'class="active"'; } ?>>Bands</a>
                              <div>
                                    <a href="<?php echo $website_path; ?>tech.php#tech">PA/Backline</a>
                                    <a href="<?php echo $website_path; ?>tech.php#bline">Instruments</a>
                                    <a href="<?php echo $website_path; ?>tech.php#staff">Sound Engineers</a>
                              </div>
                            </li>
                            <li class="dropdown"><a href="<?php echo $website_path; ?>venues.php" <?php if(isset($page) && $page == 'venues') { echo 'class="active"'; } ?>>Venues</a>
                              <div>
                                    <a href="<?php echo $website_path; ?>venues.php#venues">Venues</a>
                                    <a href="<?php echo $website_path; ?>venues.php#london">London</a>
                                    <a href="<?php echo $website_path; ?>venues.php#festivals">Festivals</a>
                                    <a href="<?php echo $website_path; ?>venues.php#national">National</a>
                                    <a href="<?php echo $website_path; ?>venues.php#outside-uk">Outside UK</a>
                                  </div>
                            </li>
                            <?php if(logged_in() == true) { ?>
                            <li class="dropdown">
                                <a href="#">Hello, <?php echo $_SESSION['first_name']; ?></a>
                                <div>
                                    <a href="<?php echo $website_path; ?>address-book.php>"Address book</a>
                                    <a href="<?php echo $website_path; ?>add-contacts.php>"Add contacts</a>
                                    <a href="<?php echo $website_path; ?>import-contacts.php>"Import contacts</a>
                                    <?php if(logged_in() == false && isset($_SESSION['permissions']) && $_SESSION['permissions'] == 'admin') { ?><a href="<?php echo $website_path; ?>info.php">Add records</a><?php } ?>
                                    <a href="<?php echo $website_path; ?>logout.php">Logout</a>
                                </div>
                            </li>
                            <?php } else { ?>
                            <li><a href="<?php echo $website_path; ?>register.php" <?php if(isset($page) && $page == 'register') { echo 'class="active"'; } ?>>Register</a></li>
                            <li class="dropdown">
                                <a href="#" <?php if(isset($_POST['login'])) { echo 'class="active"'; } ?>>Login</a>
                                <div <?php if(isset($_POST['login'])) { echo 'style="display: block;"'; } ?>>
                                    <?php if(isset($login_err)) { echo '<p>' . $login_err . '</p>'; }  ?>
                                    <form method="POST">
                                        <ul class="clearfix">
                                            <li>
                                                <label for="email">Email address:</label>
                                                <input type="text" name="email" id="email" <?php if(isset($_POST['email'])) { echo 'value="' . $_POST['email'] . '"'; } ?>>
                                            </li>
                                            <li>
                                                <label for="password">Password:</label>
                                                <input type="password" name="password" id="password">
                                            </li>
                                            <li>
                                                <input type="submit" value="Log In" name="login">
                                            </li>
                                        </ul>
                                    </form>
                                </div>
                            </li>
                            <?php } ?>
                        </ul>
                    </nav>
                </div>
                <?php if(isset($page) && $page == 'home') { ?>
                <div class="bottom-home">
                    <h1 class="home-heading">A free online editable address book for bands, media and music professionals</h1>

                    <p>Register, create an account and start building an address book. Add contacts, share them or keep them private. Entries can be edited and updated.</p>

                    <div class="search">
                        <form method="GET" action="<?php echo $website_path; ?>search.php">
                            <ul>
                                <li><input type="text" name="q" placeholder="Search for anything! Booking agent, Journalist, Venue..."></li>
                                <li><input type="submit" value="Search"></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <?php } else { ?>
                <div class="bottom-other">
                    <div class="breadcrumb">
                        <p>You are here: <?php echo $breadcrumb; ?></p>
                    </div>
                    <div class="search">
                        <form method="GET" action="<?php echo $website_path; ?>search.php">
                            <ul>
                                <li><input type="text" name="q" placeholder="Search for anything! Booking agent, Journalist, Venue..." <?php if(isset($_GET['q'])) { echo 'value="' . $_GET['q'] . '"'; } ?>></li>
                                <li><input type="submit" value="Search"></li>
                            </ul>
                        </form>
                    </div>
                </div>
                <?php } ?>
            </div>
        </header>
