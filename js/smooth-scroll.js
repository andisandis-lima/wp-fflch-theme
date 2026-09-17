/*
 * Smooth Scroll - wp-fflch-theme
 * Baseado no script do tema Aegan
 */

(function($) {

var defaults = {
    exclude: [],
    excludeWithin: [],
    offset: 0,
    direction: 'top',
    scrollElement: null,
    scrollTarget: null,
    beforeScroll: function() {},
    afterScroll: function() {},
    easing: 'swing',
    speed: 400,
    autoCoefficent: 2
};

$.fn.extend({
    scrollable: function(dir) {
        var scrl = getScrollable.call(this, {dir: dir});
        return this.pushStack(scrl);
    },
    firstScrollable: function(dir) {
        var scrl = getScrollable.call(this, {el: 'first', dir: dir});
        return this.pushStack(scrl);
    },

    smoothScroll: function(options) {
        options = options || {};
        var opts = $.extend({}, $.fn.smoothScroll.defaults, options);

        this.unbind('click.smoothscroll')
            .bind('click.smoothscroll', function(event) {
                var link = this,
                    $link = $(this),
                    exclude = opts.exclude,
                    excludeWithin = opts.excludeWithin,
                    include = true,
                    clickOpts = {},
                    hostMatch = ((location.hostname === link.hostname) || !link.hostname),
                    pathMatch = opts.scrollTarget || ($.smoothScroll.filterPath(link.pathname) || location.pathname) === location.pathname,
                    thisHash = escapeSelector(link.hash);

                if (!opts.scrollTarget && (!hostMatch || !pathMatch || !thisHash)) {
                    include = false;
                } else {
                    $.each(exclude, function(index, value) {
                        if ($link.is(escapeSelector(value))) {
                            include = false;
                            return false;
                        }
                    });
                    $.each(excludeWithin, function(index, value) {
                        if ($link.closest(value).length) {
                            include = false;
                            return false;
                        }
                    });
                }

                if (include) {
                    event.preventDefault();
                    $.extend(clickOpts, opts, {
                        scrollTarget: opts.scrollTarget || thisHash,
                        link: link
                    });
                    $.smoothScroll(clickOpts);
                }
            });

        return this;
    }
});

$.smoothScroll = function(options, px) {
    var opts, $scroller, scrollTargetOffset, speed,
        scrollerOffset = 0,
        offPos = 'offset',
        scrollDir = 'scrollTop',
        aniProps = {},
        aniOpts = {};

    if (typeof options === 'number') {
        opts = $.fn.smoothScroll.defaults;
        scrollTargetOffset = options;
    } else {
        opts = $.extend({}, $.fn.smoothScroll.defaults, options || {});
        if (opts.scrollElement) {
            offPos = 'position';
            if (opts.scrollElement.css('position') == 'static') {
                opts.scrollElement.css('position', 'relative');
            }
        }
    }

    opts = $.extend({link: null}, opts);
    scrollDir = opts.direction == 'left' ? 'scrollLeft' : scrollDir;

    if (opts.scrollElement) {
        $scroller = opts.scrollElement;
        scrollerOffset = $scroller[scrollDir]();
    } else {
        $scroller = $('html, body').firstScrollable();
    }

    opts.beforeScroll.call($scroller, opts);

    scrollTargetOffset = (typeof options === 'number') ? options :
                        px ||
                        ($(opts.scrollTarget)[offPos]() &&
                        $(opts.scrollTarget)[offPos]()[opts.direction]) ||
                        0;

    aniProps[scrollDir] = scrollTargetOffset + scrollerOffset + opts.offset;
    speed = opts.speed;

    if (speed === 'auto') {
        speed = aniProps[scrollDir] || $scroller.scrollTop();
        speed = speed / opts.autoCoefficent;
    }

    aniOpts = {
        duration: speed,
        easing: opts.easing,
        complete: function() {
            opts.afterScroll.call(opts.link, opts);
        }
    };

    if (opts.step) {
        aniOpts.step = opts.step;
    }

    if ($scroller.length) {
        $scroller.stop().animate(aniProps, aniOpts);
    } else {
        opts.afterScroll.call(opts.link, opts);
    }
};

$.smoothScroll.filterPath = function(string) {
    return string
        .replace(/^\//, '')
        .replace(/(index|default).[a-zA-Z]{3,4}$/, '')
        .replace(/\/$/, '');
};

$.fn.smoothScroll.defaults = defaults;

function escapeSelector(str) {
    return str.replace(/(:|\.)/g, '\\$1');
}

})(jQuery);

/** 
 * Botão Voltar ao Topo
 * Esconde o botão no início da página e mostra quando o scroll desce mais de 200px
 */

jQuery('.btn-btt').smoothScroll({speed: 1000});

jQuery(window).scroll(function() {
    if (jQuery(window).scrollTop() > 200) {
        jQuery('.btn-btt').show();
    } else {
        jQuery('.btn-btt').hide();
    }
}).resize(function() {
    if (jQuery(window).scrollTop() > 200) {
        jQuery('.btn-btt').show();
    } else {
        jQuery('.btn-btt').hide();
    }
});