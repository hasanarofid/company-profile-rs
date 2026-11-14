<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { ChevronLeft, MapPin, Clock, CheckCircle2, Upload, Send } from '@lucide/vue';

const props = defineProps({
  career: { type: Object, required: true },
});

const page = usePage();
const flashSuccess = computed(() => page.props.flash?.success);

const form = useForm({
  applicant_name: '',
  email: '',
  phone: '',
  education: '',
  experience_summary: '',
  cover_letter: '',
  cv_file: null,
});

const handleFile = (e) => {
  form.cv_file = e.target.files[0] || null;
};

const submit = () => {
  form.post(`/karir/${props.career.slug}/lamar`, {
    forceFormData: true,
    preserveScroll: true,
    onSuccess: () => {
      form.reset();
    },
  });
};
</script>

<template>
  <Head :title="`Lowongan: ${career.title}`" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <Link href="/karir" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-primary hover:text-brand-dark">
        <ChevronLeft class="w-4 h-4" /> Kembali ke Daftar Lowongan
      </Link>

      <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
        <!-- Job Details -->
        <div class="lg:col-span-7 bg-white rounded-3xl border border-brand-sand p-6 sm:p-8 shadow-sm space-y-6">
          <div class="space-y-3 border-b border-brand-sand pb-6">
            <div class="flex flex-wrap items-center gap-2">
              <span class="px-3 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold">{{ career.category }}</span>
              <span class="px-3 py-1 rounded-full bg-brand-cream text-brand-dark text-xs font-semibold">{{ career.employment_type }}</span>
            </div>
            <h1 class="text-2xl sm:text-3xl font-extrabold text-brand-dark">{{ career.title }}</h1>
            <div class="flex flex-wrap items-center gap-4 text-xs text-brand-leaf">
              <span class="inline-flex items-center gap-1.5"><MapPin class="w-4 h-4 text-brand-primary" /> {{ career.location }}</span>
              <span v-if="career.deadline" class="inline-flex items-center gap-1.5"><Clock class="w-4 h-4 text-brand-primary" /> Batas Lamaran: {{ career.deadline }}</span>
            </div>
          </div>

          <div class="space-y-2">
            <h2 class="font-bold text-lg text-brand-dark">Deskripsi Pekerjaan</h2>
            <p class="text-sm text-brand-leaf leading-relaxed">{{ career.description }}</p>
          </div>

          <div v-if="career.requirements?.length" class="space-y-3">
            <h2 class="font-bold text-lg text-brand-dark">Kualifikasi & Persyaratan</h2>
            <ul class="space-y-2">
              <li v-for="(req, i) in career.requirements" :key="i" class="flex items-start gap-2.5 text-sm text-brand-dark/90">
                <CheckCircle2 class="w-4 h-4 text-brand-primary shrink-0 mt-0.5" />
                <span>{{ req }}</span>
              </li>
            </ul>
          </div>

          <div v-if="career.benefits?.length" class="space-y-3">
            <h2 class="font-bold text-lg text-brand-dark">Fasilitas & Benefit</h2>
            <ul class="space-y-2">
              <li v-for="(ben, i) in career.benefits" :key="i" class="flex items-start gap-2.5 text-sm text-brand-dark/90">
                <CheckCircle2 class="w-4 h-4 text-emerald-600 shrink-0 mt-0.5" />
                <span>{{ ben }}</span>
              </li>
            </ul>
          </div>
        </div>

        <!-- Application Form -->
        <div class="lg:col-span-5">
          <div class="bg-white rounded-3xl border border-brand-sand p-6 sm:p-8 shadow-sm space-y-5 sticky top-28">
            <h2 class="text-xl font-bold text-brand-dark">Kirim Lamaran Kerja</h2>

            <div v-if="flashSuccess" class="p-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-800 text-sm font-medium flex items-start gap-2.5">
              <CheckCircle2 class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" />
              <span>{{ flashSuccess }}</span>
            </div>

            <form @submit.prevent="submit" class="space-y-4">
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nama Lengkap *</label>
                <input v-model="form.applicant_name" type="text" required class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-2.5 px-3.5" />
                <p v-if="form.errors.applicant_name" class="text-xs text-rose-600 mt-1">{{ form.errors.applicant_name }}</p>
              </div>

              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Email Aktif *</label>
                <input v-model="form.email" type="email" required class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-2.5 px-3.5" />
                <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
              </div>

              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">No. HP / WhatsApp *</label>
                <input v-model="form.phone" type="text" required class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-2.5 px-3.5" />
              </div>

              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Pendidikan Terakhir & Jurusan *</label>
                <input v-model="form.education" type="text" required placeholder="Contoh: S1 Keperawatan (Ners)" class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-2.5 px-3.5" />
              </div>

              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Ringkasan Pengalaman / STR / SIP</label>
                <textarea v-model="form.experience_summary" rows="2" class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-2.5 px-3.5"></textarea>
              </div>

              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Upload CV & Berkas (PDF/DOCX, maks 5MB) *</label>
                <label class="flex items-center justify-center gap-2 p-4 rounded-xl border-2 border-dashed border-brand-sand hover:border-brand-primary bg-brand-cream/40 cursor-pointer text-xs font-semibold text-brand-dark transition-colors">
                  <Upload class="w-4 h-4 text-brand-primary" />
                  <span>{{ form.cv_file ? form.cv_file.name : 'Pilih File CV / Portofolio' }}</span>
                  <input type="file" accept=".pdf,.doc,.docx" @change="handleFile" required class="hidden" />
                </label>
                <p v-if="form.errors.cv_file" class="text-xs text-rose-600 mt-1">{{ form.errors.cv_file }}</p>
              </div>

              <button
                type="submit"
                :disabled="form.processing"
                class="w-full inline-flex items-center justify-center gap-2 py-3.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white font-bold text-sm transition-colors disabled:opacity-50"
              >
                <Send class="w-4 h-4" />
                <span>{{ form.processing ? 'Mengirim Lamaran...' : 'Kirim Berkas Lamaran' }}</span>
              </button>
            </form>
          </div>
        </div>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>

