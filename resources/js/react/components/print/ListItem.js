import React from "react";

const ListItem = ({ data }) => {
    return (
        <>
            <div>
                <table
                    style={{
                        width: "100%",
                        borderCollapse: "collapse",
                        border: "1px solid black",
                    }}
                >
                    <thead>
                        <tr>
                            <th
                                style={{
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ລຳດັບ
                            </th>
                            <th
                                style={{
                                    maxWidth: "300px",
                                    minWidth: "300px",
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
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                1
                            </td>
                            <td
                                style={{
                                    maxWidth: "300px",
                                    minWidth: "300px",
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
                                {data[0].Voucher_LAK ? parseFloat(data[0].Voucher_LAK).toLocaleString() : ""}
                            </td>
                            <td
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].Rate ? parseFloat(data[0].Rate).toLocaleString() : ""}
                            </td>
                            <td
                                style={{
                                    maxWidth: "125px",
                                    minWidth: "125px",
                                    textAlign: "center",
                                }}
                            >
                                {data[0].Voucher_USD ? parseFloat(data[0].Voucher_USD).toLocaleString() : ""}

                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </>
    );
};

export default ListItem;
