import React, { useState } from "react";
import ReactDOM from "react-dom/client";
import LocationOption from "../../components/customComponents/LocationOption";

const QuaterBudgetContainer = () => {
    const [reportOption, setReportOption] = useState({
        ProvinceID: "",
        DistrictID: "",
        VillageID: "",
    });

    return (
        <>
            <div className="card">
                <div className="card-header">
                    <h4>ງົບປະມານ ຕາມໄຕມາດ</h4>
                </div>

                <div className="card-body">
                    <div className="row">
                        <div className="col-lg-2  col-md-2  col-sm-12">
                            <div className="form-group">
                                <label>ງົບປະມານປີ</label>
                                <input type="year" className="form-control" />
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
                    <h4>ລາຍການຕາມງົບປະມານ ຕາມໄຕມາດ</h4>
                </div>

                <div className="card-body"
                 style={{
                    overflowX: "auto",
                 }}>
                    <table className="table">
                        <thead>
                            <tr>
                                <th class="text-no-wrap text-center">
                                    ລະຫັດກິດຈະກຳ
                                </th>
                                <th class="text-no-wrap text-center">
                                    ຮ່ວງລາຍຈ່າຍ
                                </th>
                                <th class="text-no-wrap text-center">
                                    ແຜນ BSP
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເນື້ອໃນກິດຈະກຳ
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນກີບ I
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນກີບ II
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນກີບ III
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນກີບ IV
                                </th>
                                <th class="text-no-wrap text-center">
                                    ລວມເງິນກີບໝົດປີ
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນໂດລ່າ I
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນໂດລ່າ II
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນໂດລ່າ III
                                </th>
                                <th class="text-no-wrap text-center">
                                    ເງິນໂດລ່າ IV
                                </th>
                                <th class="text-no-wrap text-center">
                                    ລວມເງິນໂດລ່າໝົດປີ
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
    document.getElementById("quater-budget-container")
);

root.render(<QuaterBudgetContainer />);
