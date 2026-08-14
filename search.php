<?php
/**
 * Template para resultados de busca
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
                <header class="page-header">
                    <h1 class="page-title">
                        <?php printf(__('Resultados da busca: %s', 'wp-fflch-theme'), get_search_query()); ?>
                    </h1>
                </header>

                <?php if (have_posts()) : ?>
                    <?php while (have_posts()) : the_post(); ?>
                        <article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
                            <header class="entry-header">
                                <h2><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                                <div class="entry-meta">
                                    <span class="posted-on">
                                        <?php _e('Publicado em', 'wp-fflch-theme'); ?> 
                                        <time datetime="<?php echo get_the_date('c'); ?>">
                                            <?php echo get_the_date(); ?>
                                        </time>
                                    </span>
                                </div>
                            </header>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>
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
                    <p><?php _e('Nenhum resultado encontrado para sua busca.', 'wp-fflch-theme'); ?></p>
                    <?php get_search_form(); ?>
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