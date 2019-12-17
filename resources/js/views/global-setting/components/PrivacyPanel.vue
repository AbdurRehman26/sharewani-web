<template>
  <div class="el-row user-activity">
    <el-form
      ref="userForm"
      class="el-col el-col-24 el-col-xs-24 el-col-sm-24 el-col-lg-24"
      label-position="left"
    >
      <h5 class="mb-10">Privacy Policy:</h5>

      <el-form-item prop="title" style="margin-right: 20px;">
        <markdown-editor
          ref="markdownEditorPrivacy"
          v-model="newItem.value"
          height="800px"
        />
      </el-form-item>

      <el-button type="primary" @click="onUpdate()">
        {{ $t('table.confirm') }}
      </el-button>

    </el-form>

  </div>
</template>

<script>
import GlobalSettingResource from '@/api/global-setting';
const globalSettingResource = new GlobalSettingResource();
import MarkdownEditor from '@/components/MarkdownEditor';

export default {
  components: { MarkdownEditor },
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
        value: {},
      },
      loading: false,
    };
  },
  created() {
    this.getItem();
  },
  methods: {
    async getItem() {
      const response = await globalSettingResource.getByKey('privacy_policy');
      this.newItem = response.data ? response.data : this.newItem;
    },

    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    onUpdate() {
      this.loading = true;

      this.newItem.value = this.$refs.markdownEditorPrivacy.getHtml();

      globalSettingResource
        .updateByKey('privacy_policy', this.newItem)
        .then(response => {
          this.getItem();
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
.mb-10 {
  margin-bottom: 10px;
}
</style>

<style>
.tui-editor-defaultUI .te-mode-switch {
  display: none;
}
</style>
