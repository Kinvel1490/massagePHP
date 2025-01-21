var content;
var menuItems;
var username, usermail, userphone, cursContent, stadium;
username = "Не известно";
usermail = "Не известно";
userphone = "Не известно";
document.addEventListener('DOMContentLoaded', ()=>{
    content = document.querySelector('.lk__right-wr');
    addInfo();
    menuItems = Array.from(document.querySelectorAll('.lk__menu-item-wr'));
    menuItems.forEach(el => el.addEventListener('click', switchMenu));
    stadium = document.querySelector('.lk__stadium')
});

function addRedatcion (e) {
    if(document.querySelector('#lk_redact')) return;
    e = e || window.event || UIEvent;
    var transObj = {
        action: 'myGetUser',
        nonce: myajax_data.nonce,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        let resp = JSON.parse(data);
        let mail, name, phone;
        if (resp['ok'] == 1) {
            let user = resp['user'];
            if(user['mail'] == ''){mail = "не известно";} else {mail = user['mail']}
            if(user['name'] == ''){name = "не известно";} else {name = user['name']}
            if(user['phone'] == ''){phone = "телефон";} else {phone = user['phone']}
            content.setAttribute('style', 'opacity: 0');
            setTimeout(()=>{
                content.innerHTML = `
                <div class="lk__backwards-wr">
                    <img src="${myajax_data.back_wards}" alt="backwards" class="lk__backwarrds-arrow">
                    <p class="lk__backwards">Назад</p>
                </div>
                <h3 class="lk__header lk_small-text">Редактировать профиль</h3>
                <div class="lk__info" id="lk_redact">
                    <form action="" class="lk__form" name="lk_form">
                        <div class="lk__form-name-wr">
                            <input type="text" class="lk__form-name" name="lk_name" placeholder="Имя"  value="${name}">
                        </div>
                        <input type="password" class="lk__form-pass" name="lk_pass" placeholder="Пароль">
                        <div class="lk__form-mail-wr">
                            <input type="text" class="lk__form-mail" name="lk_mail" placeholder="Email" value="${mail}">
                        </div>
                        <input type="text" class="lk__form-phone" name="lk_phone" placeholder="Телефон" value="${phone}">
                        <input type="submit" class="lk__form-subm" name="lk_subm" value="Сохранить изменения">
                    </form>
                </div>`;
                document.querySelector('.lk__form-subm').addEventListener('click', saveChanges);
                document.querySelector('.lk__form-name').addEventListener('input', nameChange)
                document.querySelector('.lk__form-mail').addEventListener('input', mailChange);
                document.querySelector('.lk__backwards-wr').addEventListener('click', ()=>{
                content.setAttribute('style', 'opacity: 0');
                setTimeout(()=>{addInfo();},
                500);
            });
            content.setAttribute('style', 'opacity: 1')},
            500);
        }
    });
}

function nameChange () {
    if (document.querySelector('#auth__error-name')){
        document.querySelector('#auth__error-name').remove();
        document.querySelector('.lk__form-name').classList.remove('auth__pass_err');    
    }
}

