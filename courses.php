<?php get_header(); 

/*
Template Name: Курсы
Template Post Type: page, cours, lessons

*/

?>
    <section class="about small-pad-top no-pad-bot">
        <h2 class="about__header centered-text">
            <?= CFS()->get('cs_head_header', 17); ?>
        </h2>
        <p class="about__txt">
            <?= CFS()->get('cs_head_text', 17); ?>  
        </p>
    </section>
    <section class="courses">
        <?php
            $courses = get_terms( 'cours', [
                'hide_empty' => false,
            ] );
            // if (!empty($courses)){
            // foreach($courses as $cours){
            //     if($cours->slug != 'courses') {
                ?>

         <?php //echo get_term_link($cours->term_id, 'cours');
        //  } }
        //     }
        ?>

        <?php 
            $query = new WP_Query([
                'post_type' => 'lessons',
            	'posts_per_page' => 9999
            ]); 
            while ( $query->have_posts() ) {
                $my_post = $query->next_post();
                if($my_post->post_parent && get_post($my_post->post_parent)->post_parent == 0){
                    $cours = get_the_terms($my_post->ID, 'cours')[0];
                    ?>
                    <div class="courses__course" style="background-image: url(<?php if (function_exists('z_taxonomy_image_url')) echo z_taxonomy_image_url($cours->term_id); ?>);">
                        <div class="courses__content">
                            <h3 class="courses__header"><?= $cours->name ?></h3>
                            <p class="courses__descr"><?= $cours->description ?></p>
                            <a href="<?php echo get_the_permalink($my_post->ID); ?>" class="courses__meet">Ознакомиться с курсом</a>
                        </div>
                    </div>
                <?php }
            }
            wp_reset_postdata();
        ?>
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