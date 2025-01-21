<?php 

if(!is_user_logged_in(  ) && is_page_template( 'lk.php' )){
    wp_redirect( home_url( ) );
}

get_header(); 

/* Template Name: Личный кабинет */



if (function_exists('checkPurchases')){
    checkPurchases();
}
?>
    <section class="lk">
        <div class="lk__stadium-wr">
            <div class="lk__stadium">
                <div class="lk__menu">
                    <div class="lk__menu-item-wr lk__active"  id="lk_1">
                        <img src="<?= CFS()->get('lk_profile_ico', $post->ID) ?>" alt="профиль" class="lk__img">
                        <p class="lk__txt"><?= CFS()->get('lk_profile_txt', $post->ID) ?></p>
                    </div>
                    <div class="lk__menu-item-wr" id="lk_2">
                        <img src="<?= CFS()->get('lk_courses_ico', $post->ID) ?>" alt="курсы" class="lk__img">
                        <p class="lk__txt"><?= CFS()->get('lk_courses_txt', $post->ID) ?></p>
                    </div>
                    <div class="lk__menu-item-wr" id="lk_3">
                        <img src="<?= CFS()->get('lk_supp_ico', $post->ID) ?>" alt="поддержка" class="lk__img">
                        <p class="lk__txt"><?= CFS()->get('lk_supp_txt', $post->ID) ?></p>
                    </div>
                </div>
                <div class="lk__right-wr">
   
                </div>            
            </div>            
        </div>

    </section>
    <?php get_footer(); ?>