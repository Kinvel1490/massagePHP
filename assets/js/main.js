var auth, pass, authContent, mail, sign_phone;
var err = 0;

document.addEventListener('DOMContentLoaded', ()=>{
    var plays = Array.from(document.querySelectorAll('.play'));
    var videos = Array.from(document.querySelectorAll('video'));
    if (plays.length > 0){
        plays.forEach(play => {
            play.addEventListener('click', startPlay);
        });
    }
    if(videos.length > 0){
        videos.forEach(video => {
            video.addEventListener('pause', pause);
            video.addEventListener('fullscreenchange', (e)=>{
                e.target.classList.toggle('contained-video');
            })
        });
    }
    var mobMenu = document.querySelector('.header__mobile-menu');
    document.querySelector('.header__burger').addEventListener('click', ()=>{showHideMMenu(mobMenu)});
    document.querySelector('.header__mobile-menu-cross').addEventListener('click', ()=>{closeMobMenu(mobMenu)});

    if(document.querySelector('.hidden_auth')){
        auth = document.querySelector('.hidden_auth');
        authContent = document.querySelector('.auth__content-wr');
        $('.header__lk').on('click', openAuth);
        $('.btn_menu_login').on('click', openAuth);
        Array.from(document.querySelectorAll('.header__auth-menu-cross')).forEach(el => el.addEventListener('click', closeAuth));
        Array.from(document.querySelectorAll('.header__auth-menu-cross')).forEach(el => el.addEventListener('click', closeSignForCours));
        addLogin();
    }

    if(document.querySelector('.price__loggedIn')){
        document.querySelectorAll('.price__loggedIn').forEach(el => el.addEventListener('click', orderHandler));
    }

    if(document.querySelector('.price__notLoggedIn')){
        document.querySelectorAll('.price__notLoggedIn').forEach(el => el.addEventListener('click', notLoggedAlert));
    }

    if(document.querySelector('.hero__btn')){
        document.querySelector('.hero__btn').addEventListener('click', singUpForCours);
    }

    if(document.querySelector('.header__auth-menu-cross_sign')){
        document.querySelector('.header__auth-menu-cross_sign').addEventListener('click', closeSignForCours);
    }

    if(document.querySelector('.sign_sub')){
        document.querySelector('.sign_sub').addEventListener('click', sendNotation);
        sign_phone = document.querySelector('#sign_phone');
        sign_phone.addEventListener('keypress', checkNumbInput);
    }

    if(document.querySelector('.price__order_from_shower')){
        document.querySelector('.price__order_from_shower').addEventListener('click', showSignForm);
    }

    // $('.header__exit-dt, .header__exit-txt-dt, .header__menu-exit').on('click', userLogout);
    /*Swiper*/
    if(document.querySelector('.actions__content')){
        new Swiper('.actions__content', {
            loop: true,
            navigation: {
                nextEl: '.actions-next',
                prevEl: '.actions-prev',
            },
            pagination: {
                el: '.actions-pagination',
                type: 'bullets',
            }
        });
    }
    /*Swiper*/

    /*Swiper*/
    if(document.querySelector('.otz__content')){
        new Swiper('.otz__content', {
            loop: true,
            slideToClickedSlide: true,
            navigation: {
                nextEl: 'otz__super-wr .next_outer',
                prevEl: 'otz__super-wr .prev_outer',
            },
            pagination: {
                el: '.otz-pagination',
                type: 'bullets',
            },
            slidesPerGroup: 1,
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                320: {
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    spaceBetween: 30
                },

                768: {
                    slidesPerGroup: 1,
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            },
            on: {
                init: function(){
                    this.el.addEventListener('click', ()=>showGalery(this))
                },
                slideChange: function () {
                    if(document.querySelector('.galery__img')){
                        $('.galery__img').css('opacity', '0');
                        setTimeout(() => {
                            document.querySelector('.galery__img').setAttribute('src', this.slides[this.activeIndex].querySelector('img').getAttribute('src'));
                            $('.galery__img').css('opacity', '1');
                        }, 300);
                    }
                }
            }
        });
    }
    /*Swiper*/

        /*Swiper*/
        if(document.querySelector('.examples__content')){
            new Swiper('.examples__content', {
                loop: false,
                navigation: {
                    nextEl: '.examples_next_outer',
                    prevEl: '.examples_prev_outer',
                },
                pagination: {
                    el: '.examples-pagination',
                    type: 'bullets',
                },
                slidesPerGroup: 1,
                slidesPerView: 1,
                spaceBetween: 30,
                breakpoints: {
                    320: {
                        slidesPerGroup: 1,
                        slidesPerView: 1,
                        spaceBetween: 30
                    },
    
                    768: {
                        slidesPerGroup: 1,
                        slidesPerView: 3,
                        spaceBetween: 30
                    }
                }
            });
        }
        /*Swiper*/

    /*Swiper*/
    if(document.querySelector('.video__content-wr')){
        new Swiper('.video__content-wr', {
            loop: true,
            navigation: {
                nextEl: '.video-next-outer',
                prevEl: '.video-prev-outer',
            },
            pagination: {
                el: '.video-pagination',
                type: 'bullets',
            },
            slidesPerGroup: 1,
            slidesPerView: 1,
            breakpoints: {
                320: {
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    spaceBetween: 0
                },

                1280: {
                    slidesPerGroup: 1,
                    slidesPerView: 3,
                    spaceBetween: 30
                }
            }
        });
    }
    /*Swiper*/

            /*Swiper*/
            if(document.querySelector('.diplomas__content')){
                new Swiper('.diplomas__content', {
                    loop: true,
                    navigation: {
                        nextEl: '.diplomas_next_outer',
                        prevEl: '.diplomas_prev_outer',
                    },
                    pagination: {
                        el: '.diplomas-pagination',
                        type: 'bullets',
                    },
                    slidesPerGroup: 1,
                    slidesPerView: 1,
                    spaceBetween: 30,
                    breakpoints: {
                        320: {
                            slidesPerGroup: 1,
                            slidesPerView: 1,
                            spaceBetween: 30
                        },
        
                        768: {
                            slidesPerGroup: 1,
                            slidesPerView: 3,
                            spaceBetween: 30
                        }
                    }
                });
            }
            /*Swiper*/

    /*квадратные изображения */
    if (document.querySelector('.square')){
        window.addEventListener('load', ()=>{
            square();        
        });
        window.addEventListener('resize', square);
        window.addEventListener("orientationchange", square);
    }
});

