<?php
/* 
Template Name: 404
*/

get_header();?>
<div class="404_content" style="height: 70vh; padding-top: 150px;">
<h2><?php echo get_the_title(263); ?> </h2>
<h2><?php echo get_the_content(false, false, 263); ?></h2>
</div>

<?php
get_footer();
?>