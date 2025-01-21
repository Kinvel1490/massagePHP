<?php get_header(); 

/* Template Name: Индивидуальные занятия */
?>
    <section class="curs-descr">
            <h2 class="curs-descr__header">
                <?= CFS()->get('ind_header_header', $post->ID); ?>
            </h2>
            <p class="curs-descr__header-txt"><?= CFS()->get('ind_header_subheader', $post->ID); ?>
            </p>
            <div class="curs-descr__content-wr">
            <div class="curs-descr__content">
                <ol class="curs-descr__numbered">
                    <?php $numlist = CFS()->get('ind_themes_cycle', $post->ID);
                    foreach($numlist as $ni){ ?>
                    <li class="curs-descr__list-item-num">
                        <?php if(!empty($ni['ind_themes_item_header'])){ ?>
                            <h4 class="curs-descr__head"><?= $ni['ind_themes_item_header']; }?></h4>
                        <?php if(!empty($ni['ind_themes_item_descr'])){ ?>
                            <p class="curs-descr__txt"><?= $ni['ind_themes_item_descr']; } ?></p>
                        <?php if(!empty($ni['ind_themes_descr_cycle'])) { ?>
                        <ul class="curs-descr__unnumbered">
                            <?php foreach($ni['ind_themes_descr_cycle'] as $uni){
                                echo '<li class="curs-descr__list-item">'.$uni['ind_themes_descr_item'].'</li>';
                            } ?>
                        </ul>
                        <?php } ?>                    
                    </li>
                    <?php } ?>
                </ol>
                <p class="curs-descr__notice"><?= CFS()->get('ind_themes_txt', $post->ID) ?></p>
                <p class="curs-descr__await"><?= CFS()->get('ind_themes_txt2', $post->ID) ?></p>
            </div>            
        </div>
    </section>
    <section class="video-block">
        <h2 class="video__header">
        <?php echo(get_category(20)->name) ?>
        </h2>
        <div class="video__super-wr">
            <div class="video__content-wr swiper">
                <div class="video__content swiper-wrapper">
                <?php
                        $my_posts = get_posts( array(
                            'numberposts' => 10,
                            'category'    => 20,
                            'orderby'     => 'date',
                            'order'       => 'DESC',
                        ) );
                        global $post;
                        foreach($my_posts as $my_post) {
                            setup_postdata($my_post);
                    ?>
                    <div class="video_video-wr swiper-slide">
                        <?php the_content(); ?>
                        <img src="<?= CFS()->get('play_btn_img', 12) ?>" alt="play" class="hero__play play">
                    </div>
                    <?php 
                        wp_reset_postdata();
                    } ?>
                </div>
            </div>
            <svg class="swiper-button-prev video-prev-outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 29); ?>
            </svg>
            <svg class="swiper-button-next video-next-outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 29); ?>
            </svg>
            <div class="swiper-pagination video-pagination"></div>            
        </div>

    </section>
    <section class="examples">
        <h2 class="examples__header centered-text"><?= CFS()->get('examples_header', $post->ID); ?></h2>
        <div class="examples__super-wr">
            <div class="examples__content swiper">
                <div class="swiper-wrapper">
                    <?php $exs = CFS()->get('examples_cycle', $post->ID);
                    foreach($exs as $ex){
                        echo '<div class="examples__slide swiper-slide  square"><img class="examples__slide-img" src="'.$ex['examples_item'].'" alt=""></div>';
                    } ?>
                </div>
            </div>  
            <svg class="swiper-button-prev examples_prev_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <svg class="swiper-button-next examples_next_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>    
            <div class="swiper-pagination examples-pagination"></div>            
        </div>
    </section>
    <section class="price">
        <h2 class="price__header centered-text"><?= CFS()->get('ind_prices_header', $post->ID) ?></h2>
        <div class="price__content-wr">
            <?php $tabs = CFS()->get('ind_prices_cycle', $post->ID);
            foreach($tabs as $tab){ ?>
            <div class="price__content">
                <h3 class="price__content-header"><?= $tab['ind_prices_price']." ".$tab['ind_prices_val']; ?></h3>
                <p class="price__content-txt"><?= $tab['ind_prices_descr'] ?></p>
            </div>
            <?php } ?>
            <p class="price__notice"><?= CFS()->get('ind_prices_notice', $post->ID) ?></p>
            <p class="price__garant"><?= CFS()->get('ind_prices_garant', $post->ID) ?></p>
            <button type="button" class="price__order price__order_from_shower"><?= CFS()->get('ind_prices_btn', $post->ID) ?></button>
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