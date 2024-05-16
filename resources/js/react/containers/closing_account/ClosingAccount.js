import React from "react";
import ReactDOM from "react-dom/client";

const ClosingAccountContainer = () => {
    return (
        <div className="card">
            <div className="card-header">
                <h4>ການປິດບັນຊີປະຈຳເດືອນ</h4>
            </div>
            <div className="card-body">
                <form>
                    <div className="form-group">
                        <label>ວັນທີປິດບັນຊີ</label>
                        <input type="date" className="form-control" />
                    </div>

                    <div className="form-group">
                        <label>ຂັ້ນຈັດຕັ້ງປະຕິບັດ</label>
                        <select className="form-control"></select>
                    </div>

                    <div className="form-group">
                        <label>ແຂວງ</label>
                        <select className="form-control"></select>
                    </div>

                    <div className="form-group">
                        <label>ເມືອງ</label>
                        <select className="form-control"></select>
                    </div>

                    <div className="form-group">
                        <label>ບ້ານ</label>
                        <select className="form-control"></select>
                    </div>

                    <div className="mt-4">
                        <button className="btn btn-primary">ບັນທຶກ</button>
                        <button className="btn btn-secondary mx-4">
                            ຍົກເລີກ
                        </button>
                    </div>
                </form>
            </div>
        </div>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("closing-account-container")
);

root.render(<ClosingAccountContainer />);