function startPlay (e) {
    e = e || window.event || UIEvent;
    vid = e.target.closest('div').querySelector('video');
    if (vid.getAttribute('controls') === null) {
        vid.setAttribute('controls', '');
        vid.play();
        e.target.setAttribute('style', 'display:none');
    }
}

function pause (e) {
    e.target.removeAttribute('controls');
    e.target.closest('div').querySelector('.play').setAttribute('style', 'display:block');
}

function showHideMMenu (mobMenu) {
    mobMenu.classList.add('shown');
    document.querySelector('body').classList.add('overflow');
}

function closeMobMenu (mobMenu) {
    mobMenu.classList.remove('shown');
    document.querySelector('body').classList.remove('overflow');
}

function openAuth () {
    auth.classList.add('auth');
    auth.classList.remove('auth-hide');
    document.querySelector('body').classList.add('overflow');
}

function closeAuth () {
    auth.classList.remove('auth');
    auth.classList.add('auth-hide');
    document.querySelector('body').classList.remove('overflow');
    setTimeout(addLogin, 500);
}

function showHidePass (e) {
    e = e || window.event || UIEvent;
    el = e.target.closest('.auth__label').nextElementSibling;
    let eye;
    if(e.target.classList.contains('auth__pass-hide')){
        eye = e.target;            
    } else {eye = e.target.closest('.auth__label').childNodes[0];}
    if (el.getAttribute('type') === 'password') {
        el.setAttribute('type', 'text');
        eye.setAttribute('src', myajax_data.showpass);
    } else {
        el.setAttribute('type', 'password');
        eye.setAttribute('src', myajax_data.hidepass);
    }
}

