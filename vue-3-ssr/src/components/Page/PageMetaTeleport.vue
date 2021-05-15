<template>
    <teleport to="head">
        <PageMeta />
    </teleport>
</template>

<script lang="ts">
import { Vue } from "vue-class-component";

export default class PageMetaTeleport extends Vue {}
</script>