import request from '@/utils/request';
import Resource from '@/api/resource';

class OrderResource extends Resource {
  constructor() {
    super('order');
  }
  getCollidingOrders(id){
    return request({
      url: '/' + this.uri + '/' + id + '/colliding-orders',
      method: 'get',
    });
  }
}

export { OrderResource as default };
