<script setup>
import { ref } from 'vue';
import { Head, useForm } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Save, Palette, Building2, Phone, Image as ImageIcon, Sparkles } from '@lucide/vue';

const props = defineProps({
  settings: { type: Object, required: true },
});

const currentTab = ref('hospital');

const form = useForm({
  site_name: props.settings.site_name || 'RSU Medika Nusantara',
  site_tagline: props.settings.site_tagline || '',
  site_description: props.settings.site_description || '',
  whatsapp_number: props.settings.whatsapp_number || '',
  emergency_phone: props.settings.emergency_phone || '',
  phone: props.settings.phone || '',
  email: props.settings.email || '',
  address: props.settings.address || '',
  maps_url: props.settings.maps_url || '',
  working_hours: props.settings.working_hours || '',
  theme_primary: props.settings.theme_primary || '#0D6E6E',
  theme_dark: props.settings.theme_dark || '#0A3D4A',
  theme_deep: props.settings.theme_deep || '#062832',
  theme_cream: props.settings.theme_cream || '#F5F9F9',
  theme_sand: props.settings.theme_sand || '#E6F2F2',
  theme_gold: props.settings.theme_gold || '#D97706',
  show_emergency_bar: props.settings.show_emergency_bar !== '0',
  site_logo: null,
});

const logoPreview = ref(props.settings.site_logo_url || null);

const presets = [
  { name: 'Medical Teal (Default)', primary: '#0D6E6E', dark: '#0A3D4A', deep: '#062832', cream: '#F5F9F9', sand: '#E6F2F2', gold: '#D97706' },
  { name: 'Clinical Royal Blue', primary: '#1D4ED8', dark: '#1E3A8A', deep: '#0F172A', cream: '#F8FAFC', sand: '#EFF6FF', gold: '#0EA5E9' },
  { name: 'Emerald Healthcare', primary: '#059669', dark: '#065F46', deep: '#022C22', cream: '#F4FBF7', sand: '#E6F6EE', gold: '#F59E0B' },
  { name: 'Modern Slate Indigo', primary: '#4F46E5', dark: '#312E81', deep: '#1E1B4B', cream: '#F8FAFC', sand: '#EEF2FF', gold: '#EC4899' },
];

const applyPreset = (p) => {
  form.theme_primary = p.primary;
  form.theme_dark = p.dark;
  form.theme_deep = p.deep;
  form.theme_cream = p.cream;
  form.theme_sand = p.sand;
  form.theme_gold = p.gold;
};

const handleLogo = (e) => {
  const file = e.target.files[0];
  if (file) {
    form.site_logo = file;
    logoPreview.value = URL.createObjectURL(file);
  }
};

const submit = () => {
  form.post(route('admin.settings.update'), {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      // Reload to apply updated :root CSS vars from server
      window.location.reload();
    },
  });
};
</script>

