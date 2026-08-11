<?php
/**
 * FFLCH Geografia - index.php
 * Template principal (obrigatório para o tema funcionar).
 */

get_header();
?>

<main class="site-content" style="max-width:1200px;margin:0 auto;padding:30px 20px;">

    <?php if ( have_posts() ) : ?>
        <?php while ( have_posts() ) : the_post(); ?>
            <article <?php post_class(); ?>>
                <h1><?php the_title(); ?></h1>
                <div class="entry-content">
                    <?php the_content(); ?>
                </div>
            </article>
        <?php endwhile; ?>
    <?php else : ?>
        <p><?php esc_html_e( 'Nenhum conteúdo encontrado.', 'fflch-geografia' ); ?></p>
    <?php endif; ?>

</main>

<?php
get_footer();
