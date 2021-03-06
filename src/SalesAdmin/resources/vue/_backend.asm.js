import SalesOrdersPage from "./pages/sales_orders/RoutePage";

export default {
    components: {
        "z-orders-customer-column": "components/columns/Customer.vue",
        "z-orders-payment-column": "components/columns/Payment.vue",
        "z-orders-number-and-log-column": "components/columns/OrderNumberAndLog.vue",
        "z-orders-status-action-column": "components/columns/StatusAction.vue",
        "z-orders-shipment-details": "components/columns/ShipmentDetails.vue",
        "z-orders-details-column": "components/columns/OrderDetail.vue",
        "z-admin-comment-dialog-body": "components/dialogbody/AdminComment.vue",
    },
    routes: [{
        name: "sales.orders",
        path: "/admin/sales_orders",
        component: SalesOrdersPage
    }]
}
