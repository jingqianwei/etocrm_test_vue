<template>
    <div>
        <el-button @click="visible = true">Button</el-button>
        <el-dialog :visible.sync="visible" title="Hello world">
            <p>Try Element</p>
        </el-dialog>
        <text-content></text-content>
        <cart-content></cart-content>
        <tab-content></tab-content>
        <checkbox-content></checkbox-content>
        <cascader-content></cascader-content>
    </div>
</template>

<script>
    Vue.component('text-content', require('./page/TextContent.vue'));
    Vue.component('cart-content', require('./page/CartContent.vue'));
    Vue.component('tab-content', require('./page/TabContent.vue'));
    Vue.component('checkbox-content', require('./page/CheckboxContent.vue'));
    Vue.component('cascader-content', require('./page/CascaderContent.vue'));
    export default {
        //注意传的值不能为空
        data() {
            return { visible: false }
        }
    }
</script>
