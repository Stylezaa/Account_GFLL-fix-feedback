<template>
    <div>
        <v-form ref="openForm">
            <v-card class="pt-2 pl-2 pr-2">
                <!--      Level, Province, District, Village      -->
                <v-row>
                    <v-col cols md="3">
                        <v-autocomplete
                            v-model="postForm.level"
                            density="compact"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            :items="levels"
                            :item-title="displayLevel"
                            item-value="LevelID"
                            variant="outlined"
                            :label="$t('level')"
                        />
                    </v-col>

                    <v-col cols md="3">
                        <v-autocomplete
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
                        />
                    </v-col>

                    <v-col cols md="3">
                        <v-autocomplete
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

                    <v-col cols md="3">
                        <v-autocomplete
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

                <!--      Finding with date or accountNo      -->
                <v-row class="mt-n4">

                    <v-col cols md="3">
                        <v-text-field
                            v-model="postForm.searchDate"
                            :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                            density="compact"
                            variant="outlined"
                            label="ປະຈຳເດືອນ"
                            :type="$t('monthly')"
                            format="mm-yyyy"
                        />
                    </v-col>

                    <v-col cols md="3">
                        <v-text-field
                            v-model="postForm.accountNo"
                            density="compact"
                            variant="outlined"
                            :label="$t('accountCode')"
                            clearable=""
                        />
                    </v-col>

                    <v-col cols md="2">
                        <v-btn
                            block=""
                            color="blue"
                            class="remove-rounded"
                            prepend-icon="mdi-magnify"
                            @click="loadDataList">{{ $t('search') }}
                        </v-btn>
                    </v-col>

                    <v-col cols md="2">
                        <v-btn
                            block=""
                            color="red"
                            class="remove-rounded"
                            prepend-icon="mdi-delete" @click="deleteAccount">{{$t('delete')}}
                        </v-btn>
                    </v-col>

                    <v-col cols md="2">
                        <v-btn
                            block=""
                            color="green"
                            class="remove-rounded white--text"
                            prepend-icon="mdi-printer"
                            target="_blank"
                            @click="openBalancePreview">{{$t('preview')}}
                        </v-btn>
                    </v-col>

                </v-row>
            </v-card>
        </v-form>

        <v-card class="mt-2 pl-2 pt-2 pr-2">
            <!--      Table to show info after searching      -->
            <v-row>
                <v-col cols md="12">
                    <div class="table-responsive">
                        <v-table density="compact">
                            <thead>
                            <tr class="text-no-wrap">
                                <th class="text-center text-no-wrap" width="150">ລ/ດ</th>
                                <th class="text-center text-no-wrap" width="450">ວັນທີ່</th>
                                <th class="text-center text-no-wrap">ລະຫັດບັນຊີ</th>
                                <th class="text-center text-no-wrap">ລາຍການບັນຊີ</th>
                                <th class="text-center text-no-wrap">ມູນຄ່າໜີ້ກີບ</th>
                                <th class="text-center text-no-wrap">ມູນຄ່າມີກີບ</th>
                                <th class="text-center text-no-wrap">ມູນຄ່າໜີ້ໂດລ່າ</th>
                                <th class="text-center text-no-wrap">ມູນຄ່າມີໂດລ່າ</th>
                                <th class="text-center text-no-wrap">ວັນທີ່ເຄື່ອນໄຫວ</th>
                                <th class="text-center text-no-wrap">ຜູ້ທີ່ເຄື່ອນໄຫວ</th>
                                <th class="text-center text-no-wrap">ເຄື່ອງທີ່ເຄື່ອນໄຫວ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-if="dataList.data" v-for="(item, index) in dataList.data" :key="`openBal-${index}`">
                                <td class="text-no-wrap">
                                    {{ index + 1 }}
                                </td>
                                <td class="text-no-wrap">{{ $moment(item.OpenDate, 'DD-MM-YYYY') }}</td>
                                <td class="text-no-wrap">{{ item.AccountCD }}</td>
                                <td class="text-no-wrap">{{ item.AccountName }}</td>
                                <td class="text-no-wrap text-right">{{ numeralFormat(item.LAK_Dr, '0,00.00') }}</td>
                                <td class="text-no-wrap text-right">{{ numeralFormat(item.LAK_Cr, '0,00.00') }}</td>
                                <td class="text-no-wrap text-right">{{ numeralFormat(item.USD_Dr, '0,00.00') }}</td>
                                <td class="text-no-wrap text-right">{{ numeralFormat(item.LAK_Cr, '0,00.00') }}</td>
                                <td class="text-no-wrap text-right">{{ $moment(item.LstUpdate, 'DD-MM-YYYY') }}</td>
                                <td class="text-no-wrap">{{ item.LastUser }}</td>
                                <td class="text-no-wrap">{{ item.PcName }}</td>
                            </tr>
                            </tbody>
                        </v-table>
                    </div>
                </v-col>
            </v-row>
        </v-card>

    </div>
