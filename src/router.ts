import type { RouteRecordRaw } from 'vue-router'
import { useAuthStore } from './auth.js'
import { createRouter, createWebHistory } from 'vue-router'
import Dashboard from './views/Dashboard.vue'
import Login from './views/Login.vue'

const routes: RouteRecordRaw[] = [

  /* LOGIN && REGISTER */
  {
    path: '/login',
    name: 'Login',
    component: Login,
    meta: { layout: 'empty' },
  },


  /* SETTINGS */

  //PROFILE
  {
    path: '/profile/edit',
    name: 'Profile-Edit',
    component: () => import('./views/Profile/Edit.vue'),
  },

   //PROFILE
   {
    path: '/settings/edit',
    name: 'Settings-Edit',
    component: () => import('./views/Settings/Edit.vue'),
  },

  /* RUTAS DE SISTEMA DE INVENTARIO */

  //DASHBOARD
  {
    path: '/',
    name: 'Dashboard',
    component: Dashboard,
  },

  //BUDGET
  {
    path: '/budgets',
    name: 'Budget',
    component: () => import('./views/Budget/Index.vue'),
  },
  {
    path: '/budgets/create',
    name: 'Budget-Create',
    component: () => import('./views/Budget/Create.vue'),
  },

  //CUSTOMERS
  {
    path: '/customers',
    name: 'Customers',
    component: () => import('./views/Customers/Index.vue'),
  },
  {
    path: '/customers/create',
    name: 'Customers-Create',
    component: () => import('./views/Customers/Create.vue'),
  },
  {
    path: '/customers/edit/:id',
    name: 'Customers-Edit',
    component: () => import('./views/Customers/Edit.vue'),
  },

  //PROVIDERS
  {
    path: '/providers',
    name: 'Providers',
    component: () => import('./views/Providers/Index.vue'),
  },
  {
    path: '/providers/create',
    name: 'Providers-Create',
    component: () => import('./views/Providers/Create.vue'),
  },
  {
    path: '/providers/edit/:id',
    name: 'Providers-Edit',
    component: () => import('./views/Providers/Edit.vue'),
  },

  //CELLARS
  {
    path: '/cellars',
    name: 'Cellars',
    component: () => import('./views/Cellars/Index.vue'),
  },
  {
    path: '/cellars/create',
    name: 'Cellars-Create',
    component: () => import('./views/Cellars/Create.vue'),
  },
  {
    path: '/cellars/edit/:id',
    name: 'Cellars-Edit',
    component: () => import('./views/Cellars/Edit.vue'),
  },

  //PRODUCTS
  {
    path: '/products',
    name: 'Products',
    component: () => import('./views/Products/Index.vue'),
  },
  {
    path: '/products/create',
    name: 'Products-Create',
    component: () => import('./views/Products/Create.vue'),
  },
  {
    path: '/products/edit/:id',
    name: 'Products-Edit',
    component: () => import('./views/Products/Edit.vue'),
  },

  //MOVEMENTS
  {
    path: '/movements',
    name: 'Movements',
    component: () => import('./views/Movements/Index.vue'),
  },
  {
    path: '/movements/create',
    name: 'Movements-Create',
    component: () => import('./views/Movements/Create.vue'),
  },
  {
    path: '/movements/show/:id',
    name: 'Movements-Show',
    component: () => import('./views/Movements/Show.vue'),
  },

  //TRANSFERS
  {
    path: '/transfers',
    name: 'Transfers',
    component: () => import('./views/Transfers/Index.vue'),
  },
  {
    path: '/transfers/create',
    name: 'Transfers-Create',
    component: () => import('./views/Transfers/Create.vue'),
  },
  {
    path: '/transfers/show/:id',
    name: 'Transfers-Show',
    component: () => import('./views/Transfers/Show.vue'),
  },

  /* VENTAS, COMPRAS Y DEVOLUCIONES */

  //INVOICES
  {
    path: '/invoices',
    name: 'Invoices',
    component: () => import('./views/Invoices/Index.vue'),
  },
  {
    path: '/invoices/create',
    name: 'Invoices-Create',
    component: () => import('./views/Invoices/Create.vue'),
  },
  {
    path: '/invoices/show/:id',
    name: 'Invoices-Show',
    component: () => import('./views/Invoices/Show.vue'),
  },

  //SALES
  {
    path: '/sales',
    name: 'Sales',
    component: () => import('./views/Sales/Index.vue'),
  },
  {
    path: '/sales/create',
    name: 'Sales-Create',
    component: () => import('./views/Sales/Create.vue'),
  },
  {
    path: '/sales/show/:id',
    name: 'Sales-Show',
    component: () => import('./views/Sales/Show.vue'),
  },

  //REFUDS
  {
    path: '/refunds',
    name: 'Refunds',
    component: () => import('./views/Refunds/Index.vue'),
  },
  {
    path: '/refunds/show/:id',
    name: 'Refunds-Show',
    component: () => import('./views/Refunds/Show.vue'),
  },
  {
    path: '/refunds/sales/:id',
    name: 'Refunds-Sales-Create',
    component: () => import('./views/Refunds/Create.vue'),
  },
  {
    path: '/refunds/invoices/:id',
    name: 'Refunds-Invoices-Create',
    component: () => import('./views/Refunds/Create.vue'),
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

router.beforeEach(async (to, from, next) => {
  const publicPages = ['/login']
  const authRequired = !publicPages.includes(to.path)
  const auth = useAuthStore()
  if (authRequired && !auth.user) {
    auth.returnUrl = to.fullPath
    next('/login');
  } else if(!authRequired && auth.user){
    next('/');
  } else {
    next();
  }
});

export default router
