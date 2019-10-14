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

      <el-table-column align="center" label="Title">
        <template slot-scope="scope">
          <span>{{ scope.row.title }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="USER">
        <template slot-scope="scope">
          <span>{{ scope.row.user.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="EVENT">
        <template slot-scope="scope">
          <span v-for="(event, index) in scope.row.events" :key="index">{{
            event.name
          }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="CATEGORY">
        <template slot-scope="scope">
          <span
            v-for="(category, index) in scope.row.categories"
            :key="index"
          >{{ category.name }}
          </span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="UPLOADED AT">
        <template slot-scope="scope">
          <span>{{ scope.row.formatted_created_at }}</span>
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

    <el-dialog :title="'Create new product'" :visible.sync="dialogFormVisible">
      <div v-loading="userCreating" class="form-container">
        <el-form
          ref="userForm"
          :rules="rules"
          :model="newItem"
          label-position="left"
          label-width="150px"
          style="max-width: 850px;"
        >
          <el-form-item :label="$t('product.title')" prop="title">
            <el-input v-model="newItem.title" style="max-width : 200px;" />
          </el-form-item>

          <el-form-item :label="$t('product.original_price')" prop="original_price">
            <el-input v-model="newItem.original_price" type="number" style="max-width : 200px;" />
          </el-form-item>

          <el-form-item :label="$t('product.fabric_age')" prop="fabric_age">
            <el-select
              v-model="newItem.fabric_age_id"
              class="filter-item"
              placeholder="Please select fabric age"
            >
              <el-option
                v-for="fabricAge in fabricAges"
                :key="fabricAge.id"
                :label="fabricAge.name"
                :value="fabricAge.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('product.size')" prop="role">

            <el-select
              v-model="newItem.size_id"
              class="filter-item"
              placeholder="Please select size"
            >
              <el-option
                v-for="sizeOption in sizeOptions"
                :key="sizeOption.id"
                :label="sizeOption.name"
                :value="sizeOption.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item :label="$t('product.color')" prop="role">

            <el-select
              v-model="newItem.color_id"
              class="filter-item"
              placeholder="Please select color"
            >
              <el-option
                v-for="colorOption in colorOptions"
                :key="colorOption.id"
                :label="colorOption.name"
                :value="colorOption.id"
              />
            </el-select>

          </el-form-item>

          <el-form-item :label="$t('product.event')" prop="role">

            <multiselect
              v-model="newItem.events"
              class="multiselect"
              :multiple="true"
              label="name"
              track-by="id"
              :options="events"
            />

          </el-form-item>

          <el-form-item :label="$t('product.category')" prop="role">

            <multiselect
              v-model="newItem.categories"
              class="multiselect"
              :multiple="true"
              label="name"
              track-by="id"
              :options="categories"
            />

          </el-form-item>

          <el-form-item :label="$t('product.brand')" prop="role">
            <el-select
              v-model="newItem.brand_id"
              class="filter-item"
              placeholder="Please select brand"
            >
              <el-option
                v-for="brand in brands"
                :key="brand.id"
                :label="brand.name | uppercaseFirst"
                :value="brand.id"
              />
            </el-select>
          </el-form-item>

          <el-form-item>
            <div class="components-container">
              <div class="editor-container">
                <dropzone
                  id="myVueDropzone"
                  url="api/file/upload"
                  @dropzone-removedFile="dropzoneR"
                  @dropzone-success="dropzoneS"
                />
              </div>
            </div>
          </el-form-item>
        </el-form>
        <div slot="footer" class="dialog-footer">
          <el-button @click="dialogFormVisible = false">
            {{ $t('table.cancel') }}
          </el-button>
          <el-button type="primary" @click="createItem()">
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
import Dropzone from '@/components/Dropzone';
import Multiselect from 'vue-multiselect';
const itemResource = new Resource('product');
const categoryResource = new Resource('category');
const eventResource = new Resource('event');
const brandResource = new Resource('brand');
const sizeResource = new Resource('size');
const colorResource = new Resource('color');
const fabricAgeResource = new Resource('fabric-age');

const fileResource = new Resource('file/remove');

export default {
  name: 'UserList',
  components: { Pagination, Dropzone, Multiselect },
  directives: { waves },
  data() {
    return {
      selected: null,
      colorOptions: [],
      sizeOptions: [],
      brands: [],
      fabricAges: [],
      categories: [],
      events: [],
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
      newItem: {},
      dialogFormVisible: false,
      rules: {
        title: [
          { required: true, message: 'Title is required', trigger: 'blur' },
        ],
        category: [
          { required: true, message: 'Category is required', trigger: 'blur' },
        ],
        event: [
          { required: true, message: 'Event is required', trigger: 'blur' },
        ],
      },
    };
  },
  computed: {},
  created() {
    this.resetNewItem();
    this.getList();
    this.getOptionsList();
  },
  methods: {
    getOptionsList(){
      this.getCategoryList();
      this.getEventList();
      this.getBrandList();
      this.getColorList();
      this.getSizeList();
      this.getFabricAgeList();
    },
    dropzoneS(file) {
      if (file && file.xhr && file.xhr.response){
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.images.push(uploadedFile.name);
      }

      this.$message({ message: 'Upload success', type: 'success' });
    },
    dropzoneR(file) {
      if (file && file.xhr && file.xhr.response){
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.images.splice(this.newItem.images.indexOf(uploadedFile.name));

        const fileData = {
          file_name: uploadedFile.name,
        };

        fileResource.store(fileData);
      }

      this.$message({ message: 'Delete success', type: 'success' });
    },
    async getFabricAgeList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await fabricAgeResource.list(this.query);

      this.fabricAges = response.data;
      this.fabricAges.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
    async getColorList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await colorResource.list(this.query);

      this.colorOptions = response.data;
      this.colorOptions.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
    async getSizeList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await sizeResource.list(this.query);

      this.sizeOptions = response.data;
      this.sizeOptions.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
    async getBrandList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await brandResource.list(this.query);

      this.brands = response.data;
      this.brands.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
    async getCategoryList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await categoryResource.list(this.query);

      this.categories = response.data;
      this.categories.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
    async getEventList() {
      const { limit, page } = this.query;
      this.loading = true;

      const response = await eventResource.list(this.query);

      this.events = response.data;
      this.events.forEach((element, index) => {
        element['index'] = (page - 1) * limit + index + 1;
      });
      this.loading = false;
    },
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
      this.resetNewItem();
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
    createItem() {
      this.$refs['userForm'].validate(valid => {
        if (valid) {
          this.userCreating = true;
          itemResource
            .store(this.newItem)
            .then(response => {
              this.$message({
                message:
                  'New user ' +
                  this.newItem.title +
                  '(' +
                  this.newItem.event +
                  ') has been created successfully.',
                type: 'success',
                duration: 5 * 1000,
              });
              this.resetNewItem();
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
    resetNewItem() {
      this.newItem = {
        title: '',
        category: null,
        event: null,
        images: [],
        original_price: 0,
        number_of_items: 0,
        fabric_age_id: 1,
        brand_id: 1,
        color_id: 1,
        size_id: 1,
      };
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style lang="scss" scoped>
.multiselect{
  width : 200px
}
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
