<template>
  <a-button type="primary" @click="showModal">Создать проект</a-button>
  <a-modal v-model:open="open" :title="isEdit?`Редактировать проект ${formData?.refData?.name}`:'Создать проект'" @ok="handleOk" @cancel="onClose">
    <project-form  ref="projectRef" :data="newFormData"  @validated="addProject($event)"/>
  </a-modal>
  <platform-content @edit="handleEdit($event)" :projects="projects" @change-page="onChange($event)" @update="projectList()" />
</template>
<script lang="ts" setup>

import PlatformContent from "@/components/PlatformContent.vue";
import {onMounted, ref} from 'vue';
import ProjectForm from "@/components/Forms/ProjectForm.vue";
import router from "@/router";
import projectRepository from "@/repository/projectRepository";
import taskRepository from "@/repository/taskRepository";

const open = ref<boolean>(false);



const showModal = () => {
  open.value = true;
};
const projectRef=ref(null)
const formData=ref({
  refData:null,
})
const newFormData=ref({
    name:'',
    description:''
})

const isEdit=ref(false)

const addProject = async data => {
  try{
    if(!isEdit.value){
      await projectRepository.store(data)
    }else {
      console.log("test: ",formData?.value.refData.id,data)
      const resp=await projectRepository.update(formData.value.refData.id,data)
      console.log("updae: resp: ",resp)
    }
    await projectList()
    projectRef.value.reset()
    newFormData.value.name=''
    newFormData.value.description=''
    formData.value={
      refData:null,
    }
  }catch (e){
    console.log(e)
  }finally {
    open.value=false
    isEdit.value=false
  }
}


const handleEdit=(id)=>{
  const data=projects.value?.data.find(project=>project.id===id)
  if(data){
    newFormData.value.name=data.name
    newFormData.value.description=data.description
    formData.value={
      refData:data,
    }
    isEdit.value=true
    console.log(formData.value)
    showModal()
  }

}
const onClose=()=>{
  open.value=false
  isEdit.value=false
  newFormData.value.name=''
  newFormData.value.description=''
  formData.value={
    refData:null,
  }
}


const projectList=async ()=>{
  const response=await projectRepository.index()
  projects.value=response.data.data
}

const projects=ref({})
const onChange=async (data)=>{
  const response=await projectRepository.index({params: {page: data}})
  projects.value=response.data.data
}

const handleOk = (e: MouseEvent) => {
  projectRef.value.validate()
};
onMounted(async ()=>{
  await projectList()
})
</script>