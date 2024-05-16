<template>
    <div v-if="formData && formData.data !== null">
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
            <v-col cols md="6" class="d-flex justify-content-start">{{
                    formData ? formData['data'][0].Ministry : ''
                }}
            </v-col>
            <v-col cols md="6" class="d-flex justify-content-end">{{
                    formData ? formData['data'][0].ReportNo : ''
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
            <v-col cols md="6" class="mt-n5 d-flex justify-end align-center">
                <h5>{{ formData ? formData['data'][0].sPeriod : '' }}</h5>
            </v-col>
            <v-col cols md="6" class="mt-n5 d-flex justify-end align-center">
                <h5>{{ formData ? formData['data'][0].Unitamount : '' }}</h5>
            </v-col>
        </v-row>

        <div class="table-responsive">
            <v-table density="compact" class="table table-bordered table-striped">
                <thead>
                <tr>
                    <td class="text-no-wrap text-center" colspan="2">{{ formData ? formData.data[0].lblVoucher : '' }}
                    </td>
                    <td class="text-no-wrap text-center" rowspan="2">
                        {{ formData ? formData.data[0].LblDescript : '' }}
                    </td>
                    <td class="text-no-wrap text-center" rowspan="2">{{ formData ? formData.data[0].lblaccnt : '' }}
                    </td>
                    <td class="text-no-wrap text-center" rowspan="2">{{ formData ? formData.data[0].LblFund : '' }}</td>
                    <td class="text-no-wrap text-center" rowspan="2">
                        {{ formData ? formData.data[0].lblActivity : '' }}
                    </td>
                    <td class="text-no-wrap text-center" rowspan="2">{{ formData ? formData.data[0].lblCat : '' }}</td>
                    <td class="text-no-wrap text-center" colspan="3">{{ formData ? formData.data[0].lblAmtlAK : '' }}
                    </td>
                    <td class="text-no-wrap text-center" rowspan="2">{{ formData ? formData.data[0].lblRate : '' }}</td>
                    <td class="text-no-wrap text-center" colspan="3">{{ formData ? formData.data[0].LblAmtUSD : '' }}
                    </td>
                </tr>
                <tr>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblVchDt : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblVchNo : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblcodeDr : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblCodeCr : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblBalance : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblcodeDr : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblCodeCr : '' }}</td>
                    <td class="text-no-wrap text-center">{{ formData ? formData.data[0].lblBalance : '' }}</td>
                </tr>
                </thead>
                <tbody>
                <tr v-if="formData !== null" v-for="(item, index) in formData['data']" :key="`openBalance-${index}`">
                    <td class="text-nowrap" style="width: 50px !important;">{{ $moment(item.VoucherDt,'DD-MM-YYYY') }}</td>
                    <td>{{ item.VoucherNo }}</td>
                    <td class="text-nowrap">{{ item.PairName }}</td>
                    <td class="text-nowrap">{{ item.PairCD }}</td>
                    <td class=" text-nowrap">{{ item.DonorID }}</td>
                    <td class="text-nowrap">{{ item.ActivityID }}</td>
                    <td class="text-nowrap">{{ item.CategoryID }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Dr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Cr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Balance, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.iRate, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Dr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Cr, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Balance, '0,00.00') }}</td>
                </tr>
                </tbody>
            </v-table>
        </div>

        <v-row>
            <v-col cols md="12" class="mt-5">
                <span class="d-flex justify-end align-end">{{ formData ? formData['data'][0].PlaceRPT : '' }}</span>
            </v-col>
        </v-row>

        <v-row class="d-flex">
            <v-col v-if="formData && formData['data'][0].Sign1 !== ''">
                <span>{{ formData ? formData['data'][0].Sign1 : '' }}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign2 !== ''">
                <span>{{ formData ? formData['data'][0].Sign2 : '' }}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign3 !== ''">
                <span>{{ formData ? formData['data'][0].Sign3 : '' }}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign4 !== ''">
                <span>{{ formData ? formData['data'][0].Sign4 : '' }}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Sign5 !== ''">
                <span>{{ formData ? formData['data'][0].Sign5 : '' }}</span>
            </v-col>
        </v-row>
    </div>
    <div v-else>
        <v-row
            class="flex-column flex-row justify-center justify-content-around align-content-around align-items-center">
            ບໍ່ມີຂໍ້ມູນການລາຍງານ
        </v-row>
    </div>
</template>

<script>
export default {
    props: ['formData']
}
</script>

<style scoped>

</style>
