<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Subject</h2>
            <div class="pt-5">
                <form @submit.prevent="create">
                  
                    <div>
                        <app-label for="name" value="Subject Name" />
                        <app-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                        <app-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label class="inline-flex items-center">
                            <app-checkbox class="cursor-pointer" name="status" v-model:checked="form.status" />
                            <span class="ml-2 text-sm text-gray-600 select-none">Status</span>
                        </label>
                    </div>
                   
                    <div class="mt-4">
                        <app-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
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
    import AppCheckbox from '@/Components/Shared/FormElement/Checkbox'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppLabel from '@/Components/Shared/FormElement/Label'
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
        
        data() {
            return {
                form: this.$inertia.form({
                    name: '',
                    status: true,
                }),
            }
        },
        methods: {
            create(){
                this.form.post(route('admin.subjects.store'), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.subjects.index'));
            }
        }
    }
</script>