<template>
  <a-button type="primary" @click="showModal">
    Добавить время
  </a-button>
  <a-modal v-model:open="open" title="Добавить время" @ok="handleOk" @cancel="">
    <task-time-form ref="taskTimeRef" @validated="addTaskTime($event)" @change-date="changeDate($event)" />
  </a-modal>
  <task-content :time-list="taskList" @delete="handleDelete($event)" />
</template>
<script lang="ts" setup>

import TaskContent from '@/components/TaskContent.vue'
import { onMounted, ref } from 'vue'
import { message } from 'ant-design-vue'
import TaskTimeForm from '@/components/Forms/TaskTimeForm.vue'
import type { ITaskTime } from '@/services/models'
import { useRoute } from 'vue-router'
import timeRepository from '@/repository/timeRepository'

const open = ref<boolean>(false)

const TaskTime = ref<ITaskTime>()

const changeDate = (date:ITaskTime) => {
  TaskTime.value = date
}
const fetchTaskList = async () => {
  try {
    const response = await timeRepository.index({ params: { task_id: route.params.id } })
    taskList.value = response.data.data
  } catch (e) {
    message.error('Ошибка!')
  }
}
const route = useRoute()
const taskTimeRef = ref(null)

const showModal = () => {
  open.value = true
}

const addTaskTime = async (data) => {
  try {
    const newData = {
      task_id: route.params.id,
      time_start: data.rangeTaskTime[0],
      time_finish: data.rangeTaskTime[1]
    }
    await timeRepository.store(newData)
    await fetchTaskList()
    message.success('Добавлено время :)')
  } catch (e) {
    message.error('Ошибка!')
  } finally {
    taskTimeRef.value.reset()
    open.value = false
  }
}

const handleDelete = async (data) => {
  try {
    await timeRepository.delete(data.id)
    await fetchTaskList()
    message.warning('Удалено время :)')
  } catch (e) {
    message.error('Ошибка!')
  }
}

const taskList = ref(null)

onMounted(async () => {
  await fetchTaskList()
})

const handleOk = async () => {
  try {
    taskTimeRef.value.validate()
  } catch (error) {
    message.error('Ошибка!')
  }
}
</script>
