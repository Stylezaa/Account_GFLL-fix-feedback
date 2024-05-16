import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import PrintSignatureComponent from "../../components/print/Signature";
import HeaderPDR from "../../components/print/HeaderPDR";
import SubHeader from "../../components/print/SubHeader";
import TitleReportCompnent from "../../components/print/Title";
import SubTitleReportCompnent from "../../components/print/SubTitle";
import PaymentDetailComponent from "../../components/print/PaymentDetail";
import ListItem from "../../components/print/ListItem";
import AmountLetterComponent from "../../components/print/AmountLetter";
import JournalEnterComponent from "../../components/print/JournalEnter";

const VoucherClearAdvanceLedger = () => {
    const urlParams = new URLSearchParams(window.location.search);

    const queryParams = {
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
        report_type: 'voucher_clear_advance_ledger',
    };

    //print

    useEffect(() => {
        setTimeout(() => {
            window.print();
        }, 500);
    }, []);

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
            <HeaderPDR />

            <SubHeader type={'voucher'}/>

            <TitleReportCompnent queryParams={queryParams} />

            <SubTitleReportCompnent queryParams={queryParams} />

            <PaymentDetailComponent />

            <ListItem />

            <AmountLetterComponent />

            <JournalEnterComponent />
            
            <br />
            <br />

            <PrintSignatureComponent queryString={queryParams} />
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("print-voucher-clear-advance-ledger")
);

root.render(<VoucherClearAdvanceLedger />);
