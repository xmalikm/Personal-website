(function ($) {
	"use strict";

	/*------------------------------------
		Preloader
	-------------------------------------- */
	$(window).on('load', function () {
		$('.lds-ellipsis').fadeOut();
		$('.preloader').delay(333).fadeOut('slow');
		$('body').delay(333);
	});

	/*------------------------------------
		Header Sticky
	-------------------------------------- */
	$(window).on('scroll',function () {
		let stickytopslide = $('#header.sticky-top-slide');
		if ($(this).scrollTop() > 180) {
			stickytopslide.find(".primary-menu").addClass("sticky-on");
			$('body').css('margin-top', '71px');
		} else {
			stickytopslide.find(".primary-menu").removeClass("sticky-on");
			$('body').css('margin-top', '0');
		}
	});

	/*------------------------------------
		Sections Scroll
	-------------------------------------- */
	if ($("body").hasClass("side-header")) {
		$('.smooth-scroll').on('click', function() {
			event.preventDefault();
			let sectionTo = $(this).attr('href');
			$('html, body').stop().animate({
			  scrollTop: $(sectionTo).offset().top}, 1500, 'easeInOutExpo');
		});
   } else {
		$('.smooth-scroll').on('click', function() {
			event.preventDefault();
			let sectionTo = $(this).attr('href');
			$('html, body').stop().animate({
			  scrollTop: $(sectionTo).offset().top - 50}, 1500, 'easeInOutExpo');
		});
	}

	/*------------------------------------
		Mobile Menu
	-------------------------------------- */
	$('.navbar-toggler').on('click', function() {
		$(this).toggleClass('show');
	});
	$(".navbar-nav a").on('click', function() {
		$(".navbar-collapse, .navbar-toggler").removeClass("show");
	});

	/*---------------------------------
	   Carousel (Owl Carousel)
	----------------------------------- */
	$(".owl-carousel").each(function (index) {
		let a = $(this);
		$(this).owlCarousel({
			autoplay: a.data('autoplay'),
			center: a.data('center'),
			autoplayTimeout: a.data('autoplaytimeout'),
			autoplayHoverPause: a.data('autoplayhoverpause'),
			loop: a.data('loop'),
			speed: a.data('speed'),
			nav: a.data('nav'),
			dots: a.data('dots'),
			autoHeight: a.data('autoheight'),
			autoWidth: a.data('autowidth'),
			margin: a.data('margin'),
			stagePadding: a.data('stagepadding'),
			slideBy: a.data('slideby'),
			lazyLoad: a.data('lazyload'),
			navText:['<i class="fa fa-chevron-left"></i>', '<i class="fa fa-chevron-right"></i>'],
			animateOut: a.data('animateout'),
			animateIn: a.data('animatein'),
			video: a.data('video'),
			items: a.data('items'),
			responsive:{
			0:{items: a.data('items-xs'),},
			576:{items: a.data('items-sm'),},
			768:{items: a.data('items-md'),},
			992:{items: a.data('items-lg'),}
			}
		});
	});

	/*------------------------------------
		Parallax Background
	-------------------------------------- */
	$(".parallax").each(function () {
		$(this).parallaxie({
			speed: 0.5,
		});
	});

	/*------------------------------------
		Typed
	-------------------------------------- */
	$(".typed").each(function() {
		let typed = new Typed('.typed', {
			strings: ['^300 Fullstack', '^500 Backend', '^500 Frontend'],
			loop: true,
			typeSpeed: 100,
			backSpeed: 80,
			backDelay: 2000,
		});
	});

	/*------------------------------------
		AOS animation
	-------------------------------------- */
	$(window).on('load', function () {
		AOS.init({
			disable: 'mobile',
			duration: 800,
			once: true,
		});
	});

	/*------------------------
	   tooltips
	-------------------------- */
	let tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
	let tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
	  return new bootstrap.Tooltip(tooltipTriggerEl)
	})

	/*------------------------
	   Scroll to top
	-------------------------- */
	$(function () {
		$(window).on('scroll', function(){
			if ($(this).scrollTop() > 400) {
				$('#back-to-top').fadeIn();
			} else {
				$('#back-to-top').fadeOut();
			}
		});
	});
	$('#back-to-top').on("click", function() {
		$('html, body').animate({scrollTop:0}, 'slow');
		return false;
	});

	/*------------------------------------
		Portfolio load more
	-------------------------------------- */
	$(".js-portfolio-item").slice(0, 4).show();
	$(".js-load-more").on('click', function (e) {
        e.preventDefault();
        $(".js-portfolio-item:hidden").slice(0, 2).slideDown();
        if ($(".js-portfolio-item:hidden").length == 0) {
            $(".js-load-more").fadeOut('slow');
        }
    });

	/*------------------------
	   Contact Form
	-------------------------- */
	let form = $('#contact-form'); // contact form
	let submit = $('#submit-btn'); // submit button
	form.on('submit', function (e) {
		e.preventDefault();
		$.ajax({
			url: 'php/mail.php',
			type: 'POST',
			dataType: 'json',
			data: form.serialize(),
			beforeSend: function () {
				submit.attr("disabled", "disabled");
				let loadingText = '<span role="status" aria-hidden="true" class="spinner-border spinner-border-sm align-self-center me-2"></span>Sending.....';
				if (submit.html() !== loadingText) {
					submit.data('original-text', submit.html());
					submit.html(loadingText);
				}
			},
			success: function (data) {
				submit.before(data.Message).fadeIn("slow");
				submit.html(submit.data('original-text'));
				submit.removeAttr("disabled", "disabled");
				if (data.response == 'success') {
					form.trigger('reset'); // reset form
				}
				setTimeout(function () {
					$('.alert-dismissible').fadeOut('slow', function(){
						$(this).remove();
					});
				}, 3500);
			},
			error: function (e) {
				console.log(e.responseText)
			}
		});
	});

})(jQuery)