<footer>
        <div class="footer__content">
            <a href=<?= get_home_url(); ?>><p class="footer__course"><?= CFS()->get('footer_text', 12); ?></p></a>
            <div class="footer__right">
                <?php wp_nav_menu([
                        'theme_location' => 'header_menu',
                        'container' => '',
                        'menu_class' => 'footer__list',
                        'items_wrap' => '<ul class="%2$s">%3$s</ul>',
                    ]) ?>
                <div class="footer__soc">
                    <?php
                        $socs = CFS()->get('socials', 12);
                        foreach($socs as $soc){ ?>
                            <a href="<?= $soc['footer_soc_link']['url'] ?>" class="footer__link"><img src=<?= $soc['footer_soc_name'] ?> alt=<?= $soc['footer_soc_link']['text'] ?> class="footer_soc-img"></a>
                      <?php  }
                    ?>
                </div>           
            </div>
        </div>
    </footer>
    <?php wp_footer(); ?>
</body>
</html>