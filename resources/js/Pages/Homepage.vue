<script setup>
import { ref, computed, onMounted, onUnmounted } from 'vue';
import { Head, Link, usePage } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import {
  ChevronLeft,
  ChevronRight,
  CalendarCheck,
  Stethoscope,
  Ambulance,
  HeartPulse,
  Activity,
  Microscope,
  ShieldCheck,
  Pill,
  Baby,
  Smile,
  ArrowRight,
  Quote,
  MapPin,
  Clock,
  PhoneCall,
  Award,
  Newspaper
} from '@lucide/vue';

const props = defineProps({
  pageMeta: { type: Object, default: () => ({}) },
  sections: { type: Array, default: () => [] },
  departments: { type: Array, default: () => [] },
  featuredDoctors: { type: Array, default: () => [] },
  latestArticles: { type: Array, default: () => [] },
});

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});

// Icon mapping for dynamic sections & departments
const iconMap = {
  Ambulance,
  HeartPulse,
  Activity,
  Microscope,
  ShieldCheck,
  Pill,
  Stethoscope,
  Baby,
  Smile,
};

const getIcon = (name) => iconMap[name] || Stethoscope;

// Hero slider state
const currentSlide = ref(0);
let slideTimer = null;

const heroSection = computed(() => props.sections.find((s) => s.key === 'hero_slider'));
const slides = computed(() => heroSection.value?.content?.slides || []);

const nextSlide = () => {
  if (slides.value.length > 0) {
    currentSlide.value = (currentSlide.value + 1) % slides.value.length;
  }
};

const prevSlide = () => {
  if (slides.value.length > 0) {
    currentSlide.value = (currentSlide.value - 1 + slides.value.length) % slides.value.length;
  }
};

onMounted(() => {
  if (slides.value.length > 1) {
    slideTimer = setInterval(nextSlide, 6000);
  }
});

onUnmounted(() => {
  if (slideTimer) clearInterval(slideTimer);
});

const waUrl = computed(() => {
  const num = (settings.value.whatsapp_number || '6281234567890').replace(/[^0-9]/g, '');
  return `https://wa.me/${num}?text=${encodeURIComponent('Halo, saya ingin konsultasi jadwal dokter / layanan rumah sakit.')}`;
});
</script>

