<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Exam</h2>
            <div class="pt-5">
                <form @submit.prevent="update">
                    <div class="flex space-x-3">
                        <div class="w-1/2">
                            <jet-label for="course" value="Course" />
                            <jet-input id="course" type="text" class="mt-1 block w-full font-bold disabled:opacity-50" :value="exam.batch.course.name" disabled />
                        </div>

                        <div class="w-1/2">
                            <jet-label for="batch" value="Batch" />
                            <jet-input id="batch" type="text" class="mt-1 block w-full font-bold disabled:opacity-50" :value="exam.batch.name" disabled />
                        </div>
                    </div>

                    <div class="mt-4">
                        <jet-label for="name" value="Exam Name" />
                        <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="e.g. Model Test 01" />
                        <jet-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="mt-6 flex space-x-8">
                        <div class="w-1/2">
                            <div>
                                <jet-label value="Exam Category" />
                                <!-- <vue-select 
                                    class="vue_select_box mt-1"
                                    placeholder="Choose a Category"
                                    :options="categories" 
                                    label="name" 
                                    :reduce="category => category.id" 
                                    v-model="form.category"
                                >
                                </vue-select>                         -->
                                <jet-input-error :message="form.errors.category" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <p class="font-medium text-gray-700">Select Subjects</p>
                                
                                <div class="mt-2 flex items-center">
                                    <div class="flex-1">
                                        <!-- <vue-select 
                                            class="vue_select_box"
                                            placeholder="Choose a Subject"
                                            :disabled="disableSubjectSelection"
                                            :selectable="subject => !selectedSubjectIs.includes(subject.id)"
                                            :options="subjects" 
                                            label="name" 
                                            :reduce="subject => subject.id" 
                                            v-model="subjectId"
                                        >
                                        </vue-select>   -->
                                    </div>
                                    <div class="ml-2 w-20">
                                        <jet-input type="number" v-model="noOfQuestion" :disabled="isSelectSubject" class="block w-full text-sm disabled:opacity-50" placeholder="Ex. 10" />
                                    </div>
                                    <div class="ml-2">
                                        <jet-secondary-button @click.native.prevent="addSubject" :disabled="disableSubjectAddButton" class="text-sm disabled:opacity-50">Add</jet-secondary-button>
                                    </div>
                                </div>
                                <div class="mt-5 w-full h-64 space-y-3 overflow-y-auto">
                                    <div class="flex justify-between items-center pb-2 mb-2 border-b-2 border-gray-700">
                                        <p class="font-bold tracking-wider">Subjects </p>
                                        <p class="font-bold tracking-wider text-center">
                                            No of Question
                                            <span class="font-normal">({{ totalSelectedQuestions }} / {{ form.total_question ? form.total_question : '?' }})</span>
                                        </p>
                                    </div>
                                    <div v-for="(subject, index) in form.subjects" :key="subject.id" class="flex items-center justify-between">
                                        <div class="flex items-center">
                                            <button @click.prevent="removeSubject(index)" class="mr-2 inline-flex item-center text-red-400 hover:text-red-600 focus:outline-none">
                                                <svg class="w-5 h-5 stroke-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                            <p>{{ subject.name }}</p>
                                        </div>
                                        <div class="w-28 text-center">
                                            <p>{{ subject.no_of_question }}</p>
                                        </div>
                                    </div>
                                </div>
                                <jet-input-error :message="form.errors.subjects" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/2">
                            <div>
                                <jet-label for="exam_duration" value="Exam Duration" />
                                <jet-input id="exam_duration" type="number" min="0" class="mt-2 block w-full" v-model="form.exam_duration" placeholder="Exam Duration (in minute)..." />
                                <jet-input-error :message="form.errors.exam_duration" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <jet-label for="total_question" value="Total Question" />
                                <jet-input id="total_question" type="number" min="0" class="mt-2 block w-full" v-model="form.total_question" placeholder="Total Question..." />
                                <jet-input-error :message="form.errors.total_question" class="mt-2" />
                            </div>
                           
                            <div class="mt-3">
                                <jet-label for="exam_start_at" value="Exam Started At" />
                                <!-- <datetime
                                    id="exam_start_at"
                                    type="datetime"
                                    v-model="form.exam_start_at"
                                    :week-start="6"
                                    value-zone="Asia/Dhaka"
                                    input-class="mt-2 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    use12-hour
                                    auto
                                ></datetime> -->

                                <jet-input-error :message="form.errors.exam_start_at" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <jet-label for="exam_end_at" value="Exam Ended At" />

                                <!-- <datetime
                                    type="datetime"
                                    v-model="form.exam_end_at"
                                    :week-start="6"
                                    value-zone="Asia/Dhaka"
                                    input-class="mt-2 w-full border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                    use12-hour
                                    auto
                                ></datetime> -->
                                <jet-input-error :message="form.errors.exam_end_at" class="mt-2" />

                            </div>
                            <div class="mt-3">
                                <p class="font-medium text-gray-700">Negetive Mark</p>
                                <div class="mt-3 flex space-x-3 items-center">
                                    <div>
                                        <jet-label for="negative_mark_status" class="inline-flex items-center cursor-pointer">
                                            <div class="flex items-center">
                                                <jet-checkbox name="subjects" id="negative_mark_status" v-model="hasNegativeMark" class="cursor-pointer" />

                                                <div class="ml-2 text-base font-normal select-none">
                                                    Has Negative Mark
                                                </div>
                                            </div>
                                        </jet-label>
                                    </div>
                                    <div v-if="hasNegativeMark" class="w-1/3">
                                        <jet-input type="number" min="0" step="0.01" class="block w-full" v-model="negativeMark" placeholder="Negative Mark..." autocomplete="name" />
                                        <jet-input-error :message="form.errors.negative_mark" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="mt-4">
                        <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
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
    import JetCheckbox from '@/Components/Shared/FormElement/Checkbox'
    import JetButton from '@/Components/Shared/Button/Button'
    import JetSecondaryButton from '@/Components/Shared/Button/SecondaryButton'
    // import VueSelect from 'vue-select'
    // import { Datetime } from 'vue-datetime'

    // import 'vue-select/dist/vue-select.css'
    // import 'vue-datetime/dist/vue-datetime.css'

    export default {
        components: {
            AdminLayout,
            JetInput,
            JetInputError,
            JetLabel,
            JetCheckbox,
            JetButton,
            JetSecondaryButton,
            // VueSelect,
            // Datetime
        },
        props: {
            categories: Array,
            subjects: Array,
            exam: Object
        },

        data() {
            return {
                hasNegativeMark: this.exam.has_negative_mark,
                negativeMark: this.exam.negative_mark,
                selectedSubjectIs: [],
                subjectId: null,
                noOfQuestion: null,
                batches: [],

                form: this.$inertia.form({
                    category: this.exam.category,
                    name: this.exam.name,
                    total_question: this.exam.total_question,
                    exam_duration: this.exam.exam_duration,
                    exam_start_at: this.exam.exam_start_at,
                    exam_end_at: this.exam.exam_end_at,
                    subjects: this.exam.subjects,
                    has_negative_mark: this.exam.hasNegativeMark,
                    negative_mark: this.exam.negative_mark,
                    total_question_in_subjects: null
                }),
            }
        },

        computed: {
            disabledBatches() {
                return this.batches.length == 0 ? true : false; 
            },
            isSelectSubject() {
                return this.subjectId ? false : true;
            },
            totalSelectedQuestions() {
                return this.form.subjects.reduce((sum, current) => sum + parseInt(current.no_of_question), 0);
            },
            disableSubjectSelection() {
                return this.form.total_question == this.totalSelectedQuestions ? true : false;
            },
            disableSubjectAddButton() {
                return !this.subjectId || (this.noOfQuestion <= 0) ? true : false;
            }
        },

        methods: {
            addSubject() {
                if(!this.form.total_question) {
                    alert('You have to insert total no of Question first!');
                    return;
                }

                if(this.noOfQuestion > (this.form.total_question - this.totalSelectedQuestions)) {
                    alert(`You can not add ${this.noOfQuestion} questions. It will exced total no of questions!`);
                    return;
                }

                const subject = this.subjects.find(subject => subject.id == this.subjectId);

                this.form.subjects.push({
                    id: subject.id,
                    name: subject.name,
                    no_of_question: this.noOfQuestion 
                });

                this.selectedSubjectIs.push(subject.id);
                this.subjectId = null;
                this.noOfQuestion = null;
            },
            removeSubject(index) {
                this.form.subjects.splice(index, 1);
                this.selectedSubjectIs.splice(index, 1);
            },
            update(){
                if(this.hasNegativeMark) {
                    this.form.has_negative_mark = true;
                    this.form.negative_mark = this.negativeMark;
                }
                this.form.total_question_in_subjects = this.totalSelectedQuestions;

                this.form.put(route('admin.exams.update', this.exam.exam_code), {
                    preserveScroll: true,
                });
            },  
            goBack() {
                this.$inertia.visit(route('admin.exams.show', this.exam.exam_code));
            }
        },

        watch: {
            'form.course'(id) {
                this.form.batch = null;
                this.batches = [];

                if(id) {
                    axios.get(`/admin/get-batches/${id}`)
                        .then(response => {
                            this.batches = response.data;
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                }
            },
            hasNegativeMark() {
                if(!this.hasNegativeMark) {
                    this.form.has_negative_mark = false;
                    this.form.negative_mark = null;
                    this.negativeMark = 0.25;
                }
            },
            subjectId() {
                this.noOfQuestion = null;
            }
        },

        mounted() {
            this.selectedSubjectIs = this.exam.subjects.map(subject => subject.id);
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