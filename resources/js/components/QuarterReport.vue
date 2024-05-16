<template>
    <div>
        <v-card class="pa-5">
            <v-form ref="quarter">
                <v-row>
                    <v-col cols md="8" class="d-inline-flex">
                        <v-autocomplete
                            v-model="postForm.level"
                            density="compact"
                            :items="levels"
                            item-value="LevelID"
                            :item-title="levelDisplay"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            variant="outlined"
                            label="ເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ"
                            style="width: 68% !important; border-bottom-right-radius: 0 !important; border-top-right-radius: 0 !important;"
                            class="mr-1"
                        />
                        <v-autocomplete
                            v-if="['V','D','P'].some((x) => x === postForm.level)"
                            v-model="postForm.province"
                            density="compact"
                            :items="provinces"
                            item-value="ProvinceID"
                            :item-title="displayProvince"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            :readonly="['P'].some((x) => x === userLevel)"
                            variant="outlined"
                            label="ເລືອກແຂວງ"
                            style="width: 68% !important; border-bottom-right-radius: 0 !important; border-top-right-radius: 0 !important;"
                            class="mr-1"
                            @update:model-value="loadingDistrict"
                        />
                        <v-autocomplete
                            v-if="['V','D'].some((x) => x === postForm.level)"
                            v-model="postForm.district"
                            density="compact"
                            :items="districts"
                            item-value="DistrictID"
                            :item-title="displayDistrict"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            :readonly="['D'].some((x) => x === userLevel)"
                            variant="outlined"
                            label="ເລືອກເມືອງ"
                            style="width: 68% !important; border-bottom-right-radius: 0 !important; border-top-right-radius: 0 !important;"
                            class="mr-1"
                            @update:model-value="loadingVillage"
                        />
                        <v-autocomplete
                            v-if="['V'].some((x) => x === postForm.level)"
                            v-model="postForm.village"
                            density="compact"
                            :items="villages"
                            item-value="VillageID"
                            :item-title="displayVillage"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            :readonly="['V'].some((x) => x === userLevel)"
                            variant="outlined"
                            label="ເລືອກບ້ານ"
                            style="width: 68% !important; border-bottom-right-radius: 0 !important; border-top-right-radius: 0 !important;"
                            class="mr-1"
                        />
                        <v-text-field
                            v-model="postForm.year"
                            label="ເລືອກປີ"
                            density="compact"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            variant="outlined"
                            style="width: 30%;"
                            min="2000"
                            max="9999"
                            type="number"
                        />
                    </v-col>
                    <v-col cols md="4" class="d-inline-flex">
                        <v-btn-group density="compact">
                            <v-btn
                                prepend-icon="mdi-download"
                                color="green"
                                @click="loadDataToShow">ໂອນຂໍ້ມູນ
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-printer"
                                color="blue"
                                @click="previewAction('LAK')">ເບິ້ງຂໍ້ມູນ LAK
                            </v-btn>
                            <v-btn
                                prepend-icon="mdi-printer"
                                color="purple"
                                @click="previewAction('USD')">ເບິ່ງຂໍ້ມູນ USD
                            </v-btn>
                        </v-btn-group>
                    </v-col>
                </v-row>
            </v-form>
        </v-card>

        <v-card v-if="reportList.length > 0 && reportList !== []" class="pa-3 mt-3">
            <v-row>
                <v-col cols md="12">
                    <v-table density="compact">
                        <thead>
                        <tr>
                            <th class="text-no-wrap text-center">ລະຫັດກິດຈະກຳ</th>
                            <th class="text-no-wrap text-center">ຮ່ວງລາຍຈ່າຍ</th>
                            <th class="text-no-wrap text-center">ແຜນ BSP</th>
                            <th class="text-no-wrap text-center">ເນື້ອໃນກິດຈະກຳ</th>
                            <th class="text-no-wrap text-center">ເງິນກີບ I</th>
                            <th class="text-no-wrap text-center">ເງິນກີບ II</th>
                            <th class="text-no-wrap text-center">ເງິນກີບ III</th>
                            <th class="text-no-wrap text-center">ເງິນກີບ IV</th>
                            <th class="text-no-wrap text-center">ລວມເງິນກີບໝົດປີ</th>
                            <th class="text-no-wrap text-center">ເງິນໂດລ່າ I</th>
                            <th class="text-no-wrap text-center">ເງິນໂດລ່າ II</th>
                            <th class="text-no-wrap text-center">ເງິນໂດລ່າ III</th>
                            <th class="text-no-wrap text-center">ເງິນໂດລ່າ IV</th>
                            <th class="text-no-wrap text-center">ລວມເງິນໂດລ່າໝົດປີ</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in reportList" :key="`quarter-tr-${index}`"
                            @dblclick="openDialog(item)">
                            <td class="text-no-wrap">{{ item.ActivityID }}</td>
                            <td class="text-no-wrap">{{ item.CategoryID }}</td>
                            <td class="text-no-wrap">{{ item.BSPCat_ID }}</td>
                            <td class="text-no-wrap">{{ item.ActivityName }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetLAKQ1, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetLAKQ2, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetLAKQ3, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetLAKQ4, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetLAKYr, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetUSDQ1, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetUSDQ2, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetUSDQ3, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetUSDQ4, '0,00.00') }}</td>
                            <td class="text-no-wrap text-right">{{ numeralFormat(item.BudgetUSDYr, '0,00.00') }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-col>
            </v-row>
        </v-card>

        <v-card v-else height="50" class="d-flex justify-content-center align-items-center pa-3 mt-3">
            <p class="font-weight-bold text-red justify-content-center align-items-center">
                ບໍ່ມີຂໍ້ມູນລາຍງານປະຈຳໄຕມາດຂອງປີ {{ postForm.year }}</p>
        </v-card>

        <v-dialog v-model="updateDialog" width="900" max-width="900">
            <v-card class="pa-3">
                <v-row>
                    <v-col cols md="4">
                        <v-text-field
                            v-model="updateForm.activity"
                            density="compact"
                            variant="outlined"
                            label="ັActivityID"
                            readonly=""
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model="updateForm.category"
                            density="compact"
                            variant="outlined"
                            label="CategoryID"
                            readonly=""
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model="updateForm.bspCategory"
                            density="compact"
                            variant="outlined"
                            label="BSP Category"
                            readonly=""
                        />
                    </v-col>
                    <v-col cols md="12" class="mt-n5">
                        <v-text-field
                            v-model="updateForm.activityName"
                            density="compact"
                            variant="outlined"
                            label="ັActivityName"
                            readonly=""
                        />
                    </v-col>
                </v-row>
                <v-divider class="mt-n1" color="green"/>
                <v-row class="d-inline-flex">
                    <v-col cols md="2" class="text-right d-flex justify-end align-items-center">
                        <p class="justify-content-center align-items-center">Quarter I</p>
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.kq1"
                            v-number="updateForm.kq1"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calKipFunction('dq1', 'kq1', 'rate1')"
                        />
                    </v-col>
                    <v-col cols md="2">
                        <v-text-field
                            v-model.lazy="updateForm.rate1"
                            v-number="updateForm.rate1"
                            density="compact"
                            variant="outlined"
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.dq1"
                            v-number="updateForm.dq1"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calUsdFunction('kq1','dq1', 'rate1')"
                        />
                    </v-col>
                </v-row>
                <v-row class="d-inline-flex mt-n5">
                    <v-col cols md="2" class="text-right d-flex justify-end align-items-center">
                        <p class="justify-content-center align-items-center">Quarter II</p>
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.kq2"
                            v-number="updateForm.kq2"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calKipFunction('dq2','kq2','rate2')"
                        />
                    </v-col>
                    <v-col cols md="2">
                        <v-text-field
                            v-model.lazy="updateForm.rate2"
                            v-number="updateForm.rate2"
                            density="compact"
                            variant="outlined"
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.dq2"
                            v-number="updateForm.dq2"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calUsdFunction('kq2','dq2','rate2')"
                        />
                    </v-col>
                </v-row>
                <v-row class="d-inline-flex mt-n5">
                    <v-col cols md="2" class="text-right d-flex justify-end align-items-center">
                        <p class="justify-content-center align-items-center">Quarter III</p>
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.kq3"
                            v-number="updateForm.kq3"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calKipFunction('dq3','kq3','rate3')"
                        />
                    </v-col>
                    <v-col cols md="2">
                        <v-text-field
                            v-model.lazy="updateForm.rate3"
                            v-number="updateForm.rate3"
                            density="compact"
                            variant="outlined"
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.dq3"
                            v-number="updateForm.dq3"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calUsdFunction('kq3','dq3','rate3')"
                        />
                    </v-col>
                </v-row>
                <v-row class="d-inline-flex mt-n5">
                    <v-col cols md="2" class="text-right d-flex justify-end align-items-center">
                        <p class="justify-content-center align-items-center">Quarter IV</p>
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.kq4"
                            v-number="updateForm.kq4"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calKipFunction('dq4','kq4','rate4')"
                        />
                    </v-col>
                    <v-col cols md="2">
                        <v-text-field
                            v-model.lazy="updateForm.rate4"
                            v-number="updateForm.rate4"
                            density="compact"
                            variant="outlined"
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.dq4"
                            v-number="updateForm.dq4"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calUsdFunction('kq4','dq4','rate4')"
                        />
                    </v-col>
                </v-row>
                <v-row class="d-inline-flex mt-n5">
                    <v-col cols md="2" class="text-right d-flex justify-end align-items-center">
                        <p class="justify-content-center align-items-center">Total</p>
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.kqyr"
                            v-number="updateForm.kqyr"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calKipFunction('dqyr','kqyr','totalRate')"
                        />
                    </v-col>
                    <v-col cols md="2">
                        <v-text-field
                            v-model.lazy="updateForm.totalRate"
                            v-number="updateForm.totalRate"
                            density="compact"
                            variant="outlined"
                            @update:model-value="updateGrantRate"
                        />
                    </v-col>
                    <v-col cols md="4">
                        <v-text-field
                            v-model.lazy="updateForm.dqyr"
                            v-number="updateForm.dqyr"
                            density="compact"
                            variant="outlined"
                            @update:model-value="calUsdFunction('kqyr','dqyr','totalRate')"
                        />
                    </v-col>
                </v-row>
                <v-divider class="mt-n1" color="green"/>
                <v-row>
                    <v-col cols md="12" class="d-inline-flex justify-center align-content-center">
                        <v-btn-group density="compact" style="width: 100%">
                            <v-btn
                                width="50%"
                                max-width="50%"
                                color="blue"
                                prepend-icon="mdi-content-save"
                                @click="updateQuarterData">ບັນທຶກ
                            </v-btn>
                            <v-btn
                                width="50%"
                                max-width="50%"
                                color="red"
                                prepend-icon="mdi-close"
                                @click="updateDialog = !updateDialog">ຍົກເລີກ
                            </v-btn>
                        </v-btn-group>
                    </v-col>
                </v-row>
            </v-card>
        </v-dialog>
    </div>
</template>

<script>
import {swalErrorToast, swalSuccessToast, swalWarningToast} from "../mixin/swalhelper";

export default {
    data() {
        return {
            levels: [],
            reportList: [],
            levelDisplay: (item) => `${item.LevelID} - ${item.LevelNameL}`,
            provinces: [],
            displayProvince: (item) => `${item.ProvinceID} - ${item.ProvinceNameL}`,
            districts: [],
            displayDistrict: (item) => `${item.DistrictID} - ${item.DistrictNameL}`,
            villages: [],
            displayVillage: (item) => `${item.VillageID} - ${item.VillageNameL}`,
            userLevel: null,
            postForm: {
                year: new Date().toISOString().substring(0, 4),
                level: null,
                province: null,
                district: null,
                village: null
            },
            updateDialog: false,
            updateForm: {
                level: null,
                province: null,
                district: null,
                village: null,
                year: null,
                activity: null,
                activityName: null,
                category: null,
                bspCategory: null,
                kq1: null,
                kq2: null,
                kq3: null,
                kq4: null,
                kqyr: null,
                rate1: null,
                rate2: null,
                rate3: null,
                rate4: null,
                dq1: null,
                dq2: null,
                dq3: null,
                dq4: null,
                dqyr: null,
                totalK: null,
                totalRate: null,
                totalD: null
            }
        }
    },
    mounted() {
        this.loadingLevels();
        this.loadingProvinces();
    },
    methods: {
        openDialog(item) {
            this.updateDialog = !this.updateDialog;
            this.updateForm.level = this.postForm.level;
            this.updateForm.province = this.postForm.province;
            this.updateForm.district = this.postForm.district;
            this.updateForm.village = this.postForm.village;
            this.updateForm.year = this.postForm.year;
            this.updateForm.activity = item.ActivityID;
            this.updateForm.activityName = item.ActivityName;
            this.updateForm.category = item.CategoryID;
            this.updateForm.bspCategory = item.BSPCat_ID;
            this.updateForm.kq1 = item.BudgetLAKQ1;
            this.updateForm.kq2 = item.BudgetLAKQ2;
            this.updateForm.kq3 = item.BudgetLAKQ3;
            this.updateForm.kq4 = item.BudgetLAKQ4;
            this.updateForm.kqyr = item.BudgetLAKYr
            this.updateForm.rate1 = item.BudgetLAKQ1 / item.BudgetUSDQ1;
            this.updateForm.rate2 = item.BudgetLAKQ2 / item.BudgetUSDQ2;
            this.updateForm.rate3 = item.BudgetLAKQ3 / item.BudgetUSDQ3;
            this.updateForm.rate4 = item.BudgetLAKQ4 / item.BudgetUSDQ4;
            this.updateForm.dq1 = item.BudgetUSDQ1;
            this.updateForm.dq2 = item.BudgetUSDQ2;
            this.updateForm.dq3 = item.BudgetUSDQ3;
            this.updateForm.dq4 = item.BudgetUSDQ4;
            this.updateForm.dqyr = item.BudgetUSDYr;
            this.updateForm.totalRate = 1;
        },

        calKipFunction(mainItem, item2, item3) {
            const multiplier = parseInt(this.updateForm[item3].toString().replace(/,/g, '')) === 1 ? parseInt(this.updateForm.totalRate.toString().replace(/,/g, '')) : parseInt(this.updateForm[item3].toString().replace(/,/g, ''));
            this.updateForm[mainItem] = parseInt(this.updateForm[item2].toString().replace(/,/g, '')) / multiplier;
            if (mainItem !== 'dqyr') {
                this.sumFunction('kqyr', 'LAK');
            }
        },

        calUsdFunction(mainItem, item2, item3) {
            const multiplier = parseInt(this.updateForm[item3].toString().replace(/,/g, '')) === 1 ? parseInt(this.updateForm.totalRate.toString().replace(/,/g, '')) : parseInt(this.updateForm[item3].toString().replace(/,/g, ''));
            this.updateForm[mainItem] = parseInt(this.updateForm[item2].toString().replace(/,/g, '')) * multiplier;
            if (mainItem !== 'kqyr') {
                this.sumFunction('dqyr', 'USD');
            }
        },

        sumFunction(item, currency) {
            let count = 1;
            let sum = 0;
            for (let key in this.updateForm) {
                if (currency === 'LAK' && key === `kq${count}`) {
                    sum = sum + parseInt(this.updateForm[key].toString().replace(/,/g, ''));
                    count = count + 1;
                } else if (currency === 'USD' && key === `dq${count}`) {
                    sum = sum + parseInt(this.updateForm[key].toString().replace(/,/g, ''));
                    count = count + 1;
                }
            }
            this.updateForm[item] = sum;
        },

        updateGrantRate() {
            this.updateForm.rate1 = 1;
            this.updateForm.rate2 = 1;
            this.updateForm.rate3 = 1;
            this.updateForm.rate4 = 1;
        },

        async loadDataToShow() {
            const {valid} = await this.$refs.quarter.validate();
            try {
                if (valid) {
                    const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/showData`, this.postForm);
                    this.reportList = [];
                    if (res.data.data !== null || res.data.data !== []) {
                        this.reportList = res.data.data;
                    } else {
                        swalWarningToast('ບໍ່ມີຂໍ້ມູນ!', 'ບໍ່ພົບຂໍ້ມູນການລາຍງານໄຕມາດ');
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມິນລາຍການລາຍງານໄຕມາດໄດ້!')
            }
        },

        async updateQuarterData() {
            const {valid} = await this.$refs.quarter.validate();
            try {
                if (valid) {
                    await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/update/data`, this.updateForm);
                    swalSuccessToast('ສຳເລັດ!', 'ການອັບເດດສຳເລັດ');
                    this.updateDialog = false;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດອັບເດດຂໍ້ມູນໄດ້!');
            }
        },

        async loadingProvinces() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/provinces`);
                if (res.data !== null) {
                    this.provinces = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!')
            }
        },

        async loadingDistrict(id) {
            try {
                let res;
                if (id !== null || id !== undefined) {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/district?provinceId=${id}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/district`);

                }
                if (res.data !== null) {
                    this.districts = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!')
            }
        },

        async loadingVillage(id) {
            try {
                let res;
                if (id !== null || id !== undefined) {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/village?districtId=${id}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/village`);
                }
                if (res.data !== null) {
                    this.villages = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!')
            }
        },

        async loadingLevels(id) {
            try {
                let res;
                if (id !== null || id !== undefined) {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/levels?districtId=${id}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/levels`);
                }
                if (res.data !== null) {
                    this.levels = res.data.levels;
                    this.postForm.level = res.data.selectedLevel;
                    this.userLevel = res.data.selectedLevel;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຂັ້ນຈັດຕັ້ງປະຕິບັດ!')
            }
        },

        async previewAction(currency) {
            const {valid} = await this.$refs.quarter.validate();
            if (valid) {
                await this.previewData(currency);
            }
        },

        async previewData(currency) {
            try {
                let element = document.createElement('form');
                element.method = 'POST';
                element.target = '_blank';
                if (currency === 'LAK') {
                    element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/preview?currency=${currency}`;
                } else {
                    element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/quarter/preview?currency=${currency}`;
                }

                for (let key in this.postForm) {
                    if (this.postForm.hasOwnProperty(key) && this.postForm[key] !== null) {
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = key;
                        input.value = this.postForm[key];
                        element.appendChild(input);
                    }
                }

                let input = document.createElement('input');
                input.type = 'hidden';
                input.name = '_token';
                input.value = document.querySelector('meta[name="csrf-token"]').content;
                element.appendChild(input);

                document.body.appendChild(element);
                element.submit();
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຂັ້ນຈັດຕັ້ງປະຕິບັດ!')
            }
        }
    }
}
</script>

<style scoped>

</style>
