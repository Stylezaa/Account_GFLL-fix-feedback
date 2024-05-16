const handlePair = (data) => {
    let initPair = 1;
    let changed = false;
    for (let i = 0; i < data.length; i++) {
        if (data[i].item_voucher_type === "debit" && i === 0) {
            return initPair;
        } else if (
            data[i].item_voucher_type === "debit" &&
            i !== 0 &&
            !changed
        ) {
            return initPair;
        } else if (
            data[i].item_voucher_type === "credit" &&
            i !== 0 &&
            !changed
        ) {
            changed = true;
            return initPair;
        } else if (
            data[i].item_voucher_type === "credit" &&
            i !== 0 &&
            changed
        ) {
            return initPair;
        } else if (
            data[i].item_voucher_type === "debit" &&
            i !== 0 &&
            changed
        ) {
            changed = false;
            initPair = initPair + 1;
            return initPair;
        }
    }
};

export default handlePair;