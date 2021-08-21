<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Application Details</h2>

            <div class="mt-5">
                <div class="flex px-5 py-6 bg-white">
                    <div class="w-1/2">
                        <h4 class="text-sm font-bold uppercase tracking-wider">Student's Info</h4>
                        <div class="mt-3">
                            <p>First Name: {{ application.first_name }}</p>
                            <p>Last Name: {{ application.last_name }}</p>
                            <p>Email: {{ application.email }}</p>
                            <p>Phone: {{ application.phone }}</p>
                            <p>Gender: {{ application.gender }}</p>
                            <p>Date of Birth: {{ application.dob }}</p>
                            <p>Application Date: {{ application.created_at }}</p>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <h4 class="text-sm font-bold uppercase tracking-wider">Guardian's Info</h4>
                        <div class="mt-3">
                            <p>Name: {{ application.guardian_name }}</p>
                            <p>Phone: {{ application.guardian_phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xl font-bold">Requested Course: {{ application.course.name }}</p>
                </div>
                <div class="mt-4">
                    <jet-button @click.native.prevent="approveStudent">
                        Approve
                    </jet-button>
                    <jet-secondary-button @click.native.prevent="goBack">
                        Back
                    </jet-secondary-button>
                </div>
            </div>
            <!--approval Modal -->
            <jet-dialog-modal :show="showApprovalModal" @close="closeModal">
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
                   <jet-button @click.native.prevent="confirmApproval" v-if="batches.length" class="mr-2">
                        Confirm
                    </jet-button>

                    <jet-secondary-button @click.native="closeModal">
                        Nevermind
                    </jet-secondary-button>
                </template>
            </jet-dialog-modal>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetSecondaryButton from '@/Components/Shared/Button/SecondaryButton'
    import JetDialogModal from '@/Components/Shared/Modal/DialogModal'

    export default {
        components: {
            AdminLayout,
            JetButton,
            JetSecondaryButton,
            JetDialogModal
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