<template>
  <h1> Потраченное время</h1>
  <a-table
    v-if="timeList"
    :pagination="{
      pageSize: 6,
    }"
    :columns="columns"
    :data-source="timeList"
  >
    <template #bodyCell="{ column, record }">
      <template v-if="column.key === 'action'">
        <span>
          <a-button type="primary" danger @click="emits('delete', record)">Удалить</a-button>
        </span>
      </template>
    </template>
  </a-table>
</template>
<script lang="ts" setup>

interface IProps {
  timeList:Object
}

const props = defineProps<IProps>()

const emits = defineEmits<{
  (e: 'delete', data:any): void

}>()

const columns = [
  {
    title: 'Начало',
    dataIndex: 'time_start',
    key: 'time_start'
  },
  {
    title: 'Конец',
    dataIndex: 'time_finish',
    key: 'time_finish'
  },
  {
    title: 'Затраченное время',
    dataIndex: 'time',
    key: 'time'
  },
  {
    title: 'Дейстивие',
    key: 'action'
  }
]

</script>
