/**
 * Show On Type wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 * @requires
 *
 */
;(function ($) {
  'use strict';

  $.HSCore.components.HSHeaderSearch = {
    /**
     *
     *
     * @var Object _baseConfig
     */
    _baseConfig: {},

    /**
     *
     *
     * @var jQuery pageCollection
     */
    pageCollection: $(),

    /**
     * Initialization of Selects wrapper.
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

      this.initHeaderSearch();

      return this.pageCollection;
    },

    initHeaderSearch: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        // inner functions
        function windowClick() {

          if (searchTarget) {

            $(searchTarget).fadeOut(400, function () {

              $(searchForm).fadeOut(400);

            });

          } else {

            $(searchForm).fadeOut(400);

          }

        }

        function clearForm() {

          $(searchField).removeClass('focused');
          $(searchField).val('');
          $(searchTarget).fadeOut(200);

        }

        //Variables
        var $this = $(el),
          searchTarget = $this.data('search-target'),
          searchMobileInvoker = $this.data('search-mobile-invoker'),
          searchForm = $this.data('search-form'),
          searchField = $this.data('search-field'),
          searchClear = $this.data('search-clear'),
          windowWidth = window.innerWidth;

        $(searchField).on('keyup', function () {
          var val = $(searchField).val();

          if (val.length >= 1) {

            $(searchField).addClass('focused');
            $(searchTarget).fadeIn(200);

          } else {

            $(searchField).removeClass('focused');
            $(searchTarget).fadeOut(200);

          }
        });

        if (searchClear) {

          document.querySelector(searchClear).addEventListener('click', clearForm);

        }

        $(searchMobileInvoker).on('click', function (e) {

          e.stopPropagation();
          e.preventDefault();

          $(searchForm).fadeToggle(400);

        });

        $(searchForm).on('click', function (e) {

          e.stopPropagation();

        });

        if (windowWidth >= 992) {

          window.removeEventListener('click', windowClick);

          if (searchClear) {
            window.removeEventListener('click', clearForm);
          }


        } else {

          window.addEventListener('click', windowClick);

          if (searchClear) {
            window.addEventListener('click', clearForm);
          }

        }

        $(searchTarget).on('click', function (e) {

          e.stopPropagation();

        });

        $(window).on('resize', function () {

          var windowWidth = window.innerWidth;

          if (windowWidth >= 992) {

            $(searchForm).attr('style', '');
            window.removeEventListener('click', windowClick);

            if (searchClear) {
              window.removeEventListener('click', clearForm);
            }

          } else {

            window.addEventListener('click', windowClick);

            if (searchClear) {
              window.addEventListener('click', clearForm);
            }

          }

        });

        //Actions
        collection = collection.add($this);
      });
    }

  }
})(jQuery);