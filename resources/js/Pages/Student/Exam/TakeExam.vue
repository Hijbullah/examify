<template>
    <student-layout>
        <div class="py-8">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col justify-center items-center">
                    <h2 class="font-bold uppercase tracking-widest">{{ exam.category }}: {{ exam.name }}</h2>
                    <div class="flex justify-between items-center space-x-12">
                        <p>Marks: {{ exam.total_question }}</p>
                        <p>Time: {{ exam.duration }}</p>
                    </div>
                </div>
                <div class="w-2/3 mx-auto mt-12">
                     <div class="flex justify-end items-center mb-6">
                        <the-timer 
                            :duration="exam.duration" 
                            @times-up="examTimeEnded"
                        />
                    </div>
                    <div v-if="!isExamFinish">
                        <div class="ql-editor">
                            <div class="flex">
                                <p class="mr-4 text-xl font-bold">{{ currenQuestion.serial }}.</p>
                                <div v-html="currenQuestion.question"></div>
                            </div>
                            <div class="mt-3 pl-8 space-y-3">
                                <div v-for="(option, key, index) in currenQuestion.options" :key="index" class="flex items-start">
                                    <div class="flex items-center">
                                        <input v-model="selectedOption" :value="key" type="radio" class="h-4 w-4 text-indigo-600 transition duration-150 ease-in-out cursor-pointer">
                                        <span class="ml-2">{{ key }})</span>
                                    </div>
                                    <div v-html="option" class="ml-3"></div>
                                </div>
                            </div>
                        </div>
                        <div class="flex justify-between items-center mt-12">
                            <div class="space-x-2">
                                <button 
                                    @click.prevent="setNeverQuestion"
                                    class="px-3 py-1 bg-red-700 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-red-600 focus:outline-none"
                                >Skip</button>
                                <button 
                                    @click.prevent="setLaterQuestion"
                                    class="px-3 py-1 bg-yellow-500 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-yellow-400 focus:outline-none"
                                >Later</button>
                                <button 
                                    @click.prevent="selectAnswer"
                                    :disabled="!this.selectedOption"
                                    class="px-3 py-1 bg-indigo-700 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-indigo-600 focus:outline-none disabled:opacity-50"
                                >Next</button>
                            </div>
                            <button 
                                @click.prevent="finishExam"
                                class="px-3 py-1 bg-green-600 text-white text-sm font-semibold uppercase tracking-widest rounded hover:bg-green-500 focus:outline-none"
                                :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                            >Finish</button>
                        </div>
                    </div>
                    <div v-else class="flex flex-col justify-center items-center bg-white px-4 py-12">
                        <p class="text-sm font-bold">No question Left. You can Finish Now!</p>
                        <button 
                            @click.prevent="finishExam"
                            class="mt-5 px-3 py-2 bg-green-600 text-white text-sm font-bold uppercase tracking-widest rounded hover:bg-green-500 focus:outline-none"
                            :class="{ 'opacity-25': form.processing }" :disabled="form.processing"
                        >Finish</button>
                    </div>
                </div>
                <div class="flex justify-center items-center mt-12 divide-x-2 divide-y-2">
                    <div
                        v-for="question in questions"
                        :key="question.serial"  
                        :class="question.cssClass"
                        class="h-8 w-8 flex justify-center items-center font-semibold rounded-full border-2 border-gray-900"
                    >{{ question.serial }}</div>
                </div>
                <p class="mt-8 text-center text-red-600 font-semibold">* Don't Reload, close or minimize the brower or Change the Tab. Exam will autometically end if you do that.</p>
            </div>
        </div>
    </student-layout>
</template>

<script>
    import StudentLayout from '@/Layouts/StudentLayout'
    import TheTimer from './TheTimer'
    import 'katex/dist/katex.min.css'
    // import 'vue2-editor/dist/vue2-editor.css'


    export default {
        components: {
            StudentLayout,
            TheTimer
        },
        props: {
            result_code: String,
            exam: Object,
            questions: Array
        },
        data() {
            return {
                removeStartEventListener: null,
                isExamFinish: false,

                selectedOption: null,
                neverQuestion: 0,

                allQuestions: [],
                questionData: [],
                laterQuestions: [],
                currenQuestion: [],
                form: this.$inertia.form({
                    result_code: this.result_code,
                    answerSheet: [],
                })
            }
        },

        methods: {
            // select answer
            selectAnswer(answer) {
                this.form.answerSheet.push({
                    id: this.currenQuestion.id,
                    answer: this.selectedOption,
                });
                this.changeQuestonStatus('selected');
                this.selectedOption = null;
                this.getNextQuestion();
            },

            // next question
            getNextQuestion() {
                if(this.questionData.length >=1) {
                    this.currenQuestion = this.questionData.pop();
                }else if(this.laterQuestions.length >= 1) {
                    this.questionData = this.laterQuestions.reverse();
                    this.laterQuestions = [];
                    this.currenQuestion = this.questionData.pop();
                }else{
                    this.isExamFinish = true;
                }
            },

            // later
            setLaterQuestion() {
                this.selectedOption = null;
                this.laterQuestions.push(this.currenQuestion);
                this.changeQuestonStatus('later');
                this.getNextQuestion();
            },

            //never
            setNeverQuestion() {
                this.selectedOption = null;
                this.neverQuestion += 1;
                this.changeQuestonStatus('skip');
                this.getNextQuestion();
            },

            finishExam() {
                this.removeStartEventListener();
                this.form.post(route('students.exams.finish', this.exam.exam_code));
            },

            examTimeEnded() {
                this.finishExam();
            },
            changeQuestonStatus(status) {
                let question = this.questions.find(question => question.serial == this.currenQuestion.serial);
                if(status == 'selected') {
                    question.cssClass = 'bg-green-600 text-white';
                } else if(status == 'skip') {
                    question.cssClass = 'bg-red-600 text-white';
                } else {
                    question.cssClass = 'bg-yellow-600 text-white';
                }
            }
        },

        mounted() {
            this.allQuestions = this.questions.map((question, index) => {
                question['serial'] = index + 1; 
                question['cssClass'] = '';
                return question;
            });

            this.questionData = Array.from(this.questions).reverse();
            this.currenQuestion = this.questionData.pop();

            this.$once(
                'hook:destroyed',
                this.removeStartEventListener = this.$inertia.on('start', (event) => {
                    if (!confirm('Want to navigate away, Are you sure? Your exam will end autometically')) {
                        event.preventDefault();
                    }
                })
            );

            // document.addEventListener("visibilitychange", this.logSomething)
            //     this.$once("hook:beforeDestroy", () => {
            //     document.removeEventListener("visibilitychange", this.logSomething);
            // });
        },
        
    }
</script>
