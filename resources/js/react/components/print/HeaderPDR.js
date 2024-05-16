import React from "react";

const HeaderPDR = ({ data }) => {
    return (
        <>
            <div
                style={{
                    textAlign: "center",
                }}
            >
                {data[0].Lao1 ?? ""}
            </div>
            <div
                style={{
                    textAlign: "center",
                }}
            >
                {data[0].Lao2 ?? ""}
            </div>
        </>
    );
};

export default HeaderPDR;
