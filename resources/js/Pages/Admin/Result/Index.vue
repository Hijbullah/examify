<template>
    <Head title="All results" />

    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Results for {{ exam.name }}</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-between items-center">
                    <div>
                        <p v-if="exam.status === 'closed'" class="text-lg font-bold">Results have been published.</p>
                        <p v-else class="text-lg font-bold">Exam will end at: {{ exam.schedule.end }}</p>
                    </div>
                    <div>
                        <button 
                            class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                            :class="{ 'opacity-25': isProcessing }" 
                            :disabled="isProcessing"
                            @click.prevent="publishResults"
                            v-if="exam.status === 'published'"
                        >
                            Publish Results
                        </button>

                        <Link 
                            :href="route('admin.exams.show', exam.exam_code)" 
                            class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                        >
                            Back
                        </Link>
                    </div>
                </div>

                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <tr class="text-left">
                            <th class="px-6 pt-4 pb-4 font-normal">Name</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Answered</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Correct</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Wrong</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Negetive Marks</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Marks</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Exam Taken At</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Position</th>
                        </tr>

                        <tr v-for="result in results.data" :key="result.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ result.student.full_name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ result.total_answered }} / {{ result.total_question }}
                            </td>
                            <td class="border-t px-6 py-2 text-center text-green-500">
                                {{ result.correct_answer }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ result.wrong_answer }}
                            </td>
                            <td class="border-t px-6 py-2 text-center text-red-500">
                                - {{ result.negative_mark }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ result.total_mark }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ result.exam_taken_at }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ result.position ? result.position : '-' }}
                            </td>
                        </tr>
                        <tr v-if="results.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="5">No Results found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination :links="results.links" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import Pagination from '@/Components/Shared/Pagination'
    import AppButton from '@/Components/Shared/Button/Button'
    import { Head, Link } from '@inertiajs/inertia-vue3'

    export default {
        components: {
            AdminLayout,
            Pagination,
            AppButton,
            Head,
            Link
        },
        props: {
            exam: Object,
            results: Object,
        },
        data() {
            return {
                isProcessing: false,
            }
        },
        methods: {
            publishResults() {
                this.$inertia.put(route('admin.exams.publish-results', this.exam.exam_code), {}, {
                    onBefore: () => confirm('Are you sure? If you publish results, exam will autometically closed.'),
                    onStart: () => this.isProcessing = true,
                    onSuccess: () => {
                        alert('Results successfully published');
                    },
                    onFinish: () => this.isProcessing = false
                });
            }
        }
    }
</script>