export default {
    computed: {
        globalUrlApiPath() {
            return `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}`
        }
    }
}
