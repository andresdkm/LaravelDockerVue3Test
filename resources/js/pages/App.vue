<template>
    <el-container>
        <el-header></el-header>
        <el-main>
            <el-row>
                <Competition  @change="(v) =>viewCompetition(v)"></Competition>
            </el-row>
            <el-row>
                <el-col>
                    <CompetitionView  v-bind:competition="competition"></CompetitionView>
                </el-col>
            </el-row>
        </el-main>
        <el-footer></el-footer>
    </el-container>
</template>

<script>
import Competition from "../components/Competition";
import axios from "axios";
import {reactive, ref} from "vue";
import CompetitionView from "../components/CompetitionView";
export default {
    name: "App",
    components:{
        Competition,
        CompetitionView
    },
    setup() {
        const competition = ref({})
        const viewCompetition = (value) => {
            competition.value = value;
        }
        return {
            viewCompetition,
            competition
        }
    }
}
</script>

<style scoped>

</style>