function addInfo () {
    if(document.querySelector('#lk__profile')) return;
    var transObj = {
        action: 'myGetUser',
        nonce: myajax_data.nonce,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        let resp = JSON.parse(data);
        let mail, name, avatar, phone, avatar_replacer, a;
        if (resp['ok'] == 1) {
            let user = resp['user'];
            if(user['mail'] == ''){mail = "не известно";} else {mail = user['mail']}
            if(user['name'] == ''){name = "не известно";} else {name = user['name']}
            if(user['avatar'] != ''){avatar = user['avatar']}
            if(user['phone'] == ''){phone = "телефон";} else {phone = user['phone']}
        }
        var expr = /user[0-9]+\/$/;
        let rg = new RegExp(expr);
        if(rg.test(avatar)){
            let letter = ((name[0].toUpperCase()));
            a = `<div class="lk_avatar lk_avatar_replacer" id="avatar_img"><p>${letter}</p></div>`
        } else {
            a = `<img src="${avatar}" alt="Avatar" class="lk_avatar" id="avatar_img">`;
        }

    content.innerHTML = `
    <img src="${myajax_data.back_wards}" alt="Назад" class="lk__backwards-mobile-only">
    <h2 class="lk__header" id="lk__profile">Профиль</h2>
    <div class="lk__info" id="lk__limit-width-480">
        <div class="lk__name-info-wr">
            <input type="file" id="avatar_changer" name="avatar_file" accept=".jpg, .jpeg, .png">
            ${a}
            <h3 class="lk__name" >${name}</h3>
            <div class="lk__edit-wr">
                <img src="${myajax_data.redact}" alt="pen" class="lk__edit-img">
                <p class="lk__edit-txt">${myajax_data.redact_txt}</p>
            </div>
        </div>
        <p class="lk__main-info">Основная информация</p>
        <div class="lk__main-info-wr">
            <div class="lk__main-info-item">
                <p class="lk__main-info-name">Email</p>
                <p class="lk__main-info-content">${mail}</p>                        
            </div>
            <div class="lk__main-info-item">
                <p class="lk__main-info-name">Телефон</p>
                <p class="lk__main-info-content">${phone}</p>                        
            </div>
        </div>
    </div>`;
    content.setAttribute('style', 'opacity: 1');
    document.querySelector('#avatar_img').addEventListener('click', ()=>$('#avatar_changer').click());
    document.querySelector('#avatar_changer').addEventListener('change', avatarFileAdder);
    document.querySelector('.lk__edit-wr').addEventListener('click', addRedatcion);
    document.querySelector('.lk__backwards-mobile-only').addEventListener('click', backwardsMobileOnly);
});
}

function avatarFileAdder(e){
    e.stopPropagation(); // остановка всех текущих JS событий
	e.preventDefault();
    if( typeof e.target.files == 'undefined' ) return;
    let f = new FormData();
    files = e.target.files;
    f.append('avatar', e.target.files[0]);
    f.append('action', 'myAddAvatar');
    f.append('nonce', myajax_data.nonce)
    $.ajax({
        url: myajax_data.ajaxurl,
        type: "POST",
        data: f,
        cache: false,
        processData: false,
        contentType: false,
        success: function(msg, status, jqxhr){
            let resp = JSON.parse(msg);
            if(resp['error'] != 0){alert(resp['error']); return;}
            else {
                if(document.querySelector('.lk_avatar_replacer')){
                    document.querySelector('.lk_avatar_replacer').remove();
                    let aimg = document.createElement('img');
                    aimg.setAttribute('class', 'lk_avatar');
                    aimg.setAttribute('id', 'avatar_img');
                    aimg.setAttribute('alt', 'Avatar');
                    aimg.setAttribute('src', resp['ok']);
                    document.querySelector('.lk__name').before(aimg);
                } else {
                document.querySelector('.lk_avatar').setAttribute('src', resp['ok']);}
            }
        }
    });
}

function addSupp () {
    if(document.querySelector('#lk__supp')) {return}
    content.innerHTML = `
    <img src="${myajax_data.back_wards}" alt="Назад" class="lk__backwards-mobile-only">
    <h2 class="lk__header"  id="lk__supp">Поддержка</h2>
    <form action="" class="lk__form-supp" name="lk_form">
        <textarea class="lk__form-supp-msg" name="lk_supp-msg" placeholder="Введите ваше  сообщение" autocorrect required></textarea>
        <input type="submit" class="lk__form-subm" name="lk_subm-supp" value="Отправить">
    </form>`;
    content.setAttribute('style', 'opacity: 1');
    document.querySelector('.lk__backwards-mobile-only').addEventListener('click', backwardsMobileOnly);
    document.querySelector('.lk__form-subm').addEventListener('click', sendHelp);
}

function addCurs () {
    var transObj = {
        action: 'myAddCurs',
        nonce: myajax_data.nonce,
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        var resp = JSON.parse(data);
        localStorage.setItem('vids', resp['script']);
        content.innerHTML = resp['content'];
        content.setAttribute('style', 'opacity: 1')
        document.querySelector('.lk__backwards-mobile-only').addEventListener('click', backwardsMobileOnly);
        cursContent = $('.lk__curs-content-wr');
        $('.lk__curs-wr').on('click', showHideCurs)
        Array.from(document.querySelectorAll('.lk__curs-content')).forEach(el => el.addEventListener('click', addVideo));
    });
}

