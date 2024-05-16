import {swalErrorToast} from "./swalhelper";

export default {
    data() {
        return {
            listLevels: [],
            ruleProvince: ['V','D','P'],
            ruleDistrict: ['V','D'],
            ruleVillage: ['V'],
        }
    },
    async created() {
        await this.fetchLevel()
    },

    methods: {
        async fetchLevel() {
            try {
                await axios.get(this.globalUrlApiPath + `/users/level`)
                    .then((res) => {
                        if (res.data) {
                            this.listLevels = res.data.map((item) => ({
                                ...item,
                                levelTitleKeyLa: `${item.LevelID} - ${item.LevelNameL}`,
                                levelTitleKeyEn: `${item.LevelID} - ${item.LevelNameE}`
                            }));
                        } else {
                            this.listLevels = []
                        }
                    })
            } catch (error) {
                swalErrorToast('ຜິດພາດ!', 'ບໍສາມາດເອີ້ນຂໍ້ມູນ ຂັ້ນໄດ້ ້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!' + error)
            }
        },
        isRuleProvince(level,isReadOnly) {
            if(!isReadOnly){
                return this.ruleProvince.some((x)=>x === level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []
            }
           if(isReadOnly){
               return this.ruleProvince.some((x)=>x === level)
           }
        },
        isRuleDistrict(level,isReadOnly) {
            if(!isReadOnly){
                return this.ruleDistrict.some((x)=>x === level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []
            }
           if(isReadOnly){
               return this.ruleDistrict.some((x)=>x === level)
           }
        },
        isRuleVillage(level,isReadOnly) {
            if(!isReadOnly){
                return this.ruleVillage.some((x)=>x === level) ? [v => !!v || 'ກາລຸນາປ້ອນຂໍ້ມູນ'] : []
            }
           if(isReadOnly){
               return this.ruleVillage.some((x)=>x === level)
           }
        },
        implementCode(level,codeObject){
            const {prodId,distId,vilId} = codeObject
            if(level === 'C'){
                return "00"
            }
        }
    }
}
