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
                            <h3 class="text-lg text-gray-900">Edit note</h3>
                            <p class="text-lg text-gray-600">
                                Update any data
                            </p>
                        </div>
                    </div>
                    <div class="md:col-span-2 mt-5 md:mt-0">
                        <div class="shadow bg-white md:rounded-md p-4">
                            <form @submit.prevent="submit">
                                <label class="block font-medium text-sm text-gray-700">
                                    Title
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.title"
                                ></textarea>
                                <label class="block font-medium text-sm text-gray-700">
                                    Content
                                </label>
                                <textarea 
                                    class="form-input w-full rounded-md shadow-sm"
                                    v-model="form.content"
                                    rows="8"
                                ></textarea>
                                <button 
                                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-md"
                                >Editar</button>
                            </form>

                            <hr class="my-6">

                            <a href="#" @click.prevent="destroy">
                                Delete note
                            </a>

                            <hr class="my-6">

                            <inertia-link :href="route('notes.index', note.id)">
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
import AppLayout from "@/Layouts/AppLayout";
import Welcome from "@/Jetstream/Welcome";

export default {
    components: {
        AppLayout,
        Welcome
    },
    props: {
        note: Object
    },
    data() {
        return {
            form: {
                title: this.note.title,
                content: this.note.content
            }
        }
    },
    methods: {
            submit() {
                this.$inertia.put(this.route('notes.update', this.note.id), this.form)
            },
            destroy() {
                if (confirm('Are you sure to delete this note?')) {
                    this.$inertia.delete(this.route('notes.destroy', this.note.id))
                }
            }
        }
};
</script>
