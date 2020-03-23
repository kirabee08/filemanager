<template>
    <div id="ButtonComponent">
        <span v-on:click="$emit('buttonEvent')" class="text_button">{{ title }}</span>
    </div>
</template>

<script>
    export default {
        name: "ButtonComponent",
        props: {
            title: String
        }
    }
</script>

<style scoped>
    .text_button {
        color: blue;
    }
    .text_button:hover {
        color: #5f00ff;
        cursor: pointer;
        text-decoration: underline;
    }
</style>