/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const userRoutes = {
  path: '/user',
  component: Layout,
  redirect: '/user/user',
  name: 'user',
  alwaysShow: true,
  meta: {
    title: 'User',
    icon: 'user',
    permissions: ['view menu user'],
  },
  children: [
    /** User managements */
    {
      path: 'user/edit/:id(\\d+)',
      component: () => import('@/views/user/Profile'),
      name: 'UserProfile',
      meta: {
        title: 'userProfile',
        noCache: true,
        permissions: ['manage user'],
      },
      hidden: true,
    },
    {
      path: 'user',
      component: () => import('@/views/user/List'),
      name: 'UserList',
      meta: { title: 'User List', icon: 'list', permissions: ['manage user'] },
    },
    // /** Role and permission */
    // {
    //   path: 'roles',
    //   component: () => import('@/views/role-permission/List'),
    //   name: 'RoleList',
    //   meta: { title: 'Role List', icon: 'role', permissions: ['manage permission'] },
    // }
  ],
};

export default userRoutes;
