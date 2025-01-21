<?php
	require __DIR__ . '/vendor/autoload.php';
	use YooKassa\Client;
	$kassa_shop_id = ''; // store number
	$kassa_secret = ''; //store secret


add_action('wp_enqueue_scripts', 'enqueue_my_scripts_n_styles');
add_action('login_enqueue_scripts', 'enqueue_my_login_scripts_n_styles');
add_action('after_setup_theme', 'add_features');
add_filter('nav_menu_css_class', 'my_custom_classes', 10, 4);
add_action( 'wp_ajax_mylogin', 'loginUser');
add_action( 'wp_ajax_nopriv_mylogin', 'loginUser');
// add_action( 'wp_ajax_mylogout', 'logoutUser');
// add_action( 'wp_ajax_nopriv_mylogout', 'logoutUser');
add_action( 'wp_ajax_myregister', 'registerUser');
add_action( 'wp_ajax_nopriv_myregister', 'registerUser');
add_action( 'wp_ajax_myforget', 'forgetUser');
add_action( 'wp_ajax_nopriv_myforget', 'forgetUser');
add_action( 'wp_ajax_myGetUser', 'myGetUser');
add_action( 'wp_ajax_nopriv_myGetUser', 'myGetUser');
add_action( 'wp_ajax_mySaveUserChanges', 'mySaveUserChanges');
add_action( 'wp_ajax_nopriv_mySaveUserChanges', 'mySaveUserChanges');
add_action( 'wp_ajax_myAddAvatar', 'myAddAvatar');
add_action( 'wp_ajax_nopriv_myAddAvatar', 'myAddAvatar');
// add_action( 'wp_ajax_mybuy', 'mybuy');
// add_action( 'wp_ajax_nopriv_mybuy', 'mybuy');
add_action( 'wp_ajax_myAddCurs', 'myAddCurs');
add_action( 'wp_ajax_nopriv_myAddCurs', 'myAddCurs');
add_action( 'wp_ajax_sendHelp', 'sendHelp');
add_action( 'wp_ajax_nopriv_sendHelp', 'sendHelp');
add_action( 'wp_ajax_myNotation', 'myNotation');
add_action( 'wp_ajax_nopriv_myNotation', 'myNotation');
add_action( 'wp_ajax_signForIndiividuals', 'signForIndiividuals');
add_action( 'wp_ajax_nopriv_signForIndiividuals', 'signForIndiividuals');
// add_action( 'init', 'un_authorized_redirect');
add_action( 'init', 'un_authorized_redirect_lk');

function enqueue_my_scripts_n_styles () {
    wp_enqueue_style ('main_style', get_stylesheet_uri(), array(), '1.0', 'all');

    wp_deregister_script( 'jquery' );
    // wp_register_script( 'jquery', 'https://cdn.jsdelivr.net/npm/jquery@3.7.0/dist/jquery.min.js', null, true);
    wp_register_script( 'jquery', get_template_directory_uri().'/assets/js/code.jquery.com_jquery-3.7.0.min.js', null, true);
    wp_enqueue_script('jquery');
    wp_enqueue_script('swiper', get_template_directory_uri().'/assets/js/swiper-bundle.min.js', null, false, true);
    if(is_page_template('lk.php')){
        wp_enqueue_script('lk', get_template_directory_uri().'/assets/js/lk.js', array('jquery'), false, true);
    }
	if(is_page_template( 'individulas.php' )){
        wp_enqueue_script('imask', get_template_directory_uri().'/assets/js/imask.js', array('jquery'), false, true);
	}
    wp_enqueue_script('main', get_template_directory_uri().'/assets/js/main.js', array('jquery'), false, true);
    wp_localize_script( 'main', 'myajax_data', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'nonce' => wp_create_nonce(),
        'hidepass' => CFS()->get('hiden_pass', 12),
        'showpass' => CFS()->get('show_pass', 12),
		'redact' => CFS()->get('lk_redact_ico', 25),
		'redact_txt' => CFS()->get('lk_redact_txt', 25),
		'back_wards' => CFS()->get('lk_backwards_arrow', 25),
		'open_close' => CFS()->get('lk_open_close', 25),
		'lk_prev' => CFS()->get('player_prev', 25),
		'LK_play' => CFS()->get('player_play', 25),
		'lk_next' => CFS()->get('player_next', 25),
		'vid_play' => CFS()->get('play_btn_img', 12),
    ) );
}

function enqueue_my_login_scripts_n_styles () {
	wp_enqueue_style( 'l_style', get_template_directory_uri(  ).'/assets/css/l_style.css', false );
	wp_enqueue_script( 'passres', get_template_directory_uri(  ).'/assets/js/passres.js', false, false, true );

	wp_localize_script( 'passres', 'peremen', array(
		'hidepass' => CFS()->get('hiden_pass', 12),
        'showpass' => CFS()->get('show_pass', 12)
	) );
}

if ( current_user_can( 'subscriber' ) ) {
    show_admin_bar( false );
}

function add_features(){
    add_theme_support('post-thumbnails');
    add_theme_support('custom-logo');
    add_theme_support('menus');
    add_theme_support('post-formats', array('video', 'image'));

    register_nav_menu('header_menu', 'Главное меню');
}

function my_custom_classes ($classes, $menu_item, $args, $depth) {
    if($args->theme_location == 'header_menu') {
    $classes = array('header__menu-item');
    return $classes;
    }
}

function loginUser () {
    $resp = array(
        'ok' => 0,
        'error' => 0,
		'link' => ''
    );
    $email = $_POST['text'];
    $creds['user_login'] = get_user_by( 'email', $email )->user_login;
    $creds['user_password'] = $_POST['pass'];
    $creds['remember'] = true;
    $nonce = $_POST['nonce'];
    $ctrl = wp_create_nonce();
    if ($ctrl != $nonce){wp_die();}
	if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on'){
		$user = wp_signon( $creds, true );
	} else {
		$user = wp_signon( $creds, false );
	}
    if ( is_wp_error($user) ) {
        $resp ['error'] = 1;
        } else  {
		wp_set_current_user($user->ID);
        $resp['ok'] = true;
		$resp['link'] = get_page_link( 25 );
        }    
    print_r (json_encode ($resp));
    wp_die();
}

function logoutUser () {
    if(isset($_POST['text']) && $_POST['text'] == 'logout') {
        wp_logout(  );
		wp_get_current_user();
        echo 'ok';
    }
    wp_die();
}

function registerUser () {
    $resp = array(
        'ok' => 0,
        'error' => 0
    );
    $nonce = $_POST['nonce'];
    $ctrl = wp_create_nonce();
    if ($ctrl != $nonce){wp_die();}
    $pass = $_POST['pass'];
    $pass2 = $_POST['pass2'];
    $email = strtolower($_POST['text']);
    $login = createLogin();
    if(username_exists(get_user_by( 'email', $email )->user_login)){
        $resp['error'] = 1;
        print_r(json_encode($resp));
    } elseif ($pass != $pass2) {
        $resp['error'] = 2;
        print_r(json_encode($resp));
    } else {
        wp_create_user( $login, $pass, $email );
        wp_signon( array(
            'user_login' => $login,
            'user_password' => $pass,
            'remember' => true
        ), false );
        $resp['ok'] = 1;
        print_r(json_encode($resp));
    }
    wp_die();
}

