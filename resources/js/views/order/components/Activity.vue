<template>
  <el-card v-if="item.product">

    <list-inner-body class="order-container" :query="query" :items="items" />

  </el-card>
</template>

<script>
import ListInnerBody from './ListInnerBody';

export default {

  components: { ListInnerBody },
  props: {
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
        total: 10,
        page: 1,
        limit: 15,
        keyword: '',
      },
      updating: false,
    };
  },
  methods: {
    onSubmit() {},
  },
};
</script>

<style lang="scss" scoped></style>
