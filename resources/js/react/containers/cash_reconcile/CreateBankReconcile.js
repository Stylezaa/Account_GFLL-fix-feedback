import React from "react";
import ReactDOM from "react-dom/client";
import LocationOption from "../../components/customComponents/LocationOption";

const CreateCashReconcile = () => {
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

    const mockData = [
        {
            id: 1,
            code: "500",
            name: "ໃບ 500",
            amount: 0,
            total: 0,
        },
        {
            id: 2,
            code: "1000",
            name: "ໃບ 1000",
            amount: 0,
            total: 0,
        },
        {
            id: 3,
            code: "2000",
            name: "ໃບ 2000",
            amount: 0,
            total: 0,
        },
        {
            id: 3,
            code: "5000",
            name: "ໃບ 5000",
            amount: 0,
            total: 0,
        },
        {
            id: 3,
            code: "10000",
            name: "ໃບ 10000",
            amount: 0,
            total: 0,
        },
        {
            id: 4,
            code: "20000",
            name: "ໃບ 20000",
            amount: 0,
            total: 0,
        },
        {
            id: 5,
            code: "50000",
            name: "ໃບ 50000",
            amount: 0,
            total: 0,
        },
        {
            id: 6,
            code: "100000",
            name: "ໃບ 100000",
            amount: 0,
            total: 0,
        },
    ];
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
                                <label>ເລກທີໃບສົມທຽບເງິນສົດ</label>
                                <input type="text" className="form-control" />
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <label>ວັນທີອອກໃບສົມທຽບ</label>
                                <input type="date" className="form-control" />
                            </div>

                            <div className="col-lg-3 col-md-3 col-sm-12">
                                <label>ເລກກທີໃບຕິດຕາມ</label>
                                <input type="date" className="form-control" />
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
                                        <div className="form-group">
                                            <label className="text-white">
                                                -
                                            </label>
                                            <button
                                                type="button"
                                                className="btn btn-outline-primary text-primary"
                                                style={{
                                                    width: "100%",
                                                }}
                                            >
                                                ເລືອກລະຫັດບັນຊີ
                                            </button>
                                        </div>
                                    </div>

                                    <div className="col-lg-9 col-md-9 col-sm-12">
                                        <div className="form-group">
                                            <label>ລະຫັດບັນຊີ</label>
                                            <input
                                                type="text"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div className="col-lg-12 col-md-12 col-sm-12 mt-4">
                                <div className="row">
                                    <div className="col-lg-3 col-md-3 col-sm-12 ">
                                        <div className="form-group">
                                            <label className="text-white">
                                                -
                                            </label>
                                            <button
                                                type="button"
                                                className="btn btn-outline-primary text-primary"
                                                style={{
                                                    width: "100%",
                                                }}
                                            >
                                                ການຄິດໄລ່
                                            </button>
                                        </div>
                                    </div>

                                    <div className="col-lg-3 col-md-3 col-sm-12">
                                        <div className="form-group">
                                            <label>ຍອດເຫຼືອຍົກມາ ວັນທີ</label>
                                            <input
                                                type="date"
                                                className="form-control"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <br />
                            <br />

                            <div className="col-lg-12 col-md-12 col-sm-12 mt-5">
                                <div className="row">
                                    <div className="col-lg-3 col-md-3 col-sm-12 ">
                                        <div className="row">
                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>ຍອດຍົກມາ</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>ຮັບເຂົ້າ</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>ຈ່າຍອອກ</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>ຍອດເຫຼືອທ້າຍ</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>

                                            <br />
                                            <br />
                                            <br />
                                            <br />

                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>
                                                        ລວມເງິນສົດນັບໄດ້
                                                    </label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>

                                            <div className="col-lg-12 col-md-12 col-sm-12 ">
                                                <div className="form-group">
                                                    <label>ຜິດດ່ຽງ</label>
                                                    <input
                                                        type="number"
                                                        className="form-control"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div className="col-lg-9 col-md-9 col-sm-9">
                                        <table className="table">
                                            <thead>
                                                <tr>
                                                    <th>ລະຫັດ</th>
                                                    <th>ເນື້ອໃນ</th>
                                                    <th>ຈຳນວນນັບ</th>
                                                    <th>ລວມເປັນເງິນ</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {mockData.map((data, index) => {
                                                    return (
                                                        <tr key={index}>
                                                            <td>{data.code}</td>
                                                            <td>{data.name}</td>
                                                            <td>{data.name}</td>
                                                            <td>{data.name}</td>
                                                        </tr>
                                                    );
                                                })}
                                            </tbody>
                                        </table>
                                    </div>
                                    <div className="col-lg-12 col-md-12 col-sm-12 ">
                                        {/* textare */}
                                        <div className="form-group">
                                            <label>ອະທິບາຍກ່ຽວກັບການຜິດດ່ຽງ</label>
                                            <textarea
                                                className="form-control"
                                                rows="3"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("create-cash-reconcile")
);

root.render(<CreateCashReconcile />);