function createLogin () {
    $newLogin = 'user';
    $numbs = [];
	$mass = ['1', '2', '3', '4','5','6','7','8','9','0','a','A','b','B','c','C','d','D','e','E','f','F','g','G','h','H','i','I','j','J','k','K','l','L','m','M','n','N','o','O','p','P','q','Q','s','S','t','T','u','U','v','V','w','W','x','X','y','Y','z','Z'];
	$c = count($mass) - 1;
    for($i=0; $i<15; $i++) {
      $numbs[] = $mass[mt_rand(0, $c)];
    }
    $newLogin .= implode('',$numbs);
    return $newLogin;
}

function forgetUser () {
	if(!wp_verify_nonce( $_POST['nonce'] )){wp_die();}
	$resp = array(
        'ok' => 0,
        'error' => 0
    );
	$mail_msg = esc_attr(wp_strip_all_tags(get_the_content(false, false, 184)));
	$mail_title = get_the_title(184);
	if($user = get_user_by( 'email', $_POST['text'])){
		$ul = $user->user_login;
		$prk = get_password_reset_key( $user );
		$headers = array(
			'From: Екатерина Воронова <no@reply.com>',
			'content-type: text/html',
		);
		$mail_msg .= home_url().'/wp-login.php?action=rp&login='.rawurlencode($ul).'&key='.$prk;
		wp_mail( $_POST['text'], $mail_title, $mail_msg, $headers);
	}
	$resp['ok'] = $_POST['text'] ." " . $mail_title ." " . $mail_msg .' '. $headers;
	print_r(json_encode( $resp ));
	wp_die();		
}

function myGetUser () {
    $nonce = $_POST['nonce'];
    $ctrl = wp_create_nonce();
    if ($ctrl != $nonce){wp_die();}
	$resp = array(
        'ok' => 0,
        'error' => 0,
		'user' => ''
    );
	$cu = wp_get_current_user();
	$phone = get_user_meta($cu->ID, 'phone', true);
	$mail = $cu->user_email;
	$name = $cu->user_login;
	$avatar = get_user_meta($cu->ID, 'avatar', true);
	if (isset($cu)){
		$resp['ok'] = 1;
		$resp['user'] = array(
			'phone' => $phone,
			'mail' => $mail,
			'name' => $name,
			'avatar' => $path = home_url().'/wp-content/uploads/avatars/user'.get_current_user_id(  ).'/'.$avatar
		);
	} else {
		$resp['error'] = 1;
	}
	print_r(json_encode($resp));
	wp_die();
}

function mySaveUserChanges () {
	global $wpdb;
	$phone = strval($_POST['phone']);
	$nonce = $_POST['nonce'];
	$err = 0;
	$ctrl = wp_create_nonce();
    if ($ctrl != $nonce){wp_die();}
	$cu_ID = wp_get_current_user()->ID;
	$cu_login = wp_get_current_user()->user_login;
	$cu_mail = wp_get_current_user()->user_email;
	$resUser = username_exists($_POST['name']);
	$resp = array(
        'mail_ok' => 0,
		'user_ok' => 0,
		'phone_ok' => 0,
		'pass_ok' => 0,
        'mail_error' => 0,
        'user_error' => 0,
        'phone_error' => 0,
		'pass_error' => 0,
    );
	if(isset($_POST['name'])){
		$mail = strtolower($_POST['mail']);
		if($resUser && $cu_login != $_POST['name'] ) {
			$resp['user_error'] = 1;
			$err = 1;
		} else {
			$resp['user_ok'] = 1;
		}
	}
	if(isset($_POST['mail'])){
		if(email_exists($mail) && $cu_mail != $mail){
			$resp['mail_error'] = 1;
			$err = 1;
		} else {
			$resp['mail_ok'] = 1;
		}
	}	
	if($err == 0){
		$done_user = $wpdb->update(
			'wp_users',
			['user_login' => $_POST['name'],
			 'display_name' => $_POST['name'],
			 'user_nicename' => $_POST['name']
			],
			['ID' => $cu_ID]
		);
		if($done_user == 0 || !$done_user ){
			$resp['user_error'] = 2;
		}
		$done_mail = $wpdb->update(
			'wp_users',
			['user_email' => $_POST['mail']],
			['ID' => $cu_ID]
		);
		if($done_mail == 0 || !$done_mail ){
			$resp['mail_error'] = 2;
		} else {$resp['mail_ok'] = 1;}
		if(isset($phone)){
			$phone_upd = update_user_meta($cu_ID, 'phone', sanitize_text_field($phone));
		} else {
			delete_user_meta($cu_ID, 'phone');
		}
		if(isset($_POST['pwd']) && !empty($_POST['pwd'])){
			$newpwd = trim( wp_unslash( $_POST['pwd'] ) );
			wp_set_password($newpwd, $cu_ID);
		}
	}
	print_r(json_encode($resp));
	wp_die();
}

