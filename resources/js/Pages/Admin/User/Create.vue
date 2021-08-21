<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Add New User</h2>
            <div class="max-w-xl pt-5">
                <form @submit.prevent="create">
                    <div class="mt-4">
                        <jet-label for="type" value="User Type" />
                        <select id="gender" v-model="form.type" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="admin">Admin</option>
                            <option value="teacher">Teacher</option>
                        </select>
                        <jet-input-error :message="form.errors.type" class="mt-2" />
                    </div>

                    <div class="flex mt-4 space-x-3">
                        <div class="w-1/2">
                            <jet-label for="first_name" value="First Name" />
                            <jet-input id="first_name" type="text" class="mt-1 block w-full" v-model="form.first_name" />
                            <jet-input-error :message="form.errors.first_name" class="mt-2" />
                        </div>
                        <div class="w-1/2">
                            <jet-label for="last_name" value="Last Name" />
                            <jet-input id="last_name" type="text" class="mt-1 block w-full" v-model="form.last_name" />
                            <jet-input-error :message="form.errors.last_name" class="mt-2" />
                        </div>

                    </div>

                    <div class="mt-4">
                        <jet-label for="email" value="Email" />
                        <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                        <jet-input-error :message="form.errors.email" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="phone" value="Phone" />
                        <jet-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                        <jet-input-error :message="form.errors.phone" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password" value="Password" />
                        <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" />
                        <jet-input-error :message="form.errors.password" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <jet-label for="password_confirmation" value="Confirm Password" />
                        <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" />
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
            JetButton,
            JetSecondaryButton,
        },

        data() {
            return {
                form: this.$inertia.form({
                    type: 'admin',
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            create(){
                this.form.post(this.route('admin.users.store'), {
                    onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }, 
            goBack() {
                this.$inertia.visit(route('admin.users.index'));
            }
        }
    }
</script>