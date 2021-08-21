<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Course</h2>
            <div class="pt-5">
                <form @submit.prevent="update">
                  
                    <div>
                        <app-label for="name" value="Course Name" />
                        <app-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Course Name..." autocomplete="name" />
                        <app-input-error :message="form.errors.name" class="mt-2" />
                    </div>
                    <div class="mt-4">
                        <app-label for="details" value="Details" />
                        <textarea 
                            id="details" 
                            rows="5" 
                            class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" 
                            placeholder="Details about Course"
                            v-model="form.details"
                        ></textarea>
                        <app-input-error :message="form.errors.details" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label class="inline-flex items-center">
                            <app-checkbox class="cursor-pointer" name="admission_status" v-model:checked="form.admission_status" />
                            <span class="ml-2 text-sm text-gray-600 select-none">Admission Open</span>
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

    export default {
        components: {
            AdminLayout,
            AppInput,
            AppInputError,
            AppLabel,
            AppCheckbox,
            AppButton,
            AppSecondaryButton
        },
        
        props: {
            course: Object
        },
        
        data() {
            return {
                form: this.$inertia.form({
                    name: this.course.name,
                    details: this.course.details,
                    admission_status: this.course.admission_status,
                })
            }
        },

        methods: {
            update(){
                this.form.put(route('admin.courses.update', this.course.slug), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.courses.index'));
            }
        }
    }
</script>