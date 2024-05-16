import React from "react";

const PaymentDetailComponent = ({ data }) => {
    return (
        <>
            <div
                style={{
                    display: "flex",
                    justifyContent: "space-between",
                    padding: "0px 100px 0px 50px",
                    margin: "10px 0px",
                }}
            >
                <div>ຈ່າຍໂດຍ</div>
                <div>
                    <input
                        type="checkbox"
                        checked={
                            data && data[0].PaidCash === "1" ? true : false
                        }
                    />{" "}
                    Cash
                </div>
                <div>
                    <input
                        type="checkbox"
                        checked={
                            data && data[0].PaidCash === "0" ? true : false
                        }
                    />{" "}
                    Cheque
                </div>
                <div>ເລກທີ No.: {data[0].ChequeNo ?? ""}</div>
                <div>
                    ວັນທີ Date:{" "}
                    {data[0].ChequeDt
                        ? new Date(data[0].ChequeDt).toLocaleDateString(
                              "en-GB",
                              {
                                  day: "2-digit",
                                  month: "2-digit",
                                  year: "numeric",
                              }
                          )
                        : ""}
                </div>
            </div>
        </>
    );
};

export default PaymentDetailComponent;
