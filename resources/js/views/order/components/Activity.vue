<template>
  <el-card v-if="item.product">

    <h4>Order:</h4>

    <list-inner-body class="order-container" :query="query" :items="[item]" />

    <hr>
    <hr>
    <hr>
    <hr>

    <h4>Colliding Orders:</h4>

    <list-inner-body class="order-container" :loading="loading" :query="query" :items="items" />

  </el-card>
</template>

<script>
import ListInnerBody from './ListInnerBody';

export default {

  components: { ListInnerBody },
  props: {
    loading: {

    },
    items: {
      type: Array,
      default: () => {
        return [];
      },
    },
    item: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          roles: [],
        };
      },
    },
  },
  data() {
    return {
      query: {
        total: 0,
        page: 1,
        limit: 15,
        keyword: '',
      },
      updating: false,
    };
  },
  watch: {
    loading(){

    },
  },
  mounted(){
  },
  methods: {
    onSubmit() {},
  },
};
</script>

<style lang="scss" scoped></style>
