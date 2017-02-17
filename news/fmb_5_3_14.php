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
<div class="news-headline">Featured artist: some musician.</div>
<div class="news-body"><p>Cras mattis consectetur purus sit amet fermentum. Donec id elit non mi porta gravida at eget metus. Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna maecenas sed diam.<br />

<div class="quote">"Cras mattis consectetur purus sit amet fermentum. Donec id elit non mi porta gravida at eget metus. Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna maecenas sed diam. " <a href="http://www.manchestersfinest.com/music/darkher-the-soup-kitchen-161013-review/" target="_blank" class="publication">Manchester's Finest</a></div><br />

<div class="quote">"Cras mattis consectetur purus sit amet fermentum. Donec id elit non mi porta gravida at eget metus. Aenean lacinia bibendum nulla sed consectetur. Maecenas sed diam eget risus varius blandit sit amet non magna maecenas sed diam." <a href="http://louderthanwar.com/darkher-in-hebden-bridge-live-review/" target="_blank" class="publication">Louder Than War</a></div>
<br />
<br />

<div><a href="http://soundcloud.com/darkher" target="_blank" class="info-1 info-titles"><img src="<?php echo $website_path; ?>img/sc_gradient_18x10.png" width="" height="" alt="Soundcloud"/> Soundcloud DARKHER</a></div>
<div><a href="http://www.facebook.com/DARKHERMUSIC" target="_blank" class="info-2 info-titles"><img src="<?php echo $website_path; ?>img/fb_blue_29.png" width="16" height="16" alt="Facebook"/> DARKHERMUSIC</a></div>
<br /><br />

<a href="http://youtu.be/cOruEGGa2js" target="_blank" class="info-1 info-titles"><img src="<?php echo $website_path; ?>img/uTube.png" width="50" height="31" alt="Youtube"/>DARKHER - 'Ghost Tears'</a>

<a href="http://www.youtube.com/watch?v=6Z0Ljs6_ODA" target="_blank" class="info-2 info-titles youtube"><img src="<?php echo $website_path; ?>img/uTube.png" width="50" height="31" alt="Youtube"/>DARKHER - 'Lament'</a>

<a href="http://www.youtube.com/watch?v=KpMRO123_rU" target="_blank" class="info-3 info-titles"><img src="<?php echo $website_path; ?>img/uTube.png" width="50" height="31" alt="Youtube"/>DARKHER - 'Hung'</a>
<br />
<br />

</div>
</div>
<div class="three-column">
<div class="info-1 info-titles">label: Faun Records</div><div class="info-2 info-titles">agent: Tris Dickin 07958 56 46 24</div>
<div><a href="https://soundcloud.com/faunrecords" target="_blank" class="info-3 info-titles"><img src="<?php echo $website_path; ?>img/sc_gradient_18x10.png" width="" height="" alt="Soundcloud"/> Soundcloud.com Faun Records</a></div>
</div>
<div class="main-news-pic-wrap"><div class="main-news-pic"><img src="../img/news/14/darkher2.jpg" width="954" height="500" />
</div>

<div class="caption">Jayn Hanna</div>

</div>


 </div>
        </div>
    </section>

<?php 
    require('inc/footer.php');
?>
