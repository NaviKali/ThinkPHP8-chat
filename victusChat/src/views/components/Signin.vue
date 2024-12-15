<template>
  <a-modal v-model:open="open" title="User Signin" @ok="handleOk">
    <a-form
      :model="formState"
      name="basic"
      :label-col="{ span: 6 }"
      :wrapper-col="{ span: 16 }"
      autocomplete="off"
      @finish="onFinish"
      @finishFailed="onFinishFailed"
    >
      <a-form-item
        label="Username"
        name="username"
        :rules="[{ required: true, message: 'Please input your username!' }]"
      >
        <a-input v-model:value="formState.username" autofocus />
      </a-form-item>

      <a-form-item
        label="Password"
        name="password"
        :rules="[{ required: true, message: 'Please input your password!' }]"
      >
        <a-input-password v-model:value="formState.password" />
      </a-form-item>
    </a-form>
  </a-modal>
</template>
  <script lang="ts" setup>
import { ref, reactive } from "vue";
import { AccountLogin } from "@/server/User/AccountLogin.ts";
import { Signin } from "@/server/User/Signin.ts";
import { message } from "ant-design-vue";


const formState = reactive({
  username: "",
  password: "",
  remember: true,
});

/**
 * Click Ok Handle
 */
const handleOk = () => {
  Signin.fetch({
    user_account: formState.username,
    user_password: formState.password,
  }).then((res: any) => {
    if (res.code == 500) {
      message.error(res.msg);
    } else {
      message.success(res.msg);
    }
  });
};
</script>
  
  <style>
</style>