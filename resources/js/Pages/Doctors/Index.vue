<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { Search, CalendarCheck, Stethoscope, Clock, MapPin, Filter } from '@lucide/vue';

const props = defineProps({
  doctors: { type: Array, default: () => [] },
  departments: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const selectedDepartment = ref(props.filters.department || '');
const selectedDay = ref(props.filters.day || '');

const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

const applyFilters = () => {
  router.get('/dokter', {
    search: search.value || undefined,
    department: selectedDepartment.value || undefined,
    day: selectedDay.value || undefined,
  }, { preserveState: true, replace: true });
};

let searchTimer = null;
watch(search, () => {
  clearTimeout(searchTimer);
  searchTimer = setTimeout(applyFilters, 300);
});

const selectDept = (slug) => {
  selectedDepartment.value = slug;
  applyFilters();
};

const selectDay = (day) => {
  selectedDay.value = selectedDay.value === day ? '' : day;
  applyFilters();
};
</script>

<template>
  <Head title="Direktori & Jadwal Dokter" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <!-- Header Banner -->
    <section class="bg-brand-deep text-white py-12 sm:py-16 border-b border-white/10">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="max-w-2xl space-y-3">
          <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-semibold">
            <Stethoscope class="w-3.5 h-3.5" />
            Tenaga Medis & Poliklinik
          </span>
          <h1 class="text-3xl sm:text-4xl font-extrabold">Direktori & Jadwal Praktik Dokter</h1>
          <p class="text-white/80 text-sm sm:text-base">
            Temukan dokter spesialis sesuai kebutuhan Anda, periksa jadwal praktik per hari, dan buat janji temu secara online.
          </p>
        </div>
      </div>
    </section>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <!-- Search & Filters -->
      <div class="bg-white p-5 sm:p-6 rounded-2xl border border-brand-sand shadow-sm space-y-5">
        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
          <div class="md:col-span-6 relative">
            <Search class="w-4 h-4 text-brand-leaf absolute left-4 top-1/2 -translate-y-1/2" />
            <input
              v-model="search"
              type="text"
              placeholder="Cari nama dokter atau spesialisasi..."
              class="w-full pl-11 pr-4 py-3 rounded-xl border-brand-sand bg-brand-cream/50 text-sm focus:border-brand-primary focus:ring-brand-primary"
            />
          </div>
          <div class="md:col-span-4">
            <select
              v-model="selectedDepartment"
              @change="applyFilters"
              class="w-full py-3 px-4 rounded-xl border-brand-sand bg-brand-cream/50 text-sm focus:border-brand-primary focus:ring-brand-primary"
            >
              <option value="">Semua Unit / Poliklinik</option>
              <option v-for="dept in departments" :key="dept.id" :value="dept.slug">
                {{ dept.name }}
              </option>
            </select>
          </div>
          <div class="md:col-span-2">
            <button
              @click="search = ''; selectedDepartment = ''; selectedDay = ''; applyFilters()"
              class="w-full py-3 px-4 rounded-xl border border-brand-sand hover:bg-brand-sand/50 text-sm font-semibold text-brand-dark transition-colors"
            >
              Reset Filter
            </button>
          </div>
        </div>

        <!-- Day Pills -->
        <div class="flex flex-wrap items-center gap-2">
          <span class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-leaf mr-2">
            <Filter class="w-3.5 h-3.5" /> Filter Hari:
          </span>
          <button
            v-for="day in days"
            :key="day"
            @click="selectDay(day)"
            :class="[
              selectedDay === day
                ? 'bg-brand-primary text-white border-brand-primary'
                : 'bg-brand-cream text-brand-dark border-brand-sand hover:bg-brand-sand',
              'px-3.5 py-1.5 rounded-lg border text-xs font-semibold transition-colors'
            ]"
          >
            {{ day }}
          </button>
        </div>
      </div>

      <!-- Doctors Grid -->
      <div v-if="doctors.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div
          v-for="doc in doctors"
          :key="doc.id"
          class="bg-white rounded-2xl overflow-hidden border border-brand-sand shadow-sm hover:shadow-card-hover transition-all flex flex-col"
        >
          <div class="flex gap-4 p-5 border-b border-brand-sand/60">
            <img
              :src="doc.photo || '/images/hospital/doctors/doctor-1.jpg'"
              :alt="doc.name"
              class="w-24 h-24 rounded-2xl object-cover object-top shrink-0 border border-brand-sand"
            />
            <div class="space-y-1">
              <span class="inline-block px-2.5 py-0.5 rounded-md bg-brand-sand text-brand-primary text-[11px] font-bold">
                {{ doc.department?.name }}
              </span>
              <h2 class="font-bold text-base text-brand-dark leading-snug">
                <Link :href="`/dokter/${doc.slug}`" class="hover:text-brand-primary transition-colors">
                  {{ doc.name }}
                </Link>
              </h2>
              <p class="text-xs text-brand-leaf font-medium">{{ doc.specialization }}</p>
              <p v-if="doc.department?.location" class="inline-flex items-center gap-1 text-[11px] text-brand-leaf/80 pt-1">
                <MapPin class="w-3 h-3 text-brand-primary" />
                {{ doc.department.location }}
              </p>
            </div>
          </div>

          <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
            <div class="space-y-2">
              <p class="text-xs font-bold uppercase tracking-wider text-brand-leaf flex items-center gap-1.5">
                <Clock class="w-3.5 h-3.5 text-brand-primary" /> Jadwal Praktik
              </p>
              <div v-if="doc.schedules?.length" class="space-y-1.5">
                <div
                  v-for="sch in doc.schedules"
                  :key="sch.id"
                  class="flex items-center justify-between text-xs bg-brand-cream px-3 py-1.5 rounded-lg"
                >
                  <span class="font-semibold text-brand-dark">{{ sch.day_of_week }}</span>
                  <span class="text-brand-primary font-medium">{{ sch.start_time }} - {{ sch.end_time }}</span>
                </div>
              </div>
              <p v-else class="text-xs text-brand-leaf italic">Jadwal sesuai perjanjian.</p>
            </div>

            <div class="flex items-center gap-2 pt-2">
              <Link
                :href="`/janji-temu?doctor_id=${doc.id}`"
                class="flex-1 inline-flex items-center justify-center gap-1.5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-xs font-bold transition-colors"
              >
                <CalendarCheck class="w-4 h-4" />
                <span>Buat Janji Temu</span>
              </Link>
              <Link
                :href="`/dokter/${doc.slug}`"
                class="px-4 py-2.5 rounded-xl border border-brand-sand hover:bg-brand-sand/50 text-brand-dark text-xs font-semibold transition-colors"
              >
                Detail
              </Link>
            </div>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-2xl border border-brand-sand p-12 text-center space-y-3">
        <Stethoscope class="w-10 h-10 text-brand-leaf/50 mx-auto" />
        <h3 class="font-bold text-lg text-brand-dark">Dokter tidak ditemukan</h3>
        <p class="text-sm text-brand-leaf">Coba ubah kata kunci pencarian atau pilih poliklinik lain.</p>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>

