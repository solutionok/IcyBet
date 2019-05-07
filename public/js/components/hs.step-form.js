/**
 * Step form wrapper.
 *
 * @author Htmlstream
 * @version 1.0
 *
 */
var isEmpty = function isEmpty(f) {
    return (/^function[^{]+\{\s*\}/m.test(f.toString()));
  }

;(function ($) {
  'use strict';

  $.HSCore.components.HSStepForm = {
    /**
     *
     *
     * @var Object _baseConfig
     */
    _baseConfig: {
      dotTemplate: '<a class="dots-item rounded-circle mx-1" href="#!"></a>',
      activeClass: 'active',
      currentStep: 0,
      validate: function () {}
    },

    /**
     *
     *
     * @var jQuery pageCollection
     */
    pageCollection: $(),

    /**
     * Initialization of Step form wrapper.
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

      this.initStepForm();

      return this.pageCollection;

    },

    initStepForm: function () {
      //Variables
      var $self = this,
        config = $self.config,
        collection = $self.pageCollection;

      //Actions
      this.collection.each(function (i, el) {
        //Variables
        var $this = $(el),
          currentStep = $this.data('current-step'),
          stepsSelector = $this.data('steps-selector'),
          stepsLength = $(stepsSelector).length,
          counterSelector = $this.data('counter-selector'),
          dotsSelector = $this.data('dots-selector'),
          dotTemplate = config.dotTemplate,
          nextSelector = $this.data('next-selector'),
          submitSelector = $this.data('submit-selector');

        $self.createCounter(stepsLength, config.currentStep, counterSelector);

        $self.createDots(stepsLength, config.currentStep, dotsSelector, dotTemplate);

        $self.changeDotsActiveClassByArrows(stepsLength, nextSelector, dotsSelector);

        $self.changeDotsActiveClassByDots(dotsSelector);

        $self.changeCounterStateByArrows(stepsLength, nextSelector, counterSelector);

        $self.changeCounterStateByDots(stepsLength, dotsSelector, counterSelector);

        $self.changeStepVisibilityByArrows(stepsLength, nextSelector, stepsSelector);

        $self.changeStepVisibilityByDots(stepsLength, dotsSelector, stepsSelector);

        $self.changeButtonToSubmit(stepsLength, nextSelector, dotsSelector, submitSelector);

        //Actions
        collection = collection.add($this);
      });
    },

    createCounter: function (length, current, counter) {
      $(counter).text((current + 1) + ' of ' + length);
    },

    createDots: function (length, current, dots, template) {
      var activeClass = this.config.activeClass;

      for (var i = 0; i < length; i++) {
        if (i === current) {
          $(template).addClass(activeClass).appendTo($(dots));
        } else {
          $(template).appendTo($(dots));
        }
      }
    },

    changeDotsActiveClassByArrows: function (length, next, dots) {
      var $self = this,
        activeClass = $self.config.activeClass;

      $(next).on('click', function (e) {
        e.preventDefault();

        if ($self.config.currentStep + 1 < length && isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $self.config.currentStep += 1;

            $(dots).children().removeClass(activeClass);
            $(dots).children().eq($self.config.currentStep).addClass(activeClass);
          }
        } else if ($self.config.currentStep + 1 < length) {
          $self.config.currentStep += 1;

          $(dots).children().removeClass(activeClass);
          $(dots).children().eq($self.config.currentStep).addClass(activeClass);
        }
      });
    },

    changeDotsActiveClassByDots: function (dots) {
      var $self = this,
        activeClass = $self.config.activeClass;

      $(dots).children().on('click', function (e) {
        e.preventDefault();

        var index = $(this).index();

        if (isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $(dots).children().removeClass(activeClass);
            $(dots).children().eq(index).addClass(activeClass);

            $self.config.currentStep = index;
          }
        } else {
          $(dots).children().removeClass(activeClass);
          $(dots).children().eq(index).addClass(activeClass);

          $self.config.currentStep = index;
        }
      });
    },

    changeCounterStateByArrows: function (length, next, counter) {
      var $self = this;

      $(next).on('click', function (e) {
        e.preventDefault();

        if ($self.config.currentStep < length && isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $(counter).text(($self.config.currentStep + 1) + ' of ' + length);
          }
        } else if ($self.config.currentStep < length) {
          $(counter).text(($self.config.currentStep + 1) + ' of ' + length);
        }
      });
    },

    changeCounterStateByDots: function (length, dots, counter) {
      var $self = this;

      $(dots).children().on('click', function (e) {
        e.preventDefault();

        var index = $(this).index();

        if (isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $(counter).text((index + 1) + ' of ' + length);
          }
        } else {
          $(counter).text((index + 1) + ' of ' + length);
        }
      });
    },

    changeStepVisibilityByArrows: function (length, next, step) {
      var $self = this;

      $(next).on('click', function (e) {
        e.preventDefault();

        if ($self.config.currentStep < length && isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $(step).hide();
            $(step).eq($self.config.currentStep).show();
          }
        } else if ($self.config.currentStep < length) {
          $(step).hide();
          $(step).eq($self.config.currentStep).show();
        }
      });
    },

    changeStepVisibilityByDots: function (length, dots, step) {
      var $self = this;

      $(dots).children().on('click', function (e) {
        e.preventDefault();

        if (isEmpty($self.config.validate) !== true) {
          if($self.config.validate() === true) {
            $(step).hide();
            $(step).eq($self.config.currentStep).show();
          }
        } else {
          $(step).hide();
          $(step).eq($self.config.currentStep).show();
        }
      });
    },

    changeButtonToSubmit: function (length, next, dots, submit) {
      var $self = this;

      $(dots).children().on('click', function (e) {
        e.preventDefault();

        if ($self.config.currentStep === length - 1) {
          $(next).hide();
          $(submit).show();
        } else {
          $(next).show();
          $(submit).hide();
        }
      });

      $(next).on('click', function (e) {
        e.preventDefault();

        if ($self.config.currentStep === length - 1) {
          $(next).hide();
          $(submit).show();
        } else {
          $(next).show();
          $(submit).hide();
        }
      });
    }

  };

})(jQuery);
