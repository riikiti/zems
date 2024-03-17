<template>
  <div class="header-content">
    <router-link :to="authStore.isAuth?'/platform':'/'">
      <img src="../assets/logo.svg" alt="logo">
    </router-link>
    <div v-if="!authStore.isLoginIn">
      <a-button type="primary" @click="showModal">Авторизация / Регистрация</a-button>
      <a-modal v-model:open="open" :title="login ? 'Авторизация' :'Регистрация'" @ok="handleOk">
        <template #footer>
          <a-button @click="toggleLogin">
            {{ login ? 'Регистрация' : 'Авторизация' }}
          </a-button>
          <a-button key="submit" type="primary" @click="handleOk">Подтвердить</a-button>
        </template>
        <login-form v-if='login' ref="loginRef" @validated="isLogin($event)"/>
        <register-form v-else ref="registerRef" @validated="register($event)"/>
      </a-modal>
    </div>
    <div v-else class="home-content__info">
      {{ user?.name }}
      <div @click="logoutUser()">
        logout
      </div>
    </div>
  </div>
</template>

<style scoped lang="scss">
.header-content {
  height: 100%;

  display: flex;
  flex-direction: row;
  justify-content: space-between;
  align-items: center;

  img {
    width: max-content;
  }
}
</style>

<script lang="ts" setup>
import {computed, onMounted, ref} from 'vue';
import router from "@/router";
import LoginForm from "@/components/Forms/LoginForm.vue";
import RegisterForm from "@/components/Forms/RegisterForm.vue";
import {message} from "ant-design-vue";
import {useAuthStore} from "@/stores/auth";
import {storeToRefs} from "pinia";

const authStore = useAuthStore()

const open = ref<boolean>(false);

const login = ref<boolean>(true);

const loginRef = ref(null);
const registerRef = ref(null);
const toggleLogin = () => {
  login.value = !login.value;
}
const showModal = () => {
  open.value = true;
};

const {user}=storeToRefs(authStore)


const isLogin = async data => {
  console.log(data)
  await authStore.login(data)

  if (authStore.isAuth) {
    open.value = false;
    await authStore.fetchUser()
    await router.push('/platform')
  }
}

const logoutUser=()=>{
  authStore.logout()
  router.push('/')
}

const register = async data => {
  const newData = {
    email: data.email,
    password: data.password,
    confirm_password: data.confirm_password,
    name: data.name,
    role: 'user',
  }
  await authStore.register(newData)
  if (authStore.isAuth) {
     await authStore.fetchUser()
     await router.push('/platform')
  }
}
const handleOk = async (e: MouseEvent) => {
  if (login.value) {
    loginRef.value.validate()
  } else {
    registerRef.value.validate()
  }
};


</script>