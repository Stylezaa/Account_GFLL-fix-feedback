import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import LocationOption from "../../components/customComponents/LocationOption";

const OpeningBalanceContainer = () => {
    const [reportOption, setReportOption] = useState({
        ProvinceID: "",
        DistrictID: "",
        VillageID: "",
    });

    return (
        <>
            <div className="card">
                <div className="card-header">
                    <h4>ຍອດຍົກມາປະຈຳເດືອນ</h4>
                </div>

                <div className="card-body">
                    <div className="row">
                        <div className="col-lg-2  col-md-2  col-sm-12">
                            <div className="form-group">
                                <label>ລະຫັດບັນຊີ</label>
                                <input type="text" className="form-control" />
                            </div>
                        </div>

                        <div className="col-lg-2  col-md-2  col-sm-12">
                            <div className="form-group">
                                <label>ປະຈຳເດືອນ</label>
                                <input type="month" className="form-control" />
                            </div>
                        </div>

                        <div className="col-lg-2  col-md-2  col-sm-12">
                            <div className="form-group">
                                <label>ຂັ້ນຈັດຕັ້ງປະຕິບັດ</label>
                                <select className="form-control">
                                    <option value="">-- ເລືອກ --</option>
                                </select>
                            </div>
                        </div>

                        <div className="col-lg-6 col-md-6 col-sm-12">
                            <LocationOption
                                inputValues={reportOption}
                                setInputValues={setReportOption}
                            />
                        </div>
                    </div>
                    
                    <br />
                    
                    <div>
                        <button className="btn btn-primary">ຄົ້ນຫາ</button>
                    </div>
                </div>
            </div>

            <br />

            <div className="card">
                <div className="card-header">
                    <h4>ລາຍການຍອດຍົກມາ</h4>
                </div>

                <div className="card-body">
                    <table className="table">
                        <thead>
                            <tr>
                                <th
                                    class="text-center text-no-wrap"
                                    width="150"
                                >
                                    ລ/ດ
                                </th>
                                <th
                                    class="text-center text-no-wrap"
                                    width="450"
                                >
                                    ວັນທີ່
                                </th>
                                <th class="text-center text-no-wrap">
                                    ລະຫັດບັນຊີ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ລາຍການບັນຊີ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ມູນຄ່າໜີ້ກີບ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ມູນຄ່າມີກີບ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ມູນຄ່າໜີ້ໂດລ່າ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ມູນຄ່າມີໂດລ່າ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ວັນທີ່ເຄື່ອນໄຫວ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ຜູ້ທີ່ເຄື່ອນໄຫວ
                                </th>
                                <th class="text-center text-no-wrap">
                                    ເຄື່ອງທີ່ເຄື່ອນໄຫວ
                                </th>
                            </tr>
                        </thead>
                        <tbody></tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("opening-balance-container")
);

root.render(<OpeningBalanceContainer />);
