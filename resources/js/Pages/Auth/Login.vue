<script setup>
import Checkbox from '@/Components/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
<GuestLayout>
    <Head title="Login" />

    <!-- 🔥 FONDO -->
    <div class="min-h-screen flex items-center justify-center bg-[#0b1120] px-4">

        <!-- CARD -->
        <div class="w-full max-w-md bg-[#020617] border border-slate-800 rounded-2xl p-8 shadow-2xl">

            <!-- HEADER -->
            <div class="text-center mb-6">
                <h1 class="text-xl font-semibold text-slate-200">
                    Diario Analítico
                </h1>
                <p class="text-sm text-slate-500 mt-1">
                    Accede a tu cuenta
                </p>
            </div>

            <!-- STATUS -->
            <div v-if="status" class="mb-4 text-sm text-green-400 text-center">
                {{ status }}
            </div>

            <!-- FORM -->
            <form @submit.prevent="submit" class="space-y-5">

                <!-- EMAIL -->
                <div>
                    <InputLabel for="email" value="Correo electrónico" class="text-slate-400 text-xs" />

                    <TextInput
                        id="email"
                        type="email"
                        v-model="form.email"
                        required
                        autofocus
                        autocomplete="username"
                        class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-slate-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
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
                        autocomplete="current-password"
                        class="mt-1 block w-full bg-[#0b1120] border border-slate-700 text-slate-200 rounded-lg focus:border-blue-500 focus:ring-blue-500"
                    />

                    <InputError class="mt-1 text-red-500 text-xs" :message="form.errors.password" />
                </div>

                <!-- REMEMBER -->
                <div class="flex items-center justify-between text-xs text-slate-400">

                    <label class="flex items-center gap-2">
                        <Checkbox name="remember" v-model:checked="form.remember" />
                        Recordarme
                    </label>

                    <Link
                        v-if="canResetPassword"
                        :href="route('password.request')"
                        class="hover:text-white transition"
                    >
                        ¿Olvidaste tu contraseña?
                    </Link>

                </div>

                <!-- BUTTON -->
                <PrimaryButton
                    class="w-full justify-center bg-blue-600 hover:bg-blue-500 transition shadow-lg shadow-blue-500/20"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing"
                >
                    Iniciar sesión
                </PrimaryButton>

            </form>

            <!-- REGISTER -->
            <div class="text-center mt-6 text-xs text-slate-500">
                ¿No tienes cuenta?
                <Link href="/register" class="text-blue-400 hover:text-blue-300 ml-1">
                    Crear cuenta
                </Link>
            </div>

        </div>

    </div>
</GuestLayout>
</template>