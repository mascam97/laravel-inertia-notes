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
                            <h3 class="text-lg text-gray-900">Notes</h3>
                            <p class="text-lg text-gray-600">Your notes</p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <div class="flex justify-between">
                                <input type="text" class="form-input rounded-md shadow-sm" placeholder="Search..." v-model="q">
                                <inertia-link :href="route('notes.create')" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded-md">
                                    Create
                                </inertia-link>
                            </div>
                            <hr class="my-3" />
                            <table>
                                <tr v-for="note in notes" :key="note.id">
                                    <td class="border px-4 py-2 mr-2">
                                       <h3 class="text-lg text-gray-900 font-bold">{{ note.title }}</h3>
                                       <p>{{ note.excerpt }}</p>
                                    </td>
                                    <td>
                                        <inertia-link class="bg-gray-500 hover:bg-gray-700 text-white font-bold font-bold m-1 py-2 px-4 rounded-md" :href="route('notes.show', note.id)">
                                            Show
                                        </inertia-link>
                                    </td>
                                    <td>
                                        <inertia-link class="bg-blue-500 hover:bg-blue-700 text-white font-bold font-bold m-1 py-2 px-4 rounded-md" :href="route('notes.edit', note.id)">
                                            Edit
                                        </inertia-link>
                                    </td>
                                </tr>
                                <tr v-if="notes.length === 0">
                                    <td class="border px-4 py-2">
                                       <h3 class="text-lg text-gray-900">There are not notes.</h3>
                                    </td>
                                </tr>
                            </table>
                            <!-- TODO: Add pagination-->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
    components: {
        AppLayout,
        Welcome
    },
    props: {
        notes: Array
    },
    data() {
            return {
                q: ''
            }
        },
    watch: {
        q: function (value) {
            this.$inertia.replace(this.route('notes.index', {q: value}))
        }
    }
};
</script>
