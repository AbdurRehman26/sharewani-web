<template>
  <el-card v-if="item.product" class="box-card user-bio">
    <div slot="header" class="clearfix">
      <span>{{ item.product.description ? item.product.description : 'N/A' }}</span>
    </div>

    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <span>Price: </span>
        <span>{{ item.product.original_price }}</span>
      </div>
    </div>
    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <span>Brand: </span>
        <span>{{ item.product.brand.name }}</span>
      </div>
    </div>
    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <span>Color: </span>
        <span>{{ item.product.color.name }}</span>
      </div>
    </div>
    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <span>Size: </span>
        <span>{{ item.product.size.name }}</span>
      </div>
    </div>
    <div class="user-education user-bio-section">
      <div class="user-bio-section-header">
        <span>Vendor: </span>
        <span>{{ item.product.vendor[0].name }}</span>
      </div>
    </div>

  </el-card>
</template>

<script>
export default {
  props: {
    item: {
      type: Object,
      default: () => {
        return {};
      },
    },
  },
};
</script>

<style lang="scss" scoped>
.user-bio {
  margin-top: 20px;
  color: #606266;
  span {
    padding-left: 4px;
  }
  .user-bio-section {
    font-size: 14px;
    padding: 15px 0;
    .user-bio-section-header {
      border-bottom: 1px solid #dfe6ec;
      padding-bottom: 10px;
      margin-bottom: 10px;
      font-weight: bold;
    }
  }
}
</style>
