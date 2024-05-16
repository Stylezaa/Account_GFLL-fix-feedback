import React from "react";

const TextAlert = ({ text, value = null, isShow = true }) => {
    return (
        <>
            {!value && isShow ? (
                <span className="text-danger">{text}</span>
            ) : null}
        </>
    );
};

export default TextAlert;
