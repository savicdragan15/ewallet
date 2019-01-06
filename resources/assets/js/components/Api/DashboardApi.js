export default {
    /**
     *
     * @param apiUrl
     * @param userId
     * @returns {*}
     */
    getNumberOfOrdersCurrentMonth(apiUrl, userId) {
        return  axios
            .get(apiUrl + "/dashboard/getNumberOfOrdersCurrentMonth", {
                headers: {
                    user: userId,
                    Authorization: 'Bearer '+localStorage.getItem('jwt-token')
                }
            })
    },
    getSpentMoney(apiUrl, userId) {
        return  axios
            .get(apiUrl + "/dashboard/getSpentMoney", {
                headers: {
                    user: userId,
                    Authorization: 'Bearer '+localStorage.getItem('jwt-token')
                }
            })
    },
    /**
     *
     * @param apiUrl
     * @param userId
     * @returns {*}
     */
    getSpentMoneyCurrentMonth(apiUrl, userId) {
        return  axios
                .get(apiUrl + "/dashboard/getSpentMoneyCurrentMonth", {
                    headers: {
                        user: userId,
                        Authorization: 'Bearer '+localStorage.getItem('jwt-token')
                    }
                })
    },
    /**
     *
     * @param apiUrl
     * @param userId
     * @returns {*}
     */
    getNumberOfOrders(apiUrl, userId) {
        return  axios
            .get(apiUrl + "/dashboard/getNumberOfOrders", {
                headers: {
                    user: userId,
                    Authorization: 'Bearer '+localStorage.getItem('jwt-token')
                }
            })
    },

    /**
     *
     * @param apiUrl
     * @param userId
     * @returns {*}
     */
    getLatestOrders (apiUrl, userId) {
      return  axios
            .get(apiUrl + "/dashboard/getLatestOrders", {
                headers: {
                    user: userId,
                    Authorization: 'Bearer '+localStorage.getItem('jwt-token')
                }
            })
    }
}
