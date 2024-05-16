<template>
    <div>
        <v-row>
            <v-col cols md="12" class="d-flex justify-content-center">{{ formData ? formData['data'][0].Lao1Name : '' }}</v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-content-center">{{ formData ? formData['data'][0].Lao2Name : '' }}
            </v-col>
        </v-row>

        <v-row>
            <v-col cols md="12" class="d-flex justify-content-start">{{ formData ? formData['data'][0].MinistryName : '' }}</v-col>
            <v-col cols md="12" class="d-flex mt-n5 justify-content-start">
                {{ formData ? formData['data'][0].DepartmentName : '' }}
            </v-col>
            <v-col cols md="12" class=" d-flex mt-n5 justify-content-start">{{ formData ? formData['data'][0].ProjectName : '' }}
            </v-col>
            <v-col cols md="6" class=" d-flex mt-n5 justify-content-start">{{ formData ? formData['data'][0].ImplementName : '' }}
            </v-col>
        </v-row>

        <v-row class="mt-3">
            <v-col cols md="12" class="mb-n1 d-flex justify-center align-center">
                <h3 class="font-weight-bold">{{formData ? formData['data'][0].Header : ''}}</h3>
            </v-col>
            <v-col cols md="12" class="mt-n5 d-flex justify-center align-center">
                <h5>{{formData ? formData['data'][0].SPeriod : ''}}</h5>
            </v-col>
        </v-row>

        <v-table density="compact" class="custom-table">
            <thead>
            <tr>
                <th rowspan="2" class="text-nowrap" style="width: 50px !important;">{{formData ? formData['data'][0].TitleNo : ''}}</th>
                <th rowspan="2" class="text-center">{{formData ? formData['data'][0].TitleCD : ''}}</th>
                <th rowspan="2" class="text-center text-nowrap">{{formData ? formData['data'][0].AccntTitle : ''}}</th>
                <th colspan="2" class="text-center">{{formData ? formData['data'][0].OpenTitle : ''}}</th>
                <th colspan="2" class="text-center">{{formData ? formData['data'][0].TranTitle : ''}}</th>
                <th colspan="2" class="text-center">{{formData ? formData['data'][0].RemTitle : ''}}</th>

            </tr>
            <tr>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleCr : ''}}</th>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleDr : ''}}</th>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleCr : ''}}</th>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleDr : ''}}</th>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleCr : ''}}</th>
                <th class="text-center text-nowrap">{{formData ? formData['data'][0].TitleDr : ''}}</th>
            </tr>
            </thead>
            <tbody>
            <tr v-if="formData !== null" v-for="(item, index) in formData['data']" :key="`voucher-${index}`">
                <td style="width: 50px !important;">{{ index+1 }}</td>
                <td>{{ item.AccountCD }}</td>
                <td class="text-nowrap">{{ item.AccountName }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.OPENDr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.OPENCr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.TransDr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.TransCr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.BalanceDr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right text-nowrap">{{ numeralFormat(item.BalanceCr,formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
            </tr>
            <tr>
                <td colspan="3" class="text-center">{{formData ? formData['data'][0].GTotalTotle : ''}}</td>
                <td></td>
                <td></td>
                <td class="text-right">{{ numeralFormat(calTotalOpenDr(), formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right">{{ numeralFormat(calTotalOpenCr(), formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right">{{ numeralFormat(calTotalBalanceDr(), formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
                <td class="text-right">{{ numeralFormat(calTotalBalanceCr(), formData['format'] === 'decimal' ? '0,000' : '0,00.00') }}</td>
            </tr>
            </tbody>
        </v-table>

        <v-row>
            <v-col cols md="12" class="mt-5">
                <span class="d-flex justify-end align-end">{{formData ? formData['data'][0].ReportPlace : ''}}</span>
            </v-col>
        </v-row>

        <v-row class="d-flex">
            <v-col v-if="formData && formData['data'][0].Singnature1 !== ''">
                <span>{{formData ? formData['data'][0].Singnature1 : ''}}</span>
                <br/>
                <span v-if="formData && formData['data'][0].SubSingnature1">{{formData ? formData['data'][0].SubSingnature1 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Singnature1 !== ''">
                <span>{{formData ? formData['data'][0].Singnature2 : ''}}</span>
                <br/>
                <span v-if="formData && formData['data'][0].SubSingnature1">{{formData ? formData['data'][0].SubSingnature1 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Singnature1 !== ''">
                <span>{{formData ? formData['data'][0].Singnature3 : ''}}</span>
                <br/>
                <span v-if="formData && formData['data'][0].SubSingnature1">{{formData ? formData['data'][0].SubSingnature1 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Singnature1 !== ''">
                <span>{{formData ? formData['data'][0].Singnature4 : ''}}</span>
                <br/>
                <span v-if="formData && formData['data'][0].SubSingnature1">{{formData ? formData['data'][0].SubSingnature1 : ''}}</span>
            </v-col>
            <v-col v-if="formData && formData['data'][0].Singnature1 !== ''">
                <span>{{formData ? formData['data'][0].Singnature5 : ''}}</span>
                <br/>
                <span v-if="formData && formData['data'][0].SubSingnature1">{{formData ? formData['data'][0].SubSingnature1 : ''}}</span>
            </v-col>
        </v-row>
    </div>
</template>

<script>

export default {
    props: ['formData'],
    methods: {
        calTotalOpenDr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.TransDr > 0) {
                        amount = amount + parseInt(item.TransDr);
                    }
                });
            }
            return amount;
        },
        calTotalOpenCr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.TransCr > 0) {
                        amount = amount + parseInt(item.TransCr);
                    }
                });
            }
            return amount;
        },
        calTotalBalanceDr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.BalanceDr > 0) {
                        amount = amount + parseInt(item.BalanceDr);
                    }
                });
            }
            return amount;
        },
        calTotalBalanceCr() {
            let amount = 0;
            if (this.formData['data'] !== null) {
                this.formData['data'].forEach(item => {
                    if (item.BalanceCr > 0) {
                        amount = amount + parseInt(item.BalanceCr);
                    }
                });
            }
            return amount;
        },
    }
}
</script>

