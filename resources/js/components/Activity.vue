<script>
import {swalErrorToast} from "../mixin/swalhelper";

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
            activityGroups: [],
            categories: [],
            accounts: [],
            bspCategory: [],
            levels: [],
            provinces: [],
            districts: [],
            villages: [],
            userLevel: null,
            store: {
                activityId:null,
                activityGroup:null,
                category:null,
                account:null,
                bspCategory:null,
                nameLao:null,
                nameEnglish:null,
                level: null,
                provinceId: null,
                districtId: null,
                villageId: null
            },
            displayAccount: (x) => x.AccountCD + " " + this.$i18n.locale === 'en' ? x.AccountNameE : x.AccountNameL
        }
    },
    mounted() {
        this.$i18n.locale = this.locale;
        this.$forceUpdate();
        this.loadingAccounts();
        this.loadLevels();
        this.loadProvince()
    },
    methods: {
        async loadingAccounts() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/accounts`);
                if (res.data) {
                    this.accounts = res.data;
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນຊີ!')
            }
        },

        async loadProvince() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/provinces`);
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
                const provinceId = this.store.provinceId;
                if (provinceId !== null) {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/districts?provinceId=${provinceId}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/districts`);
                }
                if (res.data !== null) {
                    this.districts = res.data;
                }
                await this.loadVillage();
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເມືອງໄດ້!')
            }
        },

        async loadVillage() {
            try {
                let res;
                if (this.store.districtId !== null) {
                    const districtId = this.store.districtId;
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/villages?districtId=${districtId}`);
                } else {
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/villages`);
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
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/BankVoucher/levels`);
                if (res.data !== null) {
                    this.levels = res.data.levels;
                    this.store.level = res.data.selectedLevel;
                    this.userLevel = res.data.selectedLevel;

                    const level = res.data.selectedLevel;
                    if (level === 'P') {
                        this.store.provinceId = res.data.selectedProvince;
                    } else if (level === 'D') {
                        this.store.provinceId = res.data.selectedProvince;
                        this.store.districtId = res.data.selectedDistrict;
                    } else if (level === 'V') {
                        this.store.provinceId = res.data.selectedProvince;
                        this.store.districtId = res.data.selectedDistrict;
                        this.store.villageId = res.data.selectedVillage;
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນຂັ້ນຈັດຕັ້ງໄດ້!')
            }
        },
    }
}
</script>

<template>
    <div>
        <v-card class="pa-3">
            <v-row>

                <v-col cols md="2">
                    <v-text-field
                        v-model="store.activityId"
                        variant="outlined"
                        density="compact"
                        label="ActivityID"
                        prepend-inner-icon="mdi-format-color-text"
                    />
                </v-col>
                <v-col cols md="10">
                    <v-autocomplete
                        v-model="store.activityGroup"
                        variant="outlined"
                        density="compact"
                        label="ActivityGroup"
                        prepend-inner-icon="mdi-group"
                    />
                </v-col>


                <v-col cols md="4" class="mt-n5">
                    <v-autocomplete
                        v-model="store.category"
                        variant="outlined"
                        density="compact"
                        label="Category"
                        prepend-inner-icon="mdi-package-variant"
                    />
                </v-col>
                <v-col cols md="4" class="mt-n5">
                    <v-autocomplete
                        v-model="store.account"
                        variant="outlined"
                        density="compact"
                        label="Account"
                        prepend-inner-icon="mdi-book"
                        :items="accounts"
                        item-value="AccountCD"
                        :item-title="displayAccount"
                    />
                </v-col>
                <v-col cols md="4" class="mt-n5">
                    <v-autocomplete
                        v-model="store.bspCategory"
                        variant="outlined"
                        density="compact"
                        label="BSP Category"
                        prepend-inner-icon="mdi-book-variant"
                    />
                </v-col>

                <v-col cols md="6" class="mt-n5">
                    <v-text-field
                        v-model="store.nameLao"
                        variant="outlined"
                        density="compact"
                        label="Lao name"
                        prepend-inner-icon="mdi-alphabetical"
                    />
                </v-col>
                <v-col cols md="6" class="mt-n5">
                    <v-text-field
                        v-model="store.nameEnglish"
                        variant="outlined"
                        density="compact"
                        label="English name"
                        prepend-inner-icon="mdi-alphabetical"
                    />
                </v-col>

                <v-col cols md="3" class="mt-n5">
                    <v-autocomplete
                        v-model="store.level"
                        variant="outlined"
                        density="compact"
                        label="Levels"
                        prepend-inner-icon="mdi-security"
                        :items="levels"
                        item-value="LevelID"
                        :item-title="$i18n.locale === 'en' ? `LevelNameE` : `LevelNameL`"
                    />
                </v-col>
                <v-col cols md="3" class="mt-n5">
                    <v-autocomplete
                        v-model="store.provinceId"
                        variant="outlined"
                        density="compact"
                        label="Province"
                        prepend-inner-icon="mdi-home"
                        :items="provinces"
                        item-value="ProvinceID"
                        :item-title="$i18n.locale === 'en' ? `ProvinceNameE` : `ProvinceNameL`"
                        @update:model-value="loadDistrict"
                    />
                </v-col>
                <v-col cols md="3" class="mt-n5">
                    <v-autocomplete
                        v-model="store.districtId"
                        variant="outlined"
                        density="compact"
                        label="District"
                        prepend-inner-icon="mdi-source-branch"
                        :items="districts"
                        item-value="DistrictID"
                        :item-title="$i18n.locale === 'en' ? `DistrictNameE` : `DistrictNameL`"
                        @update:model-value="loadVillage"
                    />
                </v-col>
                <v-col cols md="3" class="mt-n5">
                    <v-autocomplete
                        v-model="store.villageId"
                        variant="outlined"
                        density="compact"
                        label="Village"
                        prepend-inner-icon="mdi-source-merge"
                        :items="villages"
                        item-value="VillageID"
                        :item-title="$i18n.locale === 'en' ? `VillageNameE` : `VillageNameL`"
                    />
                </v-col>
            </v-row>
        </v-card>
    </div>
</template>

<style scoped>

</style>
