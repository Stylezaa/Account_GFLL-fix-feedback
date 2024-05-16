export default {
    methods: {
        countData(array, data) {
            let count = 0;
           for (let i = 0; i < array.length; i++) {
                if (array[i] === data) {
                    count++;
                }
           }
            return count;
        }
    }
}
