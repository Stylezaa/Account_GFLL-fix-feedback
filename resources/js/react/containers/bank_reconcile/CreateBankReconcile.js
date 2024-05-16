import React from "react";
import ReactDOM from "react-dom/client";
import LocationOption from "../../components/customComponents/LocationOption";

const CreateBankReconcile = () => {
    const [inputValues, setInputValues] = React.useState({
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
        money_amount: 0,
        currency: "LAK",
        exchange_rate: 23000,
        advance_ledger_no: "",
        advance_ledger_start_date: "",
        advance_ledger_end_date: "",
        description_lao: "",
        description_eng: "",
        status: "",
    });
    return (
        <div>
            <div className="card">
                <div className="card-header">
                    <h4>ໃຍສົມທົບຍອດເງິນບັນຊີທະນາຄານ</h4>
                </div>
                <div className="card-body">
                    <form>
                        <div className="row mb-3">
                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <label>ເລກທີລະບົບ</label>
                                <input type="text" className="form-control" />
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <label>ເລກທີໃບສົມທຽບ</label>
                                <input type="text" className="form-control" />
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <label>ວັນທີໃບສົມທຽບ</label>
                                <input type="date" className="form-control" />
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <div className="form-group">
                                    <label>ຂັ້ນຈັດຕັ້ງປະຕິບັດ</label>
                                    <select className="form-control"></select>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9">
                                <LocationOption
                                    inputValues={inputValues}
                                    setInputValues={setInputValues}
                                />
                            </div>

                            <br />

                            <div className="col-lg-12 col-md-12 col-sm-12 mt-4">
                                <div className="row">
                                    <div className="col-lg-3 col-md-3 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <button
                                                type="button"
                                                className="btn btn-outline-primary text-primary"
                                            >
                                                ເລືອກບັນຊີເງິນຝາກ
                                            </button>
                                        </div>
                                    </div>

                                    <div className="col-lg-9 col-md-9 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="text"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>ສົມທົບເງິນໃນເດືອນ</label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="date"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <button
                                            type="button"
                                            className="btn btn-outline-primary text-primary"
                                        >
                                            ການຄິດໄລ່
                                        </button>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>
                                                ຍອດເຫຼືອບັນຊີຕົ້ນເດືອນ
                                            </label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>Add Receive</label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>
                                                ລົບ: ຈຳນວນເງິນໃນເດືອນ
                                                (ປຶ້ໝບັນຊີທະນາຄານ)
                                            </label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>
                                                ຍອດເຫຼືອທ້າຍເດືອນ
                                                ປຶ້ມບັນຊີທະນາຄານ
                                            </label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br />
                            <br />
                            <br />

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>
                                                ຍອດເຫຼືອທະນາຄານ
                                                (ຕາມບັນຊີສຳຮອງທະນາຄານ)
                                            </label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label
                                                style={{
                                                    marginRight: "10px",
                                                }}
                                            >
                                                ບວກ{" "}
                                            </label>
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label
                                                style={{
                                                    marginRight: "10px",
                                                }}
                                            >
                                                ລົບ{" "}
                                            </label>
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br />
                            <br />
                            <br />
                            <div className="col-lg-9 col-md-9 col-sm-9 mt-4">
                                <div className="row">
                                    <div className="col-lg-4 col-md-4 col-sm-12 ">
                                        <div
                                            className="form-group float-right"
                                            style={{
                                                display: "flex",
                                                justifyContent:
                                                    "justify-content-center",
                                                alignItems: "center",
                                            }}
                                        >
                                            <label>ຍອດເຫຼືອທະນາຄານ</label>
                                        </div>
                                    </div>

                                    <div className="col-lg-4 col-md-4 col-sm-12">
                                        <div className="form-group">
                                            <input
                                                type="number"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div className="row">
                            <div className="col-lg-12 col-md-12 col-sm-12">
                                <button
                                    type="submit"
                                    className="btn btn-primary text-white"
                                >
                                    ບັນທຶກ
                                </button>
                                <button className="btn btn-secondary text-white mx-3">
                                    ຍົກເລີກ
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("create-bank-reconcile")
);

root.render(<CreateBankReconcile />);
