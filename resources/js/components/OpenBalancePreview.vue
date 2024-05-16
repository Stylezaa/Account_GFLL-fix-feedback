<template>
    <div>
        <v-row>
            <v-col cols md="12" class="d-flex justify-content-center">{{
                    formData ? formData['data'][0].Lao1 : ''
                }}
            </v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-content-center">{{
                    formData ? formData['data'][0].Lao2 : ''
                }}
            </v-col>
        </v-row>

        <v-row>
            <v-col cols md="12" class="d-flex justify-content-start">{{
                    formData ? formData['data'][0].Ministry : ''
                }}
            </v-col>
            <v-col cols md="12" class="d-flex mt-n5 justify-content-start">
                {{ formData ? formData['data'][0].Department : '' }}
            </v-col>
            <v-col cols md="12" class=" d-flex mt-n5 justify-content-start">
                {{ formData ? formData['data'][0].Project : '' }}
            </v-col>
            <v-col cols md="6" class=" d-flex mt-n5 justify-content-start">
                {{ formData ? formData['data'][0].Implement : '' }}
            </v-col>
        </v-row>

        <v-row class="mt-3">
            <v-col cols md="12" class="mb-n1 d-flex justify-center align-center">
                <h3 class="font-weight-bold">{{ formData ? formData['data'][0].Header : '' }}</h3>
            </v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-center align-center">
                <h5>{{ formData ? formData['data'][0].sPeriod : '' }}</h5>
            </v-col>
        </v-row>

        <div class="table-responsive">
            <v-table density="compact" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <th rowspan="2" class="text-center" style="width: 90px !important;">
                        {{ formData ? formData['data'][0].LblNo : '' }}
                    </th>
                    <th rowspan="2" class="text-center">{{ formData ? formData['data'][0].LblAccCD : '' }}</th>
                    <th rowspan="2" class="text-center">{{ formData ? formData['data'][0].LblAccNm : '' }}</th>
                    <th colspan="2" class="text-center">{{ formData ? formData['data'][0].LblAmtLAK : '' }}</th>
                    <th colspan="2" class="text-center">{{ formData ? formData['data'][0].LblAmtUSD : '' }}</th>
                </tr>
                <tr>
                    <th class="text-center">{{ formData ? formData['data'][0].LblDebit : '' }}</th>
                    <th class="text-center">{{ formData ? formData['data'][0].LblCredit : '' }}</th>
                    <th class="text-center">{{ formData ? formData['data'][0].LblDebit : '' }}</th>
                    <th class="text-center">{{ formData ? formData['data'][0].LblCredit : '' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="formData !== null" v-for="(item, index) in formData['data']" :key="`openBalance-${index}`">
                    <td style="width: 50px !important;">{{ index + 1 }}</td>
                    <td>{{ item.AccountCD }}</td>
                    <td class="text-nowrap">{{ item.AccountName }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Dr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Cr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Dr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Cr, '0,00.00') }}</td>
                </tr>
                <tr>
                    <td colspan="3" class="text-center">{{ formData ? formData['data'][0].LblTotal : '' }}</td>
                    <td class="text-right">
                        {{ numeralFormat(calLakDr(), '0,00.00') }}
                    </td>
                    <td class="text-right">
                        {{ numeralFormat(calLakCr(), '0,00.00') }}
                    </td>
                    <td class="text-right">
                        {{ numeralFormat(calUsdDr(), '0,00.00') }}
                    </td>
                    <td class="text-right">
                        {{ numeralFormat(calUsdCr(), '0,00.00') }}
                    </td>
                </tr>
                </tbody>
            </v-table>
        </div>

        <v-row>
            <v-col cols md="12" class="mt-5">
                <span class="d-flex justify-end align-end">{{formData ? formData['data'][0].PlaceRPT : ''}}</span>
            </v-col>
        </v-row>

        <v-row class="d-flex">
            <v-col v-if="formData && formData['data'][0].Sign1 !== ''">
                <span>{{formData ? formData['data'][0].Sign1 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign2 !== ''">
                <span>{{formData ? formData['data'][0].Sign2 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign3 !== ''">
                <span>{{formData ? formData['data'][0].Sign3 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign4 !== ''">
                <span>{{formData ? formData['data'][0].Sign4 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign5 !== ''">
                <span>{{formData ? formData['data'][0].Sign5 : ''}}</span>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    props: ['formData'],
    methods:{
        calLakDr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.LAK_Dr > 0) {
                        amount = amount + parseInt(item.LAK_Dr);
                    }
                });
            }
            return amount;
        },
        calLakCr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.LAK_Cr > 0) {
                        amount = amount + parseInt(item.LAK_Cr);
                    }
                });
            }
            return amount;
        },
        calUsdDr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.USD_Dr > 0) {
                        amount = amount + parseInt(item.USD_Dr);
                    }
                });
            }
            return amount;
        },
        calUsdCr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.USD_Cr > 0) {
                        amount = amount + parseInt(item.USD_Cr);
                    }
                });
            }
            return amount;
        },
    }
}
</script>
<style scoped>

</style>
