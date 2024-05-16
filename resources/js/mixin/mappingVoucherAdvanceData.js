export default {
    methods: {
        mappingVoucherAdData(data) {
            this.store.referenceNo = data.VoucherNo;
            this.store.paymentType = data.PaidCash > 0 ? false : true;
            this.store.chequeNo = data.ChequeNo;
            this.store.chequeDate = data.ChequeDt;
            this.store.amount = data.Voucher_Amt;
            this.store.currency = data.Currency;
            this.store.rate = data.Rate;
            this.store.descriptionLao = data.DescriptionL;
            this.store.descriptionEng = data.DescriptionE;
            this.store.voucherDate = data.VoucherDt.substr(0,10);
            this.store.invoiceNo = null;
            this.store.province = data.ProvinceID;
            this.store.district = data.DistrictID;
            this.store.village = data.VillageID;
            this.store.totalCreditUsd = data.Amt_USD_Cr.toFixed(2);
            this.store.totalDebitUsd = data.Amt_USD_Dr.toFixed(2);
            this.store.totalCreditLak = data.Amt_LAK_Cr;
            this.store.totalDebitLak = data.Amt_USD_Dr.toFixed(2);
            this.store.level = data.LevelID;
            this.store.Pay_to = data.Pay_to;
            this.store.Pay_to_Address = data.Pay_to_Address;
            data.items.forEach(item => {
                console.log('sub item from mapping data ====', item)
                this.accountParing.push({
                    debit: item.Code_Dr,
                    credit: item.Code_Cr,
                    descriptionL: item.DescriptionL,
                    descriptionE: item.DescriptionE,
                    actions: item.USD_Cr > 0 ? 'credit' : 'debit',
                    pair: item.Pair,
                    account: this.accounts.filter(i => i.AccountCD === item.AccountCD)[0],
                    amountDebitLak: item.LAK_Dr,
                    amountCreditLak: item.LAK_Cr,
                    amountDebitUsd: item.USD_Dr.toFixed(2),
                    amountCreditUsd: item.USD_Cr.toFixed(2),
                    donor: this.donors.filter(i => i.DonorID === item.DonorID)[0],
                    pairCode: item.PairCD,
                    pairType: item.PairType,
                    rate: item.iRate,
                    amount: data.Voucher_Amt,
                    currency: data.Currency,
                    activity: this.activity.filter(i => i.ActivityID === item.ActivityID)[0],
                    category: this.activity.filter(i => i.ActivityID === item.ActivityID)[0].category,
                    costCenter: this.costCenters.filter(i => i.CCtrID === item.CCtrID)[0],
                    subCostCenter: this.subCostCenters.filter(i => i.SCCtrID === item.SCCtrID)[0]
                })
            })
        },
    }
}