var curvid = 0;

function addVideo (e) {
    let bread1 = e.target.closest('.lk__info').querySelector('.lk_curs-name').innerText;
    let bread2 = e.target.closest('.lk__curs-content').querySelector('.lk__curs-content-head').innerText;
    let name = e.target.closest('.lk__curs-content').querySelector('.lk__curs-content-txt').innerText;
    content.setAttribute('style', 'opacity: 0');
    var videos = localStorage.getItem('vids');
    var ind = videos.lastIndexOf(',');
    var pone = videos.substring(0, ind);
    var ptwo = videos.substring(ind+1);
    videos = pone + ptwo;
    videos = JSON.parse(videos);
    console.log(videos)
    var vidind = e.target.closest('.lk__curs-content').getAttribute('data-c');
    setTimeout(()=>{
    content.innerHTML = `
    <img src="${myajax_data.back_wards}" alt="Назад" class="lk__backwards-mobile-only">
    <div class="lk__bread-cumbs">
        <p class="bread-cumbs__main" onclick=backToCurs()>${bread1}</a>
        <span class="slash">/</span>
        <p class="bread-cumbs__current">${bread2}</p>
    </div>
    <div class="lk__curs-vid-header">
        <h3 class="lk__curs-vid-header l1">${bread2}</h3>
        <h3 class="lk__curs-vid-header l2">${name}</h3>
    </div>
    <h4 class="hero__video_header">${videos[vidind][0].n}</h4>
    <div class="hero__video-wr lk_video">
        <video src="${videos[vidind][0].v}" class="hero__video video" id="lk_video"></video>
        <img src="${myajax_data.vid_play}" alt="play" class="hero__play play">
    </div>
    <div class="lk__video-contols">
        <img src="${myajax_data.lk_prev}" alt="Предыдущее видео" class="lk__video-controls lk_prev">
        <img src="${myajax_data.LK_play}" alt="Смотреть" class="lk__video-controls lk_play">
        <img src="${myajax_data.lk_next}" alt="Следующее видео" class="lk__video-controls lk_next">
    </div>`;
    curvid = 0;
    document.querySelector('.lk_play').addEventListener('click', lkPlay);
    document.querySelector('.play').addEventListener('click', lkPlay);
    document.querySelector('.video').addEventListener('pause', pause);
    document.querySelector('.lk_prev').addEventListener('click', ()=>{prev_lk_video(videos[vidind])});
    document.querySelector('.lk_next').addEventListener('click', ()=>{next_lk_video(videos[vidind])});
    document.querySelector("#lk_video").addEventListener('fullscreenchange', (e)=>{
        e.target.classList.toggle('contained-video');
    })
    content.setAttribute('style', 'opacity: 1')},
    500);
}

function next_lk_video (vid) {
    console.log(vid)
    var shownvid = document.querySelector('#lk_video');
    var shownvidsrc = shownvid.getAttribute('src');
    let next = 0;
    vid.forEach(v=>{
        if (v.v == shownvidsrc){
            next = vid.indexOf(v)+1;
        }
    })
    if(next > vid.length - 1){
        next = vid.length - 1;
    }
    if(next != curvid) {
        shownvid.setAttribute('src', vid[next].v);
        document.querySelector(".hero__video_header").innerText=vid[next].n
        curvid = next
    }
}

function prev_lk_video (vid) {
    var shownvid = document.querySelector('#lk_video');
    var shownvidsrc = shownvid.getAttribute('src');
    let next = 0;
    vid.forEach(v=>{
        if (v.v == shownvidsrc){
            next = vid.indexOf(v)-1;
        }
    })
    if(next < 0){
        next = 0;
    }
    if(next != curvid) {
        shownvid.setAttribute('src', vid[next].v);
        document.querySelector(".hero__video_header").innerText = vid[next].n
        curvid = next
    }
}

function backToCurs () {
        content.setAttribute('style', 'opacity: 0');
         setTimeout(()=>{
            addCurs();
            },
            500);
}

