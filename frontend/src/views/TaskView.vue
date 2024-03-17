<template>
  <a-button type="primary" @click="showModal">Добавить время</a-button>
  <a-modal v-model:open="open" title="Добавить время" @ok="handleOk" @cancel="">
    <task-time-form ref="taskTimeRef"  @validated="addTaskTime($event)" @change-date="changeDate($event)"/>
  </a-modal>
    <task-content :time-list="taskList" @delete="handleDelete($event)"  />
</template>
<script lang="ts" setup>

import TaskContent from "@/components/TaskContent.vue";
import {onMounted, ref} from 'vue';
import TaskTimeForm from "@/components/Forms/TaskTimeForm.vue";
import type {ITaskTime} from "@/services/models";
import taskRepository from "@/repository/taskRepository";
import {useRoute, useRouter} from "vue-router";
import timeRepository from "@/repository/timeRepository";

const open = ref<boolean>(false);

const TaskTime=ref<ITaskTime>()

const changeDate=(date:ITaskTime)=>{
  TaskTime.value=date
}

const route=useRoute()
const taskTimeRef=ref(null)


const showModal = () => {
  open.value = true;
};

const addTaskTime=async (data)=>{
  try{
    const newData={
      task_id:route.params.id,
      time_start:data.rangeTaskTime[0],
      time_finish:data.rangeTaskTime[1]
    }
    const response=await timeRepository.store(newData)
    console.log(response)
    await fetchTaskList()
  }catch (e){
    console.log("err: ",e)
  }finally {
    taskTimeRef.value.reset()
    open.value = false;
  }
}


const handleDelete=async (data)=>{
  try{
    console.log(data)
    const response = await timeRepository.delete(data.id);
    await fetchTaskList()
    console.log("del: ",response)
  }catch (e){
    console.log("err: ",e)
  }
}

const taskList=ref(null)

const fetchTaskList = async () => {
  try{
    const response = await timeRepository.index({params:{task_id:route.params.id}});
    console.log("fff: ",response)
    taskList.value = response.data.data;
    console.log("fasdf: ",taskList.value)
  }catch (e){
    console.log("err: ",e)
  }

}
onMounted(async ()=>{
  await fetchTaskList()
})



const handleOk = async (e: MouseEvent) => {
 try{
   taskTimeRef.value.validate()
 }catch (e){
   console.log(e)
 }
};
</script>