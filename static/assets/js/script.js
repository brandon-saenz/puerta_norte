// document.querySelector('.draw-logo-path-'+i).style.fill='black';
// var dasharray_fig=fig.getTotalLength().toFixed(0);

document.addEventListener("DOMContentLoaded", function() {
    console.log('SCRIPT DEL PROYECTO FUNCIONANDO'); 
    // setTimeout(function(){
    //     onIntro();
    // },100);
    offIntro();
    M.AutoInit();
    alta_swiper = new Swiper(".alta-swiper", {
        modules: [eventsAltaSwiper],
        // keyboard: {
        //     enabled: true,
        // },
        hashNavigation: {
            watchState: true,
        },
        debugger: true,
        allowTouchMove: false,
    });
    
    tabs_swiper = new Swiper(".tabs-swiper", {
        modules: [eventsTabsSwiper],
        // keyboard: {
        //     enabled: true,
        // },
        hashNavigation: {
            watchState: true,
        },
        debugger: true,
        allowTouchMove: false,
    });
});

function eventsTabsSwiper({ swiper, extendParams, on }) {
    extendParams({
      debugger: false,
    });

    on('slideChange', () => {
        if (!swiper.params.debugger) return;
        if(swiper.activeIndex>=1){
            console.log('COMPLETADO');
        }else{
            console.log('INICIO');
        }    
    });
}


function onIntro(){
    var svg = document.querySelector('.logo');
    var slogan_logo = document.querySelector('.slogan-logo');
    var loader_spin = document.querySelector('.loader-spin');
    svg.classList.remove('opacity-null');
    setTimeout(function(){
        slogan_logo.classList.remove('opacity-null');
        setTimeout(function(){
            loader_spin.classList.remove('opacity-null');
            setTimeout(function(){
                offIntro();
            },2000);
        },1000);
    },1000);
}

function offIntro(){
    var intro = document.querySelector('.intro');
    intro.classList.add('opacity-null');
    setTimeout(function(){
        intro.style.display='none';
    },500);
    viewContent();
}

function viewContent(){
    var content_page = document.querySelector('.content');
    content_page.style.display='block';
    setTimeout(function(){
        content_page.classList.remove('opacity-null');
    },1);
}