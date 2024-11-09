/*global themeApi */
import React, {Component} from "react";
import ReactDOM from "react-dom";
import Sticky from "react-sticky-el";

class StickyContainer extends Component {

    render() {
        const hasAdminBar = document.body.classList.contains( 'admin-bar' );
        let stickyStyle = {
            zIndex: 5,
            top: 0
        };

        hasAdminBar ? stickyStyle.top = '32px' : stickyStyle.top = 0;

        return (
            <div className="holder">
                <div className="scroll-wrapper">
                    <Sticky topOffset={60} stickyStyle={stickyStyle}>
                        <div className="navbar">
                            <div className="container">
                                <div className="navbar-brand">
                                    <a className="navbar-item" href="/">Amorphous Web Solutions</a>
                                </div>
                                <div className="navbar-menu">
                                    <ul className="navbar-menu navbar-end">
                                        <li><a className="navbar-item" href="http://amorphous.local/about/">About</a></li>
                                        <li><a className="navbar-item" href="http://amorphous.local/code/">Code</a></li>
                                        <li><a className="navbar-item" href="http://amorphous.local/portfolio/">Portfolio</a></li>
                                        <li><a className="navbar-item" href="http://amorphous.local/contact/">Contact</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </Sticky>
                </div>
            </div>
        )
    }
}

ReactDOM.render( <StickyContainer />, document.getElementById('sticky-span'));