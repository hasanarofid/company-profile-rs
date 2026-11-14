<script setup>
import { ref } from 'vue';
import { Head, useForm, Link, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Save, ChevronLeft, Layout, Plus, Trash2, ArrowUp, ArrowDown, Eye, EyeOff } from '@lucide/vue';

const props = defineProps({
  page: { type: Object, required: true },
});

const sectionsList = ref(JSON.parse(JSON.stringify(props.page.sections || [])));
const activeSectionId = ref(sectionsList.value[0]?.id || null);

const sectionForm = useForm({
  title: sectionsList.value[0]?.title || '',
  content: JSON.parse(JSON.stringify(sectionsList.value[0]?.content || {})),
  is_active: sectionsList.value[0]?.is_active ?? true,
});

const selectSection = (sec) => {
  activeSectionId.value = sec.id;
  sectionForm.title = sec.title || '';
  sectionForm.is_active = !!sec.is_active;
  sectionForm.content = JSON.parse(JSON.stringify(sec.content || {}));
};

const activeKey = () => sectionsList.value.find((s) => s.id === activeSectionId.value)?.key || '';

const updateSection = () => {
  if (!activeSectionId.value) return;
  sectionForm.put(route('admin.pages.sections.update', [props.page.id, activeSectionId.value]), {
    preserveScroll: true,
    onSuccess: () => {
      const target = sectionsList.value.find((s) => s.id === activeSectionId.value);
      if (target) {
        target.title = sectionForm.title;
        target.is_active = sectionForm.is_active;
        target.content = JSON.parse(JSON.stringify(sectionForm.content));
      }
    },
  });
};

const moveSection = (index, direction) => {
  const newIndex = index + direction;
  if (newIndex < 0 || newIndex >= sectionsList.value.length) return;
  const item = sectionsList.value.splice(index, 1)[0];
  sectionsList.value.splice(newIndex, 0, item);

  const orders = sectionsList.value.map((s, idx) => ({ id: s.id, order: idx + 1 }));
  router.post(route('admin.pages.sections.reorder', props.page.id), { orders }, { preserveScroll: true });
};

const addSlide = () => {
  if (!sectionForm.content.slides) sectionForm.content.slides = [];
  sectionForm.content.slides.push({
    badge: 'Layanan Terpadu',
    headline: 'Headline Baru',
    subheadline: 'Deskripsi singkat slide...',
    image: '/images/hospital/hero/hospital-exterior.jpg',
    cta_text: 'Buat Janji Temu',
    cta_url: '/janji-temu',
  });
};

const addServiceItem = () => {
  if (!sectionForm.content.items) sectionForm.content.items = [];
  sectionForm.content.items.push({ icon: 'Stethoscope', title: 'Layanan Baru', description: 'Deskripsi layanan...' });
};

const addTestimonialItem = () => {
  if (!sectionForm.content.items) sectionForm.content.items = [];
  sectionForm.content.items.push({ name: 'Nama Pasien', role: 'Pasien Poliklinik', comment: 'Testimoni pelayanan...' });
};
</script>

