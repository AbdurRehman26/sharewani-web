<template>
  <div class="navbar">

    <breadcrumb id="breadcrumb-container" class="breadcrumb-container" />

    <div class="right-menu">
      <template v-if="device!=='mobile'">

        <screenfull id="screenfull" class="right-menu-item hover-effect" />

      </template>

      <el-dialog :title="'Update Profile'" :visible.sync="dialogFormVisible">
        <div v-loading="userUpdating" class="form-container">
          <el-form
            ref="userForm"
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

      <el-dropdown class="avatar-container right-menu-item hover-effect" trigger="click">

        <div class="avatar-wrapper">
          <img :src="avatar+'/128'" class="user-avatar">
          <i class="el-icon-caret-bottom" />
        </div>
        <el-dropdown-menu slot="dropdown">
          <li @click="dialogFormVisible = true">
            <el-dropdown-item>
              {{ $t('navbar.update') }}
            </el-dropdown-item>
          </li>
          <router-link to="/">
            <el-dropdown-item>
              {{ $t('navbar.dashboard') }}
            </el-dropdown-item>
          </router-link>
          <el-dropdown-item divided>
            <span style="display:block;" @click="logout">{{ $t('navbar.logOut') }}</span>
          </el-dropdown-item>
        </el-dropdown-menu>
      </el-dropdown>
    </div>
  </div>
</template>

<script>
import { mapGetters } from 'vuex';
import Breadcrumb from '@/components/Breadcrumb';
import Screenfull from '@/components/Screenfull';

export default {
  components: {
    Breadcrumb,
    Screenfull,
  },
  data(){
    return {
      newItem: {},
      userUpdating: false,
      dialogFormVisible: false,
    };
  },
  computed: {
    ...mapGetters([
      'sidebar',
      'name',
      'avatar',
      'device',
      'userId',
    ]),
  },
  methods: {
    toggleSideBar() {
      this.$store.dispatch('app/toggleSideBar');
    },
    async logout() {
      await this.$store.dispatch('user/logout');
      this.$router.push(`/login?redirect=${this.$route.fullPath}`);
    },
  },
};
</script>

<style lang="scss" scoped>
.navbar {
  height: 50px;
  overflow: hidden;
  position: relative;
  background: #fff;
  box-shadow: 0 1px 4px rgba(0,21,41,.08);

  .hamburger-container {
    line-height: 46px;
    height: 100%;
    float: left;
    cursor: pointer;
    transition: background .3s;
    -webkit-tap-highlight-color:transparent;

    &:hover {
      background: rgba(0, 0, 0, .025)
    }
  }

  .breadcrumb-container {
    float: left;
  }

  .errLog-container {
    display: inline-block;
    vertical-align: top;
  }

  .right-menu {
    float: right;
    height: 100%;
    line-height: 50px;

    &:focus {
      outline: none;
    }

    .right-menu-item {
      display: inline-block;
      padding: 0 8px;
      height: 100%;
      font-size: 18px;
      color: #5a5e66;
      vertical-align: text-bottom;

      &.hover-effect {
        cursor: pointer;
        transition: background .3s;

        &:hover {
          background: rgba(0, 0, 0, .025)
        }
      }
    }

    .avatar-container {
      margin-right: 30px;

      .avatar-wrapper {
        margin-top: 5px;
        position: relative;

        .user-avatar {
          cursor: pointer;
          width: 40px;
          height: 40px;
          border-radius: 4px;
        }

        .el-icon-caret-bottom {
          cursor: pointer;
          position: absolute;
          right: -20px;
          top: 25px;
          font-size: 12px;
        }
      }
    }
  }
}
</style>
