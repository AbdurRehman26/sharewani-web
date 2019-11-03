<template>
  <div class="app-container">
    <el-form>
      <el-row :gutter="20">
        <el-col :span="6">
          <item-card :item="item" :items="items" />
          <item-bio :item="item" />
        </el-col>
        <el-col :span="18">
          <item-activity :loading="loading" :item="item" :items="items" @reload-list="loadList" />
        </el-col>
      </el-row>
    </el-form>
  </div>
</template>

<script>
import OrderResource from '@/api/order';
import ItemBio from './components/Bio';
import ItemCard from './components/Card';
import ItemActivity from './components/Activity';
const itemResource = new OrderResource();
export default {
  name: 'EditUser',
  components: { ItemBio, ItemCard, ItemActivity },
  data() {
    return {
      reloadList: false,
      item: {},
      items: [],
      loading: false,
    };
  },
  watch: {
    $route: 'getListOfOrders',
    reloadList(){
      this.getListOfOrders(this.$route.params.id);
      this.getSingle(this.$route.params.id);
    },
  },
  created() {
    this.loadList();
  },
  methods: {
    loadList(){
      const id = this.$route.params && this.$route.params.id;
      this.getListOfOrders(id);
      this.getSingle(id);
    },
    async getSingle(id) {
      const { data } = await itemResource.get(id);
      this.item = data;
    },
    async getListOfOrders(id) {
      const { data } = await itemResource.getCollidingOrders(id);
      this.loading = !this.loading;
      this.items = data;
    },
  },
};
</script>
