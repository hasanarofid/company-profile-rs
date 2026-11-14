<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Stethoscope, Plus, Pencil, Trash2, X, Clock } from '@lucide/vue';

defineProps({
  doctors: { type: Array, default: () => [] },
  departments: { type: Array, default: () => [] },
});

const showModal = ref(false);
const editingId = ref(null);
const days = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];

const form = useForm({
  department_id: '',
  name: '',
  specialization: '',
  sub_specialization: '',
  sip_number: '',
  education: '',
  experience_years: 5,
  bio: '',
  is_featured: true,
  is_active: true,
  photo: null,
  schedules: [{ day_of_week: 'Senin', start_time: '08:00', end_time: '12:00', room: '' }],
});

const openCreate = () => {
  editingId.value = null;
  form.reset();
  form.schedules = [{ day_of_week: 'Senin', start_time: '08:00', end_time: '12:00', room: '' }];
  showModal.value = true;
};

const openEdit = (doc) => {
  editingId.value = doc.id;
  form.department_id = doc.department_id;
  form.name = doc.name;
  form.specialization = doc.specialization;
  form.sub_specialization = doc.sub_specialization || '';
  form.sip_number = doc.sip_number || '';
  form.education = doc.education || '';
  form.experience_years = doc.experience_years || 5;
  form.bio = doc.bio || '';
  form.is_featured = !!doc.is_featured;
  form.is_active = !!doc.is_active;
  form.photo = null;
  form.schedules = doc.schedules?.length
    ? doc.schedules.map((s) => ({
        day_of_week: s.day_of_week,
        start_time: s.start_time,
        end_time: s.end_time,
        room: s.room || '',
      }))
    : [{ day_of_week: 'Senin', start_time: '08:00', end_time: '12:00', room: '' }];
  showModal.value = true;
};

const addSchedule = () => {
  form.schedules.push({ day_of_week: 'Selasa', start_time: '09:00', end_time: '13:00', room: '' });
};

const removeSchedule = (idx) => {
  form.schedules.splice(idx, 1);
};

const submit = () => {
  if (editingId.value) {
    form.transform((data) => ({ ...data, _method: 'PUT' })).post(route('admin.doctors.update', editingId.value), {
      forceFormData: true,
      onSuccess: () => { showModal.value = false; },
    });
  } else {
    form.post(route('admin.doctors.store'), {
      forceFormData: true,
      onSuccess: () => { showModal.value = false; },
    });
  }
};

const remove = (id) => {
  if (confirm('Hapus data dokter ini?')) {
    router.delete(route('admin.doctors.destroy', id));
  }
};
</script>

