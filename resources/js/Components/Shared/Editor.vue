<template>
   
    <editor
        v-model="editorContent"
        class="bg-white px-4 py-6 border-2 border-gray-600"
        api-key="jzss5lx0xus0qk2ujd67ma86css4jujfayislylc1mirow44"
        :init="{
            toolbar: false,
            menubar: false,
            inline: true,
            plugins: [
                'autolink',
                'link',
                'lists',
                'media',
                'image',
                'imagetools',
                'quickbars',
            ],
           
            automatic_uploads: true,
            images_reuse_filename: true,
            images_upload_url: route('images.upload'),
            
            quickbars_insert_toolbar: 'image media',
            quickbars_selection_toolbar: 'bold italic underline | formatselect | blockquote quicklink',
        }"
    />

    
</template>

<script>
    import Editor from '@tinymce/tinymce-vue'

    export default {
        components: {
            'editor': Editor
        },
        props: {
            editorContent: String
        },
        emits: ['update:editorContent'],

        watch: {
            editorContent(value) {
                this.$emit('update:editorContent', value);
            }
        }

    }
</script>
