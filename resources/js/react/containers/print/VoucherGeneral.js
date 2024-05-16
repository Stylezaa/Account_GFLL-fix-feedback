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
import axios from "axios";
import GeneralListItem from "../../components/print/GeneralListItem";

const VoucherGeneral = () => {
    const query = new URLSearchParams(window.location.search);

    const voucherType = query.get("type");

    const [data, setData] = useState([]);
    //print

    //close print

    useEffect(() => {
        window.onafterprint = function () {
            window.close();
        };
    }, []);

    const fetchGetVoucher = async (level, implementCD, voucherNo, path) => {
        //GeneralVoucher
        try {
            const res = await axios.get(
                `/${path}/preview/data/${level}/${implementCD}/${voucherNo}`,
                {
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/json",
                    },
                }
            );
            if (res.data) {
                setData(res.data.data);

                setTimeout(() => {
                    window.print();
                }, 500);
            } else {
                setData([]);
            }

            // await axios
            //     .get(
            //         `/GeneralVoucher/preview/data/${level}/${implementCD}/${voucherNo}`,
            //         {
            //             headers: {
            //                 "Content-Type": "application/json",
            //                 Accept: "application/json",
            //             },
            //         }
            //     )
            //     .then((res) => {
            //         console.log("res", res.data);

            //         if (res.data) {
            //             setData(res.data);
            //             console.log("res", res.data);

            //             // setTimeout(() => {
            //             //     window.print();
            //             // }, 500);
            //         }
            //     });
        } catch (error) {
            // swalWarningToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນທຶກບັນຊີໄດ້!");
            console.log("error", error);
        }
    };

    useEffect(() => {
        if (
            query.has("level") &&
            query.has("implementCD") &&
            query.has("voucherNo") &&
            query.has("path")
        ) {
            fetchGetVoucher(
                query.get("level"),
                query.get("implementCD"),
                query.get("voucherNo"),
                query.get("path")
            );
        }
    }, [query.get("level"), query.get("implementCD"), query.get("voucherNo"), query.get("path")]);

    return (
        <div
            style={{
                fontFamily: "Phetsarath OT",
                fontSize: "11px",
                margin: "15px 25px",
                color: "black",
                display: "flex",
                flexDirection: "column",
            }}
        >
            {data.length > 0 ? (
                <>
                    <HeaderPDR data={data} />

                    <SubHeader data={data} type={voucherType} />

                    <TitleReportCompnent data={data} type={voucherType} />

                    {/* <SubTitleReportCompnent data={data} type={voucherType} /> */}

                    {/* <PaymentDetailComponent data={data} /> */}

                    <GeneralListItem data={data} />

                    <br />

                    <AmountLetterComponent data={data} />

                    <hr style={{
                        color: 'black'
                    }} />

                    <JournalEnterComponent data={data} />

                    <br />
                    <br />

                    <div
                        style={{
                            display: "flex",
                            justifyContent: "space-between",
                        }}
                    >
                        <div
                            style={{
                                display: "flex",
                                flexDirection: "column",
                                alignItems: "start",
                            }}
                        >
                            <div>{data[0].Sign1}</div>
                            <div>{data[0].Sign2}</div>
                            <div>ວັນທີ/Date:</div>
                        </div>

                        <div
                            style={{
                                display: "flex",
                                flexDirection: "column",
                                alignItems: "start",
                            }}
                        >
                            <div>{data[0].Sign1}</div>
                            <div>{data[0].Sign2}</div>
                            <div>ວັນທີ/Date:</div>
                        </div>

                        <div
                            style={{
                                display: "flex",
                                flexDirection: "column",
                                alignItems: "start",
                            }}
                        >
                            <div>{data[0].Sign1}</div>
                            <div>{data[0].Sign2}</div>
                            <div>ວັນທີ/Date:</div>
                        </div>
                    </div>
                </>
            ) : null}
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("print-voucher-general")
);

root.render(<VoucherGeneral />);
