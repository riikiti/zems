<template>
  <a-space direction="vertical" class="w-full">
  <a-form
      :model="formState"
      name="time_related_controls"
      layout="vertical"
      ref="taskRef"
  >
    <a-form-item name="rangeTaskTime" label="Выберите время" v-bind="rangeConfig">
      <a-range-picker
          class="w-full"
          :disabled-date="disabledDate"
          v-model:value="formState.rangeTaskTime"
          show-time
          format="YYYY-MM-DD HH:mm:ss"
          value-format="YYYY-MM-DD HH:mm:ss"
      />
    </a-form-item>
  </a-form>

  </a-space>
</template>
<script lang="ts" setup>
import dayjs, { Dayjs } from 'dayjs';
import {reactive, ref} from "vue";

const taskRef = ref(null)
const reset=()=>{
  taskRef.value.resetFields()
}
const emits = defineEmits<{
  (e: 'validated', data: FormState): void
  (e: 'rejected'): void
}>()

const disabledDate = (current: Dayjs) => {
  return current && current < dayjs().endOf('day');
};
const validate = () => {
  taskRef.value.validateFields().then((response) => {
    if (response) {
      emits('validated', response)
    } else {
      emits('rejected')
    }
  })
}

interface FormState {
  rangeTaskTime: [string, string];
}

const formState=reactive<FormState>({
  rangeTaskTime:['','']
});
const rangeConfig = {
  rules: [{ type: 'array' as const, required: true, message: 'Please select time!' }],
};
defineExpose({
  validate,
  reset
})

</script>
<style scoped lang="scss">
  .w-full{
    width: 100%;
  }
</style>

