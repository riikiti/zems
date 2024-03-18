<template>
  <a-button type="primary" @click="showModal">
    Создать проект
  </a-button>
  <a-modal
    v-model:open="open"
    :title="isEdit ? `Редактировать проект ${formData?.refData?.name}` : 'Создать проект'"
    @ok="handleOk"
    @cancel="onClose"
  >
    <project-form ref="projectRef" :data="newFormData" @validated="addProject($event)" />
  </a-modal>
  <platform-content
    :projects="projects"
    @edit="handleEdit($event)"
    @change-page="onChange($event)"
    @update="projectList()"
  />
</template>
<script lang="ts" setup>

import PlatformContent from '@/components/PlatformContent.vue'
import { onMounted, ref } from 'vue'
import { message } from 'ant-design-vue'
import ProjectForm from '@/components/Forms/ProjectForm.vue'
import projectRepository from '@/repository/projectRepository'

const open = ref<boolean>(false)

const showModal = () => {
  open.value = true
}
const projectRef = ref(null)
const formData = ref({
  refData: null
})
const newFormData = ref({
  name: '',
  description: ''
})

const isEdit = ref(false)

const addProject = async (data) => {
  try {
    if (!isEdit.value) {
      await projectRepository.store(data)
      message.success('Добавлен проект :)')
    } else {
      if (!formData.value.refData) return
      await projectRepository.update(formData.value.refData?.id, data)
      message.warning('Проект был обновлен:)')
    }
    await projectList()
    projectRef.value.reset()
    newFormData.value.name = ''
    newFormData.value.description = ''
    formData.value = {
      refData: null
    }
  } catch (e) {
    message.error('Произошла ошибка.Попробуйте еще раз!')
  } finally {
    open.value = false
    isEdit.value = false
  }
}

const handleEdit = (id:number) => {
  const data = projects.value?.data.find((project) => project.id === id)
  if (data) {
    newFormData.value.name = data.name
    newFormData.value.description = data.description
    formData.value = {
      refData: data
    }
    isEdit.value = true
    showModal()
  }
}
const onClose = () => {
  open.value = false
  isEdit.value = false
  newFormData.value.name = ''
  newFormData.value.description = ''
  formData.value = {
    refData: null
  }
}

const projectList = async () => {
  const response = await projectRepository.index()
  projects.value = response.data.data
}

const projects = ref({})
const onChange = async (data) => {
  const response = await projectRepository.index({ params: { page: data } })
  projects.value = response.data.data
}

const handleOk = (e: MouseEvent) => {
  projectRef.value.validate()
}
onMounted(async () => {
  await projectList()
})
</script>
