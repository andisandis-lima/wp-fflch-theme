<?php
/**
 * Rodapé do Tema wp-fflch-theme
 */
?>

<!-- RODAPÉ -->
<footer class="site-footer">
    <div class="container">
        <div class="footer-columns">
            <?php for ($i = 1; $i <= 4; $i++) : ?>
                <?php if (is_active_sidebar('footer-' . $i)) : ?>
                    <div class="footer-column">
                        <?php dynamic_sidebar('footer-' . $i); ?>
                    </div>
                <?php endif; ?>
            <?php endfor; ?>
        </div>

        <div class="footer-bottom">
            <p>FFLCH - USP &copy; <?php echo date('Y'); ?> - <?php _e('Todos os direitos reservados', 'wp-fflch-theme'); ?></p>
        </div>
    </div>
</footer>

<!-- Botão Voltar ao Topo -->
<button class="btn-btt" style="display:none; position:fixed; bottom:30px; right:30px; z-index:999; background:#1c3f6e; color:#fff; border:none; border-radius:50%; width:50px; height:50px; font-size:20px; cursor:pointer;">
    <i class="fas fa-arrow-up"></i>
</button>

<?php wp_footer(); ?>
</body>
</html>