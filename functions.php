<?php
/**
 * Funções do Tema wp-fflch-theme
 * Unificação dos temas FFLCH WordPress e FFLCH Geografia
 * COM SUPORTE A SUBMENUS DE MÚLTIPLOS NÍVEIS
 */

if (!defined('ABSPATH')) {
    exit;
}

// ============================================
// 1. CONFIGURAÇÕES DO TEMA
// ============================================

function wp_fflch_theme_setup()
{
    // Suporte a título dinâmico
    add_theme_support('title-tag');

    // Suporte a imagens destacadas
    add_theme_support('post-thumbnails');

    // Suporte a logos
    add_theme_support('custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width'  => true,
    ));

    // Suporte ao Gutenberg
    add_theme_support('block-editor');
    add_theme_support('align-wide');
    add_theme_support('editor-styles');

    // Registra menus com suporte a profundidade
    register_nav_menus(array(
        'primary' => __('Menu Principal', 'wp-fflch-theme'),
        'footer'  => __('Menu do Rodapé', 'wp-fflch-theme'),
    ));

    // Suporte HTML5
    add_theme_support('html5', array(
        'search-form',
        'comment-form',
        'comment-list',
        'gallery',
        'caption',
    ));

    // Suporte a personalização de cores
    add_theme_support('custom-background', array(
        'default-color' => 'f5f5f5',
    ));

    // Suporte a largura de conteúdo
    global $content_width;
    if (!isset($content_width)) {
        $content_width = 800;
    }
}
add_action('after_setup_theme', 'wp_fflch_theme_setup');

// ============================================
// 2. CARREGA SCRIPTS E STYLES
// ============================================

