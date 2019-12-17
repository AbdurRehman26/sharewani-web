<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">

      <el-tab-pane label="Logos" name="first">

        <logo-panel />

      </el-tab-pane>

      <el-tab-pane label="Main Page Banner" name="second">

        <main-page-banner />

      </el-tab-pane>

      <el-tab-pane label="Footer" name="third">

        <footer-panel />

      </el-tab-pane>

      <el-tab-pane label="Terms of Services" name="forth">

        <terms-panel />

      </el-tab-pane>

      <el-tab-pane label="Privacy Policy" name="fifth">

        <privacy-panel />

      </el-tab-pane>

    </el-tabs>

  </el-card>
</template>

<script>
import LogoPanel from './components/LogoPanel.vue';
import FooterPanel from './components/FooterPanel.vue';
import TermsPanel from './components/TermsPanel.vue';
import PrivacyPanel from './components/PrivacyPanel.vue';
import MainPageBanner from './components/MainPageBanner.vue';

export default {
  components: { TermsPanel, LogoPanel, MainPageBanner, FooterPanel, PrivacyPanel },
  props: {},
  data() {
    return {
      activeActivity: 'first',
    };
  },
  created(){},
  methods: {
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    onSubmit() {},
  },
};
</script>

<style lang="scss" scoped>
</style>
