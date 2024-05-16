import React from "react";

const SubHeader = ({ data, type }) => {
    return (
        <>
            <div className="row">
                <div className="col-lg-12 col-md-12 col-sm-12">
                    {data[0].Ministry ?? ""}
                </div>
                <div className="col-lg-12 col-md-12 col-sm-12">
                    {data[0].Department ?? ""}
                </div>

                <div className="col-lg-7 col-md-7 col-sm-7">
                    {data[0].Project ?? ""}
                </div>

                <div
                    className="col-lg-2 col-md-2 col-sm-2"
                    style={{
                        display: "flex",
                        justifyContent: "end",
                    }}
                >
                    ເລກທີ No.:
                </div>
                <div
                    className="col-lg-3 col-md-3 col-sm-3"
                    style={{
                        // display: "flex",
                        // justifyContent: "end",
                        border: "1px solid #000",
                    }}
                >
                    {data[0].VoucherNo ?? ""}
                </div>

                <div className="col-lg-7 col-md-7 col-sm-7">
                    {data[0].Implement ?? ""}
                </div>

                <div
                    className="col-lg-2 col-md-2 col-sm-2"
                    style={{
                        display: "flex",
                        justifyContent: "end",
                    }}
                >
                    ວັນທີ Date:
                </div>

                <div
                    className="col-lg-3 col-md-3 col-sm-3"
                    style={{
                        // display: "flex",
                        // justifyContent: "end",
                        border: "1px solid #000",
                    }}
                >
                    {data[0].VoucherDt
                        ? new Date(data[0].VoucherDt).toLocaleDateString(
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

export default SubHeader;
