import React from "react";

const JournalEnterComponent = ({ data }) => {
    return (
        <div>
            <div>ບັນທຶກການລົງບັນຊີປະຈຳວັນ Journal Enter</div>
            <div>
                <table
                    style={{
                        width: "100%",
                        borderCollapse: "collapse",
                        border: "1px solid black",
                        textAlign: "center",
                        fontSize: "11px",
                    }}
                >
                    <thead>
                        <tr>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ເລກບັນຊີ
                                <br />
                                Acc
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ກິດຈະກຳ
                                <br />
                                Activity
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ຮ່ວງ
                                <br />
                                Cat.
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ແຫ່ຼງທຶນ
                                <br />
                                SOF
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ຫ້ອງການ
                                <br />
                                Cost center
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "50px",
                                    maxWidth: "50px",
                                    textAlign: "center",
                                }}
                            >
                                ບ້ານ, ເມືອງ, ແຂວງ
                                <br />
                                Sub-Cost center
                            </th>
                            <th
                                rowSpan={2}
                                style={{
                                    minWidth: "75px",
                                    maxWidth: "75px",
                                    textAlign: "center",
                                }}
                            >
                                ລາຍການ
                                <br />
                                Description
                            </th>
                            <th
                                colSpan={2}
                                style={{
                                    minWidth: "75px",
                                    maxWidth: "75px",
                                    textAlign: "center",
                                }}
                            >
                                ຈຳນວນເງິນກີບ
                                <br />
                                Amount LAK
                            </th>
                            <th
                                colSpan={2}
                                style={{
                                    minWidth: "75px",
                                    maxWidth: "75px",
                                    textAlign: "center",
                                }}
                            >
                                ຈຳນວນເງິນໂດລາ
                                <br />
                                Amount USD
                            </th>
                        </tr>
                        <tr>
                            <th
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                ໜີ້ Debit
                            </th>
                            <th
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                ມີ Credit
                            </th>
                            <th
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                ໜີ້ Debit
                            </th>
                            <th
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                ມີ Credit
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {/*
                                {data[0].Voucher_USD ? parseFloat(data[0].Voucher_USD).toLocaleString() : ""}
                        */}
                        {data && data.length > 0 ? (
                            data.map((item, index) => (
                                <tr
                                    key={index}
                                    style={{
                                        verticalAlign: 'top',
                                        height:
                                            index === data.length - 1
                                                ? "300px"
                                                : "auto",
                                    }}
                                >
                                    <td>{item.AccountCD}</td>
                                    <td>{item.ActivityID}</td>
                                    <td>{item.CategoryID}</td>
                                    <td>{item.DonorID}</td>
                                    <td>{item.CCtrID}</td>
                                    <td>{item.SCCtrID}</td>
                                    <td>{item.ItemDescription}</td>

                                    <td>
                                        {item.LAK_Dr
                                            ? parseFloat(
                                                  item.LAK_Dr
                                              ).toLocaleString()
                                            : ""}
                                    </td>
                                    <td>
                                        {item.LAK_Cr
                                            ? parseFloat(
                                                  item.LAK_Cr
                                              ).toLocaleString()
                                            : ""}
                                    </td>
                                    <td>
                                        {item.USD_Dr
                                            ? parseFloat(
                                                  item.USD_Dr
                                              ).toLocaleString()
                                            : ""}
                                    </td>
                                    <td>
                                        {item.USD_Cr
                                            ? parseFloat(
                                                  item.USD_Cr
                                              ).toLocaleString()
                                            : ""}
                                    </td>
                                </tr>
                            ))
                        ) : (
                            <tr>
                                <td colSpan={11}>No data</td>
                            </tr>
                        )}

                        {data && data.length > 0 ? (
                            <tr>
                                <td colSpan={7}>ລວມຍອດ total:</td>
                                <td>
                                    {data && data.length > 0
                                        ? data
                                              .reduce(
                                                  (acc, cur) =>
                                                      acc +
                                                      parseFloat(cur.LAK_Dr),
                                                  0
                                              )
                                              .toLocaleString()
                                        : ""}
                                </td>
                                <td>
                                    {data && data.length > 0
                                        ? data
                                              .reduce(
                                                  (acc, cur) =>
                                                      acc +
                                                      parseFloat(cur.LAK_Cr),
                                                  0
                                              )
                                              .toLocaleString()
                                        : ""}
                                </td>
                                <td>
                                    {data && data.length > 0
                                        ? data
                                              .reduce(
                                                  (acc, cur) =>
                                                      acc +
                                                      parseFloat(cur.USD_Dr),
                                                  0
                                              )
                                              .toLocaleString()
                                        : ""}
                                </td>
                                <td>
                                    {data && data.length > 0
                                        ? data
                                              .reduce(
                                                  (acc, cur) =>
                                                      acc +
                                                      parseFloat(cur.USD_Cr),
                                                  0
                                              )
                                              .toLocaleString()
                                        : ""}
                                </td>
                            </tr>
                        ) : (
                            <tr>
                                <td colSpan={11}>No data</td>
                            </tr>
                        )}
                    </tbody>
                </table>
            </div>
        </div>
    );
};

export default JournalEnterComponent;
