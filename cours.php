<?php get_header();
/* 
Template Name: Курс
Template Post Type: cours, lessons, page
*/
if(!empty($post)){
$terms = get_the_terms( $post->ID, 'cours');
foreach ( $terms as $term ) {
    $termID[] = $term->term_id;
    $termslug[] = $term->slug;
    $termname[] = $term->name;
}
}
?>

    <section class="curs-invite">
        <h2 class="curs-invite__header"><?php echo $termname[0]; ?></h2>
        <p class="curs-invite__text"><?php if(!empty($termID[0])) echo get_term_meta( $termID[0], 'cours_under_header_txt', true ); ?></p>        
    </section>
    <div class="curs-invite__notice">
        <p class="curs-invite__notice-txt"><?php if(!empty($termID[0])) echo get_term_meta( $termID[0], 'cours_notice_txt', true ); ?></p>
    </div>
    <section class="video-block">
        <h2 class="video__header centered-text">
            <?= CFS()->get('cours_advant_video_title', get_the_ID()); ?>
        </h2>
        <div class="video__super-wr">
            <div class="video__content-wr swiper">
                <div class="video__content swiper-wrapper">
                    <?php $videos = CFS()->get('cours_advant_video_cycle', get_the_ID());
                    if(!empty($videos)){
                        foreach($videos as $video){ ?>
                    <div class="video_video-wr swiper-slide">
                        <video src="<?= $video['cours_advant_video_item'] ?>" class="video__content video"></video>
                        <img src="<?= CFS()->get('play_btn_img', 12) ?>" alt="play" class="hero__play play">
                    </div>
                        <?php } } ?>
                </div>
            </div>
            <svg class="swiper-button-prev video-prev-outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <svg class="swiper-button-next video-next-outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <div class="swiper-pagination video-pagination"></div>            
        </div>
    </section>
    <section class="curs-contian">
        <h2 class="curs-contian__header">
            <?php if(!empty($termID[0])) echo get_term_meta( $termID[0], 'cours_lessons_header', true ); ?>
        </h2>
        <p class="curs-contian__lessons">
            <?php if(!empty($termID[0])) echo get_term_meta( $termID[0], 'cours_lessons_descr', true ); ?>
        </p>
        <div class="curs-contian__content-wr">
            <?php
                $query = new WP_Query([
                    'post_type' => 'lessons',
                    'cours' => $termslug,
                    'orderby' => "ID",
                    'order' => 'ASC',
                	'posts_per_page' => 9999
                ]);
                while ( $query->have_posts() ) {
                    $my_post = $query->next_post();
                    if($my_post->post_parent && get_post($my_post->post_parent)->post_parent != 0){
                        $string = preg_replace("/<h2\s(.+?)>(.+?)<\/h2>/", "$2", $my_post->post_content);
            ?>
            <div class="curs-contian__content">
                <h3 class="curs-contian__lesson-name"><?= $my_post->post_title; ?></h3>
                <div class="curs-contian__lesson-theme"><?= $string; ?></div>
                <p class="curs-contian__text-bold"><?= $my_post->post_excerpt; ?></p>
                <ul class="curs-contian__list">
                    <?php $postOpis = CFS()->get('less_plan_cycle', $my_post->ID);
                    if (!empty($postOpis) && $postOpis != ''){
                        echo '<ul>';
                        foreach($postOpis as $pop){
                            if(!empty($pop['less_plan_header'])){
                                echo '<li class="curs-contian__list-item">'.$pop['less_plan_header'].'</li>';
                            }
                        }
                        echo '</ul>';
                    } ?>
                </ul>
                <a href="<?= get_permalink( $my_post ); ?>" class="curs-contian__lesson-link">Читать подробнее</a>
            </div>
            <?php }}
            wp_reset_postdata(  ); ?>
        </div>
    </section>
    <section class="curs-information">
        <?php if(!empty(CFS()->get('cours_advant_header', get_the_ID()))){ ?>
        <h3 class="curs-information__header"><?= CFS()->get('cours_advant_header', get_the_ID()) ?></h3>
        <?php } ?>
        <div class="curs-information__content-wr">
            <?php $infos = CFS()->get('cours_advant', get_the_ID());
            if (!empty($infos)) {
                foreach($infos as $info) { ?>
            <div class="curs-information__content">
                <div class="curs-information__icon-wr">
                    <img src="<?= $info['cours_advant_img'] ?>" alt="" class="curs-information__icon">
                </div>
                <p class="curs-information__text"><?= $info['cours_advant_txt'] ?></p>
            </div>
            <?php } } ?>
    </section>
    <section class="otz">
        <?php if(!empty(CFS()->get('cours_adv_feeds_header', get_the_ID()))) { ?>
        <h2 class="otz__header centered-text"><?= CFS()->get('cours_adv_feeds_header', get_the_ID()); ?></h2>
        <?php } ?>
        <?php if(!empty(CFS()->get('cours_adv_feeds_cycle', get_the_ID()))) { ?>
        <div class="otz__super-wr">
            <div class="otz__content swiper">
                <div class="swiper-wrapper">
                    <?php 
                    $otzs = CFS()->get('cours_adv_feeds_cycle', get_the_ID());
                    foreach($otzs as $otz) { ?>
                        <div class="otz__slide swiper-slide square">
                            <figure class="wp-block-image size-full"><img class="otz__slide-img" src="<?= $otz['cours_adv_feeds_item'] ?>" alt="" loading='lazy' decoding='async'></figure>
                        </div>
                    <?php } ?>
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
        <?php } ?>
    </section>
<?php get_footer(); ?>    