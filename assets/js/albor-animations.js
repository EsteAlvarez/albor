gsap.registerPlugin(SplitText);
gsap.registerPlugin(ScrollTrigger);

/* Biography animation
================================= */
let biographyText = document.getElementById('albor_biography');
let split = SplitText.create(biographyText, {
	type: 'words',
});

gsap.from(split.words, {
	autoAlpha: 0,
	stagger: 0.04,
	ease: 'power2.out',
});

gsap.utils.toArray('.animated-img').forEach((img) => {
	gsap.from(img, {
		scrollTrigger: {
			trigger: img,
			start: 'top 80%',
		},
		opacity: 0,
		y: 50,
		duration: 1.2,
		ease: 'power2.out',
	});
});
