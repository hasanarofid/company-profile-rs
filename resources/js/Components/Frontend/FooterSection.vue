<script setup>
import { computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { MapPin, Phone, Mail, Clock, ShieldPlus, Ambulance } from '@lucide/vue';

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});
</script>

<template>
  <footer class="bg-brand-deep text-white pt-16 pb-8 border-t border-white/10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10 pb-12 border-b border-white/10">
        <!-- Brand Column -->
        <div class="space-y-4">
          <div class="flex items-center gap-3">
            <img
              v-if="settings.site_logo_url"
              :src="settings.site_logo_url"
              :alt="settings.site_name"
              class="h-10 w-auto object-contain bg-white rounded-lg p-1"
            />
            <div v-else class="w-10 h-10 rounded-xl bg-brand-primary flex items-center justify-center">
              <ShieldPlus class="w-6 h-6 text-white" />
            </div>
            <div>
              <h3 class="font-bold text-lg leading-tight">{{ settings.site_name || 'RSU Medika Nusantara' }}</h3>
              <p class="text-xs text-white/60">Terakreditasi Paripurna</p>
            </div>
          </div>
          <p class="text-sm text-white/75 leading-relaxed">
            {{ settings.site_description || 'Rumah sakit modern dengan layanan terpadu, dokter spesialis berpengalaman, dan fasilitas medis berstandar internasional.' }}
          </p>
          <div class="inline-flex items-center gap-2 px-3.5 py-2 rounded-xl bg-rose-600/20 border border-rose-500/30 text-rose-200 text-xs font-semibold">
            <Ambulance class="w-4 h-4 text-rose-400" />
            <span>IGD 24 Jam: {{ settings.emergency_phone || '(021) 500-911' }}</span>
          </div>
        </div>

        <!-- Layanan & Navigasi -->
        <div>
          <h4 class="text-sm font-bold uppercase tracking-wider text-white/90 mb-4">Layanan Pasien</h4>
          <ul class="space-y-2.5 text-sm text-white/70">
            <li><Link href="/janji-temu" class="hover:text-white transition-colors">Reservasi Janji Temu Online</Link></li>
            <li><Link href="/dokter" class="hover:text-white transition-colors">Direktori & Jadwal Dokter</Link></li>
            <li><Link href="/artikel" class="hover:text-white transition-colors">Artikel & Tips Kesehatan</Link></li>
            <li><Link href="/karir" class="hover:text-white transition-colors">Portal Karir & Rekrutmen</Link></li>
            <li><Link href="/kontak" class="hover:text-white transition-colors">Hubungi Kami</Link></li>
          </ul>
        </div>

        <!-- Jam Layanan -->
        <div>
          <h4 class="text-sm font-bold uppercase tracking-wider text-white/90 mb-4">Jam Operasional</h4>
          <ul class="space-y-3 text-sm text-white/70">
            <li class="flex items-start gap-2.5">
              <Clock class="w-4 h-4 text-brand-gold shrink-0 mt-0.5" />
              <span>IGD, Ambulans & Farmasi: <strong class="text-white">24 Jam</strong></span>
            </li>
            <li class="flex items-start gap-2.5">
              <Clock class="w-4 h-4 text-brand-gold shrink-0 mt-0.5" />
              <span>Poliklinik Spesialis: Senin - Sabtu (07.00 - 21.00 WIB)</span>
            </li>
            <li class="flex items-start gap-2.5">
              <Clock class="w-4 h-4 text-brand-gold shrink-0 mt-0.5" />
              <span>Medical Check Up: Senin - Sabtu (07.00 - 14.00 WIB)</span>
            </li>
          </ul>
        </div>

        <!-- Kontak & Alamat -->
        <div>
          <h4 class="text-sm font-bold uppercase tracking-wider text-white/90 mb-4">Kontak & Lokasi</h4>
          <ul class="space-y-3 text-sm text-white/70">
            <li class="flex items-start gap-2.5">
              <MapPin class="w-4 h-4 text-brand-gold shrink-0 mt-0.5" />
              <span>{{ settings.address || 'Jl. Kesehatan Raya No. 88, Jakarta Selatan' }}</span>
            </li>
            <li class="flex items-center gap-2.5">
              <Phone class="w-4 h-4 text-brand-gold shrink-0" />
              <span>{{ settings.phone || '(021) 555-0199' }}</span>
            </li>
            <li class="flex items-center gap-2.5">
              <Mail class="w-4 h-4 text-brand-gold shrink-0" />
              <span>{{ settings.email || 'info@medikanusantara.id' }}</span>
            </li>
          </ul>
        </div>
      </div>

      <div class="pt-6 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-white/55">
        <p>&copy; {{ new Date().getFullYear() }} {{ settings.site_name || 'RSU Medika Nusantara' }}. Hak Cipta Dilindungi.</p>
        <div class="flex items-center gap-4">
          <Link href="/login" class="hover:text-white transition-colors">Admin CMS</Link>
        </div>
      </div>
    </div>
  </footer>
</template>
