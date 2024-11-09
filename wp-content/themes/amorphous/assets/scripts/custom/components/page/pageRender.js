import React from "react";
import PropTypes from "prop-types";

const PageRender = ({page}) => {
    console.log(page, 'page');
    return (
        <div className="columns">
            <div className="column">
                <h2>{page.title.rendered}</h2>
                <div dangerouslySetInnerHTML={{__html: page.content.rendered}}></div>
            </div>
        </div>
    )
};

export default PageRender;