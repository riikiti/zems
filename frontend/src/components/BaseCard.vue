<script setup lang="ts">
import {h} from "vue";
import {DeleteOutlined, EditOutlined} from "@ant-design/icons-vue";
interface IProps{
  title:string
}

const props=defineProps<IProps>()
const emits=defineEmits<{
  (e:'edit'):void,
  (e:'delete'):void
}>()


</script>

<template>
  <div class="home-content__grid-item card global-relative">
    <div>{{title}}</div>
    <slot name="additional" />
    <div class="global-absolut edit-btn">
      <a-tooltip title="Edit">
        <a-button type="dashed" shape="circle" :icon="h(EditOutlined)" @click.stop="emits('edit')" />
      </a-tooltip>
    </div>
    <div class="global-absolut delete-btn">
      <a-tooltip title="Delete">
        <a-button type="dashed" danger shape="circle" :icon="h(DeleteOutlined)" @click.stop="emits('delete')" />
      </a-tooltip>
    </div>
  </div>
</template>

<style scoped lang="scss">
.card{
  transition: all 1s ease-out;
  display: flex;
  flex-direction: column;
  &:hover .edit-btn,&:hover .delete-btn{
    transition: all 0.5s ease-out;
    opacity: 1;
    visibility: visible;
  }
}
.edit-btn{
  opacity: 0;
  visibility: hidden;
  top:10px;
  right:10px;
}
.delete-btn{
  opacity: 0;
  visibility: hidden;
  top:50px;
  right:10px;
}
</style>