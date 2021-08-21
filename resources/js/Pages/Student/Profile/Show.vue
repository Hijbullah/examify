<template>
    <student-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <h2 class="text-gray-900 text-2xl font-semibold border-b-2 border-gray-900">My Profile</h2>
                <div class="w-full mt-8">
                   <ChangePasswordForm />
                </div>
            </div>
        </div>
    </student-layout>
</template>

<script>
    import StudentLayout from '@/Layouts/StudentLayout'
    import ChangePasswordForm from './Partials/ChangePasswordForm'

    export default {
        components: {
            StudentLayout,
            ChangePasswordForm
        }
    }
</script>
