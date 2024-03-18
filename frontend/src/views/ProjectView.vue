<template>
  <div>
    Проект {{ route.params.id }}
  </div>
  <a-button type="primary" @click="showModal">
    Создать задачу
  </a-button>
  <a-modal
    v-model:open="open"
    :title="isEdit ? `Редактировать проект ${formData?.refData?.name}` : 'Создать проект'"
    @ok="handleOk"
    @cancel="onClose()"
  >
    <task-form ref="taskRef" :data="formData.edit" @validated="addTask($event)" />
  </a-modal>
  <project-content :tasks-list="tasksList" @edit="editTask($event)" @change-page="onChange($event)" @delete="deleteTask" />
</template>

<script lang="ts" setup>

import ProjectContent from '@/components/ProjectContent.vue'
import { onMounted, reactive, ref } from 'vue'
import TaskForm from '@/components/Forms/TaskForm.vue'
import { useRoute } from 'vue-router'
import { message } from 'ant-design-vue'
import taskRepository from '@/repository/taskRepository.ts'

const open = ref<boolean>(false)
const route = useRoute()
const showModal = () => {
  open.value = true
}
const taskRef = ref(null)
const tasksList = ref([])
const formData = reactive({
  refData: null,
  edit: {
    name: ''
  }
})
const fetchTasks = async () => {
  const newData = {
    project_id: +route.params.id
  }
  const response = await taskRepository.index({ params: newData })
  tasksList.value = response.data.data
}

const onChange = async (data) => {
  const response = await taskRepository.index({ params: { project_id: +route.params.id, page: data } })
  tasksList.value = response.data.data
}

const isEdit = ref(false)
const addTask = async (data) => {
  try {
    if (!isEdit.value) {
      const newData = {
        project_id: route.params.id,
        ...data
      }
      await taskRepository.store(newData)
      message.success('Добавлена задача :)')
    } else {
      if (!formData.refData) return
      const newData = {
        project_id: route.params.id,
        ...data
      }
      await taskRepository.update(formData.refData.id, newData)
      message.warning('Обновлена задача :)')
    }
    await fetchTasks()
  } catch (e) {
    message.error('Ooops!Ошибка(')
  } finally {
    open.value = false
    isEdit.value = false
    taskRef.value.reset()
    await fetchTasks()
  }
}

const onClose = () => {
  open.value = false
  isEdit.value = false
  taskRef.value.reset()
}

const deleteTask = async (id) => {
  try {
    await taskRepository.delete(id)
    await fetchTasks()
    message.success('Удалена задача :)')
  } catch (e) {
    console.log(e)
    message.error('Ooops!Ошибка(')
  }
}

const editTask = (id) => {
  const data = tasksList?.value.data.find((project) => project.id === id)
  if (data) {
    formData.refData = data
    formData.edit.name = data.name
    isEdit.value = true
    showModal()
  }
}

onMounted(async () => {
  await fetchTasks()
})
const handleOk = () => {
  taskRef.value.validate()
  open.value = false
}
</script>
