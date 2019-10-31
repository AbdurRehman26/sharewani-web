<template>
  <el-card>
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Logos" name="first">
        <div class="user-activity">
          <el-form
            ref="userForm"
            label-position="left"
            label-width="150px"
            style="max-width: 850px;"
          >
            <el-form-item>
              <div class="components-container">
                <div class="editor-container">
                  <dropzone
                    id="myVueDropzone"
                    url="/api/file/upload?key=settings"
                    @dropzone-removedFile="dropzoneR"
                    @dropzone-success="dropzoneS"
                  />
                </div>
              </div>
            </el-form-item>
          </el-form>

          <el-button type="primary" @click="onSubmit()">
            {{ $t('table.confirm') }}
          </el-button>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
const globalSettingResource = new Resource('global-setting');
import Dropzone from '@/components/Dropzone';
const fileResource = new Resource('file/remove');

export default {
  components: { Dropzone },
  props: {
    user: {
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
      newItem: {
        key: 'main_logo',
        value: null,
        type: 1,
      },
      activeActivity: 'first',
      loading: false,
    };
  },
  methods: {
    dropzoneS(file) {
      if (file && file.xhr && file.xhr.response) {
        const uploadedFile = JSON.parse(file.xhr.response);

        this.newItem.value = uploadedFile.name;
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

<style lang="scss" scoped>
.user-bio-section-body,
.box-user-details,
.post {
  margin-top: 40px;
}

.user-activity {
  .user-block {
    .username,
    .description {
      display: block;
      margin-left: 50px;
      padding: 2px 0;
    }
    img {
      width: 40px;
      height: 40px;
      float: left;
    }
    :after {
      clear: both;
    }
    .img-circle {
      border-radius: 50%;
      border: 2px solid #d2d6de;
      padding: 2px;
    }
    span {
      font-weight: 500;
      font-size: 12px;
    }
  }
  .post {
    font-size: 14px;
    border-bottom: 1px solid #d2d6de;
    margin-bottom: 15px;
    padding-bottom: 15px;
    color: #666;
    .image {
      width: 100%;
    }
    .user-images {
      padding-top: 20px;
    }
  }
  .list-inline {
    padding-left: 0;
    margin-left: -5px;
    list-style: none;
    li {
      display: inline-block;
      padding-right: 5px;
      padding-left: 5px;
      font-size: 13px;
    }
    .link-black {
      &:hover,
      &:focus {
        color: #999;
      }
    }
  }
  .el-carousel__item h3 {
    color: #475669;
    font-size: 14px;
    opacity: 0.75;
    line-height: 200px;
    margin: 0;
  }

  .el-carousel__item:nth-child(2n) {
    background-color: #99a9bf;
  }

  .el-carousel__item:nth-child(2n + 1) {
    background-color: #d3dce6;
  }
}
</style>
