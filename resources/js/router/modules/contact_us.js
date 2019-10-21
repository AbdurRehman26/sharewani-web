/** When your routing table is too long, you can split it into small modules**/
import Layout from '@/layout';

const contactRoutes = {
  path: '/contact-us',
  component: Layout,
  redirect: '/contact',
  name: 'contact',
  alwaysShow: true,
  meta: {
    title: 'Contact Us',
    icon: 'form',
  },
  children: [
    /** contact managements */
    {
      path: '',
      component: () => import('@/views/contact/List'),
      name: 'contactList',
      meta: { title: 'List', icon: 'list' },
    }],
};

export default contactRoutes;
