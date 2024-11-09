const cardImageFigures = document.querySelectorAll( '.card-image-figure' );

function lazyLoad() {
    [...cardImageFigures].forEach( fig => {
        // full res image
        let fullResImage = fig.getAttribute( 'data-image-full' );
        let imgElement = fig.querySelector( 'img' );

        // swap out with full res image
        imgElement.src = fullResImage;
        // listen for img load event
        imgElement.addEventListener( 'load', () => {
            // swap out when img fully loaded
            fig.style.backgroundImage = `url(${fullResImage})`;
            fig.classList.add( 'is-loaded' );
        });
    });
}

lazyLoad();