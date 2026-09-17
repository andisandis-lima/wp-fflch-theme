<?php
/**
 * Template Principal (index.php)
 * Ponto de entrada do tema
 */

get_header();
?>

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
                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <h1 class="entry-title"><?php the_title(); ?></h1>
                            </header>

                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>

                            <footer class="entry-footer">
                                <?php edit_post_link(__('Editar', 'wp-fflch-theme'), '<span class="edit-link">', '</span>'); ?>
                            </footer>
                        </article>
                    <?php endwhile; ?>

                    <div class="pagination">
                        <?php
                        the_posts_pagination(array(
                            'mid_size'  => 2,
                            'prev_text' => __('← Anterior', 'wp-fflch-theme'),
                            'next_text' => __('Próximo →', 'wp-fflch-theme'),
                        ));
                        ?>
                    </div>

                <?php else : ?>
                    <div class="no-content">
                        <p><?php _e('Nenhum conteúdo encontrado.', 'wp-fflch-theme'); ?></p>
                    </div>
                <?php endif; ?>
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