<template>
    <div>
        <div class="col col-12 flex-column">
            <h4 class="fw-bold py-3 mb-2">
                <span class="text-muted fw-light">ຈັດການຜູ້ໃຊ້ງານ </span>
                <button
                    @click="formDialog = true"
                    class="btn btn-primary float-end"
                >
                    ເພິ່ມຂໍ້ມູນໃຫມ່ &nbsp;<i class="fa fa-plus-circle"></i>
                </button>
            </h4>
        </div>
        <v-divider class="my-4" color="black" />
        <!-- table data -->
        <div class="card p-3">
            <div class="card-title">
                <h4>ລາຍການຂໍ້ມູນ ({{ userResponseList.length }})</h4>
            </div>
            <div class="table-responsive">
                <table
                    class="table table-bordered table-striped"
                    id="user-table"
                >
                    <thead>
                        <tr>
                            <th
                                v-for="(item, index) in headers"
                                :key="`tb-user` + index"
                                :class="item.align"
                            >
                                {{ item.title }}
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr
                            v-for="(item, index) in userResponseList"
                            :key="`data-user-tb` + index"
                        >
                            <td>{{ index + 1 }}.</td>
                            <td>{{ item.UserID }}</td>
                            <td>{{ item.UserName }}</td>
                            <td>{{ item.UserAdmin ? "Admin" : "User" }}</td>
                            <td>
                                {{
                                    item.get_level
                                        ? item.get_level?.LevelID +
                                          " - " +
                                          item.get_level?.LevelNameL
                                        : "N/A"
                                }}
                            </td>
                            <td>{{ item.UserName }}</td>
                            <td>{{ item.CanPost ? true : false }}</td>
                            <td class="text-center text-no-wrap">
                                <div
                                    @click="openPermissionDialog(item)"
                                    class="btn btn-outline-success btn-sm"
                                >
                                    <i class="fa fa-shield-alt" />
                                </div>
                                &nbsp;
                                <div
                                    class="btn btn-outline-warning btn-sm"
                                    @click="updateForm(item)"
                                >
                                    <i class="fa fa-edit" />
                                </div>
                                &nbsp;
                                <div
                                    :loading="isLoadingSave"
                                    class="btn btn-outline-danger btn-sm"
                                    @click="deleteUser(item)"
                                >
                                    <i class="fa fa-trash" />
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- dialog form -->
        <v-dialog v-model="formDialog" width="840" scrollable="">
            <v-card>
                <v-card-title> ຟອມປ້ອນຂໍ້ມູນຜູ້ໃຊ້ງານ </v-card-title>
                <v-divider color="black" />
                <v-card-text>
                    <v-form ref="formUserRef">
                        <v-row>
                            <v-col cols="12">
                                <div class="d-flex align-center">
                                    <v-text-field
                                        v-model="formRequest.UserID"
                                        prepend-inner-icon="mdi-lock"
                                        label="ລະຫັດຜູ້ໃຊ້ງານ"
                                        variant="outlined"
                                        style="width: 60%"
                                    />
                                    <v-spacer />
                                    <v-checkbox
                                        v-model="used"
                                        color="blue"
                                        class="mt-n3"
                                        label="ຢືນຢັ້ນການລົງບັນຊີໄດ້"
                                        style="width: 40%"
                                    />
                                </div>
                                <v-text-field
                                    v-model="formRequest.UserName"
                                    prepend-inner-icon="mdi-account"
                                    :rules="[rules.required]"
                                    label="ຊື່ຜູ້ໃຊ້ງານ"
                                    variant="outlined"
                                />
                                <!-- email -->
                                <v-text-field
                                    v-model="formRequest.Email"
                                    prepend-inner-icon="mdi-email"
                                    label="ອີເມວ"
                                    variant="outlined"
                                />
                                <v-select
                                    v-model="formRequest.UserAdmin"
                                    prepend-inner-icon="mdi-shield-half-full"
                                    :rules="[rules.required]"
                                    :items="userRoles"
                                    label="ສິດນຳໃຊ້"
                                    variant="outlined"
                                />
                                <div class="d-flex">
                                    <v-text-field
                                        v-model="formRequest.UserPWD"
                                        :rules="[
                                            rules.required,
                                            rules.minLength,
                                        ]"
                                        prepend-inner-icon="mdi-lock"
                                        type="password"
                                        label="ລະຫັດຜ່ານ"
                                        variant="outlined"
                                        style="width: 50%"
                                    />
                                    <v-text-field
                                        v-model="formRequest.UserPWDConfirm"
                                        :rules="[
                                            rules.required,
                                            rules.matchPassword(
                                                formRequest.UserPWD,
                                                formRequest.UserPWDConfirm
                                            ),
                                        ]"
                                        class="ml-2"
                                        prepend-inner-icon="mdi-lock"
                                        type="password"
                                        label="ຢື້ນຢັນລະຫັດຜ່ານ"
                                        variant="outlined"
                                        style="width: 50%"
                                    />
                                </div>

                                <v-autocomplete
                                    v-model="formRequest.LevelID"
                                    :items="listLevels"
                                    :rules="[rules.required]"
                                    item-title="levelTitleKeyLa"
                                    item-value="LevelID"
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນຈັດຕັ້ງປະຕິບັດ"
                                    variant="outlined"
                                />
                          
                                <!-- <v-col cols="12" md="12" class="mb-n5">
                                    <v-autocomplete
                                        v-model="province"
                                        prepend-inner-icon="mdi-home-outline"
                                        density="compact"
                                        variant="outlined"
                                        :label="$t('province')"
                                        :items="provinces"
                                        :item-title="
                                            $i18n.locale === 'en'
                                                ? 'ProvinceNameE'
                                                : 'ProvinceNameL'
                                        "
                                        item-value="ProvinceID"
                                        @update:model-value="loadDistrict"
                                    />
                                </v-col> -->
                                <!-- <v-autocomplete
                                    v-model="formRequest.ProvinceID"
                                    :items="provinces"
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນແຂວງ"
                                    variant="outlined"
                                    @update:model-value="loadDistrict"
                                /> -->
                                <!-- select province -->
                                <v-autocomplete
                                    v-model="formRequest.ProvinceID"
                                    :items="provinces"
                                    :rules="
                                        isRuleProvince(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleProvince(
                                            formRequest.LevelID,
                                            true
                                        )
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນແຂວງ"
                                    variant="outlined"
                                    @update:model-value="loadDistrict"
                                />
                                <v-autocomplete
                                    v-model="formRequest.DistrictID"
                                    :rules="
                                        isRuleDistrict(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleDistrict(
                                            formRequest.LevelID,
                                            true
                                        )
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນເມືອງ"
                                    variant="outlined"
                                />
                                <v-autocomplete
                                    v-model="formRequest.VillageID"
                                    :rules="
                                        isRuleVillage(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleVillage(formRequest.LevelID, true)
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນບ້ານ"
                                    variant="outlined"
                                />
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider color="black" />
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        :loading="isLoadingSave"
                        class="ml-2 btn btn-primary"
                        color="primary"
                        @click="createUser"
                    >
                        <i class="fa fa-save"></i>&nbsp;ບັນທຶກຂໍ້ມູນ
                    </v-btn>

                    <div class="btn btn-danger" @click="formDialog = false">
                        <v-icon>mdi-close-circle</v-icon>
                        ປິດໜ້າຕ່າງ
                    </div>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- dialog permission -->
        <v-dialog
            v-model="permissionDialog"
            width="920"
            scrollable=""
            persistent=""
        >
            <v-card>
                <v-card-title class="mt-4">
                    ກຳນົດສິດການເຂົ້າເຖິງໃຫ້ກັບຜູ້ໃຊ້ງານ:
                    <i class="fa fa-user-alt"></i> ( {{ userDetail.UserName }} )
                </v-card-title>

                <v-divider color="black" />
                <v-card-text>
                    <v-tabs v-model="tabSelected" bg-color="primary">
                        <v-tab
                            @click="fetchMenu(tabSelected)"
                            v-for="(item, index) in tabList"
                            :value="item.value"
                            >{{ item.title }}
                        </v-tab>
                    </v-tabs>
                    <v-card-text>
                        <v-window v-model="tabSelected">
                            <v-window-item
                                v-for="(item, index) in tabList"
                                :value="item.value"
                            >
                                <v-table
                                    fixed-header
                                    class="text-no-wrap"
                                    density="compact"
                                >
                                    <thead>
                                        <tr>
                                            <th>ເລືອກ</th>
                                            <th>ເມນູ</th>
                                            <th class="text-center">
                                                ບັນທືກໄດ້
                                            </th>
                                            <th class="text-center">
                                                ແກ້ໄຂ້ໄດ້
                                            </th>
                                            <th class="text-center">ລືບໄດ້</th>
                                            <th class="text-center">ສົ່ງອອກ</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr
                                            v-for="item in menuPermitList"
                                            :key="item.MenuID"
                                        >
                                            <td>
                                                <v-checkbox
                                                    color="primary"
                                                    v-model="
                                                        selectedMenuPermission
                                                    "
                                                    :value="item"
                                                    class="mt-n5"
                                                    hide-details
                                                />
                                            </td>
                                            <td>{{ item.MenuNameL }}</td>
                                            <td class="text-center">
                                                <v-checkbox
                                                    color="blue"
                                                    v-model="item.CanSave"
                                                    class="mt-n5"
                                                    hide-details
                                                />
                                            </td>
                                            <td class="text-center">
                                                <v-checkbox
                                                    color="blue"
                                                    v-model="item.CanEdit"
                                                    class="mt-n5"
                                                    hide-details
                                                />
                                            </td>
                                            <td class="text-center">
                                                <v-checkbox
                                                    color="blue"
                                                    v-model="item.CanDelete"
                                                    class="mt-n5"
                                                    hide-details
                                                />
                                            </td>
                                            <td class="text-center">
                                                <v-checkbox
                                                    color="blue"
                                                    v-model="item.CanExport"
                                                    class="mt-n5"
                                                    hide-details
                                                />
                                            </td>
                                        </tr>
                                    </tbody>
                                </v-table>
                            </v-window-item>
                        </v-window>
                    </v-card-text>
                </v-card-text>
                <v-divider color="black" />
                <v-card-actions>
                    <v-spacer />
                    <div
                        class="btn btn-danger"
                        @click="permissionDialog = false"
                    >
                        <v-icon>mdi-close-circle</v-icon>
                        ປິດໜ້າຕ່າງ
                    </div>
                    <v-btn
                        :loading="isLoadingSave"
                        @click="createPermission"
                        class="ml-2 btn btn-primary"
                        color="primary"
                    >
                        <i class="fa fa-save"></i>&nbsp;ບັນທຶກຂໍ້ມູນ
                    </v-btn>
                </v-card-actions>
            </v-card>
        </v-dialog>

        <!-- dialog form update -->
        <v-dialog v-model="formUpdateDialog" width="840" scrollable="">
            <v-card>
                <v-card-title> ແກ້ໄຂປ້ອນຂໍ້ມູນຜູ້ໃຊ້ງານ </v-card-title>
                <v-divider color="black" />
                <v-card-text>
                    <v-form ref="formUserRef">
                        <v-row>
                            <v-col cols="12">
                                <div class="d-flex align-center">
                                    <v-text-field
                                        v-model="formRequest.UserID"
                                        prepend-inner-icon="mdi-lock"
                                        label="ລະຫັດຜູ້ໃຊ້ງານ"
                                        variant="outlined"
                                        style="width: 60%"
                                        disabled
                                    />
                                    <v-spacer />
                                    <v-checkbox
                                        v-model="formRequest.CanPost"
                                        color="blue"
                                        class="mt-n3"
                                        label="ຢືນຢັ້ນການລົງບັນຊີໄດ້"
                                        style="width: 40%"
                                    />
                                </div>
                                <v-text-field
                                    v-model="formRequest.UserName"
                                    prepend-inner-icon="mdi-account"
                                    :rules="[rules.required]"
                                    label="ຊື່ຜູ້ໃຊ້ງານ"
                                    variant="outlined"
                                />
                                <!-- email -->
                                <v-text-field
                                    v-model="formRequest.Email"
                                    prepend-inner-icon="mdi-email"
                                    label="ອີເມວ"
                                    variant="outlined"
                                    disabled
                                />
                                <v-select
                                    v-model="formRequest.UserAdmin"
                                    prepend-inner-icon="mdi-shield-half-full"
                                    :rules="[rules.required]"
                                    :items="userRoles"
                                    label="ສິດນຳໃຊ້"
                                    variant="outlined"
                                />

                                <v-autocomplete
                                    v-model="formRequest.LevelID"
                                    :items="listLevels"
                                    :rules="[rules.required]"
                                    item-title="levelTitleKeyLa"
                                    item-value="LevelID"
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນຈັດຕັ້ງປະຕິບັດ"
                                    variant="outlined"
                                />
                                <v-autocomplete
                                    v-model="formRequest.ProvinceID"
                                    :rules="
                                        isRuleProvince(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleProvince(
                                            formRequest.LevelID,
                                            true
                                        )
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນແຂວງ"
                                    variant="outlined"
                                />
                                <v-autocomplete
                                    v-model="formRequest.DistrictID"
                                    :rules="
                                        isRuleDistrict(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleDistrict(
                                            formRequest.LevelID,
                                            true
                                        )
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນເມືອງ"
                                    variant="outlined"
                                />
                                <v-autocomplete
                                    v-model="formRequest.VillageID"
                                    :rules="
                                        isRuleVillage(
                                            formRequest.LevelID,
                                            false
                                        )
                                    "
                                    :readonly="
                                        isRuleVillage(formRequest.LevelID, true)
                                    "
                                    prepend-inner-icon="mdi-file-tree"
                                    label="ຂັ້ນບ້ານ"
                                    variant="outlined"
                                />
                            </v-col>
                        </v-row>
                    </v-form>
                </v-card-text>
                <v-divider color="black" />
                <v-card-actions>
                    <v-spacer />
                    <v-btn
                        :loading="isLoadingSave"
                        class="btn btn-primary"
                        color="primary"
                        @click="updateUser"
                    >
                        <i class="fa fa-save"></i>&nbsp;ແກ້ໄຂຂໍ້ມູນ
                    </v-btn>

                    <div
                        class="ml-2 btn btn-danger"
                        @click="formUpdateDialog = false"
                    >
                        <v-icon>mdi-close-circle</v-icon>
                        ປິດໜ້າຕ່າງ
                    </div>
                </v-card-actions>
            </v-card>
        </v-dialog>
    </div>
</template>
<script>
import urlApiPath from "../mixin/urlApiPath";
import {
    swalErrorToast,
    swalSuccess,
    swalWarningToast,
} from "../mixin/swalhelper";
import dataTableShared from "../mixin/dataTableShared";
import levelsMinix from "../mixin/levelsMinix";

const initForm = () => ({
    UserID: "",
    LevelID: "C",
    Email: null,
    ProvinceID: null,
    DistrictID: null,
    VillageID: null,
    UserName: null,
    UserAdmin: "User", // or 1 based on your requirement
    canPost: 0, // or 1 based on your requirement
    UserPWD: null,
    UserPWDConfirm: null,
});
export default {
    props: {
        dataTableTransalate: {},
    },
    name: "UserManage",
    mixins: [urlApiPath, dataTableShared, levelsMinix],
    data() {
        return {
            userRoles: ["User", "Admin"],
            headers: [
                { title: "ລຳດັບ", align: "start", key: "0" },
                { title: "ລະຫັດຜູ້ໃຊ້", align: "start", key: "1" },
                { title: "ຊື່ຜູ້ໃຊ້", align: "end", key: "2" },
                { title: "ສິດນຳໃຊ້", align: "end", key: "3" },
                { title: "ຂັ້ນ", align: "end", key: "4" },
                { title: "ສະຖານທີ່ຈັດຕັ້ງປະຕິບັດ", align: "end", key: "7" },
                { title: "ຢືນຢັ້ນການໂພດ", align: "end", key: "5" },
                { title: "ຈັດການຂໍ້ມູນ", align: "text-center", key: "6" },
            ],
            formDialog: false,
            formUpdateDialog: false,
            userResponseList: [],
            tabSelected: null,
            tabList: [
                { value: 1, title: "ຂໍ້ມູນຫຼັກ", icon: "" },
                { value: 2, title: "ຂໍ້ມູນການເຄືອນໄຫວ", icon: "" },
                { value: 3, title: "ລາຍງານບັນຊີໂຄງານ", icon: "" },
                { value: 4, title: "ລາຍງານບັນຊີ", icon: "" },
                { value: 5, title: "ການຕັ້ງຄ່າ", icon: "" },
            ],
            isLoadingSave: false,
            used: false,
            formRequest: { ...initForm() },
            rules: {
                required: (value) => !!value || "Required.",
                minLength: (value) =>
                    (value && value.length >= 8) || "Min 8 characters.",
                matchPassword: (value, value2) =>
                    value === value2 || "Passwords do not match.",
            },
            isValidate: true,
            desserts: [
                {
                    name: "Frozen Yogurt",
                    calories: 159,
                },
                {
                    name: "Ice cream sandwich",
                    calories: 237,
                },
                {
                    name: "Eclair",
                    calories: 262,
                },
                {
                    name: "Cupcake",
                    calories: 305,
                },
                {
                    name: "Gingerbread",
                    calories: 356,
                },
                {
                    name: "Jelly bean",
                    calories: 375,
                },
                {
                    name: "Lollipop",
                    calories: 392,
                },
                {
                    name: "Honeycomb",
                    calories: 408,
                },
                {
                    name: "Donut",
                    calories: 452,
                },
                {
                    name: "KitKat",
                    calories: 518,
                },
            ],
            menuPermitList: false,
            selectedMenuPermission: [],
            permissionDialog: false,
            userDetail: {},
            provinces: [],
            districts: [],
            villages: [],
        };
    },
    watch: {
        userResponseList: {
            handler() {
                this.$nextTick(() => {
                    // Reload DataTables with new data
                    this.reloadDataTable();
                });
            },
            deep: true,
        },
    },
    mounted() {
        this.fetchAllUser();
        this.fetchMenu(1);
    },
    methods: {
        // onclick update set data to form
        async updateForm(item) {
            this.formRequest = {
                ...item,
                Email: item.email || null,
                UserAdmin: item.UserAdmin === "1" ? "Admin" : "User",
                CanPost: item.CanPost === "1" ? true : false,
            };
            this.formUpdateDialog = true;
            console.log("item", item);
        },
        async fetchAllUser() {
            try {
                await axios
                    .get(this.globalUrlApiPath + `/users/fetch`)
                    .then((res) => {
                        this.userResponseList = res.data;
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍສາມາດເອີ້ນຂໍ້ມູນຜູ້ໃຊ້ງານໄດ້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" +
                        error
                );
            }
        },
        async fetchMenu(tabId) {
            try {
                await axios
                    .get(this.globalUrlApiPath + `/users/menu/${tabId}`)
                    .then((res) => {
                        this.menuPermitList = res.data.map((item) => ({
                            ...item,
                            MainAction: true,
                            CanMain: false,
                            CanEdit: false,
                            CanSave: false,
                            CanDelete: false,
                            CanExport: false,
                        }));
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນ menu ໄດ້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" + error
                );
            }
        },
        async createUser() {
            const { valid } = await this.$refs.formUserRef.validate();
            if (!valid) {
                return;
            }
            this.isLoadingSave = true;
            try {
                await axios
                    .post(
                        this.globalUrlApiPath + `/users/create`,
                        this.formRequest
                    )
                    .then((res) => {
                        if (res.data.is_success) {
                            swalSuccess("ສຳເລັດແລ້ວ");
                            this.fetchAllUser();
                            this.formRequest = { ...initForm() };
                            this.isLoadingSave = false;
                        } else {
                            swalWarningToast(
                                "ຜິດພາດ!",
                                "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!"
                            );

                            this.isLoadingSave = false;
                        }
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" + error
                );
            }
            this.isLoadingSave = false;
        },

        async updateUser() {
            const { valid } = await this.$refs.formUserRef.validate();
            if (!valid) {
                return;
            }
            this.isLoadingSave = true;
            try {
                await axios
                    .put(
                        this.globalUrlApiPath +
                            `/users/update/${this.formRequest.UserID}`,
                        this.formRequest
                    )
                    .then((res) => {
                        if (res.data.is_success) {
                            swalSuccess("ສຳເລັດແລ້ວ");
                            this.fetchAllUser();
                            this.formRequest = { ...initForm() };
                            this.isLoadingSave = false;
                        } else {
                            swalWarningToast(
                                "ຜິດພາດ!",
                                "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!"
                            );

                            this.isLoadingSave = false;
                        }
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" + error
                );
            }
            this.isLoadingSave = false;
        },

        async createPermission() {
            this.isLoadingSave = true;
            try {
                const payload = this.selectedMenuPermission.map((item) => ({
                    UserID: this.userDetail?.UserID,
                    LevelID: this.userDetail?.LevelID,
                    MenuID: item.MenuID,
                    MenuAction: item.MenuAction,
                    CanEdit: item.CanEdit,
                    CanSave: item.CanSave,
                    CanExport: item.CanExport,
                    CanDelete: item.CanDelete,
                }));
                await axios
                    .post(this.globalUrlApiPath + `/users/permit-menu`, payload)
                    .then((res) => {
                        console.log(res);
                        if (res.data.is_success) {
                        } else {
                            swalWarningToast(
                                "ຜິດພາດ!",
                                "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!"
                            );
                        }
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍສາມາດສ້າງໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" + error
                );
            }
            this.isLoadingSave = false;
        },

        async deleteUser(item) {
            this.isLoadingSave = true;
            // create function to delete user
            try {
                await axios
                    .delete(
                        this.globalUrlApiPath + `/users/delete/${item.Rec_Cnt}`
                    )
                    .then((res) => {
                        if (res.status === 200) {
                            swalSuccess("ສຳເລັດແລ້ວ");
                            this.fetchAllUser();
                        } else {
                            swalWarningToast(
                                "ຜິດພາດ!",
                                "ບໍສາມາດລຶບໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!"
                            );
                        }
                    });
            } catch (error) {
                swalErrorToast(
                    "ຜິດພາດ!",
                    "ບໍສາມາດລຶບໄດ້້, ກາລຸນາລອງໃໝ່ອີກຄັ້ງ!" + error
                );
            }
        },

        //
        openPermissionDialog(item) {
            this.userDetail = item;
            this.permissionDialog = true;
        },
        reloadDataTable() {
            this.initDatable("user-table");
        },

        async loadProvince() {
            try {
                await axios
                    .get(this.globalUrlApiPath + `/province/province-api`)
                    .then((res) => {
                        if (res.status === 200) {
                            this.provinces = res.data ?? [];
                        }
                    });
            } catch (error) {
                swalErrorToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນແຂວງໄດ້!");
            }
        },

        async loadDistrict() {
            try {
                let res;
                //const provinceId = ['V','D','P'].some((x)=>x === this.store.level) ? this.store.province : null;
                const provinceId = this.store.province;

                if (provinceId !== null) {
                    res = await axios.get(
                        `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/districts`
                    );
                }
                if (res.data !== null) {
                    this.districts = res.data.filter(
                        (x) => x.ProvinceID === provinceId
                    );
                }
                await this.loadVillage();
            } catch (error) {
                swalErrorToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນເມືອງໄດ້!");
            }
        },

        async loadVillage() {
            try {
                let res;

                if (this.store.district !== null) {
                    res = await axios.get(
                        `${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/villages`
                    );
                }
                if (res.data !== null) {
                    this.villages = res.data.filter(
                        (x) => x.DistrictID === this.store.district
                    );
                }
            } catch (error) {
                swalErrorToast("ຜິດພາດ!", "ບໍ່ສາມາດເອີ້ນຂໍ້ມູນບ້ານໄດ້!");
            }
        },
    },
};
</script>
<style scoped></style>