function validationPass(e) {
    e = e || window.event || UIEvent;
    if (pass[1]) {
        if(pass[0].value !== pass[1].value){
            e.preventDefault();
            if (document.querySelector('#auth__error1') == null){
                let spanerr = document.createElement('span');
                spanerr.setAttribute('class', 'auth__error');
                spanerr.setAttribute('id', 'auth__error1');
                spanerr.innerText ='Пароли не совпадают';
                pass[0].classList.add('auth__pass_err');
                pass[1].classList.add('auth__pass_err');
                pass[0].closest('.auth__input-wr').appendChild(spanerr);
                err = 1;
            }
        }        
    }
    if (pass[0] && pass[0].value == ""){
        e.preventDefault();
        if (document.querySelector('#auth__error1') == null){
            let spanerr = document.createElement('span');
            spanerr.setAttribute('class', 'auth__error');
            spanerr.setAttribute('id', 'auth__error1');
            spanerr.innerText ='Поле не может быть пустым';
            pass[0].classList.add('auth__pass_err');
            pass[0].closest('.auth__input-wr').appendChild(spanerr);
            err = 1;
        }
    }
    if (pass[1] && pass[1].value == ""){
        e.preventDefault();
        if (document.querySelector('#auth__error2') == null){
            let spanerr = document.createElement('span');
            spanerr.setAttribute('class', 'auth__error');
            spanerr.setAttribute('id', 'auth__error2');
            spanerr.innerText ='Поле не может быть пустым';
            pass[1].classList.add('auth__pass_err');
            pass[1].closest('.auth__input-wr').appendChild(spanerr);
            err = 1;
        }
    }
    if(document.querySelector('.auth__mail')){
        mail = document.querySelector('.auth__mail');
        let exp = /([A-Za-z0-9]+\.*)+@[A-Za-z0-9]+\.[a-z]{2,3}/;
        if (mail.value == ""){
            e.preventDefault();
            if (document.querySelector('#auth__error-mail') == null){
                let spanerr = document.createElement('span');
                spanerr.setAttribute('class', 'auth__error');
                spanerr.setAttribute('id', 'auth__error-mail');
                spanerr.innerText ='Поле не может быть пустым';
                mail.classList.add('auth__pass_err');
                mail.after(spanerr);
                err = 1;
            }
        } else {
            let p = new RegExp(exp);
            if(!p.test(mail.value)){
                e.preventDefault();
                if (document.querySelector('#auth__error-mail') == null){
                    let spanerr = document.createElement('span');
                    spanerr.setAttribute('class', 'auth__error');
                    spanerr.setAttribute('id', 'auth__error-mail');
                    spanerr.innerText ='Неправильный формат почты';
                    mail.classList.add('auth__pass_err');
                    mail.after(spanerr);
                    err = 1;
                }
            } else {
                e.preventDefault();
                if (document.querySelector('.auth__subm-mail') && document.querySelector('.auth__subm-mail').getAttribute('name') == 'forget') {
                    e.preventDefault();
                    forgetUser();
                } else {
                    if(err == 0){
                        switch(document.querySelector('.auth__subm').getAttribute('name')){
                            case 'logon': loginUser(); break;
                            case 'reg': registerUser(); break;
                        }
                    }
                }
            }
        }
    }
}

function changedPass () {
    if (document.querySelector('.auth__error')){
        Array.from(document.querySelectorAll('.auth__error')).forEach(el => {
            if (el.getAttribute('id') == 'auth__error1' || el.getAttribute('id') == 'auth__error2') el.remove();
        })
        pass[0].classList.remove('auth__pass_err');
        if(pass[1]){
            pass[1].classList.remove('auth__pass_err');
        }
    err = 0;
    }
}

function mailChange () {
    if (document.querySelector('#auth__error-mail')){
        document.querySelector('#auth__error-mail').remove();
        document.querySelector('.auth__mail').classList.remove('auth__pass_err');
        if(err){
            err = 0;
        }
    }
}

