<template>
  <div class="ChatBlock">
    <!-- Menu -->
    <MenuView @ChangeSuccessPage="HandleChangeSuccessPage" />
    <div class="View">
      <ChatView v-if="CurrentMenu == 'chat'" />
      <FriendView v-if="CurrentMenu == 'friend'" />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, onMounted } from "vue";
import MenuView from "@/components/Menu.vue";
import ChatView from "@/components/Chat.vue";
import FriendView from "@/components/Friend.vue";


const socket = new WebSocket("ws://127.0.0.1:8282");

const CurrentMenu = ref<string | undefined | null>(
  localStorage.getItem("page")
);

const HandleChangeSuccessPage = (status: Boolean) => {
  if (status) CurrentMenu.value = localStorage.getItem("page");
};

socket.onopen = function()
{
  socket.send("Asd");
  console.log("Connect Success!");
}
socket.onmessage = function(e)
{
  let data = JSON.parse(e.data);
  console.log(data);
    
}
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