function wp_fflch_theme_scripts()
{
    $theme_dir = get_template_directory_uri();

    // CSS
    wp_enqueue_style('wp-fflch-style', get_stylesheet_uri(), array(), '2.0.0');
    wp_enqueue_style('font-awesome', 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css', array(), '6.4.0');
    wp_enqueue_style('google-fonts', 'https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700;800&display=swap', array(), null);

    // Carrega todos os JS da pasta /js/
    $js_files = glob(get_template_directory() . '/js/*.js');

    if (!empty($js_files)) {
        usort($js_files, function ($a, $b) {
            if (strpos($a, 'smooth-scroll') !== false) return -1;
            if (strpos($b, 'smooth-scroll') !== false) return 1;
            return 0;
        });

        foreach ($js_files as $file) {
            $filename = basename($file, '.js');
            $handle = 'wp-fflch-' . sanitize_title($filename);

            $deps = array('jquery');

            if (strpos($filename, 'smooth-scroll') === false &&
                strpos($filename, 'jquery') === false &&
                strpos($filename, 'modernizr') === false) {
                if (file_exists(get_template_directory() . '/js/smooth-scroll.js')) {
                    $deps[] = 'wp-fflch-smooth-scroll';
                }
            }

            wp_enqueue_script(
                $handle,
                $theme_dir . '/js/' . basename($file),
                $deps,
                '2.0.0',
                true
            );
        }
    }
}
add_action('wp_enqueue_scripts', 'wp_fflch_theme_scripts');

// ============================================
// 3. REGISTRA AS SIDEBARS
// ============================================

function wp_fflch_theme_widgets_init()
{
    // SIDEBAR ESQUERDA (Desativável)
    register_sidebar(array(
        'name'          => __('Sidebar Esquerda', 'wp-fflch-theme'),
        'id'            => 'sidebar-left',
        'description'   => __('Sidebar que aparece no lado esquerdo. Deixe vazia para desativar.', 'wp-fflch-theme'),
        'before_widget' => '<div id="%1$s" class="widget sidebar-left-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // SIDEBAR DIREITA (Desativável)
    register_sidebar(array(
        'name'          => __('Sidebar Direita', 'wp-fflch-theme'),
        'id'            => 'sidebar-right',
        'description'   => __('Sidebar que aparece no lado direito. Deixe vazia para desativar.', 'wp-fflch-theme'),
        'before_widget' => '<div id="%1$s" class="widget sidebar-right-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // PÁGINA INICIAL - TOPO
    register_sidebar(array(
        'name'          => __('Página Inicial - Topo', 'wp-fflch-theme'),
        'id'            => 'front-top',
        'description'   => __('Widgets que aparecem no topo da página inicial.', 'wp-fflch-theme'),
        'before_widget' => '<div id="%1$s" class="front-widget top-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    // PÁGINA INICIAL - CONTEÚDO
    register_sidebar(array(
        'name'          => __('Página Inicial - Conteúdo', 'wp-fflch-theme'),
        'id'            => 'front-content',
        'description'   => __('Widgets que aparecem no centro da página inicial.', 'wp-fflch-theme'),
        'before_widget' => '<div id="%1$s" class="front-widget content-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h2 class="widget-title">',
        'after_title'   => '</h2>',
    ));

    // PÁGINA INICIAL - RODAPÉ
    register_sidebar(array(
        'name'          => __('Página Inicial - Rodapé', 'wp-fflch-theme'),
        'id'            => 'front-footer',
        'description'   => __('Widgets que aparecem no rodapé da página inicial.', 'wp-fflch-theme'),
        'before_widget' => '<div id="%1$s" class="front-widget footer-widget %2$s">',
        'after_widget'  => '</div>',
        'before_title'  => '<h3 class="widget-title">',
        'after_title'   => '</h3>',
    ));

    // RODAPÉ (4 colunas)
    for ($i = 1; $i <= 4; $i++) {
        register_sidebar(array(
            'name'          => sprintf(__('Rodapé - Coluna %d', 'wp-fflch-theme'), $i),
            'id'            => 'footer-' . $i,
            'description'   => sprintf(__('Widgets da coluna %d do rodapé.', 'wp-fflch-theme'), $i),
            'before_widget' => '<div id="%1$s" class="footer-column-widget %2$s">',
            'after_widget'  => '</div>',
            'before_title'  => '<h4 class="footer-widget-title">',
            'after_title'   => '</h4>',
        ));
    }
}
add_action('widgets_init', 'wp_fflch_theme_widgets_init');

// ============================================
// 4. FUNÇÕES PARA SIDEBARS
// ============================================

function wp_fflch_theme_get_content_class()
{
    $left_active  = is_active_sidebar('sidebar-left');
    $right_active = is_active_sidebar('sidebar-right');

    if ($left_active && $right_active) {
        return 'col-md-6';
    } elseif ($left_active || $right_active) {
        return 'col-md-9';
    } else {
        return 'col-md-12';
    }
}

// ============================================
// 5. CLASSES PERSONALIZADAS
// ============================================

function wp_fflch_theme_body_classes($classes)
{
    $classes[] = 'wp-fflch-theme';

    if (is_front_page()) {
        $classes[] = 'front-page';
    }

    if (is_active_sidebar('sidebar-left')) {
        $classes[] = 'has-left-sidebar';
    }

    if (is_active_sidebar('sidebar-right')) {
        $classes[] = 'has-right-sidebar';
    }

    return $classes;
}
add_filter('body_class', 'wp_fflch_theme_body_classes');

// ============================================
// 6. FUNÇÃO PARA RENDERIZAR O TÍTULO DO SITE
// ============================================

function wp_fflch_theme_render_site_title()
{
    $site_name = get_bloginfo('name');
    $words     = explode(' ', trim($site_name));

    if (count($words) > 1) {
        $line2 = array_pop($words);
        $line1 = implode(' ', $words);
    } else {
        $line1 = '';
        $line2 = $site_name;
    }
    ?>
    <a href="<?php echo esc_url(home_url('/')); ?>" class="site-branding__text">
        <?php if ($line1) : ?>
            <span class="site-branding__line1"><?php echo esc_html($line1); ?></span>
        <?php endif; ?>
        <span class="site-branding__line2"><?php echo esc_html($line2); ?></span>
    </a>
    <?php
}

// ============================================
// 7. WIDGETS PERSONALIZADOS
// ============================================

// Widget de Notícias
class WpFFLCH_News_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'wp_fflch_news_widget',
            __('FFLCH - Últimas Notícias', 'wp-fflch-theme'),
            array('description' => __('Exibe as últimas notícias.', 'wp-fflch-theme'))
        );
    }

    public function widget($args, $instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Notícias', 'wp-fflch-theme');
        $count = !empty($instance['count']) ? $instance['count'] : 5;

        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];

        $news_query = new WP_Query(array(
            'posts_per_page' => $count,
            'post_type'      => 'post',
            'ignore_sticky_posts' => 1
        ));

        if ($news_query->have_posts()) :
            echo '<div class="news-list">';
            while ($news_query->have_posts()) : $news_query->the_post();
                echo '<div class="news-item">';
                echo '<span class="news-date">' . get_the_date('d/m/Y') . '</span>';
                echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('Nenhuma notícia encontrada.', 'wp-fflch-theme') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:', 'wp-fflch-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Número de notícias:', 'wp-fflch-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" 
                   name="<?php echo $this->get_field_name('count'); ?>" 
                   type="number" value="<?php echo esc_attr($count); ?>" min="1" max="20">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? intval($new_instance['count']) : 5;
        return $instance;
    }
}

// Widget de Eventos
class WpFFLCH_Events_Widget extends WP_Widget
{
    public function __construct()
    {
        parent::__construct(
            'wp_fflch_events_widget',
            __('FFLCH - Próximos Eventos', 'wp-fflch-theme'),
            array('description' => __('Exibe os próximos eventos.', 'wp-fflch-theme'))
        );
    }

    public function widget($args, $instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : __('Eventos', 'wp-fflch-theme');
        $count = !empty($instance['count']) ? $instance['count'] : 5;

        echo $args['before_widget'];
        echo $args['before_title'] . $title . $args['after_title'];

        $events_query = new WP_Query(array(
            'posts_per_page' => $count,
            'post_type'      => 'post',
            'category_name'  => 'eventos',
            'orderby'        => 'date',
            'order'          => 'ASC'
        ));

        if ($events_query->have_posts()) :
            echo '<div class="events-list">';
            while ($events_query->have_posts()) : $events_query->the_post();
                echo '<div class="event-item">';
                echo '<span class="event-date">' . get_the_date('d/m/Y') . '</span>';
                echo '<h4><a href="' . get_permalink() . '">' . get_the_title() . '</a></h4>';
                echo '</div>';
            endwhile;
            echo '</div>';
            wp_reset_postdata();
        else :
            echo '<p>' . __('Nenhum evento encontrado.', 'wp-fflch-theme') . '</p>';
        endif;

        echo $args['after_widget'];
    }

    public function form($instance)
    {
        $title = !empty($instance['title']) ? $instance['title'] : '';
        $count = !empty($instance['count']) ? $instance['count'] : 5;
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Título:', 'wp-fflch-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" 
                   name="<?php echo $this->get_field_name('title'); ?>" 
                   type="text" value="<?php echo esc_attr($title); ?>">
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('count'); ?>"><?php _e('Número de eventos:', 'wp-fflch-theme'); ?></label>
            <input class="widefat" id="<?php echo $this->get_field_id('count'); ?>" 
                   name="<?php echo $this->get_field_name('count'); ?>" 
                   type="number" value="<?php echo esc_attr($count); ?>" min="1" max="20">
        </p>
        <?php
    }

    public function update($new_instance, $old_instance)
    {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title'])) ? strip_tags($new_instance['title']) : '';
        $instance['count'] = (!empty($new_instance['count'])) ? intval($new_instance['count']) : 5;
        return $instance;
    }
}

// Registra os widgets
function wp_fflch_theme_register_widgets()
{
    register_widget('WpFFLCH_News_Widget');
    register_widget('WpFFLCH_Events_Widget');
}
add_action('widgets_init', 'wp_fflch_theme_register_widgets');

// ============================================
// 8. SHORTCODES
// ============================================

function wp_fflch_theme_noticias_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'count' => 5,
    ), $atts);

    $news = new WP_Query(array(
        'posts_per_page' => $atts['count'],
        'post_type'      => 'post'
    ));

    $output = '<div class="shortcode-noticias">';
    if ($news->have_posts()) {
        while ($news->have_posts()) {
            $news->the_post();
            $output .= '<div class="shortcode-item">';
            $output .= '<span class="data">' . get_the_date('d/m/Y') . '</span>';
            $output .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            $output .= '</div>';
        }
    }
    $output .= '</div>';
    wp_reset_postdata();

    return $output;
}
add_shortcode('noticias', 'wp_fflch_theme_noticias_shortcode');