function mailNPassChange () {
    if (document.querySelector('#auth__error-mail')){
        document.querySelector('#auth__error-mail').remove();
        document.querySelector('.auth__mail').classList.remove('auth__pass_err');
        if(err){
            err = 0;
        }
    }
    if (document.querySelector('.auth__error')){
        Array.from(document.querySelectorAll('.auth__error')).forEach(el => {
            if (el.getAttribute('id') == 'auth__error1' || el.getAttribute('id') == 'auth__error2') el.remove();
        })
        pass[0].classList.remove('auth__pass_err');
        if(pass[1]){
            pass[1].classList.remove('auth__pass_err');
        }
    err = 0;
    }
}

function addRegisteration () {
    err = 0;
    authContent.setAttribute('style', 'opacity: 0');
    setTimeout(()=>{
            authContent.innerHTML = `
        <div class="auth__text">
            <h2 class="auth__header">Регистрация</h2>
            <p class="auth__link">Войти</p>
        </div>
        <form action="" class="auth__form" name="auth">
            <input type="text" class="auth__mail" name="text" placeholder="Email">
            <div class="auth__input-wr">
                <label for="pass" class="auth__label show-hide-pass"><img src="${myajax_data.hidepass}" alt="" class="auth__pass-hide"></label>
                <input type="password" class="auth__pass passw" name="pass" placeholder="Пароль">
            </div>
            <div class="auth__input-wr auth_form-mb">
                <label for="pass_2" class="auth__label show-hide-pass_2"><img src="${myajax_data.hidepass}" alt="" class="auth__pass-hide"></label>
                <input type="password" class="auth__pass2 passw" name="pass_2" placeholder="Повторите пароль">                        
            </div>
            <input type="submit" class="auth__subm" name="reg" value="Зарегестрироваться">
        </form>`;
        document.querySelector('.auth__link').addEventListener('click', addLogin);
        var eyes = Array.from(document.querySelectorAll('.auth__label'));
        eyes.forEach(eye => eye.addEventListener('click', showHidePass));
        document.querySelector('.auth__subm').addEventListener('click', validationPass);
        pass = Array.from(document.querySelectorAll('.passw'));
        pass.forEach(p => p.addEventListener('input', changedPass));
        document.querySelector('.auth__mail').addEventListener('input', mailChange);
        authContent.setAttribute('style', 'opacity: 1');
    }, 500);

}

function addLogin () {
    err = 0;
    authContent.setAttribute('style', 'opacity: 0');
    setTimeout(()=>{
    authContent.innerHTML = `
    <div class="auth__text">
        <h2 class="auth__header">Вход</h2>
        <p class="auth__link">Зарегистрироваться</p>
    </div>
    <form action="" method="POST" class="auth__form" name="auth">
        <input type="text" class="auth__mail" name="text" placeholder="Email">
        <div class="auth__input-wr" style="margin-bottom: 20px">
            <label for="pass" class="auth__label show-hide-pass"><img src="${myajax_data.hidepass}" alt="" class="auth__pass-hide"></label>
            <input type="password" class="auth__pass passw" name="pass" placeholder="Пароль">
        </div>
        <input type="submit" class="auth__subm" name="logon" value="Войти">
    </form>
    <p class="auth__forget">Забыли пароль?</p>`;
    document.querySelector('.auth__link').addEventListener('click', addRegisteration);
    var eyes = Array.from(document.querySelectorAll('.auth__label'));
    eyes.forEach(eye => eye.addEventListener('click', showHidePass));
    document.querySelector('.auth__subm').addEventListener('click', validationPass);
    pass = Array.from(document.querySelectorAll('.passw'));
    pass.forEach(p => p.addEventListener('input', mailNPassChange));
    document.querySelector('.auth__mail').addEventListener('input', mailNPassChange);
    document.querySelector('.auth__forget').addEventListener('click', addForget);
    authContent.setAttribute('style', 'opacity: 1');
}, 500);
}

