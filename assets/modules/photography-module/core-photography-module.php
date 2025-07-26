<?php
/* Registro del custom post type 'fotografias' */

function fotografias_register()
{
    $labels = array(
        'name'                  => _x('Fotografías', 'post type general name'),
        'singular_name'         => _x('Fotografía', 'post type singular name'),
        'add_new'               => _x('Agregar', 'fotografia'),
        'add_new_item'          => __('Agregar Fotografía'),
        'edit_item'             => __('Editar Fotografía'),
        'new_item'              => __('Nueva Fotografía'),
        'view_item'             => __('Ver Fotografía'),
        'search_items'          => __('Buscar Fotografías'),
        'not_found'             => __('No se encontraron fotografías'),
        'not_found_in_trash'    => __('No se encontraron fotografías en la papelera'),
        'parent_item_colon'     => ''
    );

    $args = array(
        'labels'              => $labels,
        'public'              => true,
        'publicly_queryable'  => true,
        'show_ui'             => true,
        'query_var'           => true,
        'rewrite'             => array('slug' => 'fotografias'),
        'capability_type'     => 'post',
        'menu_icon'           => 'dashicons-format-image',
        'has_archive'         => true,
        'hierarchical'        => false,
        'menu_position'       => null,
        'taxonomies'          => array('categorias-fotografia', 'etiquetas-fotografia'),
        'supports'            => array('title', 'thumbnail', 'excerpt'),
        'exclude_from_search' => false
    );

    register_post_type('fotografias', $args);
}
add_action('init', 'fotografias_register');

// Agregar nonce para seguridad
add_action('add_meta_boxes', 'galeria_fotografias_metabox');
function galeria_fotografias_metabox()
{
    add_meta_box(
        'galeria_fotografias',
        'Galería de Imágenes',
        'galeria_fotografias_callback',
        'fotografias',
        'normal',
        'default'
    );
}

function galeria_fotografias_callback($post)
{
    // Agregar nonce field para seguridad
    wp_nonce_field('galeria_fotografias_nonce_action', 'galeria_fotografias_nonce');

    $galeria = get_post_meta($post->ID, '_galeria_fotografias', true);
?>
    <div>
        <a href="#" class="button add-gallery-images">Agregar Imágenes</a>
        <a href="#" class="button remove-all-images">Remover Todas</a>
        <ul class="gallery-preview">
            <?php if ($galeria && is_array($galeria)) :
                foreach ($galeria as $image_id) {
                    $image_url = wp_get_attachment_image_url($image_id, 'thumbnail');
                    if ($image_url) : ?>
                        <li data-id="<?php echo esc_attr($image_id); ?>">
                            <input type="hidden" name="galeria_fotografias[]" value="<?php echo esc_attr($image_id); ?>">
                            <img src="<?php echo esc_url($image_url); ?>" alt="<?php echo esc_attr(get_the_title($image_id)); ?>" />
                            <button type="button" class="remove-image">×</button>
                        </li>
            <?php endif;
                }
            endif; ?>
        </ul>
    </div>

    <style>
        .gallery-preview {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-top: 10px;
            list-style: none;
            padding: 0;
        }

        .gallery-preview li {
            position: relative;
            border: 2px solid #ddd;
            border-radius: 8px;
            padding: 5px;
            background: #f9f9f9;
        }

        .gallery-preview img {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 4px;
            display: block;
        }

        .gallery-preview .remove-image {
            position: absolute;
            top: -5px;
            right: -5px;
            background: #dc3232;
            color: white;
            border: none;
            border-radius: 50%;
            width: 20px;
            height: 20px;
            cursor: pointer;
            font-size: 12px;
            line-height: 1;
        }

        .gallery-preview .remove-image:hover {
            background: #a00;
        }

        .remove-all-images {
            margin-left: 10px;
        }
    </style>
<?php
}

add_action('save_post', 'guardar_galeria_fotografias');
function guardar_galeria_fotografias($post_id)
{
    // Verificaciones de seguridad mejoradas
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;

    // Verificar nonce
    if (
        !isset($_POST['galeria_fotografias_nonce']) ||
        !wp_verify_nonce($_POST['galeria_fotografias_nonce'], 'galeria_fotografias_nonce_action')
    ) {
        return;
    }

    // Verificar permisos
    if (!current_user_can('edit_post', $post_id)) return;

    // Verificar que es el post type correcto
    if (get_post_type($post_id) !== 'fotografias') return;

    if (isset($_POST['galeria_fotografias']) && is_array($_POST['galeria_fotografias'])) {
        // Sanitizar y validar IDs de imágenes
        $imagenes = array();
        foreach ($_POST['galeria_fotografias'] as $image_id) {
            $image_id = intval($image_id);
            // Verificar que el attachment existe y es una imagen
            if ($image_id > 0 && wp_attachment_is_image($image_id)) {
                $imagenes[] = $image_id;
            }
        }

        if (!empty($imagenes)) {
            update_post_meta($post_id, '_galeria_fotografias', $imagenes);
        } else {
            delete_post_meta($post_id, '_galeria_fotografias');
        }
    } else {
        delete_post_meta($post_id, '_galeria_fotografias');
    }
}

