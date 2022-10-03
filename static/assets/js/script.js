// document.querySelector('.draw-logo-path-'+i).style.fill='black';
// var dasharray_fig=fig.getTotalLength().toFixed(0);

var tabs_swiper, lista_productos_swiper, modal_product_swiper, side_orden_swiper;

document.addEventListener("DOMContentLoaded", function() {
    console.log('SCRIPT DEL PROYECTO FUNCIONANDO'); 
    // setTimeout(function(){
    //     onIntro();
    // },100);
    offIntro();
    M.AutoInit();
    tabs_swiper = new Swiper(".tabs-swiper", {
        modules: [eventsTabsSwiper],
        // keyboard: {
        //     enabled: true,
        // },
        hashNavigation: {
            watchState: true,
        },
        debugger: true,
        allowTouchMove: true,
    });


    modal_product_swiper = new Swiper(".modal-product-swiper", {
        modules: [eventsModalProductoSwiper],
        keyboard: {
            enabled: true,
        },
        hashNavigation: {
            watchState: true,
        },
        debugger: true,
        allowTouchMove: false,
    });

    side_orden_swiper = new Swiper(".side-orden", {
        modules: [eventsSideOrdenSwiper],
        keyboard: {
            enabled: true,
        },
        hashNavigation: {
            watchState: true,
        },
        debugger: true,
        allowTouchMove: true,
    });


    // $('#nota_producto').characterCounter();
});


function eventsTabsSwiper({ swiper, extendParams, on }) {
    extendParams({
        debugger: false,
    });

    on('slideChange', () => {
        if (!swiper.params.debugger) return;
        menu.selectTab(swiper.activeIndex);  
    });
}

function eventsListaProductosSwiper({ swiper, extendParams, on }) {
    extendParams({
        debugger: false,
    });

    on('slideChange', () => {
        if (!swiper.params.debugger) return;
    });
}

function eventsModalProductoSwiper({ swiper, extendParams, on }) {
    extendParams({
        debugger: false,
    });

    on('slideChange', () => {
        if (!swiper.params.debugger) return;
    });
}

function eventsSideOrdenSwiper({ swiper, extendParams, on }) {
    extendParams({
        debugger: false,
    });

    on('slideChange', () => {
        if (!swiper.params.debugger) return;
    });
}


function slideToIndex(instance, index, timer){
    instance.slideTo(index, timer);
}

function loop() {
    setTimeout(function() {
        loop();
    }, 10000);
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