function myAddCurs () {
	check_ajax_referer( 'myAddCurs', '', false );
	$paids = get_user_meta( get_current_user_id(), 'paid', false );
	$data = '<img src="'.CFS()->get('lk_backwards_arrow', 25).'" alt="Назад" class="lk__backwards-mobile-only">
    <h2 class="lk__header"  id="lk__curs">Курсы</h2>';
	$script = '{';
	$paids = checkPP($paids);
	if(!empty($paids['courses'])){
		foreach($paids['courses'] as $key => $cours) {
			$cp = get_post( $key );
				$data .= '    
				<div class="lk__info" id="lk_limit-width">
					<div class="lk__curs-wr">
						<h3 class="lk_curs-name">'.$cp->post_title.'</h3>
						<img src="'.CFS()->get('lk_open_close', 25).'" alt="arrow" class="lk_curs-arrow">
					</div>
					<div class="lk__curs-content-wr">';
					foreach($cours as $ckey => $c){
						$p = get_post($c);
						$string = preg_replace("/<h2\s(.+?)>(.+?)<\/h2>/", "$2", $p->post_content);
						$vids = CFS()->get('less__paid_videos_cycle', $p->ID);
						$script .= '"less'.$key.$ckey.'": [';
						if(!empty($vids)){
							$vidcount = count($vids);
							$counter = 0;
							foreach($vids as $kvid => $vid){
								$counter++;
								if($counter == $vidcount){
									$script .= '{"v":"'.$vid['less__paid_videos_item'].'", "n":"'.$vid['less__paid_videos_name'].'"}';
								} else {
									$script .= '{"v":"'.$vid['less__paid_videos_item'].'", "n":"'.$vid['less__paid_videos_name'].'"}, ';
								}
							}
						}
						$script .=  '], ';
						$data .= '
							<div class="lk__curs-content" data-c="less'.$key.$ckey.'">
								<p class="lk__curs-content-head">'.$p->post_title.'</p>
								<p class="lk__curs-content-txt">'.$string.'</p>
							</div>';
					}					
				$data .= '</div></div>';
		}
    	$script .= '}';
		$data .= '</div>';
	}
	if(!empty($paids['lessons'])){
		$data .= '<h2 class="lk__header"  id="lk__curs">Уроки</h2>';
		foreach($paids['lessons'] as $key => $cours) {
			$cp = get_post( $key );
				$data .= '    
				<div class="lk__info" id="lk_limit-width">
					<div class="lk__curs-wr">
						<h3 class="lk_curs-name">'.$cp->post_title.'</h3>
						<img src="'.CFS()->get('lk_open_close', 25).'" alt="arrow" class="lk_curs-arrow">
					</div>
					<div class="lk__curs-content-wr">';
					foreach($cours as $ckey => $c){
						$p = get_post($c);
						$string = preg_replace("/<h2\s(.+?)>(.+?)<\/h2>/", "$2", $p->post_content);
						$vids = CFS()->get('less__paid_videos_cycle', $p->ID);
						if(!empty($vids)){
						$vidcount = count($vids);
						$counter = 0;
						$script .= '"less'.$key.$ckey.'": {';
						foreach($vids as $kvid => $vid){
							$counter++;
							if($counter == $vidcount){
								$script .= '{"v":"'.$vid['less__paid_videos_item'].'", "n":"'.$vid['less__paid_videos_name'].'"}';
							} else {
								$script .= '{"v":"'.$vid['less__paid_videos_item'].'", "n":"'.$vid['less__paid_videos_name'].'"}, ';
							}
						}
					}
						$script .=  '}, ';
						$data .= '
							<div class="lk__curs-content" data-c="less'.$key.$ckey.'">
								<p class="lk__curs-content-head">'.$p->post_title.'</p>
								<p class="lk__curs-content-txt">'.$string.'</p>
							</div>';
					}					
				$data .= '</div></div>';
		}
		$data .= '</div>';
		$script .= '}';
	}
	$resp = array(
		'content' => $data,
		'script' => $script
	);
	print_r(json_encode($resp));
	wp_die();
}

function checkPP($pps) {
	$courses = array();
	$lessons = array();
	$searches = array();
	foreach($pps as $pp) {
		$pc = get_children( [
			'post_parent' => $pp,
			'post_type' => 'lessons',
			'numberposts' => 1000,
			'post_status' => 'publish',
			'orderby' => 'ID',
			'order' => 'ASC'
		] );
		if(!empty($pc)){
			$courses[$pp] = array();
			foreach($pc as $p){
				$courses[$pp][] = $p->ID; 
			}
		}
	}
	foreach ($pps as $pp) {
		$pc = get_children( [
			'post_parent' => $pp,
			'post_type' => 'lessons',
			'numberposts' => -1,
			'post_status' => 'publish',
			'orderby' => 'ID',
			'order' => 'ASC'
		] );
		if(empty($pc)){
			$lespar = get_post($pp)->post_parent;
			if(!array_key_exists($lespar, $courses)){
				if(!array_key_exists($lespar, $lessons)){
					$lessons[$lespar] = array();
				} 
				if (array_key_exists($lespar, $lessons)) {
					$lessons[$lespar][] = $pp;
				}
			}
		}
	}
	return [
		'courses' => $courses, 
		'lessons' => $lessons];
}

function myAddAvatar () {
	if( isset( $_POST['nonce'] ) ){

		if($_POST['nonce'] != wp_create_nonce()){wp_die("oops");}
		$resp = [
			'error' => 0,
			'ok' => 0
		];
		$uploaddir = '../wp-content/uploads/avatars/user'.get_current_user_id(  ); // . - текущая папка где находится submit.php
		$avapath = '../wp-content/uploads/avatars';
		// cоздадим папку если её нет
		if( ! is_dir( $avapath ) ) mkdir( $avapath, 0777 );
		if( ! is_dir( $uploaddir ) ) mkdir( $uploaddir, 0777 );
		$files      = $_FILES; // полученные файлы
		$done_files = array();
		$sizedata = getimagesize( $_FILES['avatar']['tmp_name'] );
		$max_size = 512;
		if( $sizedata[0]/*width*/ > $max_size || $sizedata[1]/*height*/ > $max_size ) {
		$resp['error'] = ( __('Картинка не может быть больше чем '. $max_size .'px в ширину или высоту','km') );}
		
		if($resp['error'] === 0) {
		// обрабатываем загрузку файла
		require_once ABSPATH . 'wp-admin/includes/image.php';
		require_once ABSPATH . 'wp-admin/includes/file.php';
		require_once ABSPATH . 'wp-admin/includes/media.php';

		// фильтр допустимых типов файлов - разрешим только картинки
		add_filter( 'upload_mimes', function( $mimes ){
			return [
				'jpg|jpeg|jpe' => 'image/jpeg',
				'gif'          => 'image/gif',
				'png'          => 'image/png',
			];
		} );
		
		// переместим файлы из временной директории в указанную
		foreach( $files as $file ){
			$file_name = cyrillic_translit( $file['name'] );
	
			if( move_uploaded_file( $file['tmp_name'], "$uploaddir/$file_name" ) ){
				$done_files[] = realpath( "$uploaddir/$file_name" );
			}
		}
		// echo $file_name;
		if(empty(get_user_meta( get_current_user_id(  ), 'avatar', true))){
			add_user_meta( get_current_user_id(  ), 'avatar', $file_name, true );
		} else {
			update_user_meta( get_current_user_id(  ), 'avatar', $file_name );
		}
		}
		$resp['ok'] = home_url().'/wp-content/uploads/avatars/user'.get_current_user_id(  ).'/'.get_user_meta( get_current_user_id(  ), 'avatar', true);
		print_r(json_encode( $resp));
		wp_die( );
	}
}

