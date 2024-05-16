import React from "react";

const AmountLetterComponent = ({ data }) => {
    return (
        // <div className="my-4">ຈຳນວນເປັນຕົວໜັງສື: {data[0].AmtLetter ?? ""}</div>
        <>
            <div>
                <table
                    style={{
                        width: "100%",
                        borderCollapse: "collapse",
                        border: "1px solid black",
                        fontSize: "11px",
                    }}
                >
                    <thead>
                        <tr>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    textAlign: "center",
                                    borderTop: "1px solid transparent",
                                    borderLeft: "1px solid transparent",
                                    borderBottom: "1px solid transparent",
                                }}
                            >
                                ຈຳນວນເປັນຕົວໜັງສື Amounth in letter:
                            </th>
                            <th
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                }}
                            >
                                {data[0].AmtLetter ?? ""}
                            </th>
                        </tr>
                        <tr>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    textAlign: "center",
                                    borderTop: "1px solid transparent",
                                    borderLeft: "1px solid transparent",
                                    borderBottom: "1px solid transparent",
                                }}
                            >
                            </th>
                            <th
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                }}
                            >
                                -
                            </th>
                        </tr>
                    </thead>
                </table>
            </div>
        </>
    );
};

export default AmountLetterComponent;
