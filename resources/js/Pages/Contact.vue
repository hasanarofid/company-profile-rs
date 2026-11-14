<script setup>
import { computed } from 'vue';
import { Head, usePage, Link } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { MapPin, Phone, Mail, Clock, Ambulance, CalendarCheck } from '@lucide/vue';

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});
</script>

<template>
  <Head title="Kontak & Lokasi Rumah Sakit" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <section class="bg-brand-deep text-white py-12">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-2">
        <h1 class="text-3xl sm:text-4xl font-extrabold">Hubungi & Kunjungi Kami</h1>
        <p class="text-white/80 text-sm sm:text-base">Layanan informasi pasien, pengaduan mutu, serta akses darurat IGD 24 jam.</p>
      </div>
    </section>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-12">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="bg-white p-7 rounded-2xl border border-brand-sand shadow-sm space-y-4">
          <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-600 flex items-center justify-center">
            <Ambulance class="w-6 h-6" />
          </div>
          <h2 class="text-lg font-bold text-brand-dark">IGD & Ambulans 24 Jam</h2>
          <p class="text-sm text-brand-leaf">Untuk kondisi kegawatdaruratan medis, segera hubungi hotline darurat kami.</p>
          <p class="text-2xl font-extrabold text-rose-600">{{ settings.emergency_phone || '(021) 500-911' }}</p>
        </div>

        <div class="bg-white p-7 rounded-2xl border border-brand-sand shadow-sm space-y-4">
          <div class="w-12 h-12 rounded-xl bg-brand-sand text-brand-primary flex items-center justify-center">
            <Phone class="w-6 h-6" />
          </div>
          <h2 class="text-lg font-bold text-brand-dark">Pusat Informasi & Pendaftaran</h2>
          <p class="text-sm text-brand-leaf flex items-center gap-2"><Phone class="w-4 h-4 text-brand-primary" /> {{ settings.phone || '(021) 555-0199' }}</p>
          <p class="text-sm text-brand-leaf flex items-center gap-2"><Mail class="w-4 h-4 text-brand-primary" /> {{ settings.email || 'info@medikanusantara.id' }}</p>
          <p class="text-sm text-brand-leaf flex items-center gap-2"><Clock class="w-4 h-4 text-brand-primary" /> {{ settings.working_hours }}</p>
        </div>

        <div class="bg-white p-7 rounded-2xl border border-brand-sand shadow-sm space-y-4">
          <div class="w-12 h-12 rounded-xl bg-brand-sand text-brand-primary flex items-center justify-center">
            <MapPin class="w-6 h-6" />
          </div>
          <h2 class="text-lg font-bold text-brand-dark">Alamat Rumah Sakit</h2>
          <p class="text-sm text-brand-leaf leading-relaxed">{{ settings.address }}</p>
          <div class="pt-2 flex flex-wrap gap-2">
            <a
              v-if="settings.maps_url"
              :href="settings.maps_url"
              target="_blank"
              class="px-4 py-2 rounded-xl bg-brand-primary text-white text-xs font-bold"
            >
              Buka Google Maps
            </a>
            <Link href="/janji-temu" class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl border border-brand-sand text-xs font-bold text-brand-dark">
              <CalendarCheck class="w-3.5 h-3.5" /> Buat Janji Temu
            </Link>
          </div>
        </div>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
