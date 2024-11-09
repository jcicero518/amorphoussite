(function($) {
    var
        configMap = {
            id_base: 'related_links_widget',
            elemHiddenClass: 'is-hidden-widget-attrs'
        },
        stateMap = {
            $container : undefined,
            is_open: false,
            is_ours: false,
            widget_attrs: undefined,
            widget_id: undefined
        },
        jqueryMap = {},
        locateToggledWidget, isReady, rowTemplate, addNewRow, setJqueryMap, initModule;

        locateToggledWidget = function ($toggleTarget) {
            var
                $widgetInside,
                $toggleBtn,
                $thisWidget = $toggleTarget.closest('.widget');

            $toggleBtn = $thisWidget.find('.widget-top button.widget-action');
            stateMap.is_open = !( $toggleBtn.parents('.widget').hasClass('open') ); // is immediately changed to close

            $widgetInside = $thisWidget.find('.widget-inside');
            stateMap.is_ours = ( $widgetInside.find('input[name="id_base"]').val() === configMap.id_base );
            stateMap.widget_id = $widgetInside.find('input[name="widget-id"]').val();
        };

        isReady = function () {
            return ( stateMap.is_open && stateMap.is_ours );
        };

        rowTemplate = function() {

        };

        addNewRow = function() {
            var $container = stateMap.$container;
            var $table = $container.find('table');

        };

        setJqueryMap = function() {
            var $container = stateMap.$container;

            jqueryMap = {
                $container: $container,
                $table: $container.find( 'table' ),
                $btnAddRow: $container.find( '.button-add-row' )
            };
        };

        initModule = function () {
            $(document).on('click.widgets-toggle', function (event) {
                var
                    $target = $(event.target),
                    isWidgetHandle = false,
                    isAddBtn = false,
                    ready = false;

                isWidgetHandle = $target.hasClass( 'widget-action' );
                isAddBtn = $target.hasClass( 'button-add-row' );

                if ( isWidgetHandle ) locateToggledWidget( $target );
                stateMap.$container = $target;
                setJqueryMap();

                if ( isAddBtn ) addNewRow();

                if ( isReady() && !( stateMap.widget_attrs ) ) {

                }

                console.log(stateMap, 'state');


            });
        };

    // https://core.trac.wordpress.org/browser/branches/4.8/src/wp-admin/js/widgets.js
    $(function() {
       initModule();
    });

})(jQuery);