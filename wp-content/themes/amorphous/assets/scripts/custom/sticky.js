/*global settings, themeApi, themeNavMap, mainMenu */
import React, {Component} from "react";
import ReactDOM from "react-dom";
import StickyContainer from "./sticky-container";

class Sticky extends Component {

    constructor(props) {
        super(props);
        this.state = {
            __html: mainMenu
        };
        this.onBurgerClick = this.onBurgerClick.bind( this );
    }

    onBurgerClick() {
        const
            menu = document.querySelector( '.sticky .navbar-menu' ),
            burger = document.querySelector( '.sticky .navbar-burger');

        menu.classList.toggle( 'is-active' );
        burger.classList.toggle( 'is-active' );
    }

    render() {
        const menu = { __html: mainMenu };
        const logo = `${themeApi.images}logo-a-white56.png`;
        return (
            <StickyContainer stickyClass="sticky-component" enter="140">
                <div className="navbar main-navigation">
                    <div className="container">
                        <div className="navbar-brand">
                            <a className="navbar-item" href="/"><img alt="Home" src={logo} /></a>
                            <button
                                className="button navbar-burger"
                                data-target-class="navbar-menu"
                                onClick={this.onBurgerClick}>
                                <span></span>
                                <span></span>
                                <span></span>
                            </button>
                        </div>
                        <div className="navbar-menu" dangerouslySetInnerHTML={menu}>
                        </div>
                    </div>
                </div>
            </StickyContainer>
        );
    }
}


ReactDOM.render( <Sticky />, document.getElementById( 'sticky-span' ) );