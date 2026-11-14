<script setup>
import { ref, computed } from 'vue';
import { Link, router, usePage } from '@inertiajs/vue3';
import {
  LayoutDashboard,
  CalendarCheck,
  Building2,
  Stethoscope,
  Briefcase,
  FileText,
  Layers,
  Palette,
  Menu,
  X,
  LogOut,
  ExternalLink,
  ShieldPlus,
  ChevronLeft,
  ChevronRight,
  CheckCircle2
} from '@lucide/vue';

const page = usePage();
const user = computed(() => page.props.auth?.user || {});
const settings = computed(() => page.props.siteSettings || {});
const flashSuccess = computed(() => page.props.flash?.success);

const isSidebarOpen = ref(false);
const isSidebarCollapsed = ref(false);

const navigation = [
  { name: 'Dashboard', href: route('admin.dashboard'), icon: LayoutDashboard, current: () => route().current('admin.dashboard') },
  { name: 'Janji Temu Pasien', href: route('admin.appointments.index'), icon: CalendarCheck, current: () => route().current('admin.appointments.*') },
  { name: 'Unit & Poliklinik', href: route('admin.departments.index'), icon: Building2, current: () => route().current('admin.departments.*') },
  { name: 'Dokter & Jadwal', href: route('admin.doctors.index'), icon: Stethoscope, current: () => route().current('admin.doctors.*') },
  { name: 'Karir & Pelamar', href: route('admin.careers.index'), icon: Briefcase, current: () => route().current('admin.careers.*') },
  { name: 'Artikel & Berita', href: route('admin.posts.index'), icon: FileText, current: () => route().current('admin.posts.*') },
  { name: 'Layout Builder', href: route('admin.pages.index'), icon: Layers, current: () => route().current('admin.pages.*') },
  { name: 'Pengaturan & Tema', href: route('admin.settings.index'), icon: Palette, current: () => route().current('admin.settings.*') },
];

const logout = () => {
  router.post(route('logout'));
};
</script>

<template>
  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans antialiased">
    <!-- Mobile Backdrop -->
    <div
      v-if="isSidebarOpen"
      @click="isSidebarOpen = false"
      class="fixed inset-0 z-40 bg-brand-deep/70 backdrop-blur-sm lg:hidden"
    ></div>

    <!-- Sidebar -->
    <aside
      :class="[
        isSidebarOpen ? 'translate-x-0' : '-translate-x-full lg:translate-x-0',
        isSidebarCollapsed ? 'lg:w-20' : 'lg:w-68',
        'fixed top-0 bottom-0 left-0 z-50 w-68 bg-brand-deep text-white border-r border-white/10 shadow-xl transition-all duration-300 flex flex-col justify-between'
      ]"
    >
      <div class="flex flex-col flex-1 overflow-hidden">
        <!-- Brand Header -->
        <div :class="[isSidebarCollapsed ? 'lg:justify-center lg:px-0' : 'px-5 justify-between', 'flex items-center h-20 border-b border-white/10 shrink-0']">
          <Link :href="route('admin.dashboard')" class="flex items-center gap-3 overflow-hidden">
            <img
              v-if="settings.site_logo_url"
              :src="settings.site_logo_url"
              alt="Logo RS"
              class="w-10 h-10 object-contain bg-white rounded-xl p-1 shrink-0"
            />
            <div v-else class="w-10 h-10 rounded-xl bg-brand-primary flex items-center justify-center shrink-0">
              <ShieldPlus class="w-6 h-6 text-white" />
            </div>
            <div v-if="!isSidebarCollapsed" class="truncate">
              <p class="text-sm font-bold text-white truncate">{{ settings.site_name || 'RSU Medika Nusantara' }}</p>
              <p class="text-[10px] text-amber-300 font-semibold uppercase tracking-wider">Hospital Admin CMS</p>
            </div>
          </Link>
          <button @click="isSidebarOpen = false" class="lg:hidden p-1.5 text-white/70 hover:text-white">
            <X class="w-5 h-5" />
          </button>
        </div>

        <!-- Nav Links -->
        <nav class="flex-1 px-3 py-5 space-y-1 overflow-y-auto">
          <Link
            v-for="item in navigation"
            :key="item.name"
            :href="item.href"
            :class="[
              item.current()
                ? 'bg-brand-primary text-white font-semibold shadow-sm'
                : 'text-white/75 hover:bg-white/10 hover:text-white',
              isSidebarCollapsed ? 'lg:justify-center lg:px-0' : 'px-3.5',
              'flex items-center py-2.5 rounded-xl text-sm transition-colors'
            ]"
            :title="isSidebarCollapsed ? item.name : ''"
          >
            <component :is="item.icon" :class="[isSidebarCollapsed ? '' : 'mr-3', 'w-5 h-5 shrink-0']" />
            <span v-if="!isSidebarCollapsed" class="truncate">{{ item.name }}</span>
          </Link>
        </nav>
      </div>

      <!-- Footer -->
      <div class="p-3 border-t border-white/10 space-y-2 shrink-0">
        <div class="hidden lg:flex items-center justify-between px-2">
          <span v-if="!isSidebarCollapsed" class="text-xs text-white/60 truncate">{{ user.name }}</span>
          <button
            @click="isSidebarCollapsed = !isSidebarCollapsed"
            class="p-1.5 rounded-lg bg-white/10 hover:bg-white/20 text-white/80 ml-auto"
          >
            <ChevronRight v-if="isSidebarCollapsed" class="w-4 h-4" />
            <ChevronLeft v-else class="w-4 h-4" />
          </button>
        </div>
        <button
          @click="logout"
          :class="[isSidebarCollapsed ? 'lg:justify-center' : 'px-3.5', 'w-full flex items-center py-2.5 rounded-xl text-sm text-rose-300 hover:bg-rose-500/20 transition-colors']"
        >
          <LogOut :class="[isSidebarCollapsed ? '' : 'mr-3', 'w-4 h-4 shrink-0']" />
          <span v-if="!isSidebarCollapsed">Keluar</span>
        </button>
      </div>
    </aside>

    <!-- Main Content -->
    <div :class="[isSidebarCollapsed ? 'lg:pl-20' : 'lg:pl-68', 'transition-all duration-300 min-h-screen flex flex-col']">
      <header class="sticky top-0 z-30 h-16 bg-white/90 backdrop-blur-md border-b border-brand-sand px-4 sm:px-8 flex items-center justify-between">
        <div class="flex items-center gap-3">
          <button
            @click="isSidebarOpen = true"
            class="lg:hidden p-2 rounded-xl border border-brand-sand text-brand-dark"
          >
            <Menu class="w-5 h-5" />
          </button>
          <span class="text-sm font-semibold text-brand-leaf hidden sm:inline">
            Panel Manajemen Rumah Sakit
          </span>
        </div>

        <div class="flex items-center gap-3">
          <a
            href="/"
            target="_blank"
            class="inline-flex items-center gap-1.5 px-3.5 py-2 rounded-xl bg-brand-sand/70 hover:bg-brand-sand text-brand-dark text-xs font-bold transition-colors"
          >
            <span>Lihat Website</span>
            <ExternalLink class="w-3.5 h-3.5" />
          </a>
        </div>
      </header>

      <main class="flex-1 p-4 sm:p-8 max-w-7xl w-full mx-auto">
        <div
          v-if="flashSuccess"
          class="mb-6 p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-center gap-2.5"
        >
          <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0" />
          <span>{{ flashSuccess }}</span>
        </div>

        <slot />
      </main>
    </div>
  </div>
</template>