</template>

<script>
import {swalErrorToast, swalSuccessToast} from "../mixin/swalhelper";

export default {
    props:{
        locale:{
            type:String,
            required:true,
            default:'en'
        }
    },
    data() {
        return {
            displayLevel: (item) => `${item.LevelID} ${item.LevelNameL} ${item.LevelNameE}`,
            displayProvince: (item) => `${item.ProvinceID} ${item.ProvinceNameL} ${item.ProvinceNameE}`,
            displayDistrict: (item) => `${item.DistrictID} ${item.DistrictNameL} ${item.DistrictNameE}`,
            displayVillage: (item) => `${item.VillageID} ${item.VillageNameL} ${item.VillageNameE}`,
            provinces: [],
            districts: [],
            villages: [],
            userLevel: null,
            levels: [],
            dataList: [],
            postForm: {
                accountNo: null,
                searchDate: new Date().toISOString().substr(0, 7),
                level: null,
                province: null,
                district: null,
                village: null
            }
        }
    },
    mounted() {
        this.loadLevels();
        this.loadingProvince();
        this.loadDistrict();
        this.loadVillage();
    },
    methods: {
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

        async loadLevels() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/levels`);
                if (res.data !== null) {
                    this.levels = res.data.levels;
                    this.userLevel = res.data.selectedLevel;

                    const level = res.data.selectedLevel;
                    if (level === 'P') {
                        this.postForm.province = res.data.selectedProvince;
                    } else if (level === 'D') {
                        this.postForm.province = res.data.selectedProvince;
                        this.postForm.district = res.data.selectedDistrict;
                        await this.loadDistrict();
                    } else if (level === 'V') {
                        this.postForm.province = res.data.selectedProvince;
                        this.postForm.district = res.data.selectedDistrict;
                        this.postForm.village = res.data.selectedVillage;
                        this.postForm.closingLevel = res.data.selectedLevel;
                        await this.loadDistrict();
                        await this.loadLevels();
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນຂັ້ນຈັດຕັ້ງໄດ້!')
            }
        },

        async loadDataList() {
            const {valid} = await this.$refs.openForm.validate();
            try {
                if (valid) {
                    const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/list`, this.postForm);
                    if (res.data !== null) {
                        this.dataList = res.data;
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນລາຍການໄດ້!')
            }
        },

        async deleteAccount() {
            const {valid} = await this.$refs.openForm.validate();
            try {
                if (valid) {
                    const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/delete`, this.postForm);
                    if (res.data.status === 'success') {
                        swalSuccessToast('ສຳເລັດ!', res.data.message);
                    } else {
                        swalErrorToast('ແຈ້ງເຕືອນ!', res.data.message);
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດປິດບັນຊີໄດ້!')
            }
        },

        async openBalancePreview() {
            const {valid} = await this.$refs.openForm.validate();
            try {
                if (valid) {
                    //const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/preview`, this.postForm);
                    let element = document.createElement('form');
                    element.method = 'POST';
                    element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/OpenBalance/preview`;
                    element.target = '_blank';

                    for (let key in this.postForm) {
                        if (this.postForm.hasOwnProperty(key) && this.postForm[key] !== null){
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
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດປິດບັນຊີໄດ້!')
            }
        }
    }
}
</script>

<style scoped>
.remove-rounded {
    border-radius: 0 !important;
}
</style>
