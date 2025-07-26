<?php

/**
 * albor functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package albor
 */

if (! defined('ALBOR_VERSION')) {
	/*
	 * Set the theme’s version number.
	 *
	 * This is used primarily for cache busting. If you use `npm run bundle`
	 * to create your production build, the value below will be replaced in the
	 * generated zip file with a timestamp, converted to base 36.
	 */
	define('ALBOR_VERSION', '0.1.0');
}

if (! defined('ALBOR_TYPOGRAPHY_CLASSES')) {
	/*
	 * Set Tailwind Typography classes for the front end, block editor and
	 * classic editor using the constant below.
	 *
	 * For the front end, these classes are added by the `albor_content_class`
	 * function. You will see that function used everywhere an `entry-content`
	 * or `page-content` class has been added to a wrapper element.
	 *
	 * For the block editor, these classes are converted to a JavaScript array
	 * and then used by the `./javascript/block-editor.js` file, which adds
	 * them to the appropriate elements in the block editor (and adds them
	 * again when they’re removed.)
	 *
	 * For the classic editor (and anything using TinyMCE, like Advanced Custom
	 * Fields), these classes are added to TinyMCE’s body class when it
	 * initializes.
	 */
	define(
		'ALBOR_TYPOGRAPHY_CLASSES',
		'prose prose-neutral max-w-none prose-a:text-primary'
	);
}

if (! function_exists('albor_setup')) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function albor_setup()
	{
		/*
		 * Make theme available for translation.
		 * Translations can be filed in the /languages/ directory.
		 * If you're building a theme based on albor, use a find and replace
		 * to change 'albor' to the name of your theme in all the template files.
		 */
		load_theme_textdomain('albor', get_template_directory() . '/languages');

		// Add default posts and comments RSS feed links to head.
		add_theme_support('automatic-feed-links');

		/*
		 * Let WordPress manage the document title.
		 * By adding theme support, we declare that this theme does not use a
		 * hard-coded <title> tag in the document head, and expect WordPress to
		 * provide it for us.
		 */
		add_theme_support('title-tag');

		/*
		 * Enable support for Post Thumbnails on posts and pages.
		 *
		 * @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		 */
		add_theme_support('post-thumbnails');

		// This theme uses wp_nav_menu() in two locations.
		register_nav_menus(
			array(
				'menu-1' => __('Primary', 'albor'),
				'menu-2' => __('Footer Menu', 'albor'),
			)
		);

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support(
			'html5',
			array(
				'search-form',
				'comment-form',
				'comment-list',
				'gallery',
				'caption',
				'style',
				'script',
			)
		);

		// Add theme support for selective refresh for widgets.
		add_theme_support('customize-selective-refresh-widgets');

		// Add support for editor styles.
		add_theme_support('editor-styles');

		// Enqueue editor styles.
		add_editor_style('style-editor.css');
		add_editor_style('style-editor-extra.css');

		// Add support for responsive embedded content.
		add_theme_support('responsive-embeds');

		// Remove support for block templates.
		remove_theme_support('block-templates');
	}
endif;
add_action('after_setup_theme', 'albor_setup');

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function albor_widgets_init()
{
	register_sidebar(
		array(
			'name'          => __('Footer', 'albor'),
			'id'            => 'sidebar-1',
			'description'   => __('Add widgets here to appear in your footer.', 'albor'),
			'before_widget' => '<section id="%1$s" class="widget %2$s">',
			'after_widget'  => '</section>',
			'before_title'  => '<h2 class="widget-title">',
			'after_title'   => '</h2>',
		)
	);
}
add_action('widgets_init', 'albor_widgets_init');

/**
 * Enqueue scripts and styles.
 */
function albor_scripts()
{
	wp_enqueue_style('albor-style', get_stylesheet_uri(), array(), ALBOR_VERSION);
	wp_enqueue_script('albor-script', get_template_directory_uri() . '/js/script.min.js', array(), ALBOR_VERSION, true);

	if (is_singular() && comments_open() && get_option('thread_comments')) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'albor_scripts');

/**
 * Enqueue the block editor script.
 */
function albor_enqueue_block_editor_script()
{
	$current_screen = function_exists('get_current_screen') ? get_current_screen() : null;

	if (
		$current_screen &&
		$current_screen->is_block_editor() &&
		'widgets' !== $current_screen->id
	) {
		wp_enqueue_script(
			'albor-editor',
			get_template_directory_uri() . '/js/block-editor.min.js',
			array(
				'wp-blocks',
				'wp-edit-post',
			),
			ALBOR_VERSION,
			true
		);
		wp_add_inline_script('albor-editor', "tailwindTypographyClasses = '" . esc_attr(ALBOR_TYPOGRAPHY_CLASSES) . "'.split(' ');", 'before');
	}
}
add_action('enqueue_block_assets', 'albor_enqueue_block_editor_script');

