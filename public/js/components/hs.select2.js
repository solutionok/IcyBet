/**
 * Selects wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 * @requires
 *
 */
;(function ($) {
  'use strict';

  function formatData(option) {
    if (!option.id) {
      return option.text;
    }

    var result = option.element.dataset.optionTemplate ? option.element.dataset.optionTemplate : '<span>' + option.text + '</span>';

    return $.parseHTML(result);
  }

  $.HSCore.components.HSSelect2 = {
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

      this.initSelects();

      return this.pageCollection;
    },

    initSelects: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        //Variables
        var $this = $(el),
          placeholder = $this.data('placeholder'),
          classes = $this.data('classes'),
          dropdownClasses = $this.data('dropdown-classes'),
          isHideSearch = Boolean($this.data('is-hide-search'));

        $this.select2({
          minimumResultsForSearch: isHideSearch ? Infinity : false,
          placeholder: placeholder ? placeholder : false,
          containerCssClass: classes,
          dropdownCssClass: dropdownClasses,
          templateResult: formatData,
          templateSelection: formatData
        });

        //Actions
        collection = collection.add($this);
      });
    }
  }
})(jQuery);
