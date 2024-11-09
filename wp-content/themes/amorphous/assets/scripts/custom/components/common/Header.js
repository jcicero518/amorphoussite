import React from "react";
import PropTypes from "prop-types";
import { BrowserRouter as Router, Redirect, Switch, Route, Link, NavLink } from "react-router-dom";

import LoadingDots from "./LoadingDots";

const Header = ({loading}) => {

    return (
        <nav className="navbar">
            <div className="container">
                <div className="navbar-brand">
                    <a className="navbar-item" href="http://bulma.io">
                        <img src="http://bulma.io/images/bulma-logo.png" alt="Bulma: a modern CSS framework based on Flexbox" width="112" height="28" />
                    </a>
                </div>
                <div className="navbar-menu">
                    <NavLink to="/" activeClassName="active" className="navbar-item">Home</NavLink>
                    {" | "}
                    <NavLink to="/about" activeClassName="active" className="navbar-item">About</NavLink>
                    {loading && <LoadingDots interval={100} dots={20} />}
                </div>
            </div>
        </nav>
    );
};

Header.propTypes = {
    loading: PropTypes.bool.isRequired
};

export default Header;