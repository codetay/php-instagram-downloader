<!DOCTYPE html>
<html lang="en" class="bg-white antialiased">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Insta Download</title>
    <link rel="stylesheet" href="style.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/vue@2.6.11"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body class="text-gray-900 leading-normal">

<div id="app" class="container mx-auto mt-20">
    <form class="max-w-lg mx-auto w-full px-5">
        <div class="flex items-center border-b border-b-2 border-teal-500 py-2">
            <input v-model="link" class="appearance-none bg-transparent border-none w-full text-gray-700 mr-3 py-1 px-2 leading-tight focus:outline-none" type="text" placeholder="Insta Link" aria-label="Full name">
            <button class="flex-shrink-0 bg-teal-500 hover:bg-teal-700 border-teal-500 hover:border-teal-700 text-sm border-4 text-white py-1 px-2 rounded" :class="{'cursor-not-allowed': !link}" type="button" @click="getLink" :disabled="!link">
                Tìm link
            </button>
        </div>
    </form>

    <div v-if="loading" class="bg-blue-200 flex justify-center max-w-lg mt-6 mx-auto p-2 rounded w-full">
        Đang tìm link tải...
    </div>


    <div v-if="!success && !loading && !download" class="bg-orange-200 flex justify-center max-w-lg mt-6 mx-auto p-2 rounded w-full">
        Không tìm thấy link tải video/hình !
    </div>

    <div v-if="success && !loading && download" class="flex justify-center max-w-lg mt-6 mx-auto w-full">
        <a class="bg-red-600 font-bold p-3 rounded text-white" :href="'download.php?download='+download">Download !</a>
    </div>

</div>

<script>
    new Vue({
        el: '#app',
        data: {
            link: '',
            download: '',
            loading: false,
            success: true,
        },
        methods: {
            getLink() {
                this.loading = true;

                axios.post('actions.php', {
                    link: this.link
                }).then(({data}) => {
                    if (data.success) {
                        this.download= data.download;
                        this.success = data.success
                    } else {
                        this.success = false;
                    }
                }).finally(() => {
                    this.loading = false;
                })

            }
        }
    })
</script>

</body>
</html>










