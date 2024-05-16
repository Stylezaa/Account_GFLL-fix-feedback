<template>
  <div>
    <v-row>
      <!--     Left side       -->
      <v-col cols md="4">
        <v-card class="pa-3">
          <v-text-field
              v-model="postForm.autoNo"
              density="compact"
              variant="outlined"
              label="ເລກທີ່ບິນລະບົບ"
              readonly=""
          />
          <v-text-field
              v-model="postForm.reconNo"
              density="compact"
              variant="outlined"
              label="ເລກທີ່ໃບສົມທຽບເງິນສົດ"
          />
          <v-text-field
              v-model="postForm.referenceNo"
              density="compact"
              variant="outlined"
              label="ເລກທີ່ໃບຕິດຕາມ"
          />
          <v-text-field
              v-model="postForm.selectedAccounts.AccountCD"
              density="compact"
              variant="outlined"
              label="ເລກລະຫັດບັນຊີ"
              readonly=""
          />
          <v-text-field
              v-model="postForm.endingDate"
              density="compact"
              variant="outlined"
              label="ຍອດເຫຼືອຍົກມາ, ວັນທີ່"
              type="month"
              class="d-inline-flex"
          />
          <!--          ປຸ່ມຄຳນວນ          -->
          <v-btn
              color="blue"
              prepend-icon="mdi-calculator"
              class="d-inline-flex mt-n4 mb-4"
              style="width: 30% !important" @click="calculate">{{ $t('calculate') }}
          </v-btn>
          <v-text-field
              v-model.lazy="postForm.openBalance"
              v-number="postForm.openBalance"
              density="compact"
              variant="outlined"
              label="ຍອດຍົກມາ"
              readonly=""
          />
          <v-text-field
              v-model.lazy="postForm.received"
              v-number="postForm.received"
              density="compact"
              variant="outlined"
              :label="$('payin')"
              readonly=""
          />
          <v-text-field
              v-model.lazy="postForm.payment"
              v-number="postForm.payment"
              density="compact"
              variant="outlined"
              :label="$t('payout')"
              readonly=""
          />
          <v-text-field
              v-model.lazy="postForm.cashBookBalance"
              v-number="postForm.cashBookBalance"
              density="compact"
              variant="outlined"
              label="ຍອດເຫຼືອທ້າຍ"
              readonly=""
          />
          <v-text-field
              v-model.lazy="postForm.countableCasTotal"
              v-number="postForm.countableCasTotal"
              density="compact"
              variant="outlined"
              :label="$t('totalCashCount')"
              readonly=""
          />
          <v-text-field
              v-model.lazy="postForm.unBalance"
              v-number="postForm.unBalance"
              density="compact"
              variant="outlined"
              :label="$t('miss_match')"
              readonly=""
              color="yellow"
          />
        </v-card>
      </v-col>
      <!--      Right side      -->
      <v-col cols md="8">
        <v-card class="pa-3">
          <v-row>
            <v-col cols md="12" class="d-inline-flex">
              <v-autocomplete
                  v-model="postForm.level"
                  :items="levels"
                  :item-title="displayLevel"
                  item-value="LevelID"
                  density="compact"
                  variant="outlined"
                  :label="$t('level')"
                  class="mr-1"
              />
              <v-text-field
                  v-model="postForm.date"
                  density="compact"
                  variant="outlined"
                  :label="$t('recon_date')"
                  type="date"
              />
            </v-col>
            <v-col v-if="postForm.level !== 'C'" cols md="12" class="d-inline-flex mt-n3">
              <v-autocomplete
                  v-if="['P','D','V'].some((x) => x === postForm.level)"
                  v-model="postForm.province"
                  :readonly="['P','D','V'].some((x) => x === userLevel)"
                  :rules="['P','D','V'].some((x) => x === postForm.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                  density="compact"
                  variant="outlined"
                  :items="provinces"
                  item-value="ProvinceID"
                  :item-title="displayProvince"
                  :label="$t('province')"
                  @update:model-value="loadDistrict"
                  class="mr-1"
              />
              <v-autocomplete
                  v-if="['D','V'].some((x) => x === postForm.level)"
                  v-model="postForm.district"
                  :readonly="['D','V'].some((x) => x === userLevel)"
                  :rules="['D','V'].some((x) => x === postForm.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                  density="compact"
                  variant="outlined"
                  :items="districts"
                  item-value="DistrictID"
                  :item-title="displayDistrict"
                  :label="$t('district')"
                  @update:model-value="loadVillage"
              />
            </v-col>
            <v-col v-if="postForm.level === 'V'" cols md="12" class="mt-n3">
              <v-autocomplete
                  v-if="['V'].some((x) => x === postForm.level)"
                  v-model="postForm.village"
                  :readonly="['V'].some((x) => x === userLevel)"
                  :rules="['V'].some((x) => x === postForm.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                  density="compact"
                  variant="outlined"
                  :items="villages"
                  item-value="VillageID"
                  :item-title="displayVillage"
                  :label="$t('village')"
              />
            </v-col>
          </v-row>
        </v-card>

        <v-card class="pa-3 mt-3 d-flex">
          <v-btn
              color="blue"
              prepend-icon="mdi-book-open"
              width="300" max-width="300"
              class="mr-1"
              @click="accountDialog = !accountDialog">ບັນຊີ
          </v-btn>

          <v-text-field
              v-model="postForm.selectedAccounts.AccountNameE"
              variant="outlined"
              density="compact"
              :label="$t('accountList')"
              readonly=""
          />
        </v-card>

        <v-divider color="green"/>

        <v-card class="pa-3 mt-3">
          <v-table density="compact">
            <thead>
            <tr>
              <th class="text-center text-nowrap">{{$t('description')}}</th>
              <th class="text-center text-nowrap">{{$t('amount')}}</th>
              <th class="text-center text-nowrap">{{$t('bankNoteItem')}}</th>
              <th class="text-center text-nowrap">{{$t('totalAmount')}}]</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in bankNotes" :key="`bankNotes-${index}`">
              <td class="text-start text-nowrap">{{ item.NoteNameL }}</td>
              <td class="text-right text-nowrap">{{ numeralFormat(item.NoteValue, '0,00.00') }}</td>
              <td class="text-right text-nowrap">
                <v-text-field
                    v-model="postForm.notes[index].noteCount"
                    variant="plain"
                    density="compact"
                    flat=""
                    @update:model-value="calNote(index)"
                    style="height: 35px !important;"
                    class="mt-n4"
                />
              </td>
              <td class="text-right text-nowrap">
                <v-text-field
                    v-model.lazy="postForm.notes[index].noteTotal"
                    v-number="postForm.notes[index].noteTotal"
                    variant="plain"
                    density="compact"
                    flat=""
                    readonly=""
                    class="mt-n4"
                    style="height: 35px !important;"
                />
              </td>
            </tr>
            </tbody>
          </v-table>
        </v-card>
        <v-divider color="green"/>

        <v-card class="pa-3">
          <v-row>
            <v-col cols md="12">
              <v-btn-group density="compact" class="d-inline">
                <v-btn
                    color="blue"
                    prepend-icon="mdi-content-save"
                    height="38"
                    width="50%"
                    :loading="btnLoading"
                    @click="storeNewData">{{$t('save')}}
                </v-btn>
                <v-btn color="green" append-icon="mdi-printer" height="38" width="50%">ວີວເບິ່ງ</v-btn>
              </v-btn-group>
            </v-col>
          </v-row>
        </v-card>
      </v-col>
    </v-row>

    <v-row class="mt-3">
      <v-col cols md="12">
        <v-card class="pa-3">
          <v-text-field
              v-model="postForm.remark"
              :placeholder="$t('miss_match_des')"
              :label="$t('miss_match_des')"
              variant="outlined"
              density="compact"
          />
        </v-card>
      </v-col>
    </v-row>

    <v-dialog v-model="accountDialog" height="800" width="1100">
      <v-card>
        <v-card-title>
          <v-btn
              size="small"
              density="compact"
              icon="mdi-close"
              color="red"
              class="float-end"
              @click="accountDialog = !accountDialog"/>
        </v-card-title>
        <v-divider color="grey" class="mt-n1"/>
        <v-card-text>
          <v-table density="compact" fixed-header class="table table-bordered table-sm">
            <thead>
            <tr>
              <th style="width: 100px !important;">ເລກບັນຊີ</th>
              <th class="text-nowrap">ຊື່ພາສາລາວ</th>
              <th class="text-nowrap">ຊື່ພາສາອັງກິດ</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="(item, index) in accounts" :key="`accounts-${index}`"
                style="height: 25px !important;" @dblclick="setAccount(item)">
              <td style="width: 100px !important;">{{ item.AccountCD }}</td>
              <td class="text-nowrap">{{ item.AccountNameL }}</td>
              <td>{{ item.AccountNameE }}</td>
            </tr>
            </tbody>
          </v-table>
        </v-card-text>
        <v-card-actions>
          <v-btn>
            {{$t('close')}}
          </v-btn>
        </v-card-actions>
      </v-card>
    </v-dialog>
  </div>
