// Form Validation
function valForm(data) {

    let form = document.getElementById(data.id);

    if (!form) {
        console.error(`Form with ID ${data.id} not found.`);
        return false;
    }

    let isValid = true;

    // validation patterns
    const valEmail = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
    const valPhone = /^\+?[0-9\s\-()]{5,20}$/;

    // Helper function to add error feedback
    const addError = (field, message) => {
        field.classList.add('is-invalid');
        let feedback = field.parentElement.querySelector('.invalid-feedback');
        if (!feedback) {
            const errorMsg = document.createElement('div');
            errorMsg.className = 'invalid-feedback';
            errorMsg.innerHTML = message;
            field.parentElement.appendChild(errorMsg);
        }
    };

    // Helper function to remove error feedback
    const removeError = (field) => {
        field.classList.remove('is-invalid');
        const feedback = field.parentElement.querySelector('.invalid-feedback');
        if (feedback) feedback.remove();
    };

    // Check if fields are provided
    if (!data.fields || data.fields.length === 0) {
        console.error("No fields provided for validation.");
        return false;
    }

    // Fields validation
    data.fields.forEach(fieldData => {
        const {
            id: fieldId,
            required,
            required_message: requiredMessage = '',
            required_filter: filter,
            required_filter_message: filterMessage = ''
        } = fieldData;

        const field = form.querySelector(`[name="${fieldId}"]`);

        if (required) {
            if (field.value.trim() === '') {
                addError(field, requiredMessage);
                isValid = false;
            } else if (filter === 'phone' && (!valPhone.test(field.value) || field.value.length < 5)) {
                removeError(field);
                addError(field, filterMessage);
                isValid = false;
            } else if (filter === 'email' && !valEmail.test(field.value)) {
                removeError(field);
                addError(field, filterMessage);
                isValid = false;
            } else {
                removeError(field);
            }
        }
    });

    // Validate reCAPTCHA v2
    if (data.captcha.enabled && data.captcha.version === 2) {
        if (typeof grecaptcha !== 'undefined') {
            var response = grecaptcha.getResponse();
            var captchaElement = form.querySelector('.captcha');

            if (response.length === 0) {
                captchaElement.classList.add('is-invalid');

                if (!captchaElement.querySelector('.invalid-feedback')) {
                    var errorMsg = document.createElement('div');
                    errorMsg.className = 'invalid-feedback';
                    errorMsg.innerText = data.captcha.message;
                    captchaElement.appendChild(errorMsg);
                }

                isValid = false;
            } else {
                captchaElement.classList.remove('is-invalid');

                var errorFeedback = captchaElement.querySelector('.invalid-feedback');
                if (errorFeedback) {
                    errorFeedback.remove();
                }
            }
        } else {
            console.error("reCAPTCHA script not loaded.");
            return false;
        }
    }

    return isValid;
}


// Form
function contactForm(data){

	var isSubmitting = false;
	var form = $('form[id="'+data.id+'"]');

	// Captcha 3.0
	if (data.captcha.enabled) {
		grecaptcha.ready(() => {
			grecaptcha.execute(data.captcha.public, { action: 'submit' }).then((token) => {
				form.find('[name="g-recaptcha-response"]').val(token);
			});
		});
	}

	// Form submit
	form.submit(function(e){
		e.preventDefault();

		// Check if a submission is already in progress
		if(isSubmitting) {
			return;
		}

		if(valForm(data)){
			//const formData = new FormData(form[0]);
			const formData = new FormData(this);
			const submitButton = form.find('button[type="submit"]');
			submitButton.addClass('btn-loading').text(data.sending);
			isSubmitting = true;

			$.ajax({
				type: 'POST',
				url: form.attr('action'),
				data: formData,
				cache: false,
				contentType: false,
				processData: false,
			}).done((response) => {
				if (data.file !== ''){
					window.open(data.file, '_blank');
				}

				if (data.redirect !== ''){
					window.location.href = data.redirect;
				}

				// Process form
				if (form.find('.text-success').length === 0){
					form.append('<div class="col-12 mt-3 text-center text-success">'+ data.thanks +'</div>');
				}

				// Remove values
				form.find('.form-control, .form-select').val('');
				form.find('.files').html('');

			}).fail(() => {
				form.find('.text-success').remove();

			}).always(() => {
				submitButton.removeClass('btn-loading').html(data.submit);
				isSubmitting = false;

				// Reload captcha after submission
				if (data.captcha.enabled) {
					grecaptcha.ready(() => {
						grecaptcha.execute(data.captcha.public, { action: 'submit' })
						.then((token) => {
							form.find('[name="g-recaptcha-response"]').val(token);
						});
					});
				}
			});

		} else {
			const firstInvalid = $('.invalid-feedback:first');

			if (firstInvalid.length){
				$('html, body').stop().animate({ 'scrollTop': firstInvalid.offset().top - 200 }, 900);
			}
		}
	});

	// Files
	form.find('.input-file-group input').change(function() {
		let files = [];
		$.each(this.files, (index, file) => {
			files.push(`<span>${file.name}</span>`);
		});
		$(this).next('.files').html(files.join(''));
	});
}

