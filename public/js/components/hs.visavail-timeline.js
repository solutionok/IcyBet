/**
 * Timeline chart wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 *
 */
;(function ($) {
  'use strict';

  $.HSCore.components.HSVisavailTimeline = {
    /**
     *
     *
     * @var Object _baseConfig
     */
    _baseConfig: {
      margin: {
        top: 0,
        right: 40,
        bottom: 0,
        left: 100
      },
      dataHeight: 18,
      lineSpacing: 14,
      width: 940,
      maxDisplayDatasets: 0,
      valueMargin: {
        top: 0,
        left: 0
      },
      axisOrientation: 'top',
      valueColor: '#ffffff',
      valueFontSize: 16,
      axisFontSize: 12,
      axisColor: '#8b8e9f',
      axisFontFamily: 'Helvetica, Arial, sans-serif',
      labelsFontSize: 16,
      labelsColor: '#4a4e69',
      labelsFontFamily: 'Helvetica, Arial, sans-serif'
    },

    /**
     *
     *
     * @var jQuery pageCollection
     */
    pageCollection: $(),

    /**
     * Initialization of Line chart wrapper.
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

      this.initCharts();

      return this.pageCollection;
    },

    initCharts: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        // Variables
        var $this = $(el),
          optData = JSON.parse(el.getAttribute('data-data-set')),
          optMargins = JSON.parse(el.getAttribute('data-margins')),
          optHeight = parseInt(el.getAttribute('data-height')),
          optWidth = parseInt(el.getAttribute('data-width')),
          optLineSpacing = parseInt(el.getAttribute('data-line-spacing')),
          optMaxDisplayDatasets = parseInt(el.getAttribute('data-max-display-datasets')),
          optValueMargin = JSON.parse(el.getAttribute('data-value-margin')),
          optAxisOrientation = el.getAttribute('data-axis-orientation'),
          optValueColor = el.getAttribute('data-value-color'),
          optValueFontSize = parseInt(el.getAttribute('data-value-font-size')),
          optAxisFontSize = parseInt(el.getAttribute('data-axis-font-size')),
          optAxisColor = el.getAttribute('data-axis-color'),
          optAxisFontFamily = el.getAttribute('data-axis-font-family'),
          optLabelsFontSize = parseInt(el.getAttribute('data-labels-font-size')),
          optLabelsColor = el.getAttribute('data-labels-color'),
          optLabelsFontFamily = el.getAttribute('data-labels-font-family'),
          optIsResponsive = Boolean(el.getAttribute('data-is-responsive'));

        var chart = visavailChart({
          dataHeight: optHeight ? optHeight : config.dataHeight,
          width: optWidth ? optWidth : config.width,
          margin: {
            top: optMargins.top ? optMargins.top : config.margin.top,
            right: optMargins.right ? optMargins.right : config.margin.right,
            bottom: optMargins.bottom ? optMargins.bottom : config.margin.bottom,
            left: optMargins.left ? optMargins.left : config.margin.left
          },
          lineSpacing: optLineSpacing ? optLineSpacing : config.lineSpacing,
          maxDisplayDatasets: optMaxDisplayDatasets ? optMaxDisplayDatasets : config.maxDisplayDatasets,
          axisOrientation: optAxisOrientation ? optAxisOrientation : config.axisOrientation,
          valueMargin: {
            top: optValueMargin.top ? optValueMargin.top : config.valueMargin.top,
            left: optValueMargin.left ? optValueMargin.left : config.valueMargin.left
          },
          valueColor: optValueColor ? optValueColor : config.valueColor,
          valueFontSize: optValueFontSize ? optValueFontSize : config.valueFontSize,
          axisFontSize: optAxisFontSize ? optAxisFontSize : config.axisFontSize,
          axisColor: optAxisColor ? optAxisColor : config.axisColor,
          axisFontFamily: optAxisFontFamily ? optAxisFontFamily : config.axisFontFamily,
          labelsFontSize: optLabelsFontSize ? optLabelsFontSize : config.labelsFontSize,
          labelsColor: optLabelsColor ? optLabelsColor : config.labelsColor,
          labelsFontFamily: optLabelsFontFamily ? optLabelsFontFamily : config.labelsFontFamily
        });

        function draw_visavail() {
          var windowWidth = window.innerWidth;

          if(windowWidth >= 768) {
            chart.width($this.width() - ((optMargins.left ? optMargins.left : config.margin.left) + (optMargins.right ? optMargins.right : config.margin.right)));
            chart.margin().left = optMargins.left ? optMargins.left : config.margin.left;
            chart.margin().bottom = optMargins.bottom ? optMargins.bottom : config.margin.bottom;
          } else {
            chart.width($this.width());
            chart.margin().left = 0;
            chart.margin().bottom = 3;
          }

          $this.text('');

          d3.select(el).datum(optData).call(chart);
        }

        draw_visavail();

        if (optIsResponsive) {
          $(window).resize(function () {
            return draw_visavail();
          });
        }

        //Actions
        collection = collection.add($(el));
      });
    }
  };
})(jQuery);
