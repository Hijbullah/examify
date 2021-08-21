<template>
    <div class="leading-normal tracking-normal">
        <div class="flex flex-wrap">

            <AdminSidebar />

            <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen">

                <AdminNavbar />

                <main>
                    <div class="p-6 bg-gray-100 mb-20">
                        <slot></slot>
                    </div>
                </main>

            </div>
        </div>
    </div>
</template>

<script>
    import AdminNavbar from '@/Components/Backend/Navbar'
    import AdminSidebar from '@/Components/Backend/AdminSidebar'

    export default {
        components: {
            AdminNavbar,
            AdminSidebar, 
        }
    }
</script>