/**
 * Add the Tailwind Typography classes to TinyMCE.
 *
 * @param array $settings TinyMCE settings.
 * @return array
 */
function albor_tinymce_add_class($settings)
{
	$settings['body_class'] = ALBOR_TYPOGRAPHY_CLASSES;
	return $settings;
}
add_filter('tiny_mce_before_init', 'albor_tinymce_add_class');

/**
 * Limit the block editor to heading levels supported by Tailwind Typography.
 *
 * @param array  $args Array of arguments for registering a block type.
 * @param string $block_type Block type name including namespace.
 * @return array
 */
function albor_modify_heading_levels($args, $block_type)
{
	if ('core/heading' !== $block_type) {
		return $args;
	}

	// Remove <h1>, <h5> and <h6>.
	$args['attributes']['levelOptions']['default'] = array(2, 3, 4);

	return $args;
}
add_filter('register_block_type_args', 'albor_modify_heading_levels', 10, 2);

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Functions which enhance the theme by hooking into WordPress.
 */
require get_template_directory() . '/inc/template-functions.php';

/**
 * Contact form.
 */
// add_shortcode('maileroo_contact', 'maileroo_contact_form');
// function maileroo_contact_form()
// {
// 	$html = '';

// 	// Verifica si se envió con éxito
// 	if (isset($_GET['form_status']) && $_GET['form_status'] === 'success') {
// 		$html .= '<p style="color:rgb(14, 227, 117);" class="font-medium my-5">¡Mensaje enviado correctamente!</p>';
// 	} elseif (isset($_GET['form_status']) && $_GET['form_status'] === 'error') {
// 		$html .= '<p style="color: #fee2e2;" class="font-medium my-5">Ocurrió un error al enviar el mensaje. Intenta nuevamente.</p>';
// 	}

// 	// Procesar formulario
// 	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['mcr_nonce'])) {
// 		if (!wp_verify_nonce($_POST['mcr_nonce'], 'mcr_form')) {
// 			$html .= '<p>Error de validación del formulario.</p>';
// 			return $html;
// 		}

// 		$name    = sanitize_text_field($_POST['mcr_name']);
// 		$email   = sanitize_email($_POST['mcr_email']);
// 		$message = sanitize_textarea_field($_POST['mcr_message']);
// 		$captcha = sanitize_text_field($_POST['mcr_captcha']);

// 		// Valida CAPTCHA simple
// 		// if ($captcha !== '7') {
// 		// 	$html .= '<p style="color: #fee2e2;" class="font-medium my-5">Respuesta incorrecta a la validación.</p>';
// 		// 	return $html;
// 		// }

// 		$admin_to = get_option('admin_email');
// 		$admin_subject = "Nuevo mensaje de contacto de $name";
// 		$admin_headers = ["From: $name <$email>", "Reply-To: $email"];
// 		$admin_body = "Nombre: $name\nEmail: $email\n\n$message";

// 		$user_subject = "Gracias por contactarme";
// 		$user_body = "Hola $name,\n\nGracias por tu mensaje. Lo he recibido y te responderé a la brevedad.\nImportante: Este formulario es solo una demostración para fines de portafolio.\n---\nTu mensaje:\n$message";
// 		$user_headers = ['From: ' . get_bloginfo('name') . ' <' . $admin_to . '>'];

// 		$admin_sent = wp_mail($admin_to, $admin_subject, $admin_body, $admin_headers);
// 		$user_sent  = wp_mail($email, $user_subject, $user_body, $user_headers);

// 		// Redirige con el resultado (PRG)
// 		$status = ($admin_sent && $user_sent) ? 'success' : 'error';
// 		wp_redirect(add_query_arg('form_status', $status, home_url('/')));
// 		exit;
// 	}

// 	// Formulario HTML
// 	$html .= '
// 	<form id="albor_contact_form" method="post" class="flex flex-col gap-10 w-full">
// 		' . wp_nonce_field('mcr_form', 'mcr_nonce', true, false) . '
// 		<div>
// 			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="text" name="mcr_name" placeholder="Nombre" required>
// 		</div>
// 		<div>
// 			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="email" name="mcr_email" placeholder="Email" required>
// 		</div>
// 		<div>
// 			<textarea class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" name="mcr_message" placeholder="Mensaje" required></textarea>
// 		</div>
// 		<div>
// 			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="text" name="mcr_captcha" placeholder="¿Cuánto es 3 + 4? (validación)" required>
// 			<span style="color:rgb(235, 15, 15);" class="font-medium" id="captcha_message"></span>
// 		</div>
// 		<div>
// 			<input type="submit" class="bg-[#fcfcf7] hover:bg-[#d6d6cf] transition duration-150 text-[#111111] text-[1.5rem] font-medium p-2 cursor-pointer" value="Enviar Mensaje">
// 		</div>
// 	</form>';

