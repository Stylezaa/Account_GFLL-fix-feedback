<template>
  <div>
    <v-card class="pa-3">
      <v-row class="mt-2">
        <v-col cols md="7" class="d-inline-flex justify-center align-center">
          <v-text-field
              v-model="postForm.startDate"
              :label="$t('report_ind_from_date')"
              type="date"
              variant="outlined"
              density="compact"
              class="mr-2"
          />
          <v-text-field
              v-model="postForm.endDate"
              :label="$t('report_ind_to_date')"
              type="date"
              variant="outlined"
              density="compact"
              class="mr-2"
          />
          <v-text-field
              :label="$t('referenceNo')"
              variant="outlined"
              density="compact"
              class="mr-2"
          />
        </v-col>
        <v-col cols md="5" class="d-inline-flex justify-start">
          <v-btn-group density="compact">
            <v-btn color="blue" prepend-icon="mdi-magnify">{{ $t('search') }}</v-btn>
            <v-btn color="#90CAF9" prepend-icon="mdi-pencil" class="text-white">{{ $t('edit') }}</v-btn>
            <v-btn color="red" prepend-icon="mdi-delete" @click="deleteConfirmation">{{ $t('delete') }}</v-btn>
            <v-btn color="purple" prepend-icon="mdi-recycle" @click="loadCashReconcile">{{ $t('reload') }}</v-btn>
            <v-btn color="green" prepend-icon="mdi-printer" :disabled="cashReconcile.length === 0"
                   @click="loadCashReconcilePreview">{{ $t('preview') }}
            </v-btn>
          </v-btn-group>
        </v-col>
      </v-row>
    </v-card>
    <v-row>
      <v-col cols md="12">
        <v-btn color="blue" prepend-icon="mdi-plus-circle" class="mt-2 d-flex float-right"
               @click="newCashReconcile">{{ $t('new') }}
        </v-btn>
      </v-col>
    </v-row>

    <v-card class="pa-3 mt-3" height="400" style="overflow-y: scroll">
      <v-table density="compact">
        <thead>
        <tr>
          <th class="text-center text-nowrap">ເລືອກ</th>
          <th class="text-center text-nowrap">ເລກທີ່ລະບົບ</th>
          <th class="text-center text-nowrap">ເລກທີ່ໃບສົມທຽບ</th>
          <th class="text-center text-nowrap">ວັນທີ່ສົມທຽບ</th>
          <th class="text-center text-nowrap">ເລກທີ່ໃບຕິດຕາມ</th>
          <th class="text-center text-nowrap">ລະຫັດບັນຊີ</th>
          <th class="text-center text-nowrap">ວັນທີ່ຍອດເຫຼືອ</th>
          <th class="text-center text-nowrap">ຍອດຍົກມາ</th>
          <th class="text-center text-nowrap">ຮັບເຂົ້າ</th>
          <th class="text-center text-nowrap">ຈ່າຍອອກ</th>
          <th class="text-center text-nowrap">ຄົງເຫຼືອບັນຊີ</th>
          <th class="text-center text-nowrap">ຍອດນັບເງິນສົດ</th>
          <th class="text-center text-nowrap">ຜິດດ່ຽງ</th>
          <th class="text-center text-nowrap">ໝາຍເຫດ</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in cashReconcile" :key="`cashReconcile-${index}`">
          <td class="text-start text-nowrap">
            <v-radio v-model="selectedRow" :value="item" @click="loadCashReconcileItem(item)"></v-radio>
          </td>
          <td class="text-start text-nowrap">{{ item.CRCC_No }}</td>
          <td class="text-start text-nowrap">{{ item.VoucherNo }}</td>
          <td class="text-start text-nowrap">{{ $moment(item.VoucherDt, 'DD-MM-yyyy') }}</td>
          <td class="text-start text-nowrap">{{ item.Ref_No }}</td>
          <td class="text-start text-nowrap">{{ item.account.AccountNameE }}</td>
          <td class="text-start text-nowrap">{{ $moment(item.CashOpenDt, 'DD-MM-yyyy') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Csh_ClosBk_Open, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Csh_ClosBk_Recpt, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Csh_ClosBk_pay, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Csh_ClosSt_Re, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Csh_OnH_Rem, '0,00.00') }}</td>
          <td class="text-start text-nowrap">{{ numeralFormat(item.Discrepancy, '0,00.00') }}</td>
          <td class="text-start text-nowrap">{{ item.Remark }}</td>
        </tr>
        </tbody>
      </v-table>
    </v-card>

    <v-card v-if="cashReconcileItems.length > 0" class="pa-3 mt-3" height="400" style="overflow-y: scroll">
      <v-table density="compact">
        <thead>
        <tr>
          <th class="text-center text-nowrap">{{ $t('description') }}</th>
          <th class="text-center text-nowrap">{{ $t('cashAmount') }}</th>
          <th class="text-center text-nowrap">{{ $t('count') }}</th>
          <th class="text-center text-nowrap">{{ $t('totalAmount') }}</th>
        </tr>
        </thead>
        <tbody>
        <tr v-for="(item, index) in cashReconcileItems" :key="`cashReconcileItem-${index}`">
          <td class="text-start text-nowrap">{{ item.bank_note.NoteNameL }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.bank_note.NoteValue, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Not_Qty, '0,00.00') }}</td>
          <td class="text-right text-nowrap">{{ numeralFormat(item.Not_amt, '0,00.00') }}</td>
        </tr>
        </tbody>
      </v-table>
    </v-card>

    <v-card v-else class="pa-3 mt-3 d-flex justify-center align-center" height="200">
      <h1 class="d-flex justify-center align-center text-red">
        <v-icon class="text-blue">mdi-emoticon-sad</v-icon>
        {{ $t('noDataFound') }}
      </h1>
    </v-card>
  </div>
