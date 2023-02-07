<template>
    <el-dialog
        v-model="visible"
        title="Ver"
        width="80%"
        :before-close="handleClose">
        <div v-if="competitionData">
            <el-row>
                <el-col>
                    <el-tabs
                        v-model="activeName"
                        type="card"
                        class="demo-tabs"
                        @tab-click="handleClick"
                    >
                        <el-tab-pane v-for="(item,key) in competitionData.time_frames" :label="item" :name="item">
                            <el-table :data="matches" style="width: 100%">
                                <el-table-column prop="hour" label="Hora" width="100"/>
                                <el-table-column label="" width="100">
                                    <template #default="scope">
                                        <el-avatar :size="50" :src="scope.row.home_team_crest" />
                                    </template>
                                </el-table-column>
                                <el-table-column prop="home_team" label="Local" />
                                <el-table-column label=" " width="50">
                                    <template #default="scope">
                                        <h2>Vs.</h2>
                                    </template>
                                </el-table-column>
                                <el-table-column prop="away_team" label="Visitante" />
                                <el-table-column label="" width="100">
                                    <template #default="scope">
                                        <el-avatar :size="50" :src="scope.row.away_team_crest" />
                                    </template>
                                </el-table-column>
                            </el-table>
<!--                            <h1>{{item}}</h1>
                            <el-row class="demo-avatar demo-basic">
                                <el-col :span="12">
                                    <div class="sub-title">circle</div>
                                    <el-avatar :size="50" :src="circleUrl" />
                                </el-col>
                                <el-col :span="12">
                                    <div class="sub-title">square</div>
                                    <el-avatar :size="50" :src="circleUrl" />
                                </el-col>
                            </el-row>-->
                        </el-tab-pane>
                    </el-tabs>
                </el-col>
            </el-row>

        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="visible = false">Aceptar</el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts">

import {computed, ref, toRefs, watch} from 'vue'
import {ElLoading, ElMessageBox, TabsPaneContext} from 'element-plus'
import axios from "axios";

export default {
    name: "CompetitionView",
    props: ['competition'],
    setup(props: any, context: any) {
        const visible = ref(false)
        const competitionData = ref(null);
        const matches = ref([]);
        const activeName = ref(null)

        const handleClose = (done: () => void) => {
            visible.value = false;
            context.emit("update:competition", null)
        }
        const loadCompetition = async (val: any) => {
            const loading = ElLoading.service({
                lock: true,
                text: 'Cargando',
                background: 'rgba(0, 0, 0, 0.7)',
            })
            let response = await axios.get(`api/competitions/${val.id}`);
            competitionData.value = response.data.data;
            activeName.value = response.data.data.time_frames[0];
            await getMatches(competitionData.value, activeName.value);
            visible.value = true;
            loading.close();
        };
        const getMatches = async (val: any, date: any) => {
            const loading = ElLoading.service({
                lock: true,
                text: 'Cargando',
                background: 'rgba(0, 0, 0, 0.7)',
            })
            let response = await axios.get(`api/competitions/${val.id}/matches/${date}`);
            matches.value = response.data.data;
            loading.close();
        };
        const competition = computed(() => props.competition);
        watch(competition, (newValue) => {
            loadCompetition(newValue);
        });

        const handleClick = (tab: TabsPaneContext, event: any) => {
            getMatches(competitionData.value, event.target.innerText);
        }
        return {
            visible,
            competition,
            handleClose,
            competitionData,
            activeName,
            handleClick,
            matches
        }
    }
}

</script>
<style scoped>
.dialog-footer button:first-child {
    margin-right: 10px;
}
 .el-carousel__item button{
     display: block;
     margin: auto;
 }

</style>
