<?php get_header(); 
/* Template Name: Главная */
?>
    
    <section class="hero">
        <h1 class="hero__header">
            <?= CFS()->get('mp_header', 12) ?>
            <a href="" class="hero__btn"><?= CFS()->get('mp_btn_text', 12) ?> <img src="<?= CFS()->get('mp_btn_icon', 12) ?>" alt="arrow" class="hero__arrow"></a>
        </h1>
        <div class="hero__video-wr">
            <figure class="wp-block-video"><video src="<?= CFS()->get('mp_main_video', 12) ?>" class="hero__video video"></video></figure>
            <img src="<?= CFS()->get('play_btn_img', 12) ?>" alt="play" class="hero__play play">
        </div>        
    </section>
    <section class="about">
        <h2 class="about__header">
            <?= CFS()->get('mp_curs_header', 12) ?>
        </h2>
        <p class="about__txt">
            <?= CFS()->get('mp_curs_text', 12) ?>
        </p>
        <img src="<?= CFS()->get('mp_curs_img', 12) ?>" alt="Записывайтесь на курс по массажу лица">
    </section>
    <section class="author">
        <div class="author__content-wr">
            <div class="author__left-wr">
                <h2 class="author__header">
                    <?= CFS()->get('mp_author_header', 12) ?>
                </h2>
                <p class="author__txt">
                    <?= CFS()->get('mp_author_text', 12) ?>
                </p>
            </div>
            <img src="<?= CFS()->get('mp_author_img', 12) ?>" alt="Автор курса - Екатерина Воронова" class="author__portriat">
        </div>
    </section>
    <section class="advantages">
        <h2 class="advantages__header">
            <?= CFS()->get('mp_advantages_header', 12); ?>
        </h2>
        <div class="advantages__icns">
            <?php
                $advs = CFS()->get('mp_advantages_cycle', 12);
                foreach($advs as $adv) {
            ?>
            <div class="advantages_card">
                <img src="<?= $adv['mp_advantages_img'] ?>" alt="Премущество" class="advantages__icon">
                <p class="advantages__descr"><?= $adv['mp_advantages_txt'] ?></p>
            </div>
            <?php
                }
            ?>
        </div>
    </section>
    <section class="actions">
        <h2 class="actions__header">
            <?php echo(get_category(18)->name) ?>
        </h2>   
        <div class="actions__super-wr">
            <div class="actions__content swiper">
                <div class="actions__content-inn-wr swiper-wrapper">
                    <?php
                        $my_posts = get_posts( array(
                            'numberposts' => 10,
                            'category'    => 18,
                            'orderby'     => 'date',
                            'order'       => 'DESC',
                        ) );
                        global $post;
                        foreach($my_posts as $my_post) {
                            setup_postdata($my_post);
                    ?>
                    <div class="actions__slide swiper-slide" id="actions__img1"><?php the_content();?></div>
                    <?php 
                        wp_reset_postdata();
                    } ?>
                </div>
            </div>
            <svg class="swiper-button-prev actions-prev" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <svg class="swiper-button-next actions-next" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <?= CFS()->get('nav_btns', 12); ?>
            </svg>
            <div class="swiper-pagination actions-pagination"></div>            
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
    <div class="signup_for_curs">
    <div class="cross-wr"><div class="header__auth-menu-cross"></div></div>
        <div class="signup__content_wr">
        <div class="cross-wr"><div class="header__auth-menu-cross_sign header__auth-menu-cross-inner"></div></div>
            <form action="" class="sign">
                <h2 class="header">Записаться на курс</h2>
                <input type="text" name="singn_name" class="singn_name" id="sign_name" placeholder="Имя">
                <input type="text" name="sign_phone" class="sign_phone" id="sign_phone" placeholder="Телефон">
                <input type="text" name="sign_mail" class="sign_mail" id="sign_mail" placeholder="E-mail">
                <input type="submit" name="sign_sub" class="sign_sub" value="Записаться">
            </form>
        </div>
    </div>
<?php get_footer(); ?>    