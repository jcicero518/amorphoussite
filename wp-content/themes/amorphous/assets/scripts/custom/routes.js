import React from "react";
import { BrowserRouter as Router, Route, Link, Switch } from "react-router-dom";
import App from "./components/App";
import HomePage from "./components/home/HomePage";
import AboutPage from "./components/about/AboutPage";
import Main from "./components/Main";

export default (
    <Switch>
        <Route exact path="/" component={HomePage}/>
        <Route path="/about" component={Main}/>
    </Switch>
);


