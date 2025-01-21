document.addEventListener('DOMContentLoaded', ()=>{
    if(document.querySelector('form .dashicons')){
        document.querySelector('form .dashicons').style.setProperty('--show', 'url('+peremen['hidepass']+')');
        document.querySelector('form .dashicons').style.setProperty('--hide', 'url('+peremen['showpass']+')');
    }
});