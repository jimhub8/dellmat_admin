import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

// import myUser from './components/users/'

import dashboard from './components/dashboard'

import myUsers from './components/users'
import MyRoles from './components/users/roles/Roles'
import myProducts from './components/product'
// import myPos from './components/pos'
import myClients from './components/clients'
import myGroup from './components/group'
// import myDrawer from './components/drawer'
// import myDiscount from './components/discount'
import mySales from './components/sales'
import EditProduct from './components/product/edit'
import myMenu from './components/menu'
import myCategory from './components/menu/category'
import myBrand from './components/brand'
import mySubcategory from './components/menu/category/subcategory'
import mySellers from './components/sellers'
import myWithdrawal from './components/withdraw'

// Settings
import myCurrency from './components/settings/currency'
import productOptions from './components/settings/products'
import mySlider from './components/settings/slider'
import myStatus from './components/settings/status'



const routes = [
    { path: '/', component: dashboard },
    { path: '/users', component: myUsers },
    { path: '/roles', component: MyRoles },
    { path: '/products', component: myProducts, name: 'products' },
    // { path: '/pos', component: myPos },
    { path: '/clients', component: myClients },
    { path: '/groups', component: myGroup },
    { path: '/sales', component: mySales },
    // { path: '/drawer', component: myDrawer },
    { path: '/vendors', component: mySellers },
    // { path: '/discount', component: myDiscount },
    { path: '/product/:id', component: EditProduct, name: 'editProduct' },

    { path: '/menu', component: myMenu },
    { path: '/category', component: myCategory },
    { path: '/brand', component: myBrand },
    { path: '/subcategory', component: mySubcategory },
    { path: '/withdraw', component: myWithdrawal },


    { path: '/status', component: myStatus },
    { path: '/currency', component: myCurrency },
    { path: '/product_option', component: productOptions },
    { path: '/slider', component: mySlider },
]


export default new VueRouter({routes})
