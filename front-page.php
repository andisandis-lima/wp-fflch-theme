<?php
/**
 * Template da Página Inicial
 * Com duas sidebars desativáveis e áreas de widget específicas
 */

get_header(); ?>

<!-- TOPO DA PÁGINA INICIAL -->
<?php if (is_active_sidebar('front-top')) : ?>
    <div class="front-top-area">
        <div class="container">
            <?php dynamic_sidebar('front-top'); ?>
        </div>
    </div>
<?php endif; ?>

<!-- CONTEÚDO PRINCIPAL DA PÁGINA INICIAL -->
<div class="front-content-area">
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
                            <?php if (!is_active_sidebar('front-content')) : ?>
                                <h1><?php the_title(); ?></h1>
                                <div class="entry-content">
                                    <?php the_content(); ?>
                                </div>
                            <?php else : ?>
                                <?php dynamic_sidebar('front-content'); ?>
                            <?php endif; ?>
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

<!-- RODAPÉ DA PÁGINA INICIAL -->
<?php if (is_active_sidebar('front-footer')) : ?>
    <div class="front-footer-area">
        <div class="container">
            <div class="row">
                <?php dynamic_sidebar('front-footer'); ?>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php get_footer(); ?>