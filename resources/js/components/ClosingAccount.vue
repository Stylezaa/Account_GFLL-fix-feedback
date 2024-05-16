<template>
    <div>
        <v-card width="600" max-width="600">
            <v-card-title class="d-flex justify-center align-center mb-n4">
                <p class="text-info">CLOSING MONTHLY ACCOUNT</p>
            </v-card-title>
            <v-card-text>
                <v-form ref="closeBalance" @submit.prevent="closingAccount">
                    <v-row>

                        <v-col cols md="12">
                            <v-text-field
                                v-model="postForm.closingDate"
                                density="compact"
                                :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                label="ເລືອກເດືອນ"
                                variant="outlined"
                                type="month"
                                class="text-center"
                            />
                        </v-col>

                        <v-col cols md="12" class="mt-n5">
                            <v-autocomplete
                                v-model="postForm.closingLevel"
                                density="compact"
                                :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                :items="levels"
                                :item-title="levelDisplay"
                                item-value="LevelID"
                                variant="outlined"
                                label="ເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ"
                            />
                        </v-col>

                        <v-col cols md="12" class="mt-n5">
                            <v-autocomplete
                                v-model="postForm.province"
                                density="compact"
                                :readonly="['P','D','V'].some((x) => x === userLevel)"
                                :rules="['P','D','V'].some((x) => x === postForm.closingLevel) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                :items="provinces"
                                item-title="ProvinceNameL"
                                item-value="ProvinceID"
                                variant="outlined"
                                label="ເລືອກແຂວງ"
                                @update:model-value="loadDistrict"
                            />
                        </v-col>

                        <v-col cols md="12" class="mt-n5">
                            <v-autocomplete
                                v-model="postForm.district"
                                :readonly="['D','V'].some((x) => x === userLevel)"
                                :rules="['D','V'].some((x) => x === postForm.closingLevel) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                density="compact"
                                :items="districts"
                                item-title="DistrictNameL"
                                item-value="DistrictID"
                                variant="outlined"
                                label="ເລືອກເມືອງ"
                                @update:model-value="loadVillage"
                            />
                        </v-col>

                        <v-col cols md="12" class="mt-n5">
                            <v-autocomplete
                                v-model="postForm.village"
                                density="compact"
                                :readonly="['V'].some((x) => x === userLevel)"
                                :rules="['V'].some((x) => x === postForm.closingLevel) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                :items="villages"
                                item-title="VillageNameL"
                                item-value="VillageID"
                                variant="outlined"
                                label="ເລືອກບ້ານ"
                            />
                        </v-col>

                        <v-col cols md="12">
                            <v-btn-group class="remove-rounded" style="width: 100%;">
                                <v-btn type="submit" prepend-icon="mdi-checkbox-marked-circle-outline" color="blue"
                                       class="d-inline-flex" style="width: 50% !important;">ປິດບັນຊີ
                                </v-btn>
                                <v-btn prepend-icon="mdi-close-circle-outline" color="red"
                                       class="d-inline-flex text-white" style="width: 50% !important;">ຍົກເລີກ
                                </v-btn>
                            </v-btn-group>
                        </v-col>

                    </v-row>
                </v-form>
            </v-card-text>
        </v-card>
    </div>
</template>

<script>
import {swalError, swalErrorToast, swalSuccess} from "../mixin/swalhelper";

export default {
    data() {
        return {
            levels: [],
            provinces: [],
            districts: [],
            villages: [],
            levelDisplay: (item) => `${item.LevelID} ${item.LevelNameL} ${item.LevelNameE}`,
            userLevel: null,
            postForm: {
                province: null,
                district: null,
                village: null,
                closingDate: new Date().toISOString().substr(0, 10),
                closingLevel: null
            },
        }
    },
    mounted() {
        this.loadLevels();
        this.loadingProvince().then(() => {
            this.loadDistrict();
            this.loadVillage();
        });
    },
    methods: {
        async loadingProvince() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/provinces`);
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
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/districts?provinceId=${this.postForm.province}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/districts`);
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
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/villages?districtId=${this.postForm.district}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/villages`);
                }
                if (res.data !== null) {
                    this.villages = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບ້ານໄດ້!')
            }
        },

        async loadLevels() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/levels`);
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

        async closingAccount(){
            const {valid} = await this.$refs.closeBalance.validate();
            try {
                if (valid){
                    const res = await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/ClosingAccount/closing`,this.postForm);
                    if (res.data.status === 'success'){
                        swalSuccess('ສຳເລັດ!',res.data.message);
                    }else{
                        swalError('ບໍ່ສຳເລັດ!',res.data.message);
                    }
                }
            }catch (error){
                swalError('ຜິດພາດ!','ປິດບັນຊີບໍ່ສຳເລັດ'/*+error.response.data*/);
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
