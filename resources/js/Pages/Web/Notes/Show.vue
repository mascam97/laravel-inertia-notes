<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Notes
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="md:grid md:grid-cols-3 md:gap-6">
                    <div class="md:col-span-1">
                        <div class="px-4 sm:px0">
                            <h3 class="text-lg text-gray-900">Note detail</h3>
                            <p class="text-lg text-gray-600">
                                Information about the note
                                <!-- TODO: show more information about the note -->
                            </p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <h3 class="text-lg text-gray-900">{{ note.title }}</h3>
                            <p class="">{{ note.content }}</p>
                            <hr class="my-6" />
                            <inertia-link class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-md" :href="route('notes.index')">
                                Back
                            </inertia-link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from '@/Layouts/WebAppLayout';

export default {
    components: {
        AppLayout,
    },
    props: {
        note: Object
    }
};
</script>
