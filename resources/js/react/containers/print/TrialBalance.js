import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import PrintSignatureComponent from "../../components/print/Signature";
import HeaderPDR from "../../components/print/HeaderPDR";
import axios from "axios";
import {
    numberFormat,
    numberFormatWithDecimal,
} from "../../utilities/number_formate";
import SubHeader from "../../components/print/SubHeader";

const TrialBalance = () => {
    const [dataReport, setDataReport] = useState([]);
    const [dataReportTotal, setDataReportTotal] = useState({
        raised_debit: 0,
        raised_credit: 0,
        transaction_debit: 0,
        transaction_credit: 0,
        balance_debit: 0,
        balance_credit: 0,
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
            const res = await axios.post(`/print/trial-balance/data`, {
                ...queryParams,
            });

            if (res.status === 200) {
                setDataReport(res.data?.data ?? []);
                setDataReportTotal({
                    raised_debit: res.data?.total?.total_raised_debit ?? 0,
                    raised_credit: res.data?.total?.total_raised_credit ?? 0,
                    transaction_debit:
                        res.data?.total?.total_transaction_debit ?? 0,
                    transaction_credit:
                        res.data?.total?.total_transaction_credit ?? 0,
                    balance_debit: res.data?.total?.total_balance_debit ?? 0,
                    balance_credit: res.data?.total?.total_balance_credit ?? 0,
                });

                setTimeout(() => {
                    window.print();
                }, 500);
            } else {
                setDataReport([]);
            }
        } catch (error) {
            setDataReport([]);
            console.log("error fetchGetTrialBalanceLevel", error);
        }
    };

    useEffect(() => {
        fetchGetDataReport();
    }, []);
    // print
    // useEffect(() => {
    //     setTimeout(() => {
    //         window.print();
    //     }, 500);
    // }, []);

    //close print
    useEffect(() => {
        window.onafterprint = function () {
            window.close();
        };
    }, []);

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
                    <strong>ໃບດຸ່ນດ່ຽງ</strong>
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
                            textAlign: "center",
                            fontSize: "11px",
                        }}
                    >
                        <thead>
                            <tr>
                                <th
                                    rowSpan={2}
                                    style={{
                                        minWidth: "35px",
                                        maxWidth: "35px",
                                        textAlign: "center",
                                    }}
                                >
                                    ລ/ດ
                                </th>
                                <th
                                    rowSpan={2}
                                    style={{
                                        minWidth: "50px",
                                        maxWidth: "50px",
                                        textAlign: "center",
                                    }}
                                >
                                    ເລກບັນຊີ
                                </th>
                                <th
                                    rowSpan={2}
                                    style={{
                                        minWidth: "350px",
                                        maxWidth: "350px",
                                    }}
                                >
                                    ເນື້ອໃນບັນຊີ
                                </th>
                                <th
                                    colSpan={2}
                                    style={{
                                        minWidth: "75px",
                                        maxWidth: "75px",
                                        textAlign: "center",
                                    }}
                                >
                                    ຍອດຍົກມາ ເດືອນ
                                </th>
                                <th
                                    colSpan={2}
                                    style={{
                                        minWidth: "75px",
                                        maxWidth: "75px",
                                        textAlign: "center",
                                    }}
                                >
                                    ເຄື່ອນໄຫວ ( {queryParams.currency} )
                                </th>
                                <th
                                    colSpan={2}
                                    style={{
                                        minWidth: "75px",
                                        maxWidth: "75px",
                                        textAlign: "center",
                                    }}
                                >
                                    ຄົງເຫຼືອ ( {queryParams.currency} )
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
                            {dataReport &&
                                dataReport.length > 0 &&
                                dataReport.map((item, index) => {
                                    return (
                                        <tr key={index}>
                                            <td
                                                style={{
                                                    minWidth: "35px",
                                                    maxWidth: "35px",
                                                    textAlign: "center",
                                                }}
                                            >
                                                {index + 1}
                                            </td>
                                            <td
                                                style={{
                                                    minWidth: "50px",
                                                    maxWidth: "50px",
                                                    textAlign: "center",
                                                }}
                                            >
                                                {numberFormat(item.account_cd)}
                                            </td>
                                            <td
                                                style={{
                                                    minWidth: "350px",
                                                    maxWidth: "350px",
                                                    textAlign: "start",
                                                    paddingLeft: "10px",
                                                }}
                                            >
                                                {item.account_name}
                                            </td>
                                            <td>
                                                {numberFormat(
                                                    item.raised_debit /
                                                        queryParams.multiplier
                                                )}
                                            </td>
                                            <td>
                                                {queryParams.display_number ===
                                                "decimal"
                                                    ? numberFormatWithDecimal(
                                                          item.raised_credit /
                                                              queryParams.multiplier
                                                      )
                                                    : numberFormat(
                                                          item.raised_credit /
                                                              queryParams.multiplier
                                                      )}
                                            </td>
                                            <td>
                                                {queryParams.display_number ===
                                                "decimal"
                                                    ? numberFormatWithDecimal(
                                                          item.transaction_debit /
                                                              queryParams.multiplier
                                                      )
                                                    : numberFormat(
                                                          item.transaction_debit /
                                                              queryParams.multiplier
                                                      )}
                                            </td>
                                            <td>
                                                {queryParams.display_number ===
                                                "decimal"
                                                    ? numberFormatWithDecimal(
                                                          item.transaction_credit /
                                                              queryParams.multiplier
                                                      )
                                                    : numberFormat(
                                                          item.transaction_credit /
                                                              queryParams.multiplier
                                                      )}
                                            </td>
                                            <td>
                                                {queryParams.display_number ===
                                                "decimal"
                                                    ? numberFormatWithDecimal(
                                                          item.balance_debit /
                                                              queryParams.multiplier
                                                      )
                                                    : numberFormat(
                                                          item.balance_debit /
                                                              queryParams.multiplier
                                                      )}
                                            </td>
                                            <td>
                                                {queryParams.display_number ===
                                                "decimal"
                                                    ? numberFormatWithDecimal(
                                                          item.balance_credit /
                                                              queryParams.multiplier
                                                      )
                                                    : numberFormat(
                                                          item.balance_credit /
                                                              queryParams.multiplier
                                                      )}
                                            </td>
                                        </tr>
                                    );
                                })}
                            <tr>
                                <td colSpan={3}>ລວມຍອດ total:</td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.raised_debit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.raised_debit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.raised_credit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.raised_credit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.transaction_debit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.transaction_debit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.transaction_credit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.transaction_credit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.balance_debit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.balance_debit /
                                                  queryParams.multiplier
                                          )}
                                </td>
                                <td>
                                    {queryParams.display_number === "decimal"
                                        ? numberFormatWithDecimal(
                                              dataReportTotal.balance_credit /
                                                  queryParams.multiplier
                                          )
                                        : numberFormat(
                                              dataReportTotal.balance_credit /
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
    document.getElementById("print-trial-balance")
);

root.render(<TrialBalance />);
