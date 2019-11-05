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
  updateOrder(id, resource){
    return request({
      url: '/' + this.uri + '/' + id + '/update-order',
      method: 'put',
      data: resource,
    });
  }
}

export { OrderResource as default };
