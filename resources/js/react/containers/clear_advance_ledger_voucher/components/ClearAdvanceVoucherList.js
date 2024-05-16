import React, { useState, useEffect } from "react";
import { numberFormat } from "../../../utilities/number_formate";

const ClearAdvanceVoucherList = ({
    setinputClearAdvanceVoucherMain,
    setIsModalSearchAdvanceLedger,
}) => {
    const [dataAdvanceVoucher, setDataAdvanceVoucher] = useState([]);
    const [inputValueSearch, setInputValueSearch] = useState({
        voucher_no: "",
        start_date: "",
        end_date: "",
    });

    const fetchGetAdvanceVoucher = async (isClick) => {
        try {
            if (isClick) {
                var response = await axios.get(
                    `/VoucherAdvance/voucher-json?voucherNo=${inputValueSearch.voucher_no}&startDate=${inputValueSearch.start_date}&presentDate=${inputValueSearch.end_date}`
                );
            } else {
                var response = await axios.get(`/VoucherAdvance/voucher-json`);
            }
            const data = response.data;

            if (data) {
                setDataAdvanceVoucher(data);
            } else {
                setDataAdvanceVoucher([]);
            }
        } catch (error) {
            console.log(error);
        }
    };

    useEffect(() => {
        fetchGetAdvanceVoucher(false);
    }, []);

    const handleSelectAdvanceVoucher = (item) => {
        setinputClearAdvanceVoucherMain({
            voucher_id: "",
            voucher_no: "",
            voucher_advance_no: item.Vch_AutoNo,
            selected_level: item.LevelID,
            selected_province: item.ProvinceID,
            selected_district: item.DistrictID,
            selected_village: item.VillageID,
            confirm_no: "",
            confirm_date: item.VoucherDt
                ? new Date(item.VoucherDt).toISOString().split("T")[0]
                : "",
            reference_detail: item.Refer,
            reference_date: item.ReferDt
                ? new Date(item.ReferDt).toISOString().split("T")[0]
                : "",
            payment_detail: item.Pay_to,
            address: item.Pay_to_Address,
            payment_type: item.PaidCash === "1" ? "cash" : "cheque",
            cheque_no: item.ChequeNo,
            cheque_date: item.ChequeDt
                ? new Date(item.ChequeDt).toISOString().split("T")[0]
                : "",
            money_amount: item.Voucher_Amt,
            currency: item.Currency,
            exchange_rate: item.Rate,
            advance_ledger_no: item.AdvanceNo,
            advance_ledger_start_date: item.Act_FDt
                ? new Date(item.Act_FDt).toISOString().split("T")[0]
                : "",
            advance_ledger_end_date: item.Act_TDt
                ? new Date(item.Act_TDt).toISOString().split("T")[0]
                : "",
            description_lao: item.DescriptionL,
            description_eng: item.DescriptionE,
            status: item.Close_accnt,
        });

        setIsModalSearchAdvanceLedger(false);
    };

    return (
        <>
            <div
                style={{
                    overflow: "auto",
                }}
            >
                {/* input search input no,  start date end date */}
                <div className="row">
                    <div className="col-md-3">
                        <div className="form-group">
                            <label htmlFor="searchVoucherNo">
                                ເລກທີໃບຍັ້ງຍືນ
                            </label>
                            <input
                                type="text"
                                className="form-control"
                                id="searchVoucherNo"
                                name="searchVoucherNo"
                                onChange={(e) => {
                                    setInputValueSearch({
                                        ...inputValueSearch,
                                        voucher_no: e.target.value,
                                    });
                                }}
                            />
                        </div>
                    </div>
                    <div className="col-md-3">
                        <div className="form-group">
                            <label htmlFor="searchStartDate">ວັນທີເລີ່ມ</label>
                            <input
                                type="date"
                                className="form-control"
                                id="searchStartDate"
                                name="searchStartDate"
                                onChange={(e) => {
                                    setInputValueSearch({
                                        ...inputValueSearch,
                                        start_date: e.target.value,
                                    });
                                }}
                            />
                        </div>
                    </div>
                    <div className="col-md-3">
                        <div className="form-group">
                            <label htmlFor="searchEndDate">ວັນທີສໍາເລັດ</label>
                            <input
                                type="date"
                                className="form-control"
                                id="searchEndDate"
                                name="searchEndDate"
                                onChange={(e) => {
                                    setInputValueSearch({
                                        ...inputValueSearch,
                                        end_date: e.target.value,
                                    });
                                }}
                            />
                        </div>
                    </div>
                    {/* button */}
                    <div className="col-md-3">
                        <div className="form-group">
                            <button
                                type="button"
                                className="btn btn-primary mt-5 text-white"
                                id="searchBtn"
                                name="searchBtn"
                                onClick={
                                    () => fetchGetAdvanceVoucher(true)
                                    // console.log(inputValueSearch)
                                }
                            >
                                ຄົ້ນຫາ
                            </button>
                        </div>
                    </div>
                </div>
                {/* end input search input no,  start date end date */}
                {/* table */}
                <br />

                <table className="table " style={{ width: "100%" }}>
                    <thead>
                        <tr>
                            <th className="text-center px-1"></th>
                            <th className="text-center px-1">ເລກທີໃບຍັ້ງຍືນ</th>
                            <th className="text-center px-1">ວັນທີ</th>
                            <th className="text-center px-1">
                                ເລກທີບິນຈ່າຍຫຼ່ວງໜ້າ
                            </th>
                            <th className="text-center px-1">
                                ມູນຄ່າຈ່າຍລ່ວງໜ້າ
                            </th>
                            <th className="text-center px-1">ສະກຸນເງິນ</th>
                            <th className="text-center px-1">ວັນທີເລີ່ມ</th>
                            <th className="text-center px-1">ວັນທີສໍາເລັດ</th>
                            <th className="text-center px-1">ຈ່າຍໃຫ້</th>
                            <th className="text-center px-1">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        {dataAdvanceVoucher.map((item, index) => (
                            <tr key={index + 1}>
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
                                    {item.VoucherNo}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.VoucherDt}
                                </td>
                                <td
                                    style={{
                                        minWidth: "200px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.AdvanceNo}
                                </td>
                                <td
                                    style={{
                                        minWidth: "125px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.Voucher_Amt
                                        ? numberFormat(item.Voucher_Amt)
                                        : 0}
                                </td>
                                <td
                                    style={{
                                        minWidth: "125px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.Currency}
                                </td>
                                <td
                                    style={{
                                        minWidth: "50px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.Act_FDt}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.Act_TDt}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    {item.Pay_to}
                                </td>
                                <td
                                    style={{
                                        minWidth: "100px",
                                    }}
                                    className="text-center px-1"
                                >
                                    <button
                                        className="btn btn-primary"
                                        style={{
                                            padding: "5px 10px",
                                        }}
                                        onClick={() =>
                                            handleSelectAdvanceVoucher(item)
                                        }
                                    >
                                        ເລືອກ
                                    </button>
                                </td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </>
    );
};

export default ClearAdvanceVoucherList;
