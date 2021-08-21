<template>
    <div>
        <div class="relative p-5 bg-white shadow-sm">
            <p class="absolute left-2 top-2 text-xs font-semibold uppercase tracking-wider bg-green-400 text-white rounded-full px-2 py-1 leading-none">{{ question.subject.name }}</p>
            <div class="flex mt-3 mb-2">
                <span class="font-bold">{{ serial }}.</span>
                <h3 class="ml-4" v-html="question.question"></h3>
            </div>
            <div class="pl-8 space-y-2">
                <div class="flex items-center">
                    <input :checked="question.answer == 'a'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4" v-html="question.options['a']"></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'b'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4" v-html="question.options['b']"></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'c'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4" v-html="question.options['c']"></div>
                </div>
                <div class="flex items-center">
                    <input :checked="question.answer == 'd'" disabled type="radio" class="form-radio h-4 w-4 text-indigo-600 transition duration-150 ease-in-out">
                    <div class="ml-4" v-html="question.options['d']"></div>
                </div>
            </div>
            <div v-if="examStatus === 'pending'" class="absolute right-0 top-0 mt-4 mr-3">
                <inertia-link :href="route('admin.questions.edit', [examCode, question.id])" class="inline-flex items-center px-2 py-1 bg-gray-800 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-gray-600 focus:outline-none">
                    <svg class="h-5 w-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </inertia-link>
                <button @click.prevent="deleteQuestion(route('admin.questions.destroy', question.id))" class="inline-flex items-center ml-3 px-2 py-1 bg-red-700 text-white text-xs font-bold tracking-widest uppercase rounded hover:bg-red-500 focus:outline-none">
                    <svg class="h-5 w-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            examCode: String,
            examStatus: String,
            question: Object,
            serial: Number
        },

        methods: {
            deleteQuestion(url) {
                this.$inertia.delete(url, {
                    preserveScroll: true,
                    onBefore: () => confirm('Are you sure you want to delete?'),
                });
            }
        }
    }
</script>
