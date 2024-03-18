<script setup lang="ts">
import { useAuthStore } from '@/stores/auth.ts'
import { storeToRefs } from 'pinia'
import { Modal } from 'ant-design-vue'
import {
  ExclamationCircleOutlined,
  LogoutOutlined,
  AppstoreOutlined,
  UpOutlined,
  DownOutlined
} from '@ant-design/icons-vue'
import { computed, h, ref } from 'vue'

const [modal, contextHolder] = Modal.useModal()
const authStore = useAuthStore()
const { user } = storeToRefs(authStore)

const emits = defineEmits<{
  (e:'logout'):void
}>()

const showConfirm = () => {
  modal.confirm({
    title: 'Вы действительно хотите выйти?',
    icon: h(ExclamationCircleOutlined),
    onOk() {
      emits('logout')
    },
    onCancel() {}
  })
}

const userMenuDropdownState = ref(false)

const userMenuDropdownIcon = computed(() => (userMenuDropdownState.value ? h(UpOutlined) : h(DownOutlined)))

const userMenu = [
  {
    name: 'Platform',
    link: '/platform',
    icon: () => h(AppstoreOutlined)
  }
]

</script>

<template>
  <div v-if="user">
    <a-dropdown v-model:open="userMenuDropdownState" :trigger="['click']">
      <div class="user-menu">
        <div>{{ user.name }}</div>
        <component :is="userMenuDropdownIcon" />
      </div>
      <template #overlay>
        <a-menu>
          <a-menu-item v-for="(menu, index) in userMenu" :key="index">
            <router-link :to="menu.link" class="user-menu">
              <component :is="menu.icon" />
              <span>{{ menu.name }}</span>
            </router-link>
          </a-menu-item>
          <a-menu-divider />
          <a-menu-item class="">
            <a-button type="primary" danger class="menu-item" @click="showConfirm()">
              <template #icon>
                <LogoutOutlined />
              </template>
              Выйти
            </a-button>
          </a-menu-item>
        </a-menu>
      </template>
    </a-dropdown>
  </div>
  <contextHolder />
</template>

<style scoped lang="scss">
  .menu-item{
    margin: 0;
    width: 100%;
  }
  .user-menu{
    display: flex;
    align-items: center;
    gap: 10px;
  }
</style>
