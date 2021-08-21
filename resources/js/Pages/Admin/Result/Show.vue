<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">{{ exam.name }}</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-end items-center space-x-2">
                    <inertia-link 
                        :href="route('admin.questions.index', exam.exam_code)" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Questions
                    </inertia-link>
                    <inertia-link 
                        :href="route('admin.exams.results', exam.exam_code)" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Results
                    </inertia-link>
                    <inertia-link 
                        v-if="!isExamPublished"
                        :href="route('admin.exams.edit', exam.exam_code)" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Edit
                    </inertia-link>

                    <inertia-link 
                        :href="route('admin.exams.index')" 
                        class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                    >
                        Back
                    </inertia-link>
                </div>

                <div class="flex space-x-5">
                   <div class="w-2/3 px-4 py-5 bg-white shadow-sm">
                       <h2 class="mb-3 text-sm font-bold uppercase tracking-wider">Exam Details</h2>
                       <p>Exam Name: {{ exam.name }}</p>
                       <p>Course: {{ exam.batch.course.name }}</p>
                       <p>Batch: {{ exam.batch.name }}</p>
                       <p>Category: {{ exam.category.name }}</p>
                       <p>Questions: {{ exam.questions_count }}/{{ exam.total_question }}</p>
                       <p>Duration: {{ exam.exam_duration }} min</p>
                       <p v-if="exam.has_negative_mark">Negetive Mark: {{ exam.negative_mark }}</p>
                   </div>
                   <div class="w-1/3 px-4 py-5 bg-white shadow-sm">
                       <h2 class="mb-3 text-sm font-bold uppercase tracking-wider">Subjects</h2>
                       <div>
                           <div class="flex justify-between items-center">
                               <p class="font-bold">Name</p>
                               <p class="font-bold">No of Question</p>
                           </div>
                           <div v-for="subject in exam.subjects" :key="subject.id" class="flex justify-between items-center">
                               <p>{{ subject.name }}</p>
                               <p class="text-center">{{ subject.no_of_question }}</p>
                           </div>
                       </div>
                       <div class="mt-3">
                           <inertia-link 
                                :href="route('admin.questions.index', exam.exam_code)" 
                                class="btn-main px-3 py-2 text-xs font-semibold uppercase tracking-widest"
                            >
                                Go To Questions
                            </inertia-link>
                       </div>
                   </div>
                </div>

                <div class="mt-5 flex space-x-5">
                    <div class="w-2/3 px-4 py-5 bg-white shadow-sm">
                        <h2 class="mb-3 text-sm font-bold uppercase tracking-wider">Exam Schedule</h2>
                        <div>
                            <p>Exam Start At: <span class="font-bold">{{ exam.schedule.start }}</span></p>
                            <p>Exam End At: <span class="font-bold">{{ exam.schedule.end }}</span></p>
                        </div>
                    </div>
                    <div class="w-1/3 px-4 py-5 bg-white shadow-sm">
                        <div class="flex justify-between items-center">
                            <h2 class="text-sm font-bold uppercase tracking-wider">Exam Status</h2>
                            <p class="text-sm font-bold uppercase tracking-widest">{{ exam.status }}</p>
                        </div>
                        <div class="mt-4">
                            <p v-if="!hasEnoughQuestions" class="mb-3 text-sm font-light text-red-500 leading-tight">Warning: You have not added enough questions for this exam. Add Question before publish exam.</p>
                            <p v-else class="mb-3 text-sm font-light text-green-500 leading-tight">Exam can be published now!</p>
                            <p v-if="isExamPublished" class="mb-3 text-sm">Exam can't be edited when it is published.</p>
                            <inertia-link 
                                v-if="!hasEnoughQuestions"
                                :href="route('admin.questions.index', exam.exam_code)" 
                                class="btn-main mr-2 px-3 py-2 text-xs font-semibold uppercase tracking-widest"
                            >
                                Add Questions
                            </inertia-link>

                            <button 
                                class="btn-main px-3 py-2 text-xs font-semibold uppercase tracking-widest disabled:opacity-50"
                                :disabled="!hasEnoughQuestions"
                                @click.prevent="toogleExamPublication"
                                v-if="!isExamPublished"
                            >
                                Publish
                            </button>

                            <button 
                                class="btn-main px-3 py-2 bg-red-500 text-white text-xs font-semibold uppercase tracking-widest hover:bg-red-400 disabled:opacity-50"
                                :disabled="!hasEnoughQuestions"
                                @click.prevent="toogleExamPublication"
                                v-else
                            >
                                UnPublish
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'

    export default {
        components: {
            AdminLayout
        },
        props: {
            exam: Object,
        },
        computed: {
            hasEnoughQuestions() {
                return this.exam.total_question === this.exam.questions_count;
            },
            isExamPublished() {
                return this.exam.status === 'published';
            }
        },
        methods: {
            toogleExamPublication() {
                this.$inertia.put(route('admin.exams.publish', this.exam.exam_code), {}, {
                    preserveScroll: true,
                    onSuccess: () => {
                        let message = 'Exam published successfully!';
                        if(this.exam === 'pending') {
                            message = 'Exam un published successfully!';
                        } 
                        alert(message);
                    }
                });
            }
        }
    }
</script>