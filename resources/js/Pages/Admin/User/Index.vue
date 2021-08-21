<template>
    <admin-layout>
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">All Admins and Teachers</h2>

            <div class="mt-5">
                <div class="mb-6 flex justify-end items-center">
                    <div>
                        <inertia-link 
                            :href="route('admin.users.create')" 
                            class="btn-main px-3 py-2 text-sm font-semibold uppercase tracking-widest"
                        >
                            Create
                        </inertia-link>
                    </div>
                </div>

                <div class="bg-white rounded shadow overflow-x-auto">
                    <table class="w-full whitespace-no-wrap">
                        <tr class="text-left">
                            <th class="px-6 pt-4 pb-4 font-normal">Name</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Email</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Type</th>
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Joined Date</th>
                            
                            <th class="px-6 pt-4 pb-4 font-normal text-center">Action</th>
                        </tr>

                        <tr v-for="user in users.data" :key="user.id" class="hover:bg-gray-100 focus-within:bg-gray-100">
                            <td class="border-t px-6 py-2">
                                {{ user.name }}
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ user.email }}
                            </td>
                           
                            <td class="border-t px-6 py-2 text-center">
                                <span v-if="user.type === 'admin'" class="inline-flex items-center px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full uppercase tracking-wider">Admin</span>
                                <span v-else class="inline-flex items-center px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full uppercase tracking-wider">Teacher</span>
                            </td>
                            <td class="border-t px-6 py-2 text-center">
                                {{ user.joined_at }}
                            </td>
                            
                            <td class="border-t px-6 py-2 text-center space-x-2">
                                <inertia-link 
                                    :href="route('admin.users.edit', user.id)" 
                                    class="inline-flex text-gray-800 hover:text-gray-500 focus:outline-none"
                                >
                                    <svg class="h-5 w-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </inertia-link>

                                <button 
                                    class="inline-flex text-red-500 hover:text-red-700 focus:outline-none"
                                    @click.prevent="deleteUser(route('admin.users.destroy', user.id))"
                                >

                                    <svg class="h-5 w-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />        
                                    </svg>

                                </button>
                            </td>
                        </tr>
                        <tr v-if="users.data.length === 0">
                            <td class="border-t px-6 py-4" colspan="4">No user found.</td>
                        </tr>
                    
                    </table>
                </div>

                <pagination v-if="users.data.length" :links="users.links" />
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
            Pagination
        },
        
        props: {
            users: Object,
        },

        methods: {
            deleteUser($url) {
                this.$inertia.delete($url, {
                    onBefore: () => confirm('Are you sure you want to delete?'),
                });
            }
        }
    }
</script>