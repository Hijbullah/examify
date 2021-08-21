<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Add Question for {{ exam.name }}</h2>

            <div class="mt-5">
                <question-form v-if="type === 'form'" :exam="exam" />
                <question-import v-else :exam="exam" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import QuestionForm from './Partials/QuestionForm'
    import QuestionImport from './Partials/QuestionImport'

    export default {
        components: {
            AdminLayout,
            QuestionForm,
            QuestionImport
        },
        props: {
            exam: Object,
            type: String,
        }
    }
</script>