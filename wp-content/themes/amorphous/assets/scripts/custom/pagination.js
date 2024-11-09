/*global themeApi, settings */
import DataStore from "./DataStore";
import codePostTpl from "../../templates/codePost.hbs";

const pageContainer = document.querySelector( '.pagination' );
const boxContainer = document.getElementById( 'content-inner-replace' );

class Pagination {

    constructor() {
        const {slug, term_id} = settings.queriedObject;
        this.dataStore = new DataStore({
            postType: 'card',
            categoryId: term_id,
            category: slug
        });

        this.pageLinks = this.parsePageLinks();
        this.watchLinks();
    }

    /**
     * Run link filter again on links added to the DOM after a page change.
     * Re-attaches click event listeners
     */
    reAttachPageLinks() {
        this.pageLinks = this.parsePageLinks();
        this.watchLinks();
    }

    /**
     * Filters pagination links down to ones that explicitly have
     * a page number value or contains a "prev" / "next" class
     *
     * @returns {Array.<T>}
     */
    parsePageLinks() {
        if ( pageContainer ) {
            return [...pageContainer.querySelectorAll( 'a')].filter( link => {
                return ( link.className.match(/prev|next/) || link.innerHTML.match(/\d{1,}/) );
            });
        }
    }

    /**
     * Handles actual rendering of "box" markup.
     *
     * Loops through existing "boxes" and removes them in anticipation of new data.
     *
     * Loops through post data and applies to Handlebars template before inserting
     * them into the DOM.
     *
     * Finally, loop through "boxes" and toggles hidden / visible classes for a bit
     * of a transition delay.
     *
     * @param payload
     */
    renderPage( payload ) {
        let boxChildren = boxContainer.children;
        if ( boxChildren.length ) {
            [...boxChildren].forEach( box => boxContainer.removeChild( box ) );
        }
        payload.forEach( (post, iterator) => {
            let eachTemplate = codePostTpl( post );
            boxContainer.insertAdjacentHTML('beforeend', eachTemplate);
        });
        let all = boxContainer.querySelectorAll( '.box' );
        all.forEach( box => {
            box.classList.remove( 'hidden' );
            box.classList.add( 'visible' );
        })
    }

    /**
     * Renders pagination after page change. Removes pageContainer's
     * first child - UL element - and adds updated paginate_links() markup.
     *
     * @param payload
     */
    renderPagination( payload ) {
        pageContainer.removeChild( pageContainer.children[0] );
        pageContainer.insertAdjacentHTML( 'beforeend', payload );
        this.reAttachPageLinks();
    }

    /**
     * Calls data store methods to render page "boxes" based on
     * new page and renders pagination with updated markup.
     *
     * @param pageNum
     */
    getPage( pageNum ) {
        // Set page number in data store then renders updated pagination when necessary
        this.dataStore.setPage( pageNum ).then( payload => {
            if ( payload === null ) return false;
            this.renderPagination( payload );
        }).catch( err => {
            console.warn( err );
        });
        // Retrieve page data from data store via promise and renders "boxes".
        this.dataStore.getPage().then( payload => {
            this.renderPage( payload );
        }).catch( err => {
            console.warn( err );
        });
    }

    /**
     * Loops through all defined pagination links and attaches an event listener
     * for click events. Determines new page to transition to based on regex match
     * of page number integer found in markup or href attribute.
     */
    watchLinks() {
        this.pageLinks.forEach( link => {
            link.addEventListener( 'click', e => {
                e.preventDefault();
                let newPage = link.innerHTML.match(/\d{1,}/) ? link.innerHTML : link.getAttribute( 'href').match(/\d{1,}/)[0];

                this.getPage( newPage );
            });
        })
    }
}

// Instantiate class only if we have a pagination element available
if ( pageContainer && boxContainer ) {
    const pagination = new Pagination().getPage(1);
}
