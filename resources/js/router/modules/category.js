/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const categoryRoutes = {
  path: '/category',
  component: Layout,
  redirect: '/category/category',
  name: 'category',
  alwaysShow: true,
  meta: {
    title: 'Category',
    icon: 'admin',
    permissions: ['view menu category'],
  },
  children: [
    /** category managements */
    {
      path: 'category/edit/:id(\\d+)',
      component: () => import('@/views/category/Profile'),
      name: 'categoryProfile',
      meta: { title: 'categoryProfile', noCache: true, permissions: ['manage category'] },
      hidden: true,
    },
    {
      path: 'category',
      component: () => import('@/views/category/List'),
      name: 'categoryList',
      meta: { title: 'List', icon: 'component', permissions: ['manage category'] },
    },
    /** Role and permission */
    {
      path: 'roles',
      component: () => import('@/views/role-permission/List'),
      name: 'RoleList',
      meta: { title: 'rolePermission', icon: 'role', permissions: ['manage permission'] },
    }],
};

export default categoryRoutes;