//uncomment when get store number & store secret
function mybuy () {
	// check_ajax_referer( 'mybuy', $_POST['nonce'], false );
	// $fbs = get_user_meta( get_current_user_id(  ), 'paid', false );
	// $price = CFS()->get('ind_prices_price', $_POST['n']) ? CFS()->get('ind_prices_price', $_POST['n']) : CFS()->get('ind_prices_btn', $post->ID);
	

	// $post_term_id = get_the_terms($post['n'], 'cours')[0]->term_id;
	// $cours_price = get_term_meta( $post_term_id, 'price_title_full', true );
	// $price2 = CFS()->get('ind_prices_btn', $post->ID);

	
	// // if(isset($_POST['n']) && isset($_POST['p'])){
	// 	if(count($fbs)>0){
	// 		foreach($fbs as $fb){
	// 			if($_POST['n'] == $fb){
	// 				$childrens = get_children( [
	// 					'post_parent' => $fb,
	// 					'post_type'   => 'lessons',
	// 					'numberposts' => -1,
	// 					'post_status' => 'publish'
	// 				] );
	// 				if (!empty($childrens)){
	// 					$type = 'курс';
	// 				} else {
	// 					$type = "урок";
	// 				}
	// 				$data = [
	// 					'ok' => '2',
	// 					'type' => $type
	// 				];
	// 				print_r (json_encode($data));
	// 				wp_die();
	// 			}
	// 		}
	// 	}

		// $client = new Client();
		// $client->setAuth('263872', 'test_Yxxd_freeR2P6ql7WhSL_Z99JnDnfWsqhHPHqWe5fs8');
		// $lk_href = get_page_link( 25);
		// $payment = $client->createPayment(
		// 	array(
		// 		'amount' => array(
		// 			'value' => $price,
		// 			'currency' => 'RUB',
		// 		),
		// 		'confirmation' => array(
		// 			'type' => 'redirect',
		// 			'return_url' => $lk_href,
		// 		),
		// 		'capture' => true,
		// 		'description' => 'Оплата покупки на сайте "' . get_bloginfo() . '" '.$type.' '.get_post($_POST['n'])->post_title,
		// 		'metadata' => array(
		// 			'lesson_id' => $_POST['n'],
		// 		),
		// 		'receipt' => array(
		// 			'customer' => array(
		// 				'email' => wp_get_current_user( )->user_email,
		// 			),
		// 			'items' => array(
		// 				array(
		// 					'description' => 'Оплата покупки на сайте "' . get_bloginfo() . '" '.$type.'а '.get_post($_POST['n'])->post_title,
		// 					'quantity' => '1.00',
		// 					'amount' => array(
		// 						'value' => $price,
		// 						'currency' => 'RUB'
		// 					),
		// 					'vat_code' => '1',
		// 					'payment_mode' => 'full_payment',
		// 				),
		// 			)
		// 		),
		// 		uniqid('massage', true)
		// 	)
		// );
		// if(isset($payment->confirmation->confirmation_url)){
		// 	$data = [
		// 		'ok' => 1,
		// 		'url' => $payment->confirmation->confirmation_url
		// 	];
		// 	add_user_meta( get_current_user_id(  ), 'purchases', $payment->ID, false );
		// 	print_r(json_encode($data));
			// wp_die(  );
		// }
	// }
}

function checkPurchases () {
	$user_purchases = get_user_meta( get_current_user_id(  ), 'purchases', false );
	if(!empty($user_purchases)){
		$exists = false;
		$client = new Client();
		$client->setAuth('263872', 'test_Yxxd_freeR2P6ql7WhSL_Z99JnDnfWsqhHPHqWe5fs8');
		foreach($user_purchases as $purchase) {
			$payment = $client->getPaymentInfo($purchase);
			if($payment->status == "succeeded"){
				$um = get_user_meta( get_current_user_id(  ), 'paid', false );
				if(!empty($um)){
					foreach($um as $p) {
						if ($p == $payment->metadata->lesson_id) {
							$exists = true;
						}
					}
				}
				if(!$exists){
					add_user_meta( get_current_user_id(  ), 'paid', $payment->metadata->lesson_id, false );
				}
				add_user_meta( get_current_user_id(  ), 'complete_buys', $purchase, false );
				delete_user_meta( get_current_user_id(  ), 'purchases', $purchase );
			}
			if ($payment->status == 'canceled') {
				delete_user_meta( get_current_user_id(  ), 'purchases', $purchase );
			}
		}
	}
}

function un_authorized_redirect_lk () {
	if(is_login() && !isset($_GET['action'])){
		wp_redirect( home_url() );
	}
	if(is_admin() && !current_user_can( 'administrator' ) ){
		if(is_admin() && !current_user_can( 'editor' ) ){
			wp_redirect( home_url( ) );
		}
	}
}

function sendHelp () {
	check_ajax_referer( 'sendHelp', $_POST['nonce'], false );
	$user = wp_get_current_user(  );
	$theme = 'Обращение в техподдержку от '.$user->user_email;
	$supp_mail = CFS()->get('support_email', 12);
	$help_msg = $_POST['help'];
	// $headers = array(
	// 	'From: '.get_bloginfo().' <no@reply.com>',
	// 	'content-type: text/html',
	// );
	if(wp_mail($supp_mail, $theme, $help_msg)){
		$data = 'ok';
	} else {
		$data = 'error';
	}
	echo $data;
	wp_die();
}


	## Транслитирация кирилических символов
function cyrillic_translit( $title ){
	$iso9_table = array(
		'А' => 'A', 'Б' => 'B', 'В' => 'V', 'Г' => 'G', 'Ѓ' => 'G',
		'Ґ' => 'G', 'Д' => 'D', 'Е' => 'E', 'Ё' => 'YO', 'Є' => 'YE',
		'Ж' => 'ZH', 'З' => 'Z', 'Ѕ' => 'Z', 'И' => 'I', 'Й' => 'J',
		'Ј' => 'J', 'І' => 'I', 'Ї' => 'YI', 'К' => 'K', 'Ќ' => 'K',
		'Л' => 'L', 'Љ' => 'L', 'М' => 'M', 'Н' => 'N', 'Њ' => 'N',
		'О' => 'O', 'П' => 'P', 'Р' => 'R', 'С' => 'S', 'Т' => 'T',
		'У' => 'U', 'Ў' => 'U', 'Ф' => 'F', 'Х' => 'H', 'Ц' => 'TS',
		'Ч' => 'CH', 'Џ' => 'DH', 'Ш' => 'SH', 'Щ' => 'SHH', 'Ъ' => '',
		'Ы' => 'Y', 'Ь' => '', 'Э' => 'E', 'Ю' => 'YU', 'Я' => 'YA',
		'а' => 'a', 'б' => 'b', 'в' => 'v', 'г' => 'g', 'ѓ' => 'g',
		'ґ' => 'g', 'д' => 'd', 'е' => 'e', 'ё' => 'yo', 'є' => 'ye',
		'ж' => 'zh', 'з' => 'z', 'ѕ' => 'z', 'и' => 'i', 'й' => 'j',
		'ј' => 'j', 'і' => 'i', 'ї' => 'yi', 'к' => 'k', 'ќ' => 'k',
		'л' => 'l', 'љ' => 'l', 'м' => 'm', 'н' => 'n', 'њ' => 'n',
		'о' => 'o', 'п' => 'p', 'р' => 'r', 'с' => 's', 'т' => 't',
		'у' => 'u', 'ў' => 'u', 'ф' => 'f', 'х' => 'h', 'ц' => 'ts',
		'ч' => 'ch', 'џ' => 'dh', 'ш' => 'sh', 'щ' => 'shh', 'ъ' => '',
		'ы' => 'y', 'ь' => '', 'э' => 'e', 'ю' => 'yu', 'я' => 'ya'
	);

	$name = strtr( $title, $iso9_table );
	$name = preg_replace('~[^A-Za-z0-9\'_\-\.]~', '-', $name );
	$name = preg_replace('~\-+~', '-', $name ); // --- на -
	$name = preg_replace('~^-+|-+$~', '', $name ); // кил - на концах

	return $name;
}

