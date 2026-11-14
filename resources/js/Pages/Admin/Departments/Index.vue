<script setup>
import { ref } from 'vue';
import { Head, useForm, router } from '@inertiajs/vue3';
import AdminLayout from '@/Layouts/AdminLayout.vue';
import { Building2, Plus, Pencil, Trash2, X } from '@lucide/vue';

defineProps({
  departments: { type: Array, default: () => [] },
});

const showModal = ref(false);
const editingId = ref(null);

const form = useForm({
  name: '',
  code: '',
  location: '',
  phone_ext: '',
  short_description: '',
  description: '',
  order: 0,
  is_featured: true,
  is_active: true,
  image: null,
});

const openCreate = () => {
  editingId.value = null;
  form.reset();
  form.is_featured = true;
  form.is_active = true;
  showModal.value = true;
};

const openEdit = (dept) => {
  editingId.value = dept.id;
  form.name = dept.name;
  form.code = dept.code || '';
  form.location = dept.location || '';
  form.phone_ext = dept.phone_ext || '';
  form.short_description = dept.short_description || '';
  form.description = dept.description || '';
  form.order = dept.order || 0;
  form.is_featured = !!dept.is_featured;
  form.is_active = !!dept.is_active;
  form.image = null;
  showModal.value = true;
};

const submit = () => {
  if (editingId.value) {
    form.transform((data) => ({ ...data, _method: 'PUT' })).post(route('admin.departments.update', editingId.value), {
      forceFormData: true,
      onSuccess: () => { showModal.value = false; },
    });
  } else {
    form.post(route('admin.departments.store'), {
      forceFormData: true,
      onSuccess: () => { showModal.value = false; },
    });
  }
};

const remove = (id) => {
  if (confirm('Hapus unit/poli ini? Dokter terkait juga akan terpengaruh.')) {
    router.delete(route('admin.departments.destroy', id));
  }
};
</script>

<template>
  <Head title="Kelola Unit & Poliklinik" />

  <AdminLayout>
    <div class="space-y-6">
      <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
          <h1 class="text-2xl font-extrabold text-brand-dark flex items-center gap-2">
            <Building2 class="w-6 h-6 text-brand-primary" />
            Unit Layanan & Poliklinik
          </h1>
          <p class="text-sm text-brand-leaf mt-1">Kelola daftar poliklinik, instalasi medis, dan fasilitas unggulan.</p>
        </div>
        <button
          @click="openCreate"
          class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-brand-primary hover:bg-brand-dark text-white text-sm font-bold"
        >
          <Plus class="w-4 h-4" /> Tambah Poli / Unit
        </button>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        <div
          v-for="dept in departments"
          :key="dept.id"
          class="bg-white rounded-2xl border border-brand-sand overflow-hidden shadow-sm flex flex-col justify-between"
        >
          <div>
            <img :src="dept.image || '/images/hospital/departments/cardiology.jpg'" :alt="dept.name" class="w-full h-40 object-cover" />
            <div class="p-5 space-y-2">
              <div class="flex items-center justify-between">
                <span class="px-2.5 py-0.5 rounded-md bg-brand-sand text-brand-primary text-xs font-bold">{{ dept.code }}</span>
                <span class="text-xs font-semibold text-brand-leaf">{{ dept.doctors_count }} Dokter</span>
              </div>
              <h2 class="font-bold text-base text-brand-dark">{{ dept.name }}</h2>
              <p class="text-xs text-brand-leaf line-clamp-2">{{ dept.short_description }}</p>
            </div>
          </div>
          <div class="px-5 py-3 bg-brand-cream/60 border-t border-brand-sand flex items-center justify-between">
            <span :class="[dept.is_active ? 'text-emerald-700' : 'text-rose-600', 'text-xs font-bold']">
              {{ dept.is_active ? 'Aktif' : 'Nonaktif' }}
            </span>
            <div class="flex items-center gap-1">
              <button @click="openEdit(dept)" class="p-2 rounded-lg text-brand-primary hover:bg-brand-sand/60"><Pencil class="w-4 h-4" /></button>
              <button @click="remove(dept.id)" class="p-2 rounded-lg text-rose-600 hover:bg-rose-50"><Trash2 class="w-4 h-4" /></button>
            </div>
          </div>
        </div>
      </div>

      <!-- Modal -->
      <div v-if="showModal" class="fixed inset-0 z-50 bg-brand-deep/70 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-white rounded-3xl max-w-xl w-full p-6 sm:p-8 space-y-5 max-h-[90vh] overflow-y-auto">
          <div class="flex items-center justify-between border-b border-brand-sand pb-3">
            <h3 class="text-lg font-bold text-brand-dark">{{ editingId ? 'Edit Unit / Poli' : 'Tambah Unit / Poli' }}</h3>
            <button @click="showModal = false" class="p-1.5 rounded-lg hover:bg-brand-sand/50"><X class="w-5 h-5" /></button>
          </div>

          <form @submit.prevent="submit" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
              <div class="sm:col-span-2">
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Nama Poli / Unit *</label>
                <input v-model="form.name" type="text" required class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Kode</label>
                <input v-model="form.code" type="text" placeholder="KRD" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Lokasi Ruangan</label>
                <input v-model="form.location" type="text" placeholder="Gedung Utama Lt. 2" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
              <div>
                <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Urutan Tampil</label>
                <input v-model="form.order" type="number" class="w-full rounded-xl border-brand-sand text-sm" />
              </div>
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Deskripsi Singkat</label>
              <input v-model="form.short_description" type="text" class="w-full rounded-xl border-brand-sand text-sm" />
            </div>

            <div>
              <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Foto Unit / Poli</label>
              <input type="file" accept="image/*" @change="form.image = $event.target.files[0]" class="w-full text-xs" />
            </div>

            <div class="flex items-center gap-6">
              <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" v-model="form.is_active" class="rounded border-brand-sand text-brand-primary" />
                <span>Aktif</span>
              </label>
              <label class="inline-flex items-center gap-2 text-sm">
                <input type="checkbox" v-model="form.is_featured" class="rounded border-brand-sand text-brand-primary" />
                <span>Tampilkan di Beranda</span>
              </label>
            </div>

            <div class="flex justify-end gap-2 pt-3 border-t border-brand-sand">
              <button type="button" @click="showModal = false" class="px-4 py-2 rounded-xl border border-brand-sand text-sm font-semibold">Batal</button>
              <button type="submit" :disabled="form.processing" class="px-6 py-2 rounded-xl bg-brand-primary text-white text-sm font-bold">Simpan</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </AdminLayout>
</template>

