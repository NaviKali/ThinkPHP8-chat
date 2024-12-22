import { message } from "ant-design-vue";
import { getUserInfo } from "./socket_handle.ts";
import { reactive, ref } from "vue";

export const wSocket: WebSocket = new WebSocket("ws://127.0.0.1:8282");

/**
 * 定义模块函数
 * !一般定义GET类型的握手
 */
export const ModelFunction = ref<
  Array<{
    _void: String;
    model: String;
  }>
>([
  {
    _void: "User.User/getOtherUserList",
    model: "friend",
  },
]);

/**
 * 模块数据
 * @var Object
 */
export const ModelData = reactive<{
  friend: Object | Array<any>;
}>({
  friend: {},
});

/**
 * 打开{WebSocket}时候
 */
wSocket.onopen = function (): any {};
/**
 * 每当服务Socket返回信息或发送信息时候
 * @param e 信息数据
 */
wSocket.onmessage = function (e): any {
  let data = JSON.parse(atob(e.data));
  if (data.code == 110) HandleError();
  if (data.message != undefined) {
    HandleMessage(data.message.type, data.message.content);
  }
  HandleApi(data.api.void, data.data);
  HandleModelFunction(data.api.data, data.data);
  
};

/**
 * 处理模块函数
 */
function HandleModelFunction(api: String, data: Object | Array<any>) {
  ModelFunction.value.forEach((item: { _void: String; model: String }) => {
    if (item._void == api) {
      switch (item.model) {
        case "friend":
          ModelData.friend = data;
          break;
        default:
          break;
      }
    }
  });
}

/**
 * 处理101异常
 */
function HandleError(): void {
  localStorage.clear(); //*清空数据 {避免异常数据的泛滥}
  setTimeout(() => {
    location.href = "/"; //*退回登录页
  }, 1000);
}

/**
 * 处理提示框
 */
function HandleMessage(type: string, content: string): void {
  type == "success"
    ? message.success(content)
    : type == "error"
    ? message.error(content)
    : type == "warning"
    ? message.warning(content)
    : null;
}

/**
 * 处理某件Api事项
 */
function HandleApi(_void: string, _data: any): void {
  switch (_void) {
    case "WriteUserInfo":
      getUserInfo();
      break;
    case "getUserInfo":
      localStorage.setItem("UserInfo", JSON.stringify(_data));
      break;
    default:
      break;
  }
}
