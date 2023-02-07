<template>
    <el-card :body-style="{ padding: '0px' }">
        <el-image class="image" :src="competition.emblem" style="width: 100%; height: 100px" :fit="'contain'">
        </el-image>
        <div style="padding: 14px">
            <span>{{competition.name}}</span>
            <div class="bottom">
                <time class="time">Fin: {{competition.end_date}}</time>
                <el-button type="primary" round class="button" @click="onClick()">Ver</el-button>
            </div>
        </div>
    </el-card>
</template>

<script lang="ts">
import { Picture as IconPicture } from '@element-plus/icons-vue'
import {toRefs} from "vue";
import {ElMessageBox} from "element-plus";
export default {
    name: "CompetitionCard",
    props: ['competition'],
    setup(props: any, context: any) {
        const { competition } = toRefs(props)
        const onClick = () => {
            context.emit("change", competition.value)
        }
        return {
            onClick,
            competition
        }
    }
}
</script>

<style scoped>
.time {
    font-size: 12px;
    color: #999;
}

.bottom {
    margin-top: 13px;
    line-height: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.button {
    padding: 0;
    min-width: 150px;
    min-height: auto;
}

.image {
    width: 100%;
    display: block;
}
</style>
