<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
<GuestLayout>
    <Head title="Registro" />

    <div class="bg-[#020617] border border-slate-800 rounded-2xl p-8 shadow-2xl">

        <!-- HEADER -->
        <div class="mb-6 text-center">
            <h1 class="text-xl font-semibold text-slate-200">
                Crear cuenta
            </h1>
            <p class="text-sm text-slate-500 mt-1">
                Registra tu acceso al sistema
            </p>
        </div>

        <!-- FORM -->
        <form @submit.prevent="submit" class="space-y-5">

            <!-- NAME -->
            <div>
                <InputLabel for="name" value="Nombre" class="text-slate-400 text-xs" />

                <TextInput
                    id="name"
                    type="text"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Tu nombre"
                    class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-white placeholder-slate-500 rounded-lg px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                />

                <InputError class="mt-1 text-red-500 text-xs" :message="form.errors.name" />
            </div>

            <!-- EMAIL -->
            <div>
                <InputLabel for="email" value="Correo electrónico" class="text-slate-400 text-xs" />

                <TextInput
                    id="email"
                    type="email"
                    v-model="form.email"
                    required
                    autocomplete="username"
                    placeholder="correo@ejemplo.com"
                    class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-white placeholder-slate-500 rounded-lg px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                />

                <InputError class="mt-1 text-red-500 text-xs" :message="form.errors.email" />
            </div>

            <!-- PASSWORD -->
            <div>
                <InputLabel for="password" value="Contraseña" class="text-slate-400 text-xs" />

                <TextInput
                    id="password"
                    type="password"
                    v-model="form.password"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-white placeholder-slate-500 rounded-lg px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                />

                <InputError class="mt-1 text-red-500 text-xs" :message="form.errors.password" />
            </div>

            <!-- CONFIRM PASSWORD -->
            <div>
                <InputLabel
                    for="password_confirmation"
                    value="Confirmar contraseña"
                    class="text-slate-400 text-xs"
                />

                <TextInput
                    id="password_confirmation"
                    type="password"
                    v-model="form.password_confirmation"
                    required
                    autocomplete="new-password"
                    placeholder="••••••••"
                    class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-white placeholder-slate-500 rounded-lg px-4 py-3
                           focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition"
                />

                <InputError
                    class="mt-1 text-red-500 text-xs"
                    :message="form.errors.password_confirmation"
                />
            </div>

            <!-- FOOTER -->
            <div class="flex items-center justify-between pt-4">

                <Link
                    :href="route('login')"
                    class="text-sm text-slate-400 hover:text-white transition"
                >
                    ¿Ya tienes cuenta?
                </Link>

                <PrimaryButton
                    class="bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-lg shadow-lg shadow-blue-500/20 transition"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Crear cuenta
                </PrimaryButton>

            </div>

        </form>

    </div>

</GuestLayout>
</template>