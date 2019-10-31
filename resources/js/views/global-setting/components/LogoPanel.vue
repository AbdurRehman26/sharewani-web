<template>
  <div class="el-row user-activity">
    <el-form
      ref="userForm"
      class="el-col el-col-24 el-col-xs-24 el-col-sm-24 el-col-lg-12"
      label-position="left"
    >
      <el-form-item>
        <div class="components-container">
          <div class="editor-container">
            <dropzone
              id="myVueDropzone"
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
      class="el-col el-col-24 el-col-xs-24 el-col-sm-24 el-col-lg-12"
      label-position="left"
    >
      <el-form-item>
        <div class="components-container">
          <div class="editor-container">
            <dropzone
              id="myVueDropzone"
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
  </div>
</template>

<script>
import Resource from '@/api/resource';
const globalSettingResource = new Resource('global-setting');
import Dropzone from '@/components/Dropzone';
const fileResource = new Resource('file/remove');

export default {
  components: { Dropzone },
  props: {},
  data() {
    return {
      items: [],
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
      const response = await globalSettingResource.list();
      this.items = response.data;
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
    onSubmit() {
      this.loading = true;
      globalSettingResource
        .store(this.newItem)
        .then(response => {
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
