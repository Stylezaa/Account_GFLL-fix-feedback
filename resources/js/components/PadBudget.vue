<template>
    <div id="PadBudget">
        <v-form ref="formRequest">
            <v-row>
                <v-col cols md="12" class="d-inline-flex">

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
                    <v-text-field v-model="postForm.rate"
                                  v-number="postForm.rate"
                                  label="ອັດຕາແລກປ່ຽນ (ກີບ-ໂດລາ)"
                                  density="compact"
                                  :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                  variant="outlined" style="width: 30%"/>

                </v-col>
            </v-row>
        </v-form>

        <v-row justify="center" no-gutters>
            <v-col cols md="4" class="d-inline-flex">
                <v-btn-group density="compact">
                    <v-btn prepend-icon="mdi-download" color="green" @click="loadPadBudgetData()" :loading="isLoading">ໂອນຂໍ້ມູນ</v-btn>
                    <v-btn :disabled="importPadBudgetData.length === 0" prepend-icon="mdi-content-save" color="blue"
                           @click="savePadBudgetData()">ບັນທືກຂໍ້ມູນ
                    </v-btn>
                    <v-btn prepend-icon="mdi-printer" color="purple" @click="previewBudgetData">ເບິ່ງຂໍ້ມູນ</v-btn>
                </v-btn-group>
            </v-col>
        </v-row>

        <v-row v-if="importPadBudgetData.length > 0">
            <v-col cols md="12">

                <v-table  density="compact">
                    <thead>
                    <tr>
                        <th class="text-center">ລະຫັດກິດຈະກຳ</th>
                        <th class="text-center">ຮ່ວງລາຍຈ່າຍ</th>
                        <th class="text-center">ແຜນ BSP</th>
                        <th class="text-center">ເນື້ອໃນກິດຈະກຳ</th>
                        <th class="text-right">ມູນຄ່າງົບປະມານກີບ</th>
                        <th class="text-center">ອັດຕາ</th>
                        <th class="text-right">ມູນຄ່າງົບປະມານໂດລ້າ</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-for="(item,index) in importPadBudgetData" :key="`report-`+ index">
                        <td>{{ item.ActivityID }}</td>
                        <td>{{ item.CategoryID }}</td>
                        <td>{{ item.BSPCat_ID }}</td>
                        <td>{{ item.ActivityName }}</td>
                        <td class="right-input hover-pointer">
                            <v-text-field
                                v-model.lazy="item.AmountLAK"
                                v-number="item.AmountLAK"
                                density="compact"
                                variant="plain"
                                class="right-input"
                                @update:model-value="updateAmountLAK(index)"
                            />
                        </td>
                        <td class="text-right">
                                                        <v-text-field
                                                            v-model="item.Rate"
                                                            v-number="item.Rate"
                                                            density="compact"
                                                            variant="plain"
                                                            class="right-input"
                                                            @update:model-value="updateAmountRate(index)"
                                                        />

<!--                            {{ numeralFormat(item.Rate, '0,000') }}-->
                        </td>
                        <td class="text-right hover-pointer">
                            <!--                            {{ numeralFormat(item.AmountUSD, '0,000') }}-->
                            <v-text-field
                                v-model="item.AmountUSD"
                                v-number="item.AmountUSD"
                                density="compact"
                                variant="plain"
                                class="right-input"
                                @update:model-value="updateAmountUSD(index)"
                            />
                        </td>
                    </tr>
                    </tbody>
                </v-table>

            </v-col>

        </v-row>
        <v-card v-else class="d-flex justify-center py-6 mt-6">
            <h4 style="color:red;">ບໍ່ພົບຂໍ້ມູນລາຍງານ</h4>
        </v-card>


    </div>
</template>

<script>
import {swalError, swalErrorToast, swalLoading, swalSuccess, swalWarningToast} from "../mixin/swalhelper";
import convertToNumMixin from "../mixin/convertToNumMixin";
import {list} from "postcss";

export default {
    name: 'PadBudget',
    mixins: [convertToNumMixin],
    data() {
        return {
            levels: [],
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
                village: null,
                rate: 0,
            },
            importPadBudgetData: [],
            isLoading: false


        }
    },
    mounted() {
        this.loadingLevels();
        this.loadingProvinces();
        // this.loadPadBudgetData();
    },
    methods: {
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

        async loadPadBudgetData() {
            try {
                if (this.$refs.formRequest.validate) {
                    this.isLoading = true
                    this.postForm.rate = this.convertToNum(this.postForm.rate)
                    const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/pad-budget/data`, this.postForm);
                    this.importPadBudgetData = []
                    if (res.data.data.length > 0) {
                        this.isLoading = false
                        this.importPadBudgetData = res.data.data;
                    } else {
                        this.isLoading = false
                        swalWarningToast('ແຈ້ງເຕືອນ', 'ບໍ່ພົບຂໍ້ມູນ')
                    }

                }
            } catch (e) {
                this.isLoading = false
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນ Budget Data ໄດ້!')
            }
        },

        updateAmountLAK(index) {
            // console.log( this.importPadBudgetData[index])
            this.importPadBudgetData[index].AmountUSD = this.removeThousandSeparator(this.importPadBudgetData[index].AmountLAK) / this.removeThousandSeparator(this.importPadBudgetData[index].Rate)
        },

        updateAmountRate(index) {
            // console.log( this.importPadBudgetData[index])
            this.importPadBudgetData[index].AmountLAK = this.removeThousandSeparator(this.importPadBudgetData[index].AmountUSD) * this.removeThousandSeparator(this.importPadBudgetData[index].Rate)
        },

        updateAmountUSD(index) {
            // console.log( this.importPadBudgetData[index])
            this.importPadBudgetData[index].AmountLAK = this.removeThousandSeparator(this.importPadBudgetData[index].AmountUSD) * this.removeThousandSeparator(this.importPadBudgetData[index].Rate)
        },

        async savePadBudgetData() {
            try {
                swalLoading('ກຳລັງບັນທືກຂໍ້ມູນ','ກະລຸນາລໍຖ້າ ຈະປິດລົງພາຍໃນ','info')
                let formattedData = this.importPadBudgetData.map(item => {
                    return {
                        ...item,
                        AmountLAK: this.removeThousandSeparator(item.AmountLAK),
                        Rate: this.removeThousandSeparator(item.Rate),
                        AmountUSD: this.removeThousandSeparator(item.AmountUSD),
                    };
                });
                const payload = {
                    data: formattedData,
                    postRequest: this.postForm
                }
                const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/pad-budget/save`, payload);
                if(res.data.isSuccess){
                    swalSuccess('ບັນທືກຂໍ້ມູນສຳເລັດ','')
                }else{
                    swalError('ຜິດພາດ!', res.data.error)
                }
            } catch (e) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນ Budget Data ໄດ້!')
            }
        },
        previewBudgetData(){
            let element = document.createElement('form');
            element.method = 'POST';
            element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/pad-budget/preview`;
            element.target = '_blank';


            const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
            let formInput = document.createElement('input');
            formInput.type = "hidden";
            formInput.name = "_token";
            formInput.value = csrfToken;
            element.appendChild(formInput);
            document.body.appendChild(element);

            let formDataRequest = document.createElement('input');
            formDataRequest.type = "hidden";
            formDataRequest.name = "formData";
            formDataRequest.value = JSON.stringify(this.formData);
            element.appendChild(formDataRequest);
            document.body.appendChild(element);

            element.submit();
        }
    }
}
</script>

<style scoped>

.hover-pointer {
    cursor: pointer;
}

/deep/ .right-input input {
    text-align: right
}
</style>