add_action('admin_enqueue_scripts', 'galeria_fotografias_scripts');
function galeria_fotografias_scripts($hook)
{
    global $post;

    // Verificar que estamos en la página correcta
    if ($hook !== 'post.php' && $hook !== 'post-new.php') return;
    if (!$post || $post->post_type !== 'fotografias') return;

    // Encolar scripts necesarios
    wp_enqueue_media();
    wp_enqueue_script('jquery');

    // Registrar script personalizado
    wp_add_inline_script('jquery', '
        jQuery(document).ready(function($) {
            console.log("Galería script cargado"); // Debug
            
            let frame;
            
            // Agregar imágenes
            $(document).on("click", ".add-gallery-images", function(e) {
                e.preventDefault();
                console.log("Botón agregar clickeado"); // Debug
                
                // Verificar si wp.media está disponible
                if (typeof wp === "undefined" || typeof wp.media === "undefined") {
                    alert("Error: WordPress Media Library no está disponible");
                    console.error("wp.media no está definido");
                    return;
                }
                
                if (frame) {
                    frame.open();
                    return;
                }
                
                frame = wp.media({
                    title: "Selecciona imágenes",
                    button: {
                        text: "Usar estas imágenes"
                    },
                    multiple: true,
                    library: {
                        type: "image"
                    }
                });

                frame.on("select", function() {
                    console.log("Imágenes seleccionadas"); // Debug
                    let selection = frame.state().get("selection");
                    
                    selection.map(function(attachment) {
                        attachment = attachment.toJSON();
                        console.log("Procesando imagen:", attachment.id); // Debug
                        
                        // Verificar si la imagen ya está en la galería
                        if ($(".gallery-preview").find("li[data-id=\"" + attachment.id + "\"]").length > 0) {
                            console.log("Imagen ya existe:", attachment.id);
                            return;
                        }
                        
                        let thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail ? 
                            attachment.sizes.thumbnail.url : attachment.url;
                        
                        let altText = attachment.alt || attachment.title || "";
                            
                        let imageHTML = "<li data-id=\"" + attachment.id + "\">" +
                            "<input type=\"hidden\" name=\"galeria_fotografias[]\" value=\"" + attachment.id + "\">" +
                            "<img src=\"" + thumbnailUrl + "\" alt=\"" + altText + "\" />" +
                            "<button type=\"button\" class=\"remove-image\">×</button>" +
                            "</li>";
                            
                        $(".gallery-preview").append(imageHTML);
                        console.log("Imagen agregada al DOM"); // Debug
                    });
                });

                frame.open();
            });
            
            // Remover imagen individual
            $(document).on("click", ".remove-image", function(e) {
                e.preventDefault();
                console.log("Removiendo imagen"); // Debug
                $(this).closest("li").remove();
            });
            
            // Remover todas las imágenes
            $(document).on("click", ".remove-all-images", function(e) {
                e.preventDefault();
                if (confirm("¿Estás seguro de que quieres remover todas las imágenes?")) {
                    $(".gallery-preview").empty();
                    console.log("Todas las imágenes removidas"); // Debug
                }
            });
            
            // Hacer la galería sorteable (opcional)
            if (typeof $.fn.sortable !== "undefined") {
                $(".gallery-preview").sortable({
                    items: "li",
                    cursor: "move",
                    update: function() {
                        console.log("Orden actualizado");
                    }
                });
            }
        });
    ');
}

// Función para obtener la galería de fotografías (helper para el frontend)
function get_galeria_fotografias($post_id = null)
{
    if (!$post_id) {
        $post_id = get_the_ID();
    }

    $galeria = get_post_meta($post_id, '_galeria_fotografias', true);

    if (!$galeria || !is_array($galeria)) {
        return array();
    }

    return $galeria;
}

// Función para mostrar la galería en el frontend
function display_galeria_fotografias($post_id = null, $size = 'medium')
{
    $galeria = get_galeria_fotografias($post_id);

    if (empty($galeria)) {
        return '';
    }

    $output = '<div class="fotografias-gallery">';

    foreach ($galeria as $image_id) {
        if (wp_attachment_is_image($image_id)) {
            $image_url = wp_get_attachment_image_url($image_id, $size);
            $image_alt = get_post_meta($image_id, '_wp_attachment_image_alt', true);
            $image_title = get_the_title($image_id);

            if ($image_url) {
                $output .= sprintf(
                    '<div class="gallery-item"><img src="%s" alt="%s" title="%s" /></div>',
                    esc_url($image_url),
                    esc_attr($image_alt ?: $image_title),
                    esc_attr($image_title)
                );
            }
        }
    }

    $output .= '</div>';

    return $output;
}

/* Función para registrar estilos (descomentada y corregida)
function photography_styles_register()
{
    wp_enqueue_style(
        'photography-styles', 
        get_template_directory_uri() . '/assets/modules/photography-module/photography-module.css', 
        array(), 
        wp_get_theme()->get('Version')
    );
}
add_action('wp_enqueue_scripts', 'photography_styles_register');
*/