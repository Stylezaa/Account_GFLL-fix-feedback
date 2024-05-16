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
                    <th rowspan="2" class="text-nowrap text-center" style="width: 90px !important;">
                        {{ formData ? formData['data'][0].lblActID : '' }}
                    </th>
                    <th rowspan="2" class="text-nowrap text-center">{{
                            formData ? formData['data'][0].lblActNm : ''
                        }}
                    </th>
                    <th rowspan="2" class="text-nowrap text-center">{{
                            formData ? formData['data'][0].lblCAT : ''
                        }}
                    </th>
                    <th rowspan="2" class="text-nowrap text-center">{{
                            formData ? formData['data'][0].lblBSP : ''
                        }}
                    </th>
                    <th colspan="5" class="text-nowrap text-center">{{
                            formData ? formData['data'][0].lblBudget : ''
                        }}
                    </th>
                </tr>
                <tr>
                    <th class="text-nowrap text-center">{{ formData ? formData['data'][0].lblQ1 : '' }}</th>
                    <th class="text-nowrap text-center">{{ formData ? formData['data'][0].lblQ2 : '' }}</th>
                    <th class="text-nowrap text-center">{{ formData ? formData['data'][0].lblQ3 : '' }}</th>
                    <th class="text-nowrap text-center">{{ formData ? formData['data'][0].lblQ4 : '' }}</th>
                    <th class="text-nowrap text-center">{{ formData ? formData['data'][0].lblYr : '' }}</th>
                </tr>
                </thead>
                <tbody>
                <tr v-if="formData !== null" v-for="(item, index) in formData['data']" :key="`openBalance-${index}`">
                    <td class="text-nowrap text-center">{{ item.ActivityID }}</td>
                    <td class="text-truncate">{{ item.ActivityName }}</td>
                    <td class="text-nowrap">{{ item.CategoryID }}</td>
                    <td class="text-nowrap">{{ item.BSPID }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.AmtQ1, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.AmtQ2, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.AmtQ3, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.AmtQ4, '0,00.00') }}</td>
                    <td class="text-right text-nowrap">{{ numeralFormat(item.AmtYear, '0,00.00') }}</td>
                </tr>
                <tr>
                    <td colspan="2" class="text-center">{{ formData ? formData['data'][0].lblGRoral : '' }}</td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-right">{{ numeralFormat(calQ1(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calQ2(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calQ3(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calQ4(), '0,00.00') }}</td>
                    <td class="text-right">{{ numeralFormat(calYr(), '0,00.00') }}</td>
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
            <v-col>
                <span
                    v-if="formData && formData['data'][0].Sign1 !== ''">{{
                        formData ? formData['data'][0].Sign1 : ''
                    }}</span>
            </v-col>
            <v-col>
                <span
                    v-if="formData && formData['data'][0].Sign2 !== ''">{{
                        formData ? formData['data'][0].Sign2 : ''
                    }}</span>
            </v-col>
            <v-col>
                <span
                    v-if="formData && formData['data'][0].Sign3 !== ''">{{
                        formData ? formData['data'][0].Sign3 : ''
                    }}</span>
            </v-col>
            <v-col>
                <span
                    v-if="formData && formData['data'][0].Sign4 !== ''">{{
                        formData ? formData['data'][0].Sign4 : ''
                    }}</span>
            </v-col>
            <v-col>
                <span
                    v-if="formData && formData['data'][0].Sign5 !== ''">{{
                        formData ? formData['data'][0].Sign5 : ''
                    }}</span>
            </v-col>
        </v-row>
    </div>
</template>

<script>
export default {
    props: ['formData'],
    data(){
        return{
            data:[

            ]
        }
    },
    mounted() {
        this.findComponents()
    },
    methods: {
        calQ1() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.AmtQ1 > 0) {
                        amount = amount + parseInt(item.AmtQ1);
                    }
                });
            }
            return amount;
        },
        calQ2() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.AmtQ2 > 0) {
                        amount = amount + parseInt(item.AmtQ2);
                    }
                });
            }
            return amount;
        },
        calQ3() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.AmtQ3 > 0) {
                        amount = amount + parseInt(item.AmtQ3);
                    }
                });
            }
            return amount;
        },
        calQ4() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.AmtQ4 > 0) {
                        amount = amount + parseInt(item.AmtQ4);
                    }
                });
            }
            return amount;
        },
        calYr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.AmtYear > 0) {
                        amount = amount + parseInt(item.AmtYear);
                    }
                });
            }
            return amount;
        },
        findComponents(){
            //filter components
           const components = this.formData.filter((item) => item.ComponentID);
           //remove duplicate component
           const newCompo = [...new Set(components)];
            // find subComponent
            newCompo.forEach(item => {
                this.data.push({
                    component:item,
                    componentName:  this.formData[this.formData.findIndex(cp => cp.ComponentID === item)].ComponentName,
                    category:null,
                    bspCategory:null,
                    subComponent:{

                    }
                })
                /*const subComponent = this.formData.filter((subItem) => subItem.ComponentID === item);
                //remove duplicate
                const newBubCompo = [...new Set(subComponent)];*/
            })

        }
    }
}
</script>

<style scoped>

</style>