// 	return $html;
// }


add_shortcode('maileroo_contact', 'maileroo_contact_form');
function maileroo_contact_form()
{
	ob_start();
?>
	<form id="albor_contact_form" method="post" class="flex flex-col gap-10 w-full" action="<?php echo admin_url('admin-ajax.php'); ?>">
		<?php wp_nonce_field('mcr_ajax_form', 'mcr_nonce'); ?>
		<div>
			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="text" name="mcr_name" placeholder="Nombre" required>
		</div>
		<div>
			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="email" name="mcr_email" placeholder="Email" required>
		</div>
		<div>
			<textarea class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" name="mcr_message" placeholder="Mensaje" required></textarea>
		</div>
		<div>
			<input class="w-full border-b border-[#d6d6cf] p-2 text-[1.5rem] text-[#d6d6cf]" type="text" name="mcr_captcha" placeholder="¿Cuánto es 3 + 4? (validación)" required>
			<span style="color:rgb(235, 15, 15);" class="font-medium" id="captcha_message"></span>
		</div>
		<div class="flex items-center gap-3">
			<input type="submit" class="bg-[#fcfcf7] hover:bg-[#d6d6cf] transition duration-150 text-[#111111] text-[1.5rem] font-medium p-2 cursor-pointer" value="Enviar Mensaje">
			<span id="loading_icon_form" style="display:none;"><span class="loader-form"></span></span>
		</div>
	</form>
	<div id="albor_form_response" class="my-3 text-[1rem] font-medium"></div>
<?php
	return ob_get_clean();
}
add_action('wp_ajax_maileroo_send_form', 'maileroo_handle_form');
add_action('wp_ajax_nopriv_maileroo_send_form', 'maileroo_handle_form');

function maileroo_handle_form()
{
	if (!isset($_POST['mcr_nonce']) || !wp_verify_nonce($_POST['mcr_nonce'], 'mcr_ajax_form')) {
		wp_send_json_error('Error de validación.');
	}

	$name    = sanitize_text_field($_POST['mcr_name']);
	$email   = sanitize_email($_POST['mcr_email']);
	$message = sanitize_textarea_field($_POST['mcr_message']);
	$captcha = sanitize_text_field($_POST['mcr_captcha']);

	if ($captcha !== '7') {
		wp_send_json_error('Respuesta incorrecta a la validación.');
	}

	$admin_to = get_option('admin_email');
	$admin_subject = "Nuevo mensaje de contacto de $name";
	$admin_headers = ["From: $name <$email>", "Reply-To: $email"];
	$admin_body = "Nombre: $name\nEmail: $email\n\n$message";

	$user_subject = "Gracias por contactarme";
	$user_body = "Hola $name,\n\nGracias por tu mensaje. Lo he recibido y te responderé a la brevedad.\nImportante: Este formulario es solo una demostración para fines de portafolio.\n---\nTu mensaje:\n$message";
	$user_headers = ['From: ' . get_bloginfo('name') . ' <' . $admin_to . '>'];

	$admin_sent = wp_mail($admin_to, $admin_subject, $admin_body, $admin_headers);
	$user_sent  = wp_mail($email, $user_subject, $user_body, $user_headers);

	if ($admin_sent && $user_sent) {
		wp_send_json_success('¡Mensaje enviado correctamente!');
	} else {
		wp_send_json_error('Error al enviar el mensaje. Intenta nuevamente.');
	}
}

/**
 * Social links
 */
function albor_iconoir_social_links_shortcode($atts)
{
	$atts = shortcode_atts([
		'instagram' => '#',
		'behance'   => '#',
		'linkedin'  => '#',
		'class'     => 'flex gap-4 items-center',
	], $atts);

	$icons = [
		'instagram' => '<i class="iconoir-instagram"></i>',
		'behance'   => '<i class="iconoir-behance-tag"></i>',
		'linkedin'  => '<i class="iconoir-linkedin"></i>',
	];

	$html = '<div class="' . esc_attr($atts['class']) . '">';
	foreach (['instagram', 'behance', 'linkedin'] as $network) {
		$html .= '<a href="' . esc_url($atts[$network]) . '" class="text-[2.5rem]" rel="noopener noreferrer" aria-label="' . $network . '">'
			. $icons[$network] . '</a>';
	}
	$html .= '</div>';

	return $html;
}
add_shortcode('albor_social', 'albor_iconoir_social_links_shortcode');

/**
 * Assets.
 */
include get_template_directory() . '/assets/assets.php';
