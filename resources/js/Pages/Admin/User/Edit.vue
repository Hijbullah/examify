<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit User</h2>
            <div class="max-w-xl pt-5">
                <form @submit.prevent="update">
                    <div class="flex mt-4 space-x-3">
                        <div class="w-1/2">
                            <app-label for="first_name" value="First Name" />
                            <app-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" />
                            <app-input-error :message="form.errors.first_name" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <app-label for="last_name" value="Last Name" />
                            <app-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" />
                            <app-input-error :message="form.errors.last_name" class="mt-2" />
                        </div>

                    </div>

                    <div class="mt-4">
                        <app-label for="phone" value="Phone" />
                        <app-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                        <app-input-error :message="form.errors.phone" class="mt-2" />
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
    import AppButton from '@/Components/Shared/Button/Button'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'

    export default {
        components: {
            AdminLayout,
            AppInput,
            AppInputError,
            AppLabel,
            AppButton,
            AppSecondaryButton,
        },

        props: {
            user: Object
        },

        data() {
            return {
                form: this.$inertia.form({
                    type: this.user.type,
                    first_name: this.user.first_name,
                    last_name: this.user.last_name,
                    phone: this.user.phone
                }),
            }
        },

        methods: {
            update(){
                this.form.put(this.route('admin.users.update', this.user.id));
            }, 
            goBack() {
                this.$inertia.visit(route('admin.users.index'));
            }
        }
    }
</script>