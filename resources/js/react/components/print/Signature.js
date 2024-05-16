import React from "react";

const PrintSignatureComponent = ({ queryString }) => {
    console.log("queryString", queryString);

    return (
        <div
            style={{
                display: "flex",
                justifyContent: "space-between",
            }}
        >
            {queryString.signature_1 && (
                <div
                    style={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "start",
                    }}
                >
                    <div>ອະນຸມັດໂດຍ:{queryString.signature_1}</div>
                    <div>
                        verified and approved by:{queryString.signature_1}
                    </div>
                    <div>ວັນທີ/Date:</div>
                </div>
            )}

            {queryString.signature_2 && (
                <div
                    style={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "start",
                    }}
                >
                    <div>ອະນຸມັດໂດຍ:{queryString.signature_2}</div>
                    <div>
                        verified and approved by:{queryString.signature_2}
                    </div>
                    <div>ວັນທີ/Date:</div>
                </div>
            )}

            {queryString.signature_3 && (
                <div
                    style={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "start",
                    }}
                >
                    <div>ອະນຸມັດໂດຍ:{queryString.signature_3}</div>
                    <div>
                        verified and approved by:{queryString.signature_3}
                    </div>
                    <div>ວັນທີ/Date:</div>
                </div>
            )}

            {queryString.signature_4 && (
                <div
                    style={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "start",
                    }}
                >
                    <div>ອະນຸມັດໂດຍ:{queryString.signature_4}</div>
                    <div>
                        verified and approved by:{queryString.signature_4}
                    </div>
                    <div>ວັນທີ/Date:</div>
                </div>
            )}

            {queryString.signature_5 && (
                <div
                    style={{
                        display: "flex",
                        flexDirection: "column",
                        alignItems: "start",
                    }}
                >
                    <div>ອະນຸມັດໂດຍ:{queryString.signature_5}</div>
                    <div>
                        verified and approved by:{queryString.signature_5}
                    </div>
                    <div>ວັນທີ/Date:</div>
                </div>
            )}
        </div>
    );
};

export default PrintSignatureComponent;
