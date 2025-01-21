<?php
$exp = '/\/\?./';
$string = get_permalink(  );
$res = preg_match($exp, $string);
$d = $res > 0 ? '&' : "?";
get_header();

?>

<section class="individ_lessons_wrapper">
    <div class="individ_lessons_cards">
<?php 
if ( have_posts() ) : while ( have_posts() ) : the_post(); ?>
<?php
if (!empty(get_the_post_thumbnail_url( $post->ID))){ ?>
       <div class="individ_lessons_card" style="background-image: url(<?= get_the_post_thumbnail_url( $post->ID) ?> )">
<?php
} else {
    echo '<div class="individ_lessons_card">';
}
?>      <div class="individ_lessons_content">
            <h1><?php the_title() ?></h1>
            <p><?= get_the_excerpt() ?></p>
            <?php if(is_user_logged_in(  )){ ?>
                <a href=<?php echo get_permalink().$d.'a=cours' ?> class="price__order price__loggedIn" data-u="<?= get_current_user_id() ?>"><?= CFS()->get('ind_price_basic', $post->ID); ?></a>
            <?php } else { ?>
                <a href='' class="price__order price__notLoggedIn"><?= CFS()->get('ind_price_basic', $post->ID); ?></a>
            <?php } ?>
        </div>
    </div>
<?php endwhile; else: ?>
	<h1 class="curs-descr__header">Записей нет.</h1>
<?php endif; ?>
    </div>
</section>

<?php
get_footer();
?>