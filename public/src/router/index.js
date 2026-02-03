import { createRouter, createWebHistory } from 'vue-router'
import Home from '../views/Home.vue'
import ChooseColors from '../views/ChooseColors.vue'
import ChooseValues from '../views/ChooseValues.vue'
import ChooseGameMode from '../views/ChooseGameMode.vue'
import ShowCards from '../views/ShowCards.vue'
import ShowSortedCards from '../views/ShowSortedCards.vue'

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  {
    path: '/choose-colors',
    name: 'ChooseColors',
    component: ChooseColors
  },
  {
    path: '/choose-values',
    name: 'ChooseValues',
    component: ChooseValues
  },
  {
    path: '/choose-game-mode',
    name: 'ChooseGameMode',
    component: ChooseGameMode
  },
  {
    path: '/show-cards',
    name: 'ShowCards',
    component: ShowCards
  },
  {
    path: '/show-sorted-cards',
    name: 'ShowSortedCards',
    component: ShowSortedCards
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router
