import React from "react";

const CardSummary = ({ title, amount, color }) => {
    return (
        <div
            className="card"
            style={{
                width: "100%",
                height: "100px",
                display: "inline-block",
            }}
        >
            <div className={`card-header p-2 text-center`}>
                <h6>
                    <b>{title}</b>
                </h6>
            </div>
            <div className={`card-body text-center ${color}`}>
                <p>
                    <b>{amount}</b>
                </p>
            </div>
        </div>
    );
};

export default CardSummary;
