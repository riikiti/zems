<template>
  <a-layout :style ="{height: '100vh'}">
    <a-layout-header :style="headerStyle"><header-content/></a-layout-header>
    <a-layout-content :style="contentStyle"><slot/></a-layout-content>
<!--    <a-layout-footer :style="footerStyle"><footer-content/></a-layout-footer>-->
  </a-layout>
</template>
<script lang="ts" setup>
import type { CSSProperties } from 'vue';
import HeaderContent from "@/components/HeaderContent.vue";
import FooterContent from "@/components/FooterContent.vue";
import HomeContent from "@/components/HomeContent.vue";
const headerStyle: CSSProperties = {
  textAlign: 'center',
  color: '#fff',
  height: 64,
  paddingInline: 50,
  backgroundColor: '#7dbcea',
};

const contentStyle: CSSProperties = {
  textAlign: 'center',
  gap:'50px',
  color: '#fff',
  backgroundColor: '#108ee9',
};

const siderStyle: CSSProperties = {
  textAlign: 'center',
  color: '#fff',
  backgroundColor: '#3ba0e9',
};

const footerStyle: CSSProperties = {
  textAlign: 'center',
  color: '#fff',
  backgroundColor: '#7dbcea',
};
</script>