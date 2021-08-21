<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Exam Category</h2>
            <div class="pt-5">
                <form @submit.prevent="update">
                  
                    <div>
                        <jet-label for="name" value="Category Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="Category Name..." autocomplete="name" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>
                   
                    <div class="mt-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
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
    import JetInputError from '@/Components/Shared/FormElement/InputError'
    import JetLabel from '@/Components/Shared/FormElement/Label'
    import JetCheckbox from '@/Components/Shared/FormElement/Checkbox'
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

        props: {
            category: Object
        },
        
        data() {
            return {
                form: this.$inertia.form({
                    name: this.category.name
                }),
            }
        },
        methods: {
            update(){
                this.form.put(route('admin.exam-categories.update', this.category.slug), {
                    preserveScroll: true,
                });
            }, 
            goBack() {
                this.$inertia.visit(route('admin.exam-categories.index'));
            }
        }
    }
</script>