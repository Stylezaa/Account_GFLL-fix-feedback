import React from "react";

const SubTitleReportCompnent = ({ type, data }) => {
    return (
        <>
            <div className="row container">
                <div className="col-lg-2 col-md-2 col-sm-2">ອິງຕາມ</div>
                <div
                    className="col-lg-5 col-md-5 col-sm-5"
                    style={{
                        border: "1px solid #000",
                    }}
                >
                    {data[0].Refer ?? ""}
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
                        border: "1px solid #000",
                    }}
                >
                    {data[0].ReferDt
                        ? new Date(data[0].ReferDt).toLocaleDateString(
                              "en-GB",
                              {
                                  day: "2-digit",
                                  month: "2-digit",
                                  year: "numeric",
                              }
                          )
                        : ""}
                </div>

                {type === "clear_advance" || type === "advance" ? (
                    <>
                        <div className="col-lg-1 col-md-1 col-sm-1"></div>
                        <div className="col-lg-3 col-md-3 col-sm-3">
                            ເລກທີເງິນລ່ວງໜ້າ: {data[0].AdvanceNo ?? ""}
                        </div>
                        <div
                            className="col-lg-3 col-md-3 col-sm-3"
                            style={{
                                display: "flex",
                                justifyContent: "end",
                            }}
                        >
                            ເລີ່ມວັນທີ:{" "}
                            {data[0].Act_FDt
                                ? new Date(data[0].Act_FDt).toLocaleDateString(
                                      "en-GB",
                                      {
                                          day: "2-digit",
                                          month: "2-digit",
                                          year: "numeric",
                                      }
                                  )
                                : ""}
                        </div>
                        <div
                            className="col-lg-3 col-md-3 col-sm-3"
                            style={{
                                display: "flex",
                                justifyContent: "end",
                            }}
                        >
                            ຫາວັນທີ Date:{" "}
                            {data[0].Act_TDt
                                ? new Date(data[0].Act_TDt).toLocaleDateString(
                                      "en-GB",
                                      {
                                          day: "2-digit",
                                          month: "2-digit",
                                          year: "numeric",
                                      }
                                  )
                                : ""}
                        </div>
                        <div className="col-lg-2 col-md-2 col-sm-2"></div>
                    </>
                ) : null}

                <div className="col-lg-2 col-md-2 col-sm-2">ຈ່າຍໃຫ້ :</div>
                <div
                    className="col-lg-10 col-md-10 col-sm-10"
                    style={{
                        border: "1px solid #000",
                    }}
                >
                    {data[0].Pay_to ?? ""}
                </div>
            </div>
        </>
    );
};

export default SubTitleReportCompnent;