<template>
  <Head title="Pengaturan RS & Theme Customizer" />

  <AdminLayout>
    <div class="space-y-6 max-w-4xl">
      <div>
        <h1 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2">
          <Palette class="w-6 h-6 text-brand-primary" />
          Pengaturan Rumah Sakit & Theme Customizer
        </h1>
        <p class="text-sm text-brand-leaf mt-1">Ubah identitas rumah sakit, nomor IGD/WhatsApp, logo, serta warna tema website secara real-time tanpa mengubah kode.</p>
      </div>

      <!-- Tabs -->
      <div class="flex flex-wrap gap-2 border-b border-brand-sand">
        <button @click="currentTab = 'hospital'" :class="[currentTab === 'hospital' ? 'border-brand-primary text-brand-primary font-bold' : 'border-transparent text-brand-leaf', 'px-5 py-3 border-b-2 text-sm inline-flex items-center gap-2']">
          <Building2 class="w-4 h-4" /> Identitas & Kontak RS
        </button>
        <button @click="currentTab = 'theme'" :class="[currentTab === 'theme' ? 'border-brand-primary text-brand-primary font-bold' : 'border-transparent text-brand-leaf', 'px-5 py-3 border-b-2 text-sm inline-flex items-center gap-2']">
          <Sparkles class="w-4 h-4" /> Customizer Warna & Tampilan
        </button>
        <button @click="currentTab = 'logo'" :class="[currentTab === 'logo' ? 'border-brand-primary text-brand-primary font-bold' : 'border-transparent text-brand-leaf', 'px-5 py-3 border-b-2 text-sm inline-flex items-center gap-2']">
          <ImageIcon class="w-4 h-4" /> Logo Resmi RS
        </button>
      </div>

      <form @submit.prevent="submit" class="bg-white rounded-3xl border border-brand-sand p-6 sm:p-8 shadow-sm space-y-6">
        <!-- Tab 1: Hospital Info -->
        <div v-show="currentTab === 'hospital'" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nama Rumah Sakit *</label>
            <input v-model="form.site_name" type="text" required class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Tagline</label>
            <input v-model="form.site_tagline" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Deskripsi Singkat (SEO)</label>
            <textarea v-model="form.site_description" rows="2" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
          </div>
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nomor WhatsApp (628xxx)</label>
            <input v-model="form.whatsapp_number" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Hotline IGD 24 Jam</label>
            <input v-model="form.emergency_phone" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Telepon Informasi</label>
            <input v-model="form.phone" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Email Resmi</label>
            <input v-model="form.email" type="email" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Jam Operasional</label>
            <input v-model="form.working_hours" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
          </div>
          <div class="sm:col-span-2">
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Alamat Lengkap</label>
            <textarea v-model="form.address" rows="2" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
          </div>
        </div>

        <!-- Tab 2: Theme Customizer -->
        <div v-show="currentTab === 'theme'" class="space-y-6">
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-2">Preset Palet Warna Rumah Sakit</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
              <button
                v-for="p in presets"
                :key="p.name"
                type="button"
                @click="applyPreset(p)"
                class="flex items-center justify-between p-3.5 rounded-xl border border-brand-sand hover:border-brand-primary bg-brand-cream/40 text-left transition-all"
              >
                <span class="text-xs font-bold text-brand-dark">{{ p.name }}</span>
                <div class="flex items-center gap-1">
                  <span class="w-4 h-4 rounded-full border border-white shadow-sm" :style="{ background: p.primary }"></span>
                  <span class="w-4 h-4 rounded-full border border-white shadow-sm" :style="{ background: p.dark }"></span>
                  <span class="w-4 h-4 rounded-full border border-white shadow-sm" :style="{ background: p.gold }"></span>
                </div>
              </button>
            </div>
          </div>

          <div class="grid grid-cols-2 sm:grid-cols-3 gap-4">
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Warna Utama (Primary)</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_primary" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_primary" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Warna Teks / Heading</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_dark" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_dark" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Header / Footer Gelap</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_deep" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_deep" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Background Halaman</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_cream" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_cream" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Surface / Card Tint</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_sand" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_sand" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
            <div class="p-3 rounded-xl border border-brand-sand bg-brand-cream/30">
              <label class="block text-xs font-bold text-brand-dark mb-1">Warna Aksen</label>
              <div class="flex items-center gap-2">
                <input type="color" v-model="form.theme_gold" class="w-10 h-10 rounded cursor-pointer border-0" />
                <input type="text" v-model="form.theme_gold" class="w-full rounded-lg border-brand-sand text-xs font-mono" />
              </div>
            </div>
          </div>

          <label class="inline-flex items-center gap-2.5 text-sm font-semibold text-brand-dark">
            <input type="checkbox" v-model="form.show_emergency_bar" class="rounded border-brand-sand text-brand-primary" />
            <span>Tampilkan Bar Darurat IGD 24 Jam di bagian paling atas website</span>
          </label>
        </div>

        <!-- Tab 3: Logo -->
        <div v-show="currentTab === 'logo'" class="space-y-4">
          <div v-if="logoPreview" class="p-4 rounded-2xl bg-brand-cream border border-brand-sand inline-block">
            <img :src="logoPreview" alt="Preview Logo" class="h-20 w-auto object-contain" />
          </div>
          <div>
            <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Upload Logo Baru (PNG/JPG/SVG)</label>
            <input type="file" accept="image/*" @change="handleLogo" class="text-sm" />
          </div>
        </div>

        <div class="pt-4 border-t border-brand-sand flex justify-end">
          <button
            type="submit"
            :disabled="form.processing"
            class="inline-flex items-center gap-2 px-6 py-3 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold shadow-sm transition-colors"
          >
            <Save class="w-4 h-4" />
            <span>{{ form.processing ? 'Menyimpan...' : 'Simpan Pengaturan & Tema' }}</span>
          </button>
        </div>
      </form>
    </div>
  </AdminLayout>
</template>
