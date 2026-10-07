document.addEventListener("DOMContentLoaded", function(){
	gsap.registerPlugin(ScrollTrigger);

	//initLoader();
	initFades();
	initLenis();
	initFooter()
	//initCursor();
	initParallax();
});


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

// Lenis
function initLenis() {
	const lenis = new Lenis();

	function raf(time) {
		lenis.raf(time);
		requestAnimationFrame(raf);
	}
	requestAnimationFrame(raf);

	// Close menu One Page
	document.querySelectorAll('.navigation .menu li a, a[href^="#"]').forEach(function(anchor) {
		const href = anchor.getAttribute('href');

		anchor.addEventListener('click', function(e) {
			e.preventDefault();
			const target = this.getAttribute('href');

			document.querySelectorAll('.header, .nav-menu, .navigation').forEach(function(el) {
				el.classList.remove('active');
			});

			// Smooth scroll
			setTimeout(function() {
				lenis.start();
				lenis.scrollTo(target);
			}, 300);
		});
	});
}


function initCursor(){
    new MouseFollower({
        showTimeout: 0,
        hideTimeout: 300,
        hideMediaTimeout: 300,
        speed: .6,
        skewing: 0,
        skewingText: .75,
        skewingMedia: 1.5,
        skewingDelta: .0015,
        skewingDeltaMax: .15,
        stickDelta: .3,
        ease: Expo.easeOut
    })
}

function initFades(){
	const fadeAnimations = [
		{ selector: '.fadeIn', props: { opacity: 0 } },
		{ selector: '.fadeInLeft', props: { xPercent: -10, opacity: 0 } },
		{ selector: '.fadeInRight', props: { xPercent: 10, opacity: 0 } },
		{ selector: '.fadeInUp', props: { y: 50, opacity: 0 } },
		{ selector: '.fadeInDown', props: { y: -50, opacity: 0 } }
	];

	fadeAnimations.forEach(animation => {
		gsap.utils.toArray(animation.selector).forEach(element => {
			const delay = parseFloat(element.getAttribute('data-wow-delay')) || 0;
			gsap.from(element, {
				...animation.props,
				duration: 1,
				delay: delay,
				scrollTrigger: {
					trigger: element,
					start: 'top 80%',
					end: 'bottom 20%',
					toggleActions: 'play none none reverse'
				}
			});
		});
	});
}


function initParallax() {
	// Hide mobile
	const isMobile = window.innerWidth < 768;
	if (isMobile) return;

	const parallaxAnimations = [
		{ selector: '.parallax-img', props: { yPercent: [-20, 20] } },
		{ selector: '.parallax-img-up', props: { yPercent: [-20, 20] } },
		{ selector: '.parallax-img-left', props: { xPercent: [-5, 5], scale: [1.3, 1] } }
	];

	parallaxAnimations.forEach(animation => {
		gsap.utils.toArray(animation.selector).forEach(container => {
			const img = container.querySelector('img');
			// Check if the img exists and avoid running the animation if it's null
			if (!img) return;

			// Safely access the properties or fall back to default values
			const yPercentStart = animation.props.yPercent ? animation.props.yPercent[0] : 0;
			const yPercentEnd = animation.props.yPercent ? animation.props.yPercent[1] : 0;
			const xPercentStart = animation.props.xPercent ? animation.props.xPercent[0] : 0;
			const xPercentEnd = animation.props.xPercent ? animation.props.xPercent[1] : 0;
			const scaleStart = animation.props.scale ? animation.props.scale[0] : 1;
			const scaleEnd = animation.props.scale ? animation.props.scale[1] : 1;

			gsap.fromTo(img, {
				ease: 'none',
				yPercent: yPercentStart,
				xPercent: xPercentStart,
				scale: scaleStart,
			}, {
				ease: 'none',
				yPercent: yPercentEnd,
				xPercent: xPercentEnd,
				scale: scaleEnd,
				scrollTrigger: {
					trigger: container,
					scrub: true,
					pin: false
				}
			});
		});
	});
}



function initFooter(){
	const footer = gsap.timeline({
	  scrollTrigger: {
	    trigger: ".footer",
	    start: "top bottom",
	    end: "bottom bottom",
	    //id: "footer",
	    scrub: true,
	    //markers: true
	  }
	});

	footer.from(".footer .widgets", {
	  y: -300,
	  willChange: "transform"
	});
}