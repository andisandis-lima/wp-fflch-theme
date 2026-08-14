/**
 * Scripts do Tema wp-fflch-theme
 * COM SUPORTE A SUBMENUS DE MÚLTIPLOS NÍVEIS
 */

(function($) {
    'use strict';

    $(document).ready(function() {
        
        /**
         * Menu Mobile - Toggle para submenus de múltiplos níveis
         * Funciona para: 
         * - Desktop: hover para abrir submenus
         * - Mobile: clique para abrir/fechar submenus (todos os níveis)
         */
        
        function isMobile() {
            return $(window).width() <= 900;
        }

        // Função para resetar todos os submenus (exceto o atual)
        function resetSubmenus($currentItem) {
            $('.site-nav .open').each(function() {
                if ($(this).find($currentItem).length === 0) {
                    $(this).removeClass('open');
                    $(this).find('ul.sub-menu').slideUp(200);
                }
            });
        }

        // Função para fechar todos os submenus
        function closeAllSubmenus() {
            $('.site-nav .open').removeClass('open');
            $('.site-nav ul.sub-menu').slideUp(200);
        }

        // Toggle para submenus em mobile (todos os níveis)
        $('.site-nav .menu-item-has-children > a').on('click', function(e) {
            if (isMobile()) {
                var $parent = $(this).parent();
                var $submenu = $parent.children('ul.sub-menu');
                
                // Se o submenu já está aberto, fecha
                if ($parent.hasClass('open')) {
                    $parent.removeClass('open');
                    $submenu.slideUp(200);
                    e.preventDefault();
                    return;
                }
                
                // Fecha outros submenus abertos
                $('.site-nav .open').each(function() {
                    if (!$(this).is($parent)) {
                        $(this).removeClass('open');
                        $(this).find('ul.sub-menu').slideUp(200);
                    }
                });
                
                // Abre o submenu
                $parent.addClass('open');
                $submenu.slideDown(200);
                e.preventDefault();
            }
        });

        // Suporte para hover em desktop (submenus de todos os níveis)
        if (!isMobile()) {
            $('.site-nav .menu-item-has-children').hover(
                function() {
                    $(this).addClass('open');
                    $(this).children('ul.sub-menu').stop(true, true).slideDown(200);
                },
                function() {
                    $(this).removeClass('open');
                    $(this).children('ul.sub-menu').stop(true, true).slideUp(200);
                }
            );
        }

        // Fecha submenus ao clicar fora do menu (mobile)
        $(document).on('click', function(e) {
            if (!$(e.target).closest('.site-nav').length && !$(e.target).closest('.site-header__search').length) {
                closeAllSubmenus();
            }
        });

        // Fecha submenus ao redimensionar para desktop
        $(window).on('resize', function() {
            if (!isMobile()) {
                closeAllSubmenus();
                // Reaplica hover behavior
                $('.site-nav .menu-item-has-children').off('mouseenter mouseleave');
                $('.site-nav .menu-item-has-children').hover(
                    function() {
                        $(this).addClass('open');
                        $(this).children('ul.sub-menu').stop(true, true).slideDown(200);
                    },
                    function() {
                        $(this).removeClass('open');
                        $(this).children('ul.sub-menu').stop(true, true).slideUp(200);
                    }
                );
            }
        });

        // Smooth scroll para links com # (âncoras)
        $('a[href*="#"]:not([href="#"])').on('click', function() {
            if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') &&
                location.hostname === this.hostname) {
                var target = $(this.hash);
                if (target.length) {
                    $('html, body').animate({
                        scrollTop: target.offset().top - 100
                    }, 800);
                    return false;
                }
            }
        });

        // Adiciona classe para navegação sticky no topo
        var header = $('.site-header');
        var sticky = header.offset().top;

        $(window).on('scroll', function() {
            if ($(window).scrollTop() > sticky) {
                header.addClass('sticky');
            } else {
                header.removeClass('sticky');
            }
        });

        console.log('wp-fflch-theme - Scripts carregados com sucesso!');
        console.log('Suporte a submenus de múltiplos níveis ativo!');

    });

})(jQuery);