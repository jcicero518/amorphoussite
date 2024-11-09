/* global $, AccExpander */
(function( $ ) {
  var AccExpander = AccExpander || {};
  var
    configMap = {
        accord_template : '.ucmm_accordion',
        accord_class : '.ucmm_accordion_instance',
        accord_icons : {
            header: 'ui-icon-triangle-1-s',
            activeHeader: 'ui-icon-triangle-1-n'
        },
        accord_read_more : {
            template: '.ucmm_read_more',
            more : '<a href>&raquo; Read more</a>',
            less : '<a href>&raquo; Read less</a>'
        },
        current_acc : AccExpander || {}
    },
    AccMap = {
      settable : {
        active: false,
        collapsible : true,
        header : '> li > :first-child,> :not(li):even',
        heightStyle : 'content',
          icons : false
      }
    },
    stateMap = {
      read_more_state : 'closed'
    },
    jqueryMap = {},

    initAccordion, onAccordionActivate, setJqueryMap, initModule;

  initAccordion = function( elem ) {
    var
      settable = AccMap.settable,
      widget;

    widget = $( elem ).accordion( settable );
    return widget;
  };

  onAccordActivate = function(event, ui) {
    var
      $readMore = configMap.accord_read_more,
      targetAccord = $( event.target );

    if ( targetAccord.accordion( 'option', 'active' ) !== false ) {
      $( this ).find( $readMore.template ).html( $readMore.less );
    } else {
      $( this ).find( $readMore.template ).html( $readMore.more );
    }
  };

  setJqueryMap = function() {
    var $accordInstance = $( configMap.accord_class );

    jqueryMap = {
      $accordInstances : $accordInstance
    };
  };

  initModule = function() {
      var
          $accElems = $(configMap.accord_class),
          acc_read_more = configMap.accord_read_more.template,
          read_more_state = stateMap.read_more_state,
          widgetInstances = [];

      setJqueryMap();

      if ( jqueryMap.$accordInstances.length ) {
          jqueryMap.$accordInstances.each(function(key) {
              var $this = $( this );
              $.gevent.subscribe( $this, 'accordionactivate', onAccordActivate );
              widgetInstances[key] = initAccordion( '#' + $this.attr( 'id' ) );
          });

          $accElems.wrapAll('<div data-equalizer-watch="matchColumns" class="accordion accordion-container" />');
      }
  };

  $(function() {
      initModule();
  });

})( jQuery );
