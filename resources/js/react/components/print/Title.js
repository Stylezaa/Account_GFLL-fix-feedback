import React from "react";

const TitleReportCompnent = ({ data, type }) => {
    return (
        <>
            <div
                style={{
                    textAlign: "center",
                }}
            >
                <h3
                    style={{
                        color: "black",
                    }}
                >
                    <strong>
                        {type === "general"
                            ? "ບັດລົງບັນຊີ"
                            : type === "advance"
                            ? "ບັດລົງບັນຊີເງິນລ່ວງໜ້າ"
                            : type === "clear_advance"
                            ? "ບັດລົງບັນຊີສະສາງເງິນລ່ວງໜ້າ"
                            : "TITLE REPORT"}
                    </strong>
                </h3>
            </div>
        </>
    );
};

export default TitleReportCompnent;
