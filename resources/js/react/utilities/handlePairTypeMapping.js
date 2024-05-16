const handlePairTypeMapping = (data) => {
    if (data.length > 0) {
        const debit = data.filter(
            (item) => item.item_voucher_type === "debit"
        );
        const credit = data.filter(
            (item) => item.item_voucher_type === "credit"
        );

        if (debit.length > 1 && credit.length > 1) {
            return "MM";
        } else if (debit.length > 1 && credit.length === 1) {
            return "MO";
        } else if (debit.length === 1 && credit.length > 1) {
            return "OM";
        } else if (debit.length === 1 && credit.length === 1) {
            return "OO";
        }
    }
};

export default handlePairTypeMapping;