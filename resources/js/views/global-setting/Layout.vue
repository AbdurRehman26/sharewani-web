<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Logos" name="first">

        <logo-panel />

      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import LogoPanel from './components/LogoPanel.vue';

export default {
  components: { LogoPanel },
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
