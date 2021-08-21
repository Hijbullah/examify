<template>
    <div class="relative h-72 w-ull flex flex-col justify-center items-center bg-white border-2 rounded">
        <a :href="route('admin.questions.format', exam.id)" class="absolute right-4 top-4 font-bold underline tracking-wider hover:text-gray-600">Download Format</a>
        <input ref="questions_file" @change="handleUploadedFile" type="file" class="hidden">
        <div class="flex flex-col justify-center items-center space-x-1">
            <app-main-button @click.native.prevent="selectQuestionFile">
                {{ hasFile ? 'Change' : 'Select A File' }}
            </app-main-button>
            <span class="mt-2 font-bold" v-show="fileName">{{ fileName }}</span>
        </div>
        <div class="mt-5 flex space-x-2 justify-center items-center">
            <app-loading-button 
                class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest disabled:opacity-50"
                @click.native.prevent="uploadQuestionFile"
                :loading="sending"
                :disabled="!hasFile"
            >Upload</app-loading-button>

            <app-danger-button @click.native.prevent="goBack">Cancel</app-danger-button>
        </div>
        <app-input-error :message="form.errors.file"  class="mt-2 font-bold" />

    </div>
</template>

<script>
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppMainButton from '@/Components/Shared/Button/Button'
    import AppLoadingButton from '@/Components/Shared/Button/LoadingButton'
    import AppDangerButton from '@/Components/Shared/Button/DangerButton'

    export default {
        components: {
            AppInputError,
            AppMainButton,
            AppLoadingButton,  
            AppDangerButton,
        },

        props: {
            exam: Object
        },

        data() {
            return {
                sending: false,

                form: this.$inertia.form({
                    exam: this.exam.id,
                    file: null,
                }),
            }
        },

        computed: {
            hasFile() {
                return this.form.file ? true : false;
            },

            fileName() {
                return this.hasFile? this.form.file.name : '';
            }
        },

        methods: {
            selectQuestionFile() {
                this.$refs.questions_file.click();
            },

            handleUploadedFile(event) {
                this.form.file = event.target.files[0];
            },

            uploadQuestionFile() {
                this.sending = true;

                 this.form.post(route('admin.questions.store.import'), {
                    onSuccess: () => {
                        this.form.reset();
                        alert('Question Added Succefully!');
                    },
                    onFinish: () => {
                        this.sending = false;
                    }

                });
            },

            goBack() {
                this.$inertia.visit(route('admin.questions.index', this.exam.exam_code));
            },
        }

    }
</script>