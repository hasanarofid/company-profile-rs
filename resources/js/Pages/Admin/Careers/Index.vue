<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Briefcase, Plus, Pencil, Trash2, X, Download } from '@lucide/vue';

defineProps({
  careers: { type: Array, default: () => [] },
  applications: { type: Array, default: () => [] },
});

const tab = ref('jobs');
const showModal = ref(false);
const editingId = ref(null);

const form = useForm({
  title: '',
  category: 'Medis',
  employment_type: 'Full-Time',
  location: 'RSU Medika Nusantara — Jakarta Selatan',
  department_name: '',
  description: '',
  requirementsText: '',
  benefitsText: '',
  deadline: '',
  is_active: true,
});

const openCreate = () => {
  editingId.value = null;
  form.reset();
  form.is_active = true;
  showModal.value = true;
};

const openEdit = (job) => {
  editingId.value = job.id;
  form.title = job.title;
  form.category = job.category;
  form.employment_type = job.employment_type;
  form.location = job.location;
  form.department_name = job.department_name || '';
  form.description = job.description;
  form.requirementsText = (job.requirements || []).join('\n');
  form.benefitsText = (job.benefits || []).join('\n');
  form.deadline = job.deadline || '';
  form.is_active = !!job.is_active;
  showModal.value = true;
};

const submit = () => {
  const payload = {
    ...form.data(),
    requirements: form.requirementsText.split('\n').map((s) => s.trim()).filter(Boolean),
    benefits: form.benefitsText.split('\n').map((s) => s.trim()).filter(Boolean),
  };

  if (editingId.value) {
    router.put(route('admin.careers.update', editingId.value), payload, {
      onSuccess: () => { showModal.value = false; },
    });
  } else {
    router.post(route('admin.careers.store'), payload, {
      onSuccess: () => { showModal.value = false; },
    });
  }
};

const removeJob = (id) => {
  if (confirm('Hapus lowongan ini?')) {
    router.delete(route('admin.careers.destroy', id));
  }
};

const updateAppStatus = (app, status) => {
  router.patch(route('admin.careers.applications.status', app.id), { status }, { preserveScroll: true });
};
</script>

