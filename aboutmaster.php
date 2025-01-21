<?php get_header(); 

/* Template Name: О себе */
?>
    <section class="about-me">
        <div class="about-me-wr">
            <div class="about-me__left-wr">
                <h2 class="about-me__header"><?php the_title(); ?></h2>
                <?php the_content(); ?>
                <?php if(!empty(CFS()->get('about_me_me_img', $post->ID))){
                    echo '<img src="'.CFS()->get('about_me_me_img', $post->ID).'" alt="" class="about-me__photo">';
                } ?>
            </div>
            <img src="<?= CFS()->get('about_me_me_img_right', $post->ID) ?>" alt="" class="about-me__author">
        </div>

    </section>
    <section class="education">
        <h2 class="education__header centered-text"><?= CFS()->get('about_me_edu_header', $post->ID); ?></h2>
        <div class="education__content-wr">
            <div class="education__inst-wr">
                <?php $edus = CFS()->get('about_me_edu_dips_cycle', $post->ID);
                foreach($edus as $edu) { ?>
                <div class="education__inst">
                    <p class="education__year"><?= $edu['about_me_edu_year'] ?></p>
                    <p class="education__text"><?= $edu['about_me_edu_descr'] ?> 
                    </p>
                </div>
                <?php } ?>              
            </div>
            <img src="<?= CFS()->get('about_me_edu_img_prises', $post->ID) ?>" alt="" class="education__prises">
            <div class="education__techniks">
                <p class="education__techniks-text"><span class="bege"><?= CFS()->get('about_me_edu_txt', $post->ID) ?></p>
                <img src="<?= CFS()->get('about_me_edu_img', $post->ID) ?>" alt="" class="education__techniks-img">
            </div>
            <ul class="education__techs-list">
                <?php $lis = CFS()->get('about_me_edu_techs_cycle', $post->ID);
                foreach($lis as $li) { ?> 
                <li class="education__list-item"><?= $li['about_me_edu_techs_descr'] ?></li>
                <?php } ?>
            </ul>
        </div>
    </section>
    <section class="diplomas no-pad-bot-ed">
        <h2 class="diplomas__header centered-text"><?= CFS()->get('about_me_edu_diplomas_header') ?></h2>
        <div class="diplomas__super-wr">
            <div class="diplomas__content swiper">
                <div class="swiper-wrapper">
                    <?php $dips = CFS()->get('about_me_edu_diplomas_cycle');
                    foreach($dips as $dip) {
                        echo '<div class="diplomas__slide swiper-slide square"><img class="diplomas__slide-img" src="'.$dip['about_me_edu_diplomas_img'].'" alt=""></div>';
                    } ?>
                </div>
            </div>  
            <svg class="swiper-button-prev diplomas_prev_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="25" cy="25" r="25" fill="#DFB19C"/>
                <path d="M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg class="swiper-button-next diplomas_next_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="25" cy="25" r="25" fill="#DFB19C"/>
                <path d="M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>    
            <div class="swiper-pagination diplomas-pagination"></div>            
        </div>
    </section>
    <section class="otz">
        <h2 class="otz__header"> <?php echo(get_category(22)->name) ?></h2>
        <div class="otz__super-wr">
            <div class="otz__content swiper">
                <div class="swiper-wrapper">
                <?php
                        $my_posts = get_posts( array(
                            'numberposts' => 10,
                            'category'    => 22,
                            'orderby'     => 'date',
                            'order'       => 'DESC',
                        ) );
                        global $post;
                        foreach($my_posts as $my_post) {
                            setup_postdata($my_post);
                    ?>
                    <div class="otz__slide swiper-slide square"><?php the_content(); ?></div>
                    <?php
                        wp_reset_postdata();
                    } ?>
                </div>
            </div>  
            <svg class="swiper-button-prev prev_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <svg class="swiper-button-next next_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>    
            <div class="swiper-pagination otz-pagination"></div>            
        </div>
    </section>
<?php get_footer(); ?>    