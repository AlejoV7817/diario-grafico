<script setup>
import { useForm, usePage, router } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user

const form = useForm({
  date: '',
  title: '',
  content: '',
  mood_value: 0
})

const submit = () => {
  form.post('/entries')
}

const logout = () => {
  router.post('/logout')
}
</script>

<template>
  <div class="min-h-screen bg-[#0b1120] text-slate-200">

    <!-- 🔥 NAVBAR AGREGADO -->
    <div class="flex justify-between items-center px-8 py-4 border-b border-slate-800">

      <h1 class="text-lg font-semibold text-slate-300">
        Diario Analítico
      </h1>

      <div class="flex items-center gap-4 text-sm">

        <template v-if="user">
          <span class="text-slate-400">
            {{ user.name }}
          </span>

          <button @click="logout" class="text-red-400 hover:text-red-300">
            Cerrar sesión
          </button>
        </template>

        <template v-else>
          <a href="/login" class="text-slate-400 hover:text-white">
            Iniciar sesión
          </a>

          <a href="/register" class="bg-slate-700 px-3 py-1 rounded">
            Registrarse
          </a>
        </template>

      </div>
    </div>

    <!-- 🔽 TODO TU FORM ORIGINAL (SIN CAMBIOS) -->
    <div class="px-6 py-10">

      <div class="max-w-4xl mx-auto bg-[#020617] border border-slate-800 rounded-xl p-8">

        <!-- HEADER -->
        <div class="mb-8">
          <h1 class="text-xl font-semibold text-slate-300">
            Nuevo registro
          </h1>
          <p class="text-sm text-slate-500 mt-1">
            Registra tu estado emocional del día
          </p>
        </div>

        <!-- FORM -->
        <form @submit.prevent="submit" class="space-y-6">

          <!-- GRID -->
          <div class="grid md:grid-cols-2 gap-6">

            <!-- FECHA -->
            <div>
              <label class="text-sm text-slate-400 mb-2 block">
                Fecha
              </label>

              <input 
                type="date"
                v-model="form.date"
                class="w-full bg-[#0b1120] border border-slate-700 rounded-md px-4 py-3"
              />

              <p v-if="form.errors.date" class="text-red-500 text-xs mt-1">
                {{ form.errors.date }}
              </p>
            </div>

            <!-- TITULO -->
            <div>
              <label class="text-sm text-slate-400 mb-2 block">
                Título
              </label>

              <input 
                type="text"
                v-model="form.title"
                class="w-full bg-[#0b1120] border border-slate-700 rounded-md px-4 py-3"
              />

              <p v-if="form.errors.title" class="text-red-500 text-xs mt-1">
                {{ form.errors.title }}
              </p>
            </div>

          </div>

          <!-- CONTENIDO FULL -->
          <div>
            <label class="text-sm text-slate-400 mb-2 block">
              Descripción
            </label>

            <textarea 
              v-model="form.content"
              rows="5"
              class="w-full bg-[#0b1120] border border-slate-700 rounded-md px-4 py-3"
            ></textarea>

            <p v-if="form.errors.content" class="text-red-500 text-xs mt-1">
              {{ form.errors.content }}
            </p>
          </div>

          <!-- MOOD -->
          <div class="mt-6">
            <label class="text-sm text-slate-400 mb-3 block">
              Estado emocional
            </label>

            <input 
              type="range"
              min="-10"
              max="10"
              v-model="form.mood_value"
              class="w-full"
            />

            <!-- VALOR GRANDE -->
            <div class="text-center mt-4 text-2xl font-bold"
                 :class="{
                   'text-green-500': form.mood_value > 0,
                   'text-red-500': form.mood_value < 0,
                   'text-slate-400': form.mood_value === 0
                 }">
              {{ form.mood_value }}
            </div>

            <!-- BARRA -->
            <div class="w-full h-3 mt-4 rounded-full bg-gradient-to-r from-red-600 via-gray-500 to-green-600"></div>

            <div class="flex justify-between text-xs mt-2 text-slate-500">
              <span>-10</span>
              <span>0</span>
              <span>10</span>
            </div>
          </div>

          <!-- BOTONES -->
          <div class="flex justify-between items-center pt-6">

            <a href="/entries" class="text-sm text-slate-400 hover:text-white">
              Cancelar
            </a>

            <button 
              type="submit"
              :disabled="form.processing"
              class="bg-slate-700 hover:bg-slate-600 px-6 py-3 rounded-md text-sm transition disabled:opacity-50"
            >
              Guardar registro
            </button>

          </div>

        </form>

      </div>

    </div>

  </div>
</template>