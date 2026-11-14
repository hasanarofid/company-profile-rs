<script setup>
import { ref } from 'vue';
import { Head, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { CalendarCheck, Search, Trash2, MessageCircle } from '@lucide/vue';

const props = defineProps({
  appointments: { type: Array, default: () => [] },
  filters: { type: Object, default: () => ({}) },
});

const search = ref(props.filters.search || '');
const status = ref(props.filters.status || '');

const applyFilters = () => {
  router.get(route('admin.appointments.index'), {
    search: search.value || undefined,
    status: status.value || undefined,
  }, { preserveState: true, replace: true });
};

const updateStatus = (apt, newStatus) => {
  router.patch(route('admin.appointments.status', apt.id), {
    status: newStatus,
    admin_notes: apt.admin_notes,
  }, { preserveScroll: true });
};

const remove = (id) => {
  if (confirm('Hapus data janji temu ini?')) {
    router.delete(route('admin.appointments.destroy', id), { preserveScroll: true });
  }
};

const statusBadge = {
  pending: 'bg-amber-100 text-amber-800',
  confirmed: 'bg-emerald-100 text-emerald-800',
  completed: 'bg-sky-100 text-sky-800',
  cancelled: 'bg-rose-100 text-rose-800',
};
</script>

<template>
  <Head title="Kelola Janji Temu Pasien" />

  <AdminLayout>
    <div class="space-y-6">
      <div>
        <h1 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2">
          <CalendarCheck class="w-6 h-6 text-brand-primary" />
          Manajemen Janji Temu Pasien
        </h1>
        <p class="text-sm text-brand-leaf mt-1">Konfirmasi, kelola, dan pantau reservasi poliklinik pasien.</p>
      </div>

      <!-- Filters -->
      <div class="bg-white p-4 rounded-2xl border border-brand-sand flex flex-col sm:flex-row gap-3">
        <div class="relative flex-1">
          <Search class="w-4 h-4 text-brand-leaf absolute left-3.5 top-1/2 -translate-y-1/2" />
          <input
            v-model="search"
            @keyup.enter="applyFilters"
            type="text"
            placeholder="Cari kode booking, nama pasien, atau no. HP..."
            class="w-full pl-10 pr-4 py-2.5 rounded-xl border-brand-sand bg-brand-cream/40 text-sm"
          />
        </div>
        <select v-model="status" @change="applyFilters" class="rounded-xl border-brand-sand bg-brand-cream/40 text-sm px-4 py-2.5">
          <option value="">Semua Status</option>
          <option value="pending">Pending</option>
          <option value="confirmed">Confirmed</option>
          <option value="completed">Completed</option>
          <option value="cancelled">Cancelled</option>
        </select>
        <button @click="applyFilters" class="px-5 py-2.5 rounded-xl bg-brand-primary text-white text-sm font-bold">Cari</button>
      </div>

      <!-- Table -->
      <div class="bg-white rounded-2xl border border-brand-sand shadow-sm overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-brand-sand/50 text-xs uppercase font-bold text-brand-dark">
            <tr>
              <th class="px-4 py-3.5">Kode & Pasien</th>
              <th class="px-4 py-3.5">Poli & Dokter</th>
              <th class="px-4 py-3.5">Jadwal</th>
              <th class="px-4 py-3.5">Penjamin</th>
              <th class="px-4 py-3.5">Status</th>
              <th class="px-4 py-3.5 text-right">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-brand-sand">
            <tr v-for="apt in appointments" :key="apt.id" class="hover:bg-brand-cream/40">
              <td class="px-4 py-3.5">
                <span class="font-mono text-xs font-bold text-brand-primary">{{ apt.booking_code }}</span>
                <p class="font-bold text-brand-dark">{{ apt.patient_name }}</p>
                <p class="text-xs text-brand-leaf">{{ apt.patient_phone }}</p>
              </td>
              <td class="px-4 py-3.5">
                <p class="font-semibold text-brand-dark">{{ apt.department?.name }}</p>
                <p class="text-xs text-brand-leaf">{{ apt.doctor?.name }}</p>
              </td>
              <td class="px-4 py-3.5">
                <p class="font-semibold">{{ apt.appointment_date }}</p>
                <p class="text-xs text-brand-leaf">{{ apt.appointment_time }}</p>
              </td>
              <td class="px-4 py-3.5">
                <span class="px-2.5 py-1 rounded-lg bg-brand-cream text-xs font-semibold">{{ apt.payment_type }}</span>
              </td>
              <td class="px-4 py-3.5">
                <select
                  :value="apt.status"
                  @change="updateStatus(apt, $event.target.value)"
                  :class="[statusBadge[apt.status] || 'bg-slate-100', 'rounded-lg border-0 text-xs font-bold py-1.5 px-2.5 cursor-pointer']"
                >
                  <option value="pending">Pending</option>
                  <option value="confirmed">Confirmed</option>
                  <option value="completed">Completed</option>
                  <option value="cancelled">Cancelled</option>
                </select>
              </td>
              <td class="px-4 py-3.5 text-right space-x-1">
                <a
                  :href="`https://wa.me/${apt.patient_phone.replace(/^0/, '62').replace(/[^0-9]/g, '')}`"
                  target="_blank"
                  class="inline-flex p-2 rounded-lg text-emerald-600 hover:bg-emerald-50"
                  title="Hubungi WhatsApp Pasien"
                >
                  <MessageCircle class="w-4 h-4" />
                </a>
                <button
                  @click="remove(apt.id)"
                  class="inline-flex p-2 rounded-lg text-rose-600 hover:bg-rose-50"
                  title="Hapus"
                >
                  <Trash2 class="w-4 h-4" />
                </button>
              </td>
            </tr>
            <tr v-if="!appointments.length">
              <td colspan="6" class="px-4 py-10 text-center text-brand-leaf">Belum ada data janji temu.</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </AdminLayout>
</template>
