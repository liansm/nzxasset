import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

import PerfOutline from '@/views/Perf/PerfOutline'
import HitchFrame from '@/views/Perf/HitchFrame'
import FrameDetail from '@/views/Perf/FrameDetail'

Vue.use(Router)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HelloWorld',
      component: HelloWorld
    },
    {
      path: '/perf/get_perf/:id/',
      name: 'PerfOutline',
      component: PerfOutline
    },
    {
      path: '/perf/get_hitch_frame/:id/',
      name: 'HitchFrame',
      component: HitchFrame
    },
    {
      path: '/perf/get_frame_detail/:id/',
      name: 'FrameDetail',
      component: FrameDetail
    }
  ]
})
