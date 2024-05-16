import React, { useState } from "react";

const SignatureComponent = ({ inputValues, setInputValues }) => {

    const inputItems = [
        {
            key: "report_title",
            label: "Report Title",
        },
        { key: "signature_1", label: "Signature 1" },
        { key: "signature_2", label: "Signature 2" },
        { key: "signature_3", label: "Signature 3" },
        { key: "signature_4", label: "Signature 4" },
        { key: "signature_5", label: "Signature 5" },
        { key: "report_address", label: "Report Address" },
    ];

    const handleChange = (e) => {
        setInputValues({
            ...inputValues,
            [e.target.name]: e.target.value,
        });
    };
    return (
        <div className="row">
            {inputItems.map((item, index) => (
                <div key={index} className="col-lg-12 col-md-12 col-sm-12">
                    <div className="form-group  row my-2">
                        <label
                            htmlFor={item.key}
                            className="col-sm-3"
                        >
                            {item.label}:
                        </label>
                        <div className="col-sm-9">
                            <input
                                type="text"
                                className="form-control"
                                id={item.key}
                                name={item.key}
                                placeholder={item.label}
                                value={inputValues[item.key]}
                                onChange={handleChange}
                            />
                        </div>
                    </div>
                </div>
            ))}
        </div>
    );
};

export default SignatureComponent;
