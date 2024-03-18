<template>
  <div class="main-layout">
    <a-layout :style="{ height: '100vh' }">
      <a-layout-header :style="headerStyle">
        <the-header />
      </a-layout-header>
      <a-layout-content :style="contentStyle">
        <slot />
      </a-layout-content>
    </a-layout>
  </div>
</template>
<script lang="ts" setup>
import type { CSSProperties } from 'vue'
import TheHeader from '@/components/TheHeader/index.vue'

const headerStyle: CSSProperties = {
  textAlign: 'center',
  color: '#fff',
  height: 64,
  paddingInline: 50,
  backgroundColor: '#7dbcea'
}

const contentStyle: CSSProperties = {
  textAlign: 'center',
  gap: '50px',
  color: '#fff',
  backgroundColor: '#108ee9'
}

</script>
<style lang="scss" scoped>
  .main-layout{
    min-width: 100vh;
  }
</style>
