<template>
    <div class="w-full">
        <div class="mx-auto my-5 max-w-md">
            <select disabled v-model="question.subject" class="w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm cursor-pointer">
                <option v-for="subject in exam.subjects" :key="subject.id" :value="subject.id">{{ subject.name }}</option>
            </select>
        </div>

        <div class="p-5">
            <div class="mb-5 w-full">
                <question-editor :content.sync="form.question" as="question"></question-editor>
                <jet-input-error :message="form.errors.question"  class="mt-2" />
            </div>
            
            <div class="pl-8 py-4 space-y-4">
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="a" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor :content.sync="form.option_a" as="options"></question-editor>
                        </div>
                        <jet-input-error :message="form.errors.option_a"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="b" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor :content.sync="form.option_b" as="options"></question-editor>
                        </div>
                        <jet-input-error :message="form.errors.option_b"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="c" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor :content.sync="form.option_c" as="options"></question-editor>
                        </div>
                        <jet-input-error :message="form.errors.option_c"  class="mt-2" />
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    <input v-model="form.answer" value="d" type="radio" class="h-4 w-4 cursor-pointer text-indigo-600 transition duration-150 ease-in-out">
                    <div class="flex-1">
                        <div class="flex flex-col">
                            <question-editor :content.sync="form.option_d" as="options"></question-editor>
                        </div>
                        <jet-input-error :message="form.errors.option_d"  class="mt-2" />
                    </div>
                </div>
            </div>
        </div>

        <div>
            <jet-button  @click.native.prevent="updateQuestion" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Update Question
            </jet-button>
            <jet-danger-button  @click.native.prevent="goBack">Go Back</jet-danger-button>
        </div>
    </div>
</template>

<script>
    import QuestionEditor from '@/Components/Shared/Editor'
    import JetInputError from '@/Components/Shared/FormElement/InputError'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetDangerButton from '@/Components/Shared/Button/DangerButton'

    export default {
        components: {
            QuestionEditor,
            JetInputError,
            JetButton,
            JetDangerButton,
        },

        props: {
            exam: Object,
            question: Object,
        },

        data() {
            return {
                form: this.$inertia.form({
                    question: this.question.question,
                    option_a: this.question.option_a,
                    option_b: this.question.option_b,
                    option_c: this.question.option_c,
                    option_d: this.question.option_d,
                    answer: this.question.answer
                }),
            }
        },

        methods: {
            updateQuestion() {
                this.form.put(route('admin.questions.update', this.question.id), {
                    onSuccess: () => {
                        alert('Question updated Succefully!');
                    },
                });
            },
            goBack() {
                this.$inertia.visit(route('admin.questions.index', this.exam.exam_code));
            },
        }
    }
</script>
