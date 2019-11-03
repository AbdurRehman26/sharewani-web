<template>
  <div class="el-row user-activity">
    <el-form
      ref="userForm"
      class="el-col el-col-24 el-col-xs-24 el-col-sm-24 el-col-lg-6"
      label-position="left"
    >
      <el-form-item>
        <div class="components-container">
          <div class="editor-container">
            <dropzone
              id="myVueDropzone"
              ref="myVueDropzone"
              url="/api/file/upload?key=settings&file_type=main_logo"
              @dropzone-removedFile="dropzoneR"
              @dropzone-success="dropzoneS"
            />
          </div>
        </div>
      </el-form-item>
      <el-button type="primary" @click="onSubmit()">
        {{ $t('table.confirm') }}
      </el-button>
    </el-form>

    <el-form
      ref="userForm"
      class="el-col el-col-24 el-col-xs-24 el-col-sm-24 el-col-lg-18"
      label-position="left"
    >
      <el-table
        v-loading="loading"
        :data="list"
        border
        fit
        highlight-current-row
        style="width: 100%"
      >
        <el-table-column align="center" label="ID">
          <template slot-scope="scope">
            <span>{{ scope.row.index }}</span>
          </template>
        </el-table-column>

        <el-table-column align="center" label="IMAGE">
          <template slot-scope="scope">
            <img :src="scope.row.value.thumbnail_url">
          </template>
        </el-table-column>

        <el-table-column align="center" label="ACTIVE">
          <template slot-scope="scope">
            <el-tag :type="scope.row.is_active == 1 ? 'success' : 'info' | statusFilter">
              {{ scope.row.is_active ? 'Active' : 'In Active' }}
            </el-tag>
          </template>
        </el-table-column>

        <el-table-column align="center" label="Actions">
          <template slot-scope="scope">
            <el-button v-if="!scope.row.is_active" type="info" size="small" icon="el-icon-edit" @click="setActive(scope.row)">
              Set
            </el-button>
          </template>
        </el-table-column>
      </el-table>

      <pagination
        v-show="query.total > 0"
        :total="query.total"
        :page.sync="query.page"
        :limit.sync="query.limit"
        @pagination="getList"
      />
    </el-form>
  </div>
</template>

<script>
import Pagination from '@/components/Pagination';
import Resource from '@/api/resource';
import GlobalSettingResource from '@/api/global-setting';
const globalSettingResource = new GlobalSettingResource();
import Dropzone from '@/components/Dropzone';
const fileResource = new Resource('file/remove');

export default {
  components: { Dropzone, Pagination },
  props: {},
  data() {
    return {
      query: {
        total: 0,
        page: 1,
        limit: 5,
        keyword: '',
        role: '',
      },
      list: [],
      newItem: {
        key: 'main_logo',
        value: null,
        type: 1,
      },
      activeActivity: 'first',
      loading: false,
    };
  },
  created() {
    this.getList();
  },
  methods: {
    async getList() {
      this.list = [];

      const response = await globalSettingResource.list({ key: 'main_logo' });

      this.list = response.data;
      this.list.forEach((element, index) => {
        element['index'] = (this.query.page - 1) * this.query.limit + index + 1;
      });
      this.query.total = 10;
      this.loading = false;
    },

    dropzoneS(file) {
      if (file && file.xhr && file.xhr.response) {
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.value = uploadedFile;
      }

      this.$message({ message: 'Upload success', type: 'success' });
    },
    dropzoneR(file) {
      if (file && file.xhr && file.xhr.response) {
        const uploadedFile = JSON.parse(file.xhr.response);

        const fileData = {
          file_name: uploadedFile.name,
        };
        this.newItem.value = null;

        fileResource.store(fileData);
      }

      this.$message({ message: 'Delete success', type: 'success' });
    },

    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    setActive(resource) {
      this.loading = true;
      globalSettingResource
        .updateByKey('main_logo', resource)
        .then(response => {
          this.getList();
          this.loading = false;
          this.$message({
            message: 'Settings Updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.loading = false;
        });
    },
    onSubmit() {
      this.loading = true;
      globalSettingResource
        .store(this.newItem)
        .then(response => {
          this.$refs.myVueDropzone.removeAllFiles();
          this.getList();
          this.newItem.value = null;
          this.loading = false;
          this.$message({
            message: 'Settings Updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.loading = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped></style>