</template>

<script>
import {swalConfirm, swalErrorToast, swalSuccessToast, swalWarningToast} from "../mixin/swalhelper";
import data from "bootstrap/js/src/dom/data";

export default {
  props: {
    locale: {
      type: String,
      required: true,
      default: 'la'
    }
  },
  data() {
    return {
      bankNotes: [],
      cashReconcile: [],
      cashReconcileItems: [],
      selectedRow: null,
      postForm: {
        startDate: new Date().toISOString().substring(0, 10),
        endDate: new Date().toISOString().substring(0, 10)
      }
    }
  },
  mounted() {
    this.$i18n.locale = this.locale;
    this.$forceUpdate();
    this.loadCashReconcile();
  },
  methods: {
    async loadCashReconcile() {
      try {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/reconcile`);
        this.cashReconcile = res.data;
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນສົມທຽບເງິນສົດໄດ້!')
      }
    },

    async loadCashReconcilePreview(item) {
      try {
        const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/reconcile/preview`, {
          level: this.selectedRow.LevelID,
          implement: this.selectedRow.ImplementCD,
          voucher: this.selectedRow.VoucherNo
        });
        this.cashReconcile = res.data;
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນສົມທຽບເງິນສົດໄດ້!')
      }
    },

    async newCashReconcile() {
      const urlPath = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/NewCashReconcile`;
      window.open(urlPath, '_blank');
    },

    async loadCashReconcileItem(item) {
      this.selectedRow = item;
      try {
        const id = item.VoucherNo;
        const level = item.LevelID;
        const implement = item.ImplementCD;
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/reconcileItem/${id}/${level}/${implement}`);
        this.cashReconcileItems = res.data;
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນໃບເງິນສົດໄດ້!')
      }
    },

    async deleteConfirmation() {
      swalConfirm('ຢື່ນຢັນ!', 'ທ່ານຕ້ອງການລົບແທ້ບໍ່?', async () => await this.deleteReconcile());
    },

    async deleteReconcile() {
      const voucher = this.selectedRow.VoucherNo;
      const level = this.selectedRow.LevelID;
      const implement = this.selectedRow.ImplementCD;
      if (this.selectedRow !== null || this.selectedRow !== "") {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/reconcile/delete/${voucher}/${level}/${implement}`);
        if (res.data.status === 'failed') {
          swalErrorToast('ຜິພາດ!', res.data.message);
        } else {
          swalSuccessToast('ສຳເລັດ!', res.data.message);
        }
        await this.loadCashReconcile();
        await this.loadCashReconcileItem(this.cashReconcile);
      } else {
        swalWarningToast('ແຈ້ງເຕືອນ!', 'ກາລຸນາເລືອກລາຍການເງິນສົດກ່ອນ!')
      }
    }
  }
}
</script>

<style scoped>

</style>