// Fixed header
function initFixedHeader() {
    const body = document.body;
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            body.classList.add('header-fixed');
        } else {
            body.classList.remove('header-fixed');
        }
    });
}

// Open menu
function initMenuOpen() {
	const menuHeader = document.querySelectorAll('[data-open="menu"]');
	const menu = document.querySelector('.menu'); 

	menuHeader.forEach((menuButton) => {
		menuButton.addEventListener('click', function (e) {
			e.preventDefault();
			this.classList.toggle('active');

			const header = this.closest('.header');
			if (header) {
				header.classList.toggle('active');
			}

			const navigation = header.querySelector('.navigation');
			if (navigation) {
				navigation.classList.toggle('active');
			}

			// if Lenis
			if (typeof lenis !== 'undefined') {
				this.classList.contains('active') ? lenis.stop() : lenis.start();
			}
		});
	});

	// Submenus using event delegation
	document.addEventListener('click', function (e) {
		if (window.innerWidth <= 768) {

			const submenuLink = e.target.closest('.menu > li.menu-item-has-children > a');

			if (submenuLink) {
				e.preventDefault(); 
				
				const parentLi = submenuLink.parentElement;

				//
				menu.querySelectorAll('li.open-submenu').forEach((li) => {
					if (li !== parentLi) {
						li.classList.remove('open-submenu');
					}
				});

				// 
				parentLi.classList.toggle('open-submenu');
			}
		}
	});
}

// Sliders
function initSliders(){

	// Presentation
	const presentationSlider = new Swiper('.presentation .swiper', {
	    slidesPerView: 1,
	    loop: true,
	    effect: "fade",
	    autoplay: false,
	    /*autoplay: {
	        delay: 5500,
	        disableOnInteraction: false,
	    },*/
	    navigation: {
	        nextEl: '.swiper-button-next',
	        prevEl: '.swiper-button-prev',
	    },   
	     pagination: {
	        el: ".swiper-pagination",
	        clickable: true,
	    }	
	});


	// Testimonial
	const testimonialsSlider = new Swiper('.testimonial .swiper', {
	    speed: 3000, 
	    slidesPerView: 1, 
	    loop: true, 	 
	    spaceBetween: 12, 
	     navigation: {
	        nextEl: '.swiper-button-next',
	        prevEl: '.swiper-button-prev',
	    },  
	    breakpoints: {
	       
	        992: {
	            slidesPerView: 3, 
	            spaceBetween: 24, 
	        },
	    }
	});
	
}


// Number grow in stats
function initAnimationStats() {
    document.addEventListener('scroll', () => {
        document.querySelectorAll('.module-stats:not([data-animated])').forEach(stats => {
            if (window.scrollY > stats.offsetTop - stats.offsetHeight * 2) {
                stats.dataset.animated = "true";
                stats.querySelectorAll('.counter').forEach(counter => {
                    let target = +counter.dataset.number, start = 0, duration = 2000, startTime;
                    function animate(timestamp) {
                        startTime ??= timestamp;
                        let progress = Math.min((timestamp - startTime) / duration, 1);
                        counter.innerText = Math.ceil(progress * target);
                        if (progress < 1) requestAnimationFrame(animate);
                    }
                    requestAnimationFrame(animate);
                });
            }
        });
    });
}



