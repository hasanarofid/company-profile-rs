<script setup>
import { ref, computed } from 'vue';
import { Link, usePage } from '@inertiajs/vue3';
import { Menu, X, CalendarCheck, PhoneCall, Clock, Cross, ShieldPlus } from '@lucide/vue';

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});
const mobileOpen = ref(false);

const navLinks = [
  { label: 'Beranda', href: '/', active: () => page.url === '/' },
  { label: 'Dokter & Poli', href: '/dokter', active: () => page.url.startsWith('/dokter') },
  { label: 'Artikel', href: '/artikel', active: () => page.url.startsWith('/artikel') },
  { label: 'Karir', href: '/karir', active: () => page.url.startsWith('/karir') },
  { label: 'Kontak', href: '/kontak', active: () => page.url.startsWith('/kontak') },
];
</script>

<template>
  <header class="sticky top-0 z-50 w-full">
    <!-- Top Emergency & Info Bar -->
    <div
      v-if="settings.show_emergency_bar !== false"
      class="bg-brand-deep text-white text-xs py-2 px-4 border-b border-white/10"
    >
      <div class="max-w-7xl mx-auto flex flex-wrap items-center justify-between gap-2">
        <div class="flex items-center gap-4 flex-wrap">
          <a
            :href="`tel:${settings.emergency_phone || '021500911'}`"
            class="inline-flex items-center gap-1.5 font-semibold text-rose-300 hover:text-white transition-colors"
          >
            <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
            <span>IGD 24 Jam: {{ settings.emergency_phone || '(021) 500-911' }}</span>
          </a>
          <span class="hidden sm:inline-flex items-center gap-1.5 text-white/80">
            <Clock class="w-3.5 h-3.5 text-brand-gold" />
            {{ settings.working_hours || 'IGD 24 Jam | Poli: Senin - Sabtu 07.00 - 21.00' }}
          </span>
        </div>
        <div class="hidden md:flex items-center gap-4 text-white/80">
          <a :href="`tel:${settings.phone}`" class="hover:text-white inline-flex items-center gap-1">
            <PhoneCall class="w-3.5 h-3.5" />
            <span>{{ settings.phone || '(021) 555-0199' }}</span>
          </a>
          <Link href="/login" class="hover:text-white text-white/70 transition-colors">
            Portal Admin
          </Link>
        </div>
      </div>
    </div>

    <!-- Main Navbar -->
    <nav class="bg-white/95 backdrop-blur-md border-b border-brand-sand shadow-sm">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-20 flex items-center justify-between gap-4">
        <!-- Brand Logo -->
        <Link href="/" class="flex items-center gap-3 shrink-0">
          <img
            v-if="settings.site_logo_url"
            :src="settings.site_logo_url"
            :alt="settings.site_name"
            class="h-11 w-auto object-contain"
          />
          <div
            v-else
            class="w-11 h-11 rounded-xl bg-brand-primary text-white flex items-center justify-center shadow-sm"
          >
            <ShieldPlus class="w-6 h-6" />
          </div>
          <div>
            <span class="block text-base sm:text-lg font-bold tracking-tight text-brand-dark leading-tight">
              {{ settings.site_name || 'RSU Medika Nusantara' }}
            </span>
            <span class="block text-[11px] font-medium text-brand-leaf tracking-wide">
              Pelayanan Medis Terpadu
            </span>
          </div>
        </Link>

        <!-- Desktop Links -->
        <div class="hidden lg:flex items-center gap-7">
          <Link
            v-for="item in navLinks"
            :key="item.href"
            :href="item.href"
            :class="[
              item.active()
                ? 'text-brand-primary font-semibold'
                : 'text-brand-dark/80 hover:text-brand-primary font-medium',
              'text-sm transition-colors'
            ]"
          >
            {{ item.label }}
          </Link>
        </div>

        <!-- CTA + Mobile Toggle -->
        <div class="flex items-center gap-3">
          <Link
            href="/janji-temu"
            class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-semibold shadow-sm transition-all"
          >
            <CalendarCheck class="w-4 h-4" />
            <span>Buat Janji Temu</span>
          </Link>

          <button
            @click="mobileOpen = !mobileOpen"
            class="lg:hidden p-2 rounded-xl border border-brand-sand text-brand-dark hover:bg-brand-sand/50"
            aria-label="Toggle Menu"
          >
            <X v-if="mobileOpen" class="w-6 h-6" />
            <Menu v-else class="w-6 h-6" />
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div
        v-if="mobileOpen"
        class="lg:hidden bg-white border-t border-brand-sand px-4 py-4 space-y-2 shadow-lg"
      >
        <Link
          v-for="item in navLinks"
          :key="item.href"
          :href="item.href"
          @click="mobileOpen = false"
          :class="[
            item.active() ? 'bg-brand-sand text-brand-primary font-semibold' : 'text-brand-dark hover:bg-brand-cream',
            'block px-4 py-2.5 rounded-xl text-sm'
          ]"
        >
          {{ item.label }}
        </Link>
        <Link
          href="/janji-temu"
          @click="mobileOpen = false"
          class="flex items-center justify-center gap-2 w-full px-4 py-3 rounded-xl bg-brand-primary text-white text-sm font-semibold mt-2"
        >
          <CalendarCheck class="w-4 h-4" />
          <span>Buat Janji Temu Dokter</span>
        </Link>
      </div>
    </nav>
  </header>
</template>
