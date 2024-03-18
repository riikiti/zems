<template>
  <div class="home-content">
    <h1>Все проекты</h1>
    <template v-if="projects.data">
      <div class="home-content__grid">
        <base-card
          v-for="(project, idx) in projects.data"
          :key="idx"
          :title="project.name"
          @click.prevent="redirect(project.id)"
          @edit="handleEdit(project.id)"
          @delete="handleDelete(project.id)"
        >
          <template v-if="project.total_time" #additional>
            <div>
              <b>Затраченное время:</b>{{ project.total_time }}
            </div>
          </template>
        </base-card>
      </div>
      <div v-if="projects.meta && projects.meta.last_page > 1">
        <a-pagination
          :value="projects.meta.current_page"
          show-less-items
          :total="projects.meta.total"
          :default-page-size="projects.meta.per_page"
          @change="onChange($event)"
        />
      </div>
    </template>
  </div>
</template>

<script setup lang="ts">

import { toRefs } from 'vue'
import { useRouter } from 'vue-router'
import BaseCard from '@/components/BaseCard.vue'
import projectRepository from '@/repository/projectRepository.ts'

const router = useRouter()
const props = defineProps({
  projects: Object
})

const emits = defineEmits(['change-page', 'update', 'edit'])

const handleDelete = async (id) => {
  try {
    await projectRepository.delete(id)

    emits('update')
  } catch (e) {
    console.log('err: ', e)
  }
}
const handleEdit = async (id) => {
  try {
    emits('edit', id)
  } catch (e) {
    console.log('err: ', e)
  }
}
const redirect = (id) => {
  router.push({ name: 'project', params: { id } })
}

const onChange = (event) => {
  emits('change-page', event)
}

const { projects } = toRefs(props)
</script>
