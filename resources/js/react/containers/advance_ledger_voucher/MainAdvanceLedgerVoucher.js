import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import MainFormVoucher from "../../components/voucher/MainFormVoucher";
import CardSummary from "../../components/voucher/CardSummary";
import { VoucherList } from "../../components/voucher/VoucherList";
import ModalAlertComponent from "../../components/customComponents/ModalConfirmAlert";
import { numberFormat } from "../../utilities/number_formate";

const MainAdvanceLedgerVoucher = () => {
    const [inputVoucherAdvanceMain, setinputAdvanceVoucherMain] = useState({
        voucher_id: "",
        voucher_no: "",
        voucher_advance_no: "",
        selected_level: "C",
        selected_province: "",
        selected_district: "",
        selected_village: "",
        confirm_no: "",
        confirm_date: "",
        reference_detail: "",
        reference_date: "",
        payment_detail: "",
        address: "",
        payment_type: "cash",
        cheque_no: "",
        cheque_date: "",
        money_amount: "",
        currency: "LAK",
        exchange_rate: 23000,
        advance_ledger_no: "",
        advance_ledger_start_date: "",
        advance_ledger_end_date: "",
        description_lao: "",
        description_eng: "",
        status: "",
    });

    const [inputVoucherAdvanceItems, setinputVoucherAdvanceItems] = useState({
        item_selected_account_id: "",
        item_selected_donor_id: "",
        item_selected_activity_id: "",
        item_selected_category_id: "",
        item_selected_cost_center_id: "",
        item_selected_sub_cost_center_id: "",
        item_money_amount_lak: 0,
        item_money_amount_usd: 0,
        item_currency: "LAK", // 'LAK', 'USD
        item_exchange_rate: 23000,
        item_voucher_type: "",
        item_all_name: {
            account_name_lao: "",
            account_name_eng: "",
            donor_name_lao: "",
            donor_name_eng: "",
            activity_name_lao: "",
            activity_name_eng: "",
            category_name_lao: "",
            category_name_eng: "",
            cost_center_name_lao: "",
            cost_center_name_eng: "",
            sub_cost_center_name_lao: "",
            sub_cost_center_name_eng: "",
        },
    });

    const [voucherItems, setVoucherItems] = useState([]);

    const [dataSummary, setDataSummary] = useState([
        {
            title: "ມູນຄ່າໜີ້ໂດລາ",
            amount: 0,
        },
        {
            title: "ມູນຄ່າມີໂດລາ",
            amount: 0,
        },
        {
            title: "ມູນຄ່າຜິດດ່ຽວໂດລາ",
            amount: 0,
        },
        {
            title: "ມູນຄ່າໜີ້ກີບ",
            amount: 0,
        },
        {
            title: "ມູນຄ່າມີກີບ",
            amount: 0,
        },
        {
            title: "ມູນຄ່າຜິດດ່ຽວກີບ",
            amount: 0,
        },
    ]);

    const [handleCheckSubmit, setHandleCheckSubmit] = useState(false);
    const [isModalAlert, setIsModalAlert] = useState(false);
    const [messageAlert, setMessageAlert] = useState("");

    const handlePairTypeMapping = (data) => {
        if (data.length > 0) {
            const debit = data.filter(
                (item) => item.item_voucher_type === "debit"
            );
            const credit = data.filter(
                (item) => item.item_voucher_type === "credit"
            );
    
            if (debit.length > 1 && credit.length > 1) {
                return "MM";
            } else if (debit.length > 1 && credit.length === 1) {
                return "MO";
            } else if (debit.length === 1 && credit.length > 1) {
                return "OM";
            } else if (debit.length === 1 && credit.length === 1) {
                return "OO";
            }
        }
    };

    const handlePairCode = (data) => {
        if (data.length > 0) {
            const debit = data.filter(
                (item) => item.item_voucher_type === "debit"
            );
            const credit = data.filter(
                (item) => item.item_voucher_type === "credit"
            );
    
            if (debit.length > 1 && credit.length > 1) {
                return data
                    .find((item) => item.item_voucher_type === "credit")
                    .number_credit.toString();
            } else if (debit.length > 1 && credit.length === 1) {
                return data
                    .find((item) => item.item_voucher_type === "credit")
                    .number_credit.toString();
            } else if (debit.length === 1 && credit.length > 1) {
                return data
                    .find((item) => item.item_voucher_type === "debit")
                    .number_debit.toString();
            } else if (debit.length === 1 && credit.length === 1) {
                return data
                    .find((item) => item.item_voucher_type === "credit")
                    .number_credit.toString();
            }
        }
    };

    const handlePair = (data) => {
        let initPair = 1;
        let changed = false;
        for (let i = 0; i < data.length; i++) {
            if (data[i].item_voucher_type === "debit" && i === 0) {
                return initPair;
            } else if (
                data[i].item_voucher_type === "debit" &&
                i !== 0 &&
                !changed
            ) {
                return initPair;
            } else if (
                data[i].item_voucher_type === "credit" &&
                i !== 0 &&
                !changed
            ) {
                changed = true;
                return initPair;
            } else if (
                data[i].item_voucher_type === "credit" &&
                i !== 0 &&
                changed
            ) {
                return initPair;
            } else if (
                data[i].item_voucher_type === "debit" &&
                i !== 0 &&
                changed
            ) {
                changed = false;
                initPair = initPair + 1;
                return initPair;
            }
        }
    };

    const handleSaveVoucher = async () => {
        try {
            if (voucherItems.length > 0) {
                const debitLak = voucherItems.reduce((acc, item) => {
                    return item.item_voucher_type === "debit"
                        ? parseInt(acc + item.amount_debit_lak)
                        : parseInt(acc);
                }, 0);
                const creditLak = voucherItems.reduce((acc, item) => {
                    return item.item_voucher_type === "credit"
                        ? parseInt(acc + item.amount_credit_lak)
                        : parseInt(acc);
                }, 0);
                const debitUsd = voucherItems.reduce((acc, item) => {
                    return item.item_voucher_type === "debit"
                        ? parseFloat(acc + item.amount_debit_usd).toFixed(4)
                        : parseFloat(acc).toFixed(4);
                }, 0);
                const creditUsd = voucherItems.reduce((acc, item) => {
                    return item.item_voucher_type === "credit"
                        ? parseFloat(acc + item.amount_credit_usd).toFixed(4)
                        : parseFloat(acc).toFixed(4);
                }, 0);

                if (
                    inputVoucherAdvanceMain.currency === "LAK" &&
                    parseInt(debitLak) !==
                        parseInt(inputVoucherAdvanceMain.money_amount)
                ) {
                    setIsModalAlert(true);
                    setMessageAlert(
                        "ມູນຄ່າຜິດດ່ຽວບໍ່ກົງກັນ, ກະລຸນາກວດສອບຄ່າເງິນກີບ ຫຼື ໂດລາ ຄືນທີ່ລະບຸ!"
                    );
                    return;
                }

                if (handlePairTypeMapping(voucherItems) !== "MM") {
                    await axios
                        .post(`/middle-voucher/store`, {
                            voucher: {
                                LevelID: inputVoucherAdvanceMain.selected_level,
                                VoucherNo: inputVoucherAdvanceMain.confirm_no,
                                Refer: inputVoucherAdvanceMain.reference_detail,
                                ReferDt: inputVoucherAdvanceMain.reference_date,
                                ProvinceID:
                                    inputVoucherAdvanceMain.selected_province,
                                DistrictID:
                                    inputVoucherAdvanceMain.selected_district,
                                VillageID:
                                    inputVoucherAdvanceMain.selected_village,
                                VoucherDt: inputVoucherAdvanceMain.confirm_date,
                                PaidCash:
                                    inputVoucherAdvanceMain.payment_type ===
                                    "cash"
                                        ? "1"
                                        : "0",
                                ChequeNo:
                                    inputVoucherAdvanceMain.cheque_no ?? "",
                                ChequeDt:
                                    inputVoucherAdvanceMain.cheque_date ?? "",
                                Voucher_Amt:
                                    inputVoucherAdvanceMain.money_amount,
                                Currency: inputVoucherAdvanceMain.currency,
                                Rate: inputVoucherAdvanceMain.exchange_rate,
                                AdvanceNo:
                                    inputVoucherAdvanceMain.advance_ledger_no,
                                Act_FDt:
                                    inputVoucherAdvanceMain.advance_ledger_start_date,
                                Act_TDt:
                                    inputVoucherAdvanceMain.advance_ledger_end_date,
                                Pay_to: inputVoucherAdvanceMain.payment_detail,
                                Pay_to_Address: inputVoucherAdvanceMain.address,
                                DescriptionL:
                                    inputVoucherAdvanceMain.description_lao,
                                DescriptionE:
                                    inputVoucherAdvanceMain.description_eng,
                                VoucherType: "VAD",
                                Amt_USD_Dr: parseFloat(debitUsd).toFixed(4),
                                Amt_USD_Cr: parseFloat(creditUsd).toFixed(4),
                                Amt_LAK_Dr: parseInt(debitLak),
                                Amt_LAK_Cr: parseInt(creditLak),
                            },
                            items:
                                voucherItems &&
                                voucherItems.map((item) => {
                                    return {
                                        Code_Dr:
                                            item.item_voucher_type === "debit"
                                                ? item.number_debit
                                                : "",
                                        Code_Cr:
                                            item.item_voucher_type === "credit"
                                                ? item.number_credit
                                                : "",
                                        AccountCD: item.account_id,
                                        PairCD: handlePairCode(voucherItems),
                                        DescriptionL: item.content ?? "",
                                        DescriptionE: item.content_en ?? "",
                                        ActivityID: item.activity_id,
                                        DonorID: item.donor_id,
                                        CCtrID: item.cost_center_id,
                                        SCCtrID: item.sub_cost_center_id,
                                        USD_Dr: parseFloat(
                                            item.amount_debit_usd
                                        ).toFixed(4),
                                        USD_Cr: parseFloat(
                                            item.amount_credit_usd
                                        ).toFixed(4),
                                        Rate: item.exchange_rate,
                                        LAK_Dr: parseInt(item.amount_debit_lak),
                                        LAK_Cr: parseInt(
                                            item.amount_credit_lak
                                        ),
                                        Pair: handlePair(voucherItems),
                                        PairType:
                                            handlePairTypeMapping(voucherItems),
                                    };
                                }),
                        })
                        .then((response) => {
                            console.log(response);
                            // this.saveLoading = false;
                            // this.$router.push({ name: "VoucherList" });
                            window.location.href = "/VoucherAdvance";
                        })
                        .catch((error) => {
                            console.log(error);
                            // this.saveLoading = false;
                        });
                } else {
                    setIsModalAlert(true);
                    setMessageAlert(
                        "ທ່ານບໍ່ສາມາດລົງຂໍ້ມູນແບບ ຫຼາຍໜີ້ໍ່-ຫຼາຍມີໄດ້, ກະລຸນາກວດສອບ!"
                    );
                    // delete last item
                    setVoucherItems(voucherItems.slice(0, -1));
                }
            }
        } catch (error) {
            console.log(error);
            setIsModalAlert(false);
        }
    };

    const onSubmit = () => {
        if (
            inputVoucherAdvanceMain.confirm_no === "" ||
            inputVoucherAdvanceMain.confirm_date === "" ||
            inputVoucherAdvanceMain.reference_detail === "" ||
            inputVoucherAdvanceMain.reference_date === "" ||
            inputVoucherAdvanceMain.payment_detail === "" ||
            inputVoucherAdvanceMain.address === "" ||
            inputVoucherAdvanceMain.money_amount === "" ||
            inputVoucherAdvanceMain.advance_ledger_no === "" ||
            inputVoucherAdvanceMain.advance_ledger_start_date === "" ||
            inputVoucherAdvanceMain.advance_ledger_end_date === "" ||
            inputVoucherAdvanceMain.description_lao === "" ||
            inputVoucherAdvanceMain.description_eng === ""
        ) {
            setIsModalAlert(true);
            setMessageAlert("ກະລຸນາຕື່ມຂໍ້ມູນທີ່ບໍ່ມີລາຍລະອຽດ!");
            setHandleCheckSubmit(true);
        } else {
            handleSaveVoucher();
            setHandleCheckSubmit(false);
        }
    };

    useEffect(() => {
        if (voucherItems.length > 0) {
            const debitLak = voucherItems.reduce((acc, item) => {
                return item.item_voucher_type === "debit"
                    ? acc + item.amount_debit_lak
                    : acc;
            }, 0);
            const creditLak = voucherItems.reduce((acc, item) => {
                return item.item_voucher_type === "credit"
                    ? acc + item.amount_credit_lak
                    : acc;
            }, 0);
            const debitUsd = voucherItems.reduce((acc, item) => {
                return item.item_voucher_type === "debit"
                    ? parseFloat(acc + item.amount_debit_usd).toFixed(4)
                    : parseFloat(acc);
            }, 0);
            const creditUsd = voucherItems.reduce((acc, item) => {
                return item.item_voucher_type === "credit"
                    ? parseFloat(acc + item.amount_credit_usd).toFixed(4)
                    : parseFloat(acc);
            }, 0);

            setDataSummary([
                {
                    title: "ມູນຄ່າໜີ້ໂດລາ",
                    amount: parseFloat(debitUsd).toFixed(4),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າມີໂດລາ",
                    amount: parseFloat(creditUsd).toFixed(4),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າຜິດດ່ຽວໂດລາ",
                    amount: parseFloat(debitUsd - creditUsd).toFixed(4),
                    color: "text-danger",
                },
                {
                    title: "ມູນຄ່າໜີ້ກີບ",
                    amount: numberFormat(debitLak),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າມີກີບ",
                    amount: numberFormat(creditLak),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າຜິດດ່ຽວກີບ",
                    amount: numberFormat(debitLak - creditLak),
                    color: "text-danger",
                },
            ]);
        }
    }, [voucherItems]);

    return (
        <>
            <ModalAlertComponent
                title={"ແຈ້ງເຕືອນ"}
                isActive={isModalAlert ?? false}
                setIsActive={setIsModalAlert}
                id="AlertModal"
            >
                <div
                    className="modal-footer"
                    style={{
                        display: "flex",
                        justifyContent: "center",
                    }}
                >
                    <h6>{messageAlert}</h6>
                    <button
                        type="button "
                        className="btn btn-danger text-white"
                        data-bs-dismiss="modal"
                        onClick={() => setIsModalAlert(false)}
                    >
                        ຕົກລົງ
                    </button>
                </div>
            </ModalAlertComponent>

            <div className="card">
                <div className="card-body">
                    <MainFormVoucher
                        inputVoucherMain={inputVoucherAdvanceMain}
                        setinputVoucherMain={setinputAdvanceVoucherMain}
                        voucherType="advance_ledger"
                        inputVoucherItems={inputVoucherAdvanceItems}
                        voucherItems={voucherItems}
                        onSubmit={onSubmit}
                        handleCheckSubmit={handleCheckSubmit}
                    />
                </div>
            </div>
            <br />
            <div className="row">
                {dataSummary.map((item, index) => (
                    <div key={index + 1} className="col-lg-2 col-md-2 col-sm-2">
                        <CardSummary
                            key={index + 1}
                            title={item.title}
                            amount={item.amount}
                            color={item.color}
                        />
                    </div>
                ))}
            </div>
            <br />
            <div className="card">
                <div className="card-header">ລາຍການບັນຊີ</div>
                <div className="card-body">
                    <VoucherList
                        inputVoucherItems={inputVoucherAdvanceItems}
                        setinputVoucherItems={setinputVoucherAdvanceItems}
                        inputVoucherMain={inputVoucherAdvanceMain}
                        voucherItems={voucherItems}
                        setVoucherItems={setVoucherItems}
                        voucherType="advance_ledger"
                    />
                </div>
            </div>
            <br />
            <div className="card p-4">
                <div
                    className="form-group"
                    style={{ display: "flex", justifyContent: "space-between" }}
                >
                    <button
                        className="btn btn-primary text-white"
                        type="submit"
                        onClick={onSubmit}
                    >
                        ບັນທຶກ
                    </button>

                    <a href="/VoucherAdvance" className="btn btn-danger">
                        ຍົກເລີກ
                    </a>
                </div>
            </div>
        </>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("main-advance-ledger-voucher")
);

root.render(<MainAdvanceLedgerVoucher />);
