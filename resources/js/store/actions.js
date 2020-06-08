import axios from "axios";
export default {
    alertEvent(context, payload) {
        eventBus.$emit('alertRequest', payload)
        // context.commit('alertEvent', payload)
    },

    errorEvent(context, payload) {
        eventBus.$emit('errorEvent', payload)
        // context.commit('alertEvent', payload)
    },

    // Get items
    getItems(context, payload) {
        // console.log(payload);

        var model = payload.model
        var update_ = payload.update_list
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.get(model).then((response) => {
                context.commit('loading', false)
                context.commit(update_, response.data)
                resolve(response)
            }).catch((error) => {
                reject(error);
                context.commit('loading', false)
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    context.commit('errors', error.response.data.errors)
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        })
    },


    // Get Single items
    showItem(context, payload) {
        // console.log(payload);

        var model = payload.model
        var update = payload.update
        var id = payload.id
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.get(model + '/' + id).then((response) => {
                context.commit(update, response.data)
                context.commit('loading', false)
                resolve(response)
            }).catch((error) => {
                reject(error);
                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        })
    },


    nextPage(context, payload) {

        var path = payload.path
        var page = payload.page
        var update_ = payload.update_list
        console.log(update_);
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.get(path + `?page=` + page)
                .then((response) => {
                    console.log(response.data);
                    context.commit('loading', false)
                    context.commit(update_, response.data)
                    resolve(response)
                }).catch((error) => {
                    console.log(error);
                    reject(error);

                    context.commit('loading', false)
                    if (error.response.status === 500) {
                        eventBus.$emit('errorEvent', error.response.statusText)
                        return
                    } else if (error.response.status === 401 || error.response.status === 409) {
                        eventBus.$emit('reloadRequest', error.response.statusText)
                    } else if (error.response.status === 422) {
                        eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                        context.commit('errors', error.response.data.errors)

                    } else {
                        context.commit('errors', error.response.data.errors)
                    }
                })
        });
    },




    // Delete
    deleteItem(context, payload) {
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.delete(payload).then((response) => {
                context.commit('loading', false)
                resolve(response)
            }).catch((error) => {
                reject(error);
                context.commit('loading', false)
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        });
    },



    addCart(state, payload) {
        console.log(state.cart);

        var exists = state.cart.some(function (product_1) {
            return product_1.id === payload.id
        });
        if (!exists) {
            payload.ordered = 1
            state.cart.push(payload)
        } else {
            var index = state.cart.indexOf(payload);
            var add_item = (Object.assign({}, payload));
            add_item.ordered += 1
            // console.log(add_item);
            Object.assign(state.cart[index], add_item)
        }
        return state.cart
        context.commit('updateCartList', state.cart)
    },

    // Post Items
    postItems(context, payload) {
        // console.log(payload);
        context.commit('errors', [])

        var model = payload.model
        var data = payload.data

        // console.log(data);

        // var data = payload['data']
        // console.log(data);
        // var update_ = payload['update_list']
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.post(model, data).then((response) => {
                context.commit('loading', false)
                eventBus.$emit('alertRequest', 'Created')
                // console.log(response.data);
                // context.commit(update_, response.data)
                resolve(response)
            }).catch((error) => {
                // console.log(error.response.data.errors);
                reject(error);

                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    var errors_ = error.response.data.errors
                    context.commit('errors', errors_)
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        });
    },


    // Post Items
    filterItems(context, payload) {
        // console.log(payload);
        context.commit('errors', [])

        var model = payload.model
        var update = payload.update
        var data = payload.data

        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.post(model, data).then((response) => {
                context.commit('loading', false)
                context.commit(update, response.data)
                // eventBus.$emit('alertRequest', 'Created')
                // console.log(response.data);
                resolve(response)
            }).catch((error) => {
                // console.log(error.response.data.errors);
                reject(error);

                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    var errors_ = error.response.data.errors
                    context.commit('errors', errors_)
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        });
    },

    // Post Items
    postItem(context, payload) {
        // console.log(payload);
        context.commit('errors', [])

        var model = payload.model
        var data = payload.data
        var id = payload.id

        // console.log(data);

        // var data = payload['data']
        // console.log(data);
        // var update_ = payload['update_list']
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.post(model + '/' + id, data).then((response) => {
                context.commit('loading', false)
                eventBus.$emit('alertRequest', 'Created')
                // console.log(response.data);
                // context.commit(update_, response.data)
                resolve(response)
            }).catch((error) => {
                // console.log(error.response.data.errors);
                reject(error);

                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    var errors_ = error.response.data.errors
                    context.commit('errors', errors_)
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        });
    },


    // Patch Items
    patchItems(context, payload) {
        console.log(payload);

        var model = payload.model
        var data = payload.data
        var id = payload.id
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.patch(model + '/' + id, data).then((response) => {
                eventBus.$emit('alertRequest', 'Updated')
                context.commit('loading', false)
                resolve(response)
            }).catch((error) => {
                reject(error);
                context.commit('loading', false)
                if (error.response.status === 500 || error.response.status === 405) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)

                }
                context.commit('errors', error.response.data.errors)
            })
        });

    },


    searchItems(context, payload) {
        // console.log(payload);

        var model = payload.model
        var update_ = payload.update_
        var search = payload.search
        context.commit('loading', true)
        return new Promise((resolve, reject) => {
            axios.get(model + '/' + search).then((response) => {
                context.commit('loading', false)

                context.commit(update_, response.data)
                resolve(response)
            }).catch((error) => {
                console.log(error);
                reject(error);

                context.commit('loading', false)
                if (error.response.status === 500) {
                    eventBus.$emit('errorEvent', error.response.statusText)
                    return
                } else if (error.response.status === 401 || error.response.status === 409) {
                    eventBus.$emit('reloadRequest', error.response.statusText)
                } else if (error.response.status === 422) {
                    eventBus.$emit('errorEvent', error.response.data.message + ': ' + error.response.statusText)
                    context.commit('errors', error.response.data.errors)
                    return
                }
                context.commit('errors', error.response.data.errors)
            })
        });
    },



}
