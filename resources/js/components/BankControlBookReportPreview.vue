<template>
    <div>
         {{ codeParamRoute }}
        <v-row>
            <v-col cols md="12" class="d-flex justify-content-center">{{ queryReport ? queryReport[0].Lao1 : '' }}
            </v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-content-center">
                {{ queryReport ? queryReport[0].Lao2 : '' }}
            </v-col>
        </v-row>

        <v-row>
            <v-col cols md="12" class="d-flex justify-content-start">{{ queryReport ? queryReport[0].Ministry : '' }}
            </v-col>
            <v-col cols md="12" class="d-flex mt-n5 justify-content-start">
                {{ queryReport ? queryReport[0].Department : '' }}
            </v-col>
            <v-col cols md="12" class="d-flex mt-n5 justify-content-start">
                {{ queryReport ? queryReport[0].Project : '' }}
            </v-col>
            <v-col cols md="6" class=" d-flex mt-n5 justify-content-start">
                {{ queryReport ? queryReport[0].Implement : '' }}
            </v-col>
            <v-col cols md="6" class="d-flex mt-n5 justify-content-end">ເລກທີ່ No_:<p class="text-box">
                {{ queryReport ? queryReport[0].VoucherNo : '' }}</p></v-col>
            <v-col cols md="6" class=" d-flex mt-n10 justify-content-start"></v-col>
            <v-col cols md="6" class="d-flex mt-n10 justify-content-end">ວັນທີ່ Date_:<p class="text-box">
                {{ queryReport ? $moment(queryReport[0].VoucherDt, 'DD-MM-YYYY') : '' }}</p></v-col>
        </v-row>

        <v-row class="mt-3">
            <v-col cols md="12" class="mb-n1 d-flex justify-center align-center">
                <h3 class="font-weight-bold">{{ queryReport ? queryReport[0].Header : 'N/A' }}</h3>
            </v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-center align-center">
                <h5>{{ queryReport ? queryReport[0].sPeriod : 'N/A' }} </h5>
            </v-col>
        </v-row>


        <v-row>
            <v-col cols="6" class="d-flex">
                <p class="pr-2">{{ queryReport ? queryReport[0].lblMainCD : 'N/A' }}</p>
                <p class="pr-2">{{ queryReport ? queryReport[0].AccountCD : 'N/A' }}</p>
                <p>{{ queryReport ? queryReport[0].AccountName : 'N/A' }}</p>
            </v-col>
            <v-col cols="6" class="align-content-end">
                <p class="d-flex justify-end">{{ queryReport ? queryReport[0].Unitamount : 'N/A' }}</p>
            </v-col>
        </v-row>

        <!-- table -->

        <v-table density="compact" class="custom-table">
            <thead>
            <tr>
                <th  colspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblVoucher : 'N/A' }}
                </th>
                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].LblDescript : 'N/A' }}
                </th>
                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblaccnt : 'N/A' }}
                </th>
                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].LblFund : 'N/A' }}
                </th>
                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblActivity : 'N/A' }}
                </th>

                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblCat : 'N/A' }}
                </th>
                <th colspan="3" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblAmtlAK : 'N/A' }}
                </th>
                <th rowspan="2" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblRate : 'N/A' }}
                </th>
                <th colspan="3" class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].LblAmtUSD : 'N/A' }}
                </th>

            </tr>
            <tr>
                <th  class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblVchDt : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblVchNo : 'N/A' }}
                </th>

                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblcodeDr : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblcodeCr : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblBalance : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblcodeDr : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblcodeCr : 'N/A' }}
                </th>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblBalance : 'N/A' }}
                </th>
            </tr>
            <tr>
                <th class="text-center text-nowrap">
                    {{ queryReport ? queryReport[0].lblOpen : 'N/A' }}
                </th>
                <th v-for="(item,index) in 13" class="text-center text-nowrap" :key="`table-`+index">

                </th>

            </tr>
            </thead>
            <tbody>
            <tr v-for="(item,index) in queryReport"  :key="`report-table`+index">
                <td class="text-center text-nowrap">{{ item.VoucherDt}}</td>
                <td class="text-center text-nowrap">{{ item.VoucherNo}}</td>
                <td class=" text-nowrap">{{ item.PairName}}</td>
                <td class="text-center text-nowrap">{{ item.PairCD}}</td>
                <td class="text-center text-nowrap">{{ item.DonorID}}</td>
                <td class="text-center text-nowrap">{{ item.ActivityID}}</td>
                <td class="text-center text-nowrap">{{ item.CategoryID}}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Dr,'0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Cr,'0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.LAK_Balance,'0,00.00')}}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.iRate,'0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Dr,'0,00.00')}}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Cr,'0,00.00')}}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.USD_Balance,'0,00.00')}}</td>
            </tr>
            </tbody>

        </v-table>


        <v-row class="d-flex">
            <v-col v-if="queryReport && queryReport[0].Singnature1 !== ''">
                <span>{{ queryReport ? queryReport[0].Singnature1 : '' }}</span>
                <br/>
                <span
                    v-if="queryReport && queryReport[0].SubSingnature1">{{ queryReport ? queryReport[0].SubSingnature1 : '' }}</span>
            </v-col>
            <v-col v-if="queryReport && queryReport[0].Singnature1 !== ''">
                <span>{{ queryReport ? queryReport[0].Singnature2 : '' }}</span>
                <br/>
                <span
                    v-if="queryReport && queryReport[0].SubSingnature1">{{ queryReport ? queryReport[0].SubSingnature1 : '' }}</span>
            </v-col>
            <v-col v-if="queryReport && queryReport[0].Singnature1 !== ''">
                <span>{{ queryReport ? queryReport[0].Singnature3 : '' }}</span>
                <br/>
                <span
                    v-if="queryReport && queryReport[0].SubSingnature1">{{ queryReport ? queryReport[0].SubSingnature1 : '' }}</span>
            </v-col>
            <v-col v-if="queryReport && queryReport[0].Singnature1 !== ''">
                <span>{{ queryReport ? queryReport[0].Singnature4 : '' }}</span>
                <br/>
                <span
                    v-if="queryReport && queryReport[0].SubSingnature1">{{ queryReport ? queryReport[0].SubSingnature1 : '' }}</span>
            </v-col>
            <v-col v-if="queryReport && queryReport[0].Singnature1 !== ''">
                <span>{{ queryReport ? queryReport[0].Singnature5 : '' }}</span>
                <br/>
                <span
                    v-if="queryReport && queryReport[0].SubSingnature1">{{ queryReport ? queryReport[0].SubSingnature1 : '' }}</span>
            </v-col>
        </v-row>


    </div>
</template>
<script>
export default {
    name: "BankBookReportPreview",
    props: {
        queryReport: []
    },
    computed: {
        codeParamRoute(){
            const query = new URLSearchParams(window.location.search);
            return query.get('code')
        }
    }
}

</script>
<style scoped>

</style>
