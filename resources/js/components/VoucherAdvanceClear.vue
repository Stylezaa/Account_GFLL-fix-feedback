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
                                        <v-col cols="12" md="2" class="d-flex mt-1">
                                            <v-btn-group
                                                color="#2196F3"
                                                border
                                                block
                                                rounded>
                                                <v-btn
                                                    width="150"
                                                    color="blue"
                                                    class="white--text"
                                                    :loading="saveLoading"
                                                    type="submit">
                                                    FIND (F8)
                                                </v-btn>
                                            </v-btn-group>
                                        </v-col>
                                        <v-col cols="12" md="3">
                                            <v-text-field
                                                v-model="store.referenceNo"
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                label="Reference No"
                                                variant="outlined"/>
                                        </v-col>

                                        <v-col cols="12" md="3">
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
                                        <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="store.referenceNo"
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                label="Cheque No"
                                                variant="outlined"/>
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
                                                v-model.number="store.amount"
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
                                                v-model="store.rate"
                                                prepend-inner-icon="mdi-trending-up"
                                                density="compact"
                                                variant="outlined"
                                                type="number"
                                                label="Rate"
                                            />
                                        </v-col>
                                    </v-row>
                                </v-col>
                                <v-col cols="12" md="4">
                                            <v-text-field
                                                v-model="store.referenceNo"
                                                prepend-inner-icon="mdi-numeric"
                                                density="compact"
                                                label="AdvanceNo"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model="store.voucherDate"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Act_FDt"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="4" class="mb-n5">
                                            <v-text-field
                                                v-model="store.voucherDate"
                                                prepend-inner-icon="mdi-calendar"
                                                density="compact"
                                                label="Act_TDt"
                                                type="date"
                                                variant="outlined"/>
                                        </v-col>
                                        <v-col cols="12" md="6" class="mb-n5">
                                    <v-text-field
                                        v-model="store.descriptionLao"
                                        prepend-inner-icon="mdi-comment-text-outline"
                                        density="compact"
                                        variant="outlined"
                                        label="Pay_to"
                                    />
                                </v-col>
                                <v-col cols="12" md="6" class="mb-n5">
                                    <v-text-field
                                        v-model="store.descriptionLao"
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
                    <th>Debit</th>
                    <th>Credit</th>
                    <th>Description</th>
                    <th>Amount Dr LAK</th>
                    <th>Amount Cr LAK</th>
                    <th>Rate</th>
                    <th>Amount Dr USD</th>
                    <th>Amount Cr USD</th>
                    <th>Activity</th>
                    <th>Category</th>
                    <th>Donor</th>
                    <th>CostCenter</th>
                    <th>SubCostCenter</th>
                    <th>Count</th>
                    <th>AccountCD</th>
                    <th>PairCode</th>
                    <th>Pair</th>
                    <th>PairType</th>
                    <th>RecCnt</th>
                    <th>DescriptionEng</th>
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
                            :disabled="item.actions === 'credit'"
                            type="number"
                            style="width: 130px"
                            @update:modelValue="updateDebitLaoKip(index)"
                        />
                    </td>
                    <td>
                        <v-text-field
                            v-model.number="item.amountCreditLak"
                            :disabled="item.actions === 'debit'"
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
                            :disabled="item.actions === 'credit'"
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
                            :disabled="item.actions === 'debit'"
                            density="compact"
                            variant="plain"
                            type="number"
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
                        variant="solo"
                        density="compact"
                        disabled=""
                        flat=""
                        label="TOTAL USD DR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalCreditUsd"
                        variant="solo"
                        density="compact"
                        disabled=""
                        flat=""
                        label="TOTAL USD CR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.usdBalance"
                        variant="solo"
                        density="compact"
                        disabled=""
                        flat=""
                        label="USD BALANCE"
                    />
                </v-col>

                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalDebitLak"
                        variant="solo"
                        density="compact"
                        disabled=""
                        flat=""
                        label="TOTAL LAK DR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.totalCreditLak"
                        variant="solo"
                        density="compact"
                        disabled=""
                        flat=""
                        label="TOTAL LAK CR"
                    />
                </v-col>
                <v-col cols="12" md="2" class="d-flex align-center">
                    <v-text-field
                        v-model="store.lakBalance"
                        variant="solo"
                        density="compact"
                        disabled=""
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
                                item-title="AccountNameL"
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
                        <v-col cols="12" md="8" class="mb-n4">
                            <v-text-field
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
                                :items="activity"
                                item-value="ActivityID"
                                item-title="ActivityNameL"
                                return-object
                            />
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
                    <v-row>
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
                    </v-row>

                    <!--        ຜູ້ນຳໃຊ້ທຶນລາຍຍ່ອຍ (SubCostCenter)       -->

                    <v-row>
                        <v-col cols="12" md="4" class="mb-n4">
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
                        </v-col>
                        <v-col cols="12" md="12" class="mb-n4">
                            <v-row>
                                <v-col cols="12" md="4">
                                    <v-text-field
                                        v-model.number="store.amount"
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
                                        v-model="store.rate"
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

