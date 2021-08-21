<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Questions for {{ exam.name }}</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-end items-center space-x-2">
                    <inertia-link 
                        v-if="!hasEnoughQuestions"
                        :href="route('admin.questions.create', [exam.exam_code, 'form'])" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Add Questions
                    </inertia-link>
                    <inertia-link 
                        v-if="!hasQuestions"
                        :href="route('admin.questions.create', [exam.exam_code, 'file'])" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Import Questions
                    </inertia-link>
    
                    <inertia-link 
                        :href="route('admin.exams.show', exam.exam_code)" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Back
                    </inertia-link>
                </div>
                <div>
                    <p v-if="exam.status != 'pending'" class="mb-3 text-sm text-green-400 font-bold">Question Can't be add, Edit or Delete, When exam is in Publish Mode.</p>
                    <h3 class="mb-5 text-sm font-bold uppercase tracking-widest">All Questions <span>({{ questionCount }}/{{ exam.total_question }})</span></h3>
                    <div class="space-y-3">
                        <div v-if="questions.length">
                            <single-question v-for="(question, index) in questions" 
                                :key="question.id"
                                :examCode="exam.exam_code"
                                :examStatus="exam.status"
                                :question="question"
                                :serial="index + 1"
                            />
                        </div>
                        <div v-else class="h-36 flex justify-center items-center p-5 bg-white ">
                            <p>No Question found! Add Some</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import SingleQuestion from './Partials/Question'
    import 'katex/dist/katex.min.css'

    export default {
        components: {
            AdminLayout,
            SingleQuestion
        },
        props: {
            exam: Object,
            questions: Array
        },
        computed: {
            questionCount() {
                return this.questions.length;
            },
            hasEnoughQuestions() {
                return this.exam.total_question == this.questionCount;
            },
            hasQuestions() {
                return this.questionCount ? true : false;
            }
        }
    }
</script>