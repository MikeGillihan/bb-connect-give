(function($) {

	BBCGiveTabs = function( settings )
	{
		this.settings 	= settings;
		this.nodeClass  = '.fl-node-' + settings.id;
		this._init();
	};

	BBCGiveTabs.prototype = {

		settings	: {},
		nodeClass   : '',

		_init: function()
		{
			var win = $(window);

			$(this.nodeClass + ' .bbc-tabs-labels .bbc-tabs-label').click($.proxy(this._labelClick, this));
			$(this.nodeClass + ' .bbc-tabs-labels .bbc-tabs-label').on('keypress', $.proxy(this._labelClick, this));
			$(this.nodeClass + ' .bbc-tabs-panels .bbc-tabs-label').click($.proxy(this._responsiveLabelClick, this));
			$(this.nodeClass + ' .bbc-tabs-panels .bbc-tabs-label').on('keypress', $.proxy(this._responsiveLabelClick, this));

			if($(this.nodeClass + ' .bbc-tabs-vertical').length > 0) {
				this._resize();
				win.off('resize' + this.nodeClass);
				win.on('resize' + this.nodeClass, $.proxy(this._resize, this));
			}

			FLBuilderLayout.preloadAudio( this.nodeClass + ' .bbc-tabs-panel-content' );
		},

		_labelClick: function(e)
		{
			var label       = $(e.target).closest('.bbc-tabs-label'),
				index       = label.data('index'),
				wrap        = label.closest('.bbc-tabs'),
				allIcons    = wrap.find('.bbc-tabs-panels .bbc-tabs-label .fa'),
				icon        = wrap.find('.bbc-tabs-panels .bbc-tabs-label[data-index="' + index + '"] .fa');

			// Click or keyboard (enter or space) input?
			if(!this._validClick(e)) {
				return;
			}

			// Toggle the responsive icons.
			allIcons.addClass('fa-plus');
			icon.removeClass('fa-plus');

			// Toggle the tabs.
			wrap.find('.bbc-tabs-labels:first > .bbc-tab-active').removeClass('bbc-tab-active').attr('aria-selected', 'false').attr('aria-expanded', 'false');
			wrap.find('.bbc-tabs-panels:first > .bbc-tabs-panel > .bbc-tab-active').removeClass('bbc-tab-active');
			wrap.find('.bbc-tabs-panels:first > .bbc-tabs-panel > .bbc-tabs-panel-content').attr('aria-hidden', 'true');

			wrap.find('.bbc-tabs-labels:first > .bbc-tabs-label[data-index="' + index + '"]').addClass('bbc-tab-active').attr('aria-selected', 'true').attr('aria-expanded', 'true');
			wrap.find('.bbc-tabs-panels:first > .bbc-tabs-panel > .bbc-tabs-panel-content[data-index="' + index + '"]').addClass('bbc-tab-active').attr('aria-hidden', 'false');

			// Gallery module support.
			FLBuilderLayout.refreshGalleries( wrap.find('.bbc-tabs-panel-content[data-index="' + index + '"]') );

			// Grid layout support (uses Masonry)
			FLBuilderLayout.refreshGridLayout( wrap.find('.bbc-tabs-panel-content[data-index="' + index + '"]') );

			// Post Carousel support (uses BxSlider)
			FLBuilderLayout.reloadSlider( wrap.find('.bbc-tabs-panel-content[data-index="' + index + '"]') );

			// WP audio shortcode support
			FLBuilderLayout.resizeAudio( wrap.find('.bbc-tabs-panel-content[data-index="' + index + '"]') );
		},

		_responsiveLabelClick: function(e)
		{
			var label           = $(e.target).closest('.bbc-tabs-label'),
				wrap            = label.closest('.bbc-tabs'),
				index           = label.data('index'),
				content         = label.siblings('.bbc-tabs-panel-content'),
				activeContent   = wrap.find('.bbc-tabs-panel-content.bbc-tab-active'),
				activeIndex     = activeContent.data('index'),
				allIcons        = wrap.find('.bbc-tabs-panels .bbc-tabs-label > .fa'),
				icon            = label.find('.fa');

			// Click or keyboard (enter or space) input?
			if(!this._validClick(e)) {
				return;
			}

			// Should we proceed?
			if(index == activeIndex) {
				return;
			}
			if(wrap.hasClass('bbc-tabs-animation')) {
				return;
			}

			// Toggle the icons.
			allIcons.addClass('fa-plus');
			icon.removeClass('fa-plus');

			// Run the animations.
			wrap.addClass('bbc-tabs-animation');
			activeContent.slideUp('normal');

			content.slideDown('normal', function(){

				wrap.find('.bbc-tab-active').removeClass('bbc-tab-active').attr('aria-hidden', 'true');
				wrap.find('.bbc-tabs-panels:first > .bbc-tabs-panel > .bbc-tabs-panel-content').attr('aria-hidden', 'true');
				wrap.find('.bbc-tabs-label[data-index="' + index + '"]').addClass('bbc-tab-active').attr('aria-hidden', 'false');
				wrap.find('.bbc-tabs-panels:first > .bbc-tabs-panel > .bbc-tabs-panel-content[data-index="' + index + '"]').attr('aria-hidden', 'false');
				content.addClass('bbc-tab-active');
				wrap.removeClass('bbc-tabs-animation');

				// Gallery module support.
				FLBuilderLayout.refreshGalleries( content );

				// Grid layout support (uses Masonry)
				FLBuilderLayout.refreshGridLayout( content );

				// Post Carousel support (uses BxSlider)
				FLBuilderLayout.reloadSlider( content );

				// WP audio shortcode support
				FLBuilderLayout.resizeAudio( content );

				if(label.offset().top < $(window).scrollTop() + 100) {
					$('html, body').animate({ scrollTop: label.offset().top - 100 }, 500, 'swing');
				}
			});
		},

		_resize: function()
		{
			$(this.nodeClass + ' .bbc-tabs-vertical').each($.proxy(this._resizeVertical, this));
		},

		_resizeVertical: function(e)
		{
			var wrap    = $(this.nodeClass + ' .bbc-tabs-vertical'),
				labels  = wrap.find('.bbc-tabs-labels'),
				panels  = wrap.find('.bbc-tabs-panels');

			panels.css('min-height', labels.height() + 'px');
		},

		_validClick: function(e)
		{
			return (e.which == 1 || e.which == 13 || e.which == 32) ? true : false;
		}
	};

})(jQuery);