function switchMenu (e) {
    e = e || window.event || UIEvent;
    menuItems.forEach(el => el.classList.remove('lk__active'));
    e.target.closest('.lk__menu-item-wr').classList.add('lk__active');
    let lkID = e.target.closest('.lk__menu-item-wr').getAttribute('id');
    switch (lkID) {
        case 'lk_1': stadiumMover (); if(document.querySelector('#lk__profile')) {break}; switcher (addInfo); break;
        case 'lk_2': stadiumMover (); if(document.querySelector('#lk__curs')) {break}; switcher (addCurs); break;
        case 'lk_3': stadiumMover (); if(document.querySelector('#lk__supp')) {break}; switcher (addSupp); break;
    }
}

function switcher (callback) {
    if (matchMedia("(max-width: 767px)").matches){
        callback();
    } else {
        content.setAttribute('style', 'opacity: 0');
         setTimeout(()=>{
            callback();
            },
            500);
        }
}

function stadiumMover () {
    if (matchMedia("(max-width: 767px)").matches){
        stadium.setAttribute('style', 'transform:translateX(calc(-100% - 60px))')
    }
}

function sendHelp (e) {
    e = e || window.event || UIEvent;
    e.preventDefault();
    var transObj = {
        action: 'sendHelp',
        nonce: myajax_data.nonce,
        help: document.querySelector('.lk__form-supp-msg').value
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
            alert('Ваше письмо успешно отправлено');
    });
}

function saveChanges (e) {
    e = e || window.event || UIEvent;
    e.preventDefault();
    username = document.querySelector('.lk__form-name').value;
    usermail = document.querySelector('.lk__form-mail').value;
    userphone = document.querySelector('.lk__form-phone').value;
    userpass = document.querySelector('.lk__form-pass').value;
    var transObj = {
        action: 'mySaveUserChanges',
        nonce: myajax_data.nonce,
        name: username,
        mail: usermail,
        phone: userphone,
        pwd: userpass
    }
    $.post(myajax_data.ajaxurl, transObj, function(data){
        let resp = JSON.parse(data);
        if (resp['user_ok'] == 1 && resp['mail_ok'] == 1) {
            if(resp['user_error'] != 1 && resp['mail_error'] != 1){
                content.setAttribute('style', 'opacity: 0');
                addInfo();
            }
        }
        if (resp['user_error'] == 1){
            if (document.querySelector('#auth__error-name') == null){
                let spanerr = document.createElement('span');
                spanerr.setAttribute('class', 'auth__error');
                spanerr.setAttribute('id', 'auth__error-name');
                spanerr.innerText ='Это имя уже занято';
                document.querySelector('.lk__form-name').classList.add('auth__pass_err');
                document.querySelector('.lk__form-name').after(spanerr);
            }
        }
        if (resp['mail_error'] == 1){
            if (document.querySelector('#auth__error-mail') == null){
                let spanerr = document.createElement('span');
                spanerr.setAttribute('class', 'auth__error');
                spanerr.setAttribute('id', 'auth__error-mail');
                spanerr.innerText ='Такой пользователь уже есть';
                document.querySelector('.lk__form-mail').classList.add('auth__pass_err');
                document.querySelector('.lk__form-mail').after(spanerr);
            }
        }
    });
}

function showHideCurs (e) {
    let tar = $(e.target).parents('#lk_limit-width');
    if (tar.children('.lk__curs-content-wr').attr('style') != 'display: block;'){
        tar.children('.lk__curs-content-wr').slideDown(500);
        tar.find('.lk_curs-arrow').addClass('arrow-rotate')
    } else {
        tar.children('.lk__curs-content-wr').slideUp(500);
        tar.find('.lk_curs-arrow').removeClass('arrow-rotate')}
}

function backwardsMobileOnly () {
    stadium.setAttribute('style', 'transform: translateX(0)')
}

function lkPlay () {
    let vid = document.querySelector('.video');
    if (vid.getAttribute('controls') === null) {
        vid.setAttribute('controls', '');
        vid.play();
        document.querySelector('.hero__play').setAttribute('style', 'display:none');
    }
}

function pause (e) {
    e.target.removeAttribute('controls');
    e.target.nextElementSibling.setAttribute('style', 'display:block');
}

window.addEventListener('resize', ()=>{
    if(stadium.getAttribute('style') == 'transform:translateX(calc(-100% - 60px))' && !matchMedia("(max-width: 767px)").matches){
        stadium.setAttribute('style', 'transform: translateX(0)');
    }
})