/**
 * Хлебные крошки для WordPress (breadcrumbs)
 *
 * @param string $sep  Разделитель. По умолчанию ' » '.
 * @param array  $l10n Для локализации. См. переменную `$default_l10n`.
 * @param array  $args Опции. Смотрите переменную `$def_args`.
 *
 * @return void Выводит на экран HTML код
 *
 * version 3.3.3
 */
function kama_breadcrumbs( $sep = ' » ', $l10n = array(), $args = array() ){
	$kb = new Kama_Breadcrumbs;
	echo $kb->get_crumbs( $sep, $l10n, $args );
}

class Kama_Breadcrumbs {

	public $arg;

	// Локализация
	static $l10n = [
		'home'       => 'Главная',
		'paged'      => 'Страница %d',
		'_404'       => 'Ошибка 404',
		'search'     => 'Результаты поиска по запросу - <b>%s</b>',
		'author'     => 'Архив автора: <b>%s</b>',
		'year'       => 'Архив за <b>%d</b> год',
		'month'      => 'Архив за: <b>%s</b>',
		'day'        => '',
		'attachment' => 'Медиа: %s',
		'tag'        => 'Записи по метке: <b>%s</b>',
		'tax_tag'    => '%1$s из "%2$s" по тегу: <b>%3$s</b>',
		// tax_tag выведет: 'тип_записи из "название_таксы" по тегу: имя_термина'.
		// Если нужны отдельные холдеры, например только имя термина, пишем так: 'записи по тегу: %3$s'
	];

	// Параметры по умолчанию
	static $args = [
		// выводить крошки на главной странице
		'on_front_page'   => false,
		// показывать ли название записи в конце (последний элемент). Для записей, страниц, вложений
		'show_post_title' => true,
		// показывать ли название элемента таксономии в конце (последний элемент). Для меток, рубрик и других такс
		'show_term_title' => true,
		// шаблон для последнего заголовка. Если включено: show_post_title или show_term_title
		'title_patt'      => '<span class="kb_title">%s</span>',
		// показывать последний разделитель, когда заголовок в конце не отображается
		'last_sep'        => true,
		// 'markup' - микроразметка. Может быть: 'rdf.data-vocabulary.org', 'schema.org', '' - без микроразметки
		// или можно указать свой массив разметки:
		// array( 'wrappatt'=>'<div class="kama_breadcrumbs">%s</div>', 'linkpatt'=>'<a href="%s">%s</a>', 'sep_after'=>'', )
		'markup'          => 'schema.org',
		// приоритетные таксономии, нужно когда запись в нескольких таксах
		'priority_tax'    => [ 'cours' ],
		// 'priority_terms' - приоритетные элементы таксономий, когда запись находится в нескольких элементах одной таксы одновременно.
		// Например: array( 'category'=>array(45,'term_name'), 'tax_name'=>array(1,2,'name') )
		// 'category' - такса для которой указываются приор. элементы: 45 - ID термина и 'term_name' - ярлык.
		// порядок 45 и 'term_name' имеет значение: чем раньше тем важнее. Все указанные термины важнее неуказанных...
		'priority_terms'  => [],
		// добавлять rel=nofollow к ссылкам?
		'nofollow'        => false,

		// служебные
		'sep'             => '',
		'linkpatt'        => '',
		'pg_end'          => '',
	];

	function get_crumbs( $sep, $l10n, $args ){
		global $post, $wp_post_types;

		self::$args['sep'] = $sep;

		// Фильтрует дефолты и сливает
		$loc = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_loc', self::$l10n ), $l10n );
		$arg = (object) array_merge( apply_filters( 'kama_breadcrumbs_default_args', self::$args ), $args );

		$arg->sep = '<span class="kb_sep slash">' . $arg->sep . '</span>'; // дополним

		// упростим
		$sep = & $arg->sep;
		$this->arg = & $arg;

		// микроразметка ---
		if(1){
			$mark = & $arg->markup;

			// Разметка по умолчанию
			if( ! $mark ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs">%s</div>',
					'linkpatt'  => '<a href="%s">%s</a>',
					'sep_after' => '',
				];
			}
			// rdf
			elseif( $mark === 'rdf.data-vocabulary.org' ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs" prefix="v: http://rdf.data-vocabulary.org/#">%s</div>',
					'linkpatt'  => '<span typeof="v:Breadcrumb"><a href="%s" rel="v:url" property="v:title">%s</a>',
					'sep_after' => '</span>', // закрываем span после разделителя!
				];
			}
			// schema.org
			elseif( $mark === 'schema.org' ){
				$mark = [
					'wrappatt'  => '<div class="kama_breadcrumbs bread-cumbs" itemscope itemtype="http://schema.org/BreadcrumbList">%s</div>',
					'linkpatt'  => '<span class="bread-cumbs__main" itemprop="itemListElement" itemscope itemtype="http://schema.org/ListItem"><a href="%s" itemprop="item"><span itemprop="name" class="bread-cumbs__main">%s</span></a></span>',
					'sep_after' => '',
				];
			}

			elseif( ! is_array( $mark ) ){
				die( __CLASS__ . ': "markup" parameter must be array...' );
			}

