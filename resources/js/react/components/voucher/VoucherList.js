import React, { useState } from "react";
import BasicModalComponent from "../customComponents/BasicModalComponent";
import FormItemVoucher from "./FormItemVoucher";
import { numberFormat } from "../../utilities/number_formate";
import ModalConfirmDeleteComponent from "../customComponents/ModalConfirmDelete";
import ModalAlertComponent from "../customComponents/ModalConfirmAlert";
import handlePairTypeMapping from "../../utilities/handlePairTypeMapping";

export const VoucherList = ({
    inputVoucherItems,
    setinputVoucherItems,
    inputVoucherMain,
    voucherItems,
    setVoucherItems,
    voucherType = "general",
    actionType = "create",
}) => {
    console.log("voucherItems", voucherItems);
    const [isActive, setIsActive] = useState(false);
    const [isActiveUpdate, setIsActiveUpdate] = useState(false);
    const [isActiveDelete, setIsActiveDelete] = useState(false);
    const [isActiveMessage, setIsActiveMessage] = useState(false);
    const [contentModal, setContentModal] = useState({
        title: "",
        account_type: "",
        account_type_row: "",
    });
    const [selectedVoucherItemId, setSelectedVoucherItemId] = useState("");
    const [isModalAlert, setIsModalAlert] = useState(false);
    const [messageAlert, setMessageAlert] = useState("");

    // handle balance item_money_amount_lak
    const handleBalance = (value, usageAmount) => {
        return parseFloat(value) - parseFloat(usageAmount);
    };

    const handleCancel = () => {
        const inputMoneyAmount =
            inputVoucherMain && inputVoucherMain.currency === "LAK"
                ? parseFloat(inputVoucherMain.money_amount).toFixed(2)
                : parseFloat(
                      inputVoucherMain.money_amount *
                          inputVoucherMain.exchange_rate
                  ).toFixed(2);

        const inputUsdAmount =
            inputVoucherMain && inputVoucherMain.currency === "USD"
                ? parseFloat(inputVoucherMain.money_amount).toFixed(4)
                : parseFloat(
                      inputVoucherMain.money_amount /
                          inputVoucherMain.exchange_rate
                  ).toFixed(4);

        const handleLAKBalance =
            contentModal.account_type_row === "debit"
                ? handleBalance(
                      inputMoneyAmount,
                      voucherItems.reduce(
                          (acc, item) => acc + item.amount_debit_lak,
                          0
                      )
                  )
                : handleBalance(
                      inputMoneyAmount,
                      voucherItems.reduce(
                          (acc, item) => acc + item.amount_credit_lak,
                          0
                      )
                  );

        const handleUSDBalance =
            contentModal.account_type_row === "debit"
                ? handleBalance(
                      inputUsdAmount,
                      voucherItems.reduce(
                          (acc, item) => acc + item.amount_debit_usd,
                          0
                      )
                  )
                : handleBalance(
                      inputUsdAmount,
                      voucherItems.reduce(
                          (acc, item) => acc + item.amount_credit_usd,
                          0
                      )
                  );

        setIsActive(false);
        setIsActiveUpdate(false);
        setinputVoucherItems({
            item_selected_account_id: "",
            item_selected_donor_id: "",
            item_selected_activity_id: "",
            item_selected_category_id: "",
            item_selected_cost_center_id: "",
            item_selected_sub_cost_center_id: "",
            item_money_amount_lak: handleLAKBalance,
            item_money_amount_usd: handleUSDBalance,
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
        setMessageAlert("");
    };

    const handleSave = () => {
        handlePushDataItems(
            contentModal.account_type_row,
            inputVoucherItems.item_currency
        );
    };

    const handlePushDataItems = (accountType, currencyCode) => {
        const dataItems = {
            voucher_item_id: voucherItems.length + 1,
            voucher_item_action_type: "new",
            item_voucher_type: accountType ?? "",
            number_debit:
                accountType === "debit"
                    ? inputVoucherItems.item_selected_account_id
                    : 0,
            number_credit:
                accountType === "credit"
                    ? inputVoucherItems.item_selected_account_id
                    : 0,
            content: inputVoucherItems.item_all_name.account_name_lao ?? "",
            content_en: inputVoucherItems.item_all_name.account_name_eng ?? "",
            amount_debit_lak:
                accountType === "debit"
                    ? inputVoucherItems.item_money_amount_lak
                    : 0,
            amount_credit_lak:
                accountType === "credit"
                    ? inputVoucherItems.item_money_amount_lak
                    : 0,
            exchange_rate: inputVoucherItems.item_exchange_rate,
            amount_debit_usd:
                accountType === "debit"
                    ? inputVoucherItems.item_money_amount_usd
                    : 0,
            amount_credit_usd:
                accountType === "credit"
                    ? inputVoucherItems.item_money_amount_usd
                    : 0,
            currency: currencyCode,
            account_id: inputVoucherItems.item_selected_account_id,
            account_name:
                inputVoucherItems.item_selected_account_id +
                "-" +
                inputVoucherItems.item_all_name.account_name_lao,
            activity_id: inputVoucherItems.item_selected_activity_id,
            activity_name:
                inputVoucherItems.item_selected_activity_id +
                "-" +
                inputVoucherItems.item_all_name.activity_name_lao,
            category_id: inputVoucherItems.item_selected_category_id,
            category_name:
                inputVoucherItems.item_selected_category_id +
                "-" +
                inputVoucherItems.item_all_name.category_name_lao,
            payment_type: inputVoucherMain.payment_type,
            donor_id: inputVoucherItems.item_selected_donor_id,
            donor:
                inputVoucherItems.item_selected_donor_id +
                "-" +
                inputVoucherItems.item_all_name.donor_name_lao,
            cost_center_id: inputVoucherItems.item_selected_cost_center_id,
            cost_center:
                inputVoucherItems.item_selected_cost_center_id +
                "-" +
                inputVoucherItems.item_all_name.cost_center_name_lao,
            sub_cost_center_id:
                inputVoucherItems.item_selected_sub_cost_center_id,
            sub_cost_center:
                inputVoucherItems.item_selected_sub_cost_center_id +
                "-" +
                inputVoucherItems.item_all_name.sub_cost_center_name_lao,
            item_all_name: {
                account_name_lao:
                    inputVoucherItems.item_all_name.account_name_lao,
                account_name_eng:
                    inputVoucherItems.item_all_name.account_name_eng,
                donor_name_lao: inputVoucherItems.item_all_name.donor_name_lao,
                donor_name_eng: inputVoucherItems.item_all_name.donor_name_eng,
                activity_name_lao:
                    inputVoucherItems.item_all_name.activity_name_lao,
                activity_name_eng:
                    inputVoucherItems.item_all_name.activity_name_eng,
                category_name_lao:
                    inputVoucherItems.item_all_name.category_name_lao,
                category_name_eng:
                    inputVoucherItems.item_all_name.category_name_eng,
                cost_center_name_lao:
                    inputVoucherItems.item_all_name.cost_center_name_lao,
                cost_center_name_eng:
                    inputVoucherItems.item_all_name.cost_center_name_eng,
                sub_cost_center_name_lao:
                    inputVoucherItems.item_all_name.sub_cost_center_name_lao,
                sub_cost_center_name_eng:
                    inputVoucherItems.item_all_name.sub_cost_center_name_eng,
            },
        };

        const checkType = handlePairTypeMapping([...voucherItems, dataItems]);

        if (checkType === "MM") {
            setIsActive(false);

            setTimeout(() => {
                setIsModalAlert(true);
                setMessageAlert("ບໍ່ສາມາດລົງບັນຊີແບບ ຫຼາຍໜີ ແລະ ຫຼາຍມີໄດ້ !");
            }, 500);
            return;
        }

        setVoucherItems([...voucherItems, dataItems]);

        handleCancel();
    };

    const fetchDeleteVoucherItem = async (rec_cnt) => {
        try {
            const response = await axios.delete(
                `/middle-voucher/delete/item/${rec_cnt}`
            );
            if (response.status === 200) {
                setIsModalAlert(true);
                setMessageAlert("ລຶບສໍາເລັດ!");
            } else {
                setIsModalAlert(true);
                setMessageAlert("ລຶບບໍ່ສໍາເລັດ!");
            }
        } catch (error) {
            console.log(error);
        }
    };

    const handleDeleteItem = (id) => {
        const newItems = voucherItems.filter(
            (item) => parseInt(item.voucher_item_id) !== parseInt(id)
        );

        setVoucherItems(newItems);
        setIsActiveDelete(false);

        if (actionType === "update") {
            fetchDeleteVoucherItem(id);
        }
    };

    const handleUpdate = () => {
        updateItem(selectedVoucherItemId);
    };

    const updateItem = (id) => {
        const updatedItems = voucherItems.map((item) => {
            if (parseInt(item.voucher_item_id) === parseInt(id)) {
                const {
                    item_voucher_type,
                    item_selected_account_id,
                    item_all_name,
                    item_money_amount_lak,
                    item_exchange_rate,
                    item_money_amount_usd,
                    item_currency,
                    item_selected_activity_id,
                    item_selected_category_id,
                    payment_type,
                    item_selected_donor_id,
                    item_selected_cost_center_id,
                    item_selected_sub_cost_center_id,
                } = inputVoucherItems;

                const {
                    account_name_lao,
                    account_name_eng,
                    donor_name_lao,
                    donor_name_eng,
                    activity_name_lao,
                    activity_name_eng,
                    category_name_lao,
                    category_name_eng,
                    cost_center_name_lao,
                    cost_center_name_eng,
                    sub_cost_center_name_lao,
                    sub_cost_center_name_eng,
                } = item_all_name;

                return {
                    ...item,
                    item_voucher_type,
                    number_debit:
                        item_voucher_type === "debit"
                            ? item_selected_account_id
                            : 0,
                    number_credit:
                        item_voucher_type === "credit"
                            ? item_selected_account_id
                            : 0,
                    content: item_all_name.account_name_lao,
                    content_en: item_all_name.account_name_eng,
                    amount_debit_lak:
                        item_voucher_type === "debit"
                            ? item_money_amount_lak
                            : 0,
                    amount_credit_lak:
                        item_voucher_type === "credit"
                            ? item_money_amount_lak
                            : 0,
                    exchange_rate: item_exchange_rate,
                    amount_debit_usd:
                        item_voucher_type === "debit"
                            ? item_money_amount_usd
                            : 0,
                    amount_credit_usd:
                        item_voucher_type === "credit"
                            ? item_money_amount_usd
                            : 0,
                    currency: item_currency,
                    account_id: item_selected_account_id,
                    account_name: `${item_selected_account_id}-${account_name_lao}`,
                    activity_id: item_selected_activity_id,
                    activity_name: `${item_selected_activity_id}-${activity_name_lao}`,
                    category_id: item_selected_category_id,
                    category_name: `${item_selected_category_id}-${category_name_lao}`,
                    payment_type,
                    donor_id: item_selected_donor_id,
                    donor: `${item_selected_donor_id}-${donor_name_lao}`,
                    cost_center_id: item_selected_cost_center_id,
                    cost_center: `${item_selected_cost_center_id}-${cost_center_name_lao}`,
                    sub_cost_center_id: item_selected_sub_cost_center_id,
                    sub_cost_center: `${item_selected_sub_cost_center_id}-${sub_cost_center_name_lao}`,
                    item_all_name: {
                        account_name_lao,
                        account_name_eng,
                        donor_name_lao,
                        donor_name_eng,
                        activity_name_lao,
                        activity_name_eng,
                        category_name_lao,
                        category_name_eng,
                        cost_center_name_lao,
                        cost_center_name_eng,
                        sub_cost_center_name_lao,
                        sub_cost_center_name_eng,
                    },
                };
            }

            return item;
        });

        setVoucherItems(updatedItems);
        handleCancel();
    };

    const handleGetVoucherItem = (id) => {
        const item = voucherItems.find((item) => item.voucher_item_id === id);

        setinputVoucherItems({
            voucher_item_id: item.voucher_item_id,
            voucher_item_action_type: item.voucher_item_action_type,
            item_selected_account_id: item.account_id,
            item_selected_donor_id: item.donor_id,
            item_selected_activity_id: item.activity_id,
            item_selected_category_id: item.category_id,
            item_selected_cost_center_id: item.cost_center_id,
            item_selected_sub_cost_center_id: item.sub_cost_center_id,
            item_money_amount_lak:
                item.item_voucher_type === "debit"
                    ? parseFloat(item.amount_debit_lak).toFixed(2)
                    : parseFloat(item.amount_credit_lak).toFixed(2),
            item_money_amount_usd:
                item.item_voucher_type === "debit"
                    ? parseFloat(item.amount_debit_usd).toFixed(2)
                    : parseFloat(item.amount_credit_usd).toFixed(2),
            item_currency: item.currency,
            item_exchange_rate: item.exchange_rate,
            item_voucher_type: item.item_voucher_type,
            item_all_name: {
                account_name_lao: item.item_all_name.account_name_lao,
                account_name_eng: item.item_all_name.account_name_eng,
                donor_name_lao: item.item_all_name.donor_name_lao,
                donor_name_eng: item.item_all_name.donor_name_eng,
                activity_name_lao: item.item_all_name.activity_name_lao,
                activity_name_eng: item.item_all_name.activity_name_eng,
                category_name_lao: item.item_all_name.category_name_lao,
                category_name_eng: item.item_all_name.category_name_eng,
                cost_center_name_lao: item.item_all_name.cost_center_name_lao,
                cost_center_name_eng: item.item_all_name.cost_center_name_eng,
                sub_cost_center_name_lao:
                    item.item_all_name.sub_cost_center_name_lao,
                sub_cost_center_name_eng:
                    item.item_all_name.sub_cost_center_name_eng,
            },
        });
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
                        flexDirection: "column",
                    }}
                >
                    <h6>{messageAlert}</h6>
                    <button
                        type="button "
                        className="btn btn-danger text-white"
                        data-bs-dismiss="modal"
                        onClick={() => {
                            setIsModalAlert(false);
                            handleCancel();
                        }}
                    >
                        ຕົກລົງ
                    </button>
                </div>
            </ModalAlertComponent>

            <ModalAlertComponent
                title={"ແຈ້ງເຕືອນ"}
                isActive={isActiveMessage ?? false}
                setIsActive={setIsActiveMessage}
                id="AlertModalAddItem"
            >
                <div
                    className="modal-footer"
                    style={{
                        flexDirection: "column",
                    }}
                >
                    <h6>ກະລູນາເພີ່ມບັນຊີໜີ້ກ່ອນ</h6>
                    <button
                        type="button "
                        className="btn btn-danger text-white"
                        data-bs-dismiss="modal"
                        onClick={() => {
                            setIsActiveMessage(false);
                            handleCancel();
                        }}
                    >
                        ຕົກລົງ
                    </button>
                </div>
            </ModalAlertComponent>

            <BasicModalComponent
                title={contentModal.title ?? ""}
                isActive={isActive ?? false}
                setIsActive={setIsActive}
                id="create-voucher"
            >
                <FormItemVoucher
                    inputVoucherItems={inputVoucherItems}
                    setinputVoucherItems={setinputVoucherItems}
                    voucherType={voucherType}
                    accountType={contentModal.account_type ?? ""}
                    handleCancel={handleCancel}
                    handleSave={handleSave}
                    selectedCurrencyCode={inputVoucherMain.currency}
                    inputVoucherMain={inputVoucherMain}
                />
            </BasicModalComponent>

            <BasicModalComponent
                title={contentModal.title ?? ""}
                isActive={isActiveUpdate ?? false}
                setIsActive={setIsActiveUpdate}
                id="update-voucher"
            >
                <FormItemVoucher
                    inputVoucherItems={inputVoucherItems}
                    setinputVoucherItems={setinputVoucherItems}
                    voucherType={voucherType}
                    accountType={inputVoucherItems.item_voucher_type ?? ""}
                    handleCancel={handleCancel}
                    handleSave={handleUpdate}
                    selectedCurrencyCode={inputVoucherMain.currency}
                    inputVoucherMain={inputVoucherMain}
                />
            </BasicModalComponent>

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
                            handleDeleteItem(selectedVoucherItemId);
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
                </div>
            </ModalConfirmDeleteComponent>

            <div
                style={{
                    overflow: "auto",
                }}
            >
                <table className="table " style={{ width: "100%" }}>
                    <thead>
                        <tr>
                            <th className="text-center px-1"></th>
                            <th className="text-center px-1">ລຳດັບ</th>
                            <th className="text-center px-1">ເລກບັນຊີໜີ້</th>
                            <th className="text-center px-1">ເລກບັນຊີມີ</th>
                            <th className="text-center px-1">ເນື້ອໃນລາຍການ</th>
                            <th className="text-center px-1">
                                ມູນຄ່າລົງໜີ້ກີບ
                            </th>
                            <th className="text-center px-1">ມູນຄ່າລົງມີກີບ</th>
                            <th className="text-center px-1">ອັດຕາ</th>
                            <th className="text-center px-1">
                                ມູນຄ່າລົງໜີ້ໂດລາ
                            </th>
                            <th className="text-center px-1">
                                ມູນຄ່າລົງມີໂດລາ
                            </th>
                            <th className="text-center px-1">ປະເພດການຈ່າຍ</th>
                            <th className="text-center px-1">ກິດຈະກໍາ</th>
                            <th className="text-center px-1">ຮ່ວງລາຍຈ່າຍ</th>
                            <th className="text-center px-1">ທຶນ</th>
                            <th className="text-center px-1">ຜູ້ນໍາໃຊ້ທຶນ</th>
                            <th className="text-center px-1">
                                ຜູ້ນໍາໃຊ້ທຶນຍ່ອຍ
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        {voucherItems.map((item, index) => (
                            <tr key={index + 1}>
                                <td
                                    style={{
                                        minWidth: "120px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {/* icon delete and update */}
                                    <button
                                        onClick={() => {
                                            handleGetVoucherItem(
                                                item.voucher_item_id
                                            );
                                            setSelectedVoucherItemId(
                                                item.voucher_item_id
                                            );
                                            setIsActiveUpdate(true);
                                            setContentModal({
                                                title: "ແກ້ໄຂລາຍການ",
                                            });
                                        }}
                                        className="btn btn-warning btn-sm"
                                    >
                                        <i className="fas fa-edit"></i>
                                    </button>

                                    <button
                                        onClick={() => {
                                            setSelectedVoucherItemId(
                                                item.voucher_item_id
                                            );
                                            setIsActiveDelete(true);
                                            setContentModal({
                                                title: "ຢືນຢັນລົບລາຍການ",
                                            });
                                        }}
                                        className="btn btn-danger btn-sm ms-2"
                                        disabled={
                                            index < voucherItems.length - 1
                                        }
                                    >
                                        <i className="fas fa-trash"></i>
                                        {}
                                    </button>
                                </td>
                                <td
                                    style={{
                                        minWidth: "25px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {index + 1}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.number_debit}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.number_credit}
                                </td>
                                <td
                                    style={{
                                        minWidth: "200px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.content}
                                </td>
                                <td
                                    style={{
                                        minWidth: "125px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.amount_debit_lak
                                        ? numberFormat(item.amount_debit_lak)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "125px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.amount_credit_lak
                                        ? numberFormat(item.amount_credit_lak)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "50px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.exchange_rate
                                        ? numberFormat(item.exchange_rate)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.amount_debit_usd
                                        ? parseFloat(
                                              item.amount_debit_usd
                                          ).toFixed(4)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.amount_credit_usd
                                        ? parseFloat(
                                              item.amount_credit_usd
                                          ).toFixed(4)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.payment_type}
                                </td>
                                <td
                                    style={{
                                        minWidth: "250px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.activity_name}
                                </td>
                                <td
                                    style={{
                                        minWidth: "250px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.category_name}
                                </td>
                                <td
                                    style={{
                                        minWidth: "250px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.donor}
                                </td>
                                <td
                                    style={{
                                        minWidth: "250px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.cost_center}
                                </td>
                                <td
                                    style={{
                                        minWidth: "250px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.sub_cost_center}
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>

                <br />

                <div className="row">
                    <div className="col-lg-12 col-md-12 col-sm-12">
                        <button
                            className="btn btn-info me-4"
                            onClick={() => {
                                handleCancel();
                                setContentModal({
                                    title: "ເພີ່ມລາຍການບັນຊີໜີ້",
                                    account_type_row: "debit",
                                    account_type:
                                        voucherType === "advance_ledger"
                                            ? "debit"
                                            : voucherType ===
                                              "clear_advance_ledger"
                                            ? "credit"
                                            : "credit",
                                });
                                setIsActive(true);
                            }}
                        >
                            ເລືອກບັນຊີໜີ້
                        </button>
                        <button
                            className="btn btn-info"
                            onClick={() => {
                                if (voucherItems.length !== 0) {
                                    handleCancel();
                                    setContentModal({
                                        title: "ເພີ່ມລາຍການບັນຊີມີ",
                                        account_type_row: "credit",
                                        account_type:
                                            voucherType === "advance_ledger"
                                                ? "credit"
                                                : voucherType ===
                                                  "clear_advance_ledger"
                                                ? "debit"
                                                : voucherType ===
                                                  "general_voucher"
                                                ? "credit"
                                                : "debit",
                                    });
                                    setIsActive(true);
                                } else {
                                    setIsActiveMessage(true);
                                }
                            }}
                        >
                            ເລືອກບັນຊີມີ
                        </button>
                    </div>
                </div>
            </div>
        </>
    );
};
