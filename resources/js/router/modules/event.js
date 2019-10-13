/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const eventRoutes = {
  path: '/event',
  component: Layout,
  redirect: '/event',
  name: 'event',
  alwaysShow: true,
  meta: {
    title: 'Event',
    icon: 'documentation',
    permissions: ['view menu event'],
  },
  children: [
    /** event managements */
    {
      path: '',
      component: () => import('@/views/event/List'),
      name: 'eventList',
      meta: { title: 'List', icon: 'list', permissions: ['manage event'] },
    }],
};

export default eventRoutes;
