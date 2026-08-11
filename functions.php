<?php
/**
 * FFLCH Geografia - functions.php
 * Arquivo mínimo de funções do tema.
 */

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Segurança: impede acesso direto ao arquivo.
}

/**
 * Configurações básicas do tema.
 */
function fflch_geografia_setup() {
    // Título editável via wp_title / bloginfo.
    add_theme_support( 'title-tag' );

    // Suporte a menus de navegação.
    register_nav_menus( array(
        'primary' => __( 'Menu Principal', 'fflch-geografia' ),
    ) );

    // Suporte a logo customizado (opcional, caso queira trocar via Personalizar).
    add_theme_support( 'custom-logo' );

    // HTML5 para formulários de busca, menus, etc.
    add_theme_support( 'html5', array( 'search-form', 'navigation-widgets' ) );
}
add_action( 'after_setup_theme', 'fflch_geografia_setup' );

/**
 * Carrega o CSS principal do tema (style.css).
 */
function fflch_geografia_scripts() {
    wp_enqueue_style(
        'fflch-geografia-style',
        get_stylesheet_uri(),
        array(),
        wp_get_theme()->get( 'Version' )
    );
}
add_action( 'wp_enqueue_scripts', 'fflch_geografia_scripts' );

/**
 * Fallback do menu, caso nenhum menu tenha sido criado
 * em Aparência > Menus. Reproduz os itens da imagem enviada.
 */
function fflch_geografia_default_menu() {
    echo '<ul class="menu">';
    echo '<li class="menu-item-has-children"><a href="' . esc_url( home_url( '/departamento' ) ) . '">Departamento</a></li>';
    echo '<li class="menu-item-has-children"><a href="' . esc_url( home_url( '/graduacao' ) ) . '">Graduação</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/pos-graduacao' ) ) . '">Pós-Graduação</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/professores' ) ) . '">Professores</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/laboratorios' ) ) . '">Laboratórios</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/revistas' ) ) . '">Revistas</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/biblioteca' ) ) . '">Biblioteca</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/formularios' ) ) . '">Formulários</a></li>';
    echo '<li><a href="' . esc_url( home_url( '/contatos' ) ) . '">Contatos</a></li>';
    echo '</ul>';
}

/**
 * Divide o "nome do site" (bloginfo('name')) em duas linhas,
 * como no exemplo: "DEPARTAMENTO DE" / "GEOGRAFIA".
 * Regra: a última palavra vai para a 2ª linha (destaque),
 * o restante vai para a 1ª linha.
 */
function fflch_geografia_render_site_title() {
    $site_name = get_bloginfo( 'name' );
    $words     = explode( ' ', trim( $site_name ) );

    if ( count( $words ) > 1 ) {
        $line2 = array_pop( $words );
        $line1 = implode( ' ', $words );
    } else {
        $line1 = '';
        $line2 = $site_name;
    }
    ?>
    <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding__text">
        <?php if ( $line1 ) : ?>
            <span class="site-branding__line1"><?php echo esc_html( $line1 ); ?></span>
        <?php endif; ?>
        <span class="site-branding__line2"><?php echo esc_html( $line2 ); ?></span>
    </a>
    <?php
}
