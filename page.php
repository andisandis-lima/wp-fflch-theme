<?php
/**
 * Template padrão para páginas
 * Com duas sidebars (esquerda e direita) desativáveis
 */

get_header(); ?>

<div class="page-content-area">
    <div class="container">
        <div class="row">

            <!-- SIDEBAR ESQUERDA (Desativável) -->
            <?php if (is_active_sidebar('sidebar-left')) : ?>
                <div class="col-md-3 sidebar-left">
                    <?php dynamic_sidebar('sidebar-left'); ?>
                </div>
            <?php endif; ?>

            <!-- CONTEÚDO PRINCIPAL -->
            <div class="<?php echo wp_fflch_theme_get_content_class(); ?>">
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <h1><?php the_title(); ?></h1>
                            </header>

                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>

                            <footer class="entry-footer">
                                <?php edit_post_link(__('Editar', 'wp-fflch-theme'), '<span class="edit-link">', '</span>'); ?>
                            </footer>
                        </article>
                    <?php endwhile; ?>
                <?php endif; ?>
            </div>

            <!-- SIDEBAR DIREITA (Desativável) -->
            <?php if (is_active_sidebar('sidebar-right')) : ?>
                <div class="col-md-3 sidebar-right">
                    <?php dynamic_sidebar('sidebar-right'); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div>

<?php get_footer(); ?>