			$wrappatt = $mark['wrappatt'];
			$arg->linkpatt = $arg->nofollow ? str_replace( '<a ', '<a rel="nofollow"', $mark['linkpatt'] ) : $mark['linkpatt'];
			$arg->sep .= $mark['sep_after'] . "\n";
		}

		$linkpatt = $arg->linkpatt; // упростим

		$q_obj = get_queried_object();

		// может это архив пустой таксы
		$ptype = null;
		if( ! $post ){
			if( isset( $q_obj->taxonomy ) ){
				$ptype = $wp_post_types[ get_taxonomy( $q_obj->taxonomy )->object_type[0] ];
			}
		}
		else{
			$ptype = $wp_post_types[ $post->post_type ];
		}

		// paged
		$arg->pg_end = '';
		$paged_num = get_query_var( 'paged' ) ?: get_query_var( 'page' );
		if( $paged_num ){
			$arg->pg_end = $sep . sprintf( $loc->paged, (int) $paged_num );
		}

		$pg_end = $arg->pg_end; // упростим

		$out = '';

		if( is_front_page() ){
			return $arg->on_front_page ? sprintf( $wrappatt, ( $paged_num ? sprintf( $linkpatt, get_home_url(), $loc->home ) . $pg_end : $loc->home ) ) : '';
		}
		// страница записей, когда для главной установлена отдельная страница.
		elseif( is_home() ){
			$out = $paged_num ? ( sprintf( $linkpatt, get_permalink( $q_obj ), esc_html( $q_obj->post_title ) ) . $pg_end ) : esc_html( $q_obj->post_title );
		}
		elseif( is_404() ){
			$out = $loc->_404;
		}
		elseif( is_search() ){
			$out = sprintf( $loc->search, esc_html( $GLOBALS['s'] ) );
		}
		elseif( is_author() ){
			$tit = sprintf( $loc->author, esc_html( $q_obj->display_name ) );
			$out = ( $paged_num ? sprintf( $linkpatt, get_author_posts_url( $q_obj->ID, $q_obj->user_nicename ) . $pg_end, $tit ) : $tit );
		}
		elseif( is_year() || is_month() || is_day() ){
			$y_url = get_year_link( $year = get_the_time( 'Y' ) );

			if( is_year() ){
				$tit = sprintf( $loc->year, $year );
				$out = ( $paged_num ? sprintf( $linkpatt, $y_url, $tit ) . $pg_end : $tit );
			}
			// month day
			else{
				$y_link = sprintf( $linkpatt, $y_url, $year );
				$m_url = get_month_link( $year, get_the_time( 'm' ) );

				if( is_month() ){
					$tit = sprintf( $loc->month, get_the_time( 'F' ) );
					$out = $y_link . $sep . ( $paged_num ? sprintf( $linkpatt, $m_url, $tit ) . $pg_end : $tit );
				}
				elseif( is_day() ){
					$m_link = sprintf( $linkpatt, $m_url, get_the_time( 'F' ) );
					$out = $y_link . $sep . $m_link . $sep . get_the_time( 'l' );
				}
			}
		}
		// Древовидные записи
		elseif( is_singular() && $ptype->hierarchical ){
			$out = $this->_add_title( $this->_page_crumbs( $post ), $post );
		}
		// Таксы, плоские записи и вложения
		else {
			$term = $q_obj; // таксономии

			// определяем термин для записей (включая вложения attachments)
			if( is_singular() ){
				// изменим $post, чтобы определить термин родителя вложения
				if( is_attachment() && $post->post_parent ){
					$save_post = $post; // сохраним
					$post = get_post( $post->post_parent );
				}

				// учитывает если вложения прикрепляются к таксам древовидным - все бывает :)
				$taxonomies = get_object_taxonomies( $post->post_type );
				// оставим только древовидные и публичные, мало ли...
				$taxonomies = array_intersect( $taxonomies, get_taxonomies( [
					'hierarchical' => true,
					'public'       => true,
				] ) );

				if( $taxonomies ){
					// сортируем по приоритету
					if( ! empty( $arg->priority_tax ) ){

						usort( $taxonomies, static function( $a, $b ) use ( $arg ) {
							$a_index = array_search( $a, $arg->priority_tax );
							if( $a_index === false ){
								$a_index = 9999999;
							}

							$b_index = array_search( $b, $arg->priority_tax );
							if( $b_index === false ){
								$b_index = 9999999;
							}

							return ( $b_index === $a_index ) ? 0 : ( $b_index < $a_index ? 1 : -1 ); // меньше индекс - выше
						} );
					}

					// пробуем получить термины, в порядке приоритета такс
					foreach( $taxonomies as $taxname ){

						if( $terms = get_the_terms( $post->ID, $taxname ) ){
							// проверим приоритетные термины для таксы
							$prior_terms = &$arg->priority_terms[ $taxname ];

							if( $prior_terms && count( $terms ) > 2 ){

								foreach( (array) $prior_terms as $term_id ){
									$filter_field = is_numeric( $term_id ) ? 'term_id' : 'slug';
									$_terms = wp_list_filter( $terms, [ $filter_field => $term_id ] );

									if( $_terms ){
										$term = array_shift( $_terms );
										break;
									}
								}
							}
							else{
								$term = array_shift( $terms );
							}

							break;
						}
					}
				}

				// вернем обратно (для вложений)
				if( isset( $save_post ) ){
					$post = $save_post;
				}
			}

			// вывод

			// все виды записей с терминами или термины
			if( $term && isset( $term->term_id ) ){
				$term = apply_filters( 'kama_breadcrumbs_term', $term );

				// attachment
				if( is_attachment() ){
					if( ! $post->post_parent ){
						$out = sprintf( $loc->attachment, esc_html( $post->post_title ) );
					}
					else{
						if( ! $out = apply_filters( 'attachment_tax_crumbs', '', $term, $this ) ){
							$_crumbs = $this->_tax_crumbs( $term, 'self' );
							$parent_tit = sprintf( $linkpatt, get_permalink( $post->post_parent ), get_the_title( $post->post_parent ) );
							$_out = implode( $sep, [ $_crumbs, $parent_tit ] );
							$out = $this->_add_title( $_out, $post );
						}
					}
				}
				// single
				elseif( is_single() ){
					if( ! $out = apply_filters( 'post_tax_crumbs', '', $term, $this ) ){
						$_crumbs = $this->_tax_crumbs( $term, 'self' );
						$out = $this->_add_title( $_crumbs, $post );
					}
				}
				// не древовидная такса (метки)
				elseif( ! is_taxonomy_hierarchical( $term->taxonomy ) ){
					// метка
					if( is_tag() ){
						$out = $this->_add_title( '', $term, sprintf( $loc->tag, esc_html( $term->name ) ) );
					}
					// такса
					elseif( is_tax() ){
						$post_label = $ptype->labels->name;
						$tax_label = $GLOBALS['wp_taxonomies'][ $term->taxonomy ]->labels->name;
						$out = $this->_add_title( '', $term, sprintf( $loc->tax_tag, $post_label, $tax_label, esc_html( $term->name ) ) );
					}
				}
				// древовидная такса (рибрики)
				elseif( ! $out = apply_filters( 'term_tax_crumbs', '', $term, $this ) ){
					$_crumbs = $this->_tax_crumbs( $term, 'parent' );
					$out = $this->_add_title( $_crumbs, $term, esc_html( $term->name ) );
				}
			}
			// влоежния от записи без терминов
			elseif( is_attachment() ){
				$parent = get_post( $post->post_parent );
				$parent_link = sprintf( $linkpatt, get_permalink( $parent ), esc_html( $parent->post_title ) );
				$_out = $parent_link;

				// вложение от записи древовидного типа записи
				if( is_post_type_hierarchical( $parent->post_type ) ){
					$parent_crumbs = $this->_page_crumbs( $parent );
					$_out = implode( $sep, [ $parent_crumbs, $parent_link ] );
				}

				$out = $this->_add_title( $_out, $post );
			}
			// записи без терминов
			elseif( is_singular() ){
				$out = $this->_add_title( '', $post );
			}
		}

		// замена ссылки на архивную страницу для типа записи
		// $home_after = apply_filters( 'kama_breadcrumbs_home_after', '', $linkpatt, $sep, $ptype );
		$home_after = null;

		if( '' === $home_after ){
			// Ссылка на архивную страницу типа записи для: отдельных страниц этого типа; архивов этого типа; таксономий связанных с этим типом.
			if( $ptype && $ptype->has_archive && ! in_array( $ptype->name, [ 'post', 'page', 'attachment' ] )
				&& ( is_post_type_archive() || is_singular() || ( is_tax() && in_array( $term->taxonomy, $ptype->taxonomies ) ) )
			){
				$pt_title = $ptype->labels->name;

				// первая страница архива типа записи
				if( is_post_type_archive() && ! $paged_num ){
					$home_after = sprintf( $this->arg->title_patt, $pt_title );
				}
				// singular, paged post_type_archive, tax
				else{
					$home_after = sprintf( $linkpatt, get_post_type_archive_link( $ptype->name ), $pt_title );

					$home_after .= ( ( $paged_num && ! is_tax() ) ? $pg_end : $sep ); // пагинация
				}
			}
		}

		$before_out = sprintf( $linkpatt, home_url(), $loc->home ) . ( $home_after ? $sep . $home_after : ( $out ? $sep : '' ) );

		$out = apply_filters( 'kama_breadcrumbs_pre_out', $out, $sep, $loc, $arg );

		$out = sprintf( $wrappatt, $before_out . $out );

		return apply_filters( 'kama_breadcrumbs', $out, $sep, $loc, $arg );
	}

	function _page_crumbs( $post ) {
		$parent = $post->post_parent;

		$crumbs = [];
		while( $parent ){
			$page = get_post( $parent );
			$crumbs[] = sprintf( $this->arg->linkpatt, get_permalink( $page ), esc_html( $page->post_title ) );
			$parent = $page->post_parent;
		}

		return implode( $this->arg->sep, array_reverse( $crumbs ) );
	}

	function _tax_crumbs( $term, $start_from = 'self' ) {
		$termlinks = [];
		$term_id = ( $start_from === 'parent' ) ? $term->parent : $term->term_id;
		while( $term_id ){
			$term = get_term( $term_id, $term->taxonomy );
			$termlinks[] = sprintf( $this->arg->linkpatt, get_term_link( $term ), esc_html( $term->name ) );
			$term_id = $term->parent;
		}

		if( $termlinks ){
			return implode( $this->arg->sep, array_reverse( $termlinks ) );
		}

		return '';
	}

	// добалвяет заголовок к переданному тексту, с учетом всех опций. Добавляет разделитель в начало, если надо.
	function _add_title( $add_to, $obj, $term_title = '' ) {

		// упростим...
		$arg = &$this->arg;
		// $term_title чиститься отдельно, теги моугт быть...
		$title = $term_title ?: esc_html( $obj->post_title );
		$show_title = $term_title ? $arg->show_term_title : $arg->show_post_title;

		// пагинация
		if( $arg->pg_end ){
			$link = $term_title ? get_term_link( $obj ) : get_permalink( $obj );
			$add_to .= ( $add_to ? $arg->sep : '' ) . sprintf( $arg->linkpatt, $link, $title ) . $arg->pg_end;
		}
		// дополняем - ставим sep
		elseif( $add_to ){
			if( $show_title ){
				$add_to .= $arg->sep . sprintf( $arg->title_patt, $title );
			}
			elseif( $arg->last_sep ){
				$add_to .= $arg->sep;
			}
		}
		// sep будет потом...
		elseif( $show_title ){
			$add_to = sprintf( $arg->title_patt, $title );
		}

		return $add_to;
	}

}

