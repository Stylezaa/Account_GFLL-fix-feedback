<template>
    <div class="table-responsive">
        <v-table density="compact">
            <thead>
            <tr>
                <th class="text-no-wrap">{{ $t('bank_v_action') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_voucher_no')}}</th>
                <th class="text-no-wrap">{{ $t('bank_v_cheque_no')}}</th>
                <th class="text-no-wrap">{{ $t('bank_v_voucher_date') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_description')}}</th>
                <th class="text-no-wrap">{{ $t('bank_v_amount') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_currency') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_rate') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_debit_kip') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_credit_kip') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_debit_usd') }}</th>
                <th class="text-no-wrap">{{ $t('bank_v_credit_usd') }}</th>
                <th class="text-no-wrap">{{ $t('delete') }}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in vouchers" :key="`voucherBank-${index}`" @click="loadSingleItem(item)">
                <td class="text-no-wrap">
                    <v-btn-group density="compact" variant="plain" rounded>
                        <v-btn density="compact" icon="mdi-pencil" color="success" @click="preview(item,'edit')"/>
                        <v-btn density="compact" icon="mdi-printer" color="blue" @click="preview(item,'print')"/>
                    </v-btn-group>
                </td>
                <td class="text-no-wrap">{{ item.Vch_AutoNo }}</td>
                <td class="text-no-wrap">{{ item.ChequeNo }}</td>
                <td class="text-no-wrap">{{ $moment(item.VoucherDt, 'DD-MM-YYYY') }}</td>
                <td class="text-no-wrap">{{ $i18n.locale === 'en' ? item.DescriptionE : item.DescriptionL }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Voucher_Amt, '0,000.00') }}</td>
                <td class="text-no-wrap">{{ item.Currency }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Rate, '0,000.00') }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Amt_LAK_Dr, '0,000.00') }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Amt_LAK_Cr, '0,000.00') }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Amt_USD_Dr, '0,000.00') }}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.Amt_USD_Cr, '0,000.00') }}</td>
                <td class="text-no-wrap">
                    <v-btn
                        color="red"
                        :disabled="item.Close_accnt === 1"
                        icon="mdi-delete"
                        variant="plain"
                        density="compact" @click="deleteItem(item)"/>
                </td>
            </tr>
            </tbody>
        </v-table>

        <v-divider color="green"/>
        <v-table v-if="voucherItems && voucherItems.length > 0" density="compact" class="mt-3">
            <thead>
            <tr>
                <th class="text-no-wrap">ເລກບັນຊີໜີ້</th>
                <th class="text-no-wrap">ເລກບັນຊີມີ</th>
                <th class="text-no-wrap">ເນື້ອໃນ</th>
                <th class="text-no-wrap">ມູນຄ່າລົງໜີ້ກີບ</th>
                <th class="text-no-wrap">ມູນຄ່າລົງມີກີບ</th>
                <th class="text-no-wrap">ອັດຕາ</th>
                <th class="text-no-wrap">ມູນຄ່າລົງໜີ້ໂດລ່າ</th>
                <th class="text-no-wrap">ມູນຄ່າລົງມີໂດລ່າ</th>
                <th class="text-no-wrap">ລະຫັດກິດຈະກຳ</th>
                <th class="text-no-wrap">ຮ່ວງລາຍຈ່າຍ</th>
                <th class="text-no-wrap">ທຶນ</th>
                <th class="text-no-wrap">ຜູ້ນຳໃຊ້ທຶນ</th>
                <th class="text-no-wrap">ຜູ້ນຳໃຊ້ທຶນຍ່ອນ</th>
                <th class="text-no-wrap">ເລກສັນຍາ</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in voucherItems" :key="`voucherItem-${index}`">
                <td class="text-no-wrap">{{item.Code_Dr}}</td>
                <td class="text-no-wrap">{{item.Code_Cr}}</td>
                <td class="text-no-wrap">{{$i18n.locale === 'en' ? item.DescriptionE : item.DescriptionL}}</td>
                <td class="text-no-wrap text-right">{{numeralFormat(item.LAK_Dr,'0,000.00')}}</td>
                <td class="text-no-wrap text-right">{{numeralFormat(item.LAK_Cr,'0,000.00')}}</td>
                <td class="text-no-wrap text-right">{{numeralFormat(item.iRate,'0,000.00')}}</td>
                <td class="text-no-wrap text-right">{{numeralFormat(item.USD_Dr,'0,000.00')}}</td>
                <td class="text-no-wrap text-right">{{ numeralFormat(item.USD_Cr, '0,000.00')}}</td>
                <td class="text-no-wrap">{{item.ActivityID}}</td>
                <td class="text-no-wrap">{{item.activity ? item.activity.category.CategorySym : ''}}</td>
                <td class="text-no-wrap">{{item.DonorID}}</td>
                <td class="text-no-wrap">{{item.CCtrID}}</td>
                <td class="text-no-wrap">{{item.SCCtrID}}</td>
                <td class="text-no-wrap">{{item.ContractNo}}</td>
            </tr>
            </tbody>
        </v-table>
    </div>

</template>

<script>

import {swalConfirm, swalErrorToast, swalSuccessToast, swalWarningToast} from "../mixin/swalhelper";

export default {
    props: {
        vouchers: {
            type: Object,
            required: true
        },
        startDate1: {
            type: Date,
            required: true
        },
        endDate1: {
            type: Date,
            required: true
        },
        locale:{
            type:String,
            required:true
        }
    },
    data() {
        return {
            startDate: this.startDate1,
            endDate: this.endDate1,
            voucherItems: []
        }
    },
    mounted() {
        this.$i18n.locale = this.locale;
        this.$forceUpdate();
    },
    methods: {
        preview(item, action) {
            if (action === 'edit') {
                window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CashVoucher/add?action=edit&key=${item.Vch_AutoNo}`, '_blank')
            } else {
                window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CashVoucher/preview/print?level=${item.LevelID}&implementCD=${item.ImplementCD}&voucherNo=${item.Vch_AutoNo}`, '_blank')
            }
        },
        deleteAction(item) {
            axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CashVoucher/destroy?keyId=${item.Vch_AutoNo}`).then(() => {
                swalSuccessToast('ສຳເລັດ!', 'ການລຶບຂໍ້ມູນສຳເລັດ!')
                location.reload();
            });
        },
        deleteItem(item) {
            swalConfirm('ຢື່ນຢັນ!', 'ຕ້ອງການລຶບແທ້ບໍ່?', () => this.deleteAction(item))
        },
        async loadSingleItem(item) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CashVoucher/details/preview/data?voucherId=${item.Vch_AutoNo}`)
                if (res.data.length > 0){
                    this.voucherItems = res.data
                }else{
                    swalWarningToast('ແຈ້ງເຕືອນ!','ບໍ່ພົບມຂໍ້ມູນ!')
                }
            }catch (exception){
                swalErrorToast('ຜິດພາດ!','ບໍ່ສາມາດເອີ້ນຂໍ້ມູນມາສະແດງໄດ້!')
            }
        }
    }
}
</script>

<style scoped>

</style>
