/* Loader
================================= */
window.addEventListener('load', () => {
	const loader = document.getElementById('albor_loader');
	if (!loader) return;

	loader.classList.add('opacity-0', 'pointer-events-none');

	setTimeout(() => {
		loader.remove();
	}, 700);
});

/* Screenmode
================================= */
const currentAlborScreenMode = localStorage.getItem(
	'albor-current-screen-mode'
);
let alborScreenMode = document.getElementById('albor_body_theme');
let lightMode = document.getElementById('albor_light_mode');
let darkMode = document.getElementById('albor_dark_mode');

if (currentAlborScreenMode === 'dark') {
	alborScreenMode.classList.add('albor-dark-mode');
} else {
	alborScreenMode.classList.add('albor-light-mode');
}

lightMode.addEventListener('click', () => {
	alborScreenMode.classList.remove('albor-dark-mode');
	alborScreenMode.classList.add('albor-light-mode');
	localStorage.setItem('albor-current-screen-mode', 'light');
	lightMode.classList.add('font-medium');
	darkMode.classList.remove('font-medium');
});

darkMode.addEventListener('click', () => {
	alborScreenMode.classList.remove('albor-light-mode');
	alborScreenMode.classList.add('albor-dark-mode');
	localStorage.setItem('albor-current-screen-mode', 'dark');
	lightMode.classList.remove('font-medium');
	darkMode.classList.add('font-medium');
});

/* Masonry gallery
================================= */
FlexMasonry.init('.albor-masonry-gallery', {
	responsive: true,
	breakpointCols: {
		'min-width: 1200px': 3,
		'min-width: 992px': 2,
		'min-width: 768px': 2,
	},
});

document.addEventListener('DOMContentLoaded', () => {
	const form = document.getElementById('albor_contact_form');
	const responseBox = document.getElementById('albor_form_response');
	const alborSubmitInput = form.querySelector('input[type="submit"]');
	const captcha = form.querySelector('input[name="mcr_captcha"]');
	const captchaMessage = document.getElementById('captcha_message');
	const loaderForm = document.getElementById("loading_icon_form");

	if (!form) return;

	form.addEventListener('submit', async (e) => {
		e.preventDefault();

		if (captcha.value.trim() !== '7') {
			captchaMessage.textContent = 'Respuesta incorrecta.';
			return;
		}

		captchaMessage.textContent = '';
		alborSubmitInput.disabled = true;
		alborSubmitInput.value = 'Enviando Mensaje';
		loaderForm.style.display = "block";

		const formData = new FormData(form);
		formData.append('action', 'maileroo_send_form');

		try {
			const res = await fetch(form.action, {
				method: 'POST',
				body: formData,
			});
			const result = await res.json();

			if (result.success) {
				responseBox.textContent = result.data;
				responseBox.style.color = '#00b300';
				form.reset();
			} else {
				responseBox.textContent = result.data || 'Ocurrió un error.';
				responseBox.style.color = '#fee2e2';
			}
		} catch (error) {
			responseBox.textContent = 'Error de red. Intenta más tarde.';
			responseBox.style.color = '#fee2e2';
		} finally {
			alborSubmitInput.disabled = false;
			alborSubmitInput.value = 'Enviar Mensaje';
			loaderForm.style.display = "none";
			responseBox.scrollIntoView({ behavior: 'smooth' });
		}
	});
});
