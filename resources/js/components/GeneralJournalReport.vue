<template>
    <div>
        <div v-if="formData.data !== null">
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
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lblVchNo : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lblCheque : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lbladvance : ''}}</td>
                        <td class="text-no-wrap text-center" colspan="2">{{formData ? formData.data[0].lblaccnt : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].LblDescript : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].LblFund : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lblActivity : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lblCat : ''}}</td>
                        <td class="text-no-wrap text-center" colspan="2">{{formData ? formData.data[0].lblAmtlAK : ''}}</td>
                        <td class="text-no-wrap text-center" rowspan="2">{{formData ? formData.data[0].lblRate : ''}}</td>
                        <td class="text-no-wrap text-center" colspan="2">{{formData ? formData.data[0].LblAmtUSD : ''}}</td>
                    </tr>
                    <tr>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblcodeDr : ''}}</td>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblCodeCr : ''}}</td>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblcodeDr : ''}}</td>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblCodeCr : ''}}</td>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblcodeDr : ''}}</td>
                        <td class="text-no-wrap text-center">{{formData ? formData.data[0].lblCodeCr : ''}}</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr v-if="formData !== null" v-for="(item, index) in formData['data']" :key="`openBalance-${index}`">
                        <td style="width: 50px !important;">{{ item.VoucherNo }}</td>
                        <td>{{ item.ChequeNo }}</td>
                        <td class="text-nowrap">{{ item.AdvanceNo }}</td>
                        <td class="text-nowrap">{{ item.Code_Dr }}</td>
                        <td class="text-nowrap">{{ item.Code_Cr }}</td>
                        <td class="text-nowrap">{{ item.ItemDescription }}</td>
                        <td class="text-nowrap">{{item.DonorID }}</td>
                        <td class=" text-nowrap">{{ item.ActivityID }}</td>
                        <td class="text-nowrap">{{ item.CategoryID }}</td>
                        <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Dr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                        <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Cr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                        <td class="text-right text-nowrap">{{ numeralFormat(item.iRate, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                        <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Cr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                        <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Cr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
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
                <v-col>
                    <span v-if="formData && formData['data'][0].Sign1 !== ''">{{formData ? formData['data'][0].Sign1 : ''}}</span>
                </v-col>
                <v-col>
                    <span v-if="formData && formData['data'][0].Sign2 !== ''">{{formData ? formData['data'][0].Sign2 : ''}}</span>
                </v-col>
                <v-col>
                    <span v-if="formData && formData['data'][0].Sign3 !== ''">{{formData ? formData['data'][0].Sign3 : ''}}</span>
                </v-col>
                <v-col>
                    <span v-if="formData && formData['data'][0].Sign4 !== ''">{{formData ? formData['data'][0].Sign4 : ''}}</span>
                </v-col>
                <v-col>
                    <span v-if="formData && formData['data'][0].Sign5 !== ''">{{formData ? formData['data'][0].Sign5 : ''}}</span>
                </v-col>
            </v-row>
        </div>
        <div v-else>
            ບໍ່ພົບຂໍ້ມູນທີ່ທ່ານລາຍງານ
        </div>
    </div>
</template>

<script>
    export default {
        props:['formData']
    }
</script>

<style scoped>

</style>
