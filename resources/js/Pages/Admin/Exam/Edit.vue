<template>
    <admin-layout>  
        <div>
            <h2 class="text-xl text-gray-900 font-semibold border-b-2 border-gray-900">Edit Exam</h2>
            <div class="pt-5">
                <form @submit.prevent="update">
                    <div class="flex space-x-3">
                        <div class="w-1/2">
                            <app-label for="course" value="Course" />
                            <app-input id="course" type="text" class="mt-1 block w-full font-bold disabled:opacity-50" :value="exam.batch.course.name" disabled />
                        </div>

                        <div class="w-1/2">
                            <app-label for="batch" value="Batch" />
                            <app-input id="batch" type="text" class="mt-1 block w-full font-bold disabled:opacity-50" :value="exam.batch.name" disabled />
                        </div>
                    </div>

                    <div class="mt-4">
                        <app-label for="name" value="Exam Name" />
                        <app-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" placeholder="e.g. Model Test 01" />
                        <app-input-error :message="form.errors.name" class="mt-2" />
                    </div>

                    <div class="mt-6 flex space-x-8">
                        <div class="w-1/2">
                            <div>
                                <app-label value="Exam Category" />
                                <Multiselect
                                    v-model="form.category"
                                    :options="categories"
                                    :searchable="true"
                                    placeholder="Choose a Category"
                                /> 
                                <app-input-error :message="form.errors.category" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <p class="font-medium text-gray-700">Select Subjects</p>
                                
                                <div class="mt-2 flex items-center">
                                    <div class="flex-1">
                                        <Multiselect
                                            v-model="subjectId"
                                            :options="subjects"
                                            :searchable="true"
                                            :disabled="disableSubjectSelection"
                                            placeholder="Choose a Subject"
                                        /> 
                                    </div>
                                    <div class="ml-2 w-20">
                                        <app-input type="number" v-model="noOfQuestion" :disabled="isSelectSubject" class="block w-full text-sm disabled:opacity-50" placeholder="Ex. 10" />
                                    </div>
                                    <div class="ml-2">
                                        <app-secondary-button @click.prevent="addSubject" :disabled="disableSubjectAddButton" class="text-sm disabled:opacity-50">Add</app-secondary-button>
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
                                            <button @click.prevent="removeSubject(index, subject.id)" class="mr-2 inline-flex item-center text-red-400 hover:text-red-600 focus:outline-none">
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
                                <app-input-error :message="form.errors.subjects" class="mt-2" />
                            </div>
                        </div>

                        <div class="w-1/2">
                            <div>
                                <app-label for="exam_duration" value="Exam Duration" />
                                <app-input id="exam_duration" type="number" min="0" class="mt-2 block w-full" v-model="form.exam_duration" placeholder="Exam Duration (in minute)..." />
                                <app-input-error :message="form.errors.exam_duration" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <app-label for="total_question" value="Total Question" />
                                <app-input id="total_question" type="number" min="0" class="mt-2 block w-full" v-model="form.total_question" placeholder="Total Question..." />
                                <app-input-error :message="form.errors.total_question" class="mt-2" />
                            </div>
                           
                            <div class="mt-3">
                                <app-label for="exam_start_at" value="Exam Started At" />
                                <app-input id="exam_start_at" type="datetime-local" v-model="form.exam_start_at" />
                                <app-input-error :message="form.errors.exam_start_at" class="mt-2" />
                            </div>
                            <div class="mt-3">
                                <app-label for="exam_end_at" value="Exam Ended At" />
                                <app-input id="exam_end_at" type="datetime-local" v-model="form.exam_end_at" />
                                <app-input-error :message="form.errors.exam_end_at" class="mt-2" />

                            </div>
                            <div class="mt-3">
                                <p class="font-medium text-gray-700">Negetive Mark</p>
                                <div class="mt-3 flex space-x-3 items-center">
                                    <div>
                                        <app-label for="negative_mark_status" class="inline-flex items-center cursor-pointer">
                                            <div class="flex items-center">
                                                <app-checkbox name="subjects" id="negative_mark_status" v-model:checked="hasNegativeMark" class="cursor-pointer" />

                                                <div class="ml-2 text-base font-normal select-none">
                                                    Has Negative Mark
                                                </div>
                                            </div>
                                        </app-label>
                                    </div>
                                    <div v-if="hasNegativeMark" class="w-1/3">
                                        <app-input type="number" min="0" step="0.01" class="block w-full" v-model="negativeMark" placeholder="Negative Mark..." autocomplete="name" />
                                        <app-input-error :message="form.errors.negative_mark" class="mt-2" />
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                   
                    <div class="mt-4">
                        <app-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                            Update
                        </app-button>
                        <app-secondary-button class="ml-2" @click.prevent="goBack">
                            Back
                        </app-secondary-button>
                    </div>
                </form>
            </div>
        </div>
       
    </admin-layout>
</template>

<script>
    import AdminLayout from '@/Layouts/AdminLayout'
    import AppInput from '@/Components/Shared/FormElement/Input'
    import AppInputError from '@/Components/Shared/FormElement/InputError'
    import AppLabel from '@/Components/Shared/FormElement/Label'
    import AppCheckbox from '@/Components/Shared/FormElement/Checkbox'
    import AppButton from '@/Components/Shared/Button/Button'
    import AppSecondaryButton from '@/Components/Shared/Button/SecondaryButton'
    import Multiselect from '@vueform/multiselect'

    import '@vueform/multiselect/themes/default.css'

    export default {
        components: {
            AdminLayout,
            AppInput,
            AppInputError,
            AppLabel,
            AppCheckbox,
            AppButton,
            AppSecondaryButton,
            Multiselect
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

                const subject = this.subjects.find(subject => subject.value == this.subjectId);

                this.form.subjects.push({
                    id: subject.value,
                    name: subject.label,
                    no_of_question: this.noOfQuestion 
                });

                this.selectedSubjectIs.push(subject.value);
                this.subjects.find(subject => subject.value == this.subjectId).disabled = true;
                this.subjectId = null;
                this.noOfQuestion = null;
            },
            removeSubject(index, id) {
                this.form.subjects.splice(index, 1);
                this.selectedSubjectIs.splice(index, 1);
                this.subjects.find(subject => subject.value == id).disabled = false;
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
                this.$inertia.visit(route('admin.exams.index'));
            }
        },

        watch: {
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