const {createApp} = require("vue");
window._ = require('lodash');
window.Vue = require('vue');
window.Swal = require('sweetalert2');

import NumeralJs from 'vue-numerals';
import moment from 'moment'
import vueMoment from '@rah-emil/vue-moment'
import VueNumberFormat from "@coders-tm/vue-number-format";
import {createI18n} from "vue-i18n";
import languageFiles from './lang';

import '@mdi/font/css/materialdesignicons.css';
import 'vuetify/styles';
import {createVuetify} from 'vuetify';
import * as components from 'vuetify/components';
import * as directives from 'vuetify/directives';


const i18n = createI18n({
    locale: 'en',
    fallbackLocale: 'la',
    messages: languageFiles
})

const vuetify = createVuetify({
    components,
    directives
})

try {
    require('bootstrap');
} catch (e) {
}

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
window.axios.defaults.headers["Access-Control-Allow-Origin"] = "*";


/**
 * Echo exposes an expressive API for subscribing to channels and listening
 * for events that are broadcast by Laravel. Echo and event broadcasting
 * allows your team to easily build robust real-time web applications.
 */

// import Echo from 'laravel-echo';

// window.Pusher = require('pusher-js');

// window.Echo = new Echo({
//     broadcaster: 'pusher',
//     key: process.env.MIX_PUSHER_APP_KEY,
//     cluster: process.env.MIX_PUSHER_APP_CLUSTER,
//     forceTLS: true
// });

const app = createApp({});
app.config.globalProperties.$i18n = i18n;

app.use(i18n);
app.use(vuetify);
app.use(NumeralJs);
app.use(vueMoment, {moment})
app.use(VueNumberFormat, {
    precision: 2,
    separator: ','
});
app.component('general-voucher', require('./components/GeneralVoucher.vue').default);
app.component('voucher-advance', require('./components/VoucherAdvance.vue').default);
app.component('voucher-advance-clear', require('./components/VoucherAdvanceClear.vue').default);
app.component('voucher-advance-ledger-list', require('./components/VoucherAdvance_Ledger_List.vue').default);
app.component('voucher-dvance_clear_ledger_list', require('./components/VoucherAdvance_Clear_Ledger_List.vue').default);
app.component('voucher-preview', require('./components/GeneralVoucherPreview.vue').default);
app.component('voucher-advance-preview', require('./components/VoucherAdvancePreview.vue').default);
app.component('trial-balance', require('./components/TrialBalance.vue').default);
app.component('trial-balance-report', require('./components/TrailBalanceReport.vue').default);
app.component('closing-account', require('./components/ClosingAccount.vue').default);
app.component('open-balance', require('./components/OpenBalance.vue').default);
app.component('open-balance-preview', require('./components/OpenBalancePreview.vue').default);
app.component('transaction-gl', require('./components/TransactionGLReport.vue').default);
app.component('transaction-gl-report', require('./components/TransactionGLReport.vue').default);
app.component('general-journal-report', require('./components/GeneralJournalReport.vue').default);
app.component('report-initial-page', require('./components/ReportIntialPage.vue').default);
app.component('general-ledger-report', require('./components/GeneralLedgerReport.vue').default)
app.component('pad-budget', require('./components/PadBudget.vue').default)
app.component('pad-budget-preview', require('./components/PadBudgetPreview.vue').default)
app.component('general-ledger-report', require('./components/GeneralLedgerReport.vue').default);
app.component('general-ledger-report', require('./components/GeneralLedgerReport.vue').default);
app.component('quarter-report', require('./components/QuarterReport.vue').default);
app.component('quarter-report-preview', require('./components/QuarterReportPreview.vue').default);
app.component('bank-control-book-report', require('./components/BankControlBookReport.vue').default);
app.component('cash-reconcile', require('./components/CashReconcile.vue').default);
app.component('cash-new-reconcile', require('./components/CashNewReconcile.vue').default);
app.component('bank-control-book-report-preview', require('./components/BankControlBookReportPreview.vue').default);
app.component('bank-voucher-index', require('./components/BankVoucherIndex.vue').default);
app.component('bank-voucher', require('./components/BankVoucher.vue').default);
app.component('bank-voucher-preview', require('./components/BankVoucherPreview.vue').default);
app.component('cash-voucher-index', require('./components/CashVoucherIndex.vue').default);
app.component('cash-voucher', require('./components/CashVoucher.vue').default);
app.component('cash-voucher-preview', require('./components/CashVoucherPreview.vue').default);
app.component('user-manage', require('./components/UserManage.vue').default);
app.mount('#app');
