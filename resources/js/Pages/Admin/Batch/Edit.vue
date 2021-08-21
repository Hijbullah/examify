<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Batch</h2>
            <div class="pt-5">
                <form @submit.prevent="update">   
                    <div>
                        <app-label value="Course Name" />

                        <Multiselect
                            v-model="form.course"
                            :options="courses"
                            :searchable="true"
                            placeholder="Choose a Course"
                        />                      
                        <app-input-error :message="form.errors.course" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <app-label for="name" value="Batch Name" />
                        <app-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Batch Name..." autocomplete="name" />
                        <app-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label class="inline-flex items-center">
                            <app-checkbox class="cursor-pointer" name="status" v-model:checked="form.status" />
                            <span class="ml-2 text-sm text-gray-600 select-none">Active</span>
                        </label>
                    </div>
                   
                    <div class="mt-4">
                        <app-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </app-button>
                        <app-secondary-button class="ml-2" @click.prevent="goBack">
                            Back
                        </app-secondary-button>
                    </div>
                </form>
            </div>
        </div>
       
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppInput from '@/Components/Shared/FormElement/Input'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppLabel from '@/Components/Shared/FormElement/Label'
    import AppCheckbox from '@/Components/Shared/FormElement/Checkbox'
    import AppButton from '@/Components/Shared/Button/Button'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'
    import Multiselect from '@vueform/multiselect'

    import '@vueform/multiselect/themes/default.css'

    export default {
        components: {
            AdminLayout,
            AppInput,
            AppInputError,
            AppLabel,
            AppCheckbox,
            AppButton,
            AppSecondaryButton,
            Multiselect
        },
        props: {
            courses: Array,
            batch: Object
        },

        data() {
            return {
                form: this.$inertia.form({
                    course: this.batch.course_id,
                    name: this.batch.name,
                    status: this.batch.status
                })
            }
        },

        methods: {
            update(){
                this.form.put(route('admin.batches.update', this.batch.slug), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.batches.index'));
            }
        }
    }
</script>