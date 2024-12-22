<template>
  <div class="LoginBlock">
    <p class="title">Victus Chat</p>
    <div class="Buttons">
      <a-button
        type="primary"
        style="background-color: green"
        @click="LoginModalView = true"
        >Login</a-button
      >
      <a-button type="primary" @click="SigninModalView = true">Signin</a-button>
    </div>
  </div>
  <LoginModal v-model:open="LoginModalView" />
  <SigninModal v-model:open="SigninModalView" />
</template>
<script lang="ts" setup>
import { watch, ref } from "vue";
import LoginModal from "./components/Login.vue";
import SigninModal from "./components/Signin.vue";

const LoginModalView = ref<boolean>(false);
const SigninModalView = ref<boolean>(false);

const Account = ref<string>("");
const Password = ref<string>("");
</script>
<style>
.Buttons {
  box-shadow: 0px 0px 10px 4px rgb(90, 90, 90);
  margin-top: 20px;
  background: white;
  padding: 30px;
  width: 30%;
  border-radius: 12px;
  display: flex;
  justify-items: center;
  align-items: center;
  justify-content: space-around;
  align-content: center;
}
* {
  user-select: none;
}
.title {
  color: white;
  font-size: 50px !important;
  letter-spacing: 5px;
  text-shadow: 5px 5px 1ch white;
  font-weight: bold;
}
.LoginBlock {
  height: 100vh;
  width: 100%;
  display: flex;
  justify-items: center;
  align-items: center;
  justify-content: center;
  flex-direction: column;
  align-content: center;
}
</style>