// Modal Video
function initModalVideo(){

	document.querySelectorAll('.video-player.allowed').forEach((player) => {
		player.addEventListener('click', function (e){
			e.preventDefault();

			this.classList.add('active');

			let id = this.getAttribute('data-id');
			let type = this.getAttribute('data-type');

			const playerContainer = document.querySelector('#modalVideo .player');
			playerContainer.innerHTML = '';

			if (type === 'youtube'){
				playerContainer.innerHTML = `<iframe width="560" height="315" src="https://www.youtube.com/embed/${id}?autoplay=1" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>`;
			} else if (type === 'vimeo'){
				playerContainer.innerHTML = `<iframe src="https://player.vimeo.com/video/${id}?h=39c25e44a1&color=be9926&title=0&byline=0&portrait=0" width="640" height="360" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>`;
			} else {
				playerContainer.innerHTML = `<video controls playsinline loop><source src="${id}" type="video/mp4"></video>`;
			}

			let modal = new bootstrap.Modal(document.getElementById('modalVideo'));
			modal.show();
		});
	});

	const modalElement = document.getElementById('modalVideo');
	if (modalElement) {
		modalElement.addEventListener('hidden.bs.modal', function(){
			document.querySelectorAll('.video-player').forEach((player) => {
				player.classList.remove('active');
			});
			document.querySelector('#modalVideo .player').innerHTML = '';
		});
	}
}

// Filter
function initPagination(){
	// Pagination
	$('.pagination a').click(function(e){
		e.preventDefault();

		var url = $(this).attr('href');
		if (url.indexOf("?") != -1) {
			paged = url.match(/paged=([0-9]+)/)[1];
		} else {
			paged = 1;
		}

		$('.filter [name="paged"]').val(paged);
		$('.filter').submit();
	});	
}

var filters = {};

function concatValues(obj){
	var value = '';
	for (var prop in obj) {
		value += obj[prop];
	}
	return value;
}


function initFilter(){

	// Isotope
	var $grid = $('.items').isotope({
	  itemSelector: '.item',
	  layoutMode: 'fitRows'
	});

	$('.filter-group a').on( 'click', function(e){
		e.preventDefault();

		var $this = $(this);
		var $buttonGroup = $this.parents('.filter-group');
		var filterGroup = $buttonGroup.attr('data-filter-group');
		filters[filterGroup] = $this.attr('data-filter');
		var filterValue = concatValues(filters);

		$('.filter-group[data-filter-group="'+ filterGroup +'"] li a').removeClass('active');
		$(this).addClass('active');

		$grid.isotope({ filter: filterValue });
	});
}

// Share
function initSharePopup(){
	const shareLinks = document.querySelectorAll('.share ul a');

	// Add click event listener to each link
	shareLinks.forEach(link => {
		link.addEventListener('click', function(e) {
			e.preventDefault();

			const href = this.getAttribute('href');
			const windowHeight = window.innerHeight;
			const windowWidth = window.innerWidth;
			const top = windowHeight / 2 - 275;
			const left = windowWidth / 2 - 225;

			window.open(href, 'fbShareWindow',
				`height=450, width=550, top=${top}, left=${left}, toolbar=0, location=0, menubar=0, directories=0, scrollbars=0`
			);

			return false;
		});
	});
}

function initShowPassword(){
	const showPasswordButtons = document.querySelectorAll('.show_password');

	showPasswordButtons.forEach(button => {
		button.addEventListener('click', function (e) {
			e.preventDefault();

			const input = this.parentElement.querySelector('input');

			if (input.type === 'password') {
				input.type = 'text';
				this.classList.add('active');
			} else {
				input.type = 'password';
				this.classList.remove('active');
			}
		});
	});
}

// Loader
function initLoader(){
	const loading = document.getElementById("pageloader");

	document.querySelectorAll("a").forEach(link => {
		link.addEventListener("click", function (e) {
			if (this.target === "_blank" ||
				this.classList.contains("noloading") ||
				this.getAttribute("href") === "#"){

				return;
			}

			e.preventDefault();
			loading.classList.add("show");
			setTimeout(() => (window.location.href = this.href), 500);
		});
	});

	window.addEventListener("load", () => loading.classList.remove("show"));
}


function parallaxBackground() {
    let scrollTop = window.scrollY;

    document.querySelectorAll(".banner").forEach(el => {
        el.style.backgroundPosition = `center calc(100% + ${scrollTop * 0.4}px)`;
    });
}


