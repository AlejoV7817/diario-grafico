<script setup>
import { ref } from 'vue'
import { router } from '@inertiajs/vue3'

const props = defineProps({
  entry: Object
})

const form = ref({ ...props.entry })

const submit = () => {
  router.put(`/entries/${props.entry.id}`, form.value)
}
</script>

<template>
  <div class="min-h-screen bg-gray-900 text-white flex items-center justify-center p-6">

    <div class="bg-gray-800 p-6 rounded-xl w-full max-w-lg">

      <h1 class="text-xl font-bold mb-4">Editar día</h1>

      <form @submit.prevent="submit" class="space-y-4">

        <input type="date" v-model="form.date" class="w-full p-2 bg-gray-700 rounded" />

        <input type="text" v-model="form.title" class="w-full p-2 bg-gray-700 rounded" />

        <textarea v-model="form.content" class="w-full p-2 bg-gray-700 rounded"></textarea>

        <input type="range" min="-10" max="10" v-model="form.mood_value" class="w-full" />

        <div class="text-center text-lg">{{ form.mood_value }}</div>

        <button class="bg-blue-600 px-4 py-2 rounded w-full">
          Actualizar
        </button>

      </form>

    </div>

  </div>
</template>