<style scoped>
.text-box {
    display: inline-block;
    background-color: white;
    color: black;
    border: 1px solid #000;
    margin-left: 5px;
    padding-left: 20px;
    padding-right: 20px;
    width: 150px;
}

.title-text {
    font-size: 15pt;
    font-weight: 900;
}

.refer-box-title {
    display: inline-block;
    min-width: 150px;
    max-width: 150px;
    width: 150px !important;
    margin: 0 auto;
}

.amount-letter-text {
    display: flex;
    min-width: 300px;
    max-width: 300px;
    margin: 0 auto;
    height: 50px;
    align-items: center;
}

.amount-letter-number {
    display: flex;
    background-color: white;
    color: black;
    border: 1px solid #000;
    padding-left: 20px;
    padding-right: 20px;
    width: 100%;
    height: 50px;
    align-items: center;
}

.refer-box-title-right {
    width: 150px;
    justify-content: flex-end;
    align-content: flex-end;
    margin-right: 0;
}

.refer-box {
    display: inline-flex;
    background-color: white;
    color: black;
    border: 1px solid #000;
    padding-left: 20px;
    padding-right: 20px;
    height: 25px;
    width: 100%;
}

.summary-row1 {
    border-left: none;
    border-bottom: none;
    border-right: none;
    border-top: 1px solid black;
    background-color: var(--bs-body-bg);
}

.summary-row2 {
    border-left: none;
    border-bottom: none;
    border-right: none;
    border-top: 1px solid black;
    background-color: var(--bs-body-bg);
}

.rate-text-size {
    display: flex;
    min-width: 150px;
    max-width: 150px;
    margin: 0 auto;
    height: 50px;
    align-items: center;
    justify-items: center;
    justify-content: center;
}

.custom-table {
    align-items: center;
    justify-content: center;
    justify-items: center;
    font-size: 10pt;
}

.summary-title {
    justify-content: flex-end;
    align-content: flex-end;
    margin-right: 0;
}

.summary-signal-left {
    width: 300px;
    justify-content: flex-end;
    margin-left: 12px;
    align-content: flex-end;
    border-bottom: 1px solid #000000;
    border-left: 0;
    border-right: 0;
    border-top: 0;
}

.summary-signal-right {
    width: 300px;
    justify-content: flex-end;
    margin-left: 12px;
    align-content: flex-end;
    border-bottom: 1px solid #000000;
    border-left: 0;
    border-right: 0;
    border-top: 0;
}
</style>
