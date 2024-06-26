import React from "react";

const BasicModalComponent = ({
    children,
    isActive,
    title = "Modal title",
    setIsActive,
    id = "exampleModal",
}) => {
    return (
        <div
            className={`modal fade ${isActive ? "show" : ""}`}
            id={id}
            tabIndex="-1"
            aria-labelledby="exampleModalLabel"
            aria-hidden="true"
            style={{ display: isActive ? "block" : "none" }}
        >
            <div className="modal-dialog modal-dialog-centered modal-xl">
                <div className="modal-content">
                    <div className="modal-header">
                        <h5 className="modal-title" id="exampleModalLabel">
                            {title}
                        </h5>
                        <button
                            type="button"
                            className="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close"
                            onClick={() => setIsActive(false)}
                        ></button>
                    </div>
                    <div className="modal-body">{children}</div>

                </div>
            </div>
        </div>
    );
};

export default BasicModalComponent;
