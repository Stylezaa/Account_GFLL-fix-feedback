<template>
<div>
  <li class="menu-item">
      <button type="submit" class="menu-link" data-language="en" @click="switchLanguage('en')">
        <i class="menu-icon tf-icons fi fi-us fis rounded-circle fs-4 me-1"></i> &nbsp;
        <span class="align-middle">English</span>
      </button>
  </li>
  <li class="menu-item">
      <button type="submit" class="menu-link" data-language="la" @click="switchLanguage('la')">
        <i class="menu-icon tf-icons fi fi-la fis rounded-circle fs-4 me-1"></i> &nbsp;
        <span class="align-middle">ພາສາລາວ</span>
      </button>
  </li>
</div>
</template>

<script>
export default {
  methods: {
    switchLanguage(key) {
      this.$i18n.locale = key;
      this.$inertia.get(`${process.env.MIX_APP_URL}:${process.env.MIX_APP_PORT}/lang/${key}`);
    },
  },
}
</script>
