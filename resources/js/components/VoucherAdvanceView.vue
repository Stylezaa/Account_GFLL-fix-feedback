<template>
    <div>
        <v-card class="mb-5">
            <v-card-text>
                <v-form>
                    <v-row class="mb-5">
                        <v-col cols="12" md="6" lg="6" xl="6" class="mb-n5">
                            <v-row>
                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-row>
                                        <v-col cols="12" md="6">
                                            <v-text-field
                                                v-model="store.referenceNo"
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                hint="AutoGenerate"
                                                label="Reference No"
                                                variant="outlined"/>
                                        </v-col>

                                        <v-col cols="12" md="6">
                                            <v-autocomplete
                                                v-model="store.paymentType"
                                                prepend-inner-icon="mdi-format-list-checks"
                                                density="compact"
                                                :items=paymentType
                                                item-title="title"
                                                item-value="value"
                                                auto-select-first
                                                variant="outlined"
                                                label="Payment Type"
                                                hint="EG: LAK"
                                            />
                                        </v-col>

                                        <v-col v-if="store.paymentType" cols="12" md="6" class="mt-n5">
                                            <v-text-field
                                                v-model="store.chequeNo"
                                                prepend-inner-icon="mdi-receipt"
                                                density="compact"
                                                variant="outlined"
                                                label="Cheque No"
                                                hint="EG: AB1234"
                                            />
                                        </v-col>

                                        <v-col v-if="store.paymentType" cols="12" md="6" class="mt-n5">
                                            <v-text-field
                                                v-model="store.chequeDate"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                variant="outlined"
                                                label="Cheque Date"
                                                hint="EG: 2023-07-23"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="store.amount"
                                                prepend-inner-icon="mdi-plus-box"
                                                density="compact"
                                                variant="outlined"
                                                label="Amount"
                                                hint="10000"
                                            />
                                        </v-col>

                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.currency"
                                                auto-select-first
                                                prepend-inner-icon="mdi-format-list-checks"
                                                density="compact"
                                                variant="outlined"
                                                label="Currency"
                                                hint="LAK"
                                                :items="currencies"
                                                item-title="CurrencyNameL"
                                                item-value="CurrencyCD"
                                            />
                                        </v-col>

                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model="store.rate"
                                                :disabled="store.currency === 'LAK'"
                                                prepend-inner-icon="mdi-trending-up"
                                                density="compact"
                                                variant="outlined"
                                                type="number"
                                                label="Rate"
                                                hint="0"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-text-field
                                        v-model="store.descriptionLao"
                                        prepend-inner-icon="mdi-comment-text-outline"
                                        density="compact"
                                        variant="outlined"
                                        label="Description(LAO)"
                                    />
                                </v-col>

                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-text-field
                                        v-model="store.descriptionEng"
                                        prepend-inner-icon="mdi-comment-text-outline"
                                        density="compact"
                                        variant="outlined"
                                        label="Description(ENG)"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>
                        <v-divider vertical color="success"/>
                        <v-col cols="12" md="6" lg="6" xl="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-text-field
                                                v-model="store.voucherNo"
                                                disabled
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                hint="AutoGenerate"
                                                label="Voucher No"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-menu
                                                v-model="voucherDateDialog"
                                                :close-on-content-click="false"
                                                :nudge-right="40"
                                                transition="scale-transition"
                                                offset-y
                                                min-width="auto">
                                                <template v-slot:activator="{ on }">
                                                    <v-text-field
                                                        v-model="store.voucherDate"
                                                        prepend-inner-icon="mdi-calendar"
                                                        variant="outlined"
                                                        label="Voucher Date"
                                                        density="compact"
                                                        v-on:click="on"
                                                    />
                                                </template>
                                                <datepicker
                                                    v-model="store.voucherDate"
                                                    no-title
                                                ></datepicker>
                                            </v-menu>
                                        </v-col>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-text-field
                                                v-model="store.invoiceNo"
                                                prepend-inner-icon="mdi-format-list-bulleted-type"
                                                density="compact"
                                                hint="AutoGenerate"
                                                label="Invoice No"
                                                variant="outlined"/>
                                        </v-col>

                                        <v-checkbox v-model="store.used" label="Used" class="mt-n2"></v-checkbox>

                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.province"
                                                prepend-inner-icon="mdi-home-outline"
                                                density="compact"
                                                variant="outlined"
                                                label="Province"
                                                :items="provinces"
                                                item-title="ProvinceNameL"
                                                item-value="ProvinceID"
                                                @update:modelValue="loadDistrict"
                                            />
                                        </v-col>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.district"
                                                prepend-inner-icon="mdi-source-branch"
                                                density="compact"
                                                variant="outlined"
                                                label="District"
                                                :items="districts"
                                                item-value="DistrictID"
                                                item-title="DistrictNameL"
                                                @update:modelValue="loadVillage"
                                            />
                                        </v-col>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.village"
                                                prepend-inner-icon="mdi-source-merge"
                                                density="compact"
                                                variant="outlined"
                                                label="Village"
                                                :items="villages"
                                                item-value="VillageID"
                                                item-title="VillageNameL"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>

            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th scope="col" style="width: auto"></th>
                            <th scope="col">No</th>
                            <th scope="col">Debit</th>
                            <th scope="col">Credit</th>
                            <th scope="col">Description</th>
                            <th scope="col">Amount Dr LAK</th>
                            <th scope="col">Amount Cr LAK</th>
                            <th scope="col">Rate</th>
                            <th scope="col">Amount Dr USD</th>
                            <th scope="col">Amount Cr USD</th>
                            <th scope="col">Activity</th>
                            <th scope="col">Category</th>
                            <th scope="col">Donor</th>
                            <th scope="col">CostCenter</th>
                            <th scope="col">SubCostCenter</th>
                            <th scope="col">Contract</th>
                            <th scope="col">Count</th>
                            <th scope="col">AccountCD</th>
                            <th scope="col">PairCode</th>
                            <th scope="col">Pair</th>
                            <th scope="col">PairType</th>
                            <th scope="col">RecCnt</th>
                            <th scope="col">DescriptionEng</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item, index) in accountParing" :key="`trRow-${index}`">
                        <td><v-icon @click="removeAccount(index, item.action)">mdi-minus-circle-outline</v-icon></td>
                        <td>{{ index + 1 }}</td>
                        <td>{{ item.actions === 'debit' ? item.account.AccountCD : '' }}</td>
                        <td>{{ item.actions === 'credit' ? item.account.AccountCD : '' }}</td>
                        <td>
                            <v-text-field
                            v-model="item.account.AccountNameL"
                            density="compact"
                            variant="plain"/>
                        </td>
                        <td>
                            <v-text-field
                            :value="lakDebitAmount(item)"
                            density="compact"
                            variant="plain"/>
                        </td>
                        <td>
                            <v-text-field
                                :value="lakCreditAmount(item)"
                                density="compact"
                                variant="plain"/>
                        </td>
                        <td>{{store.rate}}</td>
                        <td>{{item.actions === 'debit' ? store.amount : 0}}</td>
                        <td>{{item.actions === 'credit' ? store.amount : 0}}</td>
                        <td>{{item.activity.ActivityID}}</td>
                        <td></td>
                        <td></td>
                        <td>{{item.costCenter.CCtrID}}</td>
                        <td>{{item.subCostCenter.SCCtrID}}</td>
                        <td></td>
                        <td>{{index+1}}</td>
                        <td></td>
                        <td></td>
                        <td>{{item.pair}}</td>
                        <td></td>
                        <td></td>
                        <td>{{item.donor.DonorNameE}}</td>
                    </tr>
                    <tr>
                        <td><v-icon>mdi-minus-circle-outline</v-icon>
                        </td>
                        <td></td>
                        <td @click="openDialog('debit')"></td>
                        <td @click="openDialog('credit')"></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>

    </div>

    <v-dialog v-model="acctDialog" fullscreen>
        <v-card>
            <v-card-title>
                <v-btn
                    density="comfortable"
                    color="primary"
                    icon="mdi-close"
                    position="absolute"
                    @click="acctDialog = !acctDialog"
                    class="z-3"
                />
            </v-card-title>
            <v-divider/>
            <v-card-text>

                <v-card class="pa-3">
                    <v-card-title>
                        <p>ບັນຊີ</p>
                    </v-card-title>
                    <v-divider class="mt-n5" color="grey"/>
                    <v-row>
                        <!--          ບັນຊີ          -->
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-select
                                v-model="selectAccount"
                                density="compact"
                                label="ເລືອກບັນຊີ"
                                variant="outlined"
                                placeholder="ເລືອກບັນຊີ"
                                :items="accounts"
                                item-value="AccountCD"
                                item-title="AccountNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectAccount.AccountNameE"
                                density="compact"
                                label="ຊື່ບັນຊີ(ພາສາອັງກິດ)"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>

                        <!--       ທຶນ         -->

                        <v-col cols="12" md="6" class="mb-n4">
                            <v-autocomplete
                                v-model="selectDonor"
                                auto-select-first
                                density="compact"
                                label="ເລືອກທຶນ"
                                variant="outlined"
                                :items="donors"
                                item-value="DonorID"
                                item-title="DonorNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectDonor.DonorNameE"
                                density="compact"
                                label="ຊື່ທຶນ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <!--  Activities  -->

                <v-card class="pa-3 mt-2">
                    <v-card-title>
                        <p>ກິດຈະກຳ</p>
                    </v-card-title>
                    <v-divider class="mt-n5" color="grey"/>
                    <v-row>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-autocomplete
                                v-model="selectActivity"
                                density="compact"
                                label="ກິດຈະກຳ"
                                variant="outlined"
                                :items="activity"
                                item-value="ActivityID"
                                item-title="ActivityNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectActivity.ActivityNameE"
                                density="compact"
                                label="ຊື່ກິດຈະກຳ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <!--        ຮ່ວງລາຍຈ່າຍ (Category)        -->

                <v-card class="pa-3 mt-2">
                    <v-card-title>
                        <p>ຮ່ວງລາຍຈ່າຍ</p>
                    </v-card-title>
                    <v-divider class="mt-n5" color="grey"/>
                    <v-row>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-autocomplete
                                v-model="selectCategory"
                                density="compact"
                                label="ຮ່ວງລາຍຈ່າຍ"
                                variant="outlined"
                                :items="categories"
                                item-value="CategoryID"
                                item-title="CategoryNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectCategory.CategoryNameE"
                                density="compact"
                                label="ຮ່ວງລາຍຈ່າຍ"
                                variant="outlined"
                                readonly
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <!--        ຜູ້ນຳໃຊ້ທຶນ (CostCenter)        -->

                <v-card class="pa-3 mt-2">
                    <v-card-title>
                        <p>ຜູ້ນຳໃຊ້ທຶນ</p>
                    </v-card-title>
                    <v-divider class="mt-n5" color="grey"/>
                    <v-row>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-autocomplete
                                v-model="selectCostCenter"
                                density="compact"
                                label="ຜູ້ໃຫ້ທຶນ"
                                variant="outlined"
                                :items="costCenters"
                                item-value="CCtrID"
                                item-title="CCtrNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectCostCenter.CCtrNameE"
                                density="compact"
                                label="ຜູ້ໃຫ້ທຶນ"
                                variant="outlined"
                                readonly
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <!--        ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ (SubCostCenter)       -->

                <v-card class="pa-3 mt-2">
                    <v-card-title>
                        <p>ຜູ້ນຳໃຊ້ທຶນຍ່ອຍ</p>
                    </v-card-title>
                    <v-divider class="mt-n5" color="grey"/>
                    <v-row>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-autocomplete
                                v-model="selectSubCostCenter"
                                density="compact"
                                label="ຜູ້ໃຊ້ທຶນຍ່ອຍ"
                                variant="outlined"
                                :items="subCostCenters"
                                item-value="SCCtrID"
                                item-title="SCCtrNameL"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="6" class="mb-n4">
                            <v-text-field
                                v-model="selectSubCostCenter.SCCtrNameE"
                                density="compact"
                                label="ຜູ້ໃຊ້ທຶນຍ່ອຍ"
                                variant="outlined"
                                readonly
                            />
                        </v-col>
                    </v-row>
                </v-card>

                <v-col cols="12" class="d-flex justify-center mt-5 mb-5">
                    <v-btn
                        size="large"
                        prepend-icon="mdi-checkbox-marked-circle-outline"
                        color="primary" @click="pushAccounts">
                        ເພີ່ມລົງໃນລາຍການ
                    </v-btn>
                </v-col>

            </v-card-text>
        </v-card>
    </v-dialog>
