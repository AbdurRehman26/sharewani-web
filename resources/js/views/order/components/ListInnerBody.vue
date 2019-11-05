<template>
  <div>

    <el-table
      v-loading="isLoading"
      :data="items"
      border
      fit
      highlight-current-row
      style="width: 100%"
    >
      <el-table-column align="center" label="PRODUCT DESCRIPTION">
        <template slot-scope="scope">
          <span>{{ scope.row.product.description ? scope.row.product.description : 'N/A' }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="PRODUCT IMAGE">
        <template slot-scope="scope">
          <img height="65" :src="scope.row.product.images[0]">
        </template>
      </el-table-column>

      <el-table-column align="center" label="PLACED BY">
        <template slot-scope="scope">
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>
      <el-table-column align="center" label="STATUS">
        <template slot-scope="scope">
          <el-tag :type="scope.row.order_status | statusFilter">
            {{ scope.row.order_status }}
          </el-tag>
        </template>
      </el-table-column>

      <el-table-column align="center" label="RENT">
        <template slot-scope="scope">
          {{ scope.row.rent_amount }}
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
          <el-button
            v-if="scope.row.status === 0"
            type="success"
            size="small"
            icon="el-icon-edit"
            @click.prevent="
              dialogFormVisible = true;
              confirmationType = 'accept';
              currentItemId = scope.row.id;
            "
          >
            Accept
          </el-button>
          <el-button
            v-if="scope.row.status === 0"
            type="danger"
            size="small"
            icon="el-icon-edit"
            @click.prevent="
              dialogFormVisible = true;
              confirmationType = 'reject';
              currentItemId = scope.row.id;
            "
          >
            Reject
          </el-button>

          <router-link :to="'/order/edit/' + scope.row.id">
            <el-button type="warning" size="small" icon="el-icon-eye">
              View
            </el-button>
          </router-link>
        </template>
      </el-table-column>
    </el-table>

    <el-dialog :title="'Confirm'" :visible.sync="dialogFormVisible">
      <div v-loading="isLoading" class="form-container">
        <div class="margin-bottom-40">
          Are you sure you want to {{ confirmationType }} this order?
        </div>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <el-button type="primary" @click="submitOrderRequest">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </div>
    </el-dialog>

    <pagination
      v-show="query.total > 0"
      :total="query.total"
      :page.sync="query.page"
      :limit.sync="query.limit"
      @pagination="$emit('reload-list')"
    />

  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import OrderResource from '@/api/order';

const itemResource = new OrderResource();
export default {
  name: 'UserList',
  components: { Pagination },
  filters: {
    statusFilter(status) {
      const statusMap = {
        success: 'success',
        pending: 'warning',
        rejected: 'danger',
      };
      return statusMap[status];
    },
  },
  props: {
    loading: {

    },
    query: {
      type: Object,
      default: () => {
        return {};
      },
    },
    items: {
      type: Array,
      default: () => {
        return [];
      },
    },
  },
  data() {
    return {
      currentItemId: null,
      confirmationType: '',
      total: 0,
      isLoading: true,
      downloading: false,
      userCreating: false,
      dialogFormVisible: false,
      rules: {
        name: [
          { required: true, message: 'Name is required', trigger: 'blur' },
        ],
      },
    };
  },
  computed: {},
  watch: {
    loading() {
      this.isLoading = false;
    },

    items(){
      this.isLoading = false;
    },
  },
  created() {
    this.isLoading = !this.loading;

    if (this.items.length){
      this.isLoading = false;
    }
  },
  methods: {
    async submitOrderRequest() {
      this.isLoading = true;
      if (this.confirmationType === 'reject') {
        this.query.status = -1;
      } else {
        this.query.status = 1;
      }
      await itemResource.updateOrder(this.currentItemId, this.query);

      this.dialogFormVisible = false;

      this.$emit('reload-list');

      this.isLoading = false;
    },
  },
};
</script>

<style>
	.order-container .el-dialog{
		width: 25%;
	}
</style>
