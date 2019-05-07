/**
 * Google Geo Chart wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 *
 */
;(function ($) {
  'use strict';

  $.HSCore.components.HSGoogleGeoChart = {
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
     * Initialization of Google Geo Chart wrapper.
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

      this.initGoogleGeoChart();

      return this.pageCollection;
    },

    initGoogleGeoChart: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        //Variables
        var $this = $(el),
          API_KEY = $this.data('api-key'),
          optData = JSON.parse(el.getAttribute('data-data')),
          optRegion = $this.data('region'),
          optBGColor = $this.data('bg-color-fill');

        // Actions
        google.charts.load('current', {
          'packages': ['geochart'],
          'mapsApiKey': API_KEY
        });

        google.charts.setOnLoadCallback(drawRegionsMap);

        function drawRegionsMap() {
          var chart = new google.visualization.GeoChart($this[0]),
            data = google.visualization.arrayToDataTable(optData),
            options = {
              backgroundColor: {}
            };

          if (optBGColor) {
            options.backgroundColor.fill = optBGColor;
          }

          if (optRegion) {
            options.region = optRegion;
          }

          chart.draw(data, options);

          resizeSensor.create(el, function () {
            chart.draw(data, options);
          });
        }

        //Actions
        collection = collection.add($(el));
      });
    }
  };
})(jQuery);