<template>
  <Head title="Kelola Dokter & Jadwal Praktik" />

  <AdminLayout>
    <div class="space-y-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2">
            <Stethoscope class="w-6 h-6 text-brand-primary" />
            Direktori Dokter & Jadwal Praktik
          </h1>
          <p class="text-sm text-brand-leaf mt-1">Tambah atau perbarui foto dokter, spesialisasi, dan jadwal praktik mingguan.</p>
        </div>
        <button @click="openCreate" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold">
          <Plus class="w-4 h-4" /> Tambah Dokter
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div v-for="doc in doctors" :key="doc.id" class="bg-white rounded-2xl border border-brand-sand p-5 shadow-sm flex flex-col justify-between space-y-4">
          <div class="flex gap-4">
            <img :src="doc.photo || '/images/hospital/doctors/doctor-1.jpg'" :alt="doc.name" class="w-20 h-20 rounded-2xl object-cover object-top shrink-0 border border-brand-sand" />
            <div>
              <span class="px-2 py-0.5 rounded-md bg-brand-sand text-brand-primary text-[11px] font-bold">{{ doc.department?.name }}</span>
              <h2 class="font-bold text-sm text-brand-dark mt-1">{{ doc.name }}</h2>
              <p class="text-xs text-brand-leaf">{{ doc.specialization }}</p>
            </div>
          </div>

          <div class="space-y-1">
            <p class="text-[11px] font-bold uppercase text-brand-leaf flex items-center gap-1"><Clock class="w-3 h-3" /> Jadwal ({{ doc.schedules?.length || 0 }})</p>
            <div v-for="sch in doc.schedules?.slice(0, 3)" :key="sch.id" class="text-xs flex justify-between bg-brand-cream px-2.5 py-1 rounded-lg">
              <span class="font-semibold">{{ sch.day_of_week }}</span>
              <span>{{ sch.start_time }} - {{ sch.end_time }}</span>
            </div>
          </div>

          <div class="pt-3 border-t border-brand-sand flex items-center justify-between">
            <span :class="[doc.is_active ? 'text-emerald-700' : 'text-rose-600', 'text-xs font-bold']">{{ doc.is_active ? 'Aktif' : 'Nonaktif' }}</span>
            <div class="flex gap-1">
              <button @click="openEdit(doc)" class="p-2 rounded-lg text-brand-primary hover:bg-brand-sand/50"><Pencil class="w-4 h-4" /></button>
              <button @click="remove(doc.id)" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 bg-brand-deep/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-2xl w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto">
          <div class="flex items-center justify-between border-b border-brand-sand pb-3">
            <h3 class="text-lg font-bold text-brand-dark">{{ editingId ? 'Edit Dokter & Jadwal' : 'Tambah Dokter Baru' }}</h3>
            <button @click="showModal = false" class="p-1.5 rounded-lg hover:bg-brand-sand/50"><X class="w-5 h-5" /></button>
          </div>

          <form @submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Poliklinik *</label>
                <select v-model="form.department_id" required class="w-full rounded-xl border-brand-sand text-sm">
                  <option value="">-- Pilih Poli --</option>
                  <option v-for="dept in departments" :key="dept.id" :value="dept.id">{{ dept.name }}</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nama Lengkap & Gelar *</label>
                <input v-model="form.name" type="text" required placeholder="dr. Hendra Wijaya, Sp.JP" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Spesialisasi *</label>
                <input v-model="form.specialization" type="text" required class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Pendidikan</label>
                <input v-model="form.education" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nomor SIP</label>
                <input v-model="form.sip_number" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Foto Dokter</label>
                <input type="file" accept="image/*" @change="form.photo = $event.target.files[0]" class="w-full text-xs" />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Bio Singkat</label>
              <textarea v-model="form.bio" rows="2" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
            </div>

            <!-- Jadwal Praktik -->
            <div class="space-y-2 border-t border-brand-sand pt-4">
              <div class="flex items-center justify-between">
                <label class="text-xs font-bold uppercase text-brand-dark">Jadwal Praktik</label>
                <button type="button" @click="addSchedule" class="text-xs font-bold text-brand-primary hover:underline">+ Tambah Hari</button>
              </div>
              <div v-for="(sch, idx) in form.schedules" :key="idx" class="grid grid-cols-12 gap-2 items-center">
                <select v-model="sch.day_of_week" class="col-span-3 rounded-lg border-brand-sand text-xs">
                  <option v-for="d in days" :key="d" :value="d">{{ d }}</option>
                </select>
                <input v-model="sch.start_time" type="text" placeholder="08:00" class="col-span-2 rounded-lg border-brand-sand text-xs" />
                <input v-model="sch.end_time" type="text" placeholder="12:00" class="col-span-2 rounded-lg border-brand-sand text-xs" />
                <input v-model="sch.room" type="text" placeholder="Ruang Poli" class="col-span-4 rounded-lg border-brand-sand text-xs" />
                <button type="button" @click="removeSchedule(idx)" class="col-span-1 text-rose-600 flex justify-center"><Trash2 class="w-4 h-4" /></button>
              </div>
            </div>

            <div class="flex items-center gap-6">
              <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" v-model="form.is_active" class="rounded text-brand-primary" /> Aktif</label>
              <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" v-model="form.is_featured" class="rounded text-brand-primary" /> Tampil di Beranda</label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-brand-sand">
              <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl border border-brand-sand text-sm font-semibold">Batal</button>
              <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-xl bg-brand-primary text-white text-sm font-bold">Simpan Dokter</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
