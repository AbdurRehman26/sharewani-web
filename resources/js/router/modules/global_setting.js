/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const eventRoutes = {
  path: '/global-settings',
  component: Layout,
  redirect: '/global-settings',
  name: 'global.settings',
  alwaysShow: true,
  meta: {
    title: 'Global Settings',
    icon: 'documentation',
    permissions: ['view menu event'],
  },
  children: [
    /** event managements */
    {
      path: '',
      component: () => import('@/views/global-setting/Main'),
      name: 'eventList',
      meta: { title: 'Main', icon: 'list', permissions: ['manage event'] },
    }],
};

export default eventRoutes;
