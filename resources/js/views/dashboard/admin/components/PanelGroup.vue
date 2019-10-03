<template>
  <el-row :gutter="40" class="panel-group">

    <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col">

      <KPIChart />

    </el-col>

    <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col">

      <KPIChart />

    </el-col>

    <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col">

      <KPIChart />

    </el-col>

    <el-col :xs="12" :sm="12" :lg="6" class="card-panel-col">

      <KPIChart />

    </el-col>

  </el-row>
</template>

<script>
import KPIChart from './KPIChart';

export default {
  components: {
    KPIChart,
  },
  methods: {
  },
};
</script>

<style rel="stylesheet/scss" lang="scss" scoped>
.panel-group {
  margin-top: 18px;
  .card-panel-col{
    margin-bottom: 32px;
  }
}
</style>
