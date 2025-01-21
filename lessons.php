<?php
    require __DIR__ . '/vendor/autoload.php';
	use YooKassa\Client;
get_header(); 

/*
Template Name: Занятие
Template Post Type: lessons
*/
$exp = '/\/\?./';
$string = get_permalink(  );
$res = preg_match($exp, $string);
$d = $res > 0 ? '&' : "?";

$post_term_id = get_the_terms($post->ID, 'cours')[0]->term_id;
$cours_price = get_term_meta( $post_term_id, 'price_title_full', true );
$cours_val = get_term_meta( $post_term_id, 'val_n_descr', true );
$cours_descr = get_term_meta( $post_term_id, 'under_descr', true );

if(isset($_GET['a'])){
    if($_GET['a'] == 'cours'){
        $price = str_replace(' ', '', $cours_price);
        $cp = $post->post_parent;
    }
    if($_GET['a'] == 'lesson'){
        $price = str_replace(' ', '', CFS()->get('ind_prices_price', $post->ID));
        $cp = $post->ID;
    }
    $fbs = get_user_meta( get_current_user_id(  ), 'paid', false );
    $data = array(
        'ok' => 0,
        'type' => ''
    );
    if(count($fbs)>0){
        foreach($fbs as $fb){
            if($cp == $fb){
                $childrens = get_children( [
                    'post_parent' => $fb,
                    'post_type'   => 'lessons',
                    'numberposts' => 10,
                    'post_status' => 'publish'
                ] );
                if (!empty($childrens)){
                    $type = 'курс';
                } else {
                    $type = "урок";
                }
                $data['type'] = $type;
                $data['ok'] = 2;
            }
        }
    }
    if($data['ok'] == 2) {
        echo ('<script>
        alert("Вы уже приобрели этот '.$type.'")
        location.replace("'.get_permalink(  ).'")
        </script>');
    } else {
        $client = new Client();
        $client->setAuth('263872', 'test_Yxxd_freeR2P6ql7WhSL_Z99JnDnfWsqhHPHqWe5fs8');
        $lk_href = get_page_link( 25);
        $payment = $client->createPayment(
        array(
            'amount' => array(
                'value' => $price,
                'currency' => 'RUB',
            ),
            'confirmation' => array(
                'type' => 'redirect',
                'return_url' => $lk_href,
            ),
            'capture' => true,
            'description' => 'Оплата покупки на сайте "' . get_bloginfo() . '" '.$type.' '.get_post($cp)->post_title,
            'metadata' => array(
                'lesson_id' => $cp,
            ),
            'receipt' => array(
                'customer' => array(
                    'email' => wp_get_current_user( )->user_email,
                ),
                'items' => array(
                    array(
                        'description' => 'Оплата покупки на сайте "' . get_bloginfo() . '" '.$type.'а '.get_post($cp)->post_title,
                        'quantity' => '1.00',
                        'amount' => array(
                            'value' => $price,
                            'currency' => 'RUB'
                        ),
                        'vat_code' => '1',
                        'payment_mode' => 'full_payment',
                    ),
                )
            ),
            uniqid('massage', true)
        )
    );
    if(isset($payment->confirmation->confirmation_url)){
        add_user_meta( get_current_user_id(  ), 'purchases', $payment->ID, false );
        echo ('<script>location.replace("'.$payment->confirmation->confirmation_url.'")</script>');
    }
}
}
?>
    <section class="lesson-description">
        <div class="lesson-description__header-wr">
            <h2 class="lesson-description__header"><?php the_title(); ?></h2>
            <h2 class="lesson-description__header"><?php the_content(  ); ?></h2>
        </div>
        <div class="lesson-description__content-wr">
            <?php $opis = CFS()->get('less_plan_cycle', $post->ID);
            if(!empty($opis)){
            foreach($opis as $o){
                echo '<div class="lesson-description__content-line">';
            if(!empty($o['less_plan_img'])){ ?>
                <img src="<?= $o['less_plan_img'] ?>" alt="" class="lesson-description-img">
                <div class="lesson-description__content-text-wr">
            <?php } else {?>            
                <div class="lesson-description__content-text-wr single">
            <?php } ?>
            <ul class="lesson-description-list"><li class="lesson-description-list-item"><?= $o['less_plan_header'] ?></li></ul>
                    <p class="lesson-description-text"><?= $o['less_plan_descr'] ?></p>
                </div>
            </div> <?php  
        }} ?>
        </div>
    </section>
    <section class="video-block pad-bot">
        <h2 class="video__header centered-text">
            <?= CFS()->get('less_video_header', $post->ID); ?>
        </h2>
        <div class="video__super-wr">
            <div class="video__content-wr swiper">
                <div class="video__content swiper-wrapper">
                    <?php $vids = CFS()->get('less_video_cycle', $post->ID);
                    if(!empty($vids)){
                        foreach($vids as $vid){ ?>
                            <div class="video_video-wr swiper-slide">
                                <video src="<?= $vid['less_video_item'] ?>" class="video__content video"></video>
                                <img src="<?= CFS()->get('play_btn_img', 12) ?>" alt="play" class="hero__play play">
                            </div>
                    <?php    }
                    } ?>
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
    <section class="price">
        <h2 class="price__header centered-text"><?= CFS()->get('ind_prices_header', $post->ID); ?></h2>
        <div class="price__content-wr">
            <?php
                $term = get_the_terms($post->ID, 'cours')[0]->term_id;
                $t_meta = get_term_meta( $term, 'cours_lessons_split', true );
                if($t_meta !== 'yes'){
                    $style = 'style="grid-column: 1/-1;"';
                } else {
                    $style = '';
                }
            ?>
            <div class="price__wr"  <?= $style ?>>
                <div class="price__content">
                    <h3 class="price__content-header"><?= $cours_price.' '.$cours_val ?></h3>
                    <p class="price__content-txt"><?= $cours_descr ?></p>
                </div>
                <?php if(is_user_logged_in(  )){ ?>
                    <a href=<?php echo get_permalink().$d.'a=cours' ?> class="price__order price__loggedIn" data-u="<?= get_current_user_id() ?>" data-n='<?= $post->post_parent ?>'><?= CFS()->get('ind_prices_btn', $post->ID); ?></a>
                <?php } else { ?>
                    <a href='' class="price__order price__notLoggedIn"><?= CFS()->get('ind_prices_btn_hour', $post->ID); ?></a>
                <?php } ?>
            </div>
            <?php 
                if($t_meta === 'yes'){ ?>
            <div class="price__wr">
                <div class="price__content">
                    <h3 class="price__content-header"><?= CFS()->get('ind_prices_price', $post->ID).' '.CFS()->get('ind_prices_val', $post->ID) ?></h3>
                    <p class="price__content-txt"><?= CFS()->get('ind_prices_descr', $post->ID) ?></p>
                </div>
                <?php
                if(is_user_logged_in(  )){ ?>
                    <a href=<?php echo get_permalink().$d.'a=lesson' ?> data-u="<?= get_current_user_id() ?>" data-n="<?= $post->ID ?>" class="price__order price__loggedIn"><?= CFS()->get('ind_prices_btn_hour', $post->ID); ?></a>
                <?php } else { ?>
                    <a href="" class="price__order price__notLoggedIn" ><?= CFS()->get('ind_prices_btn_hour', $post->ID); ?></a>
                <?php }} ?>
            </div>
            <p class="price__notice"><?= CFS()->get('ind_prices_notice', $post->ID); ?></p>
            <p class="price__garant"><?= CFS()->get('ind_prices_garant', $post->ID); ?></p>
        </div>
    </section>
    <section class="otz">
        <h2 class="otz__header centered-text"><?= CFS()->get('less_otz_header', $post->ID) ?></h2>
        <div class="otz__super-wr">
            <div class="otz__content swiper">
                <div class="swiper-wrapper">
                    <?php $less_otzs = CFS()->get('less_otz_cycle', $post->ID);
                    foreach($less_otzs as $lotz){
                        echo '<div class="otz__slide swiper-slide square"><img class="otz__slide-img" src="'.$lotz['less_otz_item'].'" alt=""></div>';
                    } ?>
                </div>
            </div>  
            <svg class="swiper-button-prev prev_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="25" cy="25" r="25" fill="#DFB19C"/>
                <path d="M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <svg class="swiper-button-next next_outer" width="50" height="50" viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="25" cy="25" r="25" fill="#DFB19C"/>
                <path d="M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>    
            <div class="swiper-pagination otz-pagination"></div>            
        </div>
    </section>
    <?php 
    get_footer();
     ?>   