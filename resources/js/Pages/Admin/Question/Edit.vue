<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Question for {{ exam.name }}</h2>

            <div class="mt-5">
                <question-edit-form :exam="exam" :question="question" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import QuestionEditForm from './Partials/QuestionEditForm'

    export default {
        components: {
            AdminLayout,
            QuestionEditForm
        },
        props: {
            exam: Object,
            question: Object,
        }
    }
</script>