add_action( 'init', 'add_courses_tax' );

add_filter( 'the_content', 'filter_ptags_on_images' );
function filter_ptags_on_images( $content ){

	$string = preg_replace("/<h2\s(.+?)>(.+?)<\/h2>/", "$2", $content);
	return ($string); 
}

function add_courses_tax (){
	register_taxonomy('cours', array('lessons'), array(
		'labels'                => [
			'name'              => 'Курсы',
			'singular_name'     => 'Курс',
			'search_items'      => 'Найти курс',
			'all_items'         => 'Все курсы',
			'view_item '        => 'Просмотреть',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить курс',
			'new_item_name'     => 'Имя курса',
			'menu_name'         => 'Курсы',
			'back_to_items'     => '← назад к курсам',
		],
		'description'           => '', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => null, // равен аргументу public
		'hierarchical'          => true,
		'has_archive'           => true,
		'query_var'             => true, // название параметра запроса
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt' ),
		'show_in_rest'          => true, // добавить в REST API
		'rewrite'               => array(
			'slug' => 'courses',
			'with_front' => true,
			'hierarchical' => false,
		),
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	));

	register_post_type( 'lessons', array(
		'labels'                => [
			'name'              => 'Занятия',
			'singular_name'     => 'Занятие',
			'search_items'      => 'Найти занятие',
			'all_items'         => 'Все занятия',
			'view_item '        => 'Просмотреть',
			'edit_item'         => 'Редактировать',
			'update_item'       => 'Обновить',
			'add_new_item'      => 'Добавить занятие',
			'new_item_name'     => 'Новое занятие',
			'menu_name'         => 'Занятия',
			'back_to_items'     => '← назад к занятиям',
		],
		'description'           => 'Страница уроков', // описание таксономии
		'public'                => true,
		'publicly_queryable'    => true, // равен аргументу public
		'hierarchical'          => true,
		'has_archive'           => true,
		'query_var'             => true, // название параметра запроса
		'supports'              => array( 'title', 'editor', 'author', 'thumbnail', 'excerpt', 'page-attributes' ),
		'show_in_rest'          => true, // добавить в REST API
		'menu_position'         => 8,
		'taxonomy'              => ['cours'],
		'menu_icon'             => 'dashicons-clipboard',
		'rewrite'               => array(
			'slug' => 'lessons',
			'with_front' => false,
			'hierarchical' => false,
		),
		// '_builtin'              => false,
		//'update_count_callback' => '_update_post_term_count',
	));
}

add_action( 'cours_add_form_fields', 'true_add_cat_fields' );
 
function true_add_cat_fields( $tag ) {
	echo $tag;
	$courses = get_term_children(23, 'category');
	foreach($courses as $cours) {
		// $cat = get_category($cours);
		// $parentcats = get_the_terms( $cours, 'category' );
		// print_r($cat);
	}
	echo '<div class="form-field">
	<label for="price_title_full">Цена курса</label>
	<input type="text" name="price_title_full" id="price_title_full" />

	<label for="val_n_descr">Валюта и описание</label>
	<input type="text" name="val_n_descr" id="val_n_descr" />

	<label for="under_descr">Описание в блоке под ценой</label>
	<input type="text" name="under_descr" id="under_descr" />

	<label for="cours_under_header_txt">Текст в загловке</label>
	<textarea type="text" name="cours_under_header_txt" id="cours_under_header_txt"></textarea>

	<label for="cours_notice_txt">Текст под загловом</label>
	<textarea type="text" name="cours_notice_txt" id="cours_notice_txt"></textarea>

	<label for="cours_lessons_header">Заголовок для блока уроков</label>
	<input type="text" name="cours_lessons_header" id="cours_lessons_header" />

	<label for="cours_lessons_descr">Описание блока уроков</label>
	<input type="text" name="cours_lessons_descr" id="cours_lessons_descr" />

	<label for="cours_lessons_split">Может продаваться отдельными уроками</label>
	<input name="cours_lessons_split" id="cours_lessons_split" type="checkbox" value="yes"/>
	</div>';
}

add_action( 'cours_edit_form_fields', 'true_edit_term_fields', 10, 2 );
 
