<?php
/**
 * Template para posts individuais
 * Com duas sidebars (esquerda e direita) desativáveis
 */

get_header(); ?>

<div class="single-content-area">
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
                                <h1><?php the_title(); ?></h1>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php _e('Publicado em', 'wp-fflch-theme'); ?> 
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                    <span class="byline">
                                        <?php _e('por', 'wp-fflch-theme'); ?> 
                                        <?php the_author(); ?>
                                    </span>
                                    <span class="categories">
                                        <?php _e('Categorias:', 'wp-fflch-theme'); ?> 
                                        <?php the_category(', '); ?>
                                    </span>
                                </div>
                            </header>

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <?php the_post_thumbnail('large'); ?>
                                </div>
                            <?php endif; ?>

                            <div class="entry-content">
                                <?php the_content(); ?>
                            </div>

                            <footer class="entry-footer">
                                <?php the_tags(__('Tags:', 'wp-fflch-theme'), ', '); ?>
                                <?php edit_post_link(__('Editar', 'wp-fflch-theme'), '<span class="edit-link">', '</span>'); ?>
                            </footer>

                            <div class="post-navigation">
                                <?php
                                previous_post_link('%link', '← ' . __('Post anterior', 'wp-fflch-theme'));
                                next_post_link('%link', __('Próximo post', 'wp-fflch-theme') . ' →');
                                ?>
                            </div>
                        </article>
                    <?php endwhile; ?>
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