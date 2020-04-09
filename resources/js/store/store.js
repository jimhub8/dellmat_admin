import actions from './actions';
import getters from './getters';
import mutations from './mutations';

export default {
    state: {
        loading: false,
        errors: [],
        users: [],
        deletedUsers: [],
        roles: [],
        permissions: [],
        products: [],
        order_address: [],
        customers: [],
        sellers: [],
        discount: [],
        sales: [],
        withdrawal: [],
        groups: [],
        drawers: [],
        discounts: [],
        clients: [],
        suppliers: [],
        categories: [],
        status: [],
        menu: [],
        subcategories: [],
        brands: [],
        unique_sku: null,
        option_values: [],
        currency: [],
        // Deleted
        deleted_clients: [],

        // Dashboard
        user_count: null,
        week_sales_count: null,
        sellers_count: null,
        total_sales_count: null,
        clients_count: null,

        product_count: null,
        category_count: null,
        brand_count: null,

        // Charts
        clients_chart: null,
        sellers_chart: null,
        sales_chart: [],

        // Api
        options: [],
        slider_1: [],
        slider: [],
        cart: [],

        week_total_sales_income: null,
        week_sold_items: null,
        week_orders: null,


    },
    getters,
    mutations,
    actions
}
