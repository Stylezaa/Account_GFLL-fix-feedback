<template>
    <div>
        <div class="pa-2" ref="content">
            <v-row>
                <v-col cols md="12" sm="12" class="d-flex justify-content-center">{{ voucher ? voucher.data[0].Lao1 : '' }}
                </v-col>
                <v-col cols md="12" sm="12" class="mt-n5 d-flex justify-content-center">
                    {{ voucher ? voucher.data[0].Lao2 : '' }}
                </v-col>
            </v-row>

            <v-row>
                <v-col cols md="12" sm="12" class="d-flex justify-content-start">{{ voucher ? voucher.data[0].Ministry : '' }}
                </v-col>
                <v-col cols md="12" sm="12" class="d-flex mt-n5 justify-content-start">
                    {{ voucher ? voucher.data[0].Department : '' }}
                </v-col>
                <v-col cols md="12" sm="12" class=" d-flex mt-n5 justify-content-start">
                    {{ voucher ? voucher.data[0].Project : '' }}
                </v-col>
                <v-col cols md="6" sm="6" class=" d-flex mt-n5 justify-content-start">
                    {{ voucher ? voucher.data[0].Implement : '' }}
                </v-col>
                <v-col cols md="6" sm="6" class="d-flex mt-n5 justify-content-end">ເລກທີ່ No_:<p class="text-box">
                    {{ voucher ? voucher.data[0].VoucherNo : '' }}</p></v-col>
                <v-col cols md="6" sm="6" class=" d-flex mt-n10 justify-content-start"></v-col>
                <v-col cols md="6" sm="6" class="d-flex mt-n10 justify-content-end">ວັນທີ່ Date_:<p class="text-box">
                    {{ voucher ? $moment(voucher.data[0].VoucherDt, 'DD-MM-YYYY') : '' }}</p></v-col>
                <v-col cols md="12" sm="12" class="mt-1 d-flex justify-content-center"><p class="title-text">
                    {{ voucher ? voucher.data[0].Header : '' }}</p>
                </v-col>
            </v-row>

            <v-row class="mt-n5">
                <v-col cols md="9" sm="8" class="d-flex d-block justify-content-start">
                    <p class="refer-box-title">ອີງຕາມ Refer:</p>
                    <p class="refer-box">{{ voucher ? voucher.data[0].Refer : '' }}</p>
                </v-col>
                <v-col cols md="3" sm="4" class="d-flex justify-content-end">ວັນທີ່ Date:<p class="text-box">
                    {{ voucher ? voucher.data[0].ReferDt : '' }}</p>
                </v-col>
                <v-col cols md="12" sm="12" class="mt-n10 d-flex justify-content-start">
                    <p class="refer-box-title">ຈ່າຍໃຫ້ Pay to:</p>
                    <p class="refer-box">{{ voucher ? voucher.data[0].Pay_to : '' }}</p>
                </v-col>
                <v-col cols md="4" sm="5" class="mt-n10 d-flex justify-content-start">
                    <p class="refer-box-title">ຈ່າຍໂດຍ Pay by:</p>
                    <v-checkbox :model-value="voucher && voucher.data[0].PaidCash === 1" readonly="" label="cash"
                                class="mt-n4" style="width: 100%;"/>
                    <v-checkbox :model-value="voucher && voucher.data[0].PaidCash === 0" readonly="" label="cheque"
                                class="mt-n4" style="width: 100%;"/>
                </v-col>
                <v-col cols md="2" sm="3" class="mt-n10 d-flex justify-content-end">
                    <p class="refer-box-title-right">No:</p>
                    <p class="text-box">{{ voucher ? voucher.data[0].ChequeNo : '' }}</p>
                </v-col>
                <v-col cols md="6" sm="4" class="mt-n10 d-flex justify-content-end">
                    <p class="refer-box-title-right">ວັນທີ່ Cheque Date:</p>
                    <p class="text-box">{{ voucher ? $moment(voucher.data[0].ChequeDt, 'DD-MM-YYYY') : '' }}</p>
                </v-col>
            </v-row>

            <v-table density="compact" class="mt-n7">
                <thead>
                <tr>
                    <th>ລາຍການ Description</th>
                    <th style="width: 300px !important;">ຈຳນວນເງິນກີບ Amount LAK</th>
                    <th style="width:200px !important;">ອັດຕາແລກປ່ຽນ Exchange Rate</th>
                    <th style="width: 300px !important;">ຈຳນວນເງິນໂດລາ Amount USD</th>
                </tr>
                </thead>
                <tbody>
                <tr>
                    <td>{{ voucher ? voucher.data[0].DescriptionL : '' }}</td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_LAK, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width:200px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Rate, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_USD, '0,00.00') : '' }}
                    </td>
                </tr>
                <!--<tr>
                    <td>{{ voucher ? voucher.data[0].DescriptionE : '' }}</td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_LAK, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width:200px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Rate, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_USD, '0,00.00') : '' }}
                    </td>
                </tr>-->
                <!--<tr>
                    <td class="summary-row1"></td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_LAK, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width:200px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Rate, '0,00.00') : '' }}
                    </td>
                    <td class="text-right" style="width: 300px !important;">
                        {{ voucher ? numeralFormat(voucher.data[0].Voucher_USD, '0,00.00') : '' }}
                    </td>
                </tr>-->
                </tbody>
            </v-table>

            <v-row>
                <v-col cols md="12" sm="12" class="d-flex d-block justify-content-start h-25">
                    <p class="amount-letter-text">ຈຳນວນເງິນເປັນຕົວໜັງສີ Amount in letter:</p>
                    <p class="amount-letter-number">{{ voucher ? voucher.data[0].AmtLetter : '' }}</p>
                </v-col>
            </v-row>

            <v-divider ticknes="1" color="black"/>

            <v-table density="compact" class="custom-table">
                <thead>
                <tr>
                    <th class="text-nowrap" rowspan="2">ເລກບັນຊີ<br/>Acct</th>
                    <th class="text-nowrap" rowspan="2">ອົງປະກອບ<br/>Task</th>
                    <th class="text-nowrap" rowspan="2">ຮ່ວງ<br/>Category</th>
                    <th class="text-nowrap" rowspan="2">ແຫຼ່ງທຶນ<br/>Source of Fund</th>
