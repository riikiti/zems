<template>
  <a-form
      :model="formState"
      name="basic"
      autocomplete="off"
      ref="registerRef"
      layout="vertical"
  >
    <a-form-item
        label="Имя"
        name="name"
        :rules="[{ required: true, message: 'Please input your username!' }]"
    >
      <a-input v-model:value="formState.name"/>
    </a-form-item>

    <a-form-item
        label="Почта"
        name="email"
        :rules="[{ required: true,type:'email', message: 'Please input your email!' }]"
    >
      <a-input v-model:value="formState.email"/>
    </a-form-item>

    <a-form-item
        name="password"
        label="Пароль"
        :rules="[{ required: true, message: 'Please input your password!' }]"
    >
      <a-input-password v-model:value="formState.password" placeholder="Пароль">
        <template #prefix>
          <lock-outlined/>
        </template>
      </a-input-password>
    </a-form-item>
    <a-form-item
        label="Подтверждение"
        name="confirm_password"
        :rules="[
              { required: true, message: 'Please input your password!' },
              {
                validator: async (rule, value) => {
                  if (value !== formState.password) {
                    throw new Error('The passwords do not match')
                  }
                },
                trigger: 'blur'
              }
            ]"
    >
      <a-input-password v-model:value="formState.confirm_password" placeholder="Повтори пароль">
        <template #prefix>
          <lock-outlined/>
        </template>
      </a-input-password>
    </a-form-item>
  </a-form>
</template>
<script lang="ts" setup>
import {reactive, ref} from 'vue';

interface FormState {
  name: string;
  password: string;
  confirm_password: string;
  email: string;
}

const formState = reactive<FormState>({
  name: '',
  password: '',
  confirm_password: '',
  email: '',
});

const emits = defineEmits<{
  (e: 'validated', data: FormState): void
  (e: 'rejected', data: any): void
}>()
const registerRef = ref(null);
const validate = () => {
  registerRef.value.validateFields().then((errors) => {
    if (errors) {
      emits('validated', errors)
    } else {
      emits('rejected', errors)
    }
  })
}
defineExpose({
  validate
})

</script>