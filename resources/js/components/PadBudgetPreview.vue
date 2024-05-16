<template>
    <div>
        <div v-if="queryData[0]">

            <v-row>
                <v-col cols md="12" class="d-flex justify-content-center">{{
                        mapGetFirstIndexData.Lao1 ?? 'N/A'
                    }}
                </v-col>
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
                    <h3 class="font-weight-bold">{{ mapGetFirstIndexData.Header ?? 'N/A' }}</h3>
                </v-col>
                <!--                <v-col cols md="12" class="mt-n5 d-flex justify-center align-center">-->
                <!--                    <h5>ປະຈຳປີ 2023 </h5>-->
                <!--                </v-col>-->
            </v-row>

            <!-- table -->

            <v-table density="compact" class="custom-table">
                <thead>
                <tr>
                    <th rowspan="2" class="text-center">{{ mapGetFirstIndexData.lblActID ?? 'N/A' }}</th>
                    <th rowspan="2" class="text-center text-nowrap">{{ mapGetFirstIndexData.lblActNm ?? 'N/A' }}</th>
                    <th rowspan="2" class="text-center text-nowrap">{{ mapGetFirstIndexData.lblCAT ?? 'N/A' }}</th>
                    <th rowspan="2" class="text-center">{{ mapGetFirstIndexData.lblBSP ?? 'N/A' }}</th>

                    <th class="text-center text-nowrap" colspan="3">ງົບປະມານ</th>
                </tr>
                <tr>

                    <th class="text-center">{{ mapGetFirstIndexData.lblLAK ?? 'N/A' }}</th>
                    <th class="text-center text-nowrap">{{ mapGetFirstIndexData.lblRate ?? 'N/A' }}</th>
                    <th class="text-center">{{ mapGetFirstIndexData.lblUSD ?? 'N/A' }}</th>

                </tr>
                </thead>
                <tbody>

                <template v-for="(item,index) in groupedData" :key="`view-data-`+index">
                    <tr>
                        <td >{{ item.ComponentID }}</td>
                        <td ></td>
                        <td ></td>
                        <td class="text-no-wrap">{{ item.details.ComponentName ?? 'N/A'}}</td>
                    </tr>

                    <template v-for="(item2,index2) in item.subComponentId" :key="`view-data2-`+index">
                        <tr>
                            <td class="pl-6">{{ item2.SubComponentID }}</td>
                            <td ></td>
                            <td ></td>
                            <td class="text-no-wrap">{{ item2.details.SubComponentName ?? 'N/A'}}</td>
                        </tr>
                        <tr v-for="(item3,index3) in item2.groupActId"  :key="`view-data3-`+index" >
                            <td class="pl-10" >{{ item3.GroupActID }}</td>
                            <td class="pl-10" >{{ item3 }}</td>
                            <td ></td>
                            <td ></td>
                        </tr>
                    </template>


                </template>

                <!--                    <tr>-->
                <!--                        <td v-if="index === 0">-->
                <!--                            <div class="pl-4">-->
                <!--                                {{ item.GroupActID }}-->
                <!--                            </div>-->
                <!--                        </td>-->
                <!--                        <td v-if="index === 0" class="text-nowrap">{{ item.GroupActName }}</td>-->
                <!--                        <td v-if="index === 0"></td>-->
                <!--                        <td v-if="index === 0"></td>-->
                <!--                        <td v-if="index === 0" class="text-right">{{ item.AmountLAK }}</td>-->
                <!--                        <td v-if="index === 0" class="text-right">{{ item.Rate }}</td>-->
                <!--                        <td v-if="index === 0" class="text-right">{{ item.AmountUSD }}</td>-->
                <!--                    </tr>-->
                <!--                    <tr>-->
                <!--                        <td>-->
                <!--                            <div class="pl-6">-->
                <!--                                {{ item.ActivityID }}-->
                <!--                            </div>-->
                <!--                        </td>-->
                <!--                        <td  class="text-nowrap">{{ item.ActivityName }}</td>-->
                <!--                        <td>{{ item.CategoryID }}</td>-->
                <!--                        <td>{{ item.BSPID }}</td>-->
                <!--                        <td class="text-right">{{ item.AmountLAK }}</td>-->
                <!--                        <td class="text-right">{{ item.Rate }}</td>-->
                <!--                        <td class="text-right">{{ item.AmountUSD }}</td>-->
                <!--                    </tr>-->

                </tbody>
                <tfoot>
                <tr>
                    <td class="text-center " colspan="4">{{ mapGetFirstIndexData.lblGRoral ?? 'N/A' }}</td>
                </tr>
                </tfoot>
            </v-table>

            <v-row class="mt-2" justify="end">
                <v-col cols="4">
                    <p class="text-right border-text">{{ mapGetFirstIndexData.LoCationPlace ?? 'N/A' }}</p>
                </v-col>
            </v-row>


        </div>


    </div>
</template>
<script>

import countWithSameDataMixin from "../mixin/countWithSameDataMixin";

export default {
    name: "BudgetPreview",
    props: ['queryData'],
    mixins: [countWithSameDataMixin],
    computed: {
        mapGetFirstIndexData() {
            return this.queryData[0]
        },
        groupedData() {
            return this.queryData.reduce((acc, el) => {
                let {ComponentID,SubComponentID,GroupActID} = el
                let preComponentId = acc.find(x => x.ComponentID === ComponentID);
                if(!preComponentId){
                    acc.push({ComponentID,details: el, subComponentId: []});
                } else {
                    // set sub component
                    let prevSubComponent = preComponentId.subComponentId.find(x => x.SubComponentID === SubComponentID);

                    if(!prevSubComponent) {

                        preComponentId.subComponentId.push({SubComponentID,details: el, groupActId: []});

                    } else {

                        prevSubComponent.groupActId.push({GroupActID});
                        // GroupActID
                        let prevGroupActID = prevSubComponent.groupActId.find(x => x.GroupActID === GroupActID)

                        if(!prevGroupActID) {
                            prevSubComponent.groupActId.push({GroupActID,groupActId: []});
                        } else {
                             prevSubComponent.groupActId.push({GroupActID});
                        }
                    }
                }
                return acc;
            }, []);
        },

    },
    created() {
        // const relatedSites = [ { "SubdomainName": "client1", "ClientName": "Eastern Region", "ClientAlias": "eastern-region" }, { "SubdomainName": "client1", "ClientName": "City of Knox", "ClientAlias": "knox" }, { "SubdomainName": "client2", "ClientName": "Eastern Region", "ClientAlias": "eastern-region" }, { "SubdomainName": "client2", "ClientName": "City of Knox", "ClientAlias": "knox" } ];
        //
        // const result = Object.values(relatedSites.reduce((acc, el) => {
        //     acc[el.SubdomainName] = acc[el.SubdomainName] || { title: el.SubdomainName, links: [] };
        //     acc[el.SubdomainName].links.push({ url: `https://${el.SubdomainName}.com/${el.ClientAlias}`, displayText: el.ClientName });
        //     return acc;
        // }, {}))
        //
        // console.log(result)
        //
         console.log(JSON.stringify(this.queryData,null,2))
    },
    methods: {
    }
}

</script>
<style scoped>
.border-text {
    padding: 4px;
    border: 1px dashed black;
}
</style>