export default {
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
            fallbackData: ''
        }
    },

    mounted() {
        this.loadingAccounts();
        this.loadActivities();
        this.loadCostCenters();
        this.loadSubCostCenters();
        this.loadDonors();
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
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບັນຊີ!')
            }
        },

        async loadActivities() {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/Activity/activities`);
                console.log('active activity' , res)
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

        async loadDistrict(provinceId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/districts?provinceId=${provinceId}`);
                if (res.data !== null) {
                    this.districts = res.data;
                }
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເມືອງໄດ້!')
            }
        },

        async loadVillage(districtId) {
            try {
                const res = await axios.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/villages?districtId=${districtId}`);
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
                if (res.data !== null) {
                    this.levels = res.data;
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
                    if (this.accountParing.length > 0 && this.store.lakBalance === 0 && this.store.usdBalance === 0) {
                        this.saveLoading = true;
                        await axios.post(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/store`, {
                            voucher: this.store,
                            detail: this.accountParing
                        }).then((res) => {
                            if (res.status === 200 || res.status === 201) {
                                this.saveLoading = false;
                                this.fallbackData = res.data;
                                this.enabledPreview = false;
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
            window.location.href = `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvanceClear`;
            // window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/VoucherAdvance/addva`);
        },

        openDialog(actions) {
            if (actions === 'credit' && this.accountParing.length === 0) {
                swalWarning('ຄຳເຕືອນ!', 'ກາລຸນາເລືອກບັນຊີໜີ້ກ່ອນ!')
            } else {
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
            this.accountParing[index].rate = this.accountParing[index].amountDebitLak / this.accountParing[index].amountDebitUsd;
            this.calTotalCreditUsd()
        },

        updateCreditLaoKip(index) {
            this.accountParing[index].rate = this.accountParing[index].amountCreditLak / this.accountParing[index].amountCreditUsd;
            this.calTotalCreditUsd()
        },

        updateDebitUsd(index) {
            this.accountParing[index].amountDebitLak = this.accountParing[index].amountDebitUsd * this.accountParing[index].rate;
            this.calTotalCreditUsd()
        },

        updateCreditUsd(index) {
            this.accountParing[index].amountCreditLak = this.accountParing[index].amountCreditUsd * this.accountParing[index].rate;
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
                    this.store.totalDebitLak = this.store.totalDebitLak + this.accountParing[i].amountDebitLak;
                    this.store.totalDebitUsd = this.store.totalDebitUsd + this.accountParing[i].amountDebitUsd;
                } else {
                    this.store.totalCreditLak = this.store.totalCreditLak + this.accountParing[i].amountCreditLak;
                    this.store.totalCreditUsd = this.store.totalCreditUsd + this.accountParing[i].amountCreditUsd;
                }
                this.store.lakBalance = this.store.totalDebitLak - this.store.totalCreditLak;
                this.store.usdBalance = this.store.totalDebitUsd - this.store.totalCreditUsd;
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
            window.open(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/GeneralVoucher/preview?level=${this.store.level}&implementCD=${this.implementCode()}&voucherNo=${this.fallbackData.Vch_AutoNo}`,'_blank')
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
</style>
