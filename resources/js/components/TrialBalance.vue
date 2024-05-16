<template>
    <div>
        <v-form ref="trail_form">
            <v-row>
                <!--     Left side       -->
                <v-col cols md="6" lg="6" xl="6">
                    <v-card class="pa-3">
                        <v-row>
                            <v-col cols md="4">
                                <v-card height="100%" class="pa-2 d-flex align-center">
                                    <v-radio-group v-model="formData.reportType" label="ເລືອກການລາຍງານ" class="mt-n6">
                                        <v-radio label="ລາຍງານຈາກເດືອນ" value="month"/>
                                        <v-radio label="ລາຍງານຈາກປີ" value="year" class="mt-n3"/>
                                    </v-radio-group>
                                </v-card>
                            </v-col>

                            <v-col cols md="4">
                                <v-card class="pt-2 pl-2 pr-2">
                                    <v-row>
                                        <v-col cols md="12">
                                            <v-text-field
                                                v-model="formData.startDate"
                                                :rules="formData.reportType === 'month' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                label="ເລີ່ມຈາກເດືອນ"
                                                density="compact"
                                                variant="outlined"
                                                type="month"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.startYear"
                                                :rules="formData.reportType === 'year' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                label="ເລີ່ມຈາກປີ"
                                                density="compact"
                                                variant="outlined"
                                                type="year"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>

                            <v-col cols md="4">
                                <v-card class="pt-2 pl-2 pr-2">
                                    <v-row>
                                        <v-col cols md="12">
                                            <v-text-field
                                                v-model="formData.endDate"
                                                :rules="formData.reportType === 'month' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                label="ເລີ່ມຈາກເດືອນ"
                                                density="compact"
                                                variant="outlined"
                                                type="month"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.endYear"
                                                :rules="formData.reportType === 'year' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                label="ເລີ່ມຈາກເດືອນ"
                                                density="compact"
                                                variant="outlined"
                                                type="year"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-card>
                            </v-col>

                        </v-row>
                    </v-card>
                    <v-card class="mt-1 d-flex align-center">
                        <v-radio-group v-model="formData.numberFormat" inline="" class="mt-2 mb-n4">
                            <v-radio label="ສະແດງຕົວເລກທົດສະນິຍົມ(1,000)" value="decimal"/>
                            <v-radio label="ສະແດງຕົວເລກເສດ(1,000.00)" value="float"/>
                        </v-radio-group>
                    </v-card>
                    <v-card class="mt-1 d-flex align-center">
                        <v-radio-group v-model="formData.currency" inline="" class="mt-2 mb-n4">
                            <v-radio label="ລາຍງານສະກຸນເງິນກີບ(LAK)" value="LAK"/>
                            <v-radio label="ລາຍງານສະກຸນເງິນໂດລ່າ(USD)" value="USD"/>
                        </v-radio-group>
                    </v-card>
                    <v-card class="mt-1 pa-3 d-flex align-center">
                        <v-autocomplete
                            v-model="formData.multiplier"
                            prepend-inner-icon="mdi-marker-check"
                            :items="multiplies"
                            item-value="value"
                            item-title="text"
                            label="ຈຳນວນຕົວຄູນ x"
                            density="compact"
                            variant="outlined"
                            class="mb-n4"
                        />
                    </v-card>
                    <v-card class="mt-1 pa-3 d-flex justify-center align-center">
                        <span
                            class="mb-2 mt-1 date-label">{{ formData.reportType === 'month' ? formData.startDate : formData.startYear }}</span>
                        &nbsp;
                        <span
                            class="mb-2 mt-1 date-label">{{ formData.reportType === 'month' ? formData.endDate : formData.endYear }}</span>
                    </v-card>
                </v-col>
                <!--     Right side       -->
                <v-col cols md="6" lg="6" xl="6">
                    <v-card height="100%" class="pt-5 pl-2 pr-2">
                        <v-row>
                            <v-col cols md="12">
                                <v-text-field
                                    v-model="formData.title"
                                    prepend-inner-icon="mdi-format-text"
                                    label="ຫົວຂໍ້ລາຍງານ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign1"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    label="ລາຍເຊັນທີ່ 1"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign2"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    label="ລາຍເຊັນທີ່ 2"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign3"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    label="ລາຍເຊັນທີ່ 3"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign4"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    label="ລາຍເຊັນທີ່ 4"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign5"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    label="ລາຍເຊັນທີ່ 5"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.location"
                                    prepend-inner-icon="mdi-map-marker-circle"
                                    label="ສະຖານທີ່ຕັ້ງ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <v-row class="mt-n4 mb-1">
                <!--     Bottom Row 1       -->
                <v-col cols md="12">
                    <v-card class="pa-2">
                        <v-row>
                            <!--<v-col cols md="3" class="mb-n2">
                                <v-checkbox label="ຮັກສາຂໍ້ມູນ"/>
                            </v-col>-->
                            <v-col cols md="12" class="d-flex">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="accountDialog = !accountDialog">ເລືອກບັນຊີ
                                    </v-btn>
                                    <v-btn
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formData.selectedAccounts"
                                    density="compact"
                                    readonly=""
                                    variant="outlined"
                                    class="remove-corner remove-rounded no-border-radius"/>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
                <!--     Bottom Row 2       -->
                <v-col cols md="12" class="mt-n3">
                    <v-card class="pt-3 pl-2 pr-2">
                        <v-row>
                            <v-col cols md="3" class="mb-n2">
                                <v-autocomplete
                                    v-model="formData.level"
                                    prepend-inner-icon="mdi-home-circle"
                                    :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                    :items="levels"
                                    item-value="TypeID"
                                    item-title="TypeName"
                                    label="ເລືອກຂັ້ນຈັດຕັ້ງປະຕິບັດ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="2" class="mb-n2">
                                <v-autocomplete
                                    v-model="formData.province"
                                    prepend-inner-icon="mdi-source-branch"
                                    :readonly="userInfo !== null && ['V','D','P'].some((x) => x === userInfo.level)"
                                    :items="provinces"
                                    item-value="ProvinceID"
                                    item-title="ProvinceNameL"
                                    label="ເລືອກແຂວງ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="2" class="mb-n2">
                                <v-autocomplete
                                    v-model="formData.district"
                                    prepend-inner-icon="mdi-source-branch"
                                    :readonly="userInfo !== null && ['V','D'].some((x) => x === userInfo.level)"
                                    :items="districts"
                                    item-value="DistrictID"
                                    item-title="DistrictNameL"
                                    label="ເລືອກເມືອງ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="2">
                                <v-autocomplete
                                    v-model="formData.village"
                                    prepend-inner-icon="mdi-source-branch"
                                    :readonly="userInfo !== null && ['V'].some((x) => x === userInfo.level)"
                                    :items="villages"
                                    item-value="VillageID"
                                    item-title="VillageNameL"
                                    label="ເລືອກບ້ານ"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="3" class="mb-n2" width="100%">
                                <v-btn block="" class="remove-corner" color="green" @click="previewData"
                                       target="_blank">
                                    <v-icon>mdi-printer</v-icon>
                                    PREVIEW
                                </v-btn>
                            </v-col>
                        </v-row>
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
                                <th style="width: 80px !important;">ເລືອກ</th>
                                <th style="width: 100px !important;">ເລກບັນຊີ</th>
                                <th class="text-nowrap">ຊື່ພາສາລາວ</th>
                                <th class="text-nowrap">ຊື່ພາສາອັງກິດ</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="(item, index) in accounts" :key="`accounts-${index}`"
                                style="height: 25px !important;">
                                <td style="width: 80px !important;">
                                    <v-checkbox
                                        v-model="formData.selectedAccounts[index]"
                                        :value="item.AccountCD"
                                        color="blue"/>
                                </td>
                                <td style="width: 100px !important;">{{ item.AccountCD }}</td>
                                <td class="text-nowrap">{{ item.AccountNameL }}</td>
                                <td>{{ item.AccountNameE }}</td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn>
                            CLOSE
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>
        </v-form>
    </div>