</template>

<script>
import {swalErrorToast, swalSuccessToast, swalWarningToast} from "../mixin/swalhelper";
import {da} from "vuetify/locale";
import convertToNumMixin from "../mixin/convertToNumMixin";

export default {
  mixins: [convertToNumMixin],
  props: {
    locale: {
      type: String,
      required: true,
      default: 'la'
    }
  },
  data() {
    return {
      btnLoading: false,
      accountDialog: false,
      displayLevel: (item) => `${item.LevelID} - ${item.LevelNameL}`,
      displayProvince: (item) => `${item.ProvinceID} ${item.ProvinceNameL} ${item.ProvinceNameE}`,
      displayDistrict: (item) => `${item.DistrictID} ${item.DistrictNameL} ${item.DistrictNameE}`,
      displayVillage: (item) => `${item.VillageID} ${item.VillageNameL} ${item.VillageNameE}`,
      level: null,
      bankNotes: [],
      levels: [],
      provinces: [],
      districts: [],
      villages: [],
      accounts: [],
      userLevel: null,
      postForm: {
        autoNo: null,
        reconNo: null,
        referenceNo: null,
        selectedAccounts: [],
        level: null,
        endingDate: new Date().toISOString().substring(0, 7),
        date: new Date().toISOString().substring(0, 10),
        province: null,
        district: null,
        village: null,
        notes: [],
        openBalance: null,
        received: null,
        payment: null,
        cashBookBalance: null,
        countableCasTotal: null,
        unBalance: null,
        remark: null
      },
    }
  },
  async mounted() {
    this.$i18n.locale = this.locale;
    this.$forceUpdate();
    await this.loadingProvince();
    await this.loadBankNotes();
    await this.loadLevels();
    await this.loadingAccounts();
  },
  watch: {
    'postForm.notes': {
      deep: true,
      handler(newVal, oldVal) {
        newVal.forEach(obj => {
          obj.noteTotal = obj.note * obj.noteCount
        })
        this.postForm.countableCasTotal = newVal.reduce((acc, obj) => acc + obj.noteTotal, 0)
      }
    }
  },

  methods: {
    async loadBankNotes() {
      try {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/bankNotes`);
        this.bankNotes = res.data;
        res.data.forEach((item) => {
          this.postForm.notes.push({
            noteId: item.NoteID,
            note: parseInt(item.NoteValue),
            noteCount: 0,
            noteTotal: 0
          })
        })
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຊໍ້ມູນໃບເງິນໄດ້!')
      }
    },

    async storeNewData() {
      this.btnLoading = true;
      try {
        const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/storeNewReconcile`, this.postForm);
        if (res.data.status === 'success') {
          swalSuccessToast('ສຳເລັດ!', res.data.message);
        } else {
          swalWarningToast('ຜິດພາດ!', res.data.message)
        }
        this.btnLoading = false;
      } catch (error) {
        this.btnLoading = false;
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຊໍ້ມູນໃບເງິນໄດ້!')
      }
    },

    async calculate() {
      try {
        const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/calculate`, this.postForm);
        if (res.data.status === 'success') {
          if (res.data.data && res.data.data.length > 0) {
            this.postForm.openBalance = res.data.data[0].OpenAmt;
            this.postForm.received = res.data.data[0].TransDr;
            this.postForm.payment = res.data.data[0].TransCr;
            this.postForm.cashBookBalance = res.data.data[0].Balance;
          }

          this.postForm.unBalance = this.convertToNum(this.postForm.countableCasTotal) - this.convertToNum(this.postForm.cashBookBalance);
          swalSuccessToast('ສຳເລັດ!', res.data.message);
        } else {
          swalWarningToast('ຜິດພາດ!', res.data.message)
        }
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຊໍ້ມູນໃບເງິນໄດ້!')
      }
    },

    calNote(index) {
      this.postForm.notes[index].noteTotal = this.convertToNum(this.postForm.notes[index].note) * this.convertToNum(this.postForm.notes[index].noteCount);
    },

    async loadLevels() {
      try {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/levels`);
        this.levels = res.data.levels;
        this.postForm.level = res.data.selectedLevel;
        this.userLevel = res.data.selectedLevel;
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຂັ້ນຈັດຕັ້ງປະຕິບັດໄດ້!')
      }
    },

    async loadingProvince() {
      try {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/provinces`);
        if (res.data !== null) {
          this.provinces = res.data;
        }
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!')
      }
    },

    async loadDistrict() {
      try {
        let res;
        if (this.postForm.province !== null) {
          res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/districts?provinceId=${this.postForm.province}`);
        } else {
          res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/districts`);
        }
        if (res.data !== null) {
          this.districts = [];
          this.districts = res.data;
        }
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເມືອງໄດ້!')
      }
    },

    async loadVillage() {
      try {
        let res;
        if (this.postForm.district !== null) {
          res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/villages?districtId=${this.postForm.district}`);
        } else {
          res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/villages`);
        }
        if (res.data !== null) {
          this.villages = [];
          this.villages = res.data;
        }
      } catch (error) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບ້ານໄດ້!')
      }
    },

    async loadingAccounts() {
      try {
        const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/cash-reconcile/accounts`);
        if (res.data) {
          this.accounts = res.data;
        }
      } catch (err) {
        swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນຊີ!')
      }
    },

    setAccount(item) {
      this.postForm.selectedAccounts = item;
      this.accountDialog = !this.accountDialog;
    }
  }
}
</script>

<style scoped>

</style>
