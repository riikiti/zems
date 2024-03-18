<template>
  <a-form
    ref="loginRef"
    :model="formState"
    name="basic"
    autocomplete="off"
    layout="vertical"
  >
    <a-form-item
      label="Название"
      name="name"
      :rules="[{ required: true, message: 'Пожалуйста введите название проекта' }]"
    >
      <a-input v-model:value="formState.name" />
    </a-form-item>

    <a-form-item
      label="Описание"
      name="description"
      :rules="[{ required: true, message: 'Пожалуйста введите описание проекта!' }]"
    >
      <a-input v-model:value="formState.description" />
    </a-form-item>
  </a-form>
</template>
<script lang="ts" setup>
import {
  ref, toRefs
} from 'vue'

interface FormState {
  name: string;
  description: string;
}

interface IProps {
  data?:FormState,
}

const props = withDefaults(defineProps<IProps>(), {
  data: () => ({
    name: '',
    description: ''
  })
})

const { data } = toRefs(props)
const formState = ref<FormState>({
  name: data.value.name,
  description: data.value.description
})

const loginRef = ref(null)
const emits = defineEmits<{
  (e: 'validated', data: FormState): void
  (e: 'rejected', data: any): void
}>()

const reset = () => {
  loginRef.value.resetFields()
}

const validate = () => {
  loginRef.value.validateFields().then((errors) => {
    if (errors) {
      emits('validated', errors)
    } else {
      emits('rejected', errors)
    }
  })
}

defineExpose({
  validate,
  reset
})
</script>
