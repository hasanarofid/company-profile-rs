<script setup>
import { computed } from 'vue';
import { Head, Link, useForm, usePage } from '@inertiajs/vue3';
import { ShieldPlus, Lock, Mail, ArrowLeft } from '@lucide/vue';

defineProps({
  canResetPassword: Boolean,
  status: String,
});

const page = usePage();
const settings = computed(() => page.props.siteSettings || {});

const form = useForm({
  email: 'admin@rsmedika.id',
  password: 'password',
  remember: false,
});

const submit = () => {
  form.post(route('login'), {
    onFinish: () => form.reset('password'),
  });
};
</script>

<template>
  <Head title="Login Admin Rumah Sakit" />

  <div class="min-h-screen bg-brand-cream flex flex-col justify-center items-center p-4">
    <div class="w-full max-w-md bg-white rounded-3xl border border-brand-sand shadow-fashion p-8 space-y-6">
      <div class="text-center space-y-2">
        <div class="w-14 h-14 rounded-2xl bg-brand-primary text-white flex items-center justify-center mx-auto shadow-sm">
          <ShieldPlus class="w-8 h-8" />
        </div>
        <h1 class="text-2xl font-extrabold text-brand-dark">{{ settings.site_name || 'RSU Medika Nusantara' }}</h1>
        <p class="text-xs text-brand-leaf">Portal Super Admin & Manajemen Konten Rumah Sakit</p>
      </div>

      <div v-if="status" class="p-3 rounded-xl bg-emerald-50 text-emerald-700 text-xs font-medium">
        {{ status }}
      </div>

      <form @submit.prevent="submit" class="space-y-4">
        <div>
          <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Email Admin</label>
          <div class="relative">
            <Mail class="w-4 h-4 text-brand-leaf absolute left-3.5 top-1/2 -translate-y-1/2" />
            <input
              v-model="form.email"
              type="email"
              required
              autofocus
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border-brand-sand bg-brand-cream/40 text-sm focus:border-brand-primary focus:ring-brand-primary"
            />
          </div>
          <p v-if="form.errors.email" class="text-xs text-rose-600 mt-1">{{ form.errors.email }}</p>
        </div>

        <div>
          <label class="block text-xs font-bold uppercase text-brand-leaf mb-1">Password</label>
          <div class="relative">
            <Lock class="w-4 h-4 text-brand-leaf absolute left-3.5 top-1/2 -translate-y-1/2" />
            <input
              v-model="form.password"
              type="password"
              required
              class="w-full pl-10 pr-4 py-2.5 rounded-xl border-brand-sand bg-brand-cream/40 text-sm focus:border-brand-primary focus:ring-brand-primary"
            />
          </div>
          <p v-if="form.errors.password" class="text-xs text-rose-600 mt-1">{{ form.errors.password }}</p>
        </div>

        <label class="inline-flex items-center gap-2 text-xs text-brand-leaf">
          <input type="checkbox" v-model="form.remember" class="rounded border-brand-sand text-brand-primary" />
          <span>Ingat sesi saya</span>
        </label>

        <button
          type="submit"
          :disabled="form.processing"
          class="w-full py-3 rounded-xl bg-brand-primary hover:bg-brand-dark text-white font-bold text-sm shadow-sm transition-colors disabled:opacity-50"
        >
          {{ form.processing ? 'Memverifikasi...' : 'Masuk ke Panel Admin' }}
        </button>
      </form>

      <div class="pt-4 border-t border-brand-sand text-center">
        <Link href="/" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-primary hover:text-brand-dark">
          <ArrowLeft class="w-3.5 h-3.5" /> Kembali ke Website Utama
        </Link>
      </div>
    </div>
  </div>
</template>
