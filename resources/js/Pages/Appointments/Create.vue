<script setup>
import { computed, watch } from 'vue';
import { Head, useForm, usePage, Link } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { CalendarCheck, CheckCircle2, MessageCircle, Clock, User, Stethoscope } from '@lucide/vue';

const props = defineProps({
  departments: { type: Array, default: () => [] },
  doctors: { type: Array, default: () => [] },
  preselectedDoctorId: { type: Number, default: null },
  preselectedDepartmentId: { type: Number, default: null },
  bookingResult: { type: Object, default: null },
});

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});

const initialDoctor = props.doctors.find((d) => d.id === props.preselectedDoctorId);
const initialDeptId = initialDoctor ? initialDoctor.department_id : (props.preselectedDepartmentId || '');

const form = useForm({
  department_id: initialDeptId,
  doctor_id: props.preselectedDoctorId || '',
  appointment_date: new Date(Date.now() + 86400000).toISOString().slice(0, 10),
  appointment_time: '',
  patient_name: '',
  patient_phone: '',
  patient_email: '',
  patient_dob: '',
  patient_nik: '',
  payment_type: 'Umum',
  complaint: '',
});

const filteredDoctors = computed(() => {
  if (!form.department_id) return props.doctors;
  return props.doctors.filter((d) => Number(d.department_id) === Number(form.department_id));
});

const selectedDoctor = computed(() => {
  return props.doctors.find((d) => Number(d.id) === Number(form.doctor_id));
});

const availableTimeSlots = computed(() => {
  if (selectedDoctor.value?.schedules?.length) {
    return selectedDoctor.value.schedules.map((s) => `${s.day_of_week}: ${s.start_time} - ${s.end_time}`);
  }
  return ['Pagi: 08:00 - 12:00', 'Siang: 13:00 - 16:00', 'Sore: 17:00 - 20:00'];
});

watch(() => form.department_id, (newVal) => {
  if (selectedDoctor.value && Number(selectedDoctor.value.department_id) !== Number(newVal)) {
    form.doctor_id = '';
    form.appointment_time = '';
  }
});

watch(() => form.doctor_id, () => {
  if (availableTimeSlots.value.length && !availableTimeSlots.value.includes(form.appointment_time)) {
    form.appointment_time = availableTimeSlots.value[0];
  }
}, { immediate: true });

const submit = () => {
  form.post('/janji-temu', {
    preserveScroll: true,
    onSuccess: () => {
      form.reset('patient_name', 'patient_phone', 'patient_email', 'patient_dob', 'patient_nik', 'complaint');
    },
  });
};

const whatsappConfirmUrl = computed(() => {
  if (!props.bookingResult) return '#';
  const num = (settings.value.whatsapp_number || '6281234567890').replace(/[^0-9]/g, '');
  const b = props.bookingResult;
  const text = `Halo ${settings.value.site_name || 'RSU Medika Nusantara'}, saya ingin konfirmasi Janji Temu Online:\n\n` +
    `Kode Booking: *${b.booking_code}*\n` +
    `Nama Pasien: ${b.patient_name}\n` +
    `Poli/Unit: ${b.department_name}\n` +
    `Dokter: ${b.doctor_name}\n` +
    `Tanggal: ${b.appointment_date}\n` +
    `Jam: ${b.appointment_time}\n` +
    `Penjamin: ${b.payment_type}`;
  return `https://wa.me/${num}?text=${encodeURIComponent(text)}`;
});
</script>

