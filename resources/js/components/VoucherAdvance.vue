<template>
    <div>
        <v-card class="mb-5">
            <v-card-text>
                <v-form @submit.prevent="recordData">
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
                                            />
                                        </v-col>

                                        <v-col v-if="store.paymentType" cols="12" md="6" class="mt-n5">
                                            <v-text-field
                                                v-model="store.chequeNo"
                                                prepend-inner-icon="mdi-receipt"
                                                density="compact"
                                                variant="outlined"
                                                label="Cheque No"
                                            />
                                        </v-col>

                                        <v-col v-if="store.paymentType" cols="12" md="6" class="mt-n5">
                                            <v-text-field
                                                v-model="store.chequeDate"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Cheque Date"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>
                                    </v-row>
                                </v-col>

                                <v-col cols="12" md="12" class="mb-n5">
                                    <v-row>
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model.lazy="store.amount"
                                                v-number="store.amount"
                                                prepend-inner-icon="mdi-plus-box"
                                                density="compact"
                                                variant="outlined"
                                                label="Amount"
                                            />
                                        </v-col>

                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.currency"
                                                prepend-inner-icon="mdi-format-list-checks"
                                                density="compact"
                                                variant="outlined"
                                                label="Currency"
                                                :items="currencies"
                                                item-title="CurrencyNameE"
                                                item-value="CurrencyCD"
                                            />
                                        </v-col>

                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model.lazy="store.rate"
                                                v-number="store.rate"
                                                prepend-inner-icon="mdi-trending-up"
                                                density="compact"
                                                variant="outlined"
                                                label="Rate"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="store.AdvanceNo"
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                label="AdvanceNo"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model="store.Act_FDt"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Act_FDt"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model="store.Act_TDt"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Act_TDt"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="6" class="mb-n5">
                                    <v-text-field
                                        v-model="store.Pay_to"
                                        prepend-inner-icon="mdi-comment-text-outline"
                                        density="compact"
                                        variant="outlined"
                                        label="Pay_to"
                                    />
                                </v-col>
                                <v-col cols="12" md="6" class="mb-n5">
                                    <v-text-field
                                        v-model="store.Pay_to_Address"
                                        prepend-inner-icon="mdi-comment-text-outline"
                                        density="compact"
                                        variant="outlined"
                                        label="Pay_to_Address"
                                    />
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
                        <v-divider vertical="" color="success"/>
                        <v-col cols="12" md="6" lg="6" xl="6">
                            <v-row>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-autocomplete
                                                v-model="store.level"
                                                prepend-inner-icon="mdi-security"
                                                density="compact"
                                                variant="outlined"
                                                label="Level"
                                                :items="levels"
                                                item-title="LevelNameE"
                                                item-value="LevelID"
                                                @update:modelValue="loadDistrict"
                                            />
                                        </v-col>

                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-text-field
                                                v-model="store.voucherDate"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Voucher Date"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>

                                        <v-col cols="12" md="12" class="mb-n5">
                                            <v-text-field
                                                v-model="store.invoiceNo"
                                                prepend-inner-icon="mdi-format-list-bulleted-type"
                                                density="compact"
                                                label="Invoice No"
                                                variant="outlined"/>
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="6">
                                    <v-row>
                                        <v-col cols="12" md="12" class="mb-n5">
                                            {{  store.level }}
                                            <v-autocomplete
                                                v-model="store.province"
                                                :rules="['V','D','P'].some((x)=>x === store.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :readonly="['V','D','P'].some((x) => x === this.store.level)"
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
                                                :rules="['V','D'].some((x)=>x === store.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :readonly="['V','D'].some((x) => x === this.store.level)"
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
                                                :rules="['V'].some((x)=>x === store.level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                                :readonly="this.store.level === 'V'"
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
                                <v-col cols="12" md="3" class="mt-3 align-items-center">
                                    <v-checkbox
                                        v-model="store.used"
                                        label="Used"
                                        style="height: 36px; margin-top: -15px"
                                    />
                                </v-col>
                                <v-col cols="12" md="9" class="d-flex mt-1">
                                    <v-btn-group
                                        color="#2196F3"
                                        border
                                        block
                                        rounded>
                                        <v-btn
                                            width="150"
                                            color="blue"
                                            class="white--text"
                                            prepend-icon="mdi-content-save"
                                            :loading="saveLoading"
                                            type="submit">
                                            SAVE
                                        </v-btn>

                                        <v-btn
                                            width="150"
                                            color="#8BC34A"
                                            class="white--text"
                                            prepend-icon="mdi-printer"
                                            :disabled="enabledPreview"
                                            @click="preview" style="color: white">
                                            PREVIEW
                                        </v-btn>

                                        <v-btn
                                            width="150"
                                            color="red"
                                            class="white--text"
                                            prepend-icon="mdi-broom"
                                            @click="resetFormVal">
                                            CLEAR
                                        </v-btn>
                                    </v-btn-group>
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
                    <th class="text-nowrap">Debit</th>
                    <th class="text-nowrap">Credit</th>
                    <th class="text-nowrap">Description</th>
                    <th class="text-nowrap">Amount Dr LAK</th>
                    <th class="text-nowrap">Amount Cr LAK</th>
                    <th class="text-nowrap">Rate</th>
                    <th class="text-nowrap">Amount Dr USD</th>
                    <th class="text-nowrap">Amount Cr USD</th>
                    <th class="text-nowrap">Activity</th>
                    <th class="text-nowrap">Category</th>
                    <th class="text-nowrap">Donor</th>
                    <th class="text-nowrap">CostCenter</th>
                    <th class="text-nowrap">SubCostCenter</th>
                    <th class="text-nowrap">Count</th>
                    <th class="text-nowrap">AccountCD</th>
                    <th class="text-nowrap">PairCode</th>
                    <th class="text-nowrap">Pair</th>
                    <th class="text-nowrap">PairType</th>
                    <th class="text-nowrap">RecCnt</th>
                    <th class="text-nowrap">DescriptionEng</th>
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
                            v-model="item.descriptionL"
                            density="compact"
                            variant="plain"
                            style="width: 350px"/>
                    </td>
                    <td class="text-right">
                        <v-text-field
                            v-model="item.amountDebitLak"
                            v-number="item.amountDebitLak"
                            class="right-input"
                            density="compact"
                            variant="plain"
                            :disabled="item.actions === 'credit'"
                            style="width: 130px"
                            @update:modelValue="updateDebitLaoKip(index)"
                        />
                    </td>
                    <td class="text-right">
                        <v-text-field
                            v-model="item.amountCreditLak"
                            v-number="item.amountCreditLak"
                            :disabled="item.actions === 'debit'"
                            class="right-input"
                            density="compact"
                            variant="plain"
                            style="width: 130px;"
                            @update:modelValue="updateCreditLaoKip(index)"
                        />
                    </td>
                    <td class="text-right">
                        <v-text-field
                            v-model="item.rate"
                            v-number="item.rate"
                            class="right-input"
                            density="compact"
                            variant="plain"
                            style="width: 100px;"
                        />
                    </td>
                    <td class="text-right">
                        <v-text-field
                            v-model.number="item.amountDebitUsd"
                            v-number="item.amountDebitUsd"
                            :disabled="item.actions === 'credit'"
                            class="right-input"
                            density="compact"
                            variant="plain"
                            style="width: 130px;"
                            @update:modelValue="updateDebitUsd(index)"
                        />
                    </td>
                    <td class="text-right">
                        <v-text-field
                            v-model.number="item.amountCreditUsd"
                            v-number="item.amountCreditUsd"
                            :disabled="item.actions === 'debit'"
                            class="right-input"
                            density="compact"
                            variant="plain"
                            style="width: 130px;"
                            @update:modelValue="updateCreditUsd(index)"
                        />
                    </td>
                    <td><p style="width: 130px;">{{ item.activity ? item.activity.ActivityID : '' }}</p></td>
                    <td style="width: 130px;">{{ item.category ? item.category.CategoryID : '' }}</td>
                    <td style="width: 130px;">{{ item.donor ? item.donor.DonorID : '' }}</td>
                    <td><p style="width: 100px;">{{ item.costCenter ? item.costCenter.CCtrID : '' }}</p></td>
                    <td><p style="width: 100px;">{{ item.subCostCenter ? item.subCostCenter.SCCtrID : '' }}</p></td>
                    <td><p style="width: 100px;">{{ index + 1 }}</p></td>
                    <td style="width: 100px;">{{ item.account ? item.account.AccountCD : '' }}</td>
                    <td style="width: 100px;">{{ item.pairCode }}</td>
                    <td>
                        <v-text-field
                            v-model.number="item.pair"
                            disabled=""
                            variant="plain"
                            density="compact"
                        />
                    </td>
                    <td style="width: 100px;">{{ item.pairType }}</td>
                    <td style="width: 100px;"></td>
                    <td><p style="width: 300px">{{ item.donor.DonorNameE }}</p></td>
                </tr>
                <tr>
                    <td style="width: 100px;"></td>
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
                </tr>
                </tbody>
            </v-table>
        </div>

        <v-card class="sticky-card" flat="">
            <v-row>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalDebitUsd"
                        v-number="store.totalDebitUsd"
                        variant="solo"
                        density="compact"

                        flat=""
                        label="TOTAL USD DR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalCreditUsd"
                        v-number="store.totalCreditUsd"
                        variant="solo"
                        density="compact"
                    readonly=""
                        flat=""
                        label="TOTAL USD CR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.usdBalance"
                        v-number="store.usdBalance"
                        variant="solo"
                        density="compact"
                        readonly=""
                        flat=""
                        label="USD BALANCE"
                    />
                </v-col>

                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalDebitLak"
                        v-number="store.totalDebitLak"
                        variant="solo"
                        density="compact"
                        readonly=""
                        flat=""
                        label="TOTAL LAK DR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalCreditLak"
                        v-number="store.totalCreditLak"
                        variant="solo"
                        density="compact"
                        readonly=""
                        flat=""
                        label="TOTAL LAK CR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.lakBalance"
                        v-number="store.lakBalance"
                        variant="solo"
                        density="compact"
                        readonly=""
                        flat=""
                        label="LAK BALANCE"
                    />
                </v-col>
            </v-row>
        </v-card>
    </div>

    <v-dialog v-model="acctDialog" width="1500">
        <v-form ref="modal_form">
            <v-card>
                <v-card-title class="mb-10">
                    <v-btn
                        density="comfortable"
                        color="primary"
                        icon="mdi-close"
                        position="absolute"
                        @click="acctDialog = !acctDialog"
                        class="z-3"
                    />
                </v-card-title>
                <v-card-text>
                    <v-row>
                        <!--          ບັນຊີ          -->
                        <v-col cols="12" md="4" class="mb-n4">
                            <v-autocomplete
                                v-model="selectAccount"
                                density="compact"
                                label="ເລືອກບັນຊີ"
                                variant="outlined"
                                placeholder="ເລືອກບັນຊີ"
                                :items="accounts"
                                :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                item-value="AccountCD"
                                :item-title="accountItems"
                                :menu-props="{ maxHeight: '200px', maxWidth:'100%'}"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="8" class="mb-n4">
                            <v-text-field
                                :model-value="selectAccount !== null ?selectAccount.AccountNameE : ''"
                                density="compact"
                                label="ຊື່ບັນຊີ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>

                        <!--       ທຶນ         -->

                        <v-col cols="12" md="4" class="mb-n4">
                            <v-autocomplete
                                v-model="selectDonor"
                                :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                auto-select-first
                                density="compact"
                                label="ເລືອກທຶນ"
                                variant="outlined"
                                :items="donors"
                                item-value="DonorID"
                                :item-title="donorItems"
                                :menu-props="{ maxHeight: '200px', maxWidth:'100%'}"
                                return-object
                            />
                        </v-col>
                        <v-col cols="12" md="8" class="mb-n4">
                            <v-text-field
                                :rules="[v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ']"
                                :model-value="selectDonor !== null ? selectDonor.DonorNameE : ''"
                                density="compact"
                                label="ຊື່ທຶນ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                    </v-row>

                    <!--  Activities  -->
                    <v-row>
                        <v-col cols="12" md="4" class="mb-n4">
                            <v-autocomplete
                                v-model="selectActivity"

                                density="compact"
                                label="ກິດຈະກຳ"
                                variant="outlined"
                                eager=""
                                :rules="isPayable ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []"
                                :items="activity"
                                item-value="ActivityID"
                                :item-title="activityItems"
                                :menu-props="{ maxHeight: '200px', maxWidth:'100%'}"
                                return-object
                            >
                            </v-autocomplete>
                        </v-col>
                        <v-col cols="12" :md="selectActivity !== null ? '4' : '8'" class="mb-n4">
                            <v-text-field
                                :model-value="selectActivity != null ? selectActivity.ActivityNameE : ''"
                                density="compact"
                                label="ຊື່ກິດຈະກຳ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                        <v-col cols="12" :md="selectActivity !== null ? '4' : '8'" class="mb-n4">
                            <v-text-field
                                v-if="selectActivity !== null"
                                :model-value="selectActivity !== null ? `${selectActivity.category.CategoryID}-${selectActivity.category.CategoryNameE}`: ''"
                                density="compact"
                                label="ຮ່ວງລາຍຈ່າຍ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                    </v-row>

                    <!--        ຜູ້ນຳໃຊ້ທຶນ (CostCenter)        -->
                    <!-- <v-row>
                        <v-col cols="12" md="4" class="mb-n4">
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
                        <v-col cols="12" md="8" class="mb-n4">
                            <v-text-field
                                :model-value="selectCostCenter !== null ? selectCostCenter.CCtrNameE : ''"
                                density="compact"
                                label="ຜູ້ໃຫ້ທຶນ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col>
                    </v-row> -->
                    <v-row>
                        <v-col cols="12" md="4" class="mb-n4">
                            <v-autocomplete
                                v-model="store.level"
                                prepend-inner-icon="mdi-security"
                                density="compact"
                                variant="outlined"
                                readonly=""
                                label="Level"
                                :items="levels"
                                item-title="LevelNameE"
                                item-value="LevelID"
                            />
                        </v-col>
                        <v-col cols="12" md="3" class="mb-n5">
                            <v-autocomplete
                                v-model="store.province"
                                prepend-inner-icon="mdi-home-outline"
                                :readonly="['V','D','P'].some((x) => x === this.store.level)"
                                readonly=""
                                density="compact"
                                variant="outlined"
                                label="Province"
                                :items="provinces"
                                item-title="ProvinceNameL"
                                item-value="ProvinceID"
                            />
                        </v-col>
                        <v-col cols="12" md="3" class="mb-n5">
                            <v-autocomplete
                                v-model="store.district"
                                prepend-inner-icon="mdi-source-branch"
                                :readonly="['V','D'].some((x) => x === this.store.level)"
                                readonly=""
                                density="compact"
                                variant="outlined"
                                label="District"
                                :items="districts"
                                item-value="DistrictID"
                                item-title="DistrictNameL"
                            />
                        </v-col>
                        <v-col cols="12" md="2" class="mb-n5">
                            <v-autocomplete
                                v-model="store.village"
                                prepend-inner-icon="mdi-source-merge"
                                :readonly="this.store.level === 'V'"
                                density="compact"
                                variant="outlined"
                                label="Village"
                                :items="villages"
                                item-value="VillageID"
                                item-title="VillageNameL"
                            />
                        </v-col>
                    </v-row>
                    <!--        ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ (SubCostCenter)       -->

                    <v-row>
                        <!-- <v-col cols="12" md="4" class="mb-n4">
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
                        <v-col cols="12" md="8" class="mb-n4">
                            <v-text-field
                                :model-value="selectSubCostCenter !== null ? selectSubCostCenter.SCCtrNameE : ''"
                                density="compact"
                                label="ຜູ້ໃຊ້ທຶນຍ່ອຍ"
                                variant="outlined"
                                readonly=""
                            />
                        </v-col> -->
                        <v-col cols="12" md="12" class="mb-n4">
                            <v-row>
                                <v-col cols="12" md="4">
                                    <v-text-field
                                        v-model.lazy="store.amount"
                                        v-number="store.amount"
                                        prepend-inner-icon="mdi-plus-box"
                                        density="compact"
                                        variant="outlined"
                                        label="Amount"
                                    />
                                </v-col>

                                <v-col cols="12" md="4" class="mb-n5">
                                    <v-autocomplete
                                        v-model="store.currency"
                                        prepend-inner-icon="mdi-format-list-checks"
                                        density="compact"
                                        variant="outlined"
                                        label="Currency"
                                        :items="currencies"
                                        item-title="CurrencyNameE"
                                        item-value="CurrencyCD"
                                    />
                                </v-col>

                                <v-col cols="12" md="4" class="mb-n5">
                                    <v-text-field
                                        v-model.lazy="store.rate"
                                        v-number="store.rate"
                                        prepend-inner-icon="mdi-trending-up"
                                        density="compact"
                                        variant="outlined"
                                        label="Rate"
                                        hint="0"
                                    />
                                </v-col>
                            </v-row>
                        </v-col>
                    </v-row>

                    <v-col cols="12" class="d-flex justify-center mt-5 mb-5">
                        <v-btn
                            size="large"
                            prepend-icon="mdi-checkbox-marked-circle-outline"
                            color="blue" @click="pushAccounts">
                            ເພີ່ມລົງໃນລາຍການ
                        </v-btn>
                    </v-col>

                </v-card-text>
            </v-card>
        </v-form>
    </v-dialog>
