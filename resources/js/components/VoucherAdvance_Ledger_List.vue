<template>
    <div >
        <h4 class="fw-bold py-3 mb-4">
            <a class="btn rounded-pill btn-primary" @click="openAddva">
                            <i class="fa fa-plus-circle me-1"></i>
                            Add
                        </a>
                        
        </h4>       
    </div>
    <div>
        <v-card class="mb-5">
            <v-card-text>
                <v-form @submit.prevent="recordData">
                    <v-row class="mb-5">
                        <v-col cols="12" md="6" lg="6" xl="6" class="mb-n5">
                            <v-row>
                                <v-col cols="12" md="12" class="mb-n5">

                                </v-col>

                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-row>
                                        <v-col cols="12" md="4">
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
                                                        label="Start Date"
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

                                        <v-col cols="12" md="4" class="mb-n5">
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
                                                        label="End Date"
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

                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-btn
                                                block
                                                color="blue"
                                                class="white--text"
                                                prepend-icon="mdi-content-save"
                                                type="button">
                                                Search
                                            </v-btn>
                                        </v-col>
                                    </v-row>
                                </v-col>

                            </v-row>
                        </v-col>
                        <v-divider vertical color="success"/>
                        <v-col cols="12" md="6" lg="6" xl="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="12" class="mb-n5">

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
                                    </v-row>
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
        <div class="table-responsive">
            <v-table fixed-header density="compact">
                <thead>
                <tr>
                    <th></th>
                    <th>ຂັ້ນຈັດຕັ້ງປະຕິບັດ</th>
                    <th>ເລກທີໃບຢັ້ງຢືນ</th>
                    <th>ເລກທີໃບຕິດຕາມ</th>
                    <th>ວັນທີໃບຢັ້ງຢືນ</th>
                    <th>ປະເພດ</th>
                    <th>ເລກທີແຊັກ</th>
                    <th>ວັນທີອອອກແຊັກ</th>
                    <th>ເລກທີຈ່າຍລ່ວງໜ້າ</th>
                    <th>ແຕ່ມື້</th>
                    <th>ຫາມື້</th>
                    <th>ເປັນເງິນ</th>
                    <th>ອັດຕາເງິນ</th>
                    <th>ມູນຄ່າກີບ</th>
                    <th>ມູນຄ່າໂດລາ</th>
                    <th>ຢ່າໃຫ້</th>
                    <th>ເນື້ອໃນບິນ</th>
                    <th>ຂັ້ນ</th>
                    <th>ແຂວງ</th>
                    <th>ເມືອງ</th>
                    <th>ບ້ານ</th>
                    <th>ຜູ້ເຄື່ອນໄຫວ</th>
                    <th>ວັນທີເຄື່ອນໄຫວ</th>
                    <th>ຄອມພິວເຕີເຄື່ອນໄຫວ</th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(item, index) in accountParing" :key="`trRow-${index}`">
                    <td>
                        <v-icon @click="removeAccount(index, item.action)">mdi-minus-circle-outline</v-icon>
                    </td>
                    <td style="width: 90px">{{ item.actions === 'debit' ? item.account.AccountCD : '' }}</td>
                    <td style="width: 90px;">{{ item.actions === 'credit' ? item.account.AccountCD : '' }}</td>
                    <td style="width: 350px">
                        <v-text-field
                            v-model="item.description"
                            density="compact"
                            variant="plain"
                            style="width: 350px"/>
                    </td>
                    <td>
                        <v-text-field
                            v-model.number="item.amountDebitLak"
                            density="compact"
                            variant="plain"
                            type="number"
                            style="width: 130px"
                            @update:modelValue="updateDebitLaoKip(index)"
                        />
                    </td>
                    <td>
                        <v-text-field
                            v-model.number="item.amountCreditLak"
                            density="compact"
                            variant="plain"
                            type="number"
                            style="width: 130px;"
                            @update:modelValue="updateCreditLaoKip(index)"
                        />
                    </td>
                    <td>
                        <v-text-field
                            v-model="item.rate"
                            density="compact"
                            variant="plain"
                            type="number"
                            style="width: 100px;"
                        />
                    </td>
                    <td>
                        <v-text-field
                            v-model.number="item.amountDebitUsd"
                            density="compact"
                            variant="plain"
                            type="number"
                            style="width: 130px;"
                            @update:modelValue="updateDebitUsd(index)"
                        />
                    </td>
                    <td>
                        <v-text-field
                            v-model.number="item.amountCreditUsd"
                            density="compact"
                            variant="plain"
                            type="number"
                            style="width: 130px;"
                            @update:modelValue="updateCreditUsd(index)"
                        />
                    </td>
                    <td><p style="width: 130px;">{{ item.activity.ActivityID }}</p></td>
                    <td style="width: 130px;">{{item.category.CategoryID}}</td>
                    <td style="width: 130px;">{{item.donor.DonorID}}</td>
                    <td><p style="width: 100px;">{{ item.costCenter.CCtrID }}</p></td>
                    <td><p style="width: 100px;">{{ item.subCostCenter.SCCtrID }}</p></td>
                    <td style="width: 100px;"></td>
                    <td><p style="width: 100px;">{{ index + 1 }}</p></td>
                    <td style="width: 100px;">{{item.account.AccountCD}}</td>
                    <td style="width: 100px;">{{item.pairCode}}</td>
                    <td>
                        <v-text-field
                            v-model.number="item.pair"
                            variant="plain"
                            density="compact"
                        />
                    </td>
                    <td style="width: 100px;">{{item.pairType}}</td>
                    <td style="width: 100px;"></td>
                    <td>
                        <p style="width: 300px">{{ item.donor.DonorNameE }}</p>
                    </td>
                </tr>
                <tr>
                    <td style="width: 100px;">
                        <v-icon>mdi-minus-circle-outline</v-icon>
                    </td>
                    <td @click="openDialog('debit')"></td>
                    <td @click="openDialog('credit')"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                    <td style="width: 100px;"></td>
                </tr>
                </tbody>
            </v-table>
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
            disabled: false,
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
            levels:[],
            selectLevel:'',
            action: '',
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
                referenceNo: "ABCDEFG",
                paymentType: "CASH",
                chequeNo: "CHEQ182734",
                chequeDate: "2023-07-29",
                amount: 3000000,
                currency: 'USD',
                rate: 19000,
                descriptionLao: "ປ້ອນລາຍລະອຽດຂໍ້ມູນຂອງທ່ານໃສ່ໃນນີ້ເດີເຈົ້າ",
                descriptionEng: "Enter your description in here to tell more details",
                voucherDate: new Date().toISOString().substring(0, 10),
                invoiceNo: "1827364",
                province: "01",
                district: "0101",
                village: "0101001",
                used: false,
                level:'C'
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
        this.loadLevels();
    },

    methods: {
        async loadingAccounts() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/accounts`);
                if (res.data) {
                    this.accounts = res.data;
                }
            } catch (err) {
                console.log(err);
            }
        },

        async loadActivities() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Activity/activities`);
                if (res.data !== null) {
                    this.activity = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadCategories() {
            const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/categories/categories`);
            if (res.data !== null) {
                this.categories = res.data;
            }
        },

        async loadCostCenters() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CostCenter/costCenters`);
                if (res.data !== null) {
                    this.costCenters = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadDonors() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/donors/donors`);
                if (res.data !== null) {
                    this.donors = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadSubCostCenters() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/SubCostCenter/subCostCenters`);
                if (res.data !== null) {
                    this.subCostCenters = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadCurrency() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/currencies`);
                if (res.data !== null) {
                    this.currencies = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadProvince() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/provinces`);
                if (res.data !== null) {
                    this.provinces = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadDistrict(provinceId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/districts?provinceId=${provinceId}`);
                if (res.data !== null) {
                    this.districts = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadVillage(districtId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/villages?districtId=${districtId}`);
                if (res.data !== null) {
                    this.villages = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async loadLevels() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/levels`);
                if (res.data !== null) {
                    this.levels = res.data;
                }
            } catch (error) {
                console.log(error)
            }
        },

        async recordData(){
            try{
                const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/store`,{
                    voucher: this.store,
                    detail: this.accountParing
                });
                console.log(res);
            }catch (err){
                console.log(err)
            }
        },

        openAddva() {
            window.location.href = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/addva`;
            // window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/addva`);
        },

        openDialog(actions) {
            if (actions === 'credit' && this.accountParing.length === 0) {
                //
            } else {
                this.acctDialog = !this.acctDialog;
                this.action = actions;
            }
        },

        pushAccounts() {
            this.disabled = true;
            const dataToPush = {
                debit: this.selectAccount.AccountCD,
                credit: this.selectAccount.AccountCD,
                description: this.store.used ? this.store.descriptionLao : this.selectAccount.AccountNameL,
                actions: this.action,
                pair: '',
                account: this.selectAccount,
                amountDebitLak: this.lakDebitAmount(this.store.currency, this.action),
                amountCreditLak: this.lakCreditAmount(this.store.currency, this.action),
                amountDebitUsd: this.usdDebitAmount(this.store.currency, this.action),
                amountCreditUsd: this.usdCreditAmount(this.store.currency, this.action),
                donor: this.selectDonor,
                pairCode: '',
                pairType: '',
                rate: this.store.rate,
                amount: this.store.amount,
                currency: this.store.currency,
                activity: this.selectActivity,
                category: this.selectCategory,
                costCenter: this.selectCostCenter,
                subCostCenter: this.selectSubCostCenter
            };
            this.accountParing.push(dataToPush)
            this.acctDialog = !this.acctDialog;
            this.resetVal();
            this.pairMapping();
            this.pairTypeMapping();
        },

        removeAccount(index) {
            this.accountParing.splice(index, 1)
        },

        lakDebitAmount(currency, action) {
            if (currency === 'LAK' && action === 'debit') {
                return this.store.amount;
            } else if (currency === 'LAK' && action !== 'debit') {
                return 0;
            } else if (currency !== 'LAK' && action !== 'debit') {
                return 0;
            } else {
                return this.store.amount * this.store.rate;
            }
        },

        lakCreditAmount(currency, action) {
            if (currency === 'LAK' && action === 'credit') {
                return this.store.amount;
            } else if (currency === 'LAK' && action !== 'credit') {
                return 0;
            } else if (currency !== 'LAK' && action !== 'credit') {
                return 0;
            } else {
                return this.store.amount * this.store.rate;
            }
        },

        usdCreditAmount(currency, action) {
            if (currency === 'USD' && action === 'credit') {
                return this.store.amount;
            } else if (currency === 'USD' && action !== 'credit') {
                return 0;
            } else if (currency !== 'USD' && action !== 'credit') {
                return 0;
            } else {
                return this.store.amount;
            }
        },

        usdDebitAmount(currency, action) {
            if (currency === 'USD' && action === 'debit') {
                return this.store.amount;
            } else if (currency === 'USD' && action !== 'debit') {
                return 0;
            } else if (currency !== 'USD' && action !== 'debit') {
                return 0;
            } else {
                return this.store.amount;
            }
        },

        resetVal() {
            this.selectDonor = '';
            this.selectAccount = '';
            this.selectActivity = '';
            this.selectCategory = '';
            this.selectCostCenter = '';
            this.selectSubCostCenter = '';
        },

        pairMapping() {
            let initPair = 1;
            let changed = false;
            for (let i = 0; i < this.accountParing.length; i++) {
                if (this.accountParing[i].actions === 'debit' && i === 0) {
                    this.accountParing[i].pair = initPair;
                } else if (this.accountParing[i].actions === 'debit' && i !== 0 && !changed) {
                    this.accountParing[i].pair = initPair;
                } else if (this.accountParing[i].actions === 'credit' && i !== 0 && !changed) {
                    this.accountParing[i].pair = initPair;
                    changed = true;
                } else if (this.accountParing[i].actions === 'credit' && i !== 0 && changed) {
                    this.accountParing[i].pair = initPair;
                } else if (this.accountParing[i].actions === 'debit' && i !== 0 && changed) {
                    changed = false;
                    initPair = initPair + 1;
                    this.accountParing[i].pair = initPair;
                }
            }
        },

        pairTypeMapping() {
            //holding all paring nums in here
            let initPair = [];

            // push all numbers
            this.accountParing.forEach(item => {initPair.push(item.pair)})

            //removed duplicate value
            let removeDuplicate = [...new Set(initPair)];

            let workingArrays = [];

            removeDuplicate.forEach(item => {
                workingArrays.push({
                  index: item,
                  debit: this.filterArrays(this.accountParing, item, 'debit'),
                  credit: this.filterArrays(this.accountParing, item, 'credit'),
                })
            })

            for (let i = 0; i < this.accountParing.length; i++){
                workingArrays.forEach(item =>{
                    console.log(item.credit);
                    if (this.accountParing[i].pair === item.index){
                        if (item.debit.length > 1 && item.credit.length > 1){
                            this.accountParing[i].pairType = 'MM';
                            //this.accountParing[i].pairCode = this.accountParing[i].credit;
                        }else if (item.debit.length > 1 && item.credit.length === 1){
                            this.accountParing[i].pairType = 'MO';
                            this.accountParing[i].pairCode = this.accountParing[i].credit;
                        }else if(item.debit.length === 1 && item.credit.length > 1){
                            this.accountParing[i].pairType = 'OM';
                            this.accountParing[i].pairCode = this.accountParing[i].debit;
                        }else if(item.debit.length === 1 && item.credit.length === 1){
                            this.accountParing[i].pairType = 'OO';
                            this.accountParing[i].pairCode = this.accountParing[i].credit;
                        }
                    }
                })
            }
        },

        filterArrays(array, pairNum, actions) {
            return array.filter(item => item.pair === pairNum && item.actions === actions);
        },

        updateDebitLaoKip(index){
         this.accountParing[index].rate =this.accountParing[index].amountDebitLak / this.accountParing[index].amountDebitUsd ;
        },

        updateCreditLaoKip(index){
         this.accountParing[index].rate = this.accountParing[index].amountCreditLak / this.accountParing[index].amountCreditUsd;
        },

        updateDebitUsd(index){
            this.accountParing[index].amountDebitLak = this.accountParing[index].amountDebitUsd * this.accountParing[index].rate;
        },

        updateCreditUsd(index){
            this.accountParing[index].amountCreditLak = this.accountParing[index].amountCreditUsd * this.accountParing[index].rate;
        }
    }
}
</script>

<style scoped>
v-table {
    border: 1px solid #666;
    table-layout: fixed !important;
}

th, td {
    border: 1px solid #666;
    width: 900px !important;
    overflow: hidden;
}
</style>
