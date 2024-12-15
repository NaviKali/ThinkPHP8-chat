<template>
  <div class="Menu">
    <div
      v-for="(item, index) in menu"
      :key="index"
      :class="{MenuItem:true,MenuActive:item.page == CurrentMenu ? true : false}"
      @click="HandleChangePage(item.page)"
    >
      <img :src="item.img" alt="" />
    </div>
  </div>
</template>
<script lang="ts" setup>
import { ref, onMounted, defineEmits } from "vue";

const emit = defineEmits(["ChangeSuccessPage"]);

interface menuItem {
  img: string;
  page: string;
}
const CurrentMenu = ref<string|undefined|null>(localStorage.getItem("page"));

/**
 * Define Menu
 */
const menu = ref<menuItem[]>([
  {
    img: "/src/assets/Image/chat.png",
    page: "chat",
  },
  {
    img: "/src/assets/Image/friend.png",
    page: "friend",
  },
]);

const HandleChangePage = (page: string) => {
  localStorage.setItem("page", page);
  CurrentMenu.value = page;
  emit("ChangeSuccessPage", true);
};
</script>
<style scoped>
.MenuActive {
  box-shadow: 0px 0px 10px 2px rgb(218, 218, 218);
}

.MenuItem img {
  width: 50%;
}
.MenuItem {
  width: 65px;
  height: 95%;
  display: flex;
  justify-content: center;
  margin-left: 10px;
  align-content: center;
  align-items: center;
  transition: all 0.6s;
  border-radius: 12px;
}
.MenuItem:hover {
  background: rgb(218, 218, 218);
}
.Menu {
  height: 80px;
  margin: 10px;
  padding: 10px 30px 10px 30px;
  border-radius: 28px;
  background: white;
  display: flex;
  justify-content: left;
  align-content: center;
  align-items: center;
}
</style>