</template>

<script>
import {swalErrorToast, swalSuccessToast, swalWarning, swalWarningToast} from "../mixin/swalhelper";
import mappingVoucherAdvanceData from "../mixin/mappingVoucherAdvanceData";
import convertToNumMixin from "../mixin/convertToNumMixin";

export default {
    mixins: [mappingVoucherAdvanceData,convertToNumMixin],
    data() {
        return {
            enabledPreview: true,
            isPayable: false,
            saveLoading: false,
            acctDialog: false,
            accounts: [],
            selectAccount: null,
            donors: [],
            selectDonor: null,
            activity: [],
            selectActivity: null,
            categories: [],
            selectCategory: null,
            costCenters: [],
            selectCostCenter: null,
            subCostCenters: [],
            selectSubCostCenter: null,
            currencies: [
                {
                    CurrencyCD: "LAK",
                    CurrencyNameE: "LAK",
                }, {
                    CurrencyCD: "USD",
                    CurrencyNameE: "USD",

                },
            ],
            provinces: [],
            districts: [],
            villages: [],
            accountParing: [],
            levels: [],
            selectLevel: '',
            action: '',
            voucherDateDialog: false,
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
                referenceNo: "",
                paymentType: false,
                chequeNo: "",
                chequeDate: new Date().toISOString().substring(0, 10),
                amount: 0,
                currency: 'LAK',
                rate: 0,
                AdvanceNo:"",
                Act_FDt: new Date().toISOString().substring(0, 10),
                Act_TDt: new Date().toISOString().substring(0, 10),
                Pay_to:"",
                Pay_to_Address:"",
                descriptionLao: "",
                descriptionEng: "",
                voucherDate: new Date().toISOString().substring(0, 10),
                invoiceNo: "",
                province: "",
                district: "",
                village: "",
                used: false,
                level: "",
                totalCreditUsd: 0,
                totalDebitUsd: 0,
                usdBalance: 0,
                totalCreditLak: 0,
                totalDebitLak: 0,
                lakBalance: 0,
            },
            fallbackData: '',
            activityItems: (x)=>x.ActivityID + " "+x.ActivityNameL,
            accountItems: (x)=>x.AccountCD + " " + x.AccountNameL,
            donorItems: (x)=>x.DonorID + " " + x.DonorNameL
        }
    },

    mounted() {
        const query = new URLSearchParams(window.location.search);
        this.loadLevels().then(()=>{
            this.loadDistrict();
        });

        this.loadingAccounts(null);
        this.loadActivities();
        this.loadCostCenters();
        this.loadSubCostCenters();
        this.loadDonors();
        this.loadProvince();
        this.loadLevels();

        console.log('query',query.get('action'))
        console.log('query',query.get('key'))

        if (query.get('action') === 'edit') {
            this.loadSingleData();
        }

    },

    computed: {
        getParaAction(){
            return  new URLSearchParams(window.location.search)
        }
    },
    methods: {
        async loadSingleData() {
            try {
                const query = new URLSearchParams(window.location.search);
                await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/add/data/${query.get('key')}`)
                    .then((res) => {
                        console.log('sing fetch data response', res.data)
                         this.mappingVoucherAdData(res.data);
                    })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເພື່ອແກ້ໄຂໄດ້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!' + error)
            }
        },
        async loadingAccounts(accountType) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/accounts/${accountType}`);
                if (res.data) {
                    this.accounts = res.data;
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນຊີ!')
            }
        },

        async loadActivities() {
            try {
                let res;
                const levelID = this.store.level;
                if (levelID !== null){
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Activity/activities?levelId=${levelID}&implCode=${levelID === 'C' ? '00' : levelID === 'P' ? this.store.province : levelID === 'D' ? this.store.district : this.store.village}`);
                }else{
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Activity/activities`);
                }
                if (res.data !== null) {
                    this.activity = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນກິດຈະກຳໄດ້!')
            }
        },

        async loadCostCenters() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/CostCenter/costCenters`);
                if (res.data !== null) {
                    this.costCenters = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຜູ້ນຳໃຊ້ທຶນໄດ້!')
            }
        },

        async loadDonors() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/donors/donors`);
                if (res.data !== null) {
                    this.donors = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຜູ້ໃຫ້ທຶນໄດ້!')
            }
        },

        async loadSubCostCenters() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/SubCostCenter/subCostCenters`);
                if (res.data !== null) {
                    this.subCostCenters = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນຜູ້ນຳໃຊ້ທຶນຍ່ອຍໄດ້!')
            }
        },

        async loadProvince() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/provinces`);
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
                const provinceId = ['V','D','P'].some((x)=>x === this.store.level) ? this.store.province : null;
                if (provinceId !== null){
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/districts?provinceId=${provinceId}`);
                }else{
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/districts`);
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
                if(['D','V','P'].some((x)=>x === this.store.level)){
                    const districtId = this.store.district;
                     res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/villages?districtId=${districtId}`);
                }else{
                    res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/villages`);
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
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/levels`);
                console.log(res.data);
                if (res.data !== null) {
                    this.levels = res.data.levels;
                    this.store.level = res.data.selectedLevel;
                    const level = res.data.selectedLevel;
                    if (level === 'P') {
                        this.store.province = res.data.selectedProvince;
                    } else if (level === 'D') {
                        this.store.province = res.data.selectedProvince;
                        this.store.district = res.data.selectedDistrict;
                    } else if (level === 'V') {
                        this.store.province = res.data.selectedProvince;
                        this.store.district = res.data.selectedDistrict;
                        this.store.village = res.data.selectedVillage;
                    }
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດໂຫຼດຂໍ້ມູນຂັ້ນຈັດຕັ້ງໄດ້!')
            }
        },

        async recordData() {
            try {
                const checking = this.checkingMtoM();
                if (checking) {
                    swalWarningToast('ບໍ່ອານຸຍາດ!', 'ລະບົບບໍ່ອານຸຍາດໃຫ້ລົງບັນຊີແບບຫຼາຍໜີ້ ແລະ ຫຼາຍມີໄດ້!')
                } else {
                    if (this.accountParing.length > 0 && this.removeThousandSeparator(this.store.lakBalance) === 0 && this.removeThousandSeparator(this.store.usdBalance) === 0) {
                        // this.saveLoading = true;
                        await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/store`, {
                            voucher: this.store,
                            detail: this.accountParing
                        }).then((res) => {
                            if (res.status === 200 || res.status === 201) {
                                this.saveLoading = false;
                                this.fallbackData = res.data;
                                this.enabledPreview = false;
                                this.store.referenceNo = this.fallbackData.VoucherNo
                                swalSuccessToast('ສຳເລັດ!', 'ທ່ານໄດ້ລົງບັນຊີສຳເລັດແລ້ວ!')
                            }
                        });
                        this.saveLoading = false;
                    } else {
                        swalWarningToast('ຜິດພາດ', 'ບັນຊີບໍ່ດຸ່ນ, ກາລຸນາກວດຊອບໃໝ່!')
                    }
                }
            } catch (err) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດບັດທຶກຂໍ້ມູນບັນຊີໄດ້!')
            }
        },

        openAddva() {
            window.location.href = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance`;
            // window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/addva`);
        },

        async openDialog(actions) {

            if (actions === 'credit' && this.accountParing.length === 0) {
                swalWarning('ຄຳເຕືອນ!', 'ກາລຸນາເລືອກບັນຊີໜີ້ກ່ອນ!')
            } else {
                /**
                 * ເລືອກກໍລະນີ້ເປັນໜີ້ ຫລື ມີ ໃຫ້ ສົ່ງ ຄ່າໄປ filter ເອົາປະເພດບັນຊີນີ້ມາ
                 */
                await this.loadingAccounts(actions)
                this.acctDialog = !this.acctDialog;
                this.action = actions;
            }
        },

        async pushAccounts() {
            const { valid } = await this.$refs.modal_form.validate();
            if (valid){
                if (
                    this.selectAccount.AccountCD.startsWith('2') ||
                    this.selectAccount.AccountCD.startsWith('6') ||
                    this.selectDonor === null &&
                    this.selectActivity === null &&
                    this.selectCostCenter === null &&
                    this.selectSubCostCenter === null) {
                    this.pushData();
                } else {
                    this.pushData();
                }
            }

        },

        pushData(){
            const dataToPush = {
                debit: this.selectAccount.AccountCD,
                credit: this.selectAccount.AccountCD,
                descriptionL: this.store.used ? this.store.descriptionLao : this.selectAccount.AccountNameL,
                descriptionE: this.store.used ? this.store.descriptionEng : this.selectAccount.AccountNameE,
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
                category: this.selectActivity.category,
                costCenter: this.selectCostCenter,
                subCostCenter: this.selectSubCostCenter
            };
            this.accountParing.push(dataToPush)
            this.acctDialog = !this.acctDialog;
            this.resetModalVal();
            this.pairMapping();
            this.pairTypeMapping();
            this.calTotalCreditUsd()
        },

        removeAccount(index) {
            if (index + 1 === this.accountParing.length) {
                this.accountParing.splice(index, 1);
                this.pairMapping();
                this.pairTypeMapping();
            } else {
                swalWarningToast('ບໍ່ອານຸຍາດ!', 'ອານຸຍາດໃຫ້ລົບແຕ່ລາຍການສຸດທ້າຍຂື້ນເທິງ!')
            }
        },

        lakDebitAmount(currency, action) {
            if (currency === 'LAK' && action === 'debit') {
                return this.removeThousandSeparator(this.store.amount)
            } else if (currency === 'LAK' && action !== 'debit') {
                return 0;
            } else if (currency !== 'LAK' && action !== 'debit') {
                return 0;
            } else {
                return this.removeThousandSeparator(this.store.amount) * this.removeThousandSeparator(this.store.rate);
            }
        },

        lakCreditAmount(currency, action) {
            if (currency === 'LAK' && action === 'credit') {
                return this.removeThousandSeparator(this.store.amount);
            } else if (currency === 'LAK' && action !== 'credit') {
                return 0;
            } else if (currency !== 'LAK' && action !== 'credit') {
                return 0;
            } else {
                return this.removeThousandSeparator(this.store.amount) * this.removeThousandSeparator(this.store.rate);
            }
        },

        usdCreditAmount(currency, action) {
            if (currency === 'USD' && action === 'credit') {
                return this.removeThousandSeparator(this.store.amount);
            } else if (currency === 'USD' && action !== 'credit') {
                return 0;
            } else if (currency !== 'USD' && action !== 'credit') {
                return 0;
            } else {
                const result = this.removeThousandSeparator(this.store.amount) / this.removeThousandSeparator(this.store.rate)
                return result.toFixed(2) ;
            }
        },

        usdDebitAmount(currency, action) {
            if (currency === 'USD' && action === 'debit') {
                return this.removeThousandSeparator(this.store.amount);
            } else if (currency === 'USD' && action !== 'debit') {
                return 0;
            } else if (currency !== 'USD' && action !== 'debit') {
                return 0;
            } else {
                const result = this.removeThousandSeparator(this.store.amount) / this.removeThousandSeparator(this.store.rate)
                return result.toFixed(2);
            }
        },

        resetModalVal() {
            this.selectDonor = null;
            this.selectAccount = null;
            this.selectActivity = null;
            this.selectCategory = null;
            this.selectCostCenter = null;
            this.selectSubCostCenter = null;
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
            this.accountParing.forEach(item => {
                initPair.push(item.pair)
            })

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

            for (let i = 0; i < this.accountParing.length; i++) {
                workingArrays.forEach(item => {
                    if (this.accountParing[i].pair === item.index) {
                        if (item.debit.length > 1 && item.credit.length > 1) {
                            this.accountParing[i].pairType = 'MM';
                            this.accountParing[i].pairCode = item.credit[0].credit;
                        } else if (item.debit.length > 1 && item.credit.length === 1) {
                            this.accountParing[i].pairType = 'MO';
                            this.accountParing[i].pairCode = item.credit[0].credit;
                        } else if (item.debit.length === 1 && item.credit.length > 1) {
                            this.accountParing[i].pairType = 'OM';
                            this.accountParing[i].pairCode = item.debit[0].debit;
                        } else if (item.debit.length === 1 && item.credit.length === 1) {
                            this.accountParing[i].pairType = 'OO';
                            this.accountParing[i].pairCode = item.credit[0].credit;
                        }
                    }
                })
            }
        },

        filterArrays(array, pairNum, actions) {
            return array.filter(item => item.pair === pairNum && item.actions === actions);
        },

        updateDebitLaoKip(index) {
            this.accountParing[index].rate = this.removeThousandSeparator(this.accountParing[index].amountDebitLak) / this.removeThousandSeparator(this.accountParing[index].amountDebitUsd);
            this.calTotalCreditUsd()
        },

        updateCreditLaoKip(index) {
            this.accountParing[index].rate = this.removeThousandSeparator(this.accountParing[index].amountCreditLak) / this.removeThousandSeparator(this.accountParing[index].amountCreditUsd);
            this.calTotalCreditUsd()
        },

        updateDebitUsd(index) {
            this.accountParing[index].amountDebitLak = this.removeThousandSeparator(this.accountParing[index].amountDebitUsd) * this.removeThousandSeparator(this.accountParing[index].rate);
            this.calTotalCreditUsd()
        },

        updateCreditUsd(index) {
            this.accountParing[index].amountCreditLak = this.removeThousandSeparator(this.accountParing[index].amountCreditUsd) * this.removeThousandSeparator(this.accountParing[index].rate);
            this.calTotalCreditUsd()
        },

        calTotalCreditUsd() {
            this.store.totalCreditUsd = 0;
            this.store.totalCreditLak = 0;
            this.store.totalDebitUsd = 0;
            this.store.totalDebitLak = 0;
            this.store.usdBalance = 0;
            this.store.lakBalance = 0;
            for (let i = 0; i < this.accountParing.length; i++) {
                if (this.accountParing[i].actions === 'debit') {
                    this.store.totalDebitLak = this.removeThousandSeparator(this.store.totalDebitLak) + this.removeThousandSeparator(this.accountParing[i].amountDebitLak);
                    this.store.totalDebitUsd = this.removeThousandSeparator(this.store.totalDebitUsd) + this.removeThousandSeparator(this.accountParing[i].amountDebitUsd);
                } else {
                    this.store.totalCreditLak = this.removeThousandSeparator(this.store.totalCreditLak) + this.removeThousandSeparator(this.accountParing[i].amountCreditLak);
                    this.store.totalCreditUsd = this.removeThousandSeparator(this.store.totalCreditUsd) + this.removeThousandSeparator(this.accountParing[i].amountCreditUsd);
                }
                this.store.lakBalance = this.removeThousandSeparator(this.store.totalDebitLak) - this.removeThousandSeparator(this.store.totalCreditLak);
                this.store.usdBalance = this.removeThousandSeparator(this.store.totalDebitUsd) - this.removeThousandSeparator(this.store.totalCreditUsd);
            }
        },

        checkingMtoM() {
            let isFound = false;
            this.accountParing.forEach(item => {
                if (item.pairType === 'MM') {
                    isFound = true;
                }
            })
            return isFound;
        },

        resetFormVal() {

            if(this.getParaAction.get('action') === 'edit'){
                window.location.href = '/VoucherAdvance/addva?action=more'
            }

            this.enabledPreview = true;
            this.store.referenceNo = "";
            this.store.paymentType = false;
            this.store.chequeNo = "";
            this.store.chequeDate = new Date().toISOString().substring(0, 10);
            this.store.amount = 0;
            this.store.currency = 'LAK';
            this.store.rate = 0;
            this.store.descriptionLao = "";
            this.store.descriptionEng = "";
            this.store.voucherDate = new Date().toISOString().substring(0, 10);
            this.store.invoiceNo = "";
            this.store.province = "";
            this.store.district = "";
            this.store.village = "";
            this.store.used = false;
            this.store.level = "";
            this.store.totalCreditUsd = 0;
            this.store.totalDebitUsd = 0;
            this.store.usdBalance = 0;
            this.store.totalCreditLak = 0;
            this.store.totalDebitLak = 0;
            this.store.lakBalance = 0;
            this.accountParing = [];
            this.resetModalVal();
        },

        preview(){
            window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/preview?level=${this.store.level}&implementCD=${this.implementCode()}&voucherNo=${this.fallbackData.Vch_AutoNo}`,'_blank')
        },

        implementCode(){
            return this.store.level === 'C' ? '00' : this.store.level === 'D' ? this.store.district : this.store.level === 'P' ? this.store.province : this.store.village;
        }
    }
}
</script>

<style>
v-table {
    border: 1px solid #666;
    table-layout: fixed !important;
}

th, td {
    border: 1px solid #666;
    width: 900px !important;
    overflow: hidden;
}

.sticky-card {
    position: sticky;
    height: 50px;
    bottom: 15px;
    width: 100%;
    margin-top: 30%;
}

/* Chrome, Safari, Edge, Opera */
input::-webkit-outer-spin-button,
input::-webkit-inner-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

/* Firefox */
input[type=number] {
    -moz-appearance: textfield;
}


/deep/ .right-input input {
    text-align: right
}
</style>
