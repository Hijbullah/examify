<template>
    <Head title="Welcome" />
    
    <div class="relative flex items-top justify-center min-h-screen bg-gray-100  sm:items-center sm:pt-0">
        <div class="hidden fixed top-0 right-0 px-6 py-4 sm:block">
            <Link v-if="$page.props.auth.user" :href="route('students.dashboard')" class="text-sm text-gray-700 underline">
                Dashboard
            </Link>

            <template v-else>
                <Link :href="route('login')" class="text-sm text-gray-700 underline">
                    Login
                </Link>

                <Link :href="route('students.admission')" class="ml-4 text-sm text-gray-700 underline">
                    Apply For Admission
                </Link>
            </template>
        </div>

        <div class="max-w-6xl mx-auto sm:px-6 lg:px-8">
            <div class="flex justify-center pt-8 sm:justify-start sm:pt-0">
               <h2 class="text-5xl font-bold">Classify</h2>
            </div>
        </div>
    </div>
</template>

<script>
import { Head, Link } from '@inertiajs/inertia-vue3';

export default {
    components: {
      Head,
      Link,
    }
}
</script>