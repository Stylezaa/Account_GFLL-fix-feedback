<template>
    <div>

        <div v-if="formData.dataReport[0]">
            <v-row>
                <v-col cols md="12" class="d-flex justify-content-center">{{ mapGetFirstIndexData.Lao1 ?? 'N/A' }}</v-col>
                <v-col cols md="12" class="mt-n5 d-flex justify-content-center">
                    {{ mapGetFirstIndexData.Lao2 ?? 'N/A' }}
                </v-col>
            </v-row>

            <v-row>
                <v-col cols md="12" class="d-flex justify-content-start">ກະຊວງ ກະສິກຳ ແລະ ປ່າໄມ້</v-col>
                <v-col cols md="12" class="d-flex mt-n5 justify-content-start">
                    {{ mapGetFirstIndexData.Department ?? 'N/A' }}
                </v-col>
                <v-col cols md="12" class=" d-flex mt-n5 justify-content-start">
                    {{ mapGetFirstIndexData.Project ?? 'N/A' }}
                </v-col>
                <v-col cols md="6" class=" d-flex mt-n5 justify-content-start">
                    {{ mapGetFirstIndexData.Implement ?? 'N/A' }}
                </v-col>
            </v-row>

            <v-row class="mt-3">
                <v-col cols md="12" class="mb-n1 d-flex justify-center align-center">
                    <h3 class="font-weight-bold">ລາຍງານການເຄື່ອນໄຫວ</h3>
                </v-col>
                <v-col cols md="12" class="mt-n5 d-flex justify-center align-center">
                    <h5>{{ mapGetFirstIndexData.sPeriod ?? 'N/A'}} </h5>
                </v-col>
            </v-row>

            <!-- table -->

            <v-table density="compact" class="custom-table">
                <thead>
                <tr>
                    <th colspan="2" class="text-center text-nowrap">
                        ໃບຢັ້ງຢືນ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ເລກແຊັກ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ເລກທີ່ຈ່າຍລ່ວງໜ້າ
                    </th>
                    <th colspan="2" class="text-center text-nowrap">
                        ເລກບັນຊີ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ເນື້ອໃນລາຍການ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ກິດຈະກຳ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ຮ່ວງລາຍຈ່າຍ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ແຫຼ່ງທຶນ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ຜູ້ໃຊ້ທຶນ
                    </th>
                    <th rowspan="2" class="text-center text-nowrap">
                        ຜູ້ນຳໃຊ້ທຶນຍ່ອຍ
                    </th>
                    <th colspan="2" class="text-center text-nowrap">
                        ມູນຄ່າລົງບັນຊີ (ກີບ)
                    </th>

                    <th rowspan="2" class="text-center text-nowrap">
                        ອັດຕາ
                    </th>

                    <th colspan="2" class="text-center text-nowrap">
                        ມູນຄ່າລົງບັນຊີ (ໂດລ້າ)
                    </th>


                </tr>
                <tr>
                    <th class="text-center">ເລກທີ່</th>
                    <th class="text-center text-nowrap">ວັນທີ່</th>
                    <th class="text-center">ໜີ້</th>
                    <th class="text-center text-nowrap">ມີ</th>
                    <th class="text-center">ໜີ້</th>
                    <th class="text-center text-nowrap">ມີ</th>
                    <th class="text-center">ໜີ້</th>
                    <th class="text-center text-nowrap">ມີ</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="formData !== null" v-for="(item,index) in formData.dataReport" :key="`voucher-list-`+index">
                    <td>{{ item.Vch_AutoNo }}</td>
                    <td class="text-nowrap">{{ $moment(item.VoucherDt ,'DD/MM/YYYY')  }}</td>
                    <td class="text-nowrap">{{ item.ChequeNo }}</td>
                    <td class="text-nowrap">{{ item.AdvanceNo }}</td>
                    <td class="text-nowrap">{{ item.Code_Dr ? item.Code_Dr : '-'  }}</td>
                    <td class="text-nowrap">{{ item.Code_Cr ?  item.Code_Cr : '-'}}</td>
                    <td class="text-nowrap">{{ item.ItemDescription }}</td>
                    <td class="text-nowrap">{{ item.ActivityID }}</td>
                    <td class="text-nowrap">{{ item.CategoryID }}</td>
                    <td class="text-nowrap">{{ item.DonorID }}</td>
                    <td class="text-nowrap"> {{ item.CCtrID }}</td>
                    <td class="text-nowrap">{{ item.SCCtrID }}</td>
                    <td class="text-right text-nowrap">{{  numeralFormat(item.LAK_Dr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{  numeralFormat(item.LAK_Cr, formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{  numeralFormat(item.iRate, formData.formatter === 'decimal' ? '0,000' : '0,00.00')  }}</td>
                    <td class="text-right text-nowrap">{{ item.USD_Dr ? numeralFormat(item.USD_Dr , formData.formatter === 'decimal' ? '0,000' : '0,00.00') : '-' }}</td>
                    <td class="text-right text-nowrap">{{ item.USD_Cr ?  numeralFormat(item.USD_Cr, formData.formatter === 'decimal' ? '0,000' : '0,00.00')   :'-' }}</td>
                </tr>
                </tbody>
                <tfoot>
                <tr>
                    <td colspan="7" class="text-center">ມູນຄ່າລວມຍອດ:</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td class="text-right">{{  numeralFormat(sumNumberLoop(formData.dataReport,'LAK_Dr'), formData.formatter === 'decimal' ? '0,000' : '0,00.00')}}</td>
                    <td class="text-right">{{  numeralFormat(sumNumberLoop(formData.dataReport,'LAK_Cr'), formData.formatter === 'decimal' ? '0,000' : '0,00.00') }}</td>
                    <td></td>
                    <td class="text-right">{{ numeralFormat(sumNumberLoop(formData.dataReport,'USD_Dr'), formData.formatter === 'decimal' ? '0,000' : '0,00.00')}}</td>
                    <td class="text-right">{{ numeralFormat(sumNumberLoop(formData.dataReport,'USD_Cr'), formData.formatter === 'decimal' ? '0,000' : '0,00.00')}}</td>
                </tr>
                </tfoot>
            </v-table>

            <v-row class="d-flex">
                <v-col v-if="formData && formData['dataReport'][0].Singnature1 !== ''">
                    <span>{{formData ? formData['dataReport'][0].Singnature1 : ''}}</span>
                    <br/>
                    <span v-if="formData && formData['dataReport'][0].SubSingnature1">{{formData ? formData['dataReport'][0].SubSingnature1 : ''}}</span>
                </v-col>
                <v-col v-if="formData && formData['dataReport'][0].Singnature1 !== ''">
                    <span>{{formData ? formData['dataReport'][0].Singnature2 : ''}}</span>
                    <br/>
                    <span v-if="formData && formData['dataReport'][0].SubSingnature1">{{formData ? formData['dataReport'][0].SubSingnature1 : ''}}</span>
                </v-col>
                <v-col v-if="formData && formData['dataReport'][0].Singnature1 !== ''">
                    <span>{{formData ? formData['dataReport'][0].Singnature3 : ''}}</span>
                    <br/>
                    <span v-if="formData && formData['dataReport'][0].SubSingnature1">{{formData ? formData['dataReport'][0].SubSingnature1 : ''}}</span>
                </v-col>
                <v-col v-if="formData && formData['dataReport'][0].Singnature1 !== ''">
                    <span>{{formData ? formData['dataReport'][0].Singnature4 : ''}}</span>
                    <br/>
                    <span v-if="formData && formData['dataReport'][0].SubSingnature1">{{formData ? formData['dataReport'][0].SubSingnature1 : ''}}</span>
                </v-col>
                <v-col v-if="formData && formData['dataReport'][0].Singnature1 !== ''">
                    <span>{{formData ? formData['dataReport'][0].Singnature5 : ''}}</span>
                    <br/>
                    <span v-if="formData && formData['dataReport'][0].SubSingnature1">{{formData ? formData['dataReport'][0].SubSingnature1 : ''}}</span>
                </v-col>
            </v-row>
        </div>

            <div v-else class="d-flex flex-column justify-center align-center text-center" style="height:100vh">
                <div style="color: red">
                    <v-icon size="74">mdi-delete-forever</v-icon>
                    <h2 style="color: red">ບໍ່ພົບຂໍ້ມູນການລາຍງານ</h2>
                </div>
            </div>




    </div>
</template>
<script>
import sumWithLoop from "../mixin/sumWithLoop";

export default {
    name: "TransactionGLReport",
    props: ['formData'],
    mixins: [sumWithLoop],
    computed: {
        mapGetFirstIndexData() {
            return this.formData?.dataReport[0]
        }
    }
}

</script>
<style scoped>
.custom-table {
    align-items: center;
    justify-content: center;
    justify-items: center;
    font-size: 10pt;
}

</style>