<template>
  <Head title="Kelola Karir & Pelamar" />

  <AdminLayout>
    <div class="space-y-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2">
            <Briefcase class="w-6 h-6 text-brand-primary" />
            Portal Karir & Data Pelamar
          </h1>
          <p class="text-sm text-brand-leaf mt-1">Kelola lowongan kerja medis/non-medis dan berkas lamaran yang masuk.</p>
        </div>
        <button @click="openCreate" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold">
          <Plus class="w-4 h-4" /> Buka Lowongan Baru
        </button>
      </div>

      <!-- Tabs -->
      <div class="flex gap-2 border-b border-brand-sand">
        <button
          @click="tab = 'jobs'"
          :class="[tab === 'jobs' ? 'border-brand-primary text-brand-primary font-bold' : 'border-transparent text-brand-leaf', 'px-5 py-3 border-b-2 text-sm']"
        >
          Daftar Lowongan ({{ careers.length }})
        </button>
        <button
          @click="tab = 'applications'"
          :class="[tab === 'applications' ? 'border-brand-primary text-brand-primary font-bold' : 'border-transparent text-brand-leaf', 'px-5 py-3 border-b-2 text-sm']"
        >
          Pelamar Masuk ({{ applications.length }})
        </button>
      </div>

      <!-- Jobs Tab -->
      <div v-if="tab === 'jobs'" class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div v-for="job in careers" :key="job.id" class="bg-white p-6 rounded-2xl border border-brand-sand shadow-sm flex flex-col justify-between space-y-4">
          <div class="space-y-2">
            <div class="flex justify-between">
              <span class="px-2.5 py-0.5 rounded-md bg-brand-sand text-brand-primary text-xs font-bold">{{ job.category }}</span>
              <span class="text-xs font-semibold text-brand-leaf">{{ job.applications_count }} Pelamar</span>
            </div>
            <h2 class="font-bold text-lg text-brand-dark">{{ job.title }}</h2>
            <p class="text-xs text-brand-leaf">{{ job.department_name }} &bull; {{ job.employment_type }}</p>
          </div>
          <div class="pt-3 border-t border-brand-sand flex justify-between items-center">
            <span :class="[job.is_active ? 'text-emerald-700' : 'text-rose-600', 'text-xs font-bold']">{{ job.is_active ? 'Dibuka' : 'Ditutup' }}</span>
            <div class="flex gap-1">
              <button @click="openEdit(job)" class="p-2 rounded-lg text-brand-primary hover:bg-brand-sand/50"><Pencil class="w-4 h-4" /></button>
              <button @click="removeJob(job.id)" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Applications Tab -->
      <div v-else class="bg-white rounded-2xl border border-brand-sand shadow-sm overflow-x-auto">
        <table class="w-full text-sm text-left">
          <thead class="bg-brand-sand/50 text-xs uppercase font-bold text-brand-dark">
            <tr>
              <th class="px-4 py-3.5">Pelamar</th>
              <th class="px-4 py-3.5">Posisi Dilamar</th>
              <th class="px-4 py-3.5">Pendidikan</th>
              <th class="px-4 py-3.5">Berkas CV</th>
              <th class="px-4 py-3.5">Status</th>
            </tr>
          </thead>
          <tbody class="divide-y divide-brand-sand">
            <tr v-for="app in applications" :key="app.id">
              <td class="px-4 py-3.5">
                <p class="font-bold text-brand-dark">{{ app.applicant_name }}</p>
                <p class="text-xs text-brand-leaf">{{ app.email }} &bull; {{ app.phone }}</p>
              </td>
              <td class="px-4 py-3.5 font-semibold">{{ app.career?.title }}</td>
              <td class="px-4 py-3.5 text-xs text-brand-leaf">{{ app.education }}</td>
              <td class="px-4 py-3.5">
                <a :href="app.cv_path" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-brand-sand text-brand-primary text-xs font-bold">
                  <Download class="w-3.5 h-3.5" /> Unduh CV
                </a>
              </td>
              <td class="px-4 py-3.5">
                <select :value="app.status" @change="updateAppStatus(app, $event.target.value)" class="rounded-lg border-brand-sand text-xs font-bold py-1.5 px-2.5">
                  <option value="submitted">Submitted</option>
                  <option value="reviewed">Reviewed</option>
                  <option value="interview">Interview</option>
                  <option value="accepted">Accepted</option>
                  <option value="rejected">Rejected</option>
                </select>
              </td>
            </tr>
            <tr v-if="!applications.length">
              <td colspan="5" class="px-4 py-10 text-center text-brand-leaf">Belum ada pelamar kerja masuk.</td>
            </tr>
          </tbody>
        </table>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 bg-brand-deep/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-4 max-h-[90vh] overflow-y-auto">
          <div class="flex items-center justify-between border-b border-brand-sand pb-3">
            <h3 class="text-lg font-bold text-brand-dark">{{ editingId ? 'Edit Lowongan' : 'Tambah Lowongan Kerja' }}</h3>
            <button @click="showModal = false"><X class="w-5 h-5" /></button>
          </div>
          <form @submit.prevent="submit" class="space-y-4">
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Judul Posisi *</label>
              <input v-model="form.title" type="text" required class="w-full rounded-xl border-brand-sand text-sm" />
            </div>
            <div class="grid grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Kategori</label>
                <select v-model="form.category" class="w-full rounded-xl border-brand-sand text-sm">
                  <option value="Medis">Medis</option>
                  <option value="Keperawatan">Keperawatan</option>
                  <option value="Penunjang Medis">Penunjang Medis</option>
                  <option value="Non-Medis & IT">Non-Medis & IT</option>
                </select>
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Tipe</label>
                <select v-model="form.employment_type" class="w-full rounded-xl border-brand-sand text-sm">
                  <option value="Full-Time">Full-Time</option>
                  <option value="Part-Time">Part-Time</option>
                  <option value="Kontrak">Kontrak</option>
                </select>
              </div>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Deskripsi *</label>
              <textarea v-model="form.description" rows="2" required class="w-full rounded-xl border-brand-sand text-sm"></textarea>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Persyaratan (1 baris per poin)</label>
              <textarea v-model="form.requirementsText" rows="3" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
            </div>
            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Benefit (1 baris per poin)</label>
              <textarea v-model="form.benefitsText" rows="2" class="w-full rounded-xl border-brand-sand text-sm"></textarea>
            </div>
            <label class="inline-flex items-center gap-2 text-sm"><input type="checkbox" v-model="form.is_active" class="rounded text-brand-primary" /> Lowongan Aktif</label>
            <div class="flex justify-end gap-2 pt-3 border-t border-brand-sand">
              <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl border border-brand-sand text-sm">Batal</button>
              <button type="submit" class="px-6 py-2 rounded-xl bg-brand-primary text-white text-sm font-bold">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>
