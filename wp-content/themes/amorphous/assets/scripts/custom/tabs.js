/*global themeApi */

class Tabs {

    constructor() {
        this.$root = document.querySelector( '[data-tabs-root]' );
        this.$tabs = this.$root.querySelectorAll( '.tab' );
        this.activeTab = null;

        this.$root.addEventListener( 'click', this.onTabClick.bind( this ) );

        this.onTabClick = this.onTabClick.bind( this );
        this.showTab = this.showTab.bind( this );
        this.hideTab = this.hideTab.bind( this );

        this.getActiveTab();
    }

    setActiveTab( tab ) {
        if ( !tab instanceof Element ) {
            return false;
        }
        this.activeTab = tab.getAttribute( 'id' );

        if ( localStorage ) {
            localStorage.setItem( 'js.activeTabId', this.activeTab );
        }
    }

    getActiveTab() {
        let tabId;
        if ( localStorage ) {
            tabId = this.activeTab = localStorage.getItem( 'js.activeTabId' ) ? localStorage.getItem( 'js.activeTabId' ) : 'site_tab_0';
        } else {
            tabId = 'site_tab_0';
        }

        this.activeTab = document.getElementById( tabId );
        this.showTab( this.activeTab );
    }

    onTabClick( event ) {
        let clickTarget = event.target;
        let tab = clickTarget.nodeName === 'SPAN' ? clickTarget.parentElement : event.target;
        if ( !tab.classList.contains( 'tab' ) ) {
            return false;
        }

        event.preventDefault();
        console.log(this, 'this tab click');

        let selected = tab.getAttribute( 'aria-selected' ) === 'true';
        selected ? this.hideTab( tab ) : this.showTab( tab );
    }

    showTab( tab ) {
        let
            contentControls = tab.getAttribute( 'aria-controls'),
            tabParent = tab.parentElement;

        tab.setAttribute( 'aria-selected', true );
        this.setActiveTab( tab );
        tabParent.classList.add( 'is-active' );

        this.$tabs.forEach( t => {
            if ( t.getAttribute( 'aria-controls') !== contentControls ) {
                t.setAttribute( 'aria-selected', false );
                t.parentElement.classList.remove( 'is-active' );
            }
        });

        let tabPanels = this.$root.querySelectorAll( '.tab-panel' );
        tabPanels.forEach( panel => {
           panel.getAttribute( 'aria-controls' ) === contentControls
               ? panel.setAttribute( 'aria-hidden', false )
               : panel.setAttribute( 'aria-hidden', true );
        });
    }

    hideTab( tab ) {
        let
            contentControls = tab.getAttribute( 'aria-controls'),
            tabParent = tab.parentElement;

        tab.setAttribute( 'aria-selected', false );
        tabParent.classList.remove( 'is-active' );

        let tabPanels = this.$root.querySelectorAll( '.tab-panel' );
        tabPanels.forEach( panel => {
            panel.getAttribute( 'aria-controls' ) === contentControls
                ? panel.setAttribute( 'aria-hidden', true )
                : panel.setAttribute( 'aria-hidden', false );
        });
    }
}

if ( document.querySelector( '[data-tabs-root]' ) ) {
    new Tabs();
}