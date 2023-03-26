$(document).ready(function(){
    $(window).scroll(function(){
        // sticky navbar on scroll script
        if(this.scrollY > 20){
            $('.navbar').addClass("sticky");
        }else{
            $('.navbar').removeClass("sticky");
        }

        //   =======scroll-up button show/hide script
        if(this.scrollY > 500){
            $('.scroll-up-btn').addClass("show");
        }else{
            $('.scroll-up-btn').removeClass("show");
        }
    });

    // s===========lide-up script
    $('.scroll-up-btn').click(function(){
        $('html').animate({scrollTop: 0});
        // removing smooth scroll on slide-up button click
        $('html').css("scrollBehavior", "auto");
    });

    $('.navbar .menu li a').click(function(){
        // applying again smooth scroll on menu items click
        $('html').css("scrollBehavior", "smooth");
    });

    // toggle menu/navbar script
    $('.menu-btn').click(function(){
        $('.navbar .menu').toggleClass("active");
        $('.menu-btn i').toggleClass("active");
    });

    // typing text animation script
    var typed = new Typed(".typing", {
        strings: ["Service", " à l'écoute", "sérieux"],
        typeSpeed: 100,
        backSpeed: 60,
        loop: true
    });
    // owl carousel script
    $('.carousel').owlCarousel({
        margin: 20,
        loop: true,
        autoplayTimeOut: 2000,
        autoplayHoverPause: true,
        responsive: {
            0:{
                items: 1,
                nav: false
            },
            600:{
                items: 2,
                nav: false
            },
            1000:{
                items: 3,
                nav: false
            }
        }
    });


});
// ===========animation trait début
let path = document.querySelector('path')
let pathlength = path.getTotalLength()

path.style.strokeDasharray = pathlength + ' ' + pathlength;
path.style.strokeDashoffset = pathlength ;

window.addEventListener('scroll', () =>{

    var scrollPercentage = (document.documentElement.scrollTop + document.body.scrollTop) / (document.documentElement.scrollHeight - document.documentElement.clientHeight);

    var drawlength = pathlength * scrollPercentage;

    path.style.strokeDashoffset = pathlength - drawlength;

    const  target = document.querySelectorAll('.scroll')

    var index = 0, length = target.length;
    for(index; index < length; index++){
        var pos = window.pageYOffset = target[index].dataset.rate;

        if(target[index].dataset.direction === 'vertical'){
            target[index].style.transform = 'translate3d(0px,' +pos+'px, 0px)';

        }else{
            var posX = window.pageYOffset = target[index].dataset.ratex;
            var posY = window.pageYOffset = target[index].dataset.ratey;

            target[index].style.transform = 'translate3d('+posX+'px, '+posY+'px, 0px)';
        }
    }
})



