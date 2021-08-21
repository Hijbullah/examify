<template>
    <div id="app">
        <VueEditor
            v-model="content"
            use-custom-image-handler
            @imageRemoved="handleImageRemoved"
            @imageAdded="handleImageAdded"
        />
    </div>
</template>

<script>
    import axios from "axios";
    import Quill from "quill";

    /**
     * Customize image functionality so we can add an `id` attribute
     */
    const BlockEmbed = Quill.import("blots/block/embed");

    class ImageBlot extends BlockEmbed {
    static create(value) {
        const node = super.create();
        node.setAttribute("src", value.url);
        node.setAttribute("id", value.id);
        node.setAttribute("data-deletehash", value["data-deletehash"]);

        return node;
    }

    static value(node) {
        return {
        url: node.getAttribute("src"),
        id: node.getAttribute("id"),
        "data-deletehash": node.getAttribute("data-deletehash")
        };
    }
    }

    ImageBlot.blotName = "image";
    ImageBlot.tagName = "img";
    Quill.register(ImageBlot);

    const CLIENT_ID = "993793b1d8d3e2e";

    export default {
    name: "App",
    data: () => ({
        content: ""
    }),

    methods: {
        deleteImage(deleteId) {
        axios({
            url: `https://api.imgur.com/3/image/${deleteId}`,
            method: "DELETE",
            headers: { Authorization: "Client-ID " + CLIENT_ID }
        }).then(result => console.log("DELETE RESULT: ", result));
        },

        handleImageRemoved(image) {
        console.log("Removed Image -> image: ", image);
        const deleteId = image["data-deletehash"];
        this.deleteImage(deleteId);
        },

        handleImageAdded(file, Editor, cursorLocation) {
        const formData = new FormData();
        formData.append("image", file);

        axios({
            url: "https://api.imgur.com/3/image",
            method: "POST",
            headers: { Authorization: "Client-ID " + CLIENT_ID },
            data: formData
        })
            .then(result => {
            console.log(result.data.data);
            const { link, id, deletehash } = result.data.data;

            Editor.insertEmbed(
                cursorLocation,
                "image",
                {
                id,
                url: link,
                "data-deletehash": deletehash
                },
                Quill.sources.USER
            );
            })
            .catch(err => console.log(err));
        }
    }
    };
</script>