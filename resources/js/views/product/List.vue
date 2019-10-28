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

      <el-select
        v-model="query.brand_id"
        :placeholder="$t('product.brand')"
        clearable
        style="width: 120px; margin-left: 10px;"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in brands"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        />
      </el-select>

      <el-select
        v-model="query.fabric_brand_id"
        :placeholder="$t('product.fabric_brand')"
        clearable
        style="width: 120px; margin-left: 10px;"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in brands"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        />
      </el-select>

      <el-select
        v-model="query.fabric_age_id"
        :placeholder="$t('product.fabric_age')"
        clearable
        style="width: 120px; margin-left: 10px;"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in fabricAges"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        />
      </el-select>

      <el-select
        v-model="query.size_id"
        :placeholder="$t('product.size')"
        clearable
        style="width: 120px; margin-left: 10px;"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in sizeOptions"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        />
      </el-select>

      <el-select
        v-model="query.color_id"
        :placeholder="$t('product.color')"
        clearable
        style="width: 120px; margin-left: 10px;"
        class="filter-item"
        @change="handleFilter"
      >
        <el-option
          v-for="item in colorOptions"
          :key="item.id"
          :label="item.name"
          :value="item.id"
        />
      </el-select>
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

      <el-table-column align="center" label="IMAGE">
        <template slot-scope="scope">
          <img height="65" :src="scope.row.image_paths[0]">
        </template>
      </el-table-column>

      <el-table-column align="center" label="DESCRIPTION">
        <template slot-scope="scope">
          <span v-html="scope.row.description" />
        </template>
      </el-table-column>

      <el-table-column align="center" label="ORIGINAL PRICE">
        <template slot-scope="scope">
          <span>{{ scope.row.original_price }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="COLOR">
        <template slot-scope="scope">
          <span>{{ scope.row.color.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="SIZE">
        <template slot-scope="scope">
          <span>{{ scope.row.size.name }} ({{ scope.row.size_length + ', ' + scope.row.size_chest + ', ' +scope.row.size_sleeves + ', '+ scope.row.size_tummy + ', '+ scope.row.size_collar }})</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="BRAND">
        <template slot-scope="scope">
          <span>{{ scope.row.brand.name }}</span>
        </template>
      </el-table-column>

      <el-table-column align="center" label="FABRIC BRAND">
        <template slot-scope="scope">
          <span>{{ scope.row.fabric_brand ? scope.row.fabric_brand.name : '' }}</span>
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

      <el-table-column align="center" label="Vender">
        <template slot-scope="scope">
          <span>{{ scope.row.vendor.name }}</span>
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
            <el-button type="warning" size="small" icon="el-icon-eye">
              View
            </el-button>
          </router-link>

          <el-button type="blue" size="small" icon="el-icon-edit" @click="newItem = scope.row; dialogFormVisible = true;">
            Edit
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
          <el-form-item :label="$t('product.description')" prop="title">
            <markdown-editor
              ref="markdownEditor"
              v-model="newItem.description"
              height="300px"
            />
          </el-form-item>

          <el-form-item
            :label="$t('product.original_price')"
            prop="original_price"
          >
            <el-input
              v-model="newItem.original_price"
              type="number"
              style="max-width : 200px;"
            />
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

          <el-form-item class="product-size-fields" :label="$t('product.size')" prop="role">
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

            <el-form-item
              label="Length"
              prop="size_length"
            >
              <el-input
                v-model="newItem.size_length"
                type="number"
                style="max-width : 80px;"
              />
            </el-form-item>

            <el-form-item
              label="Chest"
              prop="size_chest"
            >

              <el-input
                v-model="newItem.size_chest"
                type="number"
                style="max-width : 80px;"
              />
            </el-form-item>

            <el-form-item
              label="Tummy"
              prop="size_tummy"
            >

              <el-input
                v-model="newItem.size_tummy"
                type="number"
                style="max-width : 80px;"
              />
            </el-form-item>

            <el-form-item
              label="Sleeves"
              prop="size_sleeves"
            >

              <el-input
                v-model="newItem.size_sleeves"
                type="number"
                style="max-width : 80px;"
              />
            </el-form-item>

            <el-form-item
              label="Collar"
              prop="size_collar"
            >

              <el-input
                v-model="newItem.size_collar"
                type="number"
                style="max-width : 80px;"
              />
            </el-form-item>

          </el-form-item>

          <el-form-item :label="$t('product.color')" prop="color_id">
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

          <el-form-item :label="$t('product.event')" prop="events">
            <multiselect
              v-model="newItem.events"
              class="multiselect"
              :multiple="true"
              label="name"
              track-by="id"
              :options="events"
            />
          </el-form-item>

          <el-form-item :label="$t('product.category')" prop="categories">
            <multiselect
              v-model="newItem.categories"
              class="multiselect"
              :multiple="true"
              :searchable="true"
              label="name"
              track-by="id"
              :options="categories"
            />
          </el-form-item>

          <el-form-item :label="$t('product.brand')" prop="brand_id">
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

          <el-form-item :label="$t('product.fabric_brand')" prop="fabric_brand_id">
            <el-select
              v-model="newItem.fabric_brand_id"
              class="filter-item"
              placeholder="Please select fabric brand"
            >
              <el-option
                v-for="brand in brands"
                :key="brand.id"
                :label="brand.name | uppercaseFirst"
                :value="brand.id"
              />
            </el-select>
          </el-form-item>
          <el-form-item :label="$t('product.vendor_number')" prop="vendor_number">
            <multiselect
              v-model="newItem.vendor"
              tag-placeholder="Add this as new tag"
              placeholder="Search or add a tag"
              label="phone_number"
              track-by="id"
              :options="users"
              :multiple="true"
              :taggable="true"
              :max="1"
              :loading="loading"
              @tag="addTag"
              @search-change="asyncFind"
            />
          </el-form-item>

          <el-form-item
            v-if="newItem.vendor.length"
            :label="$t('product.vendor_name')"
            prop="role"
          >
            <el-input
              v-model="newItem.vendor[0].name"
              :disabled="!!newItem.vendor[0].id"
              style="max-width : 200px;"
            />
          </el-form-item>

          <el-form-item>
            <div class="components-container">
              <div class="editor-container">
                <dropzone
                  id="myVueDropzone"
                  url="/api/file/upload"
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
import MarkdownEditor from '@/components/MarkdownEditor';

const itemResource = new Resource('product');
const categoryResource = new Resource('category');
const eventResource = new Resource('event');
const brandResource = new Resource('brand');
const sizeResource = new Resource('size');
const colorResource = new Resource('color');
const fabricAgeResource = new Resource('fabric-age');
const userResource = new Resource('user');

const fileResource = new Resource('file/remove');

export default {
  name: 'UserList',
  components: { Pagination, Dropzone, Multiselect, MarkdownEditor },
  directives: { waves },
  data() {
    return {
      value: [],
      users: [],
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
      newItem: {
        phone_number: [],
        vendor: [],
      },
      dialogFormVisible: false,

      rules: {
        vendor_id: [
          { required: true, message: 'Vendor is required', trigger: 'blur' },
        ],
        brand_id: [
          { required: true, message: 'Brand is required', trigger: 'blur' },
        ],
        color_id: [
          { required: true, message: 'Color is required', trigger: 'blur' },
        ],
        size_chest: [
          { required: true, message: 'Size Chest is required', trigger: 'blur' },
        ],
        size_tummy: [
          { required: true, message: 'Size Tummy is required', trigger: 'blur' },
        ],
        size_collar: [
          { required: true, message: 'Size Collar is required', trigger: 'blur' },
        ],
        size_sleeves: [
          { required: true, message: 'Size Sleeves is required', trigger: 'blur' },
        ],
        size_length: [
          { required: true, message: 'Size Length is required', trigger: 'blur' },
        ],

        size_id: [
          { required: true, message: 'Size is required', trigger: 'blur' },
        ],
        fabric_age_id: [
          { required: true, message: 'Fabric Age is required', trigger: 'blur' },
        ],

        original_price: [
          { required: true, message: 'Original Price is required', trigger: 'blur' },
        ],
        description: [
          { required: true, message: 'Description is required', trigger: 'blur' },
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
    addTag(newTag) {
      const tag = {
        id: null,
        phone_number: newTag,
      };
      this.users.push(tag);
      this.newItem.vendor.push(tag);
    },
    async asyncFind(query) {
      const formData = {
        phone_number: query,
      };
      this.loading = true;
      const response = await userResource.list(formData);
      this.users = response.data;
      this.loading = false;
    },
    getOptionsList() {
      this.getCategoryList();
      this.getEventList();
      this.getBrandList();
      this.getColorList();
      this.getSizeList();
      this.getFabricAgeList();
    },
    dropzoneS(file) {
      if (file && file.xhr && file.xhr.response) {
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.images.push(uploadedFile.name);
      }

      this.$message({ message: 'Upload success', type: 'success' });
    },
    dropzoneR(file) {
      if (file && file.xhr && file.xhr.response) {
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.images.splice(
          this.newItem.images.indexOf(uploadedFile.name)
        );

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
          this.newItem.description = this.$refs.markdownEditor.getHtml();
          this.userCreating = true;
          itemResource
            .store(this.newItem)
            .then(response => {
              this.$message({
                message:
                  'New product ' +
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
        images: [],
        original_price: null,
        fabric_age_id: 1,
        fabric_brand_id: 1,
        brand_id: 1,
        color_id: 1,
        size_id: 1,
        vendor: [],
      };
    },
  },
};
</script>

<style src="vue-multiselect/dist/vue-multiselect.min.css"></style>

<style>

  .product-size-fields .el-form-item__label{
    width: 120px !important;
    margin-top: 20px;
  }

  .product-size-fields .el-form-item__content{
    margin-left: 120px !important;
    margin-top: 20px;
  }
  .product-size-fields .el-form-item, .product-size-fields .el-select{
  margin-left:30px !important;
  }

  .tui-editor-defaultUI .te-mode-switch {
  display: none;
}
</style>

<style lang="scss" scoped>
.multiselect {
  width: 200px;
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
