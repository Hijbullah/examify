<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">student Details</h2>

            <div class="mt-5">
                <div class="flex px-5 py-6 bg-white">
                    <div class="w-1/2">
                        <h4 class="text-sm font-bold uppercase tracking-wider">Student's Info</h4>
                        <div class="mt-3">
                            <p>First Name: {{ student.first_name }}</p>
                            <p>Last Name: {{ student.last_name }}</p>
                            <p>Email: {{ student.email }}</p>
                            <p>Phone: {{ student.phone }}</p>
                            <p>Gender: {{ student.gender }}</p>
                            <p>Date of Birth: {{ student.dob }}</p>
                            <p>student Date: {{ student.approval_date }}</p>
                        </div>
                    </div>
                    <div class="w-1/2">
                        <h4 class="text-sm font-bold uppercase tracking-wider">Guardian's Info</h4>
                        <div class="mt-3">
                            <p>Name: {{ student.guardian_name }}</p>
                            <p>Phone: {{ student.guardian_phone }}</p>
                        </div>
                    </div>
                </div>
                <div class="mt-4">
                    <p class="text-xl font-bold">Course: {{ student.course.name }}</p>
                    <p class="text-xl font-bold">Batch: {{ student.batch.name }}</p>
                </div>
                <div class="mt-4">
                    <app-secondary-button @click.native.prevent="goBack">
                        Back
                    </app-secondary-button>
                </div>
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'

    export default {
        components: {
            AdminLayout,
            AppSecondaryButton
        },

        props: {
            student: Object,
        },

        methods: {
            goBack() {
                this.$inertia.visit(route('admin.students.index'));
            }
        }
    }
</script>