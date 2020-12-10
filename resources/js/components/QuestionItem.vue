<template>
    <div class="question-item d-flex align-items-center">
        <div>
            <div class="question-item-dot" />
            <div>
                {{ question }}
            </div>
        </div>
        <div>

        </div>
        <div v-if="active">
            {{ answer }}
        </div>
    </div>
</template>

<script>
export default {
    name: "QuestionItem",
    props: ['question', 'answer', 'active']
}
</script>

<style scoped>
.question-item {
    padding-left: 32px;
    padding-right: 28px;
    width: 100%;
    height: 62px;
    background: #FFFFFF;
    box-shadow: 0 16px 24px rgba(0, 0, 0, 0.06), 0 2px 6px rgba(0, 0, 0, 0.04), 0 0 1px rgba(0, 0, 0, 0.04);
}
.question-item-dot {
    width: 8px;
    height: 8px;
    border-radius: 8px;
    background: #004BC1;
    margin-right: 16px;
}
</style>
