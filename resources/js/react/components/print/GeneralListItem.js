import React from "react";

const GeneralListItem = ({ data }) => {
    return (
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
                                    textAlign: "center",
                                    borderTop: "1px solid transparent",
                                    borderLeft: "1px solid transparent",
                                    borderBottom: "1px solid transparent",
                                }}
                            >
                                ອີງຕາມ Refer:
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                }}
                                colSpan={2}
                            >
                                {data[0].Refer ?? ""}
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "end",
                                    borderTop: "1px solid transparent",
                                }}
                            >
                                ວັນທີ Date:
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].ReferDt
                                    ? new Date(
                                          data[0].ReferDt
                                      ).toLocaleDateString("en-GB", {
                                          day: "2-digit",
                                          month: "2-digit",
                                          year: "numeric",
                                      })
                                    : ""}
                            </th>
                        </tr>
                        <tr>
                            <th
                                style={{
                                    textAlign: "center",
                                    borderTop: "1px solid transparent",
                                    borderLeft: "1px solid transparent",
                                    borderBottom: "1px solid transparent",
                                }}
                            >
                                ຈ່າຍໃຫ້ Pay to:
                            </th>
                            <th
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                }}
                                colSpan={5}
                            >
                                {data[0].Pay_to ?? ""}
                            </th>
                        </tr>
                        <tr>
                            <th
                                style={{
                                    textAlign: "center",
                                    borderTop: "1px solid transparent",
                                    borderLeft: "1px solid transparent",
                                    borderRight: "1px solid transparent",
                                }}
                            >
                                ຈ່າຍໂດຍ Pay by:
                            </th>
                            <th
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                    textAlign: "center",
                                }}
                            >
                                <div
                                    style={{
                                        display: "flex",
                                        justifyContent: "space-between",
                                    }}
                                >
                                    <div>
                                        <input
                                            type="checkbox"
                                            checked={
                                                data && data[0].PaidCash === "1"
                                                    ? true
                                                    : false
                                            }
                                        />{" "}
                                        Cash
                                    </div>
                                    <div>
                                        <input
                                            type="checkbox"
                                            checked={
                                                data && data[0].PaidCash === "0"
                                                    ? true
                                                    : false
                                            }
                                        />{" "}
                                        Cheque
                                    </div>
                                    <div>ເລກທີເຊັກ Cheque No.:</div>
                                </div>
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].ChequeNo ?? ""}
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                ວັນທີເຊັກ Cheque Date.:
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].ChequeDt
                                    ? new Date(
                                          data[0].ChequeDt
                                      ).toLocaleDateString("en-GB", {
                                          day: "2-digit",
                                          month: "2-digit",
                                          year: "numeric",
                                      })
                                    : ""}
                            </th>
                        </tr>
                        <tr>
                            <th
                                style={{
                                    minWidth: "100px",
                                    textAlign: "center",
                                }}
                            >
                                ລຳດັບ
                            </th>
                            <th
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                    textAlign: "center",
                                }}
                            >
                                ລາຍການ
                                <br />
                                Description
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                ຈຳນວນເງິນກີບ
                                <br />
                                Amount Kip
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                ອັດຕາແລກປ່ຽນ
                                <br />
                                Exchange Rate
                            </th>
                            <th
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                ຈຳນວນເງິນໂດລາ
                                <br />
                                Amount USD
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                1
                            </td>
                            <td
                                style={{
                                    maxWidth: "250px",
                                    minWidth: "250px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].DescriptionL ?? ""}
                            </td>
                            <td
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].Voucher_LAK
                                    ? parseFloat(
                                          data[0].Voucher_LAK
                                      ).toLocaleString()
                                    : ""}
                            </td>
                            <td
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].Rate
                                    ? parseFloat(data[0].Rate).toLocaleString()
                                    : ""}
                            </td>
                            <td
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].Voucher_USD
                                    ? parseFloat(
                                          data[0].Voucher_USD
                                      ).toLocaleString()
                                    : ""}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </>
    );
};

export default GeneralListItem;
