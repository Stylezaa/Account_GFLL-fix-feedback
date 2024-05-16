import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import MainFormVoucher from "../../components/voucher/MainFormVoucher";
import CardSummary from "../../components/voucher/CardSummary";
import { VoucherList } from "../../components/voucher/VoucherList";
import ModalAlertComponent from "../../components/customComponents/ModalConfirmAlert";
import { numberFormat } from "../../utilities/number_formate";
import ModalConfirmDeleteComponent from "../../components/customComponents/ModalConfirmDelete";

const UpdateGeneralVoucher = () => {
    // get id from url
    const url = window.location.pathname;
    const p_voucher_id = url.substring(url.lastIndexOf("/") + 1);

    const [voucherRecCnt, setVoucherRecCnt] = useState("");

    const [isActiveDelete, setIsActiveDelete] = useState(false);
    const [contentModal, setContentModal] = useState({
        title: "",
        account_type: "",
        account_type_row: "",
    });
    const [statusDelete, setStatusDelete] = useState({
        status: "none",
        message: "",
    });
    const [selectedVoucherItemId, setSelectedVoucherItemId] = useState("");
    const [inputVoucherGeneralMain, setinputGeneralVoucherMain] = useState({
        voucher_id: "",
        voucher_no: "",
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

    const handleUpdateVoucher = async (voucherId) => {
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

                const debitUsd = voucherItems
                    .reduce((acc, item) => {
                        return item.item_voucher_type === "debit"
                            ? parseFloat(acc) +
                                  parseFloat(item.amount_debit_usd)
                            : parseFloat(acc);
                    }, 0)
                    .toFixed(4);

                const creditUsd = voucherItems
                    .reduce((acc, item) => {
                        return item.item_voucher_type === "credit"
                            ? parseFloat(acc) +
                                  parseFloat(item.amount_credit_usd)
                            : parseFloat(acc);
                    }, 0)
                    .toFixed(4);

                // if (
                //     inputVoucherGeneralMain.currency === "LAK" &&
                //     parseInt(debitLak) !==
                //         parseInt(inputVoucherGeneralMain.money_amount)
                // ) {
                //     setIsModalAlert(true);
                //     setMessageAlert(
                //         "ມູນຄ່າຜິດດ່ຽວບໍ່ກົງກັນ, ກະລຸນາກວດສອບຄ່າເງິນກີບ ຫຼື ໂດລາ ຄືນທີ່ລະບຸ!"
                //     );
                //     return;
                // }

                if (handlePairTypeMapping(voucherItems) !== "MM") {
                    console.log(
                        " handlePairTypeMapping(voucherItems)",
                        handlePairTypeMapping(voucherItems)
                    );
                    await axios
                        .put(`/middle-voucher/update/single/${voucherId}`, {
                            voucher: {
                                LevelID: inputVoucherGeneralMain.selected_level,
                                VoucherNo: inputVoucherGeneralMain.confirm_no,
                                Refer: inputVoucherGeneralMain.reference_detail,
                                ReferDt: inputVoucherGeneralMain.reference_date,
                                ProvinceID:
                                    inputVoucherGeneralMain.selected_province,
                                DistrictID:
                                    inputVoucherGeneralMain.selected_district,
                                VillageID:
                                    inputVoucherGeneralMain.selected_village,
                                VoucherDt: inputVoucherGeneralMain.confirm_date,
                                PaidCash:
                                    inputVoucherGeneralMain.payment_type ===
                                    "cash"
                                        ? "1"
                                        : "0",
                                ChequeNo:
                                    inputVoucherGeneralMain.cheque_no ?? "",
                                ChequeDt:
                                    inputVoucherGeneralMain.cheque_date ?? "",
                                Voucher_Amt:
                                    inputVoucherGeneralMain.money_amount,
                                Currency: inputVoucherGeneralMain.currency,
                                Rate: inputVoucherGeneralMain.exchange_rate,
                                AdvanceNo: "",
                                Act_FDt: "",
                                Act_TDt: "",
                                Pay_to: inputVoucherGeneralMain.payment_detail,
                                Pay_to_Address: "",
                                DescriptionL:
                                    inputVoucherGeneralMain.description_lao,
                                DescriptionE:
                                    inputVoucherGeneralMain.description_eng,
                                VoucherType: "VJN",
                                Amt_USD_Dr: parseFloat(debitUsd).toFixed(4),
                                Amt_USD_Cr: parseFloat(creditUsd).toFixed(4),
                                Amt_LAK_Dr: parseInt(debitLak),
                                Amt_LAK_Cr: parseInt(creditLak),
                            },
                            items:
                                voucherItems &&
                                voucherItems.map((item) => {
                                    return {
                                        voucher_item_id: item.voucher_item_id,
                                        voucher_item_action_type:
                                            item.voucher_item_action_type,
                                        item_voucher_type:
                                            item.item_voucher_type,
                                        Code_Dr:
                                            item.item_voucher_type === "debit"
                                                ? item.number_debit
                                                : "",
                                        Code_Cr:
                                            item.item_voucher_type === "credit"
                                                ? item.number_credit
                                                : "",
                                        AccountCD: item.account_id,
                                        PairCD:
                                            handlePairCode(voucherItems) ?? "",
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
                                        Pair: handlePair(voucherItems) ?? "",
                                        PairType:
                                            handlePairTypeMapping(
                                                voucherItems
                                            ) ?? "",
                                    };
                                }),
                        })
                        .then((response) => {
                            if (response.status === 200) {
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1000);
                            } else {
                                setIsModalAlert(true);
                                setMessageAlert("ບໍ່ສາມາດແກ້ໄຂໍ້ມູນໄດ້!");
                            }
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
            inputVoucherGeneralMain.confirm_no === "" ||
            inputVoucherGeneralMain.confirm_date === "" ||
            inputVoucherGeneralMain.reference_detail === "" ||
            inputVoucherGeneralMain.reference_date === "" ||
            inputVoucherGeneralMain.payment_detail === "" ||
            inputVoucherGeneralMain.money_amount === 0 ||
            inputVoucherGeneralMain.description_lao === "" ||
            inputVoucherGeneralMain.description_eng === ""
        ) {
            setIsModalAlert(true);
            setMessageAlert("ກະລຸນາຕື່ມຂໍ້ມູນທີ່ບໍ່ມີລາຍລະອຽດ!");
            setHandleCheckSubmit(true);
        } else {
            if (voucherRecCnt) {
                handleUpdateVoucher(voucherRecCnt);
                setHandleCheckSubmit(false);
            } else {
                setIsModalAlert(true);
                setMessageAlert("ບໍ່ສາມາດແກ້ໄຂ້ມູນ!");
            }
        }
    };

    useEffect(() => {
        if (voucherItems.length > 0) {
            const calculateTotal = (items, key) => {
                return items.reduce((acc, item) => {
                    return item[key] > 0 ? acc + parseFloat(item[key]) : acc;
                }, 0);
            };

            const debitLak = calculateTotal(voucherItems, "amount_debit_lak");
            const creditLak = calculateTotal(voucherItems, "amount_credit_lak");
            const debitUsd = calculateTotal(voucherItems, "amount_debit_usd");
            const creditUsd = calculateTotal(voucherItems, "amount_credit_usd");

            setDataSummary([
                {
                    title: "ມູນຄ່າໜີ້ໂດລາ",
                    amount: debitUsd.toFixed(4),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າມີໂດລາ",
                    amount: creditUsd.toFixed(4),
                    color: "text-success",
                },
                {
                    title: "ມູນຄ່າຜິດດ່ຽວໂດລາ",
                    amount: (debitUsd - creditUsd).toFixed(4),
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

    const fetchGetSingleVoucher = async (p_voucher_id) => {
        try {
            const response = await axios.get(
                `/GeneralVoucher/add/data/${p_voucher_id}`
            );
            const data = response.data;
            if (data) {
                setinputGeneralVoucherMain({
                    voucher_id: data.Vch_AutoNo,
                    voucher_no: data.Vch_AutoNo,
                    selected_level: data.LevelID,
                    selected_province: data.ProvinceID,
                    selected_district: data.DistrictID,
                    selected_village: data.VillageID,
                    confirm_no: data.VoucherNo,
                    confirm_date: data.VoucherDt
                        ? new Date(data.VoucherDt).toISOString().split("T")[0]
                        : "",
                    reference_detail: data.Refer,
                    reference_date: data.ReferDt
                        ? new Date(data.ReferDt).toISOString().split("T")[0]
                        : "",
                    payment_detail: data.Pay_to,
                    address: data.Pay_to_Address,
                    payment_type: data.PaidCash === "1" ? "cash" : "cheque",
                    cheque_no: data.ChequeNo,
                    cheque_date: data.ChequeDt
                        ? new Date(data.ChequeDt).toISOString().split("T")[0]
                        : "",
                    money_amount: data.Voucher_Amt,
                    currency: data.Currency,
                    exchange_rate: data.Rate,
                    advance_ledger_no: data.AdvanceNo,
                    advance_ledger_start_date: data.Act_FDt
                        ? new Date(data.Act_FDt).toISOString().split("T")[0]
                        : "",
                    advance_ledger_end_date: data.Act_TDt
                        ? new Date(data.Act_TDt).toISOString().split("T")[0]
                        : "",
                    description_lao: data.DescriptionL,
                    description_eng: data.DescriptionE,
                    status: data.Close_accnt,
                });

                setVoucherRecCnt(data.Rec_Cnt);

                if (data.items.length > 0) {
                    const newItems = data.items.map((item) => {
                        return {
                            voucher_item_id: item.Rec_Cnt,
                            voucher_item_action_type: "update",
                            number_debit: item.Code_Dr,
                            number_credit: item.Code_Cr,
                            item_voucher_type:
                                item.Code_Cr === null ? "debit" : "credit",
                            content: item.DescriptionL,
                            content_en: item.DescriptionE,
                            amount_debit_lak: item.LAK_Dr,
                            amount_credit_lak: item.LAK_Cr,
                            exchange_rate: item.iRate,
                            amount_debit_usd: item.USD_Dr,
                            amount_credit_usd: item.USD_Cr,
                            payment_type:
                                item.PaidCash === "1" ? "cash" : "cheque",
                            currency: item.Currency,
                            account_id: item.AccountCD,
                            account_name:
                                item.account?.AccountNameL +
                                " " +
                                item.account?.AccountNameE,
                            activity_id: item.ActivityID,
                            activity_name:
                                item.activity?.ActivityNameL +
                                " " +
                                item.activity?.ActivityNameE,
                            category_id: item.CateID,
                            category_name:
                                item.activity?.category?.CategoryNameL +
                                " " +
                                item.activity?.category?.CategoryNameE,
                            donor_id: item.DonorID,
                            donor:
                                item.donor?.DonorNameL +
                                " " +
                                item.donor?.DonorNameE,
                            cost_center_id: item.CCtrID,
                            cost_center:
                                item.cost_center?.CCtrNameL +
                                " " +
                                item.cost_center?.CCtrNameE,
                            sub_cost_center_id: item.SCCtrID,
                            sub_cost_center:
                                item.sub_cost_center?.SCCtrNameL +
                                " " +
                                item.sub_cost_center?.SCCtrNameE,
                            item_all_name: {
                                account_name_lao: item.account?.AccountNameL,
                                account_name_eng: item.account?.AccountNameE,
                                donor_name_lao: item.donor?.DonorNameL,
                                donor_name_eng: item.donor?.DonorNameE,
                                activity_name_lao: item.activity?.ActivityNameL,
                                activity_name_eng: item.activity?.ActivityNameE,
                                category_name_lao:
                                    item.activity?.category?.CategoryNameL,
                                category_name_eng:
                                    item.activity?.category?.CategoryNameE,
                                cost_center_name_lao:
                                    item.cost_center?.CCtrNameL,
                                cost_center_name_eng:
                                    item.cost_center?.CCtrNameE,
                                sub_cost_center_name_lao:
                                    item.sub_cost_center?.SCCtrNameL,
                                sub_cost_center_name_eng:
                                    item.sub_cost_center?.SCCtrNameE,
                            },
                        };
                    });

                    setVoucherItems(newItems);
                }
            } else {
                setIsModalAlert(true);
                setMessageAlert("ບໍ່ພົບຂໍ້ມູນບັນຊີນີ້!");
            }
        } catch (error) {
            console.log(error);
        }
    };

    useEffect(() => {
        if (p_voucher_id) {
            fetchGetSingleVoucher(p_voucher_id);
        }
    }, [p_voucher_id]);

    const handleDelete = async (voucherId) => {
        try {
            const response = await axios.delete(
                `/middle-voucher/delete/${voucherId}`
            );
            if (response.status === 200) {
                setStatusDelete({
                    status: "success",
                    message: "ລຶບສໍາເລັດ!",
                });

                setTimeout(() => {
                    window.location.href = "/VoucherAdvanceClear";
                }, 1000);
            } else {
                setStatusDelete({
                    status: "error",
                    message: "ລຶບບໍ່ສໍາເລັດ!",
                });
            }
        } catch (error) {
            console.log(error);
            setStatusDelete({
                status: "error",
                message: "ລຶບບໍ່ສໍາເລັດ!",
            });
        }
    };
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

            <ModalConfirmDeleteComponent
                title={contentModal.title ?? ""}
                isActive={isActiveDelete ?? false}
                setIsActive={setIsActiveDelete}
                id="confirmDeleteVooucher"
            >
                <div
                    className="modal-footer"
                    style={{
                        display: "flex",
                        justifyContent: "center",
                    }}
                >
                    <button
                        type="button"
                        className="btn btn-danger text-white"
                        onClick={() => {
                            handleDelete(selectedVoucherItemId);
                        }}
                    >
                        ລຶບ
                    </button>

                    <button
                        type="button"
                        className="btn btn-secondary text-white"
                        data-bs-dismiss="modal"
                        onClick={() => setIsActiveDelete(false)}
                    >
                        ຍົກເລີກ
                    </button>
                    {
                        <h6
                            className={
                                statusDelete.status === "success"
                                    ? "text-success"
                                    : "text-danger"
                            }
                        >
                            {statusDelete.message}
                        </h6>
                    }
                </div>
            </ModalConfirmDeleteComponent>

            <div className="card">
                <div className="card-body">
                    <MainFormVoucher
                        inputVoucherMain={inputVoucherGeneralMain}
                        setinputVoucherMain={setinputGeneralVoucherMain}
                        voucherType="general_voucher"
                        inputVoucherItems={inputVoucherAdvanceItems}
                        voucherItems={voucherItems}
                        onSubmit={() => {}}
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
                        inputVoucherMain={inputVoucherGeneralMain}
                        voucherItems={voucherItems}
                        setVoucherItems={setVoucherItems}
                        voucherType="general_voucher"
                        actionType="update"
                    />
                </div>
            </div>
            <br />
            <div className="card p-4">
                <div
                    className="form-group"
                    style={{ display: "flex", justifyContent: "space-between" }}
                >
                    <div
                        style={{
                            display: "flex",
                            justifyContent: "space-between",
                            width: "225px",
                        }}
                    >
                        <button
                            className="btn btn-primary text-white"
                            type="submit"
                            onClick={onSubmit}
                            style={{
                                width: "100px",
                            }}
                        >
                            ບັນທຶກ
                        </button>

                        <button
                            className="btn btn-danger text-white"
                            style={{
                                width: "100px",
                            }}
                            onClick={() => {
                                setSelectedVoucherItemId(p_voucher_id);
                                setIsActiveDelete(true);
                                setContentModal({
                                    title: "ຢືນຢັນລຶບຂໍ້ມູນການລົງບັນຊີ",
                                });
                            }}
                        >
                            ລຶບ
                        </button>
                    </div>
                    <a href="/GeneralVoucher" className="btn btn-secondary">
                        ຍົກເລີກ
                    </a>
                </div>
            </div>
        </>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("update-general-voucher")
);

root.render(<UpdateGeneralVoucher />);
