<template>
  <el-card v-if="user.name">
    <el-tabs v-model="activeActivity" @tab-click="handleClick">
      <el-tab-pane label="Product Details" name="first">
        <div class="user-activity">
          <div class="user-skills user-bio-section">
            <div class="user-bio-section-header">
              <span>
                <strong> {{ product.title }} </strong></span>
            </div>

            <div class="user-bio-section-body">
              <div class="progress-item">
                <span>{{ product.description }}</span>
              </div>
            </div>
          </div>

          <div class="box-user-details">
            <el-table :data="productDetails" :show-header="false">
              <el-table-column prop="label" label="Name" />
              <el-table-column label="Count" align="left" width="100">
                <template slot-scope="scope">
                  {{ product[scope.row.key] }}
                </template>
              </el-table-column>
            </el-table>
          </div>

          <div class="post">
            <div class="user-images">
              <el-carousel :interval="6000" type="card" height="200px">
                <el-carousel-item
                  v-for="(item, index) in product.images"
                  :key="index"
                >
                  <img :src="item" class="image">
                </el-carousel-item>
              </el-carousel>
            </div>
          </div>
        </div>
      </el-tab-pane>
    </el-tabs>
  </el-card>
</template>

<script>
import Resource from '@/api/resource';
const userResource = new Resource('users');

export default {
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
    product: {
      type: Object,
      default: () => {
        return {
          name: '',
          email: '',
          avatar: '',
          images: [],
        };
      },
    },
  },
  data() {
    return {
      productDetails: [
        {
          key: 'number_of_items',
          label: 'Total Items',
        },
        {
          key: 'original_price',
          label: 'Original Price',
        },
        {
          key: 'total_orders',
          label: 'Total Orders',
        },
        {
          key: 'total_accepted_orders',
          label: 'Accepted Orders',
        },

        {
          key: 'total_pending_orders',
          label: 'Rejected Orders',
        },
      ],

      activeActivity: 'first',
      carouselImages: [],
      updating: false,
    };
  },
  methods: {
    handleClick(tab, event) {
      console.log('Switching tab ', tab, event);
    },
    onSubmit() {
      this.updating = true;
      userResource
        .update(this.user.id, this.user)
        .then(response => {
          this.updating = false;
          this.$message({
            message: 'User information has been updated successfully',
            type: 'success',
            duration: 5 * 1000,
          });
        })
        .catch(error => {
          console.log(error);
          this.updating = false;
        });
    },
  },
};
</script>

<style lang="scss" scoped>
.user-bio-section-body, .box-user-details, .post {
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
