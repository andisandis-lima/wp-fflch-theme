<?php
/**
 * Cabeçalho do Tema wp-fflch-theme
 * Testeira unificada com logo FFLCH, nome do site em duas linhas, busca e logo USP
 * COM SUPORTE A SUBMENUS DE MÚLTIPLOS NÍVEIS
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="profile" href="https://gmpg.org/xfn/11">
    <?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<!-- TOPO INSTITUCIONAL - FAIXA AZUL -->
<div class="top-bar">
    <div class="container">
        <!-- SEM CONTEÚDO -->
    </div>
</div>

<!-- CABEÇALHO -->
<header class="site-header">

    <!-- Busca no canto superior direito -->
    <div class="site-header__search">
        <?php get_search_form(); ?>
    </div>

    <div class="site-header__top">

        <!-- Logo FFLCH + nome do site -->
        <div class="site-branding">
            <a href="<?php echo esc_url(home_url('/')); ?>" class="site-branding__logo">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo-fflch.png'); ?>" alt="FFLCH">
            </a>

            <?php wp_fflch_theme_render_site_title(); ?>
        </div>

        <!-- Logo USP -->
        <div class="site-header__usp">
            <a href="https://www5.usp.br/" target="_blank" rel="noopener">
                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/logo-usp.png'); ?>" alt="USP">
            </a>
        </div>

    </div>

    <!-- Menu principal com suporte a múltiplos níveis -->
    <nav class="site-nav" aria-label="Menu principal">
        <div class="site-nav__inner">
            <?php
            if (has_nav_menu('primary')) {
                wp_nav_menu(array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'menu',
                    'depth'          => 4, // Permite até 4 níveis de profundidade
                    'fallback_cb'    => 'wp_fflch_theme_default_menu',
                ));
            } else {
                wp_fflch_theme_default_menu();
            }
            ?>
        </div>
    </nav>

</header>