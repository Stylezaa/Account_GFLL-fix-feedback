import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import PrintSignatureComponent from "../../components/print/Signature";
import HeaderPDR from "../../components/print/HeaderPDR";
import axios from "axios";
import {
    numberFormat,
    numberFormatWithDecimal,
} from "../../utilities/number_formate";

const VoucherLedgerReport = () => {
    const [dataReport, setDataReport] = useState([]);
    const [dataReportTotal, setDataReportTotal] = useState({
        lak_balance_debit: 0,
        lak_balance_credit: 0,
        usd_balance_debit: 0,
        usd_balance_credit: 0,
    });

    const urlParams = new URLSearchParams(window.location.search);

    const queryParams = {
        period_type: urlParams.get("period_type"),
        start_date: urlParams.get("start_date"),
        end_date: urlParams.get("end_date"),
        start_month: urlParams.get("start_month"),
        end_month: urlParams.get("end_month"),
        start_year: urlParams.get("start_year"),
        end_year: urlParams.get("end_year"),
        display_number: urlParams.get("display_number"),
        multiplier: urlParams.get("multiplier"),
        selected_level_id: urlParams.get("selected_level_id"),
        report_title: urlParams.get("report_title"),
        signature_1: urlParams.get("signature_1"),
        signature_2: urlParams.get("signature_2"),
        signature_3: urlParams.get("signature_3"),
        signature_4: urlParams.get("signature_4"),
        signature_5: urlParams.get("signature_5"),
        report_address: urlParams.get("report_address"),
        voucher: urlParams.get("voucher"),
        single_voucher: urlParams.get("single_voucher"),
        activity: urlParams.get("activity"),
        single_activity: urlParams.get("single_activity"),
        category: urlParams.get("category"),
        single_category: urlParams.get("single_category"),
        account: urlParams.get("account"),
        single_account: urlParams.get("single_account"),
        donor: urlParams.get("donor"),
        single_donor: urlParams.get("single_donor"),
        ProvinceID: urlParams.get("ProvinceID"),
        DistrictID: urlParams.get("DistrictID"),
        VillageID: urlParams.get("VillageID"),
        trial_balance_level: urlParams.get("trial_balance_level"),
        is_order_account: urlParams.get("is_order_account"),
        report_type: "voucher_general",
        currency: urlParams.get("currency"),
    };

    const fetchGetDataReport = async () => {
        try {
            const res = await axios.post(`/print/voucher-ledger/data`, {
                ...queryParams,
            });

            if (res.status === 200) {
                setDataReport(res.data.data);
                if (res.data.total) {
                    setDataReportTotal({
                        lak_balance_debit:
                            res.data.total.lak_total_balance_debit,
                        lak_balance_credit:
                            res.data.total.lak_total_balance_credit,
                        usd_balance_debit:
                            res.data.total.usd_total_balance_debit,
                        usd_balance_credit:
                            res.data.total.usd_total_balance_credit,
                    });
                }

                setTimeout(() => {
                    window.print();
                }, 500);
            } else {
                setDataReport([]);
            }
        } catch (error) {
            setDataReport([]);
            console.log("error fetchGetVoucherLedgerReportLevel", error);
        }
    };

    useEffect(() => {
        fetchGetDataReport();
    }, []);

    //close print
    useEffect(() => {
        window.onafterprint = function () {
            window.close();
        };
    }, []);

    const groupedData = dataReport.reduce((groups, data) => {
        const account_cd = data.account_cd;

        if (!groups[account_cd]) {
            groups[account_cd] = [];
        }

        groups[account_cd].push(data);
        return groups;
    }, {});

    return (
        <div
            style={{
                fontFamily: "Phetsarath OT",
                fontSize: "12px",
                margin: "15px 25px",
                color: "black",
                display: "flex",
                flexDirection: "column",
            }}
        >
            <HeaderPDR
                data={[
                    {
                        Lao1: "ສາທາລະນະລັດ ປະຊາທິປະໄຕ ປະຊາຊົນລາວ",
                        Lao2: "ສັນຕິພາບ ເອກະລາດ ປະຊາທິປະໄຕ ເອກະພາບ ວັນທະນາຖາວອນ",
                    },
                ]}
            />

            <div className="row">
                <div className="col-lg-12 col-md-12 col-sm-12">
                    ກະຊວງກະສິກໍາ ແລະ ປ່າໄມ້
                </div>
                <div className="col-lg-12 col-md-12 col-sm-12">ກົມປ່າໄມ້</div>
                <div className="col-lg-12 col-md-12 col-sm-12">
                    ໂຄງການ ຄູ້ມຄອງປ່າໄມ້ແບບພູມິທັດ ແລະ ສົ່ງເສີມຊີວິດການເປັນຢູ່
                    ພາກເໜືອຂອງ ສປປ ລາວ GFLL
                </div>
                <div className="col-lg-12 col-md-12 col-sm-12">-</div>
            </div>

            <div
                style={{
                    textAlign: "center",
                }}
            >
                <h4
                    style={{
                        color: "black",
                    }}
                >
                    <strong>ລາຍງານບັນຊີແຍກປະເພດ</strong>
                </h4>
            </div>

            <div
                style={{
                    textAlign: "center",
                }}
            >
                <h6
                    style={{
                        color: "black",
                    }}
                >
                    <strong>
                        {queryParams.period_type === "daily" ? (
                            <>
                                {"ປະຈຳວັນທີ " +
                                    queryParams.start_date +
                                    " ຫາ " +
                                    queryParams.end_date}
                            </>
                        ) : queryParams.period_type === "monthly" ? (
                            <>
                                {"ປະຈຳເດືອນທີ " +
                                    queryParams.start_month +
                                    " ຫາ " +
                                    queryParams.end_month}
                            </>
                        ) : (
                            <>
                                {"ປະຈຳປີທີ " +
                                    queryParams.start_year +
                                    " ຫາ " +
                                    queryParams.end_year}
                            </>
                        )}
                    </strong>
                </h6>
            </div>

            <div>
                <p
                    style={{
                        float: "right",
                    }}
                >
                    ຕົວຄູນ: <b>{queryParams.multiplier}</b>
                </p>
            </div>
            <div>
                <div>
                    <table
                        style={{
                            width: "100%",
                            borderCollapse: "collapse",
                            border: "1px solid black",
                            paddingLeft: "15px",
                            fontSize: "11px",
                        }}
                    >
                        <thead>
                            <tr
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                <th colSpan={2}>ໃບຢັ້ງຢືນ</th>
                                <th rowSpan={2}>ເນື້ອໃນລາຍການ</th>
                                <th rowSpan={2}>ເລກບັນຊີ</th>
                                <th rowSpan={2}>ແຫຼ່ງທຶນ</th>
                                <th rowSpan={2}>ກິດຈະກໍາ</th>
                                <th rowSpan={2}>ຮ່ວງລາຍຈ່າຍ</th>
                                <th colSpan={3}>ມູນຄ່າລົງບັນຊີ (ກີບ)</th>
                                <th rowSpan={2}>ອັດຕາແລກປ່ຽນ</th>
                                <th colSpan={3}>ມູນຄ່າລົງບັນຊີ (ໂດລາ)</th>
                            </tr>
                            <tr
                                style={{
                                    textAlign: "center",
                                }}
                            >
                                <th>ວັນທີ</th>
                                <th>ເລກທີ</th>
                                <th>ໜີ້</th>
                                <th>ມີ </th>
                                <th>ຍອດຄົງເຫຼືອ</th>
                                <th>ໜີ້</th>
                                <th>ມີ </th>
                                <th>ຍອດຄົງເຫຼືອ</th>
                            </tr>
                        </thead>
                        <tbody>
                            {Object.keys(groupedData).length > 0 ? (
                                Object.entries(groupedData).map(
                                    ([account_cd, group], index) => (
                                        <React.Fragment key={index}>
                                            <tr
                                                style={{
                                                    borderTop:
                                                        "2px solid black",
                                                }}
                                            >
                                                <td
                                                    colSpan={3}
                                                    style={{
                                                        textAlign: "center",
                                                    }}
                                                >
                                                    ຍອດຍົກມາ <b>{account_cd}</b>{" "}
                                                    {group[0].account_name}
                                                </td>
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                            </tr>
                                            {group.map((data, dataIndex) => (
                                                <tr key={dataIndex}>
                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "75px",
                                                        }}
                                                    >
                                                        {data.voucher_date}
                                                    </td>
                                                    <td
                                                        style={{
                                                            minWidth: "75px",
                                                        }}
                                                    >
                                                        {data.voucher_no ?? ""}
                                                    </td>
                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "250px",
                                                        }}
                                                    >
                                                        {data.description}
                                                    </td>

                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "75px",
                                                        }}
                                                    ></td>

                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "50px",
                                                        }}
                                                    >
                                                        {data.donor_id}
                                                    </td>

                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "75px",
                                                        }}
                                                    >
                                                        {data.activity_id}
                                                    </td>

                                                    <td
                                                        style={{
                                                            paddingLeft: "5px",
                                                            minWidth: "50px",
                                                        }}
                                                    >
                                                        {data.category_id}
                                                    </td>

                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {data.lak_dr > 0
                                                            ? numberFormat(
                                                                  data.lak_dr /
                                                                      queryParams.multiplier
                                                              )
                                                            : "-"}
                                                    </td>
                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {data.lak_cr > 0
                                                            ? numberFormat(
                                                                  data.lak_cr /
                                                                      queryParams.multiplier
                                                              )
                                                            : "-"}
                                                    </td>

                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {"-"}
                                                    </td>

                                                    <td
                                                        style={{
                                                            textAlign: "center",
                                                            minWidth: "60px",
                                                        }}
                                                    >
                                                        {numberFormat(
                                                            data.exchange_rate
                                                        )}
                                                    </td>
                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {data.usd_dr > 0
                                                            ? numberFormat(
                                                                  data.usd_dr /
                                                                      queryParams.multiplier
                                                              )
                                                            : "-"}
                                                    </td>
                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {data.usd_cr > 0
                                                            ? numberFormat(
                                                                  data.usd_cr /
                                                                      queryParams.multiplier
                                                              )
                                                            : "-"}
                                                    </td>
                                                    <td
                                                        style={{
                                                            textAlign: "right",
                                                            paddingRight: "5px",
                                                        }}
                                                    >
                                                        {"-"}
                                                    </td>
                                                </tr>
                                            ))}
                                            <tr
                                                style={{
                                                    borderBottom:
                                                        "2px solid black",
                                                }}
                                            >
                                                <td
                                                    colSpan={3}
                                                    style={{
                                                        fontWeight: "bold",
                                                        textAlign: "center",
                                                    }}
                                                ></td>
                                                <td />
                                                <td />
                                                <td />

                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                                <td />
                                            </tr>
                                        </React.Fragment>
                                    )
                                )
                            ) : (
                                <tr>
                                    <td colSpan={22}>ບໍ່ມີຂໍ້ມູນ</td>
                                </tr>
                            )}

                            <tr>
                                <td colSpan={4}>ລວມຍອດ total:</td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td
                                    style={{
                                        textAlign: "center",
                                    }}
                                >
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.lak_balance_debit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.lak_balance_debit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td
                                    style={{
                                        textAlign: "center",
                                    }}
                                >
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.lak_balance_credit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.lak_balance_credit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td></td>
                                <td></td>
                                <td
                                    style={{
                                        textAlign: "center",
                                    }}
                                >
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.usd_balance_debit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.usd_balance_debit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td
                                    style={{
                                        textAlign: "center",
                                    }}
                                >
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.usd_balance_credit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.usd_balance_credit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <br />

            <div>
                <p
                    style={{
                        float: "right",
                    }}
                >
                    ນະຄອນຫຼວງວຽງຈັນ ວັນທີ:..............................
                </p>
            </div>
            <PrintSignatureComponent queryString={queryParams} />
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("print-voucher-ledger-report")
);

root.render(<VoucherLedgerReport />);
