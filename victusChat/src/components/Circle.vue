<template>
    <div class="Body">
        <!-- Left -->
        <div class="List">
            <div class="circle_box">
                <a-button type="primary" @click="showDrawer('large')">Open Large Size (736px)</a-button>            </div>
        </div>
    </div>
    <a-drawer title="Basic Drawer" :size="size" :open="open" @close="onClose" :mask="mask">
    <template #extra >
      <a-button style="margin-right: 8px" @click="onClose">Cancel</a-button>
      <a-button type="primary" @click="onClose">Submit</a-button>
    </template>
    <p>Some contents...</p>
    <p>Some contents...</p>
    <p>Some contents...</p>
  </a-drawer>
</template>
<script lang="ts" setup>
import { ref } from 'vue';
const open = ref<boolean>(false);
const mask = ref<Boolean>(false);
const size = ref<DrawerProps['size']>('default');
const showDrawer = (val: DrawerProps['size']) => {
  size.value = val;
  open.value = true;
};

const onClose = () => {
  open.value = false;
};
</script>
<style scoped>
.circle_box {
    width: 40%;
    height: 100%;
    background: #fff;
    box-shadow: 0px 0px 5px #ccc;
}

.List {
    height: 100%;
    background: white;
    width: 100%;
    border-radius: 12px;
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