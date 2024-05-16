export default {
    methods: {
        sumNumberLoop(arr, key) {
            let sum = 0;
            for (let i = 0; i < arr.length; i++) {
                sum += arr[i][key];
            }
            return sum;
        }
    }
}