</template>

<script>
import {swalErrorToast} from "../mixin/swalhelper";

export default {
    data() {
        return {
            accountDialog: false,
            multiplies: [
                {
                    value: '1',
                    text: '1'
                }, {
                    value: '10',
                    text: '10'
                }, {
                    value: '100',
                    text: '100'
                }, {
                    value: '1000',
                    text: '1,000'
                }, {
                    value: '10000',
                    text: '10,000'
                }
            ],
            levels: [],
            accounts: [],
            provinces: [],
            districts: [],
            villages: [],
            userInfo: null,
            signature: null,
            formData: {
                selectedAccounts: [],
                reportType: 'month',
                startDate: new Date().toISOString().substring(0, 7),
                endDate: new Date().toISOString().substring(0, 7),
                startYear: new Date().toISOString().substring(0, 4),
                endYear: new Date().toISOString().substring(0, 4),
                title: null,
                reportCode:null,
                uniqueNo: null,
                sign1: null,
                sign2: null,
                sign3: null,
                sign4: null,
                sign5: null,
                location: null,
                numberFormat: 'decimal',
                currency: 'LAK',
                multiplier: 1,
                dateTime: '0000-00-00 00:00:00',
                labelText: 'Label2',
                level: null,
                province: null,
                district: null,
                village: null,
                account: null
            }
        }
    },

    mounted() {
        this.loadSignature();
        this.loadUserInfo();
        this.loadProvince();
        this.loadDistrict();
        this.loadVillage();
        this.loadingAccounts();
        this.loadLevels();
    },
    methods: {
        async loadUserInfo() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/userInfo`);
                if (res.data) {
                    this.userInfo = res.data;
                    //this.formData.level = res.data.level;
                    this.formData.province = res.data.province;
                    this.formData.district = res.data.district;
                    this.formData.village = res.data.village;
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຜູ້ໃຊ້ໄດ້!')
            }
        },

        async loadSignature() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/signature`);
                if (res.data) {
                    this.signature = res.data;
                    this.formData.title = res.data.HeaderL;
                    this.formData.sign1 = res.data.SignatureE1;
                    this.formData.sign2 = res.data.SignatureE2;
                    this.formData.sign3 = res.data.SignatureE3;
                    this.formData.sign4 = res.data.SignatureE4;
                    this.formData.sign5 = res.data.SignatureE5;
                    this.formData.location = res.data.PlaceL;
                    this.formData.reportCode = res.data.ReportID;
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນລາຍເຊັນໄດ້!')
            }
        },

        async loadingAccounts() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/accounts`);
                if (res.data) {
                    this.accounts = res.data;
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນຊີ!')
            }
        },

        async loadProvince() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/provinces`);
                if (res.data !== null) {
                    this.provinces = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!')
            }
        },

        async loadDistrict(provinceId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/districts?provinceId=${provinceId}`);
                if (res.data !== null) {
                    this.districts = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເມືອງໄດ້!')
            }
        },

        async loadVillage(districtId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/villages?districtId=${districtId}`);
                if (res.data !== null) {
                    this.villages = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບ້ານໄດ້!')
            }
        },

        async loadLevels() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/levels`);
                if (res.data !== null) {
                    this.levels = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນຂັ້ນຈັດຕັ້ງໄດ້!')
            }
        },

        async previewData() {
            try {
                const {valid} = await this.$refs.trail_form.validate();
                if (valid) {
                    await this.removeUncheck();
                    await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/clearData`, this.formData).then(() => {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                        let element = document.createElement('form');
                        element.method = 'POST';
                        element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/TrialBalance/preview`;
                        element.target = '_blank';

                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'accounts';
                        input.value = this.formData.selectedAccounts;
                        element.appendChild(input);

                        let formInput = document.createElement('input');
                        formInput.type = "hidden";
                        formInput.name = "_token";
                        formInput.value = csrfToken;
                        element.appendChild(formInput);
                        document.body.appendChild(element);

                        let numberFormat = document.createElement('input');
                        numberFormat.type = "hidden";
                        numberFormat.name = "numFmt";
                        numberFormat.value = this.formData.numberFormat;
                        element.appendChild(numberFormat);
                        document.body.appendChild(element);

                        element.submit();
                    });
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດລາຍງານໃບດຸ່ນດ່ຽງໄດ້!')
            }
        },

        async removeUncheck() {
            this.formData.selectedAccounts.forEach((item, index) => {
                if (item === false || item === undefined) {
                    this.formData.selectedAccounts.splice(index, 1);
                }
            })
        }
    }
}
</script>
<style scoped>
.remove-corner {
    border-radius: 0 !important;
}

.remove-rounded .v-input__control {
    border-radius: 0 !important;
}

.no-border-radius.v-input .v-input__slot {
    border-radius: 0;
}

.date-label {
    display: flex;
    background-color: white;
    color: black;
    border: 1px dashed #000;
    padding-left: 20px;
    padding-right: 20px;
    width: 20%;
    align-items: center;
    justify-content: center;
}
</style>
