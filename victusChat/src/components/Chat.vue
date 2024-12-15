<template>
        <div class="Body">
        <!-- Left -->
        <div class="Left"></div>
        <!-- right -->
         <div class="Right"></div>
    </div>
</template>
<script lang="ts" setup>

</script>
<style scoped>
.Right{
  height: 100%;
  background: white;
  width: 79%;
  border-radius: 12px;
}
.Left {
  height: 100%;
  background: white;
  width: 20%;
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