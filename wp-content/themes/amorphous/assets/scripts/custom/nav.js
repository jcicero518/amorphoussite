/*global themeApi, themeNavMap, settings */
const navBurger = document.querySelector( '.navbar-burger' );
const navMenuContainers = document.querySelectorAll( 'ul.navbar-menu' );
const navMap = Object.assign( {}, themeNavMap );

function maybeHighlightNavItem() {
    const {taxonomy} = settings.queriedObject;
    if ( taxonomy && taxonomy !== undefined ) {
        if ( taxonomy === 'code_category' ) {
            [...navMenuContainers].map( container => {
                let listElem = container.querySelector( `li.${navMap['code']}`);
                if ( ! listElem.classList.contains( 'current-menu-item' ) ) {
                    listElem.classList.add( 'current-menu-item' );
                }
            });
        }
    }
}

navBurger.addEventListener( 'click', event => {
   let
       navButton = event.target,
       navButtonClass = event.target.getAttribute( 'data-target-class' ),
       navTargetElem;

    navButton.classList.contains( 'is-active' )
        ? navButton.classList.remove( 'is-active' )
        : navButton.classList.add( 'is-active' );

    navTargetElem = document.querySelector(`.${navButtonClass}`);

    if ( navTargetElem instanceof Element ) {
        navTargetElem.classList.contains( 'is-active' )
            ? navTargetElem.classList.remove( 'is-active' )
            : navTargetElem.classList.add( 'is-active' );
    }
});

function domReady(cbfn) {
    if (document.readyState != 'loading') {
        cbfn();
    } else {
        document.addEventListener('DOMContentLoaded', cbfn);
    }
}

domReady( maybeHighlightNavItem );