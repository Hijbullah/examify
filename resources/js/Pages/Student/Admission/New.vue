<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 bg-gray-100">
        <div>
            <inertia-link href="/">
                <application-logo class="w-20 h-20 fill-current text-gray-500" />
            </inertia-link>
        </div>

        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow overflow-hidden sm:rounded">
            <form @submit.prevent="submit">
                <div>
                    <jet-label value="Course" />
                    <!-- <vue-select 
                        class="vue_select_box mt-1"
                        placeholder="Choose a Course"
                        :options="courses" 
                        label="name" 
                        :reduce="course => course.id" 
                        v-model="form.course_id"
                    >
                    </vue-select>  -->
                    <jet-input-error :message="form.errors.course_id" class="mt-2" />
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

                <div class="flex mt-4 space-x-3">
                    <div class="w-1/2">
                        <jet-label for="gender" value="Gender" />
                        <select id="gender" v-model="form.gender" class="mt-1 block w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm">
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                        </select>
                        <jet-input-error :message="form.errors.gender" class="mt-2" />
                    </div>

                    <div class="w-1/2">
                        <jet-label for="dob" value="Date of Birth" />
                        <jet-input id="dob" type="date" class="mt-1 block w-full" v-model="form.dob" />
                        <jet-input-error :message="form.errors.dob" class="mt-2" />
                    </div>
                </div>

                <div class="mt-4">
                    <jet-label for="guardian_name" value="Guardian Name" />
                    <jet-input id="guardian_name" type="text" class="mt-1 block w-full" v-model="form.guardian_name" />
                    <jet-input-error :message="form.errors.guardian_name" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-label for="guardian_phone" value="Guardian Phone" />
                    <jet-input id="guardian_phone" type="text" class="mt-1 block w-full" v-model="form.guardian_phone" />
                    <jet-input-error :message="form.errors.guardian_phone" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-8">
                    <inertia-link :href="route('login')" class="underline text-sm text-gray-600 hover:text-gray-900">
                        Already Applied? Login
                    </inertia-link>

                    <jet-button class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Apply For Admission
                    </jet-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
    import ApplicationLogo from '@/Components/Shared/ApplicationLogo'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetInput from '@/Components/Shared/FormElement/Input'
    import JetCheckbox from "@/Components/Shared/FormElement/Checkbox";
    import JetLabel from '@/Components/Shared/FormElement/Label'
    import JetInputError from '@/Components/Shared/FormElement/InputError'
    // import VueSelect from 'vue-select'

    // import 'vue-select/dist/vue-select.css'

    export default {
        components: {
            ApplicationLogo,
            JetButton,
            JetInput,
            JetCheckbox,
            JetLabel,
            JetInputError,
            // VueSelect
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
                    guardian_name: '',
                    guardian_phone: '',
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


<style scoped>
    /* .vue_select_box >>> .vs__search::placeholder {
        color: #394066;
        font-size: 16px;
    }
    .vue_select_box >>> .vs__dropdown-toggle {
        background: #fff;
        border: 1px solid #ddd;
        color: #394066;
        padding: 7px 5px;
        font-size: 14px;
    }
    .vue_select_box >>> .vs__dropdown-menu {
        color: #394066;
        font-size: 14px;
    }

    .vue_select_box >>> .vs__dropdown-option:hover, 
    .vue_select_box >>> .vs__dropdown-option--highlight 
    {
        background-color: #394066;
        color: white;
    }

    .vue_select_box >>> .vs__clear,
    .vue_select_box >>> .vs__open-indicator {
        fill: #394066;
    } */

</style>