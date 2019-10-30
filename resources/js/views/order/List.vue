<template>
  <div class="app-container">
    <div class="filter-container">
      <el-input
        v-model="query.keyword"
        :placeholder="$t('table.keyword')"
        style="width: 200px;"
        class="filter-item"
        @keyup.enter.native="handleFilter"
      />
      <el-button
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >
        {{ $t('table.search') }}
      </el-button>
    </div>

    <list-inner-body :query="query" :items="items" />
  </div>
</template>

<script>
import ListInnerBody from './components/ListInnerBody';
import Resource from '@/api/resource';

const itemResource = new Resource('order');

export default {
  name: 'OrderList',
  components: { ListInnerBody },
  data() {
    return {
      reloadList: false,
      items: [],
      query: {
        total: 0,
        page: 1,
        limit: 15,
        keyword: '',
      },
    };
  },
  computed: {},
  watch: {
    reloadList(){
      this.getList();
    },
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await itemResource.list(this.query);

      this.items = response.data;
      this.items.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.query.total = 10;
      this.loading = false;
    },

    handleFilter() {
      this.query.page = 1;
    },
  },
};
</script>

<style lang="scss" scoped>
.dialog-footer {
  text-align: left;
  padding-top: 0;
}
.app-container {
  flex: 1;
  justify-content: space-between;
  font-size: 14px;
  padding-right: 8px;
  .block {
    float: left;
    min-width: 250px;
  }
  .clear-left {
    clear: left;
  }
}
</style>
