<template>
    <vue-select 
        class="vue_select_box mt-1"
        :placeholder="placeholder"
        :options="options" 
        :label="label"
    >
    </vue-select>  
</template>

<script>
    import VueSelect from 'vue-select'
    import 'vue-select/dist/vue-select.css'

    export default {
        components: {
            VueSelect
        },
        props: {
            placeholder: {
                type: String,
                default: 'Select a Option'
            },
            label: String,
            options: Array
        }
    }
</script>

<style scoped>
    .vue_select_box >>> .vs__search::placeholder {
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
    }

</style>