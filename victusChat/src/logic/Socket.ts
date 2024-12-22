export namespace Socket {
  /**
   * Socket向后端提出->类型
   * @constant
   * @var String
   */
  export const SOCKET_TYPE_HANDLE: String = "handle";
  /**
   * Socket向后端提出->获取
   * @constant
   * @var String
   */
  export const SOCKET_TYPE_GET: String = "get";
  /**
   * 发起处理
   * @param _api Api路径
   * @param _params 携带参数
   * @param _getUserGuid 是否携带用户Guid default true
   * @returns
   */
  export function SendHandle(
    _api: string,
    _params: Array<any> | any,
    _getUserGuid: Boolean = true
  ): string {
    return JSON.stringify({
      type: SOCKET_TYPE_HANDLE,
      api: btoa(_api),
      params: _getUserGuid ? getUserGuid(_params) : _params,
    });
  }
  /**
   * 发起获取
   * @param _api Api路径
   * @param _getUserGuid 是否携带用户Guid default true
   * @returns
   */
  export function SendGet(_api: string, _getUserGuid: Boolean = true): string {
    return JSON.stringify({
      type: SOCKET_TYPE_GET,
      api: btoa(_api),
      params: _getUserGuid
        ? {
            author: localStorage.getItem("Author") ?? null,
          }
        : {},
    });
  }
  /**
   * 第一次握手
   * @returns
   */
  export function FirstSend():string {
    return JSON.stringify({
      Timer: true,
      Author: localStorage.getItem("Author") ?? null,
    });
  }

  /**
   * 获取用户Guid(身份)
   * @param _arr must
   * @returns any
   */
  export function getUserGuid(_arr: any): any {
    _arr.author = localStorage.getItem("Author") ?? null;
    return _arr;
  }
}