<template>
  <Head title="Buat Janji Temu Dokter Online" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <section class="bg-brand-deep text-white py-12">
      <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 space-y-2">
        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full bg-white/10 text-amber-300 text-xs font-semibold">
          <CalendarCheck class="w-3.5 h-3.5" />
          Reservasi Poliklinik Online
        </span>
        <h1 class="text-3xl sm:text-4xl font-extrabold">Buat Janji Temu Dokter</h1>
        <p class="text-white/80 text-sm sm:text-base">
          Pilih poliklinik, dokter spesialis, dan jadwal kunjungan Anda tanpa perlu antre lama di loket pendaftaran.
        </p>
      </div>
    </section>

    <main class="flex-1 max-w-5xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10">
      <!-- Booking Success Confirmation -->
      <div
        v-if="bookingResult"
        class="mb-8 bg-white rounded-3xl border-2 border-emerald-500 p-6 sm:p-8 shadow-lg space-y-6"
      >
        <div class="flex items-start gap-4">
          <div class="w-12 h-12 rounded-2xl bg-emerald-100 text-emerald-700 flex items-center justify-center shrink-0">
            <CheckCircle2 class="w-7 h-7" />
          </div>
          <div>
            <span class="text-xs font-bold uppercase tracking-wider text-emerald-700">Reservasi Berhasil Tercatat</span>
            <h2 class="text-2xl font-extrabold text-brand-dark mt-0.5">Kode Booking: {{ bookingResult.booking_code }}</h2>
            <p class="text-sm text-brand-leaf mt-1">
              Simpan kode booking Anda atau klik tombol di bawah untuk konfirmasi langsung melalui WhatsApp Pendaftaran RS.
            </p>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 bg-brand-cream p-5 rounded-2xl border border-brand-sand text-sm">
          <div>
            <p class="text-xs text-brand-leaf">Nama Pasien</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.patient_name }}</p>
          </div>
          <div>
            <p class="text-xs text-brand-leaf">Poliklinik</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.department_name }}</p>
          </div>
          <div>
            <p class="text-xs text-brand-leaf">Dokter Spesialis</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.doctor_name }}</p>
          </div>
          <div>
            <p class="text-xs text-brand-leaf">Tanggal Kunjungan</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.appointment_date }}</p>
          </div>
          <div>
            <p class="text-xs text-brand-leaf">Sesi / Jam</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.appointment_time }}</p>
          </div>
          <div>
            <p class="text-xs text-brand-leaf">Penjamin</p>
            <p class="font-bold text-brand-dark">{{ bookingResult.payment_type }}</p>
          </div>
        </div>

        <div class="flex flex-wrap items-center gap-3">
          <a
            :href="whatsappConfirmUrl"
            target="_blank"
            class="inline-flex items-center gap-2 px-6 py-3.5 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white font-bold text-sm shadow-sm transition-colors"
          >
            <MessageCircle class="w-4 h-4" />
            <span>Konfirmasi via WhatsApp RS</span>
          </a>
          <Link
            href="/dokter"
            class="px-5 py-3.5 rounded-xl border border-brand-sand hover:bg-brand-sand/50 text-sm font-semibold text-brand-dark"
          >
            Lihat Jadwal Dokter Lain
          </Link>
        </div>
      </div>

      <!-- Appointment Form -->
      <form @submit.prevent="submit" class="bg-white rounded-3xl border border-brand-sand shadow-sm p-6 sm:p-10 space-y-8">
        <!-- Step 1: Poli & Dokter -->
        <div class="space-y-4">
          <h2 class="text-lg font-bold text-brand-dark flex items-center gap-2 border-b border-brand-sand pb-3">
            <Stethoscope class="w-5 h-5 text-brand-primary" />
            <span>1. Pilih Poliklinik, Dokter & Jadwal</span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Unit / Poliklinik *</label>
              <select
                v-model="form.department_id"
                required
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              >
                <option value="">-- Pilih Poliklinik --</option>
                <option v-for="dept in departments" :key="dept.id" :value="dept.id">
                  {{ dept.name }}
                </option>
              </select>
              <p v-if="form.errors.department_id" class="text-xs text-rose-600 mt-1">{{ form.errors.department_id }}</p>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Dokter Spesialis *</label>
              <select
                v-model="form.doctor_id"
                required
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              >
                <option value="">-- Pilih Dokter --</option>
                <option v-for="doc in filteredDoctors" :key="doc.id" :value="doc.id">
                  {{ doc.name }} ({{ doc.specialization }})
                </option>
              </select>
              <p v-if="form.errors.doctor_id" class="text-xs text-rose-600 mt-1">{{ form.errors.doctor_id }}</p>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Tanggal Kunjungan *</label>
              <input
                v-model="form.appointment_date"
                type="date"
                :min="new Date().toISOString().slice(0, 10)"
                required
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
              <p v-if="form.errors.appointment_date" class="text-xs text-rose-600 mt-1">{{ form.errors.appointment_date }}</p>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Pilih Sesi / Jam Praktik *</label>
              <select
                v-model="form.appointment_time"
                required
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              >
                <option v-for="slot in availableTimeSlots" :key="slot" :value="slot">
                  {{ slot }}
                </option>
              </select>
              <p v-if="form.errors.appointment_time" class="text-xs text-rose-600 mt-1">{{ form.errors.appointment_time }}</p>
            </div>
          </div>
        </div>

        <!-- Step 2: Data Pasien -->
        <div class="space-y-4">
          <h2 class="text-lg font-bold text-brand-dark flex items-center gap-2 border-b border-brand-sand pb-3">
            <User class="w-5 h-5 text-brand-primary" />
            <span>2. Data Pasien</span>
          </h2>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Nama Lengkap Pasien *</label>
              <input
                v-model="form.patient_name"
                type="text"
                required
                placeholder="Contoh: Budi Santoso"
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
              <p v-if="form.errors.patient_name" class="text-xs text-rose-600 mt-1">{{ form.errors.patient_name }}</p>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Nomor HP / WhatsApp *</label>
              <input
                v-model="form.patient_phone"
                type="text"
                required
                placeholder="0812xxxxxxxx"
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
              <p v-if="form.errors.patient_phone" class="text-xs text-rose-600 mt-1">{{ form.errors.patient_phone }}</p>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Email (Opsional)</label>
              <input
                v-model="form.patient_email"
                type="email"
                placeholder="email@contoh.com"
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Metode Penjamin / Pembayaran *</label>
              <select
                v-model="form.payment_type"
                required
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              >
                <option value="Umum">Pasien Umum / Pribadi</option>
                <option value="BPJS Kesehatan">BPJS Kesehatan</option>
                <option value="Asuransi Swasta">Asuransi Kesehatan Swasta</option>
              </select>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Tanggal Lahir (Opsional)</label>
              <input
                v-model="form.patient_dob"
                type="date"
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">NIK / No. RM (Opsional)</label>
              <input
                v-model="form.patient_nik"
                type="text"
                placeholder="16 digit NIK atau No. Rekam Medis"
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              />
            </div>

            <div class="md:col-span-2">
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1.5">Keluhan / Catatan Tambahan</label>
              <textarea
                v-model="form.complaint"
                rows="3"
                placeholder="Tuliskan keluhan singkat atau keperluan konsultasi..."
                class="w-full rounded-xl border-brand-sand bg-brand-cream/40 text-sm py-3 px-4 focus:border-brand-primary focus:ring-brand-primary"
              ></textarea>
            </div>
          </div>
        </div>

        <div class="pt-4 border-t border-brand-sand flex flex-col sm:flex-row items-center justify-between gap-4">
          <p class="text-xs text-brand-leaf flex items-center gap-1.5">
            <Clock class="w-4 h-4 text-brand-primary" />
            Mohon hadir 15 menit sebelum jadwal praktik dimulai.
          </p>
          <button
            type="submit"
            :disabled="form.processing"
            class="w-full sm:w-auto px-8 py-3.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white font-bold text-sm shadow-sm transition-all disabled:opacity-50"
          >
            {{ form.processing ? 'Memproses...' : 'Kirim Reservasi Janji Temu' }}
          </button>
        </div>
      </form>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
