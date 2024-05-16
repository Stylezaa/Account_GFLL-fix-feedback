import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import LocationOption from "../../components/customComponents/LocationOption";

const ProjectBudgetContainer = () => {
    const [reportOption, setReportOption] = useState({
        ProvinceID: "",
        DistrictID: "",
        VillageID: "",
    });

    return (
        <>
            <div className="card">
                <div className="card-header">
                    <h4>ການຂຶ້ນງົບປະມານທັງໝົດຂອງໂຄງການ</h4>
                </div>

                <div className="card-body">
                    <div className="row">
                        <div className="col-lg-2  col-md-2  col-sm-12">
                            <div className="form-group">
                                <label>ອັດຕາແລກປ່ຽນ ກີບ-ໂດລາ</label>
                                <input type="text" className="form-control" />
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
                    <h4>ລາຍງົບປະມານທັງໝົດຂອງໂຄງການ</h4>
                </div>

                <div className="card-body">
                    <table className="table">
                        <thead>
                            <tr>
                                <th class="text-center">ລະຫັດກິດຈະກຳ</th>
                                <th class="text-center">ຮ່ວງລາຍຈ່າຍ</th>
                                <th class="text-center">ແຜນ BSP</th>
                                <th class="text-center">ເນື້ອໃນກິດຈະກຳ</th>
                                <th class="text-right">ມູນຄ່າງົບປະມານກີບ</th>
                                <th class="text-center">ອັດຕາ</th>
                                <th class="text-right">ມູນຄ່າງົບປະມານໂດລ້າ</th>
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
    document.getElementById("project-budget-container")
);

root.render(<ProjectBudgetContainer />);
