<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Application Details</h2>

            <div class="mt-5">
                <div class="flex px-5 py-6 bg-white">
                    <div>
                        <h4 class="text-sm font-bold uppercase tracking-wider">Student's Info</h4>
                        <div class="mt-3">
                            <p>First Name: {{ application.first_name }}</p>
                            <p>Last Name: {{ application.last_name }}</p>
                            <p>Email: {{ application.email }}</p>
                            <p>Phone: {{ application.phone }}</p>
                            <p>Gender: {{ application.gender }}</p>
                            <p>Date of Birth: {{ application.dob }}</p>
                            <p>Application Date: {{ application.application_date }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xl font-bold">Requested Course: {{ application.course.name }}</p>
                </div>
                <div class="mt-4">
                    <app-button @click.prevent="approveStudent">
                        Approve
                    </app-button>
                    <app-secondary-button class="ml-2" @click.prevent="goBack">
                        Back
                    </app-secondary-button>
                </div>
            </div>
            <!--approval Modal -->
            <app-dialog-modal :show="showApprovalModal" @close="closeModal">
                <template #title>
                    Student Approval
                </template>

                <template #content>
                    <p class="font-bold">Select a batch</p>
                    <div v-if="batches.length" class="px-5 pt-3">
                        <div v-for="batch in batches" :key="batch.id" class="flex items-center mb-3">
                            <input v-model="form.batch" :value="batch.id" :id="'batch_' + batch.id" type="radio" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300">
                            <label :for="'batch_' + batch.id" class="ml-3 block text-sm font-medium text-gray-700">
                                {{ batch.name }}
                            </label>
                        </div>
                    </div>
                    <div v-else>
                        <p>No Batch found for this course. Create some batch first.</p>
                    </div>
                </template>

                <template #footer>
                   <app-button @click.prevent="confirmApproval" v-if="batches.length" class="mr-2">
                        Confirm
                    </app-button>

                    <app-secondary-button @click.prevent="closeModal">
                        Nevermind
                    </app-secondary-button>
                </template>
            </app-dialog-modal>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppButton from '@/Components/Shared/Button/Button'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'
    import AppDialogModal from '@/Components/Shared/Modal/DialogModal'

    export default {
        components: {
            AdminLayout,
            AppButton,
            AppSecondaryButton,
            AppDialogModal
        },

        props: {
            application: Object,
            batches: Array,
        },

        data() {
            return {
                showApprovalModal: false,

                form: this.$inertia.form({
                    batch: this.batches.length ? this.batches[0].id : null,
                })
            }
        },

        methods: {
            approveStudent() {
                this.showApprovalModal = true;
            },

            closeModal() {
                this.showApprovalModal = false;
            },

            confirmApproval() {
                this.form.post(route('admin.applications.confirm', this.application.id), {
                    onFinish: () => this.showApprovalModal = false,
                });
            },
            goBack() {
                this.$inertia.visit(route('admin.applications.index'));
            }
        }
    }
</script>