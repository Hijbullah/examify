<template>
    <div class="leading-normal tracking-normal">
        <div class="flex flex-wrap">

            <TeacherSidebar />

            <div class="w-full bg-gray-100 pl-0 lg:pl-64 min-h-screen">

                <TeacherNavbar />

                <main>
                    <div class="p-6 bg-gray-100 mb-20">
                        <slot></slot>
                    </div>
                </main>

                <portal-target name="modal" multiple></portal-target>

            </div>
        </div>
    </div>
</template>

<script>
    import TeacherNavbar from '@/Components/Backend/Navbar'
    import TeacherSidebar from '@/Components/Backend/TeacherSidebar'

    export default {
        components: {
            TeacherNavbar,
            TeacherSidebar, 
        }
    }
</script>
