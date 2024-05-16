const handlePairCode = (data) => {
    if (data.length > 0) {
        const debit = data.filter(
            (item) => item.item_voucher_type === "debit"
        );
        const credit = data.filter(
            (item) => item.item_voucher_type === "credit"
        );

        if (debit.length > 1 && credit.length > 1) {
            return data
                .find((item) => item.item_voucher_type === "credit")
                .number_credit.toString();
        } else if (debit.length > 1 && credit.length === 1) {
            return data
                .find((item) => item.item_voucher_type === "credit")
                .number_credit.toString();
        } else if (debit.length === 1 && credit.length > 1) {
            return data
                .find((item) => item.item_voucher_type === "debit")
                .number_debit.toString();
        } else if (debit.length === 1 && credit.length === 1) {
            return data
                .find((item) => item.item_voucher_type === "credit")
                .number_credit.toString();
        }
    }
};
export default handlePairCode;