import React, { useEffect, useState } from "react";
import LocationOption from "../../../components/customComponents/LocationOption";

const FomUser = ({
    inputValues,
    setInputValues,
    setIsActiveForm,
    isActiveForm,
    handleSave,
    formAction,
    status,
}) => {
    const [dataLevel, setDataLevel] = useState([]);

    const fetchAllLevel = async () => {
        try {
            setDataLevel([]);
            await axios.get(`/users/level`).then((res) => {
                if (res.data) {
                    setDataLevel(res.data);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataLevel([]);
        }
    };

    useEffect(() => {
        fetchAllLevel();
    }, []);


    return (
        <form
            className="form"
            id="form"
            autoComplete="off"
            onSubmit={(e) => {
                e.preventDefault();
                handleSave();
            }}
        >
            {" "}
            <div className="row">
                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="UserID">ລະຫັດຜູ້ໃຊ້ງານ</label>
                        <input
                            type="text"
                            className="form-control"
                            id="UserID"
                            name="UserID"
                            value={inputValues.UserID}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    UserID: e.target.value,
                                })
                            }
                            required
                        />
                    </div>
                </div>
            </div>
            <div className="row">
                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="UserName">ຊື່ຜູ້ໃຊ້ງານ</label>
                        <input
                            type="text"
                            className="form-control"
                            id="UserName"
                            name="UserName"
                            value={inputValues.UserName}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    UserName: e.target.value,
                                })
                            }
                            required
                        />
                    </div>
                </div>
                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="Email">Email</label>
                        <input
                            type="email"
                            className="form-control"
                            id="Email"
                            name="Email"
                            value={inputValues.Email}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    Email: e.target.value,
                                })
                            }
                            required
                        />
                    </div>
                </div>
                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="canPost">Can Post</label>
                        <select
                            className="form-control"
                            id="canPost"
                            name="canPost"
                            value={inputValues.canPost}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    canPost: e.target.value,
                                })
                            }
                        >
                            <option value="0">No</option>
                            <option value="1">Yes</option>
                        </select>
                    </div>
                </div>
            </div>
            <div className="row">
                {formAction === "create" ? (
                    <>
                        <div className="col-lg-4 col-md-4">
                            <div className="form-group">
                                <label htmlFor="UserPWD">ລະຫັດຜ່ານ</label>
                                <input
                                    type="password"
                                    className="form-control"
                                    id="UserPWD"
                                    name="UserPWD"
                                    value={inputValues.UserPWD}
                                    onChange={(e) =>
                                        setInputValues({
                                            ...inputValues,
                                            UserPWD: e.target.value,
                                        })
                                    }
                                    required
                                    minLength="8"
                                />
                                <span className="text-danger">
                                    {inputValues.UserPWD &&
                                    inputValues.UserPWD.length < 8
                                        ? "Password must be at least 8 characters"
                                        : ""}
                                </span>
                            </div>
                        </div>
                        <div className="col-lg-4 col-md-4">
                            <div className="form-group">
                                <label htmlFor="UserPWDConfirm">
                                    ຍືນຍັນລະຫັດຜ່ານ
                                </label>
                                <input
                                    type="password"
                                    className="form-control"
                                    id="UserPWDConfirm"
                                    name="UserPWDConfirm"
                                    value={inputValues.UserPWDConfirm}
                                    minLength="8"
                                    onChange={(e) =>
                                        setInputValues({
                                            ...inputValues,
                                            UserPWDConfirm: e.target.value,
                                        })
                                    }
                                />
                                {/* show password not match */}
                                <span className="text-danger">
                                    {inputValues.UserPWD !==
                                    inputValues.UserPWDConfirm
                                        ? "Password not match"
                                        : ""}
                                </span>
                            </div>
                        </div>
                    </>
                ) : null}

                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="LevelID">User Level</label>
                        <select
                            className="form-control"
                            id="LevelID"
                            name="LevelID"
                            value={inputValues.LevelID}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    LevelID: e.target.value || "C",
                                })
                            }
                        >
                            {dataLevel.map((level) => (
                                <option
                                    key={level.LevelID}
                                    value={level.LevelID}
                                >
                                    {level.LevelID} - {level.LevelNameL}
                                </option>
                            ))}
                        </select>
                    </div>
                </div>
            </div>
            <LocationOption
                inputValues={inputValues}
                setInputValues={setInputValues}
            />
            <div className="row">
                <div className="col-lg-4 col-md-4">
                    <div className="form-group">
                        <label htmlFor="UserAdmin">User Type</label>
                        <select
                            className="form-control"
                            id="UserAdmin"
                            name="UserAdmin"
                            value={inputValues.UserAdmin}
                            onChange={(e) =>
                                setInputValues({
                                    ...inputValues,
                                    UserAdmin: e.target.value,
                                })
                            }
                            required
                        >
                            <option value="User">User</option>
                            <option value="Admin">Admin</option>
                        </select>
                    </div>
                </div>
            </div>
            <div className="row">
                <div className="col-md-12">
                    <div className="modal-footer">
                        <button
                            type="submit"
                            className="btn btn-primary text-white"
                            disabled={status.status === 1 ? true : false}
                        >
                            {status.status === 1 ? (
                                <div>
                                    <div
                                        className="spinner-border text-success"
                                        role="status"
                                    >
                                        <span className="visually-hidden">
                                            Loading...
                                        </span>
                                    </div>
                                </div>
                            ) : (
                                <div>
                                    <i className="fa fa-save" />
                                    &nbsp; Save
                                </div>
                            )}
                        </button>

                        <button
                            type="button"
                            className="btn btn-secondary text-white"
                            data-bs-dismiss="modal"
                            onClick={() => setIsActiveForm(false)}
                            disabled={status.status === 1 ? true : false}
                        >
                            {status.status === 1 ? (
                                <div>
                                    <div
                                        className="spinner-border text-success"
                                        role="status"
                                    >
                                        <span className="visually-hidden">
                                            Loading...
                                        </span>
                                    </div>
                                </div>
                            ) : (
                                <div>
                                    <i className="fa fa-times" />
                                    &nbsp; Cancel
                                </div>
                            )}
                        </button>
                    </div>
                </div>
            </div>
            <div
                className={
                    "alert " +
                    (status.status === 2
                        ? "alert-success"
                        : status.status === 3
                        ? "alert-danger"
                        : "d-none")
                }
                role="alert"
            >
                {status.status === 1 && (
                    <div>
                        <div
                            className="spinner-border text-success"
                            role="status"
                        >
                            <span className="visually-hidden">Loading...</span>
                        </div>
                        &nbsp; {status.message}
                    </div>
                )}
                {status.status === 2 && (
                    <div>
                        <i className="fa fa-check-circle" />
                        &nbsp; {status.message}
                    </div>
                )}
                {status.status === 3 && (
                    <div>
                        <i className="fa fa-times-circle" />
                        &nbsp; {status.message}
                    </div>
                )}
            </div>
        </form>
    );
};

export default FomUser;
