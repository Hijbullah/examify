<template>
    <student-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center items-center">
                    <h2 class="font-bold uppercase tracking-widest">Result Summery</h2>
                    <div class="mt-12">
                        <p>{{ result.exam_category }}: {{ result.exam_name }}</p>
                        <p>Total Question: {{ result.total_question }}</p>
                        <p>Correct Answer: {{ result.correct_answer }}</p>
                        <p>Wrong Answer: {{ result.wrong_answer }}</p>
                        <p v-if="result.negative_mark">Negative Mark: {{ result.negative_mark }}</p>
                        <p>Total Mark: {{ result.total_mark }}</p>
                        <p v-if="result.position">Position: {{ result.position }}</p>
                    </div>
                    <div v-if="!result.is_published" class="mt-6">
                        <p>Details result will be published after exam Schedule.</p>
                    </div>
                    <div class="mt-6">
                        <inertia-link 
                            v-if="result.is_published"
                            :href="route('students.results.details', result.result_code)" 
                            class="inline-flex items-center px-3 py-2 bg-gray-900 text-white text-sm uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                        >
                            Details Result
                        </inertia-link>

                        <inertia-link 
                            :href="route('students.results.index')" 
                            class="inline-flex items-center px-3 py-2 bg-gray-900 text-white text-sm uppercase tracking-widest rounded hover:bg-gray-700 focus:outline-none"
                        >
                           Back To All Results
                        </inertia-link>
                    </div>
                </div>
            </div>
        </div>
    </student-layout>
</template>

<script>
    import StudentLayout from '@/Layouts/StudentLayout'

    export default {
        components: {
            StudentLayout
        },
        props: {
            result: Object
        }
    }
</script>
