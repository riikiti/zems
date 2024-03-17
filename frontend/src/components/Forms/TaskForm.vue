<template>
  <a-form
      :model="formState"
      name="basic"
      autocomplete="off"
      ref="loginRef"
      layout="vertical"
  >
    <a-form-item
        label="Название задачи"
        name="name"
        :rules="[{ required: true, message: 'Please input your email!' }]"
    >
      <a-input v-model:value="formState.name"/>
    </a-form-item>


  </a-form>
</template>
<script lang="ts" setup>
import {reactive, ref, toRefs, watch} from 'vue';

interface FormState {
  name: string;
}

interface IProps{
  data?:FormState,
}

const props=withDefaults(defineProps<IProps>(),{
  data:()=>({
    name: "",
  }),
})

/*
* watcher
* */

const {data}=toRefs(props)

const formState = ref<FormState>({
  name: data.value.name,
});

const loginRef=ref(null)
const emits = defineEmits<{
  (e: 'validated', data: FormState): void
  (e: 'rejected', data: any): void
}>()

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
const reset=()=>{
  console.log("red")
  loginRef.value.resetFields()
}

defineExpose({
  validate,
  reset
})
</script>