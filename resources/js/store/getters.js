export default {
    loading(state) {
        return state.loading;
    },
    errors(state) {
        return state.errors;
    },
    alertEvent(state) {
        eventBus.$emit('alertEvent', state)
        // return state.alertEvent;
    },
    users(state) {
        return state.users
    },
    deletedUsers(state) {
        return state.deletedUsers
    },
    roles(state) {
        return _.orderBy(state.roles, 'name', 'asc')
    },
    permissions(state) {
        return state.permissions;
    },
    order_address(state) {
        return state.order_address;
    },
    products(state) {
        return state.products
    },
    clients(state) {
        return state.clients
    },
    sellers(state) {
        return state.sellers
    },
    suppliers(state) {
        return state.suppliers
    },
    customers(state) {
        return state.customers
    },
    discount(state) {
        return state.discount
    },
    sales(state) {
        return state.sales
    },
    groups(state) {
        return state.groups
    },
    drawers(state) {
        return state.drawers
    },

    discounts(state) {
        return state.discounts
    },
    // Unique
    unique_sku(state) {
        return state.unique_sku;
    },
    categories(state) {
        return state.categories;
    },
    menu(state) {
        return state.menu;
    },
    subcategories(state) {
        return state.subcategories;
    },
    brands(state) {
        return state.brands;
    },
    currency(state) {
        return state.currency;
    },
    options(state) {
        return state.options;
    },
    option_values(state) {
        return state.option_values;
    },
    slider(state) {
        return state.slider;
    },
    slider_1(state) {
        return state.slider_1;
    },
    withdrawal(state) {
        return state.withdrawal;
    },


    status(state) {
        return state.status;
    },


    // Dashboard
    user_count(state) {
        return state.user_count
    },
    week_sales_count(state) {
        return state.week_sales_count
    },
    sellers_count(state) {
        return state.sellers_count
    },
    total_sales_count(state) {
        return state.total_sales_count
    },
    clients_count(state) {
        return state.clients_count
    },
    product_count(state) {
        return state.product_count;
    },
    category_count(state) {
        return state.category_count;
    },
    brand_count(state) {
        return state.brand_count;
    },

    // Charts
    sales_chart(state) {
        return state.sales_chart
    },
    clients_chart(state) {
        return state.clients_chart
    },
    sellers_chart(state) {
        return state.sellers_chart
    },


    // Seller Dashboard

    week_total_sales_income(state) {
        return state.week_total_sales_income
    },
    week_sold_items(state) {
        return state.week_sold_items
    },
    week_orders(state) {
        return state.week_orders
    },
}

