import {lory} from "lory.js";

const sliderContainer = document.querySelector( '.js_slider' );

class Slider {

    constructor( sliderOptions ) {
        const defaultOptions = {
            rewind: true,
            infinite: 1
        };

        this.sliderOptions = Object.assign( defaultOptions, sliderOptions );
        this.slider = lory( sliderContainer, this.sliderOptions );
    }
}

// Conditionally load slider - if sliderContainer element exists
if ( sliderContainer ) {
    console.log(sliderContainer);
    // optionally pass in object to add / override default options
    document.addEventListener( 'DOMContentLoaded', () => {
        new Slider();
    });
}