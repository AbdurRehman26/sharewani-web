import request from '@/utils/request';
import Resource from '@/api/resource';

class GlobalSettingResource extends Resource {
  constructor() {
    super('global-setting');
  }
  updateByKey(key, resource) {
    return request({
      url: '/' + this.uri + '-key/' + key,
      method: 'put',
      data: resource,
    });
  }

  getByKey(key) {
    return request({
      url: '/' + this.uri + '-key/' + key,
      method: 'get',
    });
  }
}

export { GlobalSettingResource as default };
