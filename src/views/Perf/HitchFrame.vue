<template>
  <el-table :data=hitchFrames max-height="1000" style="width:100%">
    <el-table-column prop="FrameCount" label="第几帧" width="100"></el-table-column>
    <el-table-column prop="FrameTime" label="帧时间(ms)" width="100"></el-table-column>

    <el-table-column label="时间统计(ms)" align="center" width="400">
      <el-table-column prop="GameThreadTime" label="Game时间" width="100"></el-table-column>
      <el-table-column prop="RenderThreadTime" label="Render时间" width="100"></el-table-column>
      <el-table-column prop="RHIThreadTime" label="RHI时间" width="100"></el-table-column>
      <el-table-column prop="GPUTime" label="GPU时间" width="100"></el-table-column>
    </el-table-column>

    <el-table-column label="DrawCall" align="center" width="500">
      <el-table-column prop="RHI_DrawCalls" label="Total" width="70"></el-table-column>
      <el-table-column prop="DrawCall_HZB" label="HZB" width="70"></el-table-column>
      <el-table-column prop="DrawCall_PrePass" label="Prepass" width="80"></el-table-column>
      <el-table-column prop="DrawCall_BasePass" label="Basepass" width="90"></el-table-column>
      <el-table-column prop="DrawCall_ShadowDepths" label="GPU" width="70"></el-table-column>
      <el-table-column prop="DrawCall_ParticleSimulation" label="Particle" width="90"></el-table-column>
    </el-table-column>

    <el-table-column prop="FrameEvent" label="Event" width="100"></el-table-column>
    <el-table-column prop="Pos" label="坐标" width="200"></el-table-column>
  </el-table>
</template>

<script>

export default{
  data () {
    return {
      currentRunID: parseInt(this.$route.params.id),
      hitchFrames: []
    }
  },

  mounted () {
    this.loadData()
  },

  methods: {
    async loadData () {
      let dataURL = '/perfapi/get_hitch_frame.php?run_id=' + this.currentRunID
      const {data: res} = await this.$http.get(dataURL)
      this.hitchFrames = res
      this.hitchFrames.forEach(item => {
        item.FrameTime = item.FrameTime.toFixed(2)
        item.GameThreadTime = item.GameThreadTime.toFixed(2)
        item.RenderThreadTime = item.RenderThreadTime.toFixed(2)
        item.RHIThreadTime = item.RHIThreadTime.toFixed(2)
        item.GPUTime = item.GPUTime.toFixed(2)
        item.Pos = '(' + item.View_PosX + ',' + item.View_PosY + ',' + parseInt(item.View_PosZ) + ')'
      })
    }
  },

  filters: {
    numberFilter (value) {
      return value.toFixed(2)
    }
  }
}

</script>

<style>
</style>
