<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Create New Subject</h2>
            <div class="pt-5">
                <form @submit.prevent="create">
                  
                    <div>
                        <jet-label for="name" value="Subject Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Subject Name..." autocomplete="name" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="block mt-4">
                        <label class="inline-flex items-center">
                            <jet-checkbox class="cursor-pointer" v-model="form.status" />
                            <span class="ml-2 text-sm text-gray-600 select-none">Status</span>
                        </label>
                    </div>
                   
                    <div class="mt-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Save
                        </jet-button>
                        <jet-secondary-button @click.native.prevent="goBack">
                            Back
                        </jet-secondary-button>
                    </div>
                </form>
            </div>
        </div>
       
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import JetInput from '@/Components/Shared/FormElement/Input'
    import JetCheckbox from '@/Components/Shared/FormElement/Checkbox'
    import JetInputError from '@/Components/Shared/FormElement/InputError'
    import JetLabel from '@/Components/Shared/FormElement/Label'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetSecondaryButton from '@/Components/Shared/Button/SecondaryButton'

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            JetCheckbox,
            JetButton,
            JetSecondaryButton
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