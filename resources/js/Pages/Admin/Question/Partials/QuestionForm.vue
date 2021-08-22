<template>
    <div class="w-full">
        <div class="mx-auto my-5 max-w-md">
            <select v-model="form.subject" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm cursor-pointer">
                <option :value="null">Select a Subject</option>
                <option :disabled="subject.no_of_question === subject.questions_count" v-for="subject in exam.subjects" :key="subject.id" :value="subject.id">{{ subject.name }} - ( {{ subject.questions_count }} / {{ subject.no_of_question }})</option>
            </select>
            <app-input-error :message="form.errors.subject"  class="mt-2" />
        </div>

        <div class="p-5">
            <div class="mb-5 w-full">
                <question-editor v-model:editorContent="form.question"></question-editor>
                <app-input-error :message="form.errors.question"  class="mt-2" />
            </div>
            
            <div class="pl-8 py-4 space-y-4">
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="a" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor v-model:editorContent="form.option_a"></question-editor>
                        </div>
                        <app-input-error :message="form.errors.option_a"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="b" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor v-model:editorContent="form.option_b"></question-editor>
                        </div>
                        <app-input-error :message="form.errors.option_b"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="c" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor v-model:editorContent="form.option_c"></question-editor>
                        </div>
                        <app-input-error :message="form.errors.option_c"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="d" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor v-model:editorContent="form.option_d"></question-editor>
                        </div>
                        <app-input-error :message="form.errors.option_d"  class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <app-button  @click.prevent="saveQuestion" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </app-button>
            <app-danger-button class="ml-2"  @click.prevent="goBack">Go Back</app-danger-button>
        </div>
    </div>
</template>

<script>
    import QuestionEditor from '@/Components/Shared/Editor'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppButton from '@/Components/Shared/Button/Button'
    import AppDangerButton from '@/Components/Shared/Button/DangerButton'

    export default {
        components: {
            QuestionEditor,
            AppInputError,
            AppButton,
            AppDangerButton,
        },

        props: {
            exam: Object
        },

        data() {
            return {
                form: this.$inertia.form({
                    exam: this.exam.id,
                    subject: null,
                    question: '',
                    option_a: '',
                    option_b: '',
                    option_c: '',
                    option_d: '',
                    answer: 'a'
                }),
            }
        },

        methods: {
            saveQuestion() {
                this.form.post(route('admin.questions.store.form'), {
                    onSuccess: () => {
                        this.form.reset();
                        alert('Question Added Succefully!');
                    },
                });
            },
            goBack() {
                this.$inertia.visit(route('admin.questions.index', this.exam.exam_code));
            },
        }
    }
</script>