
<script>
 export default {
    props: {
        lastCalculations:Array
    }
 }
</script>


<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
  <div>
    <Head title="Last 10 Calculations" />

    <AuthenticatedLayout>
      <template #header>
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Calculator</h2>
      </template>

      <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
          <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900">
            <div class="text-center">
              <h1 class="text-2xl font-bold mb-4">Last 10 Calculations</h1>

              <ul class="list-disc list-inside text-left">
                <li v-for="calculation in lastCalculations" :key="calculation.id">
                  {{ calculation.expression }} = {{ calculation.result }}
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </AuthenticatedLayout>
  </div>
</template>