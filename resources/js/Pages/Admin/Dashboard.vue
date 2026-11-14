<script setup>
import { Head, Link } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { CalendarCheck, Stethoscope, Building2, Briefcase, FileText, ArrowRight, Clock } from '@lucide/vue';

defineProps({
  stats: { type: Object, required: true },
  recentAppointments: { type: Array, default: () => [] },
  recentApplications: { type: Array, default: () => [] },
});

const statusColors = {
  pending: 'bg-amber-100 text-amber-800',
  confirmed: 'bg-emerald-100 text-emerald-800',
  completed: 'bg-sky-100 text-sky-800',
  cancelled: 'bg-rose-100 text-rose-800',
  submitted: 'bg-amber-100 text-amber-800',
  reviewed: 'bg-sky-100 text-sky-800',
  interview: 'bg-indigo-100 text-indigo-800',
  accepted: 'bg-emerald-100 text-emerald-800',
  rejected: 'bg-rose-100 text-rose-800',
};
</script>

<template>
  <Head title="Dashboard Admin Rumah Sakit" />

  <AdminLayout>
    <div class="space-y-8">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">Dashboard Manajemen RS</h1>
          <p class="text-sm text-brand-leaf mt-1">Ringkasan janji temu pasien, direktori dokter, lowongan karir, dan konten website.</p>
        </div>
        <div class="flex items-center gap-2">
          <Link :href="route('admin.pages.index')" class="px-4 py-2.5 rounded-xl bg-white border border-brand-sand text-xs font-bold text-brand-dark hover:bg-brand-sand/40">
            Layout Builder
          </Link>
          <Link :href="route('admin.settings.index')" class="px-4 py-2.5 rounded-xl bg-brand-primary text-white text-xs font-bold hover:bg-brand-dark">
            Theme Customizer
          </Link>
        </div>
      </div>

      <!-- KPI Cards -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
        <div class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase text-brand-leaf">Janji Temu</span>
            <CalendarCheck class="w-5 h-5 text-brand-primary" />
          </div>
          <p class="text-3xl font-extrabold text-brand-dark mt-3">{{ stats.appointments_total }}</p>
          <p class="text-xs text-amber-700 font-semibold mt-1">{{ stats.appointments_pending }} menunggu konfirmasi</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase text-brand-leaf">Dokter & Poli</span>
            <Stethoscope class="w-5 h-5 text-brand-primary" />
          </div>
          <p class="text-3xl font-extrabold text-brand-dark mt-3">{{ stats.doctors_active }}</p>
          <p class="text-xs text-brand-leaf mt-1">Tersebar di {{ stats.departments_active }} unit/poli aktif</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase text-brand-leaf">Karir & Pelamar</span>
            <Briefcase class="w-5 h-5 text-brand-primary" />
          </div>
          <p class="text-3xl font-extrabold text-brand-dark mt-3">{{ stats.applications_total }}</p>
          <p class="text-xs text-brand-leaf mt-1">{{ stats.careers_active }} lowongan dibuka</p>
        </div>

        <div class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm">
          <div class="flex items-center justify-between">
            <span class="text-xs font-bold uppercase text-brand-leaf">Artikel Terbit</span>
            <FileText class="w-5 h-5 text-brand-primary" />
          </div>
          <p class="text-3xl font-extrabold text-brand-dark mt-3">{{ stats.articles_published }}</p>
          <p class="text-xs text-brand-leaf mt-1">Tips kesehatan & berita RS</p>
        </div>
      </div>

      <!-- Recent Tables -->
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Appointments -->
        <div class="bg-white rounded-2xl border border-brand-sand shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b border-brand-sand flex items-center justify-between">
            <h2 class="font-bold text-brand-dark">Janji Temu Terbaru</h2>
            <Link :href="route('admin.appointments.index')" class="text-xs font-bold text-brand-primary inline-flex items-center gap-1">
              Kelola <ArrowRight class="w-3.5 h-3.5" />
            </Link>
          </div>
          <div class="divide-y divide-brand-sand">
            <div v-for="apt in recentAppointments" :key="apt.id" class="p-4 flex items-center justify-between gap-4">
              <div>
                <p class="font-bold text-sm text-brand-dark">{{ apt.patient_name }} <span class="text-xs font-normal text-brand-leaf">({{ apt.booking_code }})</span></p>
                <p class="text-xs text-brand-leaf mt-0.5">{{ apt.doctor?.name }} &bull; {{ apt.appointment_date }}</p>
              </div>
              <span :class="[statusColors[apt.status] || 'bg-slate-100 text-slate-700', 'px-2.5 py-1 rounded-full text-[11px] font-bold uppercase']">
                {{ apt.status }}
              </span>
            </div>
            <div v-if="!recentAppointments.length" class="p-6 text-center text-sm text-brand-leaf">Belum ada janji temu.</div>
          </div>
        </div>

        <!-- Recent Career Applications -->
        <div class="bg-white rounded-2xl border border-brand-sand shadow-sm overflow-hidden">
          <div class="px-6 py-4 border-b border-brand-sand flex items-center justify-between">
            <h2 class="font-bold text-brand-dark">Pelamar Kerja Terbaru</h2>
            <Link :href="route('admin.careers.index')" class="text-xs font-bold text-brand-primary inline-flex items-center gap-1">
              Kelola <ArrowRight class="w-3.5 h-3.5" />
            </Link>
          </div>
          <div class="divide-y divide-brand-sand">
            <div v-for="app in recentApplications" :key="app.id" class="p-4 flex items-center justify-between gap-4">
              <div>
                <p class="font-bold text-sm text-brand-dark">{{ app.applicant_name }}</p>
                <p class="text-xs text-brand-leaf mt-0.5">{{ app.career?.title }} &bull; {{ app.education }}</p>
              </div>
              <span :class="[statusColors[app.status] || 'bg-slate-100 text-slate-700', 'px-2.5 py-1 rounded-full text-[11px] font-bold uppercase']">
                {{ app.status }}
              </span>
            </div>
            <div v-if="!recentApplications.length" class="p-6 text-center text-sm text-brand-leaf">Belum ada pelamar kerja.</div>
          </div>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
