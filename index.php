<?php
    ini_set('display_errors',1);
    ini_set('display_startup_errors',1);
    error_reporting(-1);

    session_start();  
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'Musikandi';
    $page = 'home';
    require('inc/header.php');
?>
<head>
<meta name="description" content="A free online address book for bands, media and music professionals.">
</head>    
     <section id="content">
        <div class="container">

 <?php require('inc/about.php');?>
         

            </div> 
     </section>
<?php require('inc/footer.php');?>
