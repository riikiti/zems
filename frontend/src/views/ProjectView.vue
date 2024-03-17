<template>
  <div>
    Проект {{ route.params.id }}
  </div>
  <a-button type="primary" @click="showModal">Создать задачу</a-button>
  <a-modal v-model:open="open" :title="isEdit?`Редактировать проект ${formData?.refData?.name}`:'Создать проект'" @ok="handleOk" @cancel="onClose()">
    <task-form :data="formData.edit"  ref="taskRef" @validated="addTask($event)"/>
  </a-modal>
  <project-content  @edit="editTask($event)"  @change-page="onChange($event)" :tasks-list="tasksList" @delete="deleteTask"/>
</template>

<script lang="ts" setup>

import ProjectContent from "@/components/ProjectContent.vue";
import {onMounted, reactive, ref} from 'vue';
import TaskForm from "@/components/Forms/TaskForm.vue";
import {useRoute, useRouter} from "vue-router";
import taskRepository from "@/repository/taskRepository";

const open = ref<boolean>(false);
const route=useRoute()
const showModal = () => {
  open.value = true;
};
const taskRef=ref(null)
const tasksList=ref([])
const formData=reactive({
  refData:null,
  edit:{
    name:''
  }
})

const isEdit=ref(false)
const addTask=async (data)=>{
  try{
    if(!isEdit.value){
      const newData={
        project_id:route.params.id,
        ...data
      }
      const response=await taskRepository.store(newData)
    }else{
      const newData={
        project_id:route.params.id,
        ...data
      }
      const response=await taskRepository.update(formData.refData.id,newData)
    }
    await fetchTasks()
  }catch (e){
    console.log(e)
  }
  finally {
    open.value=false
    isEdit.value=false
    taskRef.value.reset()
    await fetchTasks()
  }
}

const onClose=()=>{
  open.value=false
  isEdit.value=false
  taskRef.value.reset()
}

const deleteTask=async (id)=>{
  try{
    const response=await taskRepository.delete(id)
    await fetchTasks()
  }catch (e){
    console.log(e)
  }
}




const editTask=(id)=>{
  console.log("fsfda: ",tasksList)
  const data=tasksList?.value.data.find(project=>project.id===id)
  console.log(data)
  if(data){
    formData.refData=data
    formData.edit.name=data.name
    isEdit.value=true
    console.log("dadds",formData)
    showModal()
  }
}



const fetchTasks=async ()=>{
  const newData={
    project_id:+route.params.id,
  }
  console.log(newData)
  const response=await taskRepository.index({params:newData})
  tasksList.value=response.data.data
  console.log(tasksList.value)
}

const onChange=async (data)=>{
  const response=await taskRepository.index({params: {project_id:+route.params.id,page: data}})
  tasksList.value=response.data.data
}

onMounted(async ()=>{
await fetchTasks()
})
const handleOk = (e: MouseEvent) => {
  console.log(e);
  taskRef.value.validate()
  open.value = false;
};
</script>

<style scoped lang="scss">

</style>