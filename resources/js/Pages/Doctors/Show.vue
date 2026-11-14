<script setup>
import { Head, Link } from '@inertiajs/vue3';
import HeaderNavbar from '@/Components/Frontend/HeaderNavbar.vue';
import FooterSection from '@/Components/Frontend/FooterSection.vue';
import FloatingWhatsapp from '@/Components/Frontend/FloatingWhatsapp.vue';
import { CalendarCheck, GraduationCap, Award, Clock, MapPin, ChevronLeft, FileBadge } from '@lucide/vue';

defineProps({
  doctor: { type: Object, required: true },
  otherDoctors: { type: Array, default: () => [] },
});
</script>

<template>
  <Head :title="`${doctor.name} — Profil Dokter`" />

  <div class="min-h-screen bg-brand-cream text-brand-dark font-sans flex flex-col">
    <HeaderNavbar />

    <main class="flex-1 max-w-6xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-10 space-y-8">
      <Link
        href="/dokter"
        class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand-primary hover:text-brand-dark"
      >
        <ChevronLeft class="w-4 h-4" /> Kembali ke Direktori Dokter
      </Link>

      <div class="bg-white rounded-3xl border border-brand-sand shadow-sm overflow-hidden">
        <div class="grid grid-cols-1 lg:grid-cols-12">
          <div class="lg:col-span-4 bg-brand-sand/30 p-6 sm:p-8 flex flex-col items-center text-center border-b lg:border-b-0 lg:border-r border-brand-sand">
            <img
              :src="doctor.photo || '/images/hospital/doctors/doctor-1.jpg'"
              :alt="doctor.name"
              class="w-56 h-64 rounded-2xl object-cover object-top shadow-md border border-white"
            />
            <span class="mt-5 px-3 py-1 rounded-full bg-brand-sand text-brand-primary text-xs font-bold">
              {{ doctor.department?.name }}
            </span>
            <h1 class="text-xl font-extrabold text-brand-dark mt-3">{{ doctor.name }}</h1>
            <p class="text-sm text-brand-leaf font-medium mt-1">{{ doctor.specialization }}</p>
            <p v-if="doctor.sub_specialization" class="text-xs text-brand-leaf/80 mt-0.5">{{ doctor.sub_specialization }}</p>

            <Link
              :href="`/janji-temu?doctor_id=${doctor.id}`"
              class="mt-6 w-full inline-flex items-center justify-center gap-2 py-3.5 px-5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold shadow-sm transition-colors"
            >
              <CalendarCheck class="w-4 h-4" />
              <span>Buat Janji Temu</span>
            </Link>
          </div>

          <div class="lg:col-span-8 p-6 sm:p-10 space-y-8">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div class="p-4 rounded-2xl bg-brand-cream border border-brand-sand flex items-start gap-3">
                <GraduationCap class="w-5 h-5 text-brand-primary shrink-0 mt-0.5" />
                <div>
                  <p class="text-xs font-bold uppercase text-brand-leaf">Pendidikan</p>
                  <p class="text-sm font-semibold text-brand-dark mt-0.5">{{ doctor.education || 'Universitas Terakreditasi' }}</p>
                </div>
              </div>
              <div class="p-4 rounded-2xl bg-brand-cream border border-brand-sand flex items-start gap-3">
                <Award class="w-5 h-5 text-brand-primary shrink-0 mt-0.5" />
                <div>
                  <p class="text-xs font-bold uppercase text-brand-leaf">Pengalaman Klinis</p>
                  <p class="text-sm font-semibold text-brand-dark mt-0.5">{{ doctor.experience_years || 5 }}+ Tahun Pengalaman</p>
                </div>
              </div>
              <div v-if="doctor.sip_number" class="p-4 rounded-2xl bg-brand-cream border border-brand-sand flex items-start gap-3">
                <FileBadge class="w-5 h-5 text-brand-primary shrink-0 mt-0.5" />
                <div>
                  <p class="text-xs font-bold uppercase text-brand-leaf">Nomor SIP</p>
                  <p class="text-sm font-semibold text-brand-dark mt-0.5">{{ doctor.sip_number }}</p>
                </div>
              </div>
              <div v-if="doctor.department?.location" class="p-4 rounded-2xl bg-brand-cream border border-brand-sand flex items-start gap-3">
                <MapPin class="w-5 h-5 text-brand-primary shrink-0 mt-0.5" />
                <div>
                  <p class="text-xs font-bold uppercase text-brand-leaf">Lokasi Poli</p>
                  <p class="text-sm font-semibold text-brand-dark mt-0.5">{{ doctor.department.location }}</p>
                </div>
              </div>
            </div>

            <div v-if="doctor.bio" class="space-y-2">
              <h2 class="text-lg font-bold text-brand-dark">Tentang Dokter</h2>
              <p class="text-sm text-brand-leaf leading-relaxed">{{ doctor.bio }}</p>
            </div>

            <div class="space-y-3">
              <h2 class="text-lg font-bold text-brand-dark flex items-center gap-2">
                <Clock class="w-5 h-5 text-brand-primary" />
                Jadwal Praktik Mingguan
              </h2>
              <div class="overflow-hidden rounded-2xl border border-brand-sand">
                <table class="w-full text-sm text-left">
                  <thead class="bg-brand-sand/50 text-brand-dark font-bold text-xs uppercase">
                    <tr>
                      <th class="px-4 py-3">Hari</th>
                      <th class="px-4 py-3">Jam Praktik</th>
                      <th class="px-4 py-3">Ruang</th>
                    </tr>
                  </thead>
                  <tbody class="divide-y divide-brand-sand">
                    <tr v-for="sch in doctor.schedules" :key="sch.id" class="bg-white">
                      <td class="px-4 py-3 font-semibold text-brand-dark">{{ sch.day_of_week }}</td>
                      <td class="px-4 py-3 text-brand-primary font-semibold">{{ sch.start_time }} - {{ sch.end_time }} WIB</td>
                      <td class="px-4 py-3 text-brand-leaf">{{ sch.room || doctor.department?.name }}</td>
                    </tr>
                    <tr v-if="!doctor.schedules?.length">
                      <td colspan="3" class="px-4 py-4 text-center text-brand-leaf italic">Jadwal praktik berdasarkan perjanjian.</td>
                    </tr>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <FooterSection />
    <FloatingWhatsapp />
  </div>
</template>
