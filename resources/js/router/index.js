import Vue from 'vue'
import VueRouter from 'vue-router'
import AdminPanel from '../components/AdminPanel.vue'
import Index from '../views/invoices/index.vue'
import Form from '../views/invoices/form.vue'
import Show from '../views/invoices/show.vue'
import CustomerIndex from '../views/customers/CustomerIndex.vue'
import CustomerCreate from '../views/customers/CustomerCreate.vue'
import CustomerShow from '../views/customers/CustomerShow.vue'
import CustomerEdit from '../views/customers/CustomerEdit.vue'
import UserIndex from '../views/users/UserIndex.vue'
import UserCreate from '../views/users/UserCreate.vue'
import UserShow from '../views/users/UserShow.vue'
import UserEdit from '../views/users/UserEdit.vue'
import EmployeeIndex from '../views/employees/EmployeeIndex.vue'
import EmployeeCreate from '../views/employees/EmployeeCreate.vue'
import EmployeeShow from '../views/employees/EmployeeShow.vue'
import EmployeeEdit from '../views/employees/EmployeeEdit.vue'
import VendorIndex from '../views/vendors/VendorIndex.vue'
import VendorShow from '../views/vendors/VendorShow.vue'
import VendorCreate from '../views/vendors/VendorCreate.vue'
import VendorEdit from '../views/vendors/VendorEdit.vue'
import ProductIndex from '../views/products/ProductIndex.vue'
import ProductCreate from '../views/products/ProductCreate.vue'
import ProductShow from '../views/products/ProductShow.vue'
import ProductEdit from '../views/products/ProductEdit.vue'
import ItemIndex from '../views/items/ItemIndex.vue'
import ItemCreate from '../views/items/ItemCreate.vue'
import ItemShow from '../views/items/ItemShow.vue'
import ItemEdit from '../views/items/ItemEdit.vue'
import SettingIndex from '../views/settings/SettingIndex.vue'
import SettingCreate from '../views/settings/SettingCreate.vue'
import SettingShow from '../views/settings/SettingShow.vue'
import SettingEdit from '../views/settings/SettingEdit.vue'
import ExpenseIndex from '../views/expenses/index.vue'
import ExpenseForm from '../views/expenses/form.vue'
import ExpenseShow from '../views/expenses/show.vue'
import Home from '../views/Home.vue'
import ErrorRoute from '../components/404/NotFound.vue'
import Login from '../components/auth/Login.vue'
import Register from '../components/auth/Register.vue'

Vue.use(VueRouter)

const router = new VueRouter({
    mode: 'history', //removes # (hashtag) from url
    routes: [
        {
            path: '/', 
            redirect: '/login'
        },
        {
            path: '/login', 
            name: Login,
            component: Login
        },
        {
            path: '/register', 
            name: 'register',
            component: Register
        },
        {
            path: '/',
            name: 'admin',
            component: AdminPanel,
            children: [
                {
                    path: '/dashboard', 
                    name: 'dashboard',
                    component: Home
                },
                {
                    path: '/invoices', 
                    name: 'invoices',
                    component: Index
                },
                {
                    path: '/invoices/create', 
                    name: 'invoices-create',
                    component: Form
                },
                {
                    path: '/invoices/:id/edit', 
                    component: Form, 
                    name: 'invoices-edit',
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: '/invoices/:id',
                    name: 'invoices-show',
                    component: Show
                },
                {
                    path: '/customers',
                    name: 'customers',
                    component: CustomerIndex
                },
                {
                    path: '/customers/create',
                    name: 'customers-create',
                    component: CustomerCreate
                },
                {
                    path: '/customers/:id',
                    name:'customers-show',
                    component: CustomerShow
                },
                {
                    path: '/customers/:id/edit',
                    component: CustomerEdit,
                    name: 'customers-edit',
                    meta: {
                        mode:'edit'
                    }
                },
                {
                    path: '/users',
                    name: 'users',
                    component: UserIndex
                },
                {
                    path: '/users/create',
                    name: 'users-create',
                    component: UserCreate
                },
                {
                    path: '/users/:id',
                    name:'users-show',
                    component: UserShow
                },
                {
                    path: '/users/:id/edit',
                    component: UserEdit,
                    name: 'users-edit',
                    meta: {
                        mode:'edit'
                    }
                },
                {
                    path: '/vendors',
                    name: 'vendors',
                    component: VendorIndex
                },
                {
                    path: '/vendors/create',
                    name: 'vendors-create',
                    component: VendorCreate
                },
                {
                    path: '/vendors/:id',
                    name:'vendors-show',
                    component: VendorShow
                },
                {
                    path: '/vendors/:id/edit',
                    component: VendorEdit,
                    name: 'vendors-edit',
                    meta: {
                        mode:'edit'
                    }
                },
                {
                    path: '/products',
                    name: 'products',
                    component: ProductIndex
                },
                {
                    path: '/products/create',
                    name: 'products-create',
                    component: ProductCreate
                },
                {
                    path: '/products/:id',
                    name: 'products-show',
                    component: ProductShow
                },
                {
                    path: '/products/:id/edit',
                    name: 'products-edit',
                    component: ProductEdit,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: '/items',
                    name: 'items',
                    component: ItemIndex
                },
                {
                    path: '/items/create',
                    name: 'items-create',
                    component: ItemCreate
                },
                {
                    path: '/items/:id',
                    name: 'items-show',
                    component: ItemShow
                },
                {
                    path: '/items/:id/edit',
                    name: 'items-edit',
                    component: ItemEdit,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: '/expenses',
                    name: 'expenses',
                    component: ExpenseIndex
                },
                {
                    path: '/expenses/create',
                    name: 'expenses-create',
                    component: ExpenseForm
                },
                {
                    path: '/expenses/:id',
                    name: 'expenses-show',
                    component: ExpenseShow
                },
                {
                    path: '/expenses/:id/edit',
                    name: 'expenses-edit',
                    component: ExpenseForm,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: '/settings',
                    name: 'settings',
                    component: SettingIndex
                },
                {
                    path: '/settings/create',
                    name: 'settings-create',
                    component: SettingCreate
                },
                {
                    path: '/settings/:id',
                    name: 'settings-show',
                    component: SettingShow
                },
                {
                    path: '/settings/:id/edit',
                    name: 'settings-edit',
                    component: SettingEdit,
                    meta: {
                        mode: 'edit'
                    }
                },
                {
                    path: '/employees',
                    name: 'employees',
                    component: EmployeeIndex
                },
                {
                    path: '/employees/create',
                    name: 'employees-create',
                    component: EmployeeCreate
                },
                {
                    path: '/employees/:id',
                    name:'employees-show',
                    component: EmployeeShow
                },
                {
                    path: '/employees/:id/edit',
                    component: EmployeeEdit,
                    name: 'employees-edit',
                    meta: {
                        mode:'edit'
                    }
                },
            ]
        },
        {
            path: '*', 
            name: 'error',
            component: ErrorRoute
        },
    ]
})

export default router


router.beforeEach((to, from, next) => {
    const publicPages = ['/login', '/register'];
    const authRequired = !publicPages.includes(to.path);
    const loggedIn = localStorage.getItem('token');
    // trying to access a restricted page + not logged in
    // redirect to login page
    if (authRequired && !loggedIn) {
        console.log('reached')
        next('/login');
    } else {
        next();
    }
});