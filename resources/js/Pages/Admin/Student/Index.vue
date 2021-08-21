<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Students</h2>

            <div class="mt-5">
                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <tr class="text-left">
                            <th class="px-6 pt-4 pb-4 font-normal">Name</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Email</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Course</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Batch</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Approve At</th>
                            
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Action</th>
                        </tr>

                        <tr v-for="student in students.data" :key="student.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ student.name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ student.email }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ student.course.name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ student.batch.name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ student.approval_date }}
                            </td>
                        
                            
                            <td class="border-t px-6 py-2 text-center space-x-2">
                                <inertia-link 
                                    :href="route('admin.students.show', student.id)" 
                                    class="inline-flex text-gray-800 hover:text-gray-500 focus:outline-none"
                                >
                                    <svg class="w-5 h-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </inertia-link>

                                <!-- <button 
                                    class="inline-flex text-red-500 hover:text-red-700 focus:outline-none"
                                    @click.prevent="deleteBatch(route('admin.batches.destroy', batch.slug))"
                                >

                                    <svg class="h-5 w-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />        
                                    </svg>

                                </button> -->
                            </td>
                        </tr>
                        <tr v-if="students.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="4">No students found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination v-if="students.data.length" :links="students.links" />
            </div>
        </div>
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import Pagination from '@/Components/Shared/Pagination'

    export default {
        components: {
            AdminLayout,
            Pagination,
        },
        props: {
            students: Object,
        }
    }
</script>