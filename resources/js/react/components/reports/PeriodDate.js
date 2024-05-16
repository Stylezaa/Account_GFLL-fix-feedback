import React, { useEffect, useState } from "react";

const PeriodDateComponent = ({ inputValues, setInputValues }) => {
    const [dataCurrency, setDataCurrency] = useState([]);

    const multipliers = [
        { id: 1, name: "1" },
        { id: 10, name: "10" },
        { id: 100, name: "100" },
        { id: 1000, name: "1000" },
        { id: 1000, name: "1000" },
    ];

    const periods = [
        { id: "daily", name: "Daily" },
        { id: "monthly", name: "Monthly" },
        { id: "yearly", name: "Yearly" },
    ];

    const yearItems = [];

    for (let i = 0; i < 30; i++) {
        yearItems.push({
            id: new Date().getFullYear() - i,
            name: new Date().getFullYear() - i,
        });
    }

    const currencyItems = [
        { id: "USD", name: "USD" },
        { id: "LAK", name: "LAK" },
    ];

    const displayNumberItems = [
        { id: "integer", name: "ສະແດງເລກທົດສະນິຍົມ (1,000)" },
        { id: "decimal", name: "ສະແດງເລກເສດ (1,000.00)" },
    ];

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

    useEffect(() => {
        fetchAllCurency();
    }, []);

    return (
        <div className="row">
            <div className="col-lg-12 col-md-12 col-sm-12 mb-4">
                <div
                    className="btn-group"
                    role="group"
                    aria-label="Basic example"
                >
                    {periods.map((item, index) => (
                        <button
                            key={index}
                            type="button"
                            className={`btn ${
                                inputValues.period_type === item.id
                                    ? "btn-primary text-white"
                                    : "btn btn-outline-primary "
                            }`}
                            onClick={() =>
                                setInputValues({
                                    ...inputValues,
                                    period_type: item.id,
                                })
                            }
                        >
                            {item.name}
                        </button>
                    ))}
                </div>
            </div>

            {inputValues.period_type === "daily" ? (
                <>
                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>Start Date</b>
                            </label>
                            <input
                                type="date"
                                className="form-control"
                                value={inputValues.start_date}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        start_date: e.target.value,
                                    })
                                }
                            />
                        </div>
                    </div>

                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>End Date</b>
                            </label>
                            <input
                                type="date"
                                className="form-control"
                                value={inputValues.end_date}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        end_date: e.target.value,
                                    })
                                }
                            />
                        </div>
                    </div>
                </>
            ) : null}

            {inputValues.period_type === "monthly" ? (
                <>
                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>Start month</b>
                            </label>
                            <input
                                type="month"
                                className="form-control"
                                value={inputValues.start_month}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        start_month: e.target.value,
                                    })
                                }
                            />
                        </div>
                    </div>

                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>End month</b>
                            </label>
                            <input
                                type="month"
                                className="form-control"
                                value={inputValues.end_month}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        end_month: e.target.value,
                                    })
                                }
                            />
                        </div>
                    </div>
                </>
            ) : null}

            {inputValues.period_type === "yearly" ? (
                <>
                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>Start year</b>
                            </label>
                            <select
                                className="form-control"
                                value={inputValues.start_year}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        start_year: e.target.value,
                                    })
                                }
                            >
                                <option value="">Select Year</option>
                                {yearItems.map((item, index) => (
                                    <option key={index} value={item.id}>
                                        {item.name}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>

                    <div className="col-lg-6 col-md-6 col-sm-6">
                        <div className="form-group">
                            <label>
                                <b>End year</b>
                            </label>
                            <select
                                className="form-control"
                                value={inputValues.end_year}
                                onChange={(e) =>
                                    setInputValues({
                                        ...inputValues,
                                        end_year: e.target.value,
                                    })
                                }
                            >
                                <option value="">Select Year</option>
                                {yearItems.map((item, index) => (
                                    <option key={index} value={item.id}>
                                        {item.name}
                                    </option>
                                ))}
                            </select>
                        </div>
                    </div>
                </>
            ) : null}

            <div className="col-lg-12 col-md-12 col-sm-12 mt-2">
                {/* select multi */}
                <div className="form-group">
                    <label>
                        <b>ຮູບບແບບການສະແດງຕົວເລກ</b>
                    </label>
                    <select
                        className="form-control"
                        value={inputValues.display_number}
                        onChange={(e) =>
                            setInputValues({
                                ...inputValues,
                                display_number: e.target.value,
                            })
                        }
                    >
                        {displayNumberItems.map((item, index) => (
                            <option key={index} value={item.id}>
                                {item.name}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            <div className="col-lg-12 col-md-12 col-sm-12 mt-2">
                {/* select multi */}
                <div className="form-group">
                    <label>
                        <b>ຈໍານວນຕົວຄູນ X</b>
                    </label>
                    <select
                        className="form-control"
                        value={
                            inputValues.multiplier === null
                                ? 1
                                : inputValues.multiplier
                        }
                        onChange={(e) =>
                            setInputValues({
                                ...inputValues,
                                multiplier: e.target.value,
                            })
                        }
                    >
                        {multipliers.map((item, index) => (
                            <option key={index} value={item.id}>
                                {item.name}
                            </option>
                        ))}
                    </select>
                </div>
            </div>

            <div className="col-lg-12 col-md-12 col-sm-12 mt-2">
                <div className="form-group">
                    <label>
                        <b>ສະກຸນເງິນ</b>
                    </label>
                    <select
                        className="form-control"
                        value={inputValues.currency}
                        onChange={(e) =>
                            setInputValues({
                                ...inputValues,
                                currency: e.target.value,
                            })
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
            </div>

            <div className="col-lg-12 col-md-12 col-sm-12 mt-2">
                <div className="form-group">
                    <label>
                        <b>ຕົວເລືອກ</b>
                    </label>
                    {/* checkbox */}
                    <div className="form-check">
                        <input
                            type="checkbox"
                            className="form-check-input"
                            id="is_order_account"
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    is_order_account: e.target.checked,
                                })
                            }
                        />
                        <label
                            className="form-check-label"
                            htmlFor="is_order_account"
                        >
                            ລາຍງານຕາມຊື່ບັນຊີ
                        </label>
                    </div>
                </div>
            </div>
        </div>
    );
};

export default PeriodDateComponent;
