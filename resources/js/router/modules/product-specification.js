/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const productRoutes = {
  path: '/product-specification/',
  component: Layout,
  redirect: '/product-specification',
  name: 'product-specification',
  alwaysShow: true,
  meta: {
    title: 'Product Specification',
    icon: 'theme',
  },
  children: [
    /** product managements */
    {
      path: 'color',
      component: () => import('@/views/color/List'),
      name: 'product color',
      meta: { title: 'Color', icon: 'list' },
    },
    {
      path: 'size',
      component: () => import('@/views/size/List'),
      name: 'product size',
      meta: { title: 'Size', icon: 'list' },
    },
    {
      path: 'brand',
      component: () => import('@/views/brand/List'),
      name: 'product brand',
      meta: { title: 'Brand', icon: 'list' },
    },
    {
      path: 'fabric-age',
      component: () => import('@/views/fabric_age/List'),
      name: 'product facbric age',
      meta: { title: 'Fabric Age', icon: 'list' },
    },
  ],
};

export default productRoutes;