<template>
  <Head>
    <title>{{ pageMeta.title || settings.site_name || 'RSU Medika Nusantara' }}</title>
    <meta name="description" :content="pageMeta.description || settings.site_description" />
  </Head>

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans antialiased flex flex-col">
    <HeaderNavbar />

    <main class="flex-1">
      <!-- Render Dynamic Sections in Admin-Configured Order -->
      <template v-for="section in sections" :key="section.id">
        <!-- 1. HERO SLIDER -->
        <section
          v-if="section.key === 'hero_slider' && slides.length"
          class="relative w-full h-[540px] sm:h-[600px] lg:h-[640px] overflow-hidden bg-brand-deep"
        >
          <div
            v-for="(slide, idx) in slides"
            :key="idx"
            :class="[
              idx === currentSlide ? 'opacity-100 z-10' : 'opacity-0 z-0 pointer-events-none',
              'absolute inset-0 transition-opacity duration-700 ease-in-out'
            ]"
          >
            <img
              :src="slide.image"
              :alt="slide.headline"
              class="w-full h-full object-cover object-center"
            />
            <div class="absolute inset-0 bg-gradient-to-r from-brand-deep/95 via-brand-deep/75 to-brand-deep/25"></div>

            <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-full flex items-center">
              <div class="max-w-2xl text-white space-y-5">
                <span
                  v-if="slide.badge"
                  class="inline-flex items-center gap-2 px-3.5 py-1.5 rounded-full bg-white/15 backdrop-blur-sm border border-white/20 text-xs font-semibold tracking-wide text-amber-300"
                >
                  <Award class="w-3.5 h-3.5" />
                  {{ slide.badge }}
                </span>

                <h1 class="text-3xl sm:text-5xl font-extrabold tracking-tight leading-tight">
                  {{ slide.headline }}
                </h1>

                <p class="text-base sm:text-lg text-white/85 leading-relaxed">
                  {{ slide.subheadline }}
                </p>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                  <Link
                    :href="slide.cta_url || '/janji-temu'"
                    class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-brand-primary hover:bg-brand-light text-white font-semibold text-sm shadow-lg transition-all"
                  >
                    <CalendarCheck class="w-4 h-4" />
                    <span>{{ slide.cta_text || 'Buat Janji Temu' }}</span>
                  </Link>
                  <Link
                    v-if="slide.secondary_text"
                    :href="slide.secondary_url || '/dokter'"
                    class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white/15 hover:bg-white/25 backdrop-blur-sm border border-white/25 text-white font-semibold text-sm transition-all"
                  >
                    <Stethoscope class="w-4 h-4" />
                    <span>{{ slide.secondary_text }}</span>
                  </Link>
                </div>
              </div>
            </div>
          </div>

          <!-- Slider Controls -->
          <div v-if="slides.length > 1" class="absolute bottom-6 left-0 right-0 z-20 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex items-center justify-between">
            <div class="flex items-center gap-2">
              <button
                v-for="(_, idx) in slides"
                :key="idx"
                @click="currentSlide = idx"
                :class="[
                  idx === currentSlide ? 'w-8 bg-white' : 'w-2.5 bg-white/40 hover:bg-white/70',
                  'h-2.5 rounded-full transition-all duration-300'
                ]"
                :aria-label="`Slide ${idx + 1}`"
              ></button>
            </div>
            <div class="flex items-center gap-2">
              <button
                @click="prevSlide"
                class="p-2.5 rounded-full bg-white/15 hover:bg-white/30 text-white backdrop-blur-sm transition-colors"
                aria-label="Previous slide"
              >
                <ChevronLeft class="w-5 h-5" />
              </button>
              <button
                @click="nextSlide"
                class="p-2.5 rounded-full bg-white/15 hover:bg-white/30 text-white backdrop-blur-sm transition-colors"
                aria-label="Next slide"
              >
                <ChevronRight class="w-5 h-5" />
              </button>
            </div>
          </div>
        </section>

        <!-- 2. MANAGEMENT WELCOME -->
        <section
          v-else-if="section.key === 'management_welcome'"
          class="py-16 lg:py-24 bg-white border-b border-brand-sand"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
              <div class="lg:col-span-5 relative">
                <div class="aspect-[4/3] rounded-3xl overflow-hidden shadow-fashion border border-brand-sand">
                  <img
                    :src="section.content.image || '/images/hospital/director.jpg'"
                    :alt="section.content.director_name"
                    class="w-full h-full object-cover"
                  />
                </div>
                <div class="mt-4 lg:mt-0 lg:absolute lg:-bottom-6 lg:left-6 lg:right-6 bg-brand-deep text-white p-5 rounded-2xl shadow-xl">
                  <p class="font-bold text-base">{{ section.content.director_name }}</p>
                  <p class="text-xs text-white/75 mt-0.5">{{ section.content.director_role }}</p>
                </div>
              </div>

              <div class="lg:col-span-7 space-y-6">
                <span class="inline-block px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                  {{ section.content.badge || 'Sambutan Manajemen' }}
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-brand-dark leading-tight">
                  {{ section.content.title }}
                </h2>
                <blockquote v-if="section.content.quote" class="pl-4 border-l-4 border-brand-primary italic text-brand-dark/90 font-medium text-base sm:text-lg">
                  "{{ section.content.quote }}"
                </blockquote>
                <p class="text-brand-leaf leading-relaxed">
                  {{ section.content.description }}
                </p>

                <div v-if="section.content.stats?.length" class="grid grid-cols-2 sm:grid-cols-4 gap-4 pt-4">
                  <div
                    v-for="(st, i) in section.content.stats"
                    :key="i"
                    class="p-4 rounded-2xl bg-brand-cream border border-brand-sand text-center"
                  >
                    <p class="text-2xl font-extrabold text-brand-primary">{{ st.value }}</p>
                    <p class="text-xs font-medium text-brand-leaf mt-1">{{ st.label }}</p>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- 3. FEATURED SERVICES -->
        <section
          v-else-if="section.key === 'featured_services'"
          class="py-16 lg:py-20 bg-brand-cream"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
              <span class="inline-block px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                {{ section.content.badge || 'Layanan Unggulan' }}
              </span>
              <h2 class="text-2xl sm:text-4xl font-extrabold text-brand-dark">
                {{ section.content.title }}
              </h2>
              <p class="text-brand-leaf text-sm sm:text-base">
                {{ section.content.subtitle }}
              </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="(item, idx) in (section.content.items || [])"
                :key="idx"
                class="bg-white p-7 rounded-2xl border border-brand-sand hover:border-brand-primary/40 shadow-sm hover:shadow-card-hover transition-all duration-300 group"
              >
                <div class="w-12 h-12 rounded-xl bg-brand-sand text-brand-primary flex items-center justify-center mb-5 group-hover:bg-brand-primary group-hover:text-white transition-colors">
                  <component :is="getIcon(item.icon)" class="w-6 h-6" />
                </div>
                <h3 class="text-lg font-bold text-brand-dark mb-2">{{ item.title }}</h3>
                <p class="text-sm text-brand-leaf leading-relaxed">{{ item.description }}</p>
              </div>
            </div>
          </div>
        </section>

        <!-- 4. DEPARTMENTS / UNIT POLI -->
        <section
          v-else-if="section.key === 'departments_preview'"
          class="py-16 lg:py-20 bg-white border-y border-brand-sand"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
              <div class="space-y-2">
                <span class="inline-block px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                  {{ section.content.badge || 'Poliklinik & Unit' }}
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-brand-dark">
                  {{ section.content.title }}
                </h2>
                <p class="text-brand-leaf text-sm sm:text-base max-w-xl">
                  {{ section.content.subtitle }}
                </p>
              </div>
              <Link
                href="/dokter"
                class="inline-flex items-center gap-2 text-sm font-bold text-brand-primary hover:text-brand-dark transition-colors shrink-0"
              >
                <span>Lihat Semua Poli & Dokter</span>
                <ArrowRight class="w-4 h-4" />
              </Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
              <div
                v-for="dept in departments"
                :key="dept.id"
                class="group rounded-2xl overflow-hidden bg-brand-cream border border-brand-sand hover:shadow-card-hover transition-all duration-300 flex flex-col"
              >
                <div class="relative h-48 overflow-hidden">
                  <img
                    :src="dept.image || '/images/hospital/departments/cardiology.jpg'"
                    :alt="dept.name"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                  />
                  <span class="absolute top-3 left-3 px-2.5 py-1 rounded-lg bg-white/95 text-brand-dark text-xs font-bold shadow-sm">
                    {{ dept.doctors_count || 0 }} Dokter
                  </span>
                </div>
                <div class="p-6 flex-1 flex flex-col justify-between space-y-4">
                  <div>
                    <h3 class="text-lg font-bold text-brand-dark">{{ dept.name }}</h3>
                    <p class="text-sm text-brand-leaf mt-1.5 line-clamp-2">{{ dept.short_description }}</p>
                    <p v-if="dept.location" class="inline-flex items-center gap-1.5 text-xs text-brand-primary font-medium mt-3">
                      <MapPin class="w-3.5 h-3.5" />
                      {{ dept.location }}
                    </p>
                  </div>
                  <div class="pt-3 border-t border-brand-sand flex items-center justify-between">
                    <Link
                      :href="`/dokter?department=${dept.slug}`"
                      class="text-xs font-bold text-brand-primary hover:underline"
                    >
                      Lihat Jadwal Dokter
                    </Link>
                    <Link
                      :href="`/janji-temu?department_id=${dept.id}`"
                      class="px-3.5 py-1.5 rounded-lg bg-brand-primary hover:bg-brand-dark text-white text-xs font-semibold transition-colors"
                    >
                      Daftar Poli
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- 5. FEATURED DOCTORS -->
        <section
          v-else-if="section.key === 'doctors_preview'"
          class="py-16 lg:py-20 bg-brand-cream"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
              <div class="space-y-2">
                <span class="inline-block px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                  {{ section.content.badge || 'Tim Dokter' }}
                </span>
                <h2 class="text-2xl sm:text-4xl font-extrabold text-brand-dark">
                  {{ section.content.title }}
                </h2>
                <p class="text-brand-leaf text-sm sm:text-base max-w-xl">
                  {{ section.content.subtitle }}
                </p>
              </div>
              <Link
                href="/dokter"
                class="inline-flex items-center gap-2 text-sm font-bold text-brand-primary hover:text-brand-dark transition-colors shrink-0"
              >
                <span>Cari Semua Dokter</span>
                <ArrowRight class="w-4 h-4" />
              </Link>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
              <div
                v-for="doc in featuredDoctors"
                :key="doc.id"
                class="bg-white rounded-2xl overflow-hidden border border-brand-sand shadow-sm hover:shadow-card-hover transition-all duration-300 flex flex-col"
              >
                <div class="aspect-[4/4] overflow-hidden bg-brand-sand/40">
                  <img
                    :src="doc.photo || '/images/hospital/doctors/doctor-1.jpg'"
                    :alt="doc.name"
                    class="w-full h-full object-cover object-top"
                  />
                </div>
                <div class="p-5 flex-1 flex flex-col justify-between space-y-4">
                  <div>
                    <span class="inline-block px-2.5 py-0.5 rounded-md bg-brand-sand text-brand-primary text-[11px] font-bold">
                      {{ doc.department?.name }}
                    </span>
                    <h3 class="font-bold text-base text-brand-dark mt-2 leading-snug">
                      <Link :href="`/dokter/${doc.slug}`" class="hover:text-brand-primary transition-colors">
                        {{ doc.name }}
                      </Link>
                    </h3>
                    <p class="text-xs text-brand-leaf mt-1">{{ doc.specialization }}</p>

                    <div v-if="doc.schedules?.length" class="mt-3 space-y-1">
                      <div
                        v-for="sch in doc.schedules.slice(0, 2)"
                        :key="sch.id"
                        class="flex items-center justify-between text-[11px] text-brand-dark/80 bg-brand-cream px-2.5 py-1 rounded-md"
                      >
                        <span class="font-semibold">{{ sch.day_of_week }}</span>
                        <span>{{ sch.start_time }} - {{ sch.end_time }}</span>
                      </div>
                    </div>
                  </div>

                  <div class="flex items-center gap-2 pt-2">
                    <Link
                      :href="`/janji-temu?doctor_id=${doc.id}`"
                      class="flex-1 text-center py-2 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-xs font-semibold transition-colors"
                    >
                      Buat Janji
                    </Link>
                    <Link
                      :href="`/dokter/${doc.slug}`"
                      class="px-3 py-2 rounded-xl border border-brand-sand hover:bg-brand-sand/50 text-brand-dark text-xs font-semibold transition-colors"
                    >
                      Profil
                    </Link>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- 6. TESTIMONIALS -->
        <section
          v-else-if="section.key === 'testimonials'"
          class="py-16 lg:py-20 bg-white border-t border-brand-sand"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-12 space-y-3">
              <span class="inline-block px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                {{ section.content.badge || 'Testimoni Pasien' }}
              </span>
              <h2 class="text-2xl sm:text-4xl font-extrabold text-brand-dark">
                {{ section.content.title }}
              </h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
              <div
                v-for="(item, idx) in (section.content.items || [])"
                :key="idx"
                class="p-7 rounded-2xl bg-brand-cream border border-brand-sand flex flex-col justify-between space-y-5"
              >
                <div class="space-y-3">
                  <Quote class="w-8 h-8 text-brand-primary/30" />
                  <p class="text-sm text-brand-dark/90 leading-relaxed">
                    "{{ item.comment }}"
                  </p>
                </div>
                <div class="pt-4 border-t border-brand-sand">
                  <p class="font-bold text-sm text-brand-dark">{{ item.name }}</p>
                  <p class="text-xs text-brand-leaf">{{ item.role }}</p>
                </div>
              </div>
            </div>
          </div>
        </section>

        <!-- 7. CTA BANNER -->
        <section
          v-else-if="section.key === 'cta_banner'"
          id="igd-darurat"
          class="py-16 bg-brand-primary text-white"
        >
          <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="rounded-3xl bg-brand-deep/60 border border-white/15 p-8 sm:p-12 flex flex-col lg:flex-row items-center justify-between gap-8">
              <div class="space-y-3 max-w-2xl text-center lg:text-left">
                <h2 class="text-2xl sm:text-3xl font-extrabold">{{ section.content.title }}</h2>
                <p class="text-white/80 text-sm sm:text-base">{{ section.content.subtitle }}</p>
              </div>
              <div class="flex flex-wrap items-center justify-center gap-3 shrink-0">
                <Link
                  :href="section.content.primary_url || '/janji-temu'"
                  class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-white text-brand-dark hover:bg-brand-sand font-bold text-sm shadow-lg transition-colors"
                >
                  <CalendarCheck class="w-4 h-4 text-brand-primary" />
                  <span>{{ section.content.primary_text || 'Buat Janji Temu Online' }}</span>
                </Link>
                <a
                  :href="waUrl"
                  target="_blank"
                  class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-500 text-white font-bold text-sm shadow-lg transition-colors"
                >
                  <PhoneCall class="w-4 h-4" />
                  <span>{{ section.content.secondary_text || 'Hubungi WhatsApp RS' }}</span>
                </a>
              </div>
            </div>
          </div>
        </section>
      </template>

      <!-- LATEST ARTICLES & HEALTH TIPS -->
      <section v-if="latestArticles.length" class="py-16 lg:py-20 bg-brand-cream border-t border-brand-sand">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
          <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
            <div class="space-y-2">
              <span class="inline-flex items-center gap-1.5 px-3.5 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold uppercase tracking-wider">
                <Newspaper class="w-3.5 h-3.5" />
                Edukasi & Berita RS
              </span>
              <h2 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">Artikel & Tips Kesehatan Terbaru</h2>
            </div>
            <Link href="/artikel" class="inline-flex items-center gap-2 text-sm font-bold text-brand-primary hover:text-brand-dark">
              <span>Semua Artikel</span>
              <ArrowRight class="w-4 h-4" />
            </Link>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <Link
              v-for="art in latestArticles"
              :key="art.id"
              :href="`/artikel/${art.slug}`"
              class="group bg-white rounded-2xl overflow-hidden border border-brand-sand hover:shadow-card-hover transition-all duration-300 flex flex-col"
            >
              <div class="h-48 overflow-hidden">
                <img
                  :src="art.image"
                  :alt="art.title"
                  class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                />
              </div>
              <div class="p-6 flex-1 flex flex-col justify-between space-y-3">
                <div>
                  <div class="flex items-center justify-between text-xs text-brand-leaf mb-2">
                    <span class="font-bold text-brand-primary">{{ art.category }}</span>
                    <span>{{ art.published_at }}</span>
                  </div>
                  <h3 class="font-bold text-base text-brand-dark group-hover:text-brand-primary transition-colors line-clamp-2">
                    {{ art.title }}
                  </h3>
                  <p class="text-sm text-brand-leaf mt-2 line-clamp-2">{{ art.excerpt }}</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary pt-2">
                  Baca Selengkapnya <ArrowRight class="w-3.5 h-3.5" />
                </span>
              </div>
            </Link>
          </div>
        </div>
      </section>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
