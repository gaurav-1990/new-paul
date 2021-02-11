(function ($) {
"use strict";

/* meanmenu */
 

/* slider-active */
$('.slider-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})
/* sliders-active */
$('.sliders-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})


/* top-seller-active */
$('.top-seller-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:3
        },
        1000:{
            items:4
        },
        1400:{
            items:5
        }
    }
})

/* product-active */
$('.product-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:4
        }
    }
})

/* product1-active */
$('.product1-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:4
        },
        1200:{
            items:5
        }
    }
})

/* product-2-slider */
$('.product-2-slider').owlCarousel({
    loop:true,
    nav:true,
    margin:30,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        375:{
            items:2
        },
        480:{
            items:2
        },
        768:{
            items:2
        },
        1000:{
            items:3
        },
        1200:{
            items:4
        },
        1500:{
            items:5
        }
    }
})
$('#owl-example').owlCarousel({
    loop:true,
    nav:true,
    autoplay: true,
    margin:5,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        360:{
            items:2
        },
        375:{
            items:2
        },
        480:{
            items:2
        },
        768:{
            items:3
        },
        1024:{
            items:4
        },
        1200:{
            items:5
        },
        1500:{
            items:6
        }
    }
})
$('#owl-example2').owlCarousel({
    loop:true,
    nav:false,
    dots:true,
    autoplay: true,
    margin:10,
    
	
    responsive:{
        360:{
            items:1
        },
        375:{
            items:1
        },
        480:{
            items:1
        },
        768:{
            items:1
        },
        1024:{
            items:1
        },
        1200:{
            items:1
        },
        1500:{
            items:1
        }
    }
})







/* products-active */
$('.products-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        768:{
            items:2
        },
        1000:{
            items:2
        },
        1200:{
            items:3
        }
    }
})

/* testimonial-active */
$('.testimonial-active').owlCarousel({
    loop:true,
    nav:false,
	dots:true,
    responsive:{
        0:{
            items:1
        },
        767:{
            items:1
        },
        1000:{
            items:1
        }
    }
})

/* blog-active */
$('.blog-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:3
        }
    }
})
/* item-active */
$('.item-active').owlCarousel({
    loop:true,
    nav:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:1
        },
        767:{
            items:2
        },
        1000:{
            items:2
        }
    }
})

/* brand-active */
$('.brand-active').owlCarousel({
    loop:true,
    nav:true,
	dots:false,
	autoplay:true,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        0:{
            items:2
        },
        450:{
            items:3
        },
        767:{
            items:4
        },
        1000:{
            items:6
        }
    }
})

/* related-slider */ 
$('.related-slider').owlCarousel({
	loop:true,
	nav:true,
	margin:10,
	navText:['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
	responsive:{
		0:{
			items:1
		},
		768:{
			items:3
		},
		1000:{
			items:3
		},
		1200:{
			items:4
		}
	}
})	

/* details-tab */ 
$('.details-tab').owlCarousel({
	loop:true,
	nav:true,
	margin:10,
	navText:['<i class="fa fa-long-arrow-left"></i>','<i class="fa fa-long-arrow-right"></i>'],
	responsive:{
		0:{
			items:3
		},
		450:{
			items:3
		},
		767:{
			items:3
		},
		1000:{
			items:4
		}
	}
})	
 $('#home-proslider1').owlCarousel({
    loop:true,
    nav:true,
    autoplay: true,
    margin:10,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        360:{
            items:2
        },
        375:{
            items:2
        },
        480:{
            items:2
        },
        768:{
            items:3
        },
        1024:{
            items:4
        },
        1200:{
            items:6
        },
        1500:{
            items:6
        }
    }
})


 $('#inside-final').owlCarousel({
    loop:true,
    nav:true,
    autoplay: true,
    margin:10,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        320:{
            items:1
        },
        360:{
            items:1
        },
        375:{
            items:1
        },
        480:{
            items:1
        },
        768:{
            items:1
        },
        1024:{
            items:1
        },
        1200:{
            items:1
        },
        1500:{
            items:1
        }
    }
})

 $('#home-proslider2').owlCarousel({
    loop:true,
    nav:true,
    autoplay: true,
    margin:10,
	navText:['<i class="fa fa-chevron-left"></i>','<i class="fa fa-chevron-right"></i>'],
    responsive:{
        360:{
            items:2
        },
        375:{
            items:2
        },
        480:{
            items:2
        },
        768:{
            items:3
        },
        1024:{
            items:4
        },
        1200:{
            items:6
        },
        1500:{
            items:6
        }
    }
})
 

})(jQuery);	