<template>
  <div>

    <activity :product="product" :user="user" />

  </div>
</template>

<script>

import Activity from '../product/components/ProductActivity';
import Resource from '@/api/resource';

const itemResource = new Resource('product');

export default {
  name: 'EditUser',
  components: { Activity },
  data() {
    return {
      product: {},
      user: {},
    };
  },
  watch: {
    $route: 'getItem',
  },
  created() {
    var id = this.$route.params && this.$route.params.id;
    id += '?dashboard_stats=true';
    this.getItem(id);
  },
  methods: {
    async getItem(id) {
      const response = await itemResource.get(1);
      this.product = response.data;
      this.user = response.data.user;
    },
  },
};
</script>