function addForget () {
    err = 0;
    authContent.setAttribute('style', 'opacity: 0');
    setTimeout(()=>{
        authContent.innerHTML = `
        <div class="auth__text">
            <h2 class="auth__header">Забыли пароль?</h2>
            <p class="auth__text-mail">Укажите ваш адрес электронной почты, мы отправим ссылку для восстановления пароля</p>
        </div>
        <form action="" class="auth__form" name="auth" style="gap: 40px">
            <input type="text" class="auth__mail mobile-mb" name="forget" placeholder="Email">
            <input type="submit" class="auth__subm auth__subm-mail" value="Отправить" name="forget">
        </form>
        <p class="auth__link">Войти</p>`;
        document.querySelector('.auth__link').addEventListener('click', addLogin);
        document.querySelector('.auth__subm').addEventListener('click', validationPass);
        document.querySelector('.auth__mail').addEventListener('input', mailChange);
        authContent.setAttribute('style', 'opacity: 1;gap: 30px');
    }, 500);
}

function addSended () {
    err = 0;
    authContent.setAttribute('style', 'opacity: 0');
    setTimeout(()=>{
        authContent.innerHTML = `
        <div class="auth__text">
            <p class="auth__temp-mail">Вам отправлено письмо с временным паролем. Используйте его для авторизации.</p>
            <h2 class="auth__header" style="font-size:40px;max-width:754px">Если вы не получили письмо, пожалуйста, проверьте папку «Спам».</h2>
        </div>
        <form action="" class="auth__form" name="auth">
            <input type="submit" class="auth__subm" value="Войти">
        </form>`;
        document.querySelector('.auth__subm').addEventListener('click', e=>{e.preventDefault(); addLogin()});
        authContent.setAttribute('style', 'opacity: 1;gap: 40px');
    }, 500);
}

/*квадратные изображения*/
function square (){
    Array.from(document.querySelectorAll('.square')).forEach(el=>{
        el.querySelector('img').setAttribute('style', 'height: '+el.clientWidth+'px')
    });
}

// function userLogout (){
//     let data = {
//         action: 'mylogout',
//         text: 'logout',
//     }
//     $.post(myajax_data.ajaxurl, data, function(resp){
//         if (resp == 'ok') {
//             let loc = location.protocol+'//'+location.hostname;
//             location.assign(loc);
//         }
//     });
// }

function registerUser () {
    var transObj = {
        action: 'myregister',
        nonce: myajax_data.nonce,
        text: document.querySelector(".auth__mail").value,
        pass: document.querySelector('.auth__pass').value,
        pass2: document.querySelector('.auth__pass2').value,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        data = JSON.parse(data);
        if (data['ok'] > 0 && data['error'] == 0){
            let loc = location.protocol+'//'+location.hostname+'/my-account';
            location.assign(loc);
        } else{
            if (data['error'] == 1){
                if (document.querySelector('#auth__error-mail') == null){
                    let spanerr = document.createElement('span');
                    spanerr.setAttribute('class', 'auth__error');
                    spanerr.setAttribute('id', 'auth__error-mail');
                    spanerr.innerText ='Такой пользователь зарегистрирован';
                    mail.classList.add('auth__pass_err');
                    mail.after(spanerr);
                    err = 1;
                }
            }
            if (data['error'] == 2){
                if (document.querySelector('#auth__error1') == null){
                    let spanerr = document.createElement('span');
                    spanerr.setAttribute('class', 'auth__error');
                    spanerr.setAttribute('id', 'auth__error1');
                    spanerr.innerText ='Пароли не совпадают';
                    pass[0].classList.add('auth__pass_err');
                    pass[1].classList.add('auth__pass_err');
                    pass[0].closest('.auth__input-wr').appendChild(spanerr);
                    err = 1;
                }
            }
        }
    });
}

function loginUser() {
    var transObj = {
        action: 'mylogin',
        nonce: myajax_data.nonce,
        text: document.querySelector(".auth__mail").value,
        pass: document.querySelector('.auth__pass').value,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        let resp = JSON.parse(data);
        if (resp['ok'] > 0 && resp['error'] == 0){
            // let loc = location.protocol+'//'+location.hostname+'/my-account';
            let loc = resp['link'];
            location.assign(loc);
        }
        if(resp['error'] > 0) {
            if (document.querySelector('#auth__error-mail') == null){
                let spanerr = document.createElement('span');
                spanerr.setAttribute('class', 'auth__error');
                spanerr.setAttribute('id', 'auth__error-mail');
                spanerr.innerText ='Неправильный логин или пароль';
                mail.classList.add('auth__pass_err');
                mail.after(spanerr);
                err = 1;
            }
        }
    });
}

