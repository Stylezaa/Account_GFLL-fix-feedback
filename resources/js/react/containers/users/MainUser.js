import React, { useEffect, useState } from "react";
import ReactDOM from "react-dom/client";
import ModalConfirmDeleteComponent from "../../components/customComponents/ModalConfirmDelete";
import BasicModalComponent from "../../components/customComponents/BasicModalComponent";
import FomUser from "./components/form";
import Permission from "./components/Permission";

const MainUserContainer = () => {
    const [users, setUsers] = useState([]);
    const [formAction, setFormAction] = useState("create"); // or update
    const [selectedUser, setSelectedUser] = useState({});
    const [inputValues, setInputValues] = useState({
        UserID: "",
        Name: "",
        LevelID: "C",
        Email: null,
        ProvinceID: null,
        DistrictID: null,
        VillageID: null,
        UserName: null,
        UserAdmin: "User", // or 1 based on your requirement
        canPost: 0, // or 1 based on your requirement
        UserPWD: null,
        UserPWDConfirm: null,
    });

    const [isActive, setIsActive] = useState(false);
    const [isActiveForm, setIsActiveForm] = useState(false);
    const [isActivePermission, setIsActivePermission] = useState(false);

    const [contentModal, setContentModal] = useState({
        title: "",
    });
    const [status, setStatus] = useState({
        // 0: default, 1: loading, 2: success, 3: error
        status: 0,
        message: "",
    });

    const fetchAllUser = async () => {
        try {
            setStatus({ status: 1, message: "loading" });
            await axios.get(`/users/fetch`).then((res) => {
                if (res.data) {
                    setUsers(res.data);
                    setStatus({ status: 2, message: "success" });

                    setTimeout(() => {
                        setStatus({ status: 0, message: "" });
                    }, 1500);
                } else {
                    console.log("error");
                    setStatus({ status: 3, message: "error" });

                    setTimeout(() => {
                        setStatus({ status: 0, message: "" });
                    }, 1500);
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setStatus({ status: 3, message: "error" });

            setTimeout(() => {
                setStatus({ status: 0, message: "" });
            }, 1500);
        }
    };

    useEffect(() => {
        fetchAllUser();
    }, []);

    const deleteUser = async (Rec_Cnt) => {
        try {
            setStatus({ status: 1, message: "loading" });
            await axios.delete(`/users/delete/${Rec_Cnt}`).then((res) => {
                if (res.status === 200) {
                    console.log("ສຳເລັດແລ້ວ");
                    fetchAllUser();
                    setStatus({ status: 2, message: "success" });

                    setTimeout(() => {
                        setStatus({ status: 0, message: "" });
                    }, 1500);
                } else {
                    console.log("error");
                    setStatus({ status: 3, message: "error" });

                    setTimeout(() => {
                        setStatus({ status: 0, message: "" });
                    }, 1500);
                }
            });
        } catch (error) {
            console.log("error");
            setStatus({ status: 3, message: "error" });

            setTimeout(() => {
                setStatus({ status: 0, message: "" });
            }, 1500);
        }
    };

    const fetchInsert = async () => {
        try {
            if (
                inputValues.UserID === "" ||
                inputValues.UserPWD === "" ||
                inputValues.UserPWD !== inputValues.UserPWDConfirm ||
                inputValues.UserPWDConfirm === "" ||
                inputValues.UserName === "" ||
                inputValues.Email === "" ||
                inputValues.LevelID === ""
            ) {
                return;
            }

            setStatus({ status: 1, message: "loading" });
            await axios
                .post(`/users/create`, {
                    UserID: inputValues.UserID,
                    LevelID: inputValues.LevelID,
                    password: inputValues.UserPWD,
                    ProvinceID: inputValues.ProvinceID ?? null,
                    DistrictID: inputValues.DistrictID ?? null,
                    VillageID: inputValues.VillageID ?? null,
                    UserName: inputValues.UserName,
                    UserAdmin: inputValues.UserAdmin,
                    CanPost: inputValues.canPost,
                    UserPWD: inputValues.UserPWD,
                    Name: inputValues.UserName,
                    Email: inputValues.Email,
                })
                .then((res) => {
                    if (res.status === 200) {
                        console.log("ສຳເລັດແລ້ວ");
                        fetchAllUser();
                        setStatus({ status: 2, message: "success" });
                        setTimeout(() => {
                            setStatus({ status: 0, message: "" });
                            setIsActiveForm(false);
                            setInputValues({
                                UserID: "",
                                Name: "",
                                LevelID: "C",
                                Email: null,
                                ProvinceID: null,
                                DistrictID: null,
                                VillageID: null,
                                UserName: null,
                                UserAdmin: "User", // or 1 based on your requirement
                                canPost: 0, // or 1 based on your requirement
                                UserPWD: null,
                                UserPWDConfirm: null,
                            });
                        }, 1500);
                    } else {
                        console.log("error");
                        setStatus({ status: 3, message: "error" });

                        setTimeout(() => {
                            setStatus({ status: 0, message: "" });
                        }, 1500);
                    }
                });
        } catch (error) {
            console.log("error");
            setStatus({ status: 3, message: "error" });

            setTimeout(() => {
                setStatus({ status: 0, message: "" });
            }, 1500);
        }
    };

    const fetchUpdate = async () => {
        try {
            if (
                inputValues.UserID === "" ||
                inputValues.UserPWDConfirm === "" ||
                inputValues.UserName === "" ||
                inputValues.Email === "" ||
                inputValues.LevelID === ""
            ) {
                return;
            }

            setStatus({ status: 1, message: "loading" });
            await axios
                .put(`/users/update/${selectedUser.Rec_Cnt}`, {
                    UserID: inputValues.UserID,
                    LevelID: inputValues.LevelID,
                    password: inputValues.UserPWD,
                    ProvinceID: inputValues.ProvinceID ?? null,
                    DistrictID: inputValues.DistrictID ?? null,
                    VillageID: inputValues.VillageID ?? null,
                    UserName: inputValues.UserName,
                    UserAdmin: inputValues.UserAdmin,
                    CanPost: inputValues.canPost,
                    UserPWD: inputValues.UserPWD,
                    Name: inputValues.UserName,
                    Email: inputValues.Email,
                })
                .then((res) => {
                    if (res.status === 200) {
                        console.log("ສຳເລັດແລ້ວ");
                        fetchAllUser();
                        setStatus({ status: 2, message: "success" });
                        setIsActiveForm(false);
                        setTimeout(() => {
                            setStatus({ status: 0, message: "" });
                        }, 1500);
                    } else {
                        console.log("error");
                        setStatus({ status: 3, message: "error" });

                        setTimeout(() => {
                            setStatus({ status: 0, message: "" });
                        }, 1500);
                    }
                });
        } catch (error) {
            console.log("error");
            setStatus({ status: 3, message: "error" });

            setTimeout(() => {
                setStatus({ status: 0, message: "" });
            }, 1500);
        }
    };

    const handleSave = async () => {
        formAction === "create"
            ? fetchInsert()
            : formAction === "update"
            ? fetchUpdate()
            : null;
    };

    return (
        <>
            <ModalConfirmDeleteComponent
                title={contentModal.title ?? ""}
                isActive={isActive ?? false}
                setIsActive={setIsActive}
                id="confirmDeleteUser"
            >
                <div
                    className="modal-footer"
                    style={{
                        display: "flex",
                        justifyContent: "center",
                    }}
                >
                    <button
                        type="button"
                        className="btn btn-danger text-white"
                        onClick={() => {
                            deleteUser(selectedUser.Rec_Cnt);
                            setIsActive(false);
                        }}
                    >
                        Delete
                    </button>

                    <button
                        type="button"
                        className="btn btn-secondary text-white"
                        data-bs-dismiss="modal"
                        onClick={() => setIsActive(false)}
                    >
                        Close
                    </button>
                </div>
            </ModalConfirmDeleteComponent>

            <BasicModalComponent
                title={contentModal.title ?? ""}
                isActive={isActiveForm ?? false}
                setIsActive={setIsActiveForm}
                id="createUser"
            >
                <FomUser
                    setInputValues={setInputValues}
                    inputValues={inputValues}
                    setIsActiveForm={setIsActiveForm}
                    isActiveForm={isActiveForm}
                    handleSave={handleSave}
                    formAction={formAction}
                    status={status}
                />
            </BasicModalComponent>

            <BasicModalComponent
                title={contentModal.title ?? ""}
                isActive={isActivePermission ?? false}
                setIsActive={setIsActivePermission}
                id="permissionUser"
            >
                <Permission 
                    selectedUser={selectedUser}
                    fetchAllUser={fetchAllUser}
                    setStatus={setStatus}
                    status={status}
                    isActivePermission={isActivePermission}
                    setIsActivePermission={setIsActivePermission}
                />
            </BasicModalComponent>

            <div
                style={{
                    display: "flex",
                    justifyContent: "space-between",
                }}
            >
                <h5>ຈັດການຜູ້ໃຊ້ງານ</h5>

                <button
                    className="btn btn-primary btn-sm"
                    style={{
                        width: "100px",
                        padding: "0px",
                    }}
                    onClick={() => {
                        setIsActiveForm(true);
                        setContentModal({
                            title: "ເພີ່ມຜູ້ໃຊ້ງານ",
                        });
                        setFormAction("create");
                    }}
                >
                    ເພີ່ມຜູ້ໃຊ້ງານ
                </button>
            </div>
            <hr />
            <div className="card">
                <div
                    className="card-header"
                    style={{
                        display: "flex",
                        justifyContent: "space-between",
                    }}
                >
                    <h4>ລາຍການຜູ້ໃຊ້ງານ</h4>
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
                                <span className="visually-hidden">
                                    Loading...
                                </span>
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

                <div className="card-body">
                    <table
                        className="table table-striped"
                        style={{
                            fontSize: "12px",
                        }}
                    >
                        <thead>
                            <tr>
                                <th>ລຳດັບ</th>
                                <th>ລະຫັດຜູ້ໃຊ້</th>
                                <th>ຊື່ຜູ້ໃຊ້</th>
                                <th>ສິດນຳໃຊ້</th>
                                <th>ຂັ້ນ</th>
                                <th>ສະຖານທີ່ຈັດຕັ້ງປະຕິບັດ</th>
                                <th>ຢືນຢັ້ນການໂພດ</th>
                                <th>ຈັດການຂໍ້ມູນ</th>
                            </tr>
                        </thead>
                        <tbody>
                            {users.map((user, index) => (
                                <tr key={index + 1}>
                                    <td className="py-1">{index + 1}</td>
                                    <td className="py-1">{user.UserID}</td>
                                    <td className="py-1">{user.UserName}</td>
                                    <td className="py-1">
                                        {user.UserAdmin ? "Admin" : "User"}
                                    </td>
                                    <td className="py-1">
                                        {user?.get_level?.LevelID +
                                            " - " +
                                            user?.get_level?.LevelNameL}
                                    </td>
                                    <td className="py-1">{user.UserName}</td>
                                    <td className="py-1">
                                        {user.CanPost ? "true" : "false"}
                                    </td>
                                    <td className="text-center text-no-wrap py-1">
                                        <div
                                            className="btn btn-outline-success btn-sm"
                                            onClick={() => {
                                                setIsActivePermission(true);
                                                setSelectedUser(user);
                                                setContentModal({
                                                    title: "ຈັດການສິດນຳໃຊ້",
                                                });
                                            }}
                                        >
                                            <i className="fa fa-shield-alt" />
                                        </div>
                                        &nbsp;
                                        <div
                                            className="btn btn-outline-warning btn-sm"
                                            onClick={() => {
                                                setIsActiveForm(true);
                                                setContentModal({
                                                    title: "ແກ້ໄຂຜູ້ໃຊ້ງານ",
                                                });
                                                setFormAction("update");
                                                setSelectedUser(user);
                                                setInputValues({
                                                    UserID: user.UserID,
                                                    Name: user.UserName,
                                                    LevelID: user.LevelID,
                                                    Email: user.email,
                                                    ProvinceID: user.ProvinceID,
                                                    DistrictID: user.DistrictID,
                                                    VillageID: user.VillageID,
                                                    UserName: user.UserName,
                                                    UserAdmin: user.UserAdmin,
                                                    canPost: user.CanPost,
                                                    UserPWD: null,
                                                    UserPWDConfirm: null,
                                                });
                                            }}
                                        >
                                            <i className="fa fa-edit" />
                                        </div>
                                        &nbsp;
                                        <div
                                            className="btn btn-outline-danger btn-sm"
                                            onClick={() => {
                                                setIsActive(true);
                                                setContentModal({
                                                    title: "ລຶບຜູ້ໃຊ້ງານ",
                                                });
                                                setSelectedUser(user);
                                            }}
                                        >
                                            <i className="fa fa-trash" />
                                        </div>
                                    </td>
                                </tr>
                            ))}
                        </tbody>
                    </table>
                </div>
            </div>
        </>
    );
};

const root = ReactDOM.createRoot(
    document.getElementById("main-user-management")
);

root.render(<MainUserContainer />);
