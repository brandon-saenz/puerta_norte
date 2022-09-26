// document.querySelector('.draw-logo-path-'+i).style.fill='black';
// var dasharray_fig=fig.getTotalLength().toFixed(0);

document.addEventListener("DOMContentLoaded", function() {
    console.log('SCRIPT DEL PROYECTO FUNCIONANDO'); 
    setTimeout(function(){
        onIntro();
    },100);
});


function onIntro(){
    var svg = document.querySelector('.logo');
    var slogan_logo = document.querySelector('.slogan-logo');
    var loader_spin = document.querySelector('.loader-spin');
    svg.classList.remove('opacity-null');
    setTimeout(function(){
        slogan_logo.classList.remove('opacity-null');
        setTimeout(function(){
            loader_spin.classList.remove('opacity-null');
        },1000);
    },1000);
}