async function initMap() {
    const mapArea = document.querySelector('.maparea');
    if (!mapArea) return;

    const markers = document.querySelectorAll('.marker');
    if (!markers.length) return;

    const firstMarker = markers[0];
    const initialLat = parseFloat(firstMarker.getAttribute('data-lat'));
    const initialLng = parseFloat(firstMarker.getAttribute('data-lng'));

    // Import the Maps library
    const { Map } = await google.maps.importLibrary("maps");

    // Create map options
    const mapOptions = {
        zoom: 12,
        center: { lat: initialLat, lng: initialLng },
        mapTypeId: 'roadmap',
        styles: [
            { featureType: "water", elementType: "geometry.fill", stylers: [{ color: "#d3d3d3" }] },
            { featureType: "transit", stylers: [{ color: "#808080" }, { visibility: "off" }] },
            { featureType: "road.highway", elementType: "geometry.stroke", stylers: [{ visibility: "on" }, { color: "#b3b3b3" }] },
            { featureType: "road.highway", elementType: "geometry.fill", stylers: [{ color: "#ffffff" }] },
            { featureType: "road.local", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#ffffff" }, { weight: 1.8 }] },
            { featureType: "road.local", elementType: "geometry.stroke", stylers: [{ color: "#d7d7d7" }] },
            { featureType: "poi", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#ebebeb" }] },
            { featureType: "administrative", elementType: "geometry", stylers: [{ color: "#a7a7a7" }] },
            { featureType: "road.arterial", elementType: "geometry.fill", stylers: [{ color: "#ffffff" }] },
            { featureType: "landscape", elementType: "geometry.fill", stylers: [{ visibility: "on" }, { color: "#efefef" }] },
            { featureType: "road", elementType: "labels.text.fill", stylers: [{ color: "#696969" }] },
            { featureType: "administrative", elementType: "labels.text.fill", stylers: [{ visibility: "on" }, { color: "#737373" }] },
            { featureType: "poi", elementType: "labels.icon", stylers: [{ visibility: "off" }] },
            { featureType: "poi", elementType: "labels", stylers: [{ visibility: "off" }] },
            { featureType: "road.arterial", elementType: "geometry.stroke", stylers: [{ color: "#d6d6d6" }] },
            { featureType: "road", elementType: "labels.icon", stylers: [{ visibility: "off" }] },
            { featureType: "poi", elementType: "geometry.fill", stylers: [{ color: "#dadada" }] }
        ],
    };

    // Initialize the map
    const map = new Map(mapArea, mapOptions);
    map.markers = [];

    // Add markers to the map
    markers.forEach(markerEl => addStandardMarker(markerEl, map));
    centerMap(map);
}

function addStandardMarker(markerEl, map) {
    const lat = parseFloat(markerEl.getAttribute('data-lat'));
    const lng = parseFloat(markerEl.getAttribute('data-lng'));
    const markerIcon = markerEl.getAttribute('data-marker');

    // Create a standard marker
    const marker = new google.maps.Marker({
        position: { lat, lng },
        map,
        icon: markerIcon, // Set custom icon
    });

    map.markers.push(marker);

    // Add an info window if content is present inside the marker element
    if (markerEl.innerHTML.trim()) {
        const infowindow = new google.maps.InfoWindow({ content: markerEl.innerHTML });
        marker.addListener('click', () => infowindow.open(map, marker));
    }
}

function centerMap(map) {
    const bounds = new google.maps.LatLngBounds();
    map.markers.forEach(marker => bounds.extend(marker.getPosition()));
    if (map.markers.length === 1) {
        map.setCenter(bounds.getCenter());
        map.setZoom(15);
    } else {
        map.fitBounds(bounds);
    }
}

document.addEventListener("DOMContentLoaded", function() {
    try {
        // Initialize WOW.js for scroll animations
        new WOW().init();

        parallaxBackground(); 
    	window.addEventListener("scroll", parallaxBackground);


        initFixedHeader();
        initMenuOpen();
        initSliders();
        // initLoader(); // Uncomment this line if you have a loader initialization function
        initModalVideo();
        initAnimationStats();
        //initSharePopup();
        initShowPassword();
    } catch (error) {
        console.error('Error during initialization: ', error);
    }
});
