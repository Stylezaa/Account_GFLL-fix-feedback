export default {
    methods: {
        convertToNum(value) {
            // if(isNaN(value)){
            //     return 0
            // }else{
                return parseInt(value.toString().replace(/,/g, ''));
            // }
        },
        removeThousandSeparator(num = Number | String ) {
            if (typeof num === 'number' && isNaN(num)) return `${num}`
            return Number(`${num}`.replace(/[^0-9\-.]+/g, ''))
            // return Number(`${num}`.replace(/[^0-9\-.]+/g, ''))
        }
    }
}