</template>

<script>
import Datepicker from 'vue3-datepicker';
import {tr} from "vuetify/locale";

export default {
    components: [
        Datepicker
    ],
    data() {
        return {
            tab: '',
            initRow: 1,
            acctDialog: false,
            accounts: [],
            selectAccount: '',
            donors: [],
            selectDonor: '',
            activity: [],
            selectActivity: '',
            categories: [],
            selectCategory: '',
            costCenters: [],
            selectCostCenter: '',
            subCostCenters: [],
            selectSubCostCenter: '',
            currencies: [],
            provinces: [],
            districts: [],
            villages: [],
            accountParing: [],
            action: '',
            initPair: 0,
            //donorMix: item => `${item.DonorSym} ${item.DonorNameL}`,
            // accountMix: item => `${item.AccountCD} ${item.AccountNameL}`,
            // activityMix: item => `${item.ActivityID} ${item.ActivityNameL}`,
            // categoryMix: item => `${item.CategoryID} ${item.CategorySym} ${item.CategoryNameL}`,
            // costCenterMix: item => `${item.CCtrID} ${item.CCtrNameL}`,
            // subCostCenterMix: item => `${item.SCCtrID} ${item.SCCtrNameL}`,
            voucherDateDialog: true,
            voucherDate: new Date().toISOString().substring(0, 10),
            paymentType: [
                {
                    title: 'CASH',
                    value: false
                },
                {
                    title: 'CHEQUE',
                    value: true
                }
            ],
            store: {
                referenceNo: '',
                paymentType: '',
                chequeNo: '',
                chequeDate: '',
                amount:3000000,
                currency: 'USD',
                rate: 19000,
                descriptionLao: '',
                descriptionEng: '',
                voucherNo: '',
                voucherDate: new Date().toISOString().substring(0, 10),
                invoiceNo: '',
                province: '',
                district: '',
                village: '',
                used: false
            }
        }
    },

    mounted() {
        this.loadingAccounts();
        this.loadActivities();
        this.loadCategories();
        this.loadCostCenters();
        this.loadSubCostCenters();
        this.loadDonors();
        this.loadCurrency();
        this.loadProvince();
    },

    methods: {
        async loadingAccounts() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/GeneralVoucher/accounts`);
                if (res.data) {
                    this.accounts = res.data;
                }
            } catch (err) {
                console.log(err);
            }
        },

        async loadActivities() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/Activity/activities`);
                if (res.data !== null) {
                    this.activity = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadCategories() {
            const res = await axios.get(`http://127.0.0.1:8000/categories/categories`);
            if (res.data !== null) {
                this.categories = res.data;
            }
        },

        async loadCostCenters() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/CostCenter/costCenters`);
                if (res.data !== null) {
                    this.costCenters = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadDonors() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/donors/donors`);
                if (res.data !== null) {
                    this.donors = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadSubCostCenters() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/SubCostCenter/subCostCenters`);
                if (res.data !== null) {
                    this.subCostCenters = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadCurrency() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/GeneralVoucher/currencies`);
                if (res.data !== null) {
                    this.currencies = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadProvince() {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/GeneralVoucher/provinces`);
                if (res.data !== null) {
                    this.provinces = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadDistrict(provinceId) {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/GeneralVoucher/districts?provinceId=${provinceId}`);
                if (res.data !== null) {
                    this.districts = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadVillage(districtId) {
            try {
                const res = await axios.get(`http://127.0.0.1:8000/GeneralVoucher/villages?districtId=${districtId}`);
                if (res.data !== null) {
                    this.villages = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        openDialog(actions) {
            this.acctDialog = !this.acctDialog;
            this.action = actions;
        },

        pushAccounts() {
            if (this.action === 'debit') {
                this.initPair = this.initPair + 1;
            }
            const dataToPush = {
                actions: this.action,
                pair: this.initPair,
                account: this.selectAccount,
                donor: this.selectDonor,
                activity: this.selectActivity,
                category: this.selectCategory,
                costCenter: this.selectCostCenter,
                subCostCenter: this.selectSubCostCenter
            };
            this.accountParing.push(dataToPush)
            this.acctDialog = !this.acctDialog;
        },

        removeAccount(index) {
            this.accountParing.splice(index, 1)
        },

        lakDebitAmount(item){
            if (this.store.currency === 'LAK' && item.actions === 'debit'){
                return this.store.amount;
            }else if(this.store.currency === 'LAK' && item.actions !== 'debit'){
                return 0;
            }else if(this.store.currency !== 'LAK' && item.actions !== 'debit'){
                return 0;
            }else{
                return this.store.amount * this.store.rate;
            }
        },

        lakCreditAmount(item){
            if (this.store.currency === 'LAK' && item.actions === 'credit'){
                return this.store.amount;
            }else if(this.store.currency === 'LAK' && item.actions !== 'credit'){
                return 0;
            }else if(this.store.currency !== 'LAK' && item.actions !== 'credit'){
                return 0;
            }else{
                return this.store.amount * this.store.rate;
            }
        }
    }
}
</script>

<style scoped>
.table tr th {
    width: 50%;
}
</style>
