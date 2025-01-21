<?php
if ($_SERVER['REQUEST_URI'] == "/lessons/"){
	wp_redirect(home_url(), 301);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <?php 
    if(is_page_template ('individulas.php') || is_page_template ('index.php') || is_page_template ('aboutmaster.php') || is_page_template( 'lk.php' )) { ?>
        <meta name="keywords" content="<?= CFS()->get('page_keywords', $post->ID) ?>">
        <meta name="description" content="<?= CFS()->get('page_description', $post->ID) ?>">
        <title><?= CFS()->get('page_title', $post->ID) ?></title>
    <?php } elseif (is_page_template ('courses.php')){ ?>
        <meta name="keywords" content="<?= CFS()->get('page_keywords', 17) ?>">
        <meta name="description" content="<?= CFS()->get('page_description', 17) ?>">
        <title><?= CFS()->get('page_title', 17) ?></title>
   <?php } else {?>
    
    <meta name="keywords" content="Курс по массажу лица, массаж лица, обучающие курсы массажа">
    <meta name="description" content="Курс по массажу лица"> 
    <title>Курс по массажу лица</title>
    <?php  } 
    wp_head(); ?>
</head>
<body>
    <header>
        <div class="header__content-wr">
            <div class=
            <?php if(!is_page_template( 'lk.php' )){echo "header__left-content-wr";} else {
                echo 'header__left-wr-cours';
            } ?>
            >
                    <?php 
                    if(!is_page_template( 'lk.php' )){
                        wp_nav_menu([
                            'theme_location' => 'header_menu',
                            'container' => '',
                            'menu_class' => 'header__list-wr',
                            'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                        ]);            
                    } else {?>
                        <p class="header__contact">Контакты</p>
                    <?php }
                     ?>
                <a href=<?= get_home_url(); ?>><p class="header__logo"><?= CFS()->get('header_text', 12) ?></span></p></a>
            </div>
            <?php if(is_page_template( 'lk.php' )){ ?>
                <div class="header__menu-exit">
                    <a href=<?= wp_logout_url( home_url(  ) ) ?>>
                    <img src="<?= CFS()->get('lk_exit_icon', 12) ?>" alt="" class="header__exit-dt">
                    <p class="header__exit-txt-dt"><?= CFS()->get('lk_exit_txt', 12) ?></p>
                    </a>
                </div>
                <div class="header__lk-wr">
                    <div class="header__burger"><span class="header__burger-line"></span></div>
                </div>
                <?php } else { ?> 
            <div class="header__right-content-wr">
                <a href="tel: <?= CFS()->get('phone_link', 12) ?>" class="phone"><?= CFS()->get('phone', 12) ?></a>
                <?php if(is_user_logged_in()){ ?>
                    <a href="<?= get_permalink(25); ?>" class="header__btn btn"><?= CFS()->get('header_lk_btn', 12) ?></a>
                <?php } else {?> 
                <p class="header__btn btn_menu_login btn"><?= CFS()->get('header_lk_btn', 12) ?></p>
                <?php } ?>
                <div class="header__lk-wr">
                    <?php if(is_user_logged_in()){ ?>
                        <a href="<?= get_permalink(25); ?>"><img src="<?= CFS()->get('lk_icon', 12) ?>" alt="<?= CFS()->get('header_lk_btn', 12) ?>" class="header__lk_enter"></a>
                     <?php } else {?>  
                    <p class="header__lk-link"><img src="<?= CFS()->get('lk_icon', 12) ?>" alt="<?= CFS()->get('header_lk_btn', 12) ?>" class="header__lk"></p>
                    <?php } ?>
                    <div class="header__burger"><span class="header__burger-line"></span></div>
                </div>
            </div>
            <?php } ?>
            <div class="header__mobile-menu">
                <div>
                <div class="header__mobile-menu-cross"></div>
                <a href=<?= get_home_url(); ?>><p class="header__logo"><?= CFS()->get('header_text', 12) ?></p></a>
                <?php wp_nav_menu([
                        'theme_location' => 'header_menu',
                        'container' => '',
                        'menu_class' => 'header__list-wr-mobile',
                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    ]) ?>                   
                <a href="tel: <?= CFS()->get('phone_link', 12) ?>" class="phone"><?= CFS()->get('phone', 12) ?></a>
                <?php if(is_user_logged_in(  )){?>
                    <div class="header__menu-exit">
                    <a href=<?= wp_logout_url( home_url(  ) ) ?>>
                        <img src="<?= CFS()->get('lk_exit_icon', 12) ?>" alt="" class="header__exit">
                        <p class="header__exit-txt"><?= CFS()->get('lk_exit_txt', 12) ?></p>
                    </a>
                    </div>
                <?php } ?>
                </div>
            </div>
        </div>
        <div class="hidden_auth">
        <div class="cross-wr"><div class="header__auth-menu-cross_sign"></div></div>
            <div class="auth__content">
                <div class="cross-wr"><div class="header__auth-menu-cross header__auth-menu-cross-inner"></div></div>
                <div class="auth__content-wr">

                </div>
            </div>
        </div>
    </header>
<?php 
if (is_404(  ) || is_page_template( 'lk.php' )){

} else {
if( function_exists('kama_breadcrumbs') ) kama_breadcrumbs(' /');
}
?>
