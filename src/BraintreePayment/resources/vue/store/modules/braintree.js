const actions = {
    [FETCH_BRAINTREE_CLIENT_TOKEN]: ({
        commit,
        dispatch
    }, user) => {
        return new Promise((resolve, reject) => {
            dispatch('SHOW_SPINNER', "Loading...");
            axios.put('/api/v1/braintree/token').then(response => {
                if (response && response.success) {
                    dispatch(HIDE_SPINNER);
                } else {
                    reject(response);
                    dispatch(SNACK_MESSAGE, "Set guest details failed");
                }
            }, error => {
                dispatch(HIDE_SPINNER);
                reject(error);
                dispatch(SNACK_MESSAGE, "Set guest details failed");
            });
        });
    },

    [QUOTE_ASSIGN_SHIPPING_ADDRESS_REQUEST]: ({
        commit,
        dispatch
    }, address) => {
        var url = `/api/v1/cart/shipping_address`;
        return new Promise((resolve, reject) => {
            dispatch(SHOW_SPINNER, "Update Shipping Address...");
            axios.put(url, address).then(response => {
                dispatch(HIDE_SPINNER);
                dispatch(QUOTE_SUCCESS, response.data);
                resolve(response);
            }, error => {
                dispatch(HIDE_SPINNER);
                reject(error);
            });
        });
    },

    [PLACE_ORDER_REQUEST]: ({
        commit,
        dispatch
    }, pay_id) => {
        return new Promise((resolve, reject) => {
            axios
                .post("/ajax/sales/orders", {
                    pay_id: pay_id
                })
                .then(response => {
                    if (response.success) {
                        dispatch("SNACK_MESSAGE", "Order placed");
                        resolve(response);
                    } else {
                        dispatch("SNACK_MESSAGE", response.message);
                        reject(response);
                    }
                });
        }, error => {
            dispatch(HIDE_SPINNER);
            dispatch(SNACK_MESSAGE, "Set guest details failed");
            reject(error);
        });
    }
};

export default {
    actions
};
