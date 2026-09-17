<?php
/**
 * Template para arquivos (categorias, tags, etc.)
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
                        <?php
                        if (is_category()) :
                            single_cat_title();
                        elseif (is_tag()) :
                            single_tag_title();
                        elseif (is_author()) :
                            the_author();
                        elseif (is_day()) :
                            printf(__('Dia: %s', 'wp-fflch-theme'), get_the_date());
                        elseif (is_month()) :
                            printf(__('Mês: %s', 'wp-fflch-theme'), get_the_date('F Y'));
                        elseif (is_year()) :
                            printf(__('Ano: %s', 'wp-fflch-theme'), get_the_date('Y'));
                        else :
                            _e('Arquivos', 'wp-fflch-theme');
                        endif;
                        ?>
                    </h1>
                    <?php
                    if (is_category() || is_tag()) :
                        echo '<div class="archive-description">' . term_description() . '</div>';
                    endif;
                    ?>
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

                            <?php if (has_post_thumbnail()) : ?>
                                <div class="post-thumbnail">
                                    <a href="<?php the_permalink(); ?>">
                                        <?php the_post_thumbnail('medium'); ?>
                                    </a>
                                </div>
                            <?php endif; ?>

                            <div class="entry-summary">
                                <?php the_excerpt(); ?>
                            </div>

                            <footer class="entry-footer">
                                <span class="categories">
                                    <?php _e('Categorias:', 'wp-fflch-theme'); ?> 
                                    <?php the_category(', '); ?>
                                </span>
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
                    <p><?php _e('Nenhum conteúdo encontrado.', 'wp-fflch-theme'); ?></p>
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