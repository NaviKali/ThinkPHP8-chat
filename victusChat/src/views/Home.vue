<template>
  <SigninView
    v-if="IsUserWriteInfomationStatus"
    v-model:open="SigninModel"
    :socket="socket"
    @HandleWriteUserInfoSuccess="HandleWriteUserInfoSuccess"
  />
  <div class="ChatBlock">
    <!-- Menu -->
    <MenuView @ChangeSuccessPage="HandleChangeSuccessPage" />
    <div class="View">
      <ChatView v-if="CurrentMenu == 'chat'" />
      <FriendView v-if="CurrentMenu == 'friend'" :socket="socket" />
      <CircleView v-if="CurrentMenu == 'circle'" />
      <MediaView v-if="CurrentMenu == 'media'" />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, onMounted } from "vue";
import { message } from "ant-design-vue";
import { LogicUser } from "@/logic/User";
import SigninView from "@/components/Signin.vue";
import MenuView from "@/components/Menu.vue";
import ChatView from "@/components/Chat.vue";
import FriendView from "@/components/Friend.vue";
import CircleView from "@/components/Circle.vue";
import MediaView from "@/components/Media.vue";
import { wSocket } from "@/server/socket.ts";
import { Socket } from "@/logic/Socket";

/**
 * 获取连接服务端的Socket
 * @var socket
 */
const socket = wSocket;

const SigninModel = ref<boolean | Boolean>(false);
const IsUserWriteInfomationStatus = ref<boolean | Boolean>(false);

onMounted(() => {
  setTimeout(() => {
    if (LogicUser.IsUserWriteInfomation()) {
      SigninModel.value = true;
      IsUserWriteInfomationStatus.value = true;
    }else{
      StartFirstConnection()
    }
  }, 500);
});

const CurrentMenu = ref<string | undefined | null>(
  localStorage.getItem("page")
);

const HandleChangeSuccessPage = (status: Boolean) => {
  if (status) CurrentMenu.value = localStorage.getItem("page");
};
const HandleWriteUserInfoSuccess = (status: Boolean) => {
  if (status) {
    SigninModel.value = false;
    IsUserWriteInfomationStatus.value = false;
    StartFirstConnection()
  }
};

/**
 * 第一次握手调用心跳
 */
const StartFirstConnection = ()=>
{
  wSocket.send(Socket.FirstSend());
}

// /**
//  * 禁止刷新
//  */
// window.addEventListener("keydown", function (e) {
//   if (e.key === "F5" || (e.key === "r" && e.ctrlKey)) {
//     e.preventDefault();
//   }
// });
// /**
//  * 退出 成为离线状态
//  * TODO 再见，希望我们还能再见一面。
//  */
// window.addEventListener("unload", (event) => {
//   wSocket.send(
//     Socket.SendHandle("User.User/Out", {},true)
//   );
// });
</script>
<style>
.View {
  height: 100%;
}

.ChatBlock {
  width: 80%;
  margin: 50px auto;
  height: 100vh;
}
</style>