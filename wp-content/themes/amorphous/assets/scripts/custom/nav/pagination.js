
const pageContainer = document.querySelector( '.pagination' );

class Pagination {

    constructor() {
        if ( pageContainer ) {
            this.pageLinks = [...pageContainer.querySelectorAll( 'a')].filter( link => {
                return ( link.hasAttribute( 'href' ) && link.innerHTML.match(/\d{1,}/) );
            });
        }
    }

    watchLinks() {
        this.pageLinks.forEach( link => {
            link.addEventListener( 'click', e => {
                e.preventDefault();
                console.log(link, 'link');
            });
        })
    }
}

export default Pagination;