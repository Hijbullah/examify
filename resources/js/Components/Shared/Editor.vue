<template>
    <div class="editor-wrapper bg-white" :class="as">
        <vue-editor 
            ref="vue2editor"
            :customModules="customModulesForEditor"
            :editorOptions="editorSettings"
            v-model="editorContent"
            useCustomImageHandler
            @image-added="handleImageAdded"
            :editor-toolbar="customToolbar"
        ></vue-editor>
    </div>
</template>

<script>
    import { VueEditor } from 'vue2-editor'
    import BlotFormatter from 'quill-blot-formatter'
    import katex from 'katex'
    import 'katex/dist/katex.min.css'
 

    export default {
        components: {
            VueEditor
        },
        props: {
            content: String,
            as: String
        },
        data() {
            return {
                customToolbar: [
                    [{ 'size': ['small', false, 'large'] }],
                    ['bold', 'italic', 'underline'],
                    [
                        { align: "" },
                        { align: "center" },
                        { align: "right" },
                        { align: "justify" }
                    ],
                    ['image', 'formula'],   
                ],
                customModulesForEditor: [
                    { alias: 'blotFormatter', module: BlotFormatter }, 
                ],
                editorSettings: {
                    modules: {
                        blotFormatter: {},
                    }
                }
            }
        },
        computed: {
            editorContent: {
                get() { return this.content},
                set(updatedContent) { this.$emit('update:content', updatedContent) }
            },
        },
        methods: {
            handleImageAdded(file, Editor, cursorLocation) {
                const CLIENT_ID = '993793b1d8d3e2e'
                var formData = new FormData();
                formData.append('file', file);

                axios.post(route('images.upload'), formData)
                    .then(({ data }) => {
                        Editor.insertEmbed(cursorLocation, 'image', data.url);
                    })
                    .catch((err) => {
                        console.log(err);
                    });  
            }
        },
        mounted() {
            window.katex = katex;
        }
    };
</script>

<style scoped>
    .editor-wrapper.question :deep(.ql-editor) {
		min-height: 125px;
	}
    .editor-wrapper.options :deep(.ql-editor) {
		height: 80px;
		min-height: 80px;
        overflow-y: auto;
	}
   
    .editor-wrapper :deep(.ql-snow .ql-tooltip[data-mode="formula"]) {
        top: 5px !important;
        left: 50% !important;
        transform: translateX(-50%);
    }
    .editor-wrapper :deep(.ql-snow .ql-tooltip[data-mode="formula"] input[type=text]) {
        height: 50px;
        width: 210px;
    }
</style>