function true_edit_term_fields( $term, $taxonomy ) {
 
	// сначала получаем значения этих полей
	// заголовок
	$price_title_f = get_term_meta( $term->term_id, 'price_title_full', true );
	$val_n_descr = get_term_meta( $term->term_id, 'val_n_descr', true );
	$under_descr = get_term_meta( $term->term_id, 'under_descr', true );
	$cours_under_header_txt = get_term_meta( $term->term_id, 'cours_under_header_txt', true );
	$cours_notice_txt = get_term_meta( $term->term_id, 'cours_notice_txt', true );
	$cours_lessons_header = get_term_meta( $term->term_id, 'cours_lessons_header', true );
	$cours_lessons_descr = get_term_meta( $term->term_id, 'cours_lessons_descr', true );
	$cours_lessons_split = get_term_meta( $term->term_id, 'cours_lessons_split', true );
	$cours_lessons_split_checked = $cours_lessons_split === 'yes' ? 'checked' : '';
	
	echo '<tr class="form-field">
	<th>
		<label for="price_title_full">Цена курса</label>
	</th>
	<td>
		<input name="price_title_full" id="price_title_full" type="text" value="' . esc_attr( $price_title_f ) .'" />
	</td>
	</tr>

	<tr class="form-field">
	<th>
		<label for="val_n_descr">Валюта и описание</label>
	</th>
	<td>
		<input name="val_n_descr" id="val_n_descr" type="text" value="' . esc_attr( $val_n_descr ) .'" />
	</td>
	</tr>

	<tr class="form-field">
	<th>
		<label for="under_descr">Описание в блоке под ценой</label>
	</th>
	<td>
		<input name="under_descr" id="under_descr" type="text" value="' . esc_attr( $under_descr ) .'" />
	</td>
	</tr>

	<tr class="form-field">
	<th>
		<label for="cours_under_header_txt">Текст в загловкe</label>
	</th>
	<td>
		<textarea name="cours_under_header_txt" id="cours_under_header_txt" type="text">' . esc_attr( $cours_under_header_txt ) .'</textarea>
	</td>
	</tr>
	<tr class="form-field">
	<th>
		<label for="cours_notice_txt">Текст под загловком</label>
	</th>
	<td>
		<textarea name="cours_notice_txt" id="cours_notice_txt" type="text">' . esc_attr( $cours_notice_txt ) .'</textarea>
	</td>
	</tr>
	</tr>
	<tr class="form-field">
	<th>
		<label for="cours_lessons_header">Заголовок для блока уроков</label>
	</th>
	<td>
		<input name="cours_lessons_header" id="cours_lessons_header" type="text" value="' . esc_attr( $cours_lessons_header ) .'" />
	</td>
	</tr>
	</tr>
	<tr class="form-field">
	<th>
		<label for="cours_lessons_descr">Описание блока уроков</label>
	</th>
	<td>
		<input name="cours_lessons_descr" id="cours_lessons_descr" type="text" value="' . esc_attr( $cours_lessons_descr ) .'" />
	</td>
	</tr>
	<tr class="form-field">
	<th>
		<label for="cours_lessons_split">Может продаваться отдельными уроками</label>
	</th>
	<td>
		<input name="cours_lessons_split" id="cours_lessons_split" type="checkbox" value="yes" '.$cours_lessons_split_checked.'/>
	</td>
	</tr>
	</tr>'; 
}

add_action( 'created_cours', 'true_save_term_fields' );
add_action( 'edited_cours', 'true_save_term_fields' );
 
function true_save_term_fields( $term_id ) {
 
	if( isset( $_POST[ 'price_title_full' ] ) ) {
		update_term_meta( $term_id, 'price_title_full', sanitize_text_field( $_POST[ 'price_title_full' ] ) );
	} else {
		delete_term_meta( $term_id, 'price_title_full' );
	}
	if( isset( $_POST[ 'val_n_descr' ] ) ) {
		update_term_meta( $term_id, 'val_n_descr', sanitize_text_field( $_POST[ 'val_n_descr' ] ) );
	} else {
		delete_term_meta( $term_id, 'val_n_descr' );
	}
	if( isset( $_POST[ 'under_descr' ] ) ) {
		update_term_meta( $term_id, 'under_descr', sanitize_text_field( $_POST[ 'under_descr' ] ) );
	} else {
		delete_term_meta( $term_id, 'under_descr' );
	}
	if( isset( $_POST[ 'cours_under_header_txt' ] ) ) {
		update_term_meta( $term_id, 'cours_under_header_txt', sanitize_text_field( $_POST[ 'cours_under_header_txt' ] ) );
	} else {
		delete_term_meta( $term_id, 'cours_under_header_txt' );
	}
	if( isset( $_POST[ 'cours_notice_txt' ] ) ) {
		update_term_meta( $term_id, 'cours_notice_txt', sanitize_text_field( $_POST[ 'cours_notice_txt' ] ) );
	} else {
		delete_term_meta( $term_id, 'cours_notice_txt' );
	}
	if( isset( $_POST[ 'cours_lessons_header' ] ) ) {
		update_term_meta( $term_id, 'cours_lessons_header', sanitize_text_field( $_POST[ 'cours_lessons_header' ] ) );
	} else {
		delete_term_meta( $term_id, 'cours_lessons_header' );
	}
	if( isset( $_POST[ 'cours_lessons_descr' ] ) ) {
		update_term_meta( $term_id, 'cours_lessons_descr', sanitize_text_field( $_POST[ 'cours_lessons_descr' ] ) );
	} else {
		delete_term_meta( $term_id, 'cours_lessons_descr' );
	}
	if(isset($_POST['cours_lessons_split']) && $_POST['cours_lessons_split']='yes'){
		update_term_meta( $term_id, 'cours_lessons_split', sanitize_text_field( $_POST[ 'cours_lessons_split' ] ) );
	} else {
		delete_term_meta( $term_id, 'cours_lessons_split' );
	}
}

function myNotation () {
	$supp_mail = CFS()->get('support_email', 12);
	$supp_mail_2 = CFS()->get('support_email2', 12);
	$message_sign = $_POST['n'].' хочет записаться на курс.';
	$_POST['m']? $message_sign .= ' Почта '.$_POST['m'] . '.': '';
	$_POST['p']? $message_sign .= ' Телефон '.$_POST['p'] .'.': '';
	wp_mail( $supp_mail, "Заявка на запись на курс", $message_sign);
	if(!empty($supp_mail_2)){
		wp_mail( $supp_mail_2, "Заявка на запись на курс", $message_sign);
	}
	$data = [
		'ok' => 'ok'
	];
	echo (json_encode($data));
	wp_die();
}

function signForIndiividuals () {
	$nonce = $_POST['nonce'];
	$ctrl = wp_create_nonce();
    if ($ctrl != $nonce){wp_die();}
	$name = sanitize_text_field( $_POST['name'] );
	$phone = sanitize_text_field( $_POST['phone'] );
	$email = sanitize_text_field( $_POST['email'] );
	$message = $name.' хочет записаться на идивидуальные курсы.<br>Телефон: '.$phone.'<br>E-mail: '.$email;
	if(wp_mail( $supp_mail, "Заявка на запись на индивидуальные курсы", $message)){
		$data = [
			'ok' => 1
		];
		echo (json_encode($data));
	}

	wp_die();
}
?>