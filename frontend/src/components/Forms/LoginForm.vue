<template>
  <a-form
      :model="formState"
      name="basic"
      autocomplete="off"
      ref="loginRef"
      layout="vertical"
  >
    <a-form-item
        label="Почта"
        name="email"
        :rules="[{ required: true, message: 'Please input your email!' }]"
    >
      <a-input v-model:value="formState.email"/>
    </a-form-item>

    <a-form-item
        label="Пароль"
        name="password"
        :rules="[{ required: true, message: 'Please input your password!' }]"
    >
      <a-input-password v-model:value="formState.password"/>
    </a-form-item>


  </a-form>
</template>
<script lang="ts" setup>
import {reactive, ref} from 'vue';

interface FormState {
  email: string;
  password: string;
}

const formState = reactive<FormState>({
  email: '',
  password: '',
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

defineExpose({
  validate,
})
</script>