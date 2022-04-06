import Vue from 'vue'
import Router from 'vue-router'
import HelloWorld from '@/components/HelloWorld'

import PerfOutline from '@/views/PerfOutline'
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
      path: '/perf_home/:id/',
      name: 'PerfHome',
      component: PerfHome
    },
    {
      path: '/perf/PerfOutline/:id/',
      name: 'PerfOutline',
      component: PerfOutline
    },
    {
      path: '/perf/hitch_frame/:id/',
      name: 'HitchFrame',
      component: HitchFrame
    },
    {
      path: '/perf/frame_detail/:id/',
      name: 'FrameDetail',
      component: HitchFrame
    }
  ]
})
