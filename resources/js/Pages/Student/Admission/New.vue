<template>
    <Head title="Apply for New Admission" />

    <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 bg-gray-100">
        <div>
            <Link href="/">
                <application-logo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow overflow-hidden sm:rounded">
            <form @submit.prevent="submit">
                <div>
                    <app-label value="Course" />
                    <Multiselect
                        v-model="form.course_id"
                        :options="courses"
                        :searchable="true"
                        placeholder="Choose a Course"
                    />   
                    <app-input-error :message="form.errors.course_id" class="mt-2" />
                </div>
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
                    <app-label for="email" value="Email" />
                    <app-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                    <app-input-error :message="form.errors.email" class="mt-2" />
                </div>

                <div class="mt-4">
                    <app-label for="phone" value="Phone" />
                    <app-input id="phone" type="text" class="mt-1 block w-full" v-model="form.phone" />
                    <app-input-error :message="form.errors.phone" class="mt-2" />
                </div>

                <div class="flex mt-4 space-x-3">
                    <div class="w-1/2">
                        <app-label for="gender" value="Gender" />
                        <select id="gender" v-model="form.gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <app-input-error :message="form.errors.gender" class="mt-2" />
                    </div>

                    <div class="w-1/2">
                        <app-label for="dob" value="Date of Birth" />
                        <app-input id="dob" type="date" class="mt-1 block w-full" v-model="form.dob" />
                        <app-input-error :message="form.errors.dob" class="mt-2" />
                    </div>
                </div>

                <div class="flex items-center justify-between mt-8">
                    <Link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Already Applied? Login
                    </Link>

                    <app-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Apply For Admission
                    </app-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import ApplicationLogo from '@/Components/Shared/ApplicationLogo'
    import { Head, Link } from '@inertiajs/inertia-vue3'
    import AppButton from '@/Components/Shared/Button/Button'
    import AppInput from '@/Components/Shared/FormElement/Input'
    import AppCheckbox from "@/Components/Shared/FormElement/Checkbox";
    import AppLabel from '@/Components/Shared/FormElement/Label'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import Multiselect from '@vueform/multiselect'

    import '@vueform/multiselect/themes/default.css'

    export default {
        components: {
            ApplicationLogo,
            Head,
            Link,
            AppButton,
            AppInput,
            AppCheckbox,
            AppLabel,
            AppInputError,
            Multiselect
        },

        props: {
            courses: Array,
        },

        data() {
            return {
                form: this.$inertia.form({
                    course_id: null,
                    first_name: '',
                    last_name: '',
                    email: '',
                    phone: '',
                    gender: 'male',
                    dob: '',
                })
            }
        },

        methods: {
            submit() {
                this.form.post(this.route('students.admission'), {
                    //onFinish: () => this.form.reset('password', 'password_confirmation'),
                })
            }
        }
    }
</script>