<!--                    <th class="text-nowrap" rowspan="2">ຫ້ອງການ<br/>Cost center</th>-->
                    <th class="text-nowrap" rowspan="2">ບ້ານ, ເມືອງ, ແຂວງ<br/>Sub-Cost Center</th>
                    <th class="text-nowrap" rowspan="2">ລາຍການ<br/>Description</th>
                    <!--<th rowspan="2">ຈຳນວນເງິນລວມ</th>-->
                    <th class="text-nowrap" colspan="2">ຈຳນວນເງິນແບ່ງຈ່າຍ<br/>100% TF (KIP)</th>
                    <th class="text-nowrap" colspan="2">ຈຳນວນເງິນແບ່ງຈ່າຍ<br/>100% TF (USD)</th>
                </tr>
                <tr>
                    <th class="text-nowrap">ໜີ້ Debit</th>
                    <th class="text-nowrap">ມີ Credit</th>
                    <th class="text-nowrap">ໜີ້ Debit</th>
                    <th class="text-nowrap">ມີ Credit</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="voucher && voucher.deta !== null" v-for="(item, index) in voucher.data" :key="`voucher-${index}`">
                    <td class="text-nowrap">{{ item.AccountCD }}</td>
                    <td class="text-nowrap">{{ item.ActivityID }}</td>
                    <td class="text-nowrap">{{ item.CategoryID }}</td>
                    <td class="text-nowrap">{{ item.DonorID }}</td>
