<template>
    <div>
        <v-form ref="initForm">
            <v-row>
                <!--     Left side       -->
                <v-col cols md="6" lg="6" xl="6">
                    <v-card class="pa-3">
                        <v-row>
                            <v-col cols md="4">
                                <v-card height="100%" class="pa-2 d-flex align-content-center justify-center">
                                    <v-radio-group v-model="formData.reportType" label="ເລືອກການລາຍງານ">
                                        <v-radio :label="$t('report_ind_date')" value="date"/>
                                        <v-radio :label="$t('report_ind_month')" value="month"/>
                                        <v-radio :label="$t('report_ind_year')" value="year"/>
                                    </v-radio-group>
                                </v-card>
                            </v-col>

                            <v-col cols md="4">
                                <v-card class="pt-2 pl-2 pr-2">
                                    <v-row>
                                        <v-col cols md="12">
                                            <v-text-field
                                                v-model="formData.startDate"
                                                :rules="formData.reportType === 'date' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_from_date')"
                                                density="compact"
                                                variant="outlined"
                                                type="date"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.startMonth"
                                                :rules="formData.reportType === 'month' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_form_month')"
                                                density="compact"
                                                variant="outlined"
                                                type="month"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.startYear"
                                                :rules="formData.reportType === 'year' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_from_year')"
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
                                                :rules="formData.reportType === 'date' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_to_date')"
                                                density="compact"
                                                variant="outlined"
                                                type="date"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.endMonth"
                                                :rules="formData.reportType === 'month' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_to_month')"
                                                density="compact"
                                                variant="outlined"
                                                type="month"
                                            />
                                        </v-col>
                                        <v-col cols md="12" class="mt-n8">
                                            <v-text-field
                                                v-model="formData.endYear"
                                                :rules="formData.reportType === 'year' ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :label="$t('report_ind_to_year')"
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
                            <v-radio :label="$t('display_decimal_point')" value="decimal"/>
                            <v-radio :label="$t('display_float_point')" value="float"/>
                        </v-radio-group>
                    </v-card>
                    <v-card class="mt-1 d-flex align-center">
                        <v-radio-group v-model="formData.currency" inline="" class="mt-2 mb-n4">
                            <v-radio :label="$t('report_ind_rpt_kip')" value="LAK"/>
                            <v-radio :label="$t('report_ind_rpt_usd')" value="USD"/>
                        </v-radio-group>
                    </v-card>
                    <v-card class="mt-1 pa-3 d-flex align-center">
                        <v-row>
                            <v-col cols md="4">
                                <v-checkbox v-model="formData.reportBy" label="ລາຍງານຕາມຊື່ບັນຊີ"/>
                            </v-col>
                            <v-col cols md="8">
                                <v-autocomplete
                                    v-model="formData.multiplier"
                                    prepend-inner-icon="mdi-marker-check"
                                    :items="multiplies"
                                    item-value="value"
                                    item-title="text"
                                    label="ຈຳນວນຕົວຄູນ x"
                                    density="compact"
                                    variant="outlined"
                                    class="mt-2"
                                />
                            </v-col>
                        </v-row>

                    </v-card>
                    <v-card class="mt-1 pa-3 d-flex justify-center align-center">
                        <span class="mb-2 mt-1 date-label">{{
                                formData.reportType === 'date' ?
                                    formData.startDate
                                    : formData.reportType === 'month' ?
                                        formData.startMonth : formData.startYear
                            }}</span>
                        &nbsp;
                        <span class="mb-2 mt-1 date-label">{{
                                formData.reportType === 'date' ?
                                    formData.endDate
                                    : formData.reportType === 'month' ?
                                        formData.endMonth : formData.endYear
                            }}</span>
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
                                    :label="$t('report_ind_title')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign1"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    :label="$t('report_ind_sig1')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign2"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    :label="$t('report_ind_sig2')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign3"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    :label="$t('report_ind_sig3')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign4"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    :label="$t('report_ind_sig4')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.sign5"
                                    prepend-inner-icon="mdi-pencil-box-outline"
                                    :label="$t('report_ind_sig5')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="12" class="mt-n8">
                                <v-text-field
                                    v-model="formData.location"
                                    prepend-inner-icon="mdi-map-marker-circle"
                                    :label="$t('report_ind_locationnpm')"
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
                        <!-- FILED 1 -->
                            <v-col cols md="12" class="d-flex">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="handleOpenDialog('VOUCHER')">
                                        {{ $t('bank_v_voucher_no') }}
                                    </v-btn>
                                    <v-btn
                                        @click="clearSelected('VOUCHER')"
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formattedVouchers"
                                    density="compact"
                                    readonly=""
                                    variant="outlined"
                                    class="remove-corner remove-rounded no-border-radius"/>
                            </v-col>

                            <v-col cols md="12" class="d-flex mt-n7">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="activityDialog = !activityDialog">{{ $t('activity') }}
                                    </v-btn>
                                    <v-btn
                                        @click="clearSelected('ACTIVITY')"
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formattedActivities"
                                    density="compact"
                                    readonly=""
                                    variant="outlined"
                                    class="remove-corner remove-rounded no-border-radius"/>
                            </v-col>

                            <v-col cols md="12" class="d-flex mt-n7">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="categoryDialog = !categoryDialog">{{ $t('category') }}
                                    </v-btn>
                                    <v-btn
                                        @click="clearSelected('CATAGORY')"
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formattedCategories"
                                    density="compact"
                                    readonly=""
                                    variant="outlined"
                                    class="remove-corner remove-rounded no-border-radius"/>
                            </v-col>

                            <v-col cols md="12" class="d-flex mt-n7">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="accountDialog = !accountDialog">{{ $t('account') }}
                                    </v-btn>
                                    <v-btn
                                        @click="clearSelected('ACCOUNT')"
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formattedAccounts"
                                    density="compact"
                                    readonly=""
                                    variant="outlined"
                                    class="remove-corner remove-rounded no-border-radius"/>
                            </v-col>

                            <v-col cols md="12" class="d-flex mt-n7">
                                <v-btn-group density="compact" class="remove-corner">
                                    <v-btn
                                        prepend-icon="mdi-format-list-checks"
                                        width="200"
                                        color="blue"
                                        @click="donorDialog = !donorDialog">{{ $t('donor') }}
                                    </v-btn>
                                    <v-btn
                                        @click="clearSelected('DONOR')"
                                        prepend-icon="mdi-broom"
                                        width="100"
                                        color="danger"
                                        class="text-white">Clear
                                    </v-btn>
                                </v-btn-group>
                                <v-text-field
                                    v-model="formattedDonors"
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
                                    :label="$t('report_ind_type_rpt')"
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
                                    :item-title="$i18n.locale === 'en' ? `ProvinceNameE` : `ProvinceNameL`"
                                    :label="$t('province')"
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
                                    :item-title="$i18n.locale === 'en' ? `DistrictNameE` : `DistrictNameL`"
                                    :label="$t('district')"
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
                                    :item-title="$i18n.locale === 'en' ? `VillageNameE` : `VillageNameL`"
                                    :label="$t('village')"
                                    density="compact"
                                    variant="outlined"
                                />
                            </v-col>
                            <v-col cols md="3" class="mb-n2" width="100%">
                                <v-btn block="" class="remove-corner" color="green" @click="previewData"
                                       target="_blank">
                                    <v-icon>mdi-printer</v-icon>
                                    {{ $t('preview') }}
                                </v-btn>
                            </v-col>
                        </v-row>
                    </v-card>
                </v-col>
            </v-row>

            <!--     Account Dialog       -->
            <v-dialog v-model="accountDialog" height="800" width="1100" scrollable="">
                <v-card>
                    <v-card-title class="d-flex align-center">
                        <div class="font-weight-bold">
                            ຂໍ້ມູນບັນຊີ
                        </div>
                        <v-spacer/>
                        <v-btn
                        elevation="0"
                        size="x-small"
                        icon="mdi-close"
                        color="red"
                        class="float-end"
                        @click="handleCloseDialog(`ACCOUNT`)"
                        />
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
                                    <!-- <v-checkbox
                                        v-model="formData.selectedAccounts[index]"
                                        :value="item.AccountCD"
                                        color="blue"/> -->
                                        <input 
                                            style="width: 20px; height: 20px;"
                                            type="checkbox" :value="item.AccountCD" 
                                            :checked="formData.selectedAccounts.includes(item.AccountCD)"
                                            @change="handleCheckboxChange(item.AccountCD, $event)"
                                        >
                                </td>
                                
                                <td style="width: 100px !important;">{{ item.AccountCD }}</td>
                                <td class="text-nowrap">{{ item.AccountNameL }}</td>
                                <td>{{ item.AccountNameE }}</td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>
                    <v-card-actions>
                    <v-btn @click="handleSaveSelected(`ACCOUNT`)">
                        OPERATE
                    </v-btn>
                    <v-btn @click="handleCloseDialog(`ACCOUNT`)">
                        CLOSE
                    </v-btn>
                </v-card-actions>
                </v-card>
            </v-dialog>

            <!--     Account Dialog       -->
            <v-dialog v-model="voucherDialog" height="800" width="1100">
                <v-card>
                    <v-card-title class="d-flex align-center">
                        <div class="font-weight-bold">
                            ຂໍ້ມູນໃບຢັ້ງຢືນ
                        </div>
                        <v-spacer/>
                        <v-btn
                        elevation="0"
                        size="x-small"
                        icon="mdi-close"
                        color="red"
                        class="float-end"
                        @click="handleCloseDialog(`VOUCHER`)"
                        />
                    </v-card-title>
                    <v-divider color="grey" class="mt-n1"/>
                    <v-card-text>
                        <v-table density="compact" fixed-header class="table table-bordered table-sm">
                            <thead>
                            <tr>
                                <th style="width: 80px !important;">ເລືອກ</th>
                                <th style="width: 100px !important;">ເລກໃບຢັ້ງຢືນ</th>
                                <th class="text-nowrap">ເລກອ້າງອີງ</th>
                                <th class="text-nowrap">ວັນທີ່</th>
                                <th class="text-nowrap">ສະກຸນເງິນ</th>
                                <th class="text-nowrap">ເນື້ອໃນ</th>
                            </tr>
                            </thead>
                            <tbody>
                                <!-- select -->
                            <tr v-for="(item, index) in vouchers" :key="`vouchers-${index}`"
                                style="height: 25px !important;">
                                <td style="width: 80px !important;">
                                    <!-- <v-checkbox
                                        :value="item.Vch_AutoNo"
                                        color="blue"
                                        @change="handleCheckboxChange(item.Vch_AutoNo, $event)"
                                        :checked="formData.selectedVouchers.includes(item.Vch_AutoNo)"
                                    /> -->
                                    <input 
                                     style="width: 20px; height: 20px;"
                                    type="checkbox" :value="item.Vch_AutoNo" 
                                        :checked="formData.selectedVouchers.includes(item.Vch_AutoNo)"
                                        @change="handleCheckboxChange(item.Vch_AutoNo, $event)"
                                        >
                                </td>
                                <td style="width: 100px !important;">{{ item.Vch_AutoNo }}</td>
                                <td class="text-nowrap">{{ item.VoucherNo }}</td>
                                <td class="text-nowrap">{{ item.VoucherDt }}</td>
                                <td>{{ item.Currency }}</td>
                                <td>{{ item.DescriptionL }}</td>
                            </tr>
                            </tbody>
                        </v-table>
                    </v-card-text>
                    <v-card-actions>
                        <v-btn @click="handleSaveSelected(`VOUCHER`)">
                            OPERATE
                        </v-btn>
                        <v-btn @click="handleCloseDialog(`VOUCHER`)">
                            CLOSE
                        </v-btn>
                    </v-card-actions>
                </v-card>
            </v-dialog>


        </v-form>

        <!-- activities dialog -->
        <v-dialog v-model="activityDialog" height="800" width="1100" scrollable="">
            <v-card>
                <v-card-title class="d-flex align-center">
                    <div class="font-weight-bold">
                        ຂໍ້ມູນກິດຈະກຳ
                    </div>
                    <v-spacer/>
                    <v-btn
                        elevation="0"
                        size="x-small"
                        icon="mdi-close"
                        color="red"
                        class="float-end"
                        @click="handleCloseDialog(`ACTIVITY`)"
                        />
                </v-card-title>
                <v-divider color="grey"/>
                <v-card-text>
                    <v-table density="compact" fixed-header class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th style="width: 80px !important;">ເລືອກ</th>
                            <th style="width: 100px !important;">ລະຫັດກິດຈະກຳ</th>
                            <th class="text-nowrap">ຊື່ກິດຈະກຳ(ພາສາລາວ)</th>
                            <th class="text-nowrap">ຊື່ກິດຈະກຳ(ພາສາອັງກິດ)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in activities" :key="`activities-${index}`"
                            style="height: 25px !important;">
                            <td style="width: 80px !important;">
                                <!-- <v-checkbox
                                    v-model="formData.selectedActivities[index]"
                                    :value="item.ActivityID"
                                    color="blue"/> -->
                                    <input 
                                        style="width: 20px; height: 20px;"
                                        type="checkbox" :value="item.ActivityID" 
                                        :checked="formData.selectedActivities.includes(item.ActivityID)"
                                        @change="handleCheckboxChange(item.ActivityID, $event)"
                                    >
                            </td>
                            <td style="width: 100px !important;">{{ item.ActivityID }}</td>
                            <td>{{ item.ActivityNameL }}</td>
                            <td>{{ item.ActivityNameE }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
                <v-card-actions>
                    <v-btn @click="handleSaveSelected(`ACTIVITY`)">
                        OPERATE
                    </v-btn>
                    <v-btn @click="handleCloseDialog(`ACTIVITY`)">
                        CLOSE
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- categoryDialog -->
        <v-dialog v-model="categoryDialog" height="800" width="1100" scrollable="">
            <v-card>
                <v-card-title class="d-flex align-center">
                    <div class="font-weight-bold">
                        ຂໍ້ມູນປະເພດລາຍຈ່າຍ
                    </div>
                    <v-spacer/>
                    <v-btn
                        elevation="0"
                        size="x-small"
                        icon="mdi-close"
                        color="red"
                        class="float-end"
                        @click="handleCloseDialog(`CATEGORY`)"
                        />
                </v-card-title>
                <v-divider color="grey"/>
                <v-card-text>
                    <v-table density="compact" fixed-header class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th style="width: 80px !important;">ເລືອກ</th>
                            <th style="width: 100px !important;">ລະຫັດ</th>
                            <th class="text-nowrap">ຊື່ຫຍໍ້</th>
                            <th class="text-nowrap">ຊື່ຫຍໍ້(ພາສາລາວ)</th>
                            <th class="text-nowrap">ຊື່ຫຍໍ້(ພາສາອັງກິດ)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in categories" :key="`catagories-${index}`"
                            style="height: 25px !important;">
                            <td style="width: 80px !important;">
                                <!-- <v-checkbox
                                    v-model="formData.selectedCategories[index]"
                                    :value="item.CategorySym"
                                    color="blue"/> -->
                                    <input 
                                        style="width: 20px; height: 20px;"
                                        type="checkbox" :value="item.CategorySym" 
                                        :checked="formData.selectedCategories.includes(item.CategorySym)"
                                        @change="handleCheckboxChange(item.CategorySym, $event)"
                                    >
                            </td>
                            <td style="width: 100px !important;">{{ item.CategoryID }}</td>
                            <td>{{ item.CategorySym }}</td>
                            <td>{{ item.CategoryNameL }}</td>
                            <td>{{ item.CategoryNameE }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
                <v-divider/>
                <v-card-actions>
                    <v-btn @click="handleSaveSelected(`CATEGORY`)">
                        OPERATE
                    </v-btn>
                    <v-btn @click="handleCloseDialog(`CATEGORY`)">
                        CLOSE
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- donorDialog -->
        <v-dialog v-model="donorDialog" height="800" width="1100" scrollable="">
            <v-card>
                <v-card-title class="d-flex align-center">
                    <div class="font-weight-bold">
                        ຂໍ້ມູນແຫຼ່ງທຶນ
                    </div>
                    <v-spacer/>
                    <v-btn
                        elevation="0"
                        size="x-small"
                        icon="mdi-close"
                        color="red"
                        class="float-end"
                        @click="handleCloseDialog(`DONOR`)"
                        />
                </v-card-title>
                <v-divider color="grey"/>
                <v-card-text>
                    <v-table density="compact" fixed-header class="table table-bordered table-sm">
                        <thead>
                        <tr>
                            <th style="width: 80px !important;">ເລືອກ</th>
                            <th style="width: 100px !important;">ລະຫັດ</th>
                            <th style="width: 100px !important;">ຊື່ຫຍໍ້</th>
                            <th class="text-nowrap">ຊື່(ພາສາລາວ)</th>
                            <th class="text-nowrap">ຊື່(ພາສາອັງກິດ)</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="(item, index) in donors" :key="`donor-list-${index}`"
                            style="height: 25px !important;">
                            <td style="width: 80px !important;">
                                <!-- <v-checkbox
                                    v-model="formData.selectedDonors[index]"
                                    :value="item.DonorSym"
                                    color="blue"/> -->
                                <input 
                                    style="width: 20px; height: 20px;"
                                    type="checkbox" :value="item.DonorID" 
                                    :checked="formData.selectedDonors.includes(item.DonorID)"
                                    @change="handleCheckboxChange(item.DonorID, $event)"
                                >
                            </td>
                            <td style="width: 100px !important;">{{ item.DonorID }}</td>
                            <td style="width: 100px !important;">{{ item.DonorSym }}</td>
                            <td>{{ item.DonorNameL }}</td>
                            <td>{{ item.DonorNameE }}</td>
                        </tr>
                        </tbody>
                    </v-table>
                </v-card-text>
                <v-divider/>
                <v-card-actions>
                    <v-btn @click="handleSaveSelected(`DONOR`)">
                        OPERATE
                    </v-btn>
                    <v-btn @click="handleCloseDialog(`DONOR`)">
                        CLOSE
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

    </div>
</template>

<script>
import {swalErrorToast} from "../mixin/swalhelper";

export default {
    props: {
        locale: {
            type: String,
            required: true
        }
    },
    data() {
        return {
            accountDialog: false,
            activityDialog: false,
            categoryDialog: false,
            donorDialog: false,
            voucherDialog: false,
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
            vouchers: [],
            categories: [],
            accounts: [],
            donors: [],
            activities: [],
            provinces: [],
            districts: [],
            villages: [],
            userInfo: null,
            signature: null,
            formData: {
                selectedVouchers: [],
                selectedAccounts: [],
                selectedActivities: [],
                selectedCategories: [],
                selectedDonors: [],
                reportType: 'date',
                startDate: new Date().toISOString().substring(0, 10),
                endDate: new Date().toISOString().substring(0, 10),
                startMonth: new Date().toISOString().substring(0, 7),
                endMonth: new Date().toISOString().substring(0, 7),
                startYear: new Date().toISOString().substring(0, 4),
                endYear: new Date().toISOString().substring(0, 4),
                title: null,
                reportCode: null,
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
                account: null,
                reportBy: false
            },
            temporarySelection: [],
            temporaryUnSelection: []
        }
    },

    mounted() {
        this.$i18n.locale = this.locale;
        this.$forceUpdate();

        this.loadVouchers();
        this.loadActivity();
        this.loadCategory();
        this.loadDonor();
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

                console.log('loadProvince', res.data)
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

        async loadVouchers() {
            try {
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/vouchers`).then((res) => {
                    this.vouchers = res.data;
                })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນໃບຢັ້ງຢືນໄດ້!')
            }
        },

        async loadActivity() {
            try {
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Activity/activities`).then((res) => {
                    this.activities = res.data;
                })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນກິດຈະກຳໄດ້!')
            }
        },

        async loadCategory() {
            try {
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/categories/categories`).then((res) => {
                    this.categories = res.data;
                })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຮ່ວງລາຍຈ່າຍໄດ້!')
            }
        },

        async loadDonor() {
            try {
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/donors/donors`).then((res) => {
                    this.donors = res.data;
                })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຜູ້ໃຫ້ທຶນໄດ້!')
            }
        },

        async previewData() {
            const query = new URLSearchParams(window.location.search);
            try {
                const {valid} = await this.$refs.initForm.validate();
                if (valid) {
                    await this.removeUncheck();
                    if (query.get("code") === 'journal') {
                        await this.journalReport();
                    } else if (query.get("code") === "ledger") {
                        await this.ledgerReport();
                    } else if (query.get("code") === "transaction") {
                        // transaction report
                        console.log('transaction report here')
                        await this.transactionGlReport()
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດລາຍງານໃບດຸ່ນດ່ຽງໄດ້!')
            }
        },

        async journalReport() {
            let element = document.createElement('form');
            element.method = 'POST';
            element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/journalReport`;
            element.target = '_blank';

            for (let key in this.formData) {
                if (this.formData.hasOwnProperty(key) && this.formData[key] !== null) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = this.formData[key];
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
        },

        async ledgerReport() {
            let element = document.createElement('form');
            element.method = 'POST';
            element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/ledgerReport`;
            element.target = '_blank';

            for (let key in this.formData) {
                if (this.formData.hasOwnProperty(key) && this.formData[key] !== null) {
                    let input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = key;
                    input.value = this.formData[key];
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
        },


        async transactionGlReport() {
            await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/transaction-gl-report`, this.formData).then(() => {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;

                let element = document.createElement('form');
                element.method = 'POST';
                element.action = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Reports/transaction-gl-report/preview`;
                element.target = '_blank';
                //

                let formInput = document.createElement('input');
                formInput.type = "hidden";
                formInput.name = "_token";
                formInput.value = csrfToken;
                element.appendChild(formInput);
                document.body.appendChild(element);

                let formDataRequest = document.createElement('input');
                formDataRequest.type = "hidden";
                formDataRequest.name = "formDataRequest";
                formDataRequest.value = JSON.stringify(this.formData);
                element.appendChild(formDataRequest);
                document.body.appendChild(element);

                element.submit();
            });
        },

        async removeUncheck() {
            this.formData.selectedAccounts.forEach((item, index) => {
                if (item === false || item === undefined) {
                    this.formData.selectedAccounts.splice(index, 1);
                }
            })
        },

        clearSelected(type) {
            switch (type) {
                case 'VOUCHER' :
                    this.formData.selectedVouchers = []
                    break;
                case 'ACTIVITY' :
                    this.formData.selectedActivities = []
                    break;
                case 'CATAGORY' :
                    this.formData.selectedCategories = []
                    break;
                case 'ACCOUNT' :
                    this.formData.selectedAccounts = []
                    break;
                case 'DONOR' :
                    this.formData.selectedDonors = []
                    break;
            }
        },


        handleCheckboxChange(value, event) {
            if (event.target.checked) {
                // If checkbox is checked, add value to temporarySelection
                this.temporarySelection.push(value);
                // Remove value from temporaryUnSelection if it exists
                const index = this.temporaryUnSelection.indexOf(value);
                if (index !== -1) {
                    this.temporaryUnSelection.splice(index, 1);
                }
            } else {
                // If checkbox is unchecked, remove value from temporarySelection
                const index = this.temporarySelection.indexOf(value);
                if (index !== -1) {
                    this.temporarySelection.splice(index, 1);
                }
                // Add value to temporaryUnSelection
                this.temporaryUnSelection.push(value);
            }
        },

        handleSaveSelected(type) {
            switch (type) {
                case 'VOUCHER' :
                    this.temporarySelection = Array.from(new Set(this.temporarySelection));
                    
                    this.formData.selectedVouchers = this.formData.selectedVouchers.filter(
                        item => !this.temporaryUnSelection.includes(item) 
                    );
                    
                    this.formData.selectedVouchers = [...this.formData.selectedVouchers, ...this.temporarySelection]

                    this.temporarySelection = [];
                    this.temporaryUnSelection = [];

                    this.voucherDialog = false;
                    break;
                case 'ACTIVITY' :
                    this.temporarySelection = Array.from(new Set(this.temporarySelection));
                    
                    this.formData.selectedActivities = this.formData.selectedActivities.filter(
                        item => !this.temporaryUnSelection.includes(item) 
                    );
                    
                    this.formData.selectedActivities = [...this.formData.selectedActivities, ...this.temporarySelection]

                    this.temporarySelection = [];
                    this.temporaryUnSelection = [];

                    this.activityDialog = false;
                    break;
                case 'CATEGORY' :
                    this.temporarySelection = Array.from(new Set(this.temporarySelection));
                    
                    this.formData.selectedCategories = this.formData.selectedCategories.filter(
                        item => !this.temporaryUnSelection.includes(item) 
                    );
                    
                    this.formData.selectedCategories = [...this.formData.selectedCategories, ...this.temporarySelection]

                    this.temporarySelection = [];
                    this.temporaryUnSelection = [];

                    this.categoryDialog = false;
                    break;
                case 'ACCOUNT' :
                    this.temporarySelection = Array.from(new Set(this.temporarySelection));
                    
                    this.formData.selectedAccounts = this.formData.selectedAccounts.filter(
                        item => !this.temporaryUnSelection.includes(item) 
                    );
                    
                    this.formData.selectedAccounts = [...this.formData.selectedAccounts, ...this.temporarySelection]

                    this.temporarySelection = [];
                    this.temporaryUnSelection = [];

                    this.accountDialog = false;
                    break;
                case 'DONOR' :
                    this.temporarySelection = Array.from(new Set(this.temporarySelection));
                    
                    this.formData.selectedDonors = this.formData.selectedDonors.filter(
                        item => !this.temporaryUnSelection.includes(item) 
                    );
                    
                    this.formData.selectedDonors = [...this.formData.selectedDonors, ...this.temporarySelection]

                    this.temporarySelection = [];
                    this.temporaryUnSelection = [];

                    this.donorDialog = false;
                    break;
            }
        },
        // Function to handle dialog close
        handleCloseDialog(type) {
            switch (type) {
                case 'VOUCHER' :
                    this.temporarySelection = [];
                    this.voucherDialog = false;
                    break;
                case 'ACTIVITY' :
                    this.temporarySelection = [];
                    this.activityDialog = false;
                    break;
                case 'CATEGORY' :
                    this.temporarySelection = [];
                    this.categoryDialog = false;
                    break;
                case 'ACCOUNT' :
                    this.temporarySelection = [];
                    this.accountDialog = false;
                    break;
                case 'DONOR' :
                    this.temporarySelection = [];
                    this.donorDialog = false;
                    break;
            }
        },

        handleOpenDialog(type) {
            switch (type) {
                case 'VOUCHER' :
                    this.voucherDialog = true;
                    break;
                case 'ACTIVITY' :
                    this.activityDialog = true;
                    break;
                case 'CATEGORY' :
                    this.categoryDialog = true;
                    break;
                case 'ACCOUNT' :
                    this.accountDialog = true;
                    break;
                case 'DONOR' :
                    this.donorDialog = true;
                    break;
            }
        }

    },
    computed: {


        formattedVouchers() {
            // Filter out boolean values and empty strings, then join selected voucher numbers without commas
            return this.formData.selectedVouchers
                .filter(voucher => typeof voucher === 'string' && voucher !== '')
                .join(',');
        },
        formattedActivities() {
            return this.formData.selectedActivities
                .filter(activity => typeof activity === 'string' && activity !== '')
                .join(',');
        },
        formattedCategories() {
            return this.formData.selectedCategories
                .filter(category => typeof category === 'string' && category !== '')
                .join(',');
        },
        formattedAccounts() {
            return this.formData.selectedAccounts
                .filter(account => typeof account === 'string' && account !== '')
                .join(',');
        },
        formattedDonors() {
            return this.formData.selectedDonors
                .filter(donor => typeof donor === 'string' && donor !== '')
                .join(',');
        }

    },
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
