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
        v-waves
        class="filter-item"
        type="primary"
        icon="el-icon-search"
        @click="handleFilter"
      >
        {{ $t('table.search') }}
      </el-button>

    </div>

    <el-table
      v-loading="loading"
      :data="list"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column align="center" label="ID" width="80">
        <template slot-scope="scope">
          <span>{{ scope.row.index }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="PRODUCT">
        <template slot-scope="scope">
          <span>{{ scope.row.product.title }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="PLACED BY">
        <template slot-scope="scope">
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="NUMBER OF ITEMS">
        <template slot-scope="scope">
          <span>{{ scope.row.number_of_items }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="STATUS">
        <template slot-scope="scope">
          <span>{{ scope.row.order_status }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="FROM">
        <template slot-scope="scope">
          <span>{{ scope.row.from_date }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="TO">
        <template slot-scope="scope">
          <span>{{ scope.row.to_date }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">

          <router-link :to="'/product/edit/' + scope.row.id">
            <el-button type="warning" size="small" icon="el-icon-edit">
              View
            </el-button>
          </router-link>

        </template>
      </el-table-column>
    </el-table>

    <pagination
      v-show="total > 0"
      :total="total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="getList"
    />

  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive

const itemResource = new Resource('order');

export default {
  name: 'UserList',
  components: { Pagination },
  directives: { waves },
  data() {
    return {
      list: null,
      total: 0,
      loading: true,
      downloading: false,
      userCreating: false,
      query: {
        page: 1,
        limit: 15,
        keyword: '',
      },
      dialogFormVisible: false,
      rules: {
        name: [
          { required: true, message: 'Name is required', trigger: 'blur' },
        ],
      },
    };
  },
  computed: {},
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await itemResource.list(this.query);

      this.list = response.data;
      this.list.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.total = 10;
      this.loading = false;
    },
    handleFilter() {
      this.query.page = 1;
      this.getList();
    },
  },
};
</script>

<style lang="scss" scoped>
.edit-input {
  padding-right: 100px;
}
.cancel-btn {
  position: absolute;
  right: 15px;
  top: 10px;
}
.dialog-footer {
  text-align: left;
  padding-top: 0;
  margin-left: 150px;
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
