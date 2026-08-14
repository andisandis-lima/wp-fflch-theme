<?php
/**
 * Template para página 404 (não encontrada)
 * Com duas sidebars desativáveis
 */

get_header(); ?>

<div class="page-content-area">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR ESQUERDA -->
            <?php if (is_active_sidebar('sidebar-left')) : ?>
                <div class="col-md-3 sidebar-left">
                    <?php dynamic_sidebar('sidebar-left'); ?>
                </div>
            <?php endif; ?>

            <!-- CONTEÚDO PRINCIPAL -->
            <div class="<?php echo wp_fflch_theme_get_content_class(); ?>">
                <section class="error-404 not-found">
                    <header class="page-header">
                        <h1><?php _e('404', 'wp-fflch-theme'); ?></h1>
                        <h2><?php _e('Página não encontrada', 'wp-fflch-theme'); ?></h2>
                    </header>

                    <div class="page-content">
                        <p><?php _e('O conteúdo que você procura não existe ou foi movido.', 'wp-fflch-theme'); ?></p>

                        <div style="margin: 30px 0;">
                            <a href="<?php echo esc_url(home_url('/')); ?>" class="button">
                                <?php _e('Voltar para a página inicial', 'wp-fflch-theme'); ?>
                            </a>
                        </div>

                        <div style="margin: 30px 0;">
                            <h3><?php _e('Pesquisar:', 'wp-fflch-theme'); ?></h3>
                            <?php get_search_form(); ?>
                        </div>
                    </div>
                </section>
            </div>

            <!-- SIDEBAR DIREITA -->
            <?php if (is_active_sidebar('sidebar-right')) : ?>
                <div class="col-md-3 sidebar-right">
                    <?php dynamic_sidebar('sidebar-right'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>