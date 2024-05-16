require("dotenv").config();
const mix = require("laravel-mix");

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */
mix.js(
    "resources/js/react/containers/bank_voucher/MainBankVoucher.js",
    "public/react/component/containers/bank_voucher"
).react();
mix.js(
    "resources/js/react/containers/cash_voucher/MainCashVoucher.js",
    "public/react/component/containers/cash_voucher"
).react();
// general
mix.js(
    "resources/js/react/containers/general_voucher/MainGeneralVoucher.js",
    "public/react/component/containers/general_voucher"
).react();
mix.js(
    "resources/js/react/containers/general_voucher/UpdateGeneralVoucher.js",
    "public/react/component/containers/general_voucher"
).react();
// advance
mix.js(
    "resources/js/react/containers/advance_ledger_voucher/MainAdvanceLedgerVoucher.js",
    "public/react/component/containers/advance_ledger_voucher"
).react();
mix.js(
    "resources/js/react/containers/advance_ledger_voucher/UpdateAdvanceLedgerVoucher.js",
    "public/react/component/containers/advance_ledger_voucher"
).react();
// clear advance
mix.js(
    "resources/js/react/containers/clear_advance_ledger_voucher/MainClearAdvanceLedgerVoucher.js",
    "public/react/component/containers/clear_advance_ledger_voucher"
).react();
mix.js(
    "resources/js/react/containers/clear_advance_ledger_voucher/UpdateClearAdvanceVoucher.js",
    "public/react/component/containers/clear_advance_voucher"
).react();

// report
mix.js(
    "resources/js/react/containers/filter_report/Main.js",
    "public/react/component/containers/report/filter_report"
).react();
//print
mix.js(
    "resources/js/react/containers/print/VoucherGeneral.js",
    "public/react/component/containers/print/voucher_general.js"
).react();
mix.js(
    "resources/js/react/containers/print/VoucherAdvanceLedger.js",
    "public/react/component/containers/print/voucher_advance_ledger.js"
).react();
mix.js(
    "resources/js/react/containers/print/VoucherClearAdvanceLedger.js",
    "public/react/component/containers/print/voucher_clear_advance_ledger.js"
).react();
mix.js(
    "resources/js/react/containers/print/TrialBalance.js",
    "public/react/component/containers/print/trial_balance.js"
).react();
mix.js(
    "resources/js/react/containers/print/VoucherTransaction.js",
    "public/react/component/containers/print/voucher_transaction.js"
).react();
mix.js(
    "resources/js/react/containers/print/VoucherTransactionDaily.js",
    "public/react/component/containers/print/voucher_transaction_daily.js"
).react();
mix.js(
    "resources/js/react/containers/print/VoucherLedger.js",
    "public/react/component/containers/print/voucher_ledger.js"
).react();

// back reconcile
mix.js(
    "resources/js/react/containers/bank_reconcile/CreateBankReconcile.js",
    "public/react/component/containers/bank_reconcile/create_bank_reconcile.js"
).react();

// cash reconcile
mix.js(
    "resources/js/react/containers/cash_reconcile/CreateBankReconcile.js",
    "public/react/component/containers/cash_reconcile/create_cash_reconcile.js"
).react();

// closing account
mix.js(
    "resources/js/react/containers/closing_account/ClosingAccount.js",
    "public/react/component/containers/closing_account/closing_account.js"
).react();

// opening balance
mix.js(
    "resources/js/react/containers/opening_balance/OpeningBalance.js",
    "public/react/component/containers/opening_balance/opening_balance.js"
).react();

// project-budget
mix.js(
    "resources/js/react/containers/project_budget/ProjectBudget.js",
    "public/react/component/containers/project_budget/project_budget.js"
).react();

// quater-budget
mix.js(
    "resources/js/react/containers/quater_budget/QuaterBudget.js",
    "public/react/component/containers/quater_budget/quater_budget.js"
).react();

mix.js(
    "resources/js/react/containers/users/MainUser.js",
    "public/react/component/containers/main_user"
).react();

mix.js("resources/js/app.js", "public/js")
    .vue()
    .disableNotifications()
    .sass("resources/sass/app.scss", "public/css")
    .version();
