import React from "react";
import PropTypes from "prop-types";

const PageLanding = ({ sidebar_content }) => {
    return (
        <div className="belowForm" dangerouslySetInnerHTML={ { __html: sidebar_content} }></div>
    );
};

export default PageLanding;