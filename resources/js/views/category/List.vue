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
      <el-button
        class="filter-item"
        style="margin-left: 10px;"
        type="primary"
        icon="el-icon-plus"
        @click="handleCreate"
      >
        {{ $t('table.add') }}
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

      <el-table-column align="center" label="Name">
        <template slot-scope="scope">
          <span>{{ scope.row.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="Actions" width="350">
        <template slot-scope="scope">
          <router-link :to="'/category/edit/' + scope.row.id">
            <el-button type="primary" size="small" icon="el-icon-edit">
              Edit
            </el-button>
          </router-link>

          <el-button
            type="danger"
            size="small"
            icon="el-icon-delete"
            @click="handleDelete(scope.row.id, scope.row.name)"
          >
            Delete
          </el-button>
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

    <el-dialog :title="'Create new user'" :visible.sync="dialogFormVisible">
      <div v-loading="userCreating" class="form-container">
        <el-form
          ref="userForm"
          :rules="rules"
          :model="newUser"
          label-position="left"
          label-width="150px"
          style="max-width: 500px;"
        >
          <el-form-item :label="$t('user.role')" prop="role">
            <el-select
              v-model="newUser.role"
              class="filter-item"
              placeholder="Please select role"
            >
              <el-option
                v-for="item in nonAdminRoles"
                :key="item"
                :label="item | uppercaseFirst"
                :value="item"
              />
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('user.name')" prop="name">
            <el-input v-model="newUser.name" />
          </el-form-item>
          <el-form-item :label="$t('user.email')" prop="email">
            <el-input v-model="newUser.email" />
          </el-form-item>
          <el-form-item :label="$t('user.password')" prop="password">
            <el-input v-model="newUser.password" show-password />
          </el-form-item>
          <el-form-item
            :label="$t('user.confirmPassword')"
            prop="confirmPassword"
          >
            <el-input v-model="newUser.confirmPassword" show-password />
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <el-button type="primary" @click="createUser()">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </div>
    </el-dialog>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination'; // Secondary package based on el-pagination
import Resource from '@/api/resource';
import waves from '@/directive/waves'; // Waves directive

const itemResource = new Resource('category');

export default {
  name: 'UserList',
  components: { Pagination },
  directives: { waves },
  data() {
    var validateConfirmPassword = (rule, value, callback) => {
      if (value !== this.newUser.password) {
        callback(new Error('Password is mismatched!'));
      } else {
        callback();
      }
    };
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
        role: '',
      },
      roles: ['admin', 'manager', 'editor', 'user', 'visitor'],
      nonAdminRoles: ['editor', 'user', 'visitor'],
      newUser: {},
      dialogFormVisible: false,
      currentUserId: 0,
      currentUser: {
        name: '',
      },
      rules: {
        role: [
          { required: true, message: 'Role is required', trigger: 'change' },
        ],
        name: [
          { required: true, message: 'Name is required', trigger: 'blur' },
        ],
        email: [
          { required: true, message: 'Email is required', trigger: 'blur' },
          {
            type: 'email',
            message: 'Please input correct email address',
            trigger: ['blur', 'change'],
          },
        ],
        password: [
          { required: true, message: 'Password is required', trigger: 'blur' },
        ],
        confirmPassword: [
          { validator: validateConfirmPassword, trigger: 'blur' },
        ],
      },
    };
  },
  computed: {},
  created() {
    this.resetNewUser();
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
    handleCreate() {
      this.resetNewUser();
      this.dialogFormVisible = true;
      this.$nextTick(() => {
        this.$refs['userForm'].clearValidate();
      });
    },
    handleDelete(id, name) {
      this.$confirm(
        'This will permanently delete user ' + name + '. Continue?',
        'Warning',
        {
          confirmButtonText: 'OK',
          cancelButtonText: 'Cancel',
          type: 'warning',
        }
      )
        .then(() => {
          itemResource
            .destroy(id)
            .then(response => {
              this.$message({
                type: 'success',
                message: 'Delete completed',
              });
              this.handleFilter();
            })
            .catch(error => {
              console.log(error);
            });
        })
        .catch(() => {
          this.$message({
            type: 'info',
            message: 'Delete canceled',
          });
        });
    },
    createUser() {
      this.$refs['userForm'].validate(valid => {
        if (valid) {
          this.newUser.roles = [this.newUser.role];
          this.userCreating = true;
          itemResource
            .store(this.newUser)
            .then(response => {
              this.$message({
                message:
                  'New user ' +
                  this.newUser.name +
                  '(' +
                  this.newUser.email +
                  ') has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.resetNewUser();
              this.dialogFormVisible = false;
              this.handleFilter();
            })
            .catch(error => {
              console.log(error);
            })
            .finally(() => {
              this.userCreating = false;
            });
        } else {
          console.log('error submit!!');
          return false;
        }
      });
    },
    resetNewUser() {
      this.newUser = {
        name: '',
        email: '',
        password: '',
        confirmPassword: '',
        role: 'user',
      };
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