<!--                    <td class="text-nowrap">{{ item.CCtrID }}</td>-->
                    <td class="text-nowrap">{{ item.SCCtrID }}</td>
                    <td class="text-nowrap">{{ item.ItemDescription }}</td>
                    <!--<td></td>-->
                    <td class="text-right">{{ numeralFormat(item.LAK_Dr, '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(item.LAK_Cr, '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(item.USD_Dr, '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(item.USD_Cr, '0,00.00') }}</td>
                </tr>
                <tr>
                    <td class="summary-row2"></td>
                    <td class="summary-row2"></td>
                    <td class="summary-row2"></td>
                    <td class="summary-row2"></td>
                    <td class="summary-row2"></td>
<!--                    <td class="summary-row2"></td>-->
                    <!--<td class="summary-row2"></td>-->
                    <td class="summary-row2"></td>
                    <td class="text-right">{{ numeralFormat(calTotalLakDr(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calTotalLakCr(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calTotalUsdDr(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calTotalUsdCr(), '0,00.00') }}</td>
                </tr>
                </tbody>
            </v-table>

            <v-row class="mt-10">
                <!--     First row       -->
                <v-col cols md="4" sm="4" class="d-flex d-block justify-content-start h-25">
                    <p class="summary-title">
                        {{ voucher ? voucher.data[0].Sign1 : '' }} <br/>
                        {{ voucher ? voucher.data[0].SubSign1 : '' }}
                    </p>
                </v-col>
                <v-col cols md="4" sm="4" class="d-flex d-block justify-content-start h-25">
                    <p class="summary-title">
                        {{ voucher ? voucher.data[0].Sign2 : '' }} <br/>
                        {{ voucher ? voucher.data[0].SubSign2 : '' }}
                    </p>
                </v-col>

                <!--    Second row       -->
                <v-col cols md="4" sm="4" class="d-flex d-block justify-content-start h-25">
                    <p class="summary-title">
                        {{ voucher ? voucher.data[0].Sign3 : '' }} <br/>
                        {{ voucher ? voucher.data[0].SubSign3 : '' }}
                    </p>
                </v-col>
                <v-col cols md="4" sm="4" class="d-flex d-block mt-n7 justify-content-start h-25">
                    <p class="summary-title">
                        ວັນທີ່ Date:
                    </p>
                    <p class="summary-signal-right"></p>
                </v-col>

                <!--    Thirth row       -->
                <v-col cols md="4" sm="4" class="d-flex d-block mt-n7 justify-content-start h-25">
                    <p class="summary-title">
                        ພີມເຂົ້າໂດຍ:
                    </p>
                    <p class="summary-signal-left"></p>
                </v-col>

                <!--    Fourth row       -->
                <v-col cols md="4" sm="4" class="d-flex d-block mt-n7 justify-content-start h-25">
                    <p class="summary-title">
                        ວັນທີ່ Date:
                    </p>
                    <p class="summary-signal-left"></p>
                </v-col>

            </v-row>
        </div>
    </div>
</template>

<script>
import {swalWarningToast} from "../mixin/swalhelper";

export default {
    directives: {
        print
    },
    data() {
        return {
            voucher: null
        }
    },
    mounted() {
        this.callVoucherData();
    },
    methods: {
        async callVoucherData() {
            try {
                const query = new URLSearchParams(window.location.search);
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CashVoucher/preview/data/${query.get('level')}/${query.get('implementCD')}/${query.get('voucherNo')}`, {
                    headers: {
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                }).then((res) => {
                    if (res.data !== null) {
                        this.voucher = res.data;
                    }
                })

            } catch (error) {
                swalWarningToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນທຶກບັນຊີໄດ້!')
            }
        },

        calTotalLakDr() {
            let amount = 0;
            if (this.voucher !== null) {
                this.voucher.data.forEach(item => {
                    if (item.LAK_Dr > 0) {
                        amount = amount + parseInt(item.LAK_Dr);
                    }
                });
            }
            return amount;
        },

        calTotalLakCr() {
            let amount = 0;
            if (this.voucher !== null) {
                this.voucher.data.forEach(item => {
                    if (item.LAK_Cr > 0) {
                        amount = amount + parseInt(item.LAK_Cr);
                    }
                });
            }
            return amount;
        },

        calTotalUsdDr() {
            let amount = 0;
            if (this.voucher !== null) {
                this.voucher.data.forEach(item => {
                    if (item.USD_Dr > 0) {
                        amount = amount + parseInt(item.USD_Dr);
                    }
                });
            }
            return amount;
        },

        calTotalUsdCr() {
            let amount = 0;
            if (this.voucher !== null) {
                this.voucher.data.forEach(item => {
                    if (item.USD_Cr > 0) {
                        amount = amount + parseInt(item.USD_Cr);
                    }
                });
            }
            return amount;
        },
    }
}
</script>

<style scoped>
.text-box {
    display: inline-block;
    background-color: white;
    color: black;
    border: 1px solid #000;
    margin-left: 5px;
    padding-left: 20px;
    padding-right: 20px;
    width: 150px;
}

.title-text {
    font-size: 15pt;
    font-weight: 900;
}

.refer-box-title {
    display: inline-block;
    min-width: 150px;
    max-width: 150px;
    width: 150px !important;
    margin: 0 auto;
}

.amount-letter-text {
    display: flex;
    min-width: 300px;
    max-width: 300px;
    margin: 0 auto;
    height: 50px;
    align-items: center;
}

.amount-letter-number {
    display: flex;
    background-color: white;
    color: black;
    border: 1px solid #000;
    padding-left: 20px;
    padding-right: 20px;
    width: 100%;
    height: 50px;
    align-items: center;
}

.refer-box-title-right {
    width: 150px;
    justify-content: flex-end;
    align-content: flex-end;
    margin-right: 0;
}

.refer-box {
    display: inline-flex;
    background-color: white;
    color: black;
    border: 1px solid #000;
    padding-left: 20px;
    padding-right: 20px;
    height: 25px;
    width: 100%;
}

.summary-row1 {
    border-left: none;
    border-bottom: none;
    border-right: none;
    border-top: 1px solid black;
    background-color: var(--bs-body-bg);
}

.summary-row2 {
    border-left: none;
    border-bottom: none;
    border-right: none;
    border-top: 1px solid black;
    background-color: var(--bs-body-bg);
}

.rate-text-size {
    display: flex;
    min-width: 150px;
    max-width: 150px;
    margin: 0 auto;
    height: 50px;
    align-items: center;
    justify-items: center;
    justify-content: center;
}

.custom-table {
    align-items: center;
    justify-content: center;
    justify-items: center;
    font-size: 10pt;
}

.summary-title {
    justify-content: flex-end;
    align-content: flex-end;
    margin-right: 0;
}

.summary-signal-left {
    width: 300px;
    justify-content: flex-end;
    margin-left: 12px;
    align-content: flex-end;
    border-bottom: 1px solid #000000;
    border-left: 0;
    border-right: 0;
    border-top: 0;
}

.summary-signal-right {
    width: 300px;
    justify-content: flex-end;
    margin-left: 12px;
    align-content: flex-end;
    border-bottom: 1px solid #000000;
    border-left: 0;
    border-right: 0;
    border-top: 0;
}
</style>
