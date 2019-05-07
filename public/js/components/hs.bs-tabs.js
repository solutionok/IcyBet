/**
 * Tabs wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 * @requires
 *
 */
;(function ($) {
  'use strict';

  $.HSCore.components.HSBSTabs = {
    /**
     *
     *
     * @var Object _baseConfig
     */
    _baseConfig: {
      transformResolution: 767
    },

    /**
     *
     *
     * @var jQuery pageCollection
     */
    pageCollection: $(),

    /**
     * Initialization of Tabs wrapper.
     *
     * @param String selector (optional)
     * @param Object config (optional)
     *
     * @return jQuery pageCollection - collection of initialized items.
     */

    init: function (selector, config) {

      this.collection = selector && $(selector).length ? $(selector) : $();
      if (!$(selector).length) return;

      this.config = config && $.isPlainObject(config) ?
        $.extend({}, this._baseConfig, config) : this._baseConfig;

      this.config.itemSelector = selector;

      this.initTabs();

      return this.pageCollection;

    },

    initTabs: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        //Variables
        var windowWidth = window.innerWidth,

          //Tabs
          $tabs = $(el),
          $tabsParent = $tabs.parent(),
          $tabsItem = $tabs.find('> *'),
          tabsType = $tabs.data('tabs-mobile-type'), //[slide-up-down], [accordion]
          controlClasses = $tabs.data('btn-classes'),
          context = $tabs.parent(),
          transformResolution = $tabs.data('transform-resolution') ? $tabs.data('transform-resolution') : config.transformResolution,

          //Tabs Content
          $tabsContent = $('#' + $tabs.data('target')),
          $tabsContentItem = $tabsContent.find('.tab-pane');

        if (windowWidth < transformResolution) {
          $tabs.hide();

          $tabsParent.addClass('nav-mobile-mode-on');

          $('body').on('click', function () {
            if (tabsType) {
              $tabs.slideUp(200);
            } else {
              $tabs.find('.nav-inner').slideUp(200);
            }
          });
        } else {
          $tabs.show();

          $tabsParent.removeClass('nav-mobile-mode-on');

          $('body').off('click');
        }

        if (windowWidth > transformResolution && tabsType) {
          $tabs.removeAttr('style');
          $tabsContentItem.removeAttr('style');
          context.off('click', '.js-tabs-mobile-control');
          context.off('click', '[role="tab"]');

          if (tabsType === 'accordion') {
            $tabsContent.find('.js-tabs-mobile-control').remove();
          } else {
            context.find('.js-tabs-mobile-control').remove();
          }
          return;
        }

        if (windowWidth < (transformResolution + 1) && tabsType === 'accordion') {
          $self.accordionEffect($tabsContent, $tabsItem, $tabsContentItem, controlClasses);
        } else if (windowWidth < (transformResolution + 1) && tabsType === 'slide-up-down') {
          $self.slideUpDownEffect(context, $tabs, controlClasses);
        }

        //Actions
        collection = collection.add($tabs);
      });
    },

    slideUpDownEffect: function (context, menu, btnClasses) {
      if (context.find('.js-tabs-mobile-control').length) return;

      //Create control
      var activeItemHTML = menu.find('.active').html();

      $(menu).before('<a class="js-tabs-mobile-control ' + btnClasses + '" href="#">' + activeItemHTML + '</a>');

      /*----- CLICK -----*/
      context.on('click', '.js-tabs-mobile-control', function (e) {
        e.stopPropagation();
        e.preventDefault();

        $(menu).slideToggle(200);
      });

      context.on('click', '[role="tab"]', function (e) {
        e.preventDefault();

        var thisHTML = $(this).html(),
          $targetControl = $(this).closest('ul').prev('.js-tabs-mobile-control');

        $targetControl.html(thisHTML);
        $(menu).slideUp(200);
      });
    },

    accordionEffect: function (context, menuItem, menu, btnClasses) {
      if (context.find('.js-tabs-mobile-control').length) return;

      //Create control
      $(menu).before('<a class="js-tabs-mobile-control ' + btnClasses + '" href="#"></a>');

      menuItem.each(function () {
        var thisIndex = $(this).index(),
          thisHTML = $(this).find('[role="tab"]').html();

        if ($(this).find('[role="tab"]').hasClass('active')) {
          $(menu[thisIndex]).prev().addClass('active');
        }

        $(menu[thisIndex]).prev().html(thisHTML);
      });

      /*----- CLICK -----*/
      context.on('click', '.js-tabs-mobile-control', function (e) {
        e.preventDefault();

        if ($(this).hasClass('active')) return;

        var contextID = context.attr('id');

        context.find('.js-tabs-mobile-control').removeClass('active');

        $('[data-target="' + contextID + '"]').find('.nav-link').removeClass('active');
        var $target = $(this).next(),
          targetID = $target.attr('id');

        if ($target.hasClass('fade')) {
          $(this).addClass('active');
          $('[href="#' + targetID + '"]').addClass('active');

          $(menu)
            .slideUp(200);
          $target
            .slideDown(200, function () {
              context.find('[role="tabpanel"]').removeClass('show active');
              $target.addClass('show active');
            });
        } else {
          $(this).addClass('active');
          $(menu).slideUp(200);
          $target.slideDown(200);
        }
      });
    }
  }

})(jQuery);