function wp_fflch_theme_eventos_shortcode($atts)
{
    $atts = shortcode_atts(array(
        'count' => 5
    ), $atts);

    $events = new WP_Query(array(
        'posts_per_page' => $atts['count'],
        'post_type'      => 'post',
        'category_name'  => 'eventos'
    ));

    $output = '<div class="shortcode-eventos">';
    if ($events->have_posts()) {
        while ($events->have_posts()) {
            $events->the_post();
            $output .= '<div class="shortcode-item">';
            $output .= '<span class="data">' . get_the_date('d/m/Y') . '</span>';
            $output .= '<a href="' . get_permalink() . '">' . get_the_title() . '</a>';
            $output .= '</div>';
        }
    }
    $output .= '</div>';
    wp_reset_postdata();

    return $output;
}
add_shortcode('eventos', 'wp_fflch_theme_eventos_shortcode');

// ============================================
// 9. FALLBACK DO MENU COM MÚLTIPLOS NÍVEIS
// ============================================

function wp_fflch_theme_default_menu()
{
    ?>
    <br>
    <?php
}

// ============================================
// 10. FUNÇÃO PARA CUSTOMIZAR O WALKER DO MENU
// ============================================

/**
 * Classe personalizada para o menu com suporte a múltiplos níveis
 * Adiciona classes CSS para estilização de submenus
 */
