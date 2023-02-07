<template>
    <el-col
        v-for="(competition, index) in competitions"
        :key="index"
        :span="8">
        <CompetitionCard :competition="competition" @change.once="(v)=>onChange(v)"></CompetitionCard>
    </el-col>
</template>

<script type="ts">
import {inject, ref, toRefs} from "vue";
import axios from "axios";
import CompetitionCard from "../components/CompetitionCard";
import CompetitionView from "./CompetitionView.vue";
import {ElLoading} from "element-plus";

export default {
    name: "Competition",
    components: {
        CompetitionView,
        CompetitionCard
    },
    setup(props, context) {
        const competitions = ref([])
        const getAll = async () => {
            const loading = ElLoading.service({
                lock: true,
                text: 'Cargando',
                background: 'rgba(0, 0, 0, 0.7)',
            })
            let response = await axios.get('api/competitions');
            competitions.value = response.data.data;
            loading.close()
        };
        const onChange = ($event) => {
            context.emit("change", $event)
        }
        getAll();
        return {
            competitions,
            onChange
        }
    }
}
</script>

<style scoped>

</style>
