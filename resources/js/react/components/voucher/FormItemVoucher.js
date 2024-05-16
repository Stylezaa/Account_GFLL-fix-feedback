import React, { useEffect, useState } from "react";
import Select from "react-select";

const FormItemVoucher = ({
    inputVoucherItems,
    setinputVoucherItems,
    voucherType = "general",
    accountType,
    handleCancel,
    handleSave,
    selectedCurrencyCode,
    inputVoucherMain,
    accountTypeRow,
}) => {
    const [dataAccount, setDataAccount] = useState([]);
    const [dataDonor, setDataDonor] = useState([]);
    const [dataActivity, setDataActivity] = useState([]);
    const [dataCostCenter, setDataCostCenter] = useState([]);
    const [dataSubCostCenter, setDataSubCostCenter] = useState([]);

    const fetchGetAccount = async (accountType, voucherType) => {
        try {
            const res = await axios.get(
                `/Account/account-api?account_type=${accountType}&voucher_type=${voucherType}`
            );
            if (res.data.length > 0) {
                setDataAccount(res.data);
            } else {
                setDataAccount([]);
            }
        } catch (error) {
            console.log("error fetchGetAccount", error);
        }
    };

    const fetchGetDonor = async () => {
        try {
            const res = await axios.get(`/donors/donors`);
            if (res.data.length > 0) {
                const new_data = res.data.map((item) => {
                    return {
                        ...item,
                        DonorID: item.DonorID,
                        DonorSym: item.DonorSym,
                        DonorNameL:
                            item.DonorSym +
                            " " +
                            item.DonorNameL +
                            " " +
                            item.CurrencyCD,
                        DonorNameE:
                            item.DonorSym +
                            " " +
                            item.DonorNameE +
                            " " +
                            item.CurrencyCD,
                    };
                });
                setDataDonor(new_data);
            } else {
                setDataDonor([]);
            }
        } catch (error) {
            console.log("error fetchGetDonor", error);
        }
    };

    const fetchGetActivity = async () => {
        try {
            const res = await axios.get(`/Activity/activities`);
            if (res.data.length > 0) {
                const new_data = res.data.map((item) => {
                    return {
                        ...item,
                        ActivityID: item.ActivityID,
                        ActivityCD: item.ActivityCD,
                        ActivityNameL: item.ActivityNameL,
                        ActivityNameE: item.ActivityNameE,
                        CategoryID: item.category?.CategoryID,
                        CategoryNameE:
                            item.category?.CategorySym +
                            "-" +
                            item.category?.CategoryNameE,
                        CategoryNameL:
                            item.category?.CategorySym +
                            "-" +
                            item.category?.CategoryNameL,
                    };
                });
                setDataActivity(new_data);
            } else {
                setDataActivity([]);
            }
        } catch (error) {
            console.log("error fetchGetActivity", error);
        }
    };

    const fetchGetCostCenter = async () => {
        try {
            const res = await axios.get(`/CostCenter/costCenters`);
            if (res.data.length > 0) {
                setDataCostCenter(res.data);
            } else {
                setDataCostCenter([]);
            }
        } catch (error) {
            console.log("error fetchGetCostCenter", error);
        }
    };

    const fetchGetSubCostCenter = async () => {
        try {
            const res = await axios.get(`/SubCostCenter/subCostCenters`);
            if (res.data.length > 0) {
                setDataSubCostCenter(res.data);
            } else {
                setDataSubCostCenter([]);
            }
        } catch (error) {
            console.log("error fetchGetSubCostCenter", error);
        }
    };

    useEffect(() => {
        fetchGetDonor();
        fetchGetActivity();
        fetchGetCostCenter();
        fetchGetSubCostCenter();
    }, []);

    useEffect(() => {
        if (accountType !== "" && voucherType) {
            fetchGetAccount(accountType, voucherType);
        }
    }, [accountType, voucherType]);

    const handleSetNameWithId = (
        e,
        data,
        filter_name_lao,
        filter_name_eng,
        FilterId,
        state_name_lao,
        state_name_eng
    ) => {
        const { name, value } = e.target;
        const item = data.find((item) => item[FilterId] === value);
        if (item) {
            setinputVoucherItems({
                ...inputVoucherItems,
                [name]: value,
                item_all_name: {
                    ...inputVoucherItems.item_all_name,
                    [state_name_lao]: item[filter_name_lao],
                    [state_name_eng]: item[filter_name_eng],
                },
            });

            console.log("handleSetNameWithId", item);
        }
    };

    useEffect(() => {
        if (inputVoucherItems.item_selected_activity_id) {
            setinputVoucherItems({
                ...inputVoucherItems,
                item_selected_category_id:
                    dataActivity &&
                    dataActivity.find(
                        (item) =>
                            item.ActivityID ===
                            inputVoucherItems.item_selected_activity_id
                    ).CategoryID,
                item_all_name: {
                    ...inputVoucherItems.item_all_name,
                    category_name_lao:
                        dataActivity &&
                        dataActivity.find(
                            (item) =>
                                item.ActivityID ===
                                inputVoucherItems.item_selected_activity_id
                        ).category?.CategoryNameL,
                    category_name_eng:
                        dataActivity &&
                        dataActivity.find(
                            (item) =>
                                item.ActivityID ===
                                inputVoucherItems.item_selected_activity_id
                        ).category?.CategoryNameE,
                },
            });
        } else {
            setinputVoucherItems({
                ...inputVoucherItems,
                item_selected_category_id: "",
                item_all_name: {
                    ...inputVoucherItems.item_all_name,
                    category_name_lao: "",
                    category_name_eng: "",
                },
            });
        }
    }, [inputVoucherItems.item_selected_activity_id, dataActivity]);

    console.log("inputVoucherItems", inputVoucherItems);
    return (
        <form
            onSubmit={(e) => {
                e.preventDefault();
                handleSave();
            }}
        >
            <div className="row">
                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ເລກບັນຊີ</label>
                        <Select
                            options={dataAccount.map((item) => ({
                                value: item.AccountCD,
                                label: `${item.AccountCD} - ${item.AccountNameL}`,
                            }))}
                            onChange={(selectedOption) => {
                                const e = {
                                    target: {
                                        name: "item_selected_account_id",
                                        value: selectedOption.value,
                                    },
                                };
                                handleSetNameWithId(
                                    e,
                                    dataAccount,
                                    "AccountNameL",
                                    "AccountNameE",
                                    "AccountCD",
                                    "account_name_lao",
                                    "account_name_eng"
                                );
                            }}
                            value={{
                                value: inputVoucherItems.item_selected_account_id,
                                label: `${inputVoucherItems.item_selected_account_id}`,
                            }}
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ເນື້ອໃນການເຄື່ອນໄຫວພາສາ ລາວ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .account_name_lao
                            }
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ເນື້ອໃນການເຄື່ອນໄຫວພາສາ ອັງກິດ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .account_name_eng
                            }
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ທຶນ</label>
                        <Select
                            options={dataDonor.map((item) => ({
                                value: item.DonorID,
                                label: `${item.DonorID} - ${item.DonorNameL}`,
                            }))}
                            onChange={(selectedOption) => {
                                const e = {
                                    target: {
                                        name: "item_selected_donor_id",
                                        value: selectedOption.value,
                                    },
                                };
                                handleSetNameWithId(
                                    e,
                                    dataDonor,
                                    "DonorNameL",
                                    "DonorNameE",
                                    "DonorID",
                                    "donor_name_lao",
                                    "donor_name_eng"
                                );
                            }}
                            value={{
                                value: inputVoucherItems.item_selected_donor_id,
                                label: `${inputVoucherItems.item_selected_donor_id}`,
                            }}
                        />
                    </div>
                </div>

                <div className="col-lg-8 col-md-8 col-sm-6">
                    <div className="form-group">
                        <label>ຊື່ທຶນ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name.donor_name_lao
                            }
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ລະຫັດກິດຈະກຳ</label>
                        <Select
                            options={dataActivity.map((item) => ({
                                value: item.ActivityID,
                                label: `${item.ActivityID} - ${item.ActivityCD} - ${item.ActivityNameL}`,
                            }))}
                            onChange={(selectedOption) => {
                                const e = {
                                    target: {
                                        name: "item_selected_activity_id",
                                        value: selectedOption.value,
                                    },
                                };
                                handleSetNameWithId(
                                    e,
                                    dataActivity,
                                    "ActivityNameL",
                                    "ActivityNameE",
                                    "ActivityID",
                                    "activity_name_lao",
                                    "activity_name_eng"
                                );
                            }}
                            value={{
                                value: inputVoucherItems.item_selected_activity_id,
                                label: `${inputVoucherItems.item_selected_activity_id}`,
                            }}
                        />
                    </div>
                </div>

                <div className="col-lg-8 col-md-8 col-sm-6">
                    <div className="form-group">
                        <label>ຊື່ກິດຈະກຳ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .activity_name_lao
                            }
                            readOnly={true}
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ຮ່ວງລາຍຈ່າຍ</label>
                        <input
                            type="text"
                            className="form-control"
                            name="item_selected_category_id"
                            value={inputVoucherItems.item_selected_category_id}
                            readOnly={true}
                        />
                    </div>
                </div>

                <div className="col-lg-8 col-md-8 col-sm-6">
                    <div className="form-group">
                        <label>ຊື່ຮ່ວງລາຍຈ່າຍ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .category_name_lao
                            }
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ລະຫັດຜູ້ໃຊ້ທຶນ</label>
                        <Select
                            options={dataCostCenter.map((item) => ({
                                value: item.CCtrID,
                                label: `${item.CCtrID} - ${item.CCtrNameL}`,
                            }))}
                            onChange={(selectedOption) => {
                                const e = {
                                    target: {
                                        name: "item_selected_cost_center_id",
                                        value: selectedOption.value,
                                    },
                                };
                                handleSetNameWithId(
                                    e,
                                    dataCostCenter,
                                    "CCtrNameL",
                                    "CCtrNameE",
                                    "CCtrID",
                                    "cost_center_name_lao",
                                    "cost_center_name_eng"
                                );
                            }}
                            value={{
                                value: inputVoucherItems.item_selected_cost_center_id,
                                label: `${inputVoucherItems.item_selected_cost_center_id}`,
                            }}
                        />
                    </div>
                </div>

                <div className="col-lg-8 col-md-8 col-sm-6">
                    <div className="form-group">
                        <label>ຊື່ຜູ້ໃຊ້ທຶນ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .cost_center_name_lao
                            }
                            required={voucherType === "general" ? true : false}
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ລະຫັດຜູ້ໃຊ້ທຶນຍ່ອຍ</label>
                        <Select
                            options={dataSubCostCenter.map((item) => ({
                                value: item.SCCtrID,
                                label: `${item.SCCtrID} - ${item.SCCtrNameL}`,
                            }))}
                            onChange={(selectedOption) => {
                                const e = {
                                    target: {
                                        name: "item_selected_sub_cost_center_id",
                                        value: selectedOption.value,
                                    },
                                };
                                handleSetNameWithId(
                                    e,
                                    dataSubCostCenter,
                                    "SCCtrNameL",
                                    "SCCtrNameE",
                                    "SCCtrID",
                                    "sub_cost_center_name_lao",
                                    "sub_cost_center_name_eng"
                                );
                            }}
                            value={{
                                value: inputVoucherItems.item_selected_sub_cost_center_id,
                                label: `${inputVoucherItems.item_selected_sub_cost_center_id}`,
                            }}
                        />
                    </div>
                </div>

                <div className="col-lg-8 col-md-8 col-sm-6">
                    <div className="form-group">
                        <label>ຊື່ຜູ້ໃຊ້ທຶນຍ່ອຍ</label>
                        <input
                            type="text"
                            className="form-control"
                            value={
                                inputVoucherItems?.item_all_name
                                    .sub_cost_center_name_lao
                            }
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ມູນຄ່າລົງບັນຊີກີບ</label>
                        <input
                            type="number"
                            className="form-control"
                            name="item_money_amount_lak"
                            onChange={(e) => {
                                const updatedInputVoucherItems = {
                                    ...inputVoucherItems,
                                    item_money_amount_lak: parseInt(
                                        e.target.value
                                    ),
                                    item_money_amount_usd: parseFloat(
                                        e.target.value /
                                            inputVoucherItems.item_exchange_rate
                                    ),
                                };
                                setinputVoucherItems(updatedInputVoucherItems);
                            }}
                            required={
                                selectedCurrencyCode === "LAK" ? true : false
                            }
                            disabled={
                                selectedCurrencyCode !== "LAK" ? true : false
                            }
                            value={inputVoucherItems.item_money_amount_lak}
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ອັດຕາແລກປ່ຽນ</label>
                        <input
                            type="number"
                            className="form-control"
                            name="item_exchange_rate"
                            onChange={(e) => {
                                const updatedInputVoucherItems = {
                                    ...inputVoucherItems,
                                    item_exchange_rate: parseInt(
                                        e.target.value
                                    ),
                                    item_money_amount_lak: 0,
                                    item_money_amount_usd: 0,
                                };
                                setinputVoucherItems(updatedInputVoucherItems);
                            }}
                            value={inputVoucherItems.item_exchange_rate || ""}
                        />
                    </div>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-6">
                    <div className="form-group">
                        <label>ມູນຄ່າບັນຊີໂດລາ</label>

                        <input
                            type="number"
                            className="form-control"
                            name="item_money_amount_usd"
                            onChange={(e) => {
                                const updatedInputVoucherItems = {
                                    ...inputVoucherItems,
                                    item_money_amount_usd: parseFloat(
                                        e.target.value
                                    ),
                                    item_money_amount_lak: parseInt(
                                        e.target.value *
                                            inputVoucherItems.item_exchange_rate
                                    ),
                                };
                                setinputVoucherItems(updatedInputVoucherItems);
                            }}
                            required={
                                selectedCurrencyCode === "USD" ? true : false
                            }
                            disabled={
                                selectedCurrencyCode !== "USD" ? true : false
                            }
                            value={inputVoucherItems.item_money_amount_usd}
                        />
                    </div>
                </div>

                <div className="row mt-4">
                    <div className=" col-lg-4 col-md-4 col-sm-6 ">
                        <button
                            type="submit"
                            className="btn btn-primary text-white me-2"
                        >
                            ບັນທຶກ
                        </button>

                        <button
                            type="button"
                            className="btn btn-secondary text-white"
                            data-bs-dismiss="modal"
                            onClick={() => {
                                handleCancel();
                            }}
                        >
                            ຍົກເລີກ
                        </button>
                    </div>
                </div>
            </div>
        </form>
    );
};

export default FormItemVoucher;
