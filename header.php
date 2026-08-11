<?php
/**
 * FFLCH Geografia - header.php
 * Reproduz a testeira: logo FFLCH + nome do site, busca, logo USP e menu.
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<?php wp_body_open(); ?>

<header class="site-header">

    <!-- Busca no canto superior direito -->
    <div class="site-header__search">
        <?php get_search_form(); ?>
    </div>

    <div class="site-header__top">

        <!-- Logo FFLCH + nome do site (Departamento de / Geografia) -->
        <div class="site-branding">
            <a href="<?php echo esc_url( home_url( '/' ) ); ?>" class="site-branding__logo">
                <!-- CAMINHO FIXO DA IMAGEM DO LOGO FFLCH -->
                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-fflch.png' ); ?>" alt="FFLCH">
            </a>

            <?php fflch_geografia_render_site_title(); ?>
        </div>

        <!-- Logo USP -->
        <div class="site-header__usp">
            <a href="https://www5.usp.br/" target="_blank" rel="noopener">
                <!-- CAMINHO FIXO DA IMAGEM DO LOGO USP -->
                <img src="<?php echo esc_url( get_template_directory_uri() . '/images/logo-usp.png' ); ?>" alt="USP">
            </a>
        </div>

    </div>

    <!-- Menu principal -->
    <nav class="site-nav" aria-label="Menu principal">
        <div class="site-nav__inner">
            <?php
            if ( has_nav_menu( 'primary' ) ) {
                wp_nav_menu( array(
                    'theme_location' => 'primary',
                    'container'      => false,
                    'menu_class'     => 'menu',
                    'depth'          => 2,
                ) );
            } else {
                fflch_geografia_default_menu();
            }
            ?>
        </div>
    </nav>

</header>
