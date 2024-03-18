<template>
  <div class="home-content">
    <h1>Проект </h1>
    <h3>Все задачи</h3>
    <div class="home-content__grid">
      <base-card
        v-for="task in tasksList.data"
        :key="task.id"
        :title="task.name"
        @click="redirect(task.id)"
        @edit="handleEdit(task.id)"
        @delete="handleDelete(task.id)"
      >
        <template v-if="task.total_time" #additional>
          <div>
            <b>Затраченное время:</b>{{ task.total_time }}
          </div>
        </template>
      </base-card>
    </div>
    <div v-if="tasksList.meta && tasksList.meta.last_page > 1">
      <a-pagination
        :value="tasksList.meta.current_page"
        show-less-items
        :total="tasksList.meta.total"
        :default-page-size="tasksList.meta.per_page"
        @change="onChange($event)"
      />
    </div>
  </div>
</template>

<script setup>

import { ref, toRefs } from 'vue'
import { useRouter } from 'vue-router'
import BaseCard from '@/components/BaseCard.vue'

const router = useRouter()
const props = defineProps({
  tasksList: Object
})

const emits = defineEmits(['change-page', 'delete', 'edit'])

const handleDelete = (id) => {
  emits('delete', id)
}
const handleEdit = (id) => {
  emits('edit', id)
}

const redirect = (id) => {
  router.push({ name: 'task', params: { id } })
}

const onChange = (event) => {
  emits('change-page', event)
}

const { tasksList } = toRefs(props)

</script>
