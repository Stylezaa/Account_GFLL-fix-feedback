import React, { useEffect, useState, useRef } from "react";
import TextAlert from "../customComponents/TextAlert";

const MainFormVoucher = ({
    inputVoucherMain,
    setinputVoucherMain,
    voucherType = "general",
    inputVoucherItems,
    voucherItems,
    onSubmit,
    handleCheckSubmit,
}) => {
    const formRef = useRef(null);

    const [dataLevel, setDataLevel] = useState([]);
    const [dataProvince, setDataProvince] = useState([]);
    const [dataDistrict, setDataDistrict] = useState([]);
    const [dataVillage, setDataVillage] = useState([]);
    const [dataPaymentType, setDataPaymentType] = useState([
        {
            key: "cash",
            name: "cash",
        },
        {
            key: "cheque",
            name: "cheque",
        },
    ]);

    const [dataCurrency, setDataCurrency] = useState([]);

    const handleChangedValueInput = (e) => {
        const { name, value } = e.target;
        setinputVoucherMain({
            ...inputVoucherMain,
            [name]: value,
        });
    };

    const fetchAllCurency = async () => {
        try {
            setDataCurrency([]);
            await axios.get(`/currency/currency-api`).then((res) => {
                if (res.status === 200) {
                    const newData = res.data.map((item) => {
                        return {
                            key: item.CurrencyCD,
                            name: item.CurrencyCD,
                        };
                    });

                    setDataCurrency(newData);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataCurrency([]);
        }
    };

    const fetchAllProvince = async () => {
        try {
            setDataProvince([]);
            await axios.get(`/province/province-api`).then((res) => {
                if (res.data) {
                    setDataProvince(res.data);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataProvince([]);
        }
    };

    const fetchAllDistrict = async (province_id) => {
        try {
            if (province_id === "") {
                return;
            }
            setDataDistrict([]);
            setDataVillage([]);
            await axios.get(`/district/district-api`).then((res) => {
                if (res.data) {
                    const district = res.data.filter(
                        (item) => item.ProvinceID === province_id
                    );
                    setDataDistrict(district);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataDistrict([]);
        }
    };

    const fetchAllVillage = async (district_id) => {
        try {
            if (district_id === "") {
                return;
            }

            setDataVillage([]);
            await axios.get(`/village/village-api`).then((res) => {
                if (res.data) {
                    const village = res.data.filter(
                        (item) => item.DistrictID === district_id
                    );
                    setDataVillage(village);

                    return village;
                } else {
                    console.log("error");
                    setDataVillage([]);
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataVillage([]);
        }
    };

    const fetchGetLevel = async () => {
        try {
            const res = await axios.get(`/levels/level-api`);
            if (res.status === 200) {
                res.data &&
                    res.data.map((item) => {
                        setDataLevel((dataLevel) => [
                            ...dataLevel,
                            {
                                key: item.LevelID,
                                name_la: item.LevelNameL,
                                name_en: item.LevelNameE,
                            },
                        ]);
                    });
            } else {
                swalErrorToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນລະດັບໄດ້!");
            }
        } catch (error) {
            swalErrorToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນລະດັບໄດ້!");
        }
    };

    useEffect(() => {
        fetchAllProvince();
        fetchGetLevel();
        fetchAllCurency();
    }, []);
    //clear_advance_ledger
    return (
        <form ref={formRef} autoComplete="off">
            <div className="row">
                <div className="col-lg-6 col-md-12 col-sm-12 p-1 p-1">
                    <label>ເລກທີລະບົບ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ເລກທີລະບົບ"
                        name="voucher_no"
                        value={inputVoucherMain.voucher_no}
                        onChange={handleChangedValueInput}
                        disabled={true}
                    />
                </div>

                {voucherType === "clear_advance_ledger" ? (
                    <div className="col-lg-6 col-md-12 col-sm-12 p-1 p-1">
                        <label>ເລກທີບັນຊີຈ່າຍເງິນລ່ວງໜ້າ</label>
                        <input
                            type="text"
                            className="form-control"
                            placeholder="ເລກທີລະບົບ"
                            name="voucher_no"
                            value={inputVoucherMain.voucher_advance_no}
                            onChange={handleChangedValueInput}
                            disabled={true}
                        />
                    </div>
                ) : (
                    <div className="col-lg-6 col-md-12 col-sm-12 p-1 p-1" />
                )}

                {/* check no and check date */}
                <div className="col-lg-4 col-md-6 col-sm-12 p-1">
                    <label>ເລກທີໃບຍັ້ງຍືນ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ເລກໃບອີງ"
                        name="confirm_no"
                        value={inputVoucherMain.confirm_no}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນເລກທີໃບຍັ້ງຍືນ"
                        value={inputVoucherMain.confirm_no}
                    />
                </div>

                <div className="col-lg-2 col-md-6 col-sm-12 p-1">
                    <label>ວັນທີອອກບິນ</label>
                    <input
                        type="date"
                        className="form-control"
                        placeholder="ວັນທີອອກບິນ"
                        name="confirm_date"
                        value={inputVoucherMain.confirm_date}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນວັນທີອອກບິນ"
                        value={inputVoucherMain.confirm_date}
                    />
                </div>

                <div className="col-lg-4 col-md-6 col-sm-12 p-1">
                    <label>ອີງຕາມ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ອີງຕາມ"
                        name="reference_detail"
                        value={inputVoucherMain.reference_detail}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນອີງຕາມ"
                        value={inputVoucherMain.reference_detail}
                    />
                </div>

                <div className="col-lg-2 col-md-6 col-sm-12 p-1">
                    <label>ອີງຕາມວັນທີ</label>
                    <input
                        type="date"
                        className="form-control"
                        placeholder="ອີງຕາມວັນທີ"
                        name="reference_date"
                        value={inputVoucherMain.reference_date}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນອີງຕາມວັນທີ"
                        value={inputVoucherMain.reference_date}
                    />
                </div>

                <div className="col-lg-3 col-md-3 col-sm-12 p-1 p-1">
                    {/* select */}
                    <label>ຂັນຈັດຕັ້ງປະຕິບັດ</label>
                    <select
                        className="form-select"
                        name="selected_level"
                        value={inputVoucherMain.selected_level}
                        onChange={(e) => {
                            // handleChangedValueInput(e);
                            setinputVoucherMain({
                                ...inputVoucherMain,
                                selected_level: e.target.value,
                                selected_province: "",
                                selected_district: "",
                                selected_village: "",
                            });
                        }}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    >
                        {dataLevel &&
                            dataLevel.map((item) => (
                                <option key={item.key} value={item.key}>
                                    {item.name_la}
                                </option>
                            ))}
                    </select>
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນຂັນຈັດຕັ້ງປະຕິບັດ"
                        value={inputVoucherMain.selected_level}
                    />
                </div>

                <div className="col-lg-3 col-md-3 col-sm-12 p-1">
                    <div className="form-group">
                        <label htmlFor="selected_province">ແຂວງ</label>
                        <select
                            className="form-control"
                            id="selected_province"
                            name="selected_province"
                            value={inputVoucherMain.selected_province}
                            onChange={(e) => {
                                setinputVoucherMain({
                                    ...inputVoucherMain,
                                    selected_province: e.target.value,
                                    selected_district: "",
                                    selected_village: "",
                                });
                                fetchAllDistrict(e.target.value);
                            }}
                            required={
                                inputVoucherMain.selected_level === "P" ||
                                inputVoucherMain.selected_level === "D" ||
                                inputVoucherMain.selected_level === "V"
                                    ? true
                                    : false
                            }
                            disabled={
                                inputVoucherMain.selected_level === "C"
                                    ? true
                                    : false
                            }
                        >
                            <option value="">ເລືອກແຂວງ</option>
                            {dataProvince &&
                                dataProvince.map((province) => (
                                    <option
                                        key={province.ProvinceID}
                                        value={province.ProvinceID}
                                    >
                                        {province.ProvinceNameL}
                                    </option>
                                ))}
                        </select>
                    </div>
                </div>

                <div className="col-lg-3 col-md-3 col-sm-12 p-1">
                    <div className="form-group">
                        <label htmlFor="selected_district">ເມືອງ</label>

                        <select
                            className="form-control"
                            id="selected_district"
                            name="selected_district"
                            value={inputVoucherMain.selected_district}
                            onChange={(e) => {
                                setinputVoucherMain({
                                    ...inputVoucherMain,
                                    selected_district: e.target.value,
                                    selected_village: "",
                                });
                                fetchAllVillage(e.target.value);
                            }}
                            required={
                                inputVoucherMain.selected_level === "D" ||
                                inputVoucherMain.selected_level === "V"
                                    ? true
                                    : false
                            }
                            disabled={
                                inputVoucherMain.selected_level === "C" ||
                                inputVoucherMain.selected_level === "P"
                                    ? true
                                    : false
                            }
                        >
                            <option value="">ເລືອກເມືອງ</option>

                            {dataDistrict &&
                                dataDistrict.map((district) => (
                                    <option
                                        key={district.DistrictID}
                                        value={district.DistrictID}
                                    >
                                        {district.DistrictNameL}
                                    </option>
                                ))}
                        </select>
                    </div>
                </div>

                <div className="col-lg-3 col-md-3 col-sm-12 p-1">
                    <div className="form-group">
                        <label htmlFor="selected_village">ບ້ານ</label>

                        <select
                            className="form-control"
                            id="selected_village"
                            name="selected_village"
                            value={inputVoucherMain.selected_village}
                            onChange={(e) =>
                                setinputVoucherMain({
                                    ...inputVoucherMain,
                                    selected_village: e.target.value,
                                })
                            }
                            required={
                                inputVoucherMain.selected_level === "V"
                                    ? true
                                    : false
                            }
                            disabled={
                                inputVoucherMain.selected_level === "C" ||
                                inputVoucherMain.selected_level === "D" ||
                                inputVoucherMain.selected_level === "P"
                                    ? true
                                    : false
                            }
                        >
                            <option value="">ເລືອກບ້ານ</option>
                            {dataVillage &&
                                dataVillage.map((village) => (
                                    <option
                                        key={village.VillageID}
                                        value={village.VillageID}
                                    >
                                        {village.VillageNameL}
                                    </option>
                                ))}
                        </select>
                    </div>
                </div>

                <div className="col-lg-6 col-md-12 col-sm-12 p-1">
                    {/* select */}
                    <label>ປະເພດການຈ່າຍ</label>
                    <select
                        className="form-select"
                        name="payment_type"
                        value={inputVoucherMain.payment_type}
                        onChange={(e) => {
                            setinputVoucherMain({
                                ...inputVoucherMain,
                                payment_type: e.target.value,
                                cheque_no: "",
                                cheque_date: "",
                            });
                        }}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    >
                        {dataPaymentType.map((item) => (
                            <option key={item.key} value={item.key}>
                                {item.name}
                            </option>
                        ))}
                    </select>
                </div>

                {/* check no and check date */}
                <div className="col-lg-4 col-md-12 col-sm-12 p-1">
                    <label>ເລກທີເຊັກ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ເລກທີເຊັກ"
                        name="cheque_no"
                        value={inputVoucherMain.cheque_no}
                        onChange={handleChangedValueInput}
                        disabled={
                            inputVoucherMain.payment_type === "cash"
                                ? true
                                : false
                        }
                    />
                </div>

                <div className="col-lg-2 col-md-12 col-sm-12 p-1">
                    <label>ວັນທີເຊັກ</label>
                    <input
                        type="date"
                        className="form-control"
                        placeholder="ວັນທີເຊັກ"
                        name="cheque_date"
                        value={inputVoucherMain.cheque_date}
                        onChange={handleChangedValueInput}
                        disabled={
                            inputVoucherMain.payment_type === "cash"
                                ? true
                                : false
                        }
                    />
                </div>

                <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                    <label>ມູນຄ່າບິນ</label>
                    <input
                        type="number"
                        className="form-control"
                        placeholder="ມູນຄ່າບິນ"
                        name="money_amount"
                        value={inputVoucherMain.money_amount}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນມູນຄ່າບິນ"
                        value={inputVoucherMain.money_amount}
                    />
                </div>

                <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                    <label>ອອກເປັນເງິນ</label>
                    <select
                        className="form-select"
                        name="currency"
                        value={inputVoucherMain.currency}
                        onChange={handleChangedValueInput}
                        disabled={
                            voucherItems.length > 0 ||
                            voucherType === "clear_advance_ledger"
                                ? true
                                : false
                        }
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    >
                        <option value="">ເລືອກສະກຸນເງິນ</option>
                        {dataCurrency.map((item) => (
                            <option key={item.key} value={item.key}>
                                {item.name}
                            </option>
                        ))}
                    </select>
                </div>

                <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                    <label>ອັດຕາແລກປ່ຽນ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ອັດຕາ"
                        name="exchange_rate"
                        value={parseFloat(
                            inputVoucherMain.exchange_rate
                        ).toFixed(2)}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນມູນຄ່າບິນ"
                        value={inputVoucherMain.exchange_rate}
                    />
                </div>

                {voucherType === "advance_ledger" && (
                    <>
                        <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                            <label>ເລກທີບິນຈ່າຍລ່ວງໜ້າ</label>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="ເລກທີບິນຈ່າຍລ່ວງໜ້າ"
                                name="advance_ledger_no"
                                value={inputVoucherMain.advance_ledger_no}
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນເລກທີບິນຈ່າຍລ່ວງໜ້າ"
                                value={inputVoucherMain.advance_ledger_no}
                            />
                        </div>

                        <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                            <label>ແຕ່ວັນທີ</label>
                            <input
                                type="date"
                                className="form-control"
                                placeholder="ແຕ່ວັນທີ"
                                name="advance_ledger_start_date"
                                value={
                                    inputVoucherMain.advance_ledger_start_date
                                }
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນແຕ່ວັນທີ"
                                value={
                                    inputVoucherMain.advance_ledger_start_date
                                }
                            />
                        </div>

                        <div className="col-lg-4 col-md-4 col-sm-12 p-1">
                            <label>ຫາວັນທີ</label>
                            <input
                                type="date"
                                className="form-control"
                                placeholder="ຫາວັນທີ"
                                name="advance_ledger_end_date"
                                value={inputVoucherMain.advance_ledger_end_date}
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນແຕ່ຫາວັນທີ"
                                value={inputVoucherMain.advance_ledger_end_date}
                            />
                        </div>

                        <div className="col-lg-6 col-md-6 col-sm-12 p-1">
                            <label>ຈ່າຍໃຫ້</label>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="ຈ່າຍໃຫ້"
                                name="payment_detail"
                                value={inputVoucherMain.payment_detail}
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນຈ່າຍໃຫ້"
                                value={inputVoucherMain.payment_detail}
                            />
                        </div>

                        <div className="col-lg-6 col-md-6 col-sm-12 p-1">
                            <label>ທີ່ຢູ່</label>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="ທີ່ຢູ່"
                                name="address"
                                value={inputVoucherMain.address}
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນທີ່ຢູ່"
                                value={inputVoucherMain.address}
                            />
                        </div>
                    </>
                )}

                {voucherType === "general_voucher" && (
                    <>
                        <div className="col-lg-12 col-md-12 col-sm-12 p-1">
                            <label>ຈ່າຍໃຫ້</label>
                            <input
                                type="text"
                                className="form-control"
                                placeholder="ຈ່າຍໃຫ້"
                                name="payment_detail"
                                value={inputVoucherMain.payment_detail}
                                onChange={handleChangedValueInput}
                                required={
                                    voucherType === "advance_ledger"
                                        ? true
                                        : false
                                }
                            />
                            <TextAlert
                                isShow={handleCheckSubmit}
                                text="ກະລຸນາປ້ອນຂໍ້ມູນຈ່າຍໃຫ້"
                                value={inputVoucherMain.payment_detail}
                            />
                        </div>
                    </>
                )}

                <div className="col-lg-12 col-md-12 col-sm-12 p-1">
                    <label>ລາຍລະອຽດ ລາວ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ລາຍລະອຽດ ລາວ"
                        name="description_lao"
                        value={inputVoucherMain.description_lao}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນລາຍລະອຽດ ລາວ"
                        value={inputVoucherMain.description_lao}
                    />
                </div>

                <div className="col-lg-12 col-md-12 col-sm-12 p-1">
                    <label>ລາຍລະອຽດ ອັງກິດ</label>
                    <input
                        type="text"
                        className="form-control"
                        placeholder="ລາຍລະອຽດ ອັງກິດ"
                        name="description_eng"
                        value={inputVoucherMain.description_eng}
                        onChange={handleChangedValueInput}
                        required={
                            voucherType === "advance_ledger" ? true : false
                        }
                    />
                    <TextAlert
                        isShow={handleCheckSubmit}
                        text="ກະລຸນາປ້ອນຂໍ້ມູນລາຍລະອຽດ ລາວ"
                        value={inputVoucherMain.description_eng}
                    />
                </div>
            </div>
        </form>
    );
};

export default MainFormVoucher;