function forgetUser () {
    var transObj = {
        action: 'myforget',
        nonce: myajax_data.nonce,
        text: document.querySelector(".auth__mail").value
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        data = JSON.parse(data);
    	addSended ();
        if (data['ok'] == 1) {
            
        }
    });
}

function orderHandler (e) {
    // e = e || window.event || UIEvent;
    // e.preventDefault();
    // let link = e.target.getAttribute('href');
    // let price = e.target.closest('.price__wr').querySelector('.price__content-header').innerHTML;
    // let exp = /\d+\s?\d+/
    // let reg = new RegExp(exp);
    // price = reg.exec(price);
    // price = price[0];
    // price = price.split(' ');
    // let fp = '';
    // for(i=0; i<price.length; i++){
    //     fp += price[i];
    // }
    // let transObj = {
    //     action: 'mybuy',
    //     nonce: myajax_data.nonce,
    //     p: fp,
    //     u: e.target.getAttribute('data-u'),
    //     n: e.target.getAttribute('data-n')
    // }
    // $.post(myajax_data.ajaxurl, transObj, function(data){
    //         // console.log(data)
    //     data = JSON.parse(data);
    //     if (data['ok'] == 1) {
    //         // location.assign(data['url']);
    //         console.log(data['url'])
    //     } 
    //     if(data['ok'] == 2) {
    //         alert('Вы уже приобрели этот '+ data['type']);
    //     }
    //     if (data['ok'] == 3) {
    //         alert ('Неудалось создать платеж')
    //     }
    // });
}

function notLoggedAlert (e) {
    e = e || window.event || UIEvent;
    e.preventDefault();
    alert ('Пожалуйста, авторизуйтесь для совешения покупок на сайте.')
}

function singUpForCours (e){
    e = e || window.event || UIEvent;
    e.preventDefault();
    document.querySelector('.signup_for_curs').classList.add('sign_show');
    document.querySelector('.signup_for_curs').classList.remove('sign_hide');
    document.querySelector('body').classList.add('overflow');
}

function closeSignForCours () {
    document.querySelector('.signup_for_curs').classList.remove('sign_show');
    document.querySelector('.signup_for_curs').classList.add('sign_hide');
    document.querySelector('body').classList.remove('overflow');
}

function sendNotation (e){
    e = e || window.event || UIEvent;
    e.preventDefault();
    var name = document.querySelector('#sign_name').value;
    var mail = document.querySelector('#sign_mail').value;
    var phone = document.querySelector('#sign_phone').value;
    let transObj = {
        action: 'myNotation',
        nonce: myajax_data.nonce,
        n: name,
        m: mail,
        p: phone
    }
    if(name.length>0){
        if (phone.length > 0 || mail > 0){
            $.post(myajax_data.ajaxurl, transObj, function(data){
                data = JSON.parse(data);
                if(data['ok'] == 'ok'){
                    alert('Ваше заявка успешно отправлена. Скоро с Вами свяжется специалист.');
                    closeSignForCours();
                }
            });
        } else {
            alert('Укажите почту или телефон');
        }
    } else {
        alert("Укажите имя")
    }
}

function checkNumbInput (e) {
    e.preventDefault();
    if(sign_phone.value.length<11){
        var numbs = [1,2,3,4,5,6,7,8,9,0];
        numbs.forEach(n => {
            if(n == e.key){
                sign_phone.value += e.key;
            }
        });
    }
}

