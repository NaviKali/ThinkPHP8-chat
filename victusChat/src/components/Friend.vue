<template>
  <div class="Body">
    <!-- Left -->
    <div class="List">
      <div class="item" v-for="(item, index) in List" :key="index">
        <div class="UserInfo">
          <!-- 头像 -->
          <div class="UserAvater">
            <img :src="UploadUrl + item.user_avater" alt="" />
          </div>
          <div class="UserOtherInfo">
            <p>用户项目：{{ item.user_name }}</p>
            <p>
              用户状态：
              <a-tag color="green" v-if="item.user_status == 1">{{
                item.user_status_text
              }}</a-tag>
              <a-tag color="purple" v-if="item.user_status == 0">
                {{ item.user_status_text }}
              </a-tag>
            </p>
          </div>
        </div>
        <!-- 按钮组 -->
        <div class="buttons">
          <a-button
            type="primary"
            style="height: 50px"
            @click="HandleSend(item.user_guid)"
            >申请添加好友</a-button
          >
        </div>
      </div>
    </div>
  </div>
</template>
<script lang="ts" setup>
import { reactive, ref, onMounted, onUpdated, defineProps } from "vue";
import { Socket } from "@/logic/Socket";
import { ModelData } from "@/server/socket";

const props = defineProps({
  socket: WebSocket,
});

const UploadUrl = ref<string>("");
const List = ref<Array<any>>([]);

onMounted(() => {
  UploadUrl.value = import.meta.env.VITE_BASE_UPLOAD_API;

  setTimeout(() => {
    getOtherUserList();
    setTimeout(() => {
      List.value = ModelData.friend;
    }, 50);
  }, 200);
});

/**
 * 发起申请
 */
const HandleSend = (guid: string) => {
  props.socket.send(
    Socket.SendHandle("Friend.FriendApply/SendFriendApply", {
      over_user_guid: guid,
    })
  );
};

/**
 * 获取其他用户列表
 */
const getOtherUserList = () => {
  props.socket.send(Socket.SendGet("User.User/getOtherUserList", {}));
};
</script>
<style scoped>
.buttons {
  width: 50%;
  height: 100%;
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}
.UserOtherInfo {
  display: flex;
  flex-direction: column;
  justify-content: center;
  align-content: center;
  align-items: center;
}
.UserOtherInfo p {
  padding: 10px;
}
.UserInfo {
  width: 50%;
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
}
.UserAvater {
  width: 40%;
  overflow: hidden;
  border: 2px solid rgb(209, 209, 209);
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
  border-radius: 100%;
}
.UserAvater img {
  width: 100%;
}
.item {
  display: flex;
  justify-content: center;
  align-content: center;
  align-items: center;
  width: 30vw;
  padding: 20px;
  border-radius: 12px;
  height: 200px;
  box-shadow: 0px 0px 10px 2px rgb(197, 197, 197);
}
.List {
  height: 100%;
  background: white;
  width: 100%;
  padding: 20px;
  border-radius: 12px;
  display: grid;
  grid-template-columns: auto auto;
  grid-gap: 20px 100px;
  align-content: top;
  align-items: top;
  justify-content: center;
}
.Body {
  padding: 10px;
  height: 80%;
  display: flex;
  justify-content: space-between;
  align-content: center;
  align-items: center;
}
</style>