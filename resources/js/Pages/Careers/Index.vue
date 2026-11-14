<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { Briefcase, MapPin, Clock, Search, ArrowRight } from '@lucide/vue';

const props = defineProps({
  careers: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');
const categories = ['Medis', 'Keperawatan', 'Penunjang Medis', 'Non-Medis & IT'];

const applyFilters = () => {
  router.get('/karir', {
    search: search.value || undefined,
    category: selectedCategory.value || undefined,
  }, { preserveState: true, replace: true });
};

let timer = null;
watch(search, () => {
  clearTimeout(timer);
  timer = setTimeout(applyFilters, 300);
});

const selectCategory = (cat) => {
  selectedCategory.value = cat;
  applyFilters();
};
</script>

<template>
  <Head title="Portal Karir & Lowongan Kerja Rumah Sakit" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <section class="bg-brand-deep text-white py-12 sm:py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-semibold">
          <Briefcase class="w-3.5 h-3.5" />
          Bergabung Bersama Tim Kami
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold">Portal Karir & Rekrutmen</h1>
        <p class="text-white/80 text-sm sm:text-base max-w-2xl">
          Kesempatan berkarir bagi tenaga medis, keperawatan, penunjang medis, dan profesional non-medis untuk melayani masyarakat dengan sepenuh hati.
        </p>
      </div>
    </section>

    <main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <div class="bg-white p-5 rounded-2xl border border-brand-sand shadow-sm flex flex-col md:flex-row items-stretch md:items-center justify-between gap-4">
        <div class="flex flex-wrap items-center gap-2">
          <button
            @click="selectCategory('')"
            :class="[
              selectedCategory === '' ? 'bg-brand-primary text-white' : 'bg-brand-cream text-brand-dark hover:bg-brand-sand',
              'px-4 py-2 rounded-xl text-xs font-bold transition-colors'
            ]"
          >
            Semua Bidang
          </button>
          <button
            v-for="cat in categories"
            :key="cat"
            @click="selectCategory(cat)"
            :class="[
              selectedCategory === cat ? 'bg-brand-primary text-white' : 'bg-brand-cream text-brand-dark hover:bg-brand-sand',
              'px-4 py-2 rounded-xl text-xs font-bold transition-colors'
            ]"
          >
            {{ cat }}
          </button>
        </div>

        <div class="relative w-full md:w-72">
          <Search class="w-4 h-4 text-brand-leaf absolute left-3.5 top-1/2 -translate-y-1/2" />
          <input
            v-model="search"
            type="text"
            placeholder="Cari posisi lowongan..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-brand-sand bg-brand-cream/50 text-sm focus:border-brand-primary focus:ring-brand-primary"
          />
        </div>
      </div>

      <div v-if="careers.length" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div
          v-for="job in careers"
          :key="job.id"
          class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm hover:shadow-card-hover transition-all flex flex-col justify-between space-y-5"
        >
          <div class="space-y-3">
            <div class="flex items-center justify-between gap-2">
              <span class="px-3 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold">
                {{ job.category }}
              </span>
              <span class="text-xs font-semibold text-brand-leaf">{{ job.employment_type }}</span>
            </div>
            <h2 class="text-xl font-bold text-brand-dark">{{ job.title }}</h2>
            <p class="text-sm text-brand-leaf line-clamp-2">{{ job.description }}</p>
            <div class="flex flex-wrap items-center gap-4 text-xs text-brand-leaf pt-1">
              <span class="inline-flex items-center gap-1"><MapPin class="w-3.5 h-3.5 text-brand-primary" /> {{ job.location }}</span>
              <span v-if="job.deadline" class="inline-flex items-center gap-1"><Clock class="w-3.5 h-3.5 text-brand-primary" /> Batas: {{ job.deadline }}</span>
            </div>
          </div>

          <div class="pt-4 border-t border-brand-sand flex items-center justify-between">
            <span class="text-xs font-medium text-brand-leaf">{{ job.department_name }}</span>
            <Link
              :href="`/karir/${job.slug}`"
              class="inline-flex items-center gap-1.5 px-4 py-2 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-xs font-bold transition-colors"
            >
              <span>Lihat & Lamar</span>
              <ArrowRight class="w-3.5 h-3.5" />
            </Link>
          </div>
        </div>
      </div>

      <div v-else class="bg-white rounded-2xl border border-brand-sand p-12 text-center space-y-2">
        <Briefcase class="w-10 h-10 text-brand-leaf/50 mx-auto" />
        <p class="font-bold text-brand-dark">Belum ada lowongan tersedia untuk kategori ini.</p>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>