function showSignForm (e) {
    var wrapper = document.createElement('div');
    wrapper.setAttribute('class', 'feedback_wrapper');
    var cover = document.createElement('div');
    cover.setAttribute('class', 'feedback_cover');
    wrapper.appendChild(cover);
    var form = document.createElement('form');
    form.setAttribute('class', 'feedback_form');
    wrapper.appendChild(form);
    var title = document.querySelector('p')
    title.setAttribute('class', 'feedback_title');
    title.innerText = 'Оставить заявку';
    form.appendChild(title);
    var name = document.createElement('input');
    name.setAttribute('name', 'client_name');
    name.setAttribute('type', 'text');
    name.setAttribute('class', 'feedback_input');
    name.setAttribute('placeholder', 'ФИО');
    form.appendChild(name);
    var phone = document.createElement('input');
    phone.setAttribute('name', 'client_phone');
    phone.setAttribute('type', 'text');
    phone.setAttribute('class', 'feedback_input');
    phone.setAttribute('placeholder', 'Телефон');
    IMask(phone, {
        mask: '+{7}(000)000-00-00'
    })
    form.appendChild(phone);
    var mail = document.createElement('input');
    mail.setAttribute('name', 'client_mail');
    mail.setAttribute('type', 'text');
    mail.setAttribute('class', 'feedback_input');
    mail.setAttribute('placeholder', 'e-mail');
    form.appendChild(mail);
    var subm = document.createElement('button');
    subm.setAttribute('name', 'client_btn');
    subm.setAttribute('type', 'button');
    subm.setAttribute('class', 'feedback_btn');
    subm.setAttribute('value', 'Записаться');
    subm.innerText = 'Записаться';
    form.appendChild(subm);
    var close = document.createElement('div');
    close.setAttribute('class', 'feedback__closeform');
    wrapper.appendChild(close);
    var close_inner = document.createElement('div');
    close_inner.setAttribute('class', 'feedback__closeform_inner');
    form.appendChild(close_inner);

    if(!document.querySelector('.feedback_wrapper')){
        document.querySelector('.price').appendChild(wrapper);
        cover.addEventListener('click', ()=>closefbform(wrapper));
        close_inner.addEventListener('click', ()=>closefbform(wrapper));
        close.addEventListener('click', ()=>closefbform(wrapper));
        subm.addEventListener('click', signForIndiividuals)
    }
}

function closefbform (wr) {
    wr.classList.add('hidefbform')
    setTimeout(() => {
        wr.remove();
    }, 500);
}

function signForIndiividuals () {
    var transObj = {
        action: 'signForIndiividuals',
        nonce: myajax_data.nonce,
        name: document.querySelector("[name='client_name']").value,
        phone: document.querySelector("[name='client_phone']").value,
        email: document.querySelector("[name='client_mail']").value,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        console.log(data);
        data = JSON.parse(data);
    	addSended ();
        if (data['ok'] == 1) {
            closefbform(document.querySelector('.feedback_wrapper'))
        }
    });
}

