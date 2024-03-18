<template>
  <div class="header-content">
    <router-link :to="authStore.isAuth ? '/platform' : '/'">
      <img src="../../assets/logo.svg" alt="logo" />
    </router-link>
    <div v-if="!authStore.isLoginIn">
      <a-button type="primary" @click="showModal">
        Авторизация / Регистрация
      </a-button>
      <a-modal v-model:open="open" :title="login ? 'Авторизация' : 'Регистрация'" @ok="handleOk">
        <template #footer>
          <a-button @click="toggleLogin">
            {{ login ? 'Регистрация' : 'Авторизация' }}
          </a-button>
          <a-button key="submit" type="primary" @click="handleOk">
            Подтвердить
          </a-button>
        </template>
        <login-form v-if="login" ref="loginRef" @validated="isLogin($event)" />
        <register-form v-else ref="registerRef" @validated="register($event)" />
      </a-modal>
    </div>
    <div v-else class="home-content__info">
      <user-menu @logout="logoutUser()" />
    </div>
  </div>
</template>

<script lang="ts" setup>
import { ref } from 'vue'
import router from '@/router'
import LoginForm from '@/components/Forms/LoginForm.vue'
import RegisterForm from '@/components/Forms/RegisterForm.vue'
import { message } from 'ant-design-vue'
import { useAuthStore } from '@/stores/auth'
import { storeToRefs } from 'pinia'
import UserMenu from '@/components/TheHeader/UserMenu.vue'

const authStore = useAuthStore()

const open = ref<boolean>(false)

const login = ref<boolean>(true)

const loginRef = ref(null)
const registerRef = ref(null)
const toggleLogin = () => {
  login.value = !login.value
}
const showModal = () => {
  open.value = true
}

const isLogin = async (data) => {
  await authStore.login(data)

  if (authStore.isAuth) {
    open.value = false
    await authStore.fetchUser()
    await router.push('/platform')
    message.success('Вы вошли в систему')
  }
}

const logoutUser = () => {
  authStore.logout()
  message.success('Вы вышли из системы')
  router.push('/')
}

const register = async (data) => {
  const newData = {
    email: data.email,
    password: data.password,
    confirm_password: data.confirm_password,
    name: data.name,
    role: 'user'
  }
  await authStore.register(newData)
  if (authStore.isAuth) {
    await authStore.fetchUser()
    await router.push('/platform')
    message.success('Вы вошли в систему')
  }
}
const handleOk = async () => {
  if (login.value) {
    loginRef.value.validate()
  } else {
    registerRef.value.validate()
  }
}

</script>

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
