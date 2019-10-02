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
    icon: 'admin',
  },
  children: [
    /** User managements */
    {
      path: 'order/edit/:id(\\d+)',
      component: () => import('@/views/order/Profile'),
      name: 'UserProfile',
      meta: { title: 'userProfile', noCache: true, permissions: ['manage user'] },
      hidden: true,
    },
    {
      path: 'order',
      component: () => import('@/views/order/List'),
      name: 'UserList',
      meta: { title: 'List', icon: 'user', permissions: ['manage user'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () => import('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    }],
};

export default orderRoutes;
