# Tema de Portafolio Fotográfico

Este tema WordPress está diseñado específicamente para portafolios fotográficos y cuenta con características avanzadas para mostrar y gestionar contenido visual de manera profesional.

## Características Principales

- **Gestión de Contenido Avanzada**
  - Custom Post Types personalizados para galerías de imágenes
  - Metaboxes personalizados para configuración de galerías
  - ACF (Advanced Custom Fields) integrado para campos personalizados

- **Componentes Dinámicos**
  - Shortcodes personalizados:
    - Formulario de contacto
    - Redes sociales
  - Animaciones interactivas con GSAP

- **Diseño Moderno**
  - Estilos modernos con Tailwind CSS
  - Diseño responsive
  - Optimización para imágenes

## Requisitos

- WordPress 5.0 o superior
- PHP 7.4 o superior
- ACF Pro (recomendado)

## Instalación

1. Copiar el directorio del tema a la carpeta `/wp-content/themes/`
2. Activar el tema desde el panel de administración de WordPress
3. Instalar y activar ACF Pro (si no está instalado)
4. Configurar las opciones del tema desde Apariencia > Tema

## Uso

### Galerías de Imágenes
- Crea nuevas galerías usando el Custom Post Type "Fotografías"
- Configura las opciones de cada galería usando los metaboxes personalizados
- Utiliza ACF para agregar descripciónes de las galerías

### Shortcodes
- `[maileroo_contact]` - Inserta el formulario de contacto personalizado
- `[albor_social]` - Muestra los enlaces a redes sociales

### Animaciones
- Las animaciones GSAP están configuradas automáticamente
- Personaliza las animaciones en el archivo `assets/js/albor-animations.js`

## Personalización

Para modificar el tema:
1. Edita los estilos en `assets/css/albor-styles.css`
2. Personaliza los shortcodes en `functions.php`

## Soporte

Para soporte o consultas, por favor contactar al desarrollador del tema.

---
Desarrollado por Esteban Álvarez.
Versión: 1.0.0
