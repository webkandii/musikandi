<?php  
    session_start();
    require('inc/config.php');
    require('inc/functions.php');

    $page_title = 'News • Musikandi';
    $page = 'bands';
    $breadcrumb = '<a href="' . $website_path .'">Home</a> <span>&#8250;&#8250;</span> News';
    require('inc/header.php');
?>
    
    <section id="content">
        <div class="container">
           <div class="news-content level">
<div class="news-box">
<div class="news-headline">Agency: <a href="http://julietippex.com/" title="Julie Tippex" target="_blank" class="more quote">Julie Tippex</a></div>
<div class="news-body"><p>Art and music agency. Offices Paris, Berlin and London. Interesting roster with a focus on European bands, with a few UK, American and the rest of the world. Gallon Drunk right through to the Warlocks, with weird pop and techno mixed in. Their email update gives a comprehensive list of tours and band availabilities. Good way to source small to medium sized venues.</p>


</div>
<!-- PIC -->

<img src="/img/news/warlocks.jpg" width="600" height="128" alt="Warlocks" />

</div>

 </div>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>