/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const productRoutes = {
  path: '/product',
  component: Layout,
  redirect: '/product',
  name: 'product',
  alwaysShow: true,
  meta: {
    title: 'Product',
    icon: 'theme',
    permissions: ['view menu product'],
  },
  children: [
    /** product managements */
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/product/Profile'),
      name: 'productProfile',
      meta: { title: 'productProfile', noCache: true, permissions: ['manage product'] },
      hidden: true,
    },
    {
      path: '',
      component: () => import('@/views/product/List'),
      name: 'productList',
      meta: { title: 'List', icon: 'list', permissions: ['manage product'] },
    }],
};

export default productRoutes;
