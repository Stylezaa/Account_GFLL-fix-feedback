import React, { useEffect, useState } from "react";

const LocationOption = ({ inputValues, setInputValues }) => {
    const [provinces, setProvinces] = useState([]);
    const [districts, setDistricts] = useState([]);
    const [villages, setVillages] = useState([]);

    const fetchAllProvince = async () => {
        try {
            setProvinces([]);
            await axios.get(`/province/province-api`).then((res) => {
                if (res.data) {
                    setProvinces(res.data);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setProvinces([]);
        }
    };

    const fetchAllDistrict = async (province_id) => {
        try {
            if (province_id === "") {
                return;
            }
            setDistricts([]);
            setVillages([]);
            await axios.get(`/district/district-api`).then((res) => {
                if (res.data) {
                    const district = res.data.filter(
                        (item) => item.ProvinceID === province_id
                    );
                    setDistricts(district);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDistricts([]);
        }
    };

    const fetchAllVillage = async (district_id) => {
        try {
            if (district_id === "") {
                return;
            }

            setVillages([]);
            await axios.get(`/village/village-api`).then((res) => {
                if (res.data) {
                    const village = res.data.filter(
                        (item) => item.DistrictID === district_id
                    );
                    setVillages(village);

                    return village;
                } else {
                    console.log("error");
                    setVillages([]);
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setVillages([]);
        }
    };

    useEffect(() => {
        fetchAllProvince();
    }, []);

    useEffect(() => {
        if (
            inputValues.ProvinceID !== "" &&
            inputValues.ProvinceID !== undefined
        ) {
            fetchAllDistrict(inputValues.ProvinceID);
        }
    }, [inputValues.ProvinceID]);

    useEffect(() => {
        if (
            inputValues.DistrictID !== "" &&
            inputValues.DistrictID !== undefined
        ) {
            fetchAllVillage(inputValues.DistrictID);
        }
    }, [inputValues.DistrictID]);

    return (
        <div className="row">
            <div className="col-lg-4 col-md-4 col-sm-12">
                <div className="form-group">
                    <label htmlFor="ProvinceID">ແຂວງ</label>
                    <select
                        className="form-control"
                        id="ProvinceID"
                        name="ProvinceID"
                        value={inputValues.ProvinceID}
                        onChange={(e) => {
                            setInputValues({
                                ...inputValues,
                                ProvinceID: e.target.value,
                                DistrictID: "",
                                VillageID: "",
                            });
                            fetchAllDistrict(e.target.value);
                        }}
                        required={
                            inputValues.LevelID === "P" ||
                            inputValues.LevelID === "D" ||
                            inputValues.LevelID === "V"
                                ? true
                                : false
                        }
                        disabled={inputValues.LevelID === "C" ? true : false}
                    >
                        <option value="">ເລືອກແຂວງ</option>
                        {provinces &&
                            provinces.map((province) => (
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

            <div className="col-lg-4 col-md-4 col-sm-12">
                <div className="form-group">
                    <label htmlFor="DistrictID">District</label>

                    <select
                        className="form-control"
                        id="DistrictID"
                        name="DistrictID"
                        value={inputValues.DistrictID}
                        onChange={(e) => {
                            setInputValues({
                                ...inputValues,
                                DistrictID: e.target.value,
                                VillageID: "",
                            });
                            fetchAllVillage(e.target.value);
                        }}
                        required={
                            inputValues.LevelID === "D" ||
                            inputValues.LevelID === "V"
                                ? true
                                : false
                        }
                        disabled={
                            inputValues.LevelID === "C" ||
                            inputValues.LevelID === "P"
                                ? true
                                : false
                        }
                    >
                        <option value="">Select District</option>
                        {districts.map((district) => (
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

            <div className="col-lg-4 col-md-4 col-sm-12">
                <div className="form-group">
                    <label htmlFor="VillageID">Village</label>

                    <select
                        className="form-control"
                        id="VillageID"
                        name="VillageID"
                        value={inputValues.VillageID}
                        onChange={(e) =>
                            setInputValues({
                                ...inputValues,
                                VillageID: e.target.value,
                            })
                        }
                        required={inputValues.LevelID === "V" ? true : false}
                        disabled={
                            inputValues.LevelID === "C" ||
                            inputValues.LevelID === "D" ||
                            inputValues.LevelID === "P"
                                ? true
                                : false
                        }
                    >
                        <option value="">Select Village</option>
                        {villages.map((village) => (
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
        </div>
    );
};

export default LocationOption;
