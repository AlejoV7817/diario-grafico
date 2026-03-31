<script setup>
import { computed, ref } from 'vue'
import { router, usePage } from '@inertiajs/vue3'

const page = usePage()
const user = page.props.auth.user

const props = defineProps({
  entries: Array,
  chartData: Array,
  calendarData: Array
})

/* 🔥 FIX VELA GRIS + DATOS */
const series = computed(() => [{
  data: props.chartData.map(candle => {

    // ⚪ vela neutra (0)
    if (candle.y[0] === 0 && candle.y[3] === 0) {
      return {
        ...candle,
        fillColor: '#6b7280',
        strokeColor: '#6b7280'
      }
    }

    return candle
  })
}])

const chartOptions = {
  chart: {
    type: 'candlestick',
    background: '#0f172a',
    toolbar: { show: false }
  },
  theme: { mode: 'dark' },
  xaxis: {
    type: 'category',
    labels: { style: { colors: '#94a3b8' } }
  },
  yaxis: {
    labels: { style: { colors: '#94a3b8' } }
  },
  plotOptions: {
    candlestick: {
      colors: {
        upward: '#16a34a',
        downward: '#dc2626'
      },
      wick: {
        useFillColor: true
      }
    }
  }
}

/* 🔥 MODAL DELETE */
const showModal = ref(false)
const selectedId = ref(null)

const openDelete = (id) => {
  selectedId.value = id
  showModal.value = true
}

const confirmDelete = () => {
  router.delete(`/entries/${selectedId.value}`)
  showModal.value = false
}

const logout = () => {
  router.post('/logout')
}
</script>

<template>
  <div class="min-h-screen bg-[#0b1120] text-slate-200">

    <!-- NAVBAR -->
    <div class="flex justify-between items-center px-8 py-4 border-b border-slate-800">

      <h1 class="text-lg font-semibold text-slate-300 tracking-wide">
        Diario Analítico
      </h1>

      <div class="flex items-center gap-4 text-sm">

        <template v-if="user">
          <span class="text-slate-400">{{ user.name }}</span>

          <button 
            @click="logout"
            class="px-3 py-1 rounded-md bg-red-500/10 hover:bg-red-500/20 text-red-400 transition">
            Cerrar sesión
          </button>
        </template>

        <template v-else>
          <a href="/login" class="text-slate-400 hover:text-white">
            Iniciar sesión
          </a>

          <a href="/register"
            class="bg-slate-700 px-3 py-1 rounded-md hover:bg-slate-600">
            Registrarse
          </a>
        </template>

        <a href="/entries/create"
          class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-md shadow-lg shadow-blue-500/20 transition">
          Nuevo registro
        </a>

      </div>
    </div>

    <!-- CONTENIDO -->
    <div class="p-8 space-y-8">

      <!-- GRID -->
      <div class="grid lg:grid-cols-3 gap-6">

        <!-- GRAFICA -->
        <div class="lg:col-span-2 bg-[#020617] border border-slate-800 p-6 rounded-xl shadow-lg">
          <apexchart
            type="candlestick"
            height="320"
            :options="chartOptions"
            :series="series"
          />
        </div>

        <!-- CALENDARIO -->
        <div class="bg-[#020617] border border-slate-800 p-6 rounded-xl shadow-lg">
          <div class="grid grid-cols-7 gap-2">
            <div v-for="day in calendarData"
                 :key="day.date"
                 class="w-8 h-8 rounded-sm hover:scale-110 transition"
                 :style="{ backgroundColor: day.color }">
            </div>
          </div>
        </div>

      </div>

      <!-- LISTA -->
      <div class="grid md:grid-cols-2 xl:grid-cols-3 gap-6">

        <div v-for="entry in entries"
             :key="entry.id"
             class="bg-[#020617] border border-slate-800 p-5 rounded-xl hover:border-slate-700 hover:scale-[1.02] transition">

          <!-- HEADER -->
          <div class="flex justify-between items-start mb-3">

            <h3 class="text-sm font-medium text-slate-200">
              {{ entry.title }}
            </h3>

            <!-- BOTONES PRO -->
            <div class="flex items-center gap-2 text-xs">

              <a 
                :href="`/entries/${entry.id}/edit`"
                class="flex items-center gap-1 px-2 py-1 rounded-md bg-slate-800 hover:bg-slate-700 text-slate-300 transition hover:scale-105"
              >
                ✏️ Editar
              </a>

              <button 
                @click="openDelete(entry.id)"
                class="flex items-center gap-1 px-2 py-1 rounded-md bg-red-500/10 hover:bg-red-500/20 text-red-400 transition hover:scale-105"
              >
                🗑 Eliminar
              </button>

            </div>

          </div>

          <!-- CONTENIDO -->
          <p class="text-xs text-slate-500 mb-3 line-clamp-3">
            {{ entry.content }}
          </p>

          <!-- FOOTER -->
          <div class="flex justify-between text-xs">
            <span class="text-slate-500">{{ entry.date }}</span>

            <span :class="{
              'text-green-500': entry.mood_value > 0,
              'text-red-500': entry.mood_value < 0,
              'text-slate-400': entry.mood_value === 0
            }">
              {{ entry.mood_value }}
            </span>
          </div>

        </div>

      </div>

    </div>

    <!-- MODAL DELETE -->
    <div v-if="showModal" class="fixed inset-0 bg-black/70 flex items-center justify-center z-50">

      <div class="bg-[#020617] border border-slate-800 rounded-xl p-6 w-full max-w-sm text-center">

        <h2 class="text-lg mb-4 text-slate-200">
          Confirmar eliminación
        </h2>

        <p class="text-sm text-slate-500 mb-6">
          Esta acción no se puede deshacer.
        </p>

        <div class="flex justify-center gap-4">

          <button
            @click="showModal = false"
            class="px-4 py-2 bg-slate-700 rounded hover:bg-slate-600">
            Cancelar
          </button>

          <button
            @click="confirmDelete"
            class="px-4 py-2 bg-red-600 hover:bg-red-500 rounded text-white">
            Eliminar
          </button>

        </div>

      </div>

    </div>

  </div>
</template>