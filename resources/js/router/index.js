import { createRouter, createWebHistory } from 'vue-router';
import CharacterList from '../components/CharacterList.vue';
import CharacterDetail from '../components/CharacterDetail.vue';

const routes = [
  {
    path: '/',
    name: 'CharacterList',
    component: CharacterList
  },
  {
    path: '/characters/:id',
    name: 'CharacterDetail',
    component: CharacterDetail,
    props: true
  }
];

const router = createRouter({
  history: createWebHistory(),
  routes
});

export default router;
