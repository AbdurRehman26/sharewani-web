/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const orderRoutes = {
  path: '/order',
  component: Layout,
  redirect: '/order',
  name: 'order',
  alwaysShow: true,
  meta: {
    title: 'Order',
    icon: 'shopping',
  },
  children: [
    /** User managements */
    {
      path: 'edit/:id(\\d+)',
      component: () => import('@/views/order/Profile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: '',
      component: () => import('@/views/order/List'),
      name: 'UserList',
      meta: { title: 'List', icon: 'list', permissions: ['manage user'] },
    }],
};

export default orderRoutes;
