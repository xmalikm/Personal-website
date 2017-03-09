// google mapa
function initMap() {
        var uluru = {lat: 48.160784, lng: 17.132897}; 
        var map = new google.maps.Map(document.getElementById('google-map'), {
            zoom: 13,
            center: uluru,
            scrollwheel:  false,
            styles: [
                {
                    "featureType": "poi.business",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                },
                {
                    "featureType": "poi.park",
                    "elementType": "labels.text",
                    "stylers": [
                        {
                            "visibility": "off"
                        }
                    ]
                }
            ]
        });
        var marker = new google.maps.Marker({
            position: uluru,
            map: map
        });
    }

$(document).ready(function(){

    // navigacne menu
    var $navbar = $('.navbar');

    // smooth scrollovanie na sekcie po kliknuti na linky v navbare alebo na animaciu na titulnej stranke
    $(".navbar a, .scroll-icon").on('click', function(event) {
            // Make sure this.hash has a value before overriding default behavior
            if (this.hash !== "") {
                // zabranenie defaultnemu spravaniu sa linku
                event.preventDefault();

                // ulozime hash
                var hash = this.hash;

                // na smooth scrollovanie pouzijeme jQuery funkciu animate
                // cas animacie je 0.9s
                $('html, body').animate({
                    scrollTop: $(hash).offset().top
                    }, 900, function(){
                        // callback funkcia animacie - pridanie hashu k url-ke
                        window.location.hash = hash;
                });
            }
    });

    // fixnutie navbaru na vrch stranky
    function stickNavbar(){
            // ak odscollujeme 20px od vrchu stranky pridaj triedu navbaru
            if($(this).scrollTop() > 20) {
                $navbar.addClass('navbar-scrolled');
            }
            // inak triedu odober
            else {
                $navbar.removeClass('navbar-scrolled');
            }
    }

    // slide animacia elementu
    function slide() {
            $("[class*='slide-anim']").each(function(){
                // pozicia elementu od vrchu
                var $elemPosition = $(this).offset().top,
                    // pozicia okna prehliadaca od vrchu
                    $winTop = $(window).scrollTop(),
                    // meno triedy elementu
                    $elemClass = $(this).attr('class');

                // ak je pozicia elementu mensia ako pozicia okna prehliadaca + 600px
                if ($elemPosition < $winTop + 600) {
                    // ak element obsahuje danu triedu
                    if($elemClass.indexOf('slide-anim-down') != -1) {
                        // pridaj triedu elementu
                        $(this).addClass("slide-down");
                    }
                    // ak element obsahuje danu triedu
                    else if($elemClass.indexOf('slide-anim-left') != -1) {
                        // pridaj triedu elementu
                        $(this).addClass("slide-left");
                    }
                    // ak element obsahuje danu triedu
                    else if($elemClass.indexOf('slide-anim-right') != -1) {
                        // pridaj triedu elementu
                        $(this).addClass("slide-right");
                    }
                }
            });
    }

    // volanie funkcii hned po nacitanii stranky,
    // ak je zoscrollovane od vrchu, zobrazi sa fixed navbar
    stickNavbar();
    // ak sa slide element nachadza vo viewporte prehliadaca,
    // tak sa element zobrazi
    slide();

    // volanie funkcii pri scrollovani
    $(window).scroll(function(){
        // zobrazenie fixed navbaru
        stickNavbar();
        // zobrazenie slide elementov
        slide();
    });

})