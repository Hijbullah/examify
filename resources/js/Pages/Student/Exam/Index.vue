<template>
    <student-layout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto px-10 sm:px-6 lg:px-8">
                <div>
                    <h4 class="text-xl font-bold">Current Exam</h4>
                    <div class="mt-2 px-4 py-2 bg-white shadow-sm">
                        <div v-if="currentExam" class="flex justify-between items-center ">
                            <div>
                                <p class="text-xl font-bold">{{ currentExam.category }}: <span class="text-base">{{ currentExam.name }}</span></p> 
                                <p>Exam will end At: {{ currentExam.ended_at }}</p>
                            </div>
                            <div>
                                <jet-button @click.native.prevent="confirmStartExam">Start Exam</jet-button>
                            </div>
                        </div>
                        <div v-else class="flex justify-between items-center">
                            <p class="font-semibold">No Exam Found!.</p>
                            <jet-button @click.native.prevent="reloadThePage">Refresh</jet-button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <app-dialog-modal :show="startExamConfirmation" @close="closeModal">
                <template #title>
                    Start Exam
                </template>

                <template #content>
                    Are you sure you want to start this Exam? Once exam is started, don't reload the page or change tab.  
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="closeModal">
                        Nevermind
                    </jet-secondary-button>

                    <jet-button class="ml-2" @click.native.prevent="startExam">
                        Confirm
                    </jet-button>
                </template>
            </app-dialog-modal>
    </student-layout>
</template>

<script>
    import StudentLayout from '@/Layouts/StudentLayout'
    import AppDialogModal from '@/Components/Shared/Modal/DialogModal'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetSecondaryButton from '@//Components/Shared/Button/SecondaryButton'

    export default {
        components: {
            StudentLayout,
            AppDialogModal,
            JetButton,
            JetSecondaryButton
        },
        props: {
            currentExam: Object,
        },
        data() {
            return {
                startExamConfirmation: false
            }
        },
        methods: {
            reloadThePage() {
                this.$inertia.reload();
            },
            confirmStartExam() {
                this.startExamConfirmation = true;
            },

            startExam() {
                this.startExamConfirmation = false;
                this.$inertia.get(route('students.exams.start', this.currentExam.exam_code));
            },
            closeModal() {
                this.startExamConfirmation = false;
            },
        }
    }
</script>