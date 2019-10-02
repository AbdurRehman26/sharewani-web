/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const categoryRoutes = {
  path: '/category',
  component: Layout,
  redirect: '/category',
  name: 'category',
  alwaysShow: true,
  meta: {
    title: 'Category',
    icon: 'form',
    permissions: ['view menu category'],
  },
  children: [
    /** category managements */
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/category/Profile'),
      name: 'categoryProfile',
      meta: { title: 'categoryProfile', noCache: true, permissions: ['manage category'] },
      hidden: true,
    },
    {
      path: '',
      component: () => import('@/views/category/List'),
      name: 'categoryList',
      meta: { title: 'List', icon: 'list', permissions: ['manage category'] },
    }],
};

export default categoryRoutes;