function showGalery (swiper) {
    if(!document.querySelector('.galery_wrapper')){
        var wrapper = document.createElement('div');
        wrapper.setAttribute('class', 'galery_wrapper');
        var cover = document.createElement('div');
        cover.setAttribute('class', 'galery_cover');
        wrapper.appendChild(cover);
        var imgWr = document.createElement('div');
        imgWr.setAttribute('class', 'galery__img_wrapper');
        wrapper.appendChild(imgWr)
        var img = document.createElement('img');
        img.setAttribute('class', 'galery__img');
        img.setAttribute('alt', '');
        img.setAttribute('src', swiper.clickedSlide.querySelector('img').getAttribute('src'))
        imgWr.appendChild(img);
        var next = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        next.setAttribute('class', 'swiper-button-next')
        next.setAttribute('width', '50');
        next.setAttribute('height', '50');
        next.setAttribute('viewBox', '0 0 50 50');
        next.setAttribute('fill', 'none');
        next.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        next.setAttribute('tabIndex', '0');
        next.setAttribute('role', 'button');
        var nextc = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        nextc.setAttribute('cx', '25');
        nextc.setAttribute('cy', '25');
        nextc.setAttribute('r', '25');
        nextc.setAttribute('fill', '#DFB19C');
        var nextp = document.createElementNS("http://www.w3.org/2000/svg", "path");
        nextp.setAttribute('d', 'M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5');
        nextp.setAttribute('stroke', 'white');
        nextp.setAttribute('stroke-linecap', 'round');
        nextp.setAttribute('stroke-linejoin', 'round');
        next.appendChild(nextc);
        next.appendChild(nextp)

        var prev = document.createElementNS("http://www.w3.org/2000/svg", "svg");
        prev.setAttribute('class', 'swiper-button-prev')
        prev.setAttribute('width', '50');
        prev.setAttribute('height', '50');
        prev.setAttribute('viewBox', '0 0 50 50');
        prev.setAttribute('fill', 'none');
        prev.setAttribute('xmlns', 'http://www.w3.org/2000/svg');
        prev.setAttribute('tabIndex', '0');
        prev.setAttribute('role', 'button');
        var prevc = document.createElementNS("http://www.w3.org/2000/svg", "circle");
        prevc.setAttribute('cx', '25');
        prevc.setAttribute('cy', '25');
        prevc.setAttribute('r', '25');
        prevc.setAttribute('fill', '#DFB19C');
        var prevp = document.createElementNS("http://www.w3.org/2000/svg", "path");
        prevp.setAttribute('d', 'M33.75 25H16.25M33.75 25L26.25 32.5M33.75 25L26.25 17.5');
        prevp.setAttribute('stroke', 'white');
        prevp.setAttribute('stroke-linecap', 'round');
        prevp.setAttribute('stroke-linejoin', 'round');
        prev.appendChild(prevc);
        prev.appendChild(prevp)
        var close = document.createElement('div');
        close.setAttribute('class', 'galery__closeform');
        imgWr.appendChild(close);

        imgWr.appendChild(next);
        imgWr.appendChild(prev)
    
        prev.addEventListener('click', ()=>{
            document.querySelector('.otz__content').swiper.slidePrev()
        })
        next.addEventListener('click', ()=>{
            document.querySelector('.otz__content').swiper.slideNext()
        })

        document.querySelector('.otz').appendChild(wrapper);
        changeImgSize();
        cover.addEventListener('click', ()=>closeGalery(wrapper));
        close.addEventListener('click', ()=>closeGalery(wrapper));
        window.addEventListener('resize', changeImgSize);
    }
    console.log(swiper.clickedSlide.querySelector('img').getAttribute('src'))
    // img.setAttribute('src', document.querySelector('.otz__content').swiper.clickedSlide())
}

function changeImgSize () {
    console.log('1')
    var el = document.querySelector('.galery__img');
    var dimentions = get_dimensions(el);
    var el_width = dimentions.real_width === 0 ? dimentions.client_width : dimentions.real_width;
    var el_height = dimentions.real_height === 0 ? dimentions.client_height : dimentions.real_height;
    var el_rels = el_width/el_height;
    var max_w = document.querySelector('body').clientWidth * 0.8;
    var max_h = window.innerHeight * 0.8;
    var el_pos_width = max_w;
    var el_pos_height = el_pos_width / el_rels;
    if(el_pos_height > max_h) {
        $(el).css('height', max_h+'px');
        $(el).css('width', 'auto');
    } else {
        $(el).css('width', max_w+'px');
        $(el).css('height', 'auto');
    }
}

function get_dimensions(el) {
    // Браузер с поддержкой naturalWidth/naturalHeight
    if (el.naturalWidth!=undefined) {
        return { 'real_width':el.naturalWidth,
                 'real_height':el.naturalHeight,
                 'client_width':el.width,
                 'client_height':el.height };
    }
    // Устаревший браузер
    else if (el.tagName.toLowerCase()=='img') {
        var img=new Image();
        img.src=el.src;
        var real_w=img.width;
        var real_h=img.height;
        return { 'real_width':real_w,
                 'real_height':real_h,
                 'client_width':el.width,
                 'client_height':el.height };
    }
    // Что-то непонятное
    else {
        return false;
    }
}

function closeGalery (wrapper) {
    wrapper.classList.add('hidefbform');
    setTimeout(() => {
        wrapper.remove();
        window.removeEventListener('resize', changeImgSize)
    }, 500);
}