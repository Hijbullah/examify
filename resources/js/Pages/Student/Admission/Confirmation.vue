<template>
    <Head title="Admission Confirmation" />
    
    <div class="min-h-screen flex flex-col sm:justify-center items-center py-6 bg-gray-100">
        <div>
            <Link href="/">
                <application-logo class="w-20 h-20 fill-current text-gray-500" />
            </Link>
        </div>

        <div class="w-full sm:max-w-xl mt-6 px-6 py-4 bg-white shadow overflow-hidden sm:rounded">
            <p>Your application has been received. Once accepted, we will notify you through Email.</p>
            <p>When accepted, you can login with your email and password will be you phone number.</p>
            <p>After login, you can change your password.</p>
            <div class="mt-5 space-x-5">
                <Link href="/" class="underline text-sm font-bold text-gray-600 hover:text-gray-900">
                        Back to Home
                </Link>

                <Link :href="route('login')" class="underline text-sm font-bold text-gray-600 hover:text-gray-900">
                    Login
                </Link>
            </div>
        </div>
    </div>
</template>

<script>
    import ApplicationLogo from '@/Components/Shared/ApplicationLogo'
    import { Head, Link } from "@inertiajs/inertia-vue3"

    export default {
        components: {
            ApplicationLogo,
            Head,
            Link
        },

        props: {
            name: String,
        }
    }
</script>