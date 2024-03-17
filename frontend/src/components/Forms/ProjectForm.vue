<template>
  <a-form
      :model="formState"
      name="basic"
      autocomplete="off"
      ref="loginRef"
      layout="vertical"
  >
    <a-form-item
        label="Название"
        name="name"
        :rules="[{ required: true, message: 'Please input your name!' }]"
    >
      <a-input v-model:value="formState.name"/>
    </a-form-item>

    <a-form-item
        label="Описание"
        name="description"
        :rules="[{ required: true, message: 'Please input your description!' }]"
    >
      <a-input v-model:value="formState.description"/>
    </a-form-item>

    <a-upload
        v-model:file-list="fileList"
        name="file"
        action="https://www.mocky.io/v2/5cc8019d300000980a055e76"
        :headers="headers"
        @change="handleChange"
    >
      <a-button>
        <upload-outlined></upload-outlined>
        Загрузить
      </a-button>
    </a-upload>
  </a-form>
</template>
<script lang="ts" setup>
import {reactive, ref, toRefs, watch} from 'vue';
import {UploadOutlined} from '@ant-design/icons-vue';
import type {UploadChangeParam} from 'ant-design-vue';
import {message} from 'ant-design-vue';

const handleChange = (info: UploadChangeParam) => {
  if (info.file.status !== 'uploading') {
    console.log(info.file, info.fileList);
  }
  if (info.file.status === 'done') {
    message.success(`${info.file.name} file uploaded successfully`);
  } else if (info.file.status === 'error') {
    message.error(`${info.file.name} file upload failed.`);
  }
};

const fileList = ref([]);
const headers = {
  authorization: 'authorization-text',
};

interface FormState {
  name: string;
  description: string;
}

interface IProps{
  data?:FormState,
}

const props=withDefaults(defineProps<IProps>(),{
  data:()=>({
    name: "",
    description:""
  }),
})

const {data}=toRefs(props)
const formState = ref<FormState>({
  name: data.value.name,
  description: data.value.description,
});

/*
* watcher
* */

const loginRef = ref(null)
const emits = defineEmits<{
  (e: 'validated', data: FormState): void
  (e: 'rejected', data: any): void
}>()

const reset=()=>{
  loginRef.value.resetFields()
}

const validate = () => {
  loginRef.value.validateFields().then((errors) => {
    if (errors) {
      emits('validated', errors)
    } else {
      console.log(errors)
      emits('rejected', errors)
    }
  })
}

defineExpose({
  validate,
  reset
})
</script>