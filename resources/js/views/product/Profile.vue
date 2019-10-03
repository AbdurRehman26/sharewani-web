<template>
  <div class="app-container">
    <el-form v-if="user" :model="user">
      <el-row :gutter="20">
        <el-col :span="6">
          <product-user-card :product="product" :user="user" />
        </el-col>
        <el-col :span="18">
          <product-activity :product="product" :user="user" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import Resource from '@/api/resource';
import ProductUserCard from './components/ProductUserCard';
import ProductActivity from './components/ProductActivity';

const itemResource = new Resource('product');
export default {
  name: 'EditUser',
  components: { ProductUserCard, ProductActivity },
  data() {
    return {
      product: {},
      user: {},
    };
  },
  watch: {
    '$route': 'getItem',
  },
  created() {
    var id = this.$route.params && this.$route.params.id;
    id += '?dashboard_stats=true';
    this.getItem(id);
  },
  methods: {
    async getItem(id) {
      const response = await itemResource.get(id);
      this.product = response.data;
      this.user = response.data.user;
    },
  },
};
</script>
