<template>
    <div>
        <h2 class="text-xl text-gray-900 font-semibold border-gray-900">Change Password</h2>
        <div class="max-w-xl pt-5">
            <form @submit.prevent="updatePassword">
                <div>
                    <app-label for="current_password" value="Current Password" />
                    <app-input id="current_password" type="password" class="mt-1 block w-full" v-model="form.current_password" ref="current_password" autocomplete="current-password" />
                    <app-input-error :message="form.errors.current_password" class="mt-2" />
                </div>

                <div class="mt-4">
                    <app-label for="password" value="New Password" />
                    <app-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" ref="password" autocomplete="new-password" />
                    <app-input-error :message="form.errors.password" class="mt-2" />
                </div>

                <div class="mt-4">
                    <app-label for="password_confirmation" value="Confirm Password" />
                    <app-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                    <app-input-error :message="form.errors.password_confirmation" class="mt-2" />
                </div>
                <div class="mt-4">
                    <app-main-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Update Password
                    </app-main-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import AppInput from '@/Components/Shared/FormElement/Input'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppLabel from '@/Components/Shared/FormElement/Label'
    import AppMainButton from '@/Components/Shared/Button/Button'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'

    export default {
        components: {
            AppInput,
            AppInputError,
            AppLabel,
            AppMainButton,
            AppSecondaryButton,
        },

        data() {
            return {
                form: this.$inertia.form({
                    current_password: '',
                    password: '',
                    password_confirmation: '',
                }),
            }
        },

        methods: {
            updatePassword() {
                this.form.put(route('students.password.update'), {
                    preserveScroll: true,
                    onSuccess: () => {
                        this.form.reset();
                        alert('Password updated successfully');
                    },
                    onError: () => {
                        if (this.form.errors.password) {
                            this.form.reset('password', 'password_confirmation')
                            this.$refs.password.focus()
                        }

                        if (this.form.errors.current_password) {
                            this.form.reset('current_password')
                            this.$refs.current_password.focus()
                        }
                    }
                })
            }
        }
    }
</script>