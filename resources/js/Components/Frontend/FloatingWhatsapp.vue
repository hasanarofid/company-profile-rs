<script setup>
import { computed } from 'vue';
import { usePage } from '@inertiajs/vue3';
import { MessageCircle } from '@lucide/vue';

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});
const waUrl = computed(() => {
  const num = (settings.value.whatsapp_number || '6281234567890').replace(/[^0-9]/g, '');
  const text = encodeURIComponent(`Halo ${settings.value.site_name || 'RSU Medika Nusantara'}, saya ingin menanyakan informasi layanan & jadwal dokter.`);
  return `https://wa.me/${num}?text=${text}`;
});
</script>

<template>
  <a
    :href="waUrl"
    target="_blank"
    rel="noopener noreferrer"
    class="fixed bottom-6 right-6 z-40 inline-flex items-center gap-2.5 px-4 py-3 rounded-full bg-emerald-600 hover:bg-emerald-700 text-white shadow-lg hover:shadow-xl transition-all duration-200 group"
    aria-label="Hubungi WhatsApp Rumah Sakit"
  >
    <MessageCircle class="w-5 h-5" />
    <span class="text-sm font-semibold hidden sm:inline">Tanya CS / WhatsApp</span>
  </a>
</template>
