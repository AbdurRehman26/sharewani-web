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

    </el-tabs>

  </el-card>
</template>

<script>
import LogoPanel from './components/LogoPanel.vue';
import FooterPanel from './components/FooterPanel.vue';
import MainPageBanner from './components/MainPageBanner.vue';

export default {
  components: { LogoPanel, MainPageBanner, FooterPanel },
  props: {},
  data() {
    return {
      activeActivity: 'third',
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
