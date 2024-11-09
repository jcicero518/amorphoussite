/*global themeApi */
import React, {Component} from "react";
import ReactDOM from "react-dom";
import PropTypes from "prop-types";

class StickyContainer extends Component {

    componentDidMount() {
        const setInitialHeights = elements => {
            [...elements].forEach( el => {
                el.setAttribute( 'data-sticky-initial', el.getBoundingClientRect().top );
            });
        };

        const stickyElems = document.querySelectorAll( '[data-sticky]' );
        setInitialHeights( stickyElems );

        document.addEventListener( 'scroll', () => {
            const top = document.documentElement.scrollTop || document.body.scrollTop;
            const bottom = document.documentElement.scrollHeight || document.body.scrollHeight;

            [...stickyElems].forEach( el => {
                const stickyInitial = parseInt( el.getAttribute( 'data-sticky-initial' ), 10 );
                const stickyEnter = parseInt( el.getAttribute( 'data-sticky-enter'), 10 ) || stickyInitial;
                const stickyExit = parseInt( el.getAttribute( 'data-sticky-exit' ), 10 ) || bottom;

                if ( top >= stickyEnter && top <= stickyExit ) {
                    el.classList.add( 'sticky' );
                } else {
                    el.classList.remove( 'sticky' );
                }
            });
        });
    }

    render() {
        const { stickyClass, enter, exit, children } = this.props;
        return (
            <div className={stickyClass}
                 data-sticky
                 data-sticky-enter={enter}
                 data-sticky-exit={exit}
            >
                {children}
            </div>
        );
    }
}

StickyContainer.propTypes = {
    stickyClass: PropTypes.string,
    enter: PropTypes.string,
    exit: PropTypes.string,
    children: PropTypes.node
};

export default StickyContainer;