<template>
    <student-layout>
        <div class="py-8">
            <div class="sm:px-6 lg:px-8">
                <div class="max-w-xl mx-auto">
                    <h2 class="font-bold uppercase tracking-widest text-center">Details Result</h2>
                    <div class="flex flex-col justify-center items-center mt-6 border-2 border-gray-700 px-5 py-8">
                        <p class="font-bold text-xl">{{ result.exam.category }}: {{ result.exam.name }}</p>
                        <p>Total Question: {{ result.total_question }}</p>
                        <p>Correct Answer: {{ result.correct_answer }}</p>
                        <p>Wrong Answer: {{ result.wrong_answer }}</p>
                        <p v-if="result.negative_mark">Negative Mark: - {{ result.negative_mark }}</p>
                        <p>Total Mark: {{ result.total_mark }}</p>
                        <p v-if="result.position">Position: {{ result.position }}</p>
                    </div>

                </div>

            
                <div class="max-w-3xl mx-auto mt-12">
                    <div class="mb-5" v-for="(question, index) in result.questions" :key="index">
                        
                        <div class="flex items-center mb-2 text-lg">
                            <div class="mr-2">{{ index + 1 }}. </div>
                            <div v-html="question.question"></div>
                        </div>
                    
                        <div class="flex ml-24 space-y-3" v-for="(option, key, index) in question.options" :key="index">
                            <div class="flex items-center">
                                <template v-if="question.selected_answer == key && question.correct_answer == key">
                                    <input 
                                        type="checkbox" 
                                        disabled
                                        checked
                                        class="h-4 w-4 text-green-600 focus:ring-green-500 border-gray-300 rounded"
                                    >
                                </template>

                                <template v-else-if="question.selected_answer == key && question.correct_answer != key">
                                    <input 
                                        type="checkbox" 
                                        disabled
                                        checked
                                        class="h-4 w-4 text-red-600 focus:ring-red-500 border-gray-300 rounded"
                                    >
                                </template>
                                
                                <template v-else>
                                    <input 
                                        type="checkbox" 
                                        disabled
                                        class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    >
                                </template>

                                <p class="mx-2">{{ key }})</p>

                                <div class="inline-flex items-center ml-2 text-base text-gray-900">
                                    <span v-html="option"></span>
                                    <svg v-if="question.correct_answer == key" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 ml-3 flex-shrink-0 text-green-600" viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                                    </svg>
                                </div>

                            </div>
                        </div>
                        
                    </div>
                </div>
                    
                <div class="mt-6 text-center">
                    <Link 
                        :href="route('students.results.index')" 
                        class="inline-flex items-center ml-2 px-3 py-2 bg-gray-900 text-white text-sm uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                    >
                        Back To All Results
                    </Link>
                </div>
               
            </div>
        </div>
    </student-layout>
</template>

<script>
    import StudentLayout from '@/Layouts/StudentLayout'
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            StudentLayout,
            Head,
            Link
        },
        props: {
            result: Object
        }
    }
</script>