class WpFFLCH_Walker_Nav_Menu extends Walker_Nav_Menu
{
    /**
     * Inicia o elemento de lista do menu
     */
    public function start_lvl(&$output, $depth = 0, $args = array())
    {
        $indent = str_repeat("\t", $depth);
        $output .= "\n$indent<ul class=\"sub-menu\">\n";
    }

    /**
     * Inicia o elemento do item do menu
     */
    public function start_el(&$output, $item, $depth = 0, $args = array(), $id = 0)
    {
        $indent = ($depth) ? str_repeat("\t", $depth) : '';

        $classes = empty($item->classes) ? array() : (array) $item->classes;
        $classes[] = 'menu-item-' . $item->ID;

        // Adiciona classe para itens com submenu
        if (in_array('menu-item-has-children', $classes)) {
            $classes[] = 'menu-item-has-children';
        }

        $class_names = join(' ', apply_filters('nav_menu_css_class', array_filter($classes), $item, $args));
        $class_names = $class_names ? ' class="' . esc_attr($class_names) . '"' : '';

        $id = apply_filters('nav_menu_item_id', 'menu-item-' . $item->ID, $item, $args);
        $id = $id ? ' id="' . esc_attr($id) . '"' : '';

        $output .= $indent . '<li' . $id . $class_names . '>';

        $atts = array();
        $atts['title']  = !empty($item->attr_title) ? $item->attr_title : '';
        $atts['target'] = !empty($item->target) ? $item->target : '';
        $atts['rel']    = !empty($item->xfn) ? $item->xfn : '';
        $atts['href']   = !empty($item->url) ? $item->url : '';

        $atts = apply_filters('nav_menu_link_attributes', $atts, $item, $args);

        $attributes = '';
        foreach ($atts as $attr => $value) {
            if (!empty($value)) {
                $value = ('href' === $attr) ? esc_url($value) : esc_attr($value);
                $attributes .= ' ' . $attr . '="' . $value . '"';
            }
        }

        $title = apply_filters('the_title', $item->title, $item->ID);
        $title = apply_filters('nav_menu_item_title', $title, $item, $args);

        $item_output = $args->before;
        $item_output .= '<a' . $attributes . '>';
        $item_output .= $args->link_before . $title . $args->link_after;
        $item_output .= '</a>';
        $item_output .= $args->after;

        $output .= apply_filters('walker_nav_menu_start_el', $item_output, $item, $depth, $args);
    }
}

// Registra o walker personalizado
function wp_fflch_theme_nav_menu_args($args)
{
    if ('primary' === $args['theme_location']) {
        $args['walker'] = new WpFFLCH_Walker_Nav_Menu();
        $args['depth'] = 4;
    }
    return $args;
}
add_filter('wp_nav_menu_args', 'wp_fflch_theme_nav_menu_args');