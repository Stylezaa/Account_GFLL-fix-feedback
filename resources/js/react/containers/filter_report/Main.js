import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import SignatureComponent from "../../components/reports/Signature";
import PeriodDateComponent from "../../components/reports/PeriodDate";
import MainOptionComponent from "../../components/reports/MainOption";
import LocationOption from "../../components/customComponents/LocationOption";
import {
    defaultDate,
    getAgoDate,
    getAgoMonthYear,
    getAgoYear,
    getCurrentMonthYear,
    getCurrentYear,
} from "../../utilities/default_date";

const MainFilterReport = () => {
    // get code from url query string
    const urlParams = new URLSearchParams(window.location.search);
    const code = urlParams.get("code");

    const [dataTrialBalance, setDataTrialBalance] = useState([]);

    const [reportOption, setReportOption] = useState({
        period_type: "daily",
        start_date: getAgoDate(30),
        end_date: defaultDate(),
        start_month: getAgoMonthYear(1),
        end_month: getCurrentMonthYear(),
        start_year: getAgoYear(1),
        end_year: getCurrentYear(),
        display_number: "",
        multiplier: 1,
        selected_level_id: "",
        report_title: "",
        signature_1: "",
        signature_2: "",
        signature_3: "",
        signature_4: "",
        signature_5: "",
        report_address: "",
        voucher: [],
        single_voucher: "",
        activity: [],
        single_activity: "",
        category: [],
        single_category: "",
        account: [],
        single_account: "",
        donor: [],
        single_donor: "",
        ProvinceID: "",
        DistrictID: "",
        VillageID: "",
        trial_balance_level: "",
        is_order_account: false,
        currency: "LAK",
    });

    const fetchGetTrialBalanceLevel = async () => {
        try {
            const res = await axios.get(`/TrialBalance/levels`);
            if (res.data.length > 0) {
                setDataTrialBalance(res.data);
            } else {
                setDataTrialBalance([]);
            }
        } catch (error) {
            setDataTrialBalance([]);
            console.log("error fetchGetTrialBalanceLevel", error);
        }
    };

    useEffect(() => {
        fetchGetTrialBalanceLevel();
    }, []);

    const dataHaveLimit = ["bank_deposit_book", "cash", "advance_ledger"];

    const handlePathPrint = (code) => {
        if (code === "deposit-book'") {
            return "/print/deposit-book'";
        } else if (code === "/cash-book") {
            return "/print/cash-book";
        } else if (code === "voucher-advance-tracking-book") {
            return "/print/voucher-advance-tracking-book";
        } else if (code === "transaction") {
            return "/print/voucher-transaction";
        } else if (code === "voucher-general") {
            return "/print/voucher-general";
        } else if (code === "separate-account-book") {
            return "/print/separate-account-book";
        } else if (code === "trialBalance") {
            return "/print/trial-balance";
        } else if (code === "journal") {
            return "/print/voucher-transaction-daily";
        } else if (code === "ledger") {
            return "/print/voucher-ledger";
        } else {    
            return "/print/voucher-general";
        }
    };

    const handleReportType = (code) => {
        if (code === "voucher-general'") {
            return "voucher-general";
        } else {
            return "voucher_advance_ledger";
        }
    };

    return (
        <div className="row">
            <div className="col-lg-6 col-md-6 col-sm-6">
                <div className="card card-body bg-light border-0 shadow-sm p-3 mb-3">
                    <PeriodDateComponent
                        inputValues={reportOption}
                        setInputValues={setReportOption}
                    />
                </div>
            </div>

            <div className="col-lg-6 col-md-6 col-sm-6">
                <div className="card card-body bg-light border-0 shadow-sm p-3 mb-3">
                    <SignatureComponent
                        inputValues={reportOption}
                        setInputValues={setReportOption}
                    />
                </div>
            </div>

            <div className="col-lg-12 col-md-12 col-sm-12">
                <div className="card card-body bg-light border-0 shadow-sm p-3 mb-3">
                    <MainOptionComponent
                        inputValues={reportOption}
                        setInputValues={setReportOption}
                        reportType={code ?? ""}
                        isLimit={dataHaveLimit.includes(code)}
                    />
                </div>
            </div>

            <div className="col-lg-12 col-md-12 col-sm-12">
                <div className="card card-body bg-light border-0 shadow-sm p-3 mb-3">
                    <div className="row">
                        <div className="col-lg-3 col-md-3 col-sm-12">
                            <div className="form-group">
                                <label>ຮູບແບບການລາຍງານ</label>
                                <select
                                    className="form-control"
                                    value={
                                        reportOption.trial_balance_level ?? ""
                                    }
                                    onChange={(e) =>
                                        setReportOption({
                                            ...reportOption,
                                            trial_balance_level: e.target.value,
                                        })
                                    }
                                >
                                    {dataTrialBalance.map((item, index) => (
                                        <option
                                            key={index + 1}
                                            value={item.TypeID}
                                        >
                                            {item.TypeName}
                                        </option>
                                    ))}
                                </select>
                            </div>
                        </div>
                        <div className="col-lg-7 col-md-7 col-sm-12">
                            <LocationOption
                                inputValues={reportOption}
                                setInputValues={setReportOption}
                            />
                        </div>

                        <div className="col-lg-2 col-md-2 col-sm-12">
                            {/* button preview */}
                            <a
                                href={`${handlePathPrint(code)}?start_date=${
                                    reportOption.start_date
                                }&end_date=${
                                    reportOption.end_date
                                }&start_month=${
                                    reportOption.start_month
                                }&end_month=${
                                    reportOption.end_month
                                }&start_year=${
                                    reportOption.start_year
                                }&end_year=${
                                    reportOption.end_year
                                }&display_number=${
                                    reportOption.display_number
                                }&multiplier=${
                                    reportOption.multiplier
                                }&selected_level_id=${
                                    reportOption.selected_level_id
                                }&report_title=${
                                    reportOption.report_title
                                }&signature_1=${
                                    reportOption.signature_1
                                }&signature_2=${
                                    reportOption.signature_2
                                }&signature_3=${
                                    reportOption.signature_3
                                }&signature_4=${
                                    reportOption.signature_4
                                }&signature_5=${
                                    reportOption.signature_5
                                }&report_address=${
                                    reportOption.report_address
                                }&voucher=${
                                    reportOption.voucher
                                }&single_voucher=${
                                    reportOption.single_voucher
                                }&activity=${
                                    reportOption.activity
                                }&single_activity=${
                                    reportOption.single_activity
                                }&category=${
                                    reportOption.category
                                }&single_category=${
                                    reportOption.single_category
                                }&account=${
                                    reportOption.account
                                }&single_account=${
                                    reportOption.single_account
                                }&donor=${reportOption.donor}&single_donor=${
                                    reportOption.single_donor
                                }&ProvinceID=${
                                    reportOption.ProvinceID
                                }&DistrictID=${
                                    reportOption.DistrictID
                                }&VillageID=${
                                    reportOption.VillageID
                                }&trial_balance_level=${
                                    reportOption.trial_balance_level
                                }&is_order_account=${
                                    reportOption.is_order_account
                                }&report_type=${code}&period_type=${
                                    reportOption.period_type
                                }&currency=${reportOption.currency}`}
                                target="_blank"
                                className="btn btn-primary text-white mt-5"
                                style={{
                                    width: "100%",
                                    height: "40px",
                                    fontSize: "14px",
                                    fontWeight: "bold",
                                    borderRadius: "5px",
                                    background: "#007bff",
                                    border: "none",
                                    cursor: "pointer",
                                }}
                            >
                                Preview
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    );
};

const root = ReactDOM.createRoot(document.getElementById("main-filter-report"));

root.render(<MainFilterReport />);
