import React, { Fragment, useEffect, useState } from "react";
import BasicModalComponent from "../customComponents/BasicModalComponent";

const MainOptionComponent = ({
    inputValues,
    setInputValues,
    reportType,
    isLimit,
}) => {
    const [dataVoucher, setDataVoucher] = useState([]);
    const [dataActivity, setDataActivity] = useState([]);
    const [dataCategory, setDataCategory] = useState([]);
    const [dataAccount, setDataAccount] = useState([]);
    const [dataDonor, setDataDonor] = useState([]);

    const [selectTypeModal, setSelectTypeModal] = useState("");
    const [isActive, setIsActive] = useState(false);
    const [contentModal, setContentModal] = useState({
        title: "",
    });

    const [preSelectedData, setPreSelectedData] = useState({
        voucher: [],
        activity: [],
        category: [],
        account: [],
        donor: [],
    });

    const mainOptionSelectItems = [
        {
            key: "voucher",
            title: "ເລກທີ່ລົງບັນຊີ",
            clickOpen: "openVoucher",
            dataSelected: inputValues.voucher,
            role: ["transaction", "journal", "ledger"],
            limit: isLimit,
        },
        {
            key: "activity",
            title: "ກິດຈະກໍາ",
            dataSelected: inputValues.activity,
            role: ["transaction", "journal", "ledger"],
            limit: isLimit,
        },
        {
            key: "category",
            title: "ຮ່ວງລາຍຈ່າຍ",
            dataSelected: inputValues.category,
            role: ["transaction", "journal", "ledger"],
            limit: isLimit,
        },
        {
            key: "account",
            title: "ເລກບັນຊີ",
            dataSelected: inputValues.account,
            role: [
                "transaction",
                "journal",
                "ledger",
                "bank_deposit_book",
                "trialBalance",
                "cash",
                "advance_ledger",
            ],
            limit: isLimit,
        },
        {
            key: "donor",
            title: "ທຶນ",
            dataSelected: inputValues.donor,
            role: ["transaction", "journal", "ledger"],
            limit: isLimit,
        },
    ];

    const fetchGetAccount = async (accountType, voucherType) => {
        try {
            const res = await axios.get(
                `/Account/account-api?account_type=${accountType}&voucher_type=${voucherType}`
            );
            if (res.data.length > 0) {
                const newData = res.data.map((item) => {
                    return {
                        id: item.AccountCD,
                        code: item.AccountCD,
                        label: "",
                        label_lao: item.AccountNameL,
                        label_eng: item.AccountNameE,
                    };
                });
                setDataAccount(newData);
            } else {
                setDataAccount([]);
            }
        } catch (error) {
            console.log("error fetchGetAccount", error);
        }
    };

    const fetchGetDonor = async () => {
        try {
            const res = await axios.get(`/donors/donors`);
            if (res.data.length > 0) {
                const new_data = res.data.map((item) => {
                    return {
                        id: item.DonorID,
                        code: item.DonorSym,
                        label: "",
                        label_lao: item.DonorNameL,
                        label_eng: item.DonorNameE,
                    };
                });
                setDataDonor(new_data);
            } else {
                setDataDonor([]);
            }
        } catch (error) {
            console.log("error fetchGetDonor", error);
        }
    };

    const fetchGetActivity = async () => {
        try {
            const res = await axios.get(`/Activity/activities`);
            if (res.data.length > 0) {
                const new_data = res.data.map((item) => {
                    return {
                        id: item.ActivityID,
                        code: item.ActivityCD,
                        label: "",
                        label_lao: item.ActivityNameL,
                        label_eng: item.ActivityNameE,
                    };
                });
                setDataActivity(new_data);
            } else {
                setDataActivity([]);
            }
        } catch (error) {
            console.log("error fetchGetActivity", error);
        }
    };

    const fetchGetCategory = async () => {
        try {
            const res = await axios.get(`/categories/categories`);
            if (res.data.length > 0) {
                const newData = res.data.map((item) => {
                    return {
                        id: item.CategoryID,
                        code: item.CategoryID,
                        label: item.CategorySym,
                        label_lao: item.CategoryNameL,
                        label_eng: item.CategoryNameE,
                    };
                });
                setDataCategory(newData);
            } else {
                setDataCategory([]);
            }
        } catch (error) {
            console.log("error fetchGetAccount", error);
        }
    };

    const fetchGetVoucher = async () => {
        try {
            const res = await axios.get(`/GeneralVoucher/vouchers`);
            if (res.data.length > 0) {
                const newData = res.data.map((item) => {
                    return {
                        id: item.Vch_AutoNo,
                        confirm_no: item.VoucherNo,
                        ref_no: item.Vch_AutoNo,
                        ref_date: item.VoucherDt,
                        amount: item.Voucher_Amt,
                        currency: item.Currency,
                        content: item.DescriptionL,
                    };
                });
                setDataVoucher(newData);
            } else {
                setDataVoucher([]);
            }
        } catch (error) {
            console.log("error fetchGetAccount", error);
        }
    };

    useEffect(() => {
        fetchGetAccount("", "");
        fetchGetDonor();
        fetchGetActivity();
        fetchGetCategory();
        fetchGetVoucher();
    }, []);

    const handleSaveData = () => {
        const oldData = inputValues;
        const newData = preSelectedData;

        const newSelectedData = {
            voucher: [
                ...new Set([...oldData.voucher, ...newData.voucher]),
            ].filter((item) => newData.voucher.includes(item)),
            activity: [
                ...new Set([...oldData.activity, ...newData.activity]),
            ].filter((item) => newData.activity.includes(item)),
            category: [
                ...new Set([...oldData.category, ...newData.category]),
            ].filter((item) => newData.category.includes(item)),
            account: [
                ...new Set([...oldData.account, ...newData.account]),
            ].filter((item) => newData.account.includes(item)),
            donor: [...new Set([...oldData.donor, ...newData.donor])].filter(
                (item) => newData.donor.includes(item)
            ),
        };

        setInputValues({
            ...inputValues,
            ...newSelectedData,
        });
    };

    const handleGetSingleSelectedData = (data, type) => {
        setInputValues({
            ...inputValues,
            // name is single_account i want to concat single_ + type
            [type]: [data.id],
            [`single_${type}`]: data.label_lao,
        });

        setIsActive(false);
    };

    return (
        <>
            <BasicModalComponent
                title={contentModal.title ?? ""}
                isActive={isActive ?? false}
                setIsActive={setIsActive}
                id="get-data"
            >
                <div style={{ maxHeight: "500px", overflowY: "auto" }}>
                    <table className="table table-bordered table-hover">
                        {selectTypeModal === "voucher" ? (
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ເລືອກ</th>
                                    <th>ເລກທີໃບຍັ້ງຍືນ</th>
                                    <th>ເລກທີໃບຕິດຕາມ</th>
                                    <th>ວັນທີຍັ້ງຍືນ</th>
                                    <th>ມູນຄ່າບິນ</th>
                                    <th>ສະກຸນເງິນ</th>
                                    <th>ເນື້ອໃນລົງບັນຊີ</th>
                                </tr>
                            </thead>
                        ) : (
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>ເລືອກ</th>
                                    <th>ລະຫັດ</th>
                                    <th>ຊື່ຫຍໍ້</th>
                                    <th>ເນືອໃນ ພາສາລາວ</th>
                                    <th>ເນືອໃນ ອັງກິດ</th>
                                </tr>
                            </thead>
                        )}
                        <tbody>
                            {selectTypeModal === "voucher" ? (
                                <>
                                    {dataVoucher.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td className="text-center">
                                                <input
                                                    type="checkbox"
                                                    style={{
                                                        width: "20px",
                                                        height: "20px",
                                                    }}
                                                    checked={preSelectedData.voucher.includes(
                                                        item.id
                                                    )}
                                                    onChange={(e) => {
                                                        if (e.target.checked) {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                voucher: [
                                                                    ...preSelectedData.voucher,
                                                                    item.id,
                                                                ],
                                                            });
                                                        } else {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                voucher:
                                                                    preSelectedData.voucher.filter(
                                                                        (id) =>
                                                                            id !==
                                                                            item.id
                                                                    ),
                                                            });
                                                        }
                                                    }}
                                                />
                                            </td>
                                            <td>{item.ref_no}</td>
                                            <td>{item.confirm_no}</td>
                                            <td>{item.ref_date}</td>
                                            <td>{item.amount}</td>
                                            <td>{item.currency}</td>
                                            <td>{item.content}</td>
                                        </tr>
                                    ))}
                                </>
                            ) : selectTypeModal === "activity" ? (
                                <>
                                    {dataActivity.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td className="text-center">
                                                <input
                                                    type="checkbox"
                                                    style={{
                                                        width: "20px",
                                                        height: "20px",
                                                    }}
                                                    checked={preSelectedData.activity.includes(
                                                        item.id
                                                    )}
                                                    onChange={(e) => {
                                                        if (e.target.checked) {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                activity: [
                                                                    ...preSelectedData.activity,
                                                                    item.id,
                                                                ],
                                                            });
                                                        } else {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                activity:
                                                                    preSelectedData.activity.filter(
                                                                        (id) =>
                                                                            id !==
                                                                            item.id
                                                                    ),
                                                            });
                                                        }
                                                    }}
                                                />
                                            </td>
                                            <td>{item.code}</td>
                                            <td>{item.label}</td>
                                            <td>{item.label_lao}</td>
                                            <td>{item.label_eng}</td>
                                        </tr>
                                    ))}
                                </>
                            ) : selectTypeModal === "category" ? (
                                <>
                                    {dataCategory.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td className="text-center">
                                                <input
                                                    type="checkbox"
                                                    style={{
                                                        width: "20px",
                                                        height: "20px",
                                                    }}
                                                    checked={preSelectedData.category.includes(
                                                        item.id
                                                    )}
                                                    onChange={(e) => {
                                                        if (e.target.checked) {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                category: [
                                                                    ...preSelectedData.category,
                                                                    item.id,
                                                                ],
                                                            });
                                                        } else {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                category:
                                                                    preSelectedData.category.filter(
                                                                        (id) =>
                                                                            id !==
                                                                            item.id
                                                                    ),
                                                            });
                                                        }
                                                    }}
                                                />
                                            </td>
                                            <td>{item.code}</td>
                                            <td>{item.label}</td>
                                            <td>{item.label_lao}</td>
                                            <td>{item.label_eng}</td>
                                        </tr>
                                    ))}
                                </>
                            ) : selectTypeModal === "account" ? (
                                <>
                                    {dataAccount.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td className="text-center">
                                                {isLimit ? (
                                                    <>
                                                        <button
                                                            type="button"
                                                            className="btn btn-primary text-white"
                                                            onClick={() => {
                                                                handleGetSingleSelectedData(
                                                                    item,
                                                                    "account"
                                                                );
                                                            }}
                                                        >
                                                            ເລືອກ
                                                        </button>
                                                    </>
                                                ) : (
                                                    <input
                                                        type="checkbox"
                                                        style={{
                                                            width: "20px",
                                                            height: "20px",
                                                        }}
                                                        checked={preSelectedData.account.includes(
                                                            item.id
                                                        )}
                                                        onChange={(e) => {
                                                            if (
                                                                e.target.checked
                                                            ) {
                                                                setPreSelectedData(
                                                                    {
                                                                        ...preSelectedData,
                                                                        account:
                                                                            [
                                                                                ...preSelectedData.account,
                                                                                item.id,
                                                                            ],
                                                                    }
                                                                );
                                                            } else {
                                                                setPreSelectedData(
                                                                    {
                                                                        ...preSelectedData,
                                                                        account:
                                                                            preSelectedData.account.filter(
                                                                                (
                                                                                    id
                                                                                ) =>
                                                                                    id !==
                                                                                    item.id
                                                                            ),
                                                                    }
                                                                );
                                                            }
                                                        }}
                                                    />
                                                )}
                                            </td>
                                            <td>{item.code}</td>
                                            <td>{item.label}</td>
                                            <td>{item.label_lao}</td>
                                            <td>{item.label_eng}</td>
                                        </tr>
                                    ))}
                                </>
                            ) : selectTypeModal === "donor" ? (
                                <>
                                    {dataDonor.map((item, index) => (
                                        <tr key={index}>
                                            <td>{index + 1}</td>
                                            <td className="text-center">
                                                <input
                                                    type="checkbox"
                                                    style={{
                                                        width: "20px",
                                                        height: "20px",
                                                    }}
                                                    checked={preSelectedData.donor.includes(
                                                        item.id
                                                    )}
                                                    onChange={(e) => {
                                                        if (e.target.checked) {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                donor: [
                                                                    ...preSelectedData.donor,
                                                                    item.id,
                                                                ],
                                                            });
                                                        } else {
                                                            setPreSelectedData({
                                                                ...preSelectedData,
                                                                donor: preSelectedData.donor.filter(
                                                                    (id) =>
                                                                        id !==
                                                                        item.id
                                                                ),
                                                            });
                                                        }
                                                    }}
                                                />
                                            </td>
                                            <td>{item.code}</td>
                                            <td>{item.label}</td>
                                            <td>{item.label_lao}</td>
                                            <td>{item.label_eng}</td>
                                        </tr>
                                    ))}
                                </>
                            ) : (
                                <>
                                    <tr>
                                        <td colSpan="6">No data</td>
                                    </tr>
                                </>
                            )}
                        </tbody>
                    </table>
                </div>
                {!isLimit && (
                    <div className="mt-4">
                        <button
                            style={{
                                width: "100px",
                            }}
                            type="button"
                            className="btn btn-primary text-white "
                            onClick={() => {
                                setIsActive(false);
                                handleSaveData();
                            }}
                        >
                            ບັນທຶກ
                        </button>

                        <button
                            style={{
                                width: "100px",
                            }}
                            type="button"
                            className="btn btn-outline-secondary ml-2"
                            onClick={() => {
                                setIsActive(false);
                                setPreSelectedData({
                                    voucher: [],
                                    activity: [],
                                    category: [],
                                    account: [],
                                    donor: [],
                                });
                            }}
                        >
                            ປິດ
                        </button>
                    </div>
                )}
            </BasicModalComponent>

            <div className="row">
                <div className="col-lg-12 col-md-12 col-sm-12 mb-4">
                    <div className="row">
                        {mainOptionSelectItems
                            .filter((item) => item.role.includes(reportType))
                            .map((item, index) => (
                                <Fragment key={index + 1}>
                                    <div className="col-lg-3 col-md-3 col-sm-3 mb-4">
                                        <div
                                            className="btn-group"
                                            role="group"
                                            aria-label="Basic example"
                                        >
                                            <button
                                                type="button"
                                                className="btn btn-primary text-white"
                                                style={{
                                                    width: "175px",
                                                }}
                                                onClick={() => {
                                                    setSelectTypeModal(
                                                        item.key
                                                    );
                                                    setContentModal({
                                                        title:
                                                            "ເລືອກ" +
                                                            item.title,
                                                    });
                                                    setIsActive(true);
                                                    setPreSelectedData({
                                                        ...preSelectedData,
                                                        [item.key]:
                                                            inputValues[
                                                                item.key
                                                            ],
                                                    });
                                                }}
                                            >
                                                {item.title}
                                            </button>
                                            <button
                                                type="button"
                                                className="btn btn-danger text-white"
                                                style={{
                                                    width: "100px",
                                                }}
                                                onClick={() => {
                                                    setInputValues({
                                                        ...inputValues,
                                                        [item.key]: [],
                                                        [`single_${item.key}`]:
                                                            "",
                                                    });
                                                }}
                                            >
                                                clear
                                            </button>
                                        </div>
                                    </div>
                                    {item.limit ? (
                                        <>
                                            <div className="col-lg-3 col-md-3 col-sm-3 mb-4">
                                                <input
                                                    type="text"
                                                    className="form-control"
                                                    style={{
                                                        width: "100%",
                                                    }}
                                                    value={
                                                        inputValues[item.key] &&
                                                        inputValues[item.key]
                                                            .length > 0
                                                            ? inputValues[
                                                                  item.key
                                                              ].join(", ")
                                                            : ""
                                                    }
                                                />
                                            </div>

                                            <div className="col-lg-6 col-md-6 col-sm-6 mb-4">
                                                <input
                                                    type="text"
                                                    className="form-control"
                                                    style={{
                                                        width: "100%",
                                                    }}
                                                    value={
                                                        inputValues[
                                                            `single_${item.key}`
                                                        ]
                                                    }
                                                />
                                            </div>
                                        </>
                                    ) : (
                                        <div className="col-lg-9 col-md-9 col-sm-9 mb-4">
                                            <input
                                                type="text"
                                                className="form-control"
                                                style={{
                                                    width: "100%",
                                                }}
                                                value={
                                                    inputValues[item.key] &&
                                                    inputValues[item.key]
                                                        .length > 0
                                                        ? inputValues[
                                                              item.key
                                                          ].join(", ")
                                                        : ""
                                                }
                                            />
                                        </div>
                                    )}
                                </Fragment>
                            ))}
                    </div>
                </div>
            </div>
        </>
    );
};

export default MainOptionComponent;