<template>
  <Head :title="`Layout Builder: ${page.title}`" />

  <AdminLayout>
    <div class="space-y-6">
      <div class="flex items-center gap-4">
        <Link :href="route('admin.pages.index')" class="p-2.5 bg-white border border-brand-sand rounded-xl hover:bg-brand-sand/40">
          <ChevronLeft class="w-5 h-5" />
        </Link>
        <div>
          <h1 class="text-2xl font-extrabold text-brand-dark">Layout & Content Builder: {{ page.title }}</h1>
          <p class="text-sm text-brand-leaf">Atur urutan komponen, aktif/nonaktifkan section, serta edit teks & gambar secara visual.</p>
        </div>
      </div>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        <!-- Left: Section List & Reorder -->
        <div class="lg:col-span-4 space-y-3">
          <div class="bg-white rounded-2xl border border-brand-sand p-4 space-y-2 shadow-sm">
            <p class="text-xs font-bold uppercase tracking-wider text-brand-leaf px-2 pb-1">Urutan Komponen Halaman</p>
            <div
              v-for="(sec, idx) in sectionsList"
              :key="sec.id"
              @click="selectSection(sec)"
              :class="[
                activeSectionId === sec.id ? 'bg-brand-sand border-brand-primary' : 'bg-brand-cream/40 border-brand-sand hover:bg-brand-sand/40',
                'p-3 rounded-xl border cursor-pointer flex items-center justify-between gap-2 transition-colors'
              ]"
            >
              <div class="flex items-center gap-2.5 min-w-0">
                <component :is="sec.is_active ? Eye : EyeOff" :class="[sec.is_active ? 'text-emerald-600' : 'text-slate-400', 'w-4 h-4 shrink-0']" />
                <div class="truncate">
                  <p class="text-sm font-bold text-brand-dark truncate">{{ sec.title }}</p>
                  <p class="text-[11px] text-brand-leaf font-mono">{{ sec.key }}</p>
                </div>
              </div>
              <div class="flex items-center gap-1 shrink-0" @click.stop>
                <button @click="moveSection(idx, -1)" :disabled="idx === 0" class="p-1 rounded hover:bg-white disabled:opacity-30" title="Naikkan">
                  <ArrowUp class="w-3.5 h-3.5" />
                </button>
                <button @click="moveSection(idx, 1)" :disabled="idx === sectionsList.length - 1" class="p-1 rounded hover:bg-white disabled:opacity-30" title="Turunkan">
                  <ArrowDown class="w-3.5 h-3.5" />
                </button>
              </div>
            </div>
          </div>
        </div>

        <!-- Right: Visual Editor -->
        <div class="lg:col-span-8">
          <form v-if="activeSectionId" @submit.prevent="updateSection" class="bg-white rounded-2xl border border-brand-sand p-6 space-y-5 shadow-sm">
            <div class="flex flex-wrap items-center justify-between gap-4 border-b border-brand-sand pb-4">
              <div class="flex items-center gap-2">
                <Layout class="w-5 h-5 text-brand-primary" />
                <h2 class="text-lg font-bold text-brand-dark">Edit Komponen: {{ sectionForm.title }}</h2>
              </div>
              <label class="inline-flex items-center gap-2 text-sm font-semibold">
                <input type="checkbox" v-model="sectionForm.is_active" class="rounded text-brand-primary" />
                <span>Tampilkan di Website</span>
              </label>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Label Komponen (Admin)</label>
              <input v-model="sectionForm.title" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
            </div>

            <!-- Hero Slider Editor -->
            <div v-if="activeKey() === 'hero_slider'" class="space-y-4">
              <div class="flex items-center justify-between">
                <span class="text-xs font-bold uppercase text-brand-dark">Daftar Slide Banner</span>
                <button type="button" @click="addSlide" class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary">
                  <Plus class="w-3.5 h-3.5" /> Tambah Slide
                </button>
              </div>
              <div v-for="(slide, idx) in (sectionForm.content.slides || [])" :key="idx" class="p-4 rounded-xl bg-brand-cream/50 border border-brand-sand space-y-3">
                <div class="flex justify-between items-center">
                  <span class="text-xs font-bold text-brand-primary">Slide #{{ idx + 1 }}</span>
                  <button type="button" @click="sectionForm.content.slides.splice(idx, 1)" class="text-rose-600"><Trash2 class="w-4 h-4" /></button>
                </div>
                <input v-model="slide.badge" placeholder="Badge" class="w-full rounded-lg border-brand-sand text-xs" />
                <input v-model="slide.headline" placeholder="Headline Utama" class="w-full rounded-lg border-brand-sand text-sm font-bold" />
                <textarea v-model="slide.subheadline" rows="2" placeholder="Subheadline" class="w-full rounded-lg border-brand-sand text-xs"></textarea>
                <div class="grid grid-cols-2 gap-2">
                  <input v-model="slide.cta_text" placeholder="Teks Tombol" class="rounded-lg border-brand-sand text-xs" />
                  <input v-model="slide.cta_url" placeholder="URL Tombol" class="rounded-lg border-brand-sand text-xs" />
                </div>
                <input v-model="slide.image" placeholder="Path Gambar (/images/hospital/...)" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>

            <!-- Management Welcome Editor -->
            <div v-else-if="activeKey() === 'management_welcome'" class="space-y-3">
              <input v-model="sectionForm.content.badge" placeholder="Badge" class="w-full rounded-xl border-brand-sand text-sm" />
              <input v-model="sectionForm.content.title" placeholder="Judul Sambutan" class="w-full rounded-xl border-brand-sand text-sm font-bold" />
              <div class="grid grid-cols-2 gap-3">
                <input v-model="sectionForm.content.director_name" placeholder="Nama Direktur" class="rounded-xl border-brand-sand text-sm" />
                <input v-model="sectionForm.content.director_role" placeholder="Jabatan" class="rounded-xl border-brand-sand text-sm" />
              </div>
              <input v-model="sectionForm.content.quote" placeholder="Kutipan" class="w-full rounded-xl border-brand-sand text-sm italic" />
              <textarea v-model="sectionForm.content.description" rows="3" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
              <input v-model="sectionForm.content.image" placeholder="Path Foto Direktur" class="w-full rounded-xl border-brand-sand text-xs font-mono" />
            </div>

            <!-- Generic Title / Subtitle / Items Editor -->
            <div v-else class="space-y-4">
              <input v-if="'badge' in sectionForm.content" v-model="sectionForm.content.badge" placeholder="Badge" class="w-full rounded-xl border-brand-sand text-sm" />
              <input v-if="'title' in sectionForm.content" v-model="sectionForm.content.title" placeholder="Judul Section" class="w-full rounded-xl border-brand-sand text-sm font-bold" />
              <textarea v-if="'subtitle' in sectionForm.content" v-model="sectionForm.content.subtitle" rows="2" placeholder="Subjudul" class="w-full rounded-xl border-brand-sand text-sm"></textarea>

              <!-- Services or Testimonials Items -->
              <div v-if="Array.isArray(sectionForm.content.items)" class="space-y-3 pt-2">
                <div class="flex justify-between items-center">
                  <span class="text-xs font-bold uppercase text-brand-dark">Daftar Item</span>
                  <button
                    type="button"
                    @click="activeKey() === 'testimonials' ? addTestimonialItem() : addServiceItem()"
                    class="inline-flex items-center gap-1 text-xs font-bold text-brand-primary"
                  >
                    <Plus class="w-3.5 h-3.5" /> Tambah Item
                  </button>
                </div>
                <div v-for="(item, idx) in sectionForm.content.items" :key="idx" class="p-3.5 rounded-xl bg-brand-cream/50 border border-brand-sand space-y-2">
                  <div class="flex justify-between">
                    <span class="text-xs font-bold">#{{ idx + 1 }}</span>
                    <button type="button" @click="sectionForm.content.items.splice(idx, 1)" class="text-rose-600"><Trash2 class="w-4 h-4" /></button>
                  </div>
                  <template v-if="activeKey() === 'testimonials'">
                    <div class="grid grid-cols-2 gap-2">
                      <input v-model="item.name" placeholder="Nama Pasien" class="rounded-lg border-brand-sand text-xs" />
                      <input v-model="item.role" placeholder="Poli / Keterangan" class="rounded-lg border-brand-sand text-xs" />
                    </div>
                    <textarea v-model="item.comment" rows="2" placeholder="Komentar" class="w-full rounded-lg border-brand-sand text-xs"></textarea>
                  </template>
                  <template v-else>
                    <div class="grid grid-cols-2 gap-2">
                      <input v-model="item.title" placeholder="Judul Layanan" class="rounded-lg border-brand-sand text-xs font-bold" />
                      <input v-model="item.icon" placeholder="Icon (Ambulance, HeartPulse, etc)" class="rounded-lg border-brand-sand text-xs" />
                    </div>
                    <textarea v-model="item.description" rows="2" placeholder="Deskripsi" class="w-full rounded-lg border-brand-sand text-xs"></textarea>
                  </template>
                </div>
              </div>
            </div>

            <div class="pt-4 border-t border-brand-sand flex justify-end">
              <button type="submit" :disabled="sectionForm.processing" class="inline-flex items-center gap-2 px-6 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold">
                <Save class="w-4 h-4" />
                <span>Simpan Perubahan Komponen</span>
              </button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
