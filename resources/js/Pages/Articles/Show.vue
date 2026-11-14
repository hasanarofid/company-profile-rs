<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { ChevronLeft, Calendar, Tag, CalendarCheck } from '@lucide/vue';

defineProps({
  article: { type: Object, required: true },
  relatedArticles: { type: Array, default: () => [] },
});
</script>

<template>
  <Head :title="article.title" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <main class="flex-1 max-w-4xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <Link href="/artikel" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-primary hover:text-brand-dark">
        <ChevronLeft class="w-4 h-4" /> Kembali ke Daftar Artikel
      </Link>

      <article class="bg-white rounded-3xl border border-brand-sand shadow-sm overflow-hidden">
        <img :src="article.image" :alt="article.title" class="w-full h-72 sm:h-96 object-cover" />
        <div class="p-6 sm:p-10 space-y-6">
          <div class="flex flex-wrap items-center gap-4 text-xs text-brand-leaf">
            <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-brand-sand text-brand-primary font-bold">
              <Tag class="w-3.5 h-3.5" /> {{ article.category }}
            </span>
            <span class="inline-flex items-center gap-1.5">
              <Calendar class="w-3.5 h-3.5" /> {{ article.published_at }}
            </span>
          </div>

          <h1 class="text-2xl sm:text-4xl font-extrabold text-brand-dark leading-tight">
            {{ article.title }}
          </h1>

          <div class="prose max-w-none text-brand-dark/90 leading-relaxed whitespace-pre-line text-base">
            {{ article.content }}
          </div>

          <div class="pt-6 border-t border-brand-sand flex flex-col sm:flex-row items-center justify-between gap-4 bg-brand-cream p-5 rounded-2xl">
            <div>
              <p class="font-bold text-brand-dark">Butuh Konsultasi Lebih Lanjut?</p>
              <p class="text-xs text-brand-leaf">Jadwalkan pemeriksaan bersama dokter spesialis kami.</p>
            </div>
            <Link
              href="/janji-temu"
              class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold shrink-0"
            >
              <CalendarCheck class="w-4 h-4" />
              Buat Janji Temu
            </Link>
          </div>
        </div>
      </article>

      <section v-if="relatedArticles.length" class="space-y-4">
        <h2 class="text-xl font-bold text-brand-dark">Artikel Terkait</h2>
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-5">
          <Link
            v-for="rel in relatedArticles"
            :key="rel.id"
            :href="`/artikel/${rel.slug}`"
            class="bg-white rounded-2xl overflow-hidden border border-brand-sand hover:shadow-md transition-all"
          >
            <img :src="rel.image" :alt="rel.title" class="w-full h-36 object-cover" />
            <div class="p-4">
              <span class="text-[11px] font-bold text-brand-primary">{{ rel.category }}</span>
              <h3 class="font-bold text-sm text-brand-dark mt-1 line-clamp-2">{{ rel.title }}</h3>
            </div>
          </Link>
        </div>
      </section>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
