<template>
    <div>

        <table class="table">

            <thead class="thead-dark">

            <tr>

                <th scope="col">#</th>
                <th scope="col">Ip</th>
                <th scope="col">PTR record</th>
                <th scope="col">Status</th>
                <th scope="col">Response time</th>
                <th scope="col">Date checked</th>
                <th scope="col">Comment</th>

            </tr>

            </thead>

            <tbody>

            <tr v-for="(ip, i) in this.ips">

                <th scope="row">
                    {{ i + 1 }}
                </th>
                <td><b>{{ ip.ip }}</b></td>
                <td><b>{{ ip.a_record }}</b></td>
                <td :id="`status_column_${i}`"><b>{{ ip.status }}</b></td>

                <td v-if="ip.status=='created'" :id="`response_column_${i}`" class="text-danger">
                    <div class="spinner-border text-dark" role="status">
                        <span class="sr-only">Loading...</span>
                    </div>
                    {{ checkIp(i) }}
                </td>

                <td v-else class="text-danger">
                    <b>{{ ip.response_time }} ms</b>
                </td>

                <td :id="`checked_at_column_${i}`"><b>{{ ip.checked_at }}</b></td>

                <td>
                    <textarea class="form-control" :id="`comment_${i}`" @keydown="updateComment(`comment_${i}`, `${ip.id}`)" @keyup="updateComment(`comment_${i}`, `${ip.id}`)" >{{ ip.comment }}</textarea>
                </td>

            </tr>

            </tbody>

        </table>
    </div>
</template>

<script>
export default {
    name: "IpsComponent",
    props: {
        ips: {
            type: Object,
            required: true
        }
    },
    methods: {

        checkIp: function (index) {

            let id = this.ips[index].subnet_ip_address;
            let ip_address = this.ips[index].ip;

            axios.get('/check_ip/' + ip_address + '/' + id)
                .then((response) => {

                    console.log(response.data);
                    document.getElementById(`response_column_${index}`).innerHTML = `<b>${response.data[0]} ms </b>`;
                    document.getElementById(`status_column_${index}`).innerHTML = `<b>${response.data[1]} </b>`;
                    document.getElementById(`checked_at_column_${index}`).innerHTML = `<b>${response.data[2]}</b>`;

                })
                .catch(err => {
                    return "-";
                });

        },

        updateComment: function (id, id_ip) {
            let value = document.getElementById(id).value;
            axios.post('/subnet/updatecomment', {id_ip, value})
                 .then((response) => {
                     console.log(response.data);
                 })
                 .catch((err) => {

                 });
        }

    }
}
</script>

<style scoped>

</style>
