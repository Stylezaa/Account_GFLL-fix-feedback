import { cloneWith } from "lodash";
import React, { useEffect, useState } from "react";

const Permission = ({
    selectedUser,
    fetchAllUser,
    setStatus,
    status,
    isActivePermission,
    setIsActivePermission,
}) => {
    const [datPermission, setDataMenuPermission] = useState([]);
    const [selectedPermission, setSelectedPermission] = useState([]);
    const [tabId, setTabId] = useState(1);

    const fetchMenu = async (tabId) => {
        try {
            setDataMenuPermission([]);
            await axios.get(`/users/menu/${tabId}`).then((res) => {
                if (res.data) {
                    const newData = res.data.map((item) => ({
                        ...item,
                        MenuID: item.MenuID,
                        MenuAction: false,
                        CanEdit: false,
                        CanSave: false,
                        CanDelete: false,
                        CanExport: false,
                    }));
                    setDataMenuPermission(newData);
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
            setDataMenuPermission([]);
        }
    };

    const fetchGetPermissionByUserId = async (userId) => {
        try {
            await axios.get(`/users/permission/${userId}`).then((res) => {
                if (res.data) {
                    if (res.data.length > 0) {
                        const newData = res.data.map((item) => ({
                            ...item,
                            MenuID: item.MenuID,
                            MenuAction: item.MenuAction,
                            CanEdit: item.CanEdit,
                            CanSave: item.CanSave,
                            CanDelete: item.CanDelete,
                            CanExport: item.CanExport,
                            Rec_Cnt: item.Rec_Cnt,
                        }));

                        setSelectedPermission(newData);
                    } else {
                        setSelectedPermission([]);
                    }
                } else {
                    console.log("error");
                }
            });
        } catch (error) {
            console.error("Error:", error);
        }
    };

    useEffect(() => {
        fetchMenu(1);
    }, []);

    const tabList = [
        { value: 1, title: "ຂໍ້ມູນຫຼັກ", icon: "" },
        { value: 2, title: "ຂໍ້ມູນການເຄືອນໄຫວ", icon: "" },
        { value: 3, title: "ລາຍງານບັນຊີໂຄງານ", icon: "" },
        { value: 4, title: "ລາຍງານບັນຊີ", icon: "" },
        { value: 5, title: "ການຕັ້ງຄ່າ", icon: "" },
    ];

    useEffect(() => {
        if (selectedUser) {
            fetchGetPermissionByUserId(selectedUser.UserID);
        }
    }, [selectedUser]);

    const handleCheckboxChange = (
        menuID,
        permissionType,
        checked,
        UserID,
        LevelID
    ) => {
        const updatedPermissions = selectedPermission.map((permission) => {
            if (permission.MenuID === menuID) {
                return {
                    ...permission,
                    [permissionType]: checked ? "1" : "0",
                };
            }
            return permission;
        });

        const existingPermissionIndex = updatedPermissions.findIndex(
            (permission) => permission.MenuID === menuID
        );
        if (existingPermissionIndex === -1) {
            updatedPermissions.push({
                UserID: UserID,
                LevelID: LevelID,
                MenuID: menuID,
                MenuAction: "0",
                CanEdit: "0",
                CanSave: "0",
                CanDelete: "0",
                CanExport: "0",
                [permissionType]: checked ? "1" : "0",
            });
        }

        setSelectedPermission(updatedPermissions);
    };

    const handleSavePermission = async () => {
        try {
            setStatus({ status: 1, message: "loading" });
            const convertData = selectedPermission.map((item) => ({
                UserID: item.UserID,
                LevelID: item.LevelID,
                MenuID: item.MenuID,
                MenuAction: item.MenuAction,
                CanEdit: item.CanEdit,
                CanSave: item.CanSave,
                CanExport: item.CanExport,
                CanDelete: item.CanDelete,
                Rec_Cnt: item.Rec_Cnt,
            }));

            await axios
                .post(`/users/permit-menu`, {
                    data: convertData,
                })
                .then((res) => {
                    if (res.status === 200) {
                        setStatus({ status: 2, message: "success" });

                        setTimeout(() => {
                            setIsActivePermission(false);
                            fetchAllUser();
                            setStatus({ status: 0, message: "" });
                        }, 1500);
                    } else {
                        setStatus({ status: 3, message: "error" });
                    }
                });
        } catch (error) {
            setStatus({ status: 3, message: error });
        }
    };

    const handleResetPermission = () => {
        // set munuAction, CanEdit, CanSave, CanDelete, CanExport to 0
        const newData = selectedPermission.map((item) => ({
            ...item,
            MenuID: item.MenuID,
            MenuAction: "0",
            CanEdit: "0",
            CanSave: "0",
            CanDelete: "0",
            CanExport: "0",
            Rec_Cnt: item.Rec_Cnt,
        }));

        setSelectedPermission(newData);
    };

    console.log("selectedPermission", selectedPermission);

    return (
        <div
            style={{
                fontSize: "12px",
            }}
        >
            <ul className="nav nav-tabs">
                {tabList.map((item, index) => (
                    <li className="nav-item" key={index}>
                        <a
                            className={`nav-link ${
                                index === tabId - 1 ? "active" : ""
                            }`}
                            onClick={() => {
                                setTabId(item.value);
                                fetchMenu(item.value);
                            }}
                            href="#"
                        >
                            {item.title}
                        </a>
                    </li>
                ))}
                <br />
                <table className="table table-bordered">
                    <thead>
                        <tr>
                            {/* <th className="text-center">ເລືອກ</th> */}
                            <th>ລາຍການເມນູ</th>
                            <th className="text-center">ບັນທຶກໄດ້</th>
                            <th className="text-center">ບັນແກ້ໄຂໄດ້</th>
                            <th className="text-center">ບັນລຶບໄດ້</th>
                            <th className="text-center">ສົ່ງອອກ</th>
                        </tr>
                    </thead>
                    <tbody>
                        {datPermission.map((item, index) => {
                            return (
                                <tr key={index}>
                                    <td className="text-center py-1">
                                        <input
                                            type="checkbox"
                                            checked={
                                                selectedPermission.find(
                                                    (x) =>
                                                        x.MenuID === item.MenuID
                                                )?.MenuAction === "1"
                                            }
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    item.MenuID,
                                                    "MenuAction",
                                                    e.target.checked,
                                                    selectedUser.UserID,
                                                    selectedUser.LevelID
                                                )
                                            }
                                        />
                                    </td>
                                    <td
                                        className=" py-1"
                                        style={{
                                            minWidth: "200px",
                                        }}
                                    >
                                        {item.MenuNameL}
                                    </td>
                                    <td className="text-center py-1">
                                        <input
                                            type="checkbox"
                                            checked={
                                                selectedPermission.find(
                                                    (x) =>
                                                        x.MenuID === item.MenuID
                                                )?.CanSave === "1"
                                            }
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    item.MenuID,
                                                    "CanSave",
                                                    e.target.checked,
                                                    selectedUser.UserID,
                                                    selectedUser.LevelID
                                                )
                                            }
                                        />
                                    </td>
                                    <td className="text-center py-1">
                                        <input
                                            type="checkbox"
                                            checked={
                                                selectedPermission.find(
                                                    (x) =>
                                                        x.MenuID === item.MenuID
                                                )?.CanEdit === "1"
                                            }
                                            // checked={item.CanEdit}
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    item.MenuID,
                                                    "CanEdit",
                                                    e.target.checked,
                                                    selectedUser.UserID,
                                                    selectedUser.LevelID
                                                )
                                            }
                                        />
                                    </td>
                                    <td className="text-center py-1">
                                        <input
                                            type="checkbox"
                                            checked={
                                                selectedPermission.find(
                                                    (x) =>
                                                        x.MenuID === item.MenuID
                                                )?.CanDelete === "1"
                                            }
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    item.MenuID,
                                                    "CanDelete",
                                                    e.target.checked,
                                                    selectedUser.UserID,
                                                    selectedUser.LevelID
                                                )
                                            }
                                        />
                                    </td>
                                    <td className="text-center py-1">
                                        <input
                                            type="checkbox"
                                            checked={
                                                selectedPermission.find(
                                                    (x) =>
                                                        x.MenuID === item.MenuID
                                                )?.CanExport === "1"
                                            }
                                            onChange={(e) =>
                                                handleCheckboxChange(
                                                    item.MenuID,
                                                    "CanExport",
                                                    e.target.checked,
                                                    selectedUser.UserID,
                                                    selectedUser.LevelID
                                                )
                                            }
                                        />
                                    </td>
                                </tr>
                            );
                        })}
                    </tbody>
                </table>
            </ul>

            <div className="row">
                <div
                    className="col-lg-12 col-md-12 col-sm-12"
                    style={{
                        display: "flex",
                        justifyContent: "flex-end",
                        marginTop: "20px",
                    }}
                >
                    <button
                        className="btn btn-primary mr-2"
                        onClick={handleSavePermission}
                    >
                        ບັນທຶກ
                    </button>
                    <button
                        className="btn btn-danger"
                        onClick={handleResetPermission}
                    >
                        ລ້າງ
                    </button>
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
            </div>
        </div>
    );
};

export default Permission;
