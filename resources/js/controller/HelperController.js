export default {
    validEmail(email) {
        var re = /^(([^<>()\[\]\\.,;:\s@"]+(\.[^<>()\[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
        // noinspection JSAnnotator
        return re.test(email);
    },
    convertSlashToDash(toBeConverted){
        return toBeConverted.split('/').join('-')
    },
    convertDashToSlash(toBeConverted){
        return toBeConverted.split('-').join('/')
    },
    convertStringSpaceless(toBeConverted){
        return toBeConverted.split('-').join('')
    },
    async sendPOSTRequest(request,objects){
        let self=this;
        var resp;
        await axios({
            method: 'post',
            url: request,
            params: objects
        }).then(function (response) {
            // handle success
            console.log("then"+response);
            resp =  response;

        }).catch(function (response) {
            // handle error
            console.log("catch "+response);
        }).finally(function () {
            // always executed
        });
        return resp;
    },

    async sendGetRequest(request){
        var ReturnResponse;
        await axios.get(request)
            .then((response) => {
                // console.log(response.data);
                // console.log(response.status);
                // console.log(response.statusText);
                // console.log(response.headers);
                // console.log(response.config);
                ReturnResponse =  response;
            }).catch(function (response) {
                // handle error
                console.log("catch "+response);
                // Vue.$toast.error(response);
                // resp= response.data;
            }).finally(function () {
                // always executed
            });;
            return ReturnResponse;
    },


}