<script setup>
import { ref, watch } from 'vue';
import { Head, Link, router } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { Search, Newspaper, ArrowRight } from '@lucide/vue';

const props = defineProps({
  articles: { type: Array, default: () => [] },
  categories: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const selectedCategory = ref(props.filters.category || '');

const applyFilters = () => {
  router.get('/artikel', {
    search: search.value || undefined,
    category: selectedCategory.value || undefined,
  }, { preserveState: true, replace: true });
};

let timer = null;
watch(search, () => {
  clearTimeout(timer);
  timer = setTimeout(applyFilters, 300);
});

const selectCategory = (slug) => {
  selectedCategory.value = slug;
  applyFilters();
};
</script>

<template>
  <Head title="Artikel Kesehatan & Berita Rumah Sakit" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <section class="bg-brand-deep text-white py-12 sm:py-16">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-3">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-semibold">
          <Newspaper class="w-3.5 h-3.5" />
          Edukasi & Informasi Terkini
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold">Artikel Kesehatan & Berita RS</h1>
        <p class="text-white/80 text-sm sm:text-base max-w-2xl">
          Informasi medis terpercaya, tips hidup sehat dari dokter spesialis, serta pengumuman layanan terbaru rumah sakit.
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
            Semua
          </button>
          <button
            v-for="cat in categories"
            :key="cat.id"
            @click="selectCategory(cat.slug)"
            :class="[
              selectedCategory === cat.slug ? 'bg-brand-primary text-white' : 'bg-brand-cream text-brand-dark hover:bg-brand-sand',
              'px-4 py-2 rounded-xl text-xs font-bold transition-colors'
            ]"
          >
            {{ cat.name }}
          </button>
        </div>

        <div class="relative w-full md:w-72">
          <Search class="w-4 h-4 text-brand-leaf absolute left-3.5 top-1/2 -translate-y-1/2" />
          <input
            v-model="search"
            type="text"
            placeholder="Cari artikel..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-brand-sand bg-brand-cream/50 text-sm focus:border-brand-primary focus:ring-brand-primary"
          />
        </div>
      </div>

      <div v-if="articles.length" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <Link
          v-for="art in articles"
          :key="art.id"
          :href="`/artikel/${art.slug}`"
          class="group bg-white rounded-2xl overflow-hidden border border-brand-sand hover:shadow-card-hover transition-all flex flex-col"
        >
          <div class="h-52 overflow-hidden">
            <img
              :src="art.image"
              :alt="art.title"
              class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
            />
          </div>
          <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
            <div>
              <div class="flex items-center justify-between text-xs text-brand-leaf mb-2">
                <span class="font-bold text-brand-primary">{{ art.category?.name }}</span>
                <span>{{ art.published_at }}</span>
              </div>
              <h2 class="font-bold text-lg text-brand-dark group-hover:text-brand-primary transition-colors line-clamp-2">
                {{ art.title }}
              </h2>
              <p class="text-sm text-brand-leaf mt-2 line-clamp-3">{{ art.excerpt }}</p>
            </div>
            <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary pt-2">
              Baca Artikel <ArrowRight class="w-3.5 h-3.5" />
            </span>
          </div>
        </Link>
      </div>

      <div v-else class="bg-white rounded-2xl border border-brand-sand p-12 text-center space-y-2">
        <Newspaper class="w-10 h-10 text-brand-leaf/50 mx-auto" />
        <p class="font-bold text-brand-dark">Belum ada artikel yang cocok.</p>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
