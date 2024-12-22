<template>
  <a-modal
    title="User Register"
    width="800px"
    :maskClosable="false"
    zIndex="1100"
    :keyboard="false"
    :closable="false"
    :footer="null"
  >
    <a-form
      :model="formState"
      name="basic"
      :label-col="{ span: 6 }"
      :wrapper-col="{ span: 12 }"
      autocomplete="off"
      @finish="onFinish"
      @finishFailed="onFinishFailed"
    >
      <a-form-item
        label="Avater"
        name="user_avater"
        :rules="[{ required: true, message: '请上传头像!' }]"
      >
        <div class="clearfix">
          <a-upload
            v-model:file-list="fileList"
            :action="UploadUrl"
            maxCount="1"
            list-type="picture-card"
            crossOrigin="use-credentials"
            @change="handleChange"
            @preview="handlePreview"
          >
            <div v-if="fileList.length < 8">
              <plus-outlined />
              <div style="margin-top: 8px">Upload</div>
            </div>
          </a-upload>
          <a-modal
            :open="previewVisible"
            :title="previewTitle"
            :footer="null"
            @cancel="handleCancel"
            zIndex="1101"
          >
            <img alt="example" style="width: 100%" :src="previewImage" />
          </a-modal>
        </div>
      </a-form-item>

      <a-form-item
        label="Name"
        name="user_name"
        :rules="[{ required: true, message: '请设置您的用户姓名!' }]"
      >
        <a-input v-model:value="formState.user_name" />
      </a-form-item>

      <a-form-item :wrapper-col="{ offset: 8, span: 16 }">
        <a-button type="primary" html-type="submit">Signin</a-button>
      </a-form-item>
    </a-form>
  </a-modal>
</template>
<script lang="ts" setup>
import { reactive, ref, onMounted, defineProps, defineEmits } from "vue";
import { PlusOutlined } from "@ant-design/icons-vue";
import type { UploadProps } from "ant-design-vue";
import { Socket } from "@/logic/Socket";

const props = defineProps({
  socket: WebSocket,
});
const emits = defineEmits(["HandleWriteUserInfoSuccess"]);

const UploadUrl = ref<string>("");

onMounted(() => {
  UploadUrl.value =
    import.meta.env.VITE_BASE_URL_API + "User.User/UploadAvater";
  console.log(UploadUrl.value);
});

interface FormState {
  user_name: string;
  user_avater: string;
}

const formState = reactive<FormState>({
  user_avater: "",
  user_name: "",
});
const onFinish = (values: any) => {
  //handleSocket
  props.socket.send(Socket.SendHandle("User.User/WriteUserInfo", formState));
  console.log("start");
  
  emits("HandleWriteUserInfoSuccess", true);
};

const onFinishFailed = (errorInfo: any) => {
  console.log("Failed:", errorInfo);
};

function getBase64(file: File) {
  return new Promise((resolve, reject) => {
    const reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onload = () => resolve(reader.result);
    reader.onerror = (error) => reject(error);
  });
}

const previewVisible = ref(false);
const previewImage = ref("");
const previewTitle = ref("");

const fileList = ref<UploadProps["fileList"]>([]);

const handleChange = (file: any) => {
  if (file.file.response != undefined) {
    formState.user_avater = file.file.response.data.path;
  }
};

const handleCancel = () => {
  previewVisible.value = false;
  previewTitle.value = "";
};
const handlePreview = async (file: UploadProps["fileList"][number]) => {
  if (!file.url && !file.preview) {
    file.preview = (await getBase64(file.originFileObj)) as string;
  }
  previewImage.value = file.url || file.preview;
  previewVisible.value = true;
  previewTitle.value =
    file.name || file.url.substring(file.url.lastIndexOf("/") + 1);
};
</script>
<style scoped>
.ant-upload-select-picture-card i {
  font-size: 32px;
  color: #999;
}

.ant-upload-select-picture-card .ant-upload-text {
  margin-top: 8px;
  